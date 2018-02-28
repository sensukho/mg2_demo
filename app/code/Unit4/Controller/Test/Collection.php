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
use Unit4\Retailer\Model\ResourceModel\Retailer\CollectionFactory;

class Collection extends Action
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * Collection constructor.
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory
    )
    {
        parent::__construct($context);
        $this->collectionFactory = $collectionFactory;
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
        /** @var \Unit4\Retailer\Model\ResourceModel\Retailer\Collection $collection */
        $collection = $this->collectionFactory->create();
//        $collection->addFieldToFilter('region_id',['eq'=>2]);
        $collection->addFilterByProduct(3);
        \Zend_Debug::dump($collection->getData());

    }
}