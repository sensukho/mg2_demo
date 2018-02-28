<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2/26/18
 * Time: 15:38
 */

namespace Unit2\Converter\Helper;


use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\HTTP\ClientFactory;

class GoogleConverter extends AbstractHelper
{
    const CONVERTER_URL = 'https://finance.google.com/finance/converter?a=%s&from=%s&to=%s';
    /**
     * @var ClientFactory
     */
    private $clientFactory;

    /**
     * GoogleConverter constructor.
     * @param Context $context
     * @param ClientFactory $clientFactory
     */
    public function __construct(
        Context $context,
        ClientFactory $clientFactory
    )
    {
        parent::__construct($context);
        $this->clientFactory = $clientFactory->create();
    }

    /**
     * @param $a
     * @param $from
     * @param $to
     * @return array
     */
    public function convert($a, $from, $to)
    {
        $result = [];

        try {
            $uri = sprintf(self::CONVERTER_URL, $a, $from, $to);
            $this->clientFactory->get($uri);
            $response = $this->clientFactory->getBody();
            $re = '/<span class=bld>(\d+.\d+).*?<\/span>/';

            if(preg_match($re, $response, $m)) {
                $result = [
                    'amount' => $a,
                    'from' => $from,
                    'to' => $to,
                    'value' => $m[1],
                ];
            } else {
                $result['error'] = 'Some value is wrong';
            }

        } catch (\Exception $exception) {
            $result['error'] = $exception->getMessage();
        }

        return $result;
    }
}