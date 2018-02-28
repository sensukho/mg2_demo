<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2/27/18
 * Time: 16:12
 */

namespace Unit4\Retailer\Model;


use Magento\Framework\Model\AbstractModel;

class Retailer extends AbstractModel
{
    protected $region = null;
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Unit4\Retailer\Model\ResourceModel\Retailer::class);
    }

    public function getRegionCode()
    {
        if (!$this->region) {
            $this->region = $this->_getResource()
                ->getRegionCode($this->getRegionId());
        }
        return $this->region;
    }

    public function getAssociatedProducts() {
        return $this->_getResource()
            ->getAssociatedProducts($this->getId());
    }
}
