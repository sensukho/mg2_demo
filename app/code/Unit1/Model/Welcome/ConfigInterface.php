<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2/26/18
 * Time: 13:38
 */

namespace Unit1\FreeGeoIp\Model\Welcome;


interface ConfigInterface
{
    /**
     * @param $country_code
     * @param null $location
     * @return mixed
     */
    public function getWelcomeMessage($country_code = 'default', $location = null);

    /**
     * Get configuration of all registered welcome messages
     *
     * @return array
     */
    public function getAll();
}