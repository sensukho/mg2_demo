<?php

namespace Unit5\RetailerApi\Controller\Api;

class Test extends \Magento\Framework\App\Action\Action
{
    protected $jsonFactory;
    
    protected $searchCriteriaBuilder;

    protected $filterBuilder;

    protected $sortOrderBuilder;

    protected $repository;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder,
        \Unit5\RetailerApi\Api\RetailerRepositoryInterface $repository
    ) {
        parent::__construct($context);
        $this->jsonFactory           = $jsonFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder         = $filterBuilder;
        $this->sortOrderBuilder      = $sortOrderBuilder;
        $this->repository            = $repository;
    }


    public function execute() {
        $data = [];
        $this->checkGetById($data);
        $this->checkSimpleGetList($data);
        return $this->jsonFactory->create()->setData($data);
    }


    protected function checkGetById(&$data) {
        $dataObject = $this->repository->getById(1);

        if ($dataObject->getId() && $dataObject->getName()) {
            $data['getById'] = ['status' => 'OK', 'id' => 1, 'name' => $dataObject->getName()];
        }
    }

    protected function checkSimpleGetList(&$data) {

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('country_id', 'US')
            ->create();

        $result = $this->repository->getList($searchCriteria);
        if ($result) $data['simple_get_list'] = ['status' => 'OK'];

        foreach ($result->getItems() as $item) {
            $data['simple_get_list']['items'][] = ['name' => $item['name'], 'country_id' => $item['country_id']];
        }
    }
}