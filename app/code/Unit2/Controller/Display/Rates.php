<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2/26/18
 * Time: 15:29
 */

namespace Unit2\Converter\Controller\Display;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Unit2\Converter\Helper\GoogleConverter;

class Rates extends Action
{
    /**
     * @var GoogleConverter
     */
    private $googleConverter;

    /**
     * Rates constructor.
     * @param Context $context
     * @param GoogleConverter $googleConverter
     */
    public function __construct(
        Context $context,
        GoogleConverter $googleConverter
    )
    {
        parent::__construct($context);
        $this->googleConverter = $googleConverter;
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
        // http://m2ce.m2/converter/display/rates/a/100/from/USD/to/EUR
        $amount = $this->getRequest()->getParam('a', false);
        $from = $this->getRequest()->getParam('from', 'USD');
        $to = $this->getRequest()->getParam('to', 'EUR');

        $res = $this->googleConverter->convert($amount, $from, $to);

        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($res);
        return $resultJson;
    }
}