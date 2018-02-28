<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2/26/18
 * Time: 13:38
 */
namespace Unit1\FreeGeoIp\Model\Welcome;

use Magento\Framework\Serialize\SerializerInterface;

class Config extends \Magento\Framework\Config\Data implements \Unit1\FreeGeoIp\Model\Welcome\ConfigInterface
{

    /**
     * Constructor
     *
     * @param Config\Reader $reader
     * @param \Magento\Framework\Config\CacheInterface $cache
     * @param string|null $cacheId
     * @param SerializerInterface|null $serializer
     */
    public function __construct(
        \Unit1\FreeGeoIp\Model\Welcome\Config\Reader $reader,
        \Magento\Framework\Config\CacheInterface $cache,
        $cacheId = 'welcome_config',
        SerializerInterface $serializer = null
    ) {
        parent::__construct($reader, $cache, $cacheId, $serializer);
    }

    /**
     * @param $country_code
     * @param null $location
     * @return mixed
     */
    public function getWelcomeMessage($country_code = 'default', $location = null)
    {
        $values = $this->get();
        $msg = isset($values['default']) && $values['default'] ?
            $values['default'] : '';
        if(isset($values[$country_code])) {
            $country = $values[$country_code];
            $msg = $country['default'];
            if(isset($country[$location])) {
                $msg = $country[$location];
            }
        }
        return $msg;
    }

    /**
     * Get configuration of all registered welcome messages
     *
     * @return array
     */
    public function getAll()
    {
        return $this->get();
    }
}