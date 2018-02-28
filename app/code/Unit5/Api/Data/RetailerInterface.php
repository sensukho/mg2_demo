<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2/28/18
 * Time: 09:43
 */
namespace Unit5\RetailerApi\Api\Data;

interface RetailerInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    
    const RETAILER_ID = 'retailer_id';
    const NAME = 'name';
    const COUNTRY_ID = 'country_id';
    const REGION_ID = 'region_id';
    const CITY = 'city';
    const STREET = 'street';
    const POSTCODE = 'postcode';
    const CREATED_AT = 'created_at';

    /**
     * @return string
     */
    public function getRetailerId();

    /**
     * @param string $retailer_id
     * @return $this
     */
    public function setRetailerId($retailer_id);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getCountryId();

    /**
     * @param string $country_id
     * @return $this
     */
    public function setCountryId($country_id);

    /**
     * @return string
     */
    public function getRegionId();

    /**
     * @param string $region_id
     * @return $this
     */
    public function setRegionId($region_id);

    /**
     * @return string
     */
    public function getCity();

    /**
     * @param string $city
     * @return $this
     */
    public function setCity($city);

    /**
     * @return string
     */
    public function getStreet();

    /**
     * @param string $street
     * @return $this
     */
    public function setStreet($street);

    /**
     * @return string
     */
    public function getPostcode();

    /**
     * @param string $postcode
     * @return $this
     */
    public function setPostcode($postcode);

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param string $created_at
     * @return $this
     */
    public function setCreatedAt($created_at);
}
