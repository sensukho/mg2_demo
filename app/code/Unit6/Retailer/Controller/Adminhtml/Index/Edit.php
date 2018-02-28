<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Unit6\Retailer\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Unit6_Retailer::retailer';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Unit5\RetailerApi\Api\RetailerRepositoryInterface
     */
    protected $retailerRepository;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Unit5\RetailerApi\Api\RetailerRepositoryInterface
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        \Unit5\RetailerApi\Api\RetailerRepositoryInterface $retailerRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $registry;
        $this->retailerRepository = $retailerRepository;
        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Unit6_Retailer::retailer')
            ->addBreadcrumb(__('Retailer'), __('Retailer'))
            ->addBreadcrumb(__('Manage Retailer'), __('Manage Retailer'));
        return $resultPage;
    }

    /**
     * Edit Retailer
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('retailer_id');
        $data = null;
        if ($id) {
            $data = $this->retailerRepository->getById($id);

            if (!$data->getId()) {
                $this->messageManager->addError(__('This retailer no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->coreRegistry->register('retailer', $data);

        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Retailer') : __('New Retailer'),
            $id ? __('Edit Retailer') : __('New Retailer')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Retailers'));
        $resultPage->getConfig()->getTitle()
            ->prepend($data && $data->getId() ? $data->getName() : __('New Retailer'));

        return $resultPage;
    }
}
