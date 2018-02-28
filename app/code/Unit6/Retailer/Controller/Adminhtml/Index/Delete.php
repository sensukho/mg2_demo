<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Unit6\Retailer\Controller\Adminhtml\Index;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Unit6_Retailer::retailer';

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Unit5\RetailerApi\Api\RetailerRepositoryInterface $retailerRepository
    ) {
        $this->repository = $retailerRepository;
        parent::__construct($context);
    }


    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {

        $id = $this->getRequest()->getParam('retailer_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            $title = "";
            try {
                $this->repository->deleteById($id);
                $this->messageManager->addSuccess(__('The retailer has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['retailer_id' => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a retailer to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
