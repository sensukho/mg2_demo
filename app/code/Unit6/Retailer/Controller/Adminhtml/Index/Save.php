<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Unit6\Retailer\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\LocalizedException;


class Save extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Magento_Cms::save';


    /**
     * @param Action\Context $context

     */
    public function __construct(
        Action\Context $context,
        \Unit5\RetailerApi\Api\RetailerRepositoryInterface $repository,
        \Unit5\RetailerApi\Api\Data\RetailerInterfaceFactory $dataFactory
    ) {
        parent::__construct($context);
        $this->repository  = $repository;
        $this->dataFactory = $dataFactory;
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            $id = $this->getRequest()->getParam('retailer_id');
            $dataModel = $this->dataFactory->create();

            if ($id) {
                $dataModel->setId($id);
            }
            $dataModel->setName($data['name'])
              ->setCountryId($data['country_id'])
              ->setRegionId($data['region_id'])
              ->setCity($data['city'])
              ->setStreet($data['street'])
              ->setPostcode($data['postcode']);

            try {
                $dataModel = $this->repository->save($dataModel);
                $this->messageManager->addSuccess(__('You saved the retailer.'));

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['retailer_id' => $dataModel->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the retailer.'));
            }

            return $resultRedirect->setPath('*/*/edit', ['retailer_id' => $this->getRequest()->getParam('retailer_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
