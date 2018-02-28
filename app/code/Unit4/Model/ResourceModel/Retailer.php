<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2/27/18
 * Time: 16:12
 */

namespace Unit4\Retailer\Model\ResourceModel;


use Magento\Directory\Model\RegionFactory;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Retailer extends AbstractDb
{
    /**
     * @var RegionFactory
     */
    private $regionFactory;

    /**
     * Retailer constructor.
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param RegionFactory $regionFactory
     * @param null $connectionName
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        RegionFactory $regionFactory,
        $connectionName = null)
    {
        parent::__construct($context, $connectionName);
        $this->regionFactory = $regionFactory;
    }


    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('unit4_retailer', 'retailer_id');
    }

    public function getRegionCode($regionId)
    {
        /*
        $connection = $this->getConnection();
        $sql = $connection->select()
            ->from('directory_country_region', 'code')
            ->where('region_id = ?', $regionId);
        echo (string) $sql;
        $code = $connection->fetchOne($sql);
        */

        $region = $this->regionFactory->create();
        $region->load($regionId);
        $code = $region->getCode();

        return $code;
    }

    public function getAssociatedProducts($retailerId) {

        $connection = $this->getConnection();
        $sql = $connection->select()
            ->from('unit4_retailer2product', 'product_id')
            ->where('retailer_id = ? ', $retailerId);
        return $connection->fetchCol($sql);
    }
}