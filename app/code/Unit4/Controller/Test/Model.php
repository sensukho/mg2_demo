<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2/27/18
 * Time: 16:25
 */

namespace Unit4\Retailer\Controller\Test;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Unit4\Retailer\Model\RetailerFactory;

class Model extends Action
{
    /**
     * @var RetailerFactory
     */
    private $retailerFactory;

    /**
     * Model constructor.
     * @param Context $context
     * @param RetailerFactory $retailerFactory
     */
    public function __construct(
        Context $context,
        RetailerFactory $retailerFactory
    )
    {
        parent::__construct($context);
        $this->retailerFactory = $retailerFactory;
    }


    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $retailer = $this->retailerFactory->create();
        $retailer->load(1);
        \Zend_Debug::dump($retailer->getData());
        \Zend_Debug::dump($retailer->getData('region_id'));
        \Zend_Debug::dump($retailer->getRegionId());
        \Zend_Debug::dump($retailer->getRegionCode());
        \Zend_Debug::dump($retailer->getAssociatedProducts());
    }
}