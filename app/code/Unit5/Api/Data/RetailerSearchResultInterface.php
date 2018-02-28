<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2/28/18
 * Time: 10:14
 */

namespace Unit5\RetailerApi\Api\Data;


interface RetailerSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get retailers.
     *
     * @return \Unit5\RetailerApi\Api\Data\RetailerInterface[]
     */
    public function getItems();

    /**
     * Set retailers .
     *
     * @param \Unit5\RetailerApi\Api\Data\RetailerInterface[] $items
     * @return $this
     */
    public function setItems(array $items = null);
}
