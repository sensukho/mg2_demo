<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Unit6\Retailer\Ui\Component\Form;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var array
     */
    protected $loadedData;

    protected $collection;
    
    protected $registry;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $pageCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Magento\Framework\Registry $registry,
        \Unit4\Retailer\Model\RetailerFactory $retailerFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->registry = $registry;
        $this->collection = $retailerFactory->create()->getCollection();
        $this->meta = $this->prepareMeta($this->meta);
    }

    /**
     * Prepares Meta
     *
     * @param array $meta
     * @return array
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $this->loadedData = [];

        if ($retailer = $this->registry->registry('retailer')) {
            $this->loadedData[$retailer->getId()] = [
                'retailer_id' => $retailer->getId(),
                'name'        => $retailer->getName(),
                'country_id'  => $retailer->getCountryId(),
                'region_id'   => $retailer->getRegionId(),
                'city'        => $retailer->getCity(),
                'street'      => $retailer->getStreet(),
                'postcode'    => $retailer->getPostcode()
            ];
        }
        return $this->loadedData;
    }
}
