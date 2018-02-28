<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2/26/18
 * Time: 11:27
 */

namespace Unit1\FreeGeoIp\Observer;


use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\HTTP\ClientFactory;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\SerializerInterface;

class CaptureCustomerCountryObserver implements ObserverInterface
{
    const FREEGEOIP_URL = 'http://freegeoip.net/json/%s';
    /**
     * @var RemoteAddress
     */
    private $remoteAddress;
    /**
     * @var ClientFactory
     */
    private $clientFactory;
    /**
     * @var SerializerInterface
     */
    private $serializer;
    /**
     * @var Registry
     */
    private $registry;

    /**
     * CaptureCustomerCountryObserver constructor.
     * @param RemoteAddress $remoteAddress
     * @param ClientFactory $clientFactory
     * @param SerializerInterface $serializer
     * @param Registry $registry
     */
    public function __construct(
        RemoteAddress $remoteAddress,
        ClientFactory $clientFactory,
        SerializerInterface $serializer,
        Registry $registry
    )
    {
        $this->remoteAddress = $remoteAddress;
        $this->clientFactory = $clientFactory->create();
        $this->serializer = $serializer;
        $this->registry = $registry;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        if($this->registry->registry('country_code')) return;

        $uri = $this->getFreeGeoIpUri();
        try {
            $this->clientFactory->get($uri);
            $response = $this->clientFactory->getBody();
            $data = $this->serializer->unserialize($response);
        } catch (\Exception $exception) {
        }
        /*
         'country_code' => string 'MX' (length=2)
         'region_code' => string 'ZAC' (length=3)
         'city' => string 'Morelos' (length=7)
         */
        $country_code = isset($data['country_code']) && $data['country_code'] ? $data['country_code'] : 'default';
        $region_code = isset($data['region_code']) && $data['region_code'] ? $data['region_code'] : false;
        $city = isset($data['city']) && $data['city'] ? $data['city'] : false;

        $location = $region_code ? $region_code : $city;

        $this->registry->register('country_code', strtolower($country_code));
        $this->registry->register('location', strtolower($location));
    }

    /**
     * @return string
     */
    protected function getFreeGeoIpUri()
    {
        $userip = '200.76.87.254'; //$this->remoteAddress->getRemoteAddress();
        $res = sprintf(self::FREEGEOIP_URL, $userip);
        return $res;
    }
}