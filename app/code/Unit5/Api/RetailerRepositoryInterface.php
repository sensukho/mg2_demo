<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2/28/18
 * Time: 09:41
 */

namespace Unit5\RetailerApi\Api;

/**
 * Retailer CRUD interface
 *
 * @api
 * @since 100.0.2
 */
interface RetailerRepositoryInterface
{
    /**
     * Save retailer.
     *
     * @param \Unit5\RetailerApi\Api\Data\RetailerInterface $retailer
     * @return \Unit5\RetailerApi\Api\Data\RetailerInterface
     * @throws \Magento\Framework\Exception\InputException If there is a problem with the input
     * @throws \Magento\Framework\Exception\NoSuchEntityException If a rule ID is sent but the rule does not exist
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Unit5\RetailerApi\Api\Data\RetailerInterface $retailer);

    /**
     * Get retailer by ID.
     *
     * @param int $retailerId
     * @return \Unit5\RetailerApi\Api\Data\RetailerInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If $id is not found
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($retailerId);

    /**
     * Retrieve retailers that match te specified criteria.
     *
     * This call returns an array of objects, but detailed information about each object’s attributes might not be
     * included. See http://devdocs.magento.com/codelinks/attributes.html#RuleRepositoryInterface to
     * determine which call to use to get detailed information about all attributes for an object.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\SalesRule\Api\Data\RuleSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete retailer by ID.
     *
     * @param int $retailerId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($retailerId);
}
