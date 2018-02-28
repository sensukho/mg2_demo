<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2/27/18
 * Time: 16:12
 */

namespace Unit4\Retailer\Model\ResourceModel\Retailer;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Unit4\Retailer\Model\Retailer::class,
            \Unit4\Retailer\Model\ResourceModel\Retailer::class);
    }

    public function addFilterByProduct($productId)
    {
        $this->getSelect()
            ->join(
                ['r2p' => $this->getTable('unit4_retailer2product')],
                "main_table.retailer_id = r2p.retailer_id AND r2p.product_id = $productId"
            );
        return $this;
    }
}
