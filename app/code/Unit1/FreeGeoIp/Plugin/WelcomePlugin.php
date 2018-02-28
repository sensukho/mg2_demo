<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2/26/18
 * Time: 14:20
 */

namespace Unit1\FreeGeoIp\Plugin;

use Magento\Framework\Registry;
use Unit1\FreeGeoIp\Model\Welcome\ConfigInterface;

class WelcomePlugin
{
    /**
     * @var Registry
     */
    private $registry;
    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * WelcomePlugin constructor.
     * @param Registry $registry
     * @param ConfigInterface $config
     */
    public function __construct(
        Registry $registry,
        ConfigInterface $config
    )
    {
        $this->registry = $registry;
        $this->config = $config;
    }


    public function afterGetWelcome(
        \Magento\Theme\Block\Html\Header $subject,
        $result
    )
    {
        $country_code = $this->registry->registry('country_code');
        $location = $this->registry->registry('location');

        $msg = $this->config->getWelcomeMessage($country_code, $location);
        return $msg;
    }
}