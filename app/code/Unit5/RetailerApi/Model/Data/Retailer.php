<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2/28/18
 * Time: 10:22
 */
namespace Unit5\RetailerApi\Model\Data;

use Unit5\RetailerApi\Api\Data\RetailerInterface;

class Retailer extends \Magento\Framework\Api\AbstractExtensibleObject implements RetailerInterface
{

    /**
     * @return string
     */
    public function getId()
    {
        return $this->_get(self::RETAILER_ID);
    }

    /**
     * @param string $retailer_id
     * @return $this
     */
    public function setId($retailer_id)
    {
        return $this->setData(self::RETAILER_ID, $retailer_id);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_get(self::NAME);
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @return string
     */
    public function getCountryId()
    {
        return $this->_get(self::COUNTRY_ID);
    }

    /**
     * @param string $country_id
     * @return $this
     */
    public function setCountryId($country_id)
    {
        return $this->setData(self::COUNTRY_ID, $country_id);
    }

    /**
     * @return string
     */
    public function getRegionId()
    {
        return $this->_get(self::REGION_ID);
    }

    /**
     * @param string $region_id
     * @return $this
     */
    public function setRegionId($region_id)
    {
        return $this->setData(self::REGION_ID, $region_id);
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->_get(self::CITY);
    }

    /**
     * @param string $city
     * @return $this
     */
    public function setCity($city)
    {
        return $this->setData(self::CITY, $city);
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->_get(self::STREET);
    }

    /**
     * @param string $street
     * @return $this
     */
    public function setStreet($street)
    {
        return $this->setData(self::STREET, $street);
    }

    /**
     * @return string
     */
    public function getPostcode()
    {
        return $this->_get(self::POSTCODE);
    }

    /**
     * @param string $postcode
     * @return $this
     */
    public function setPostcode($postcode)
    {
        return $this->setData(self::POSTCODE, $postcode);
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->_get(self::CREATED_AT);
    }

    /**
     * @param string $created_at
     * @return $this
     */
    public function setCreatedAt($created_at)
    {
        return $this->setData(self::CREATED_AT, $created_at);
    }
}
