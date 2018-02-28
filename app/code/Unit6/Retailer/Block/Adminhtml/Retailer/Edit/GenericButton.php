<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Unit6\Retailer\Block\Adminhtml\Retailer\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Unit5\RetailerApi\Api\RetailerRepositoryInterface;


/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var RetailerRepositoryInterface
     */
    protected $retailerRepository;

    /**
     * @param Context $context
     * @param RetailerRepositoryInterface $retailerRepository
     */
    public function __construct(
        Context $context,
        RetailerRepositoryInterface $retailerRepository
    ) {
        $this->context = $context;
        $this->retailerRepository = $retailerRepository;
    }

    /**
     * Return Retailer ID
     *
     * @return int|null
     */
    public function getRetailerId()
    {
        try {
            return $this->retailerRepository->getById(
                $this->context->getRequest()->getParam('retailer_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
