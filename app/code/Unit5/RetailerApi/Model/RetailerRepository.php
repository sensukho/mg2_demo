<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2/28/18
 * Time: 10:39
 */

namespace Unit5\RetailerApi\Model;


use Magento\Framework\Exception\NoSuchEntityException;
use Unit4\Retailer\Model\RetailerFactory;
use Unit5\RetailerApi\Api\RetailerRepositoryInterface;
use Unit5\RetailerApi\Model\Data\RetailerFactory as RetailerDataFactory;
use Magento\Framework\Api\DataObjectHelper;
use Unit5\RetailerApi\Api\Data\RetailerSearchResultInterfaceFactory;
use Magento\Framework\Reflection\DataObjectProcessor;

class RetailerRepository implements RetailerRepositoryInterface
{
    /**
     * @var RetailerFactory
     */
    private $retailerFactory;
    /**
     * @var RetailerDataFactory
     */
    private $retailerDataFactory;
    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;
    /**
     * @var RetailerSearchResultInterfaceFactory
     */
    private $retailerSearchResultFactory;
    /**
     * @var DataObjectProcessor
     */
    private $dataObjectProcessor;

    /**
     * RetailerRepository constructor.
     * @param RetailerFactory $retailerFactory
     * @param RetailerDataFactory $retailerDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param RetailerSearchResultInterfaceFactory $retailerSearchResultFactory
     * @param DataObjectProcessor $dataObjectProcessor
     */
    public function __construct(
        RetailerFactory $retailerFactory,
        RetailerDataFactory $retailerDataFactory,
        DataObjectHelper $dataObjectHelper,
        RetailerSearchResultInterfaceFactory $retailerSearchResultFactory,
        DataObjectProcessor $dataObjectProcessor
    )
    {

        $this->retailerFactory = $retailerFactory;
        $this->retailerDataFactory = $retailerDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->retailerSearchResultFactory = $retailerSearchResultFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
    }


    /**
     * Save retailer.
     *
     * @param \Unit5\RetailerApi\Api\Data\RetailerInterface $retailer
     * @return \Unit5\RetailerApi\Api\Data\RetailerInterface
     * @throws \Magento\Framework\Exception\InputException If there is a problem with the input
     * @throws \Magento\Framework\Exception\NoSuchEntityException If a rule ID is sent but the rule does not exist
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Unit5\RetailerApi\Api\Data\RetailerInterface $retailer)
    {
        /** @var \Unit4\Retailer\Model\Retailer $retailerModel */
        $retailerModel = $this->retailerFactory->create();
        if($retailer->getId()) {
            $retailerModel->load($retailer->getId());
        }
        $retailerModel->setName($retailer->getName())
            ->setCountryId($retailer->getCountryId())
            ->setRegionId($retailer->getRegionId())
            ->setCity($retailer->getCity())
            ->setStreet($retailer->getStreet())
            ->setPostcode($retailer->getPostcode())
            ->save();
        $retailer->setId($retailerModel->getId());
        return $retailer;
    }

    /**
     * Get retailer by ID.
     *
     * @param int $retailerId
     * @return \Unit5\RetailerApi\Api\Data\RetailerInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If $id is not found
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($retailerId)
    {
        /** @var \Unit4\Retailer\Model\Retailer $retailerModel */
        $retailerModel = $this->retailerFactory->create();
        $retailerModel->load($retailerId);
        if(!$retailerModel->getId()) {
            throw new NoSuchEntityException(__('Retailer with id "%1" does not exist', $retailerId));
        }

        $data = $this->retailerDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $data,
            $retailerModel->getData(),
            \Unit5\RetailerApi\Api\Data\RetailerInterface::class
        );

        $data->setId($retailerModel->getId());
        return $data;
    }

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
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $searchResult = $this->retailerSearchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);

        $collection = $this->retailerFactory->create()->getCollection();

        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }

        $searchResult->setTotalCount($collection->getSize());
        $sortOrders = $searchCriteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());

        $retailers = [];
        /** @var Retailer $retailerModel */
        foreach ($collection as $retailerModel) {
            $retailerData = $this->retailerDataFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $retailerData,
                $retailerModel->getData(),
                \Unit5\RetailerApi\Api\Data\RetailerInterface::class
            );
            $retailers[] = $this->dataObjectProcessor->buildOutputDataArray(
                $retailerData,
                \Unit5\RetailerApi\Api\Data\RetailerInterface::class
            );
        }
        $searchResult->setItems($retailers);
        return $searchResult;
    }

    /**
     * Delete retailer by ID.
     *
     * @param int $retailerId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($retailerId)
    {
        /** @var \Unit4\Retailer\Model\Retailer $retailerModel */
        $retailerModel = $this->retailerFactory->create();
        if($retailerModel->load($retailerId)->delete()) {
            return true;
        }
        return false;
    }
}