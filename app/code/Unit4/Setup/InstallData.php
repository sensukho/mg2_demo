<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2/27/18
 * Time: 15:07
 */

namespace Unit4\Retailer\Setup;


use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{

    /**
     * Installs data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $install = $setup;
        $install->startSetup();
        $retailers = [
            [
                'name' => 'Retailer 1',
                'country_id' => 'US',
                'region_id' => 2,
                'city' => 'Alaska City',
                'street' => 'Alaska Street',
                'postcode' => '12345',
            ],
            [
                'name' => 'Retailer 2',
                'country_id' => 'US',
                'region_id' => 2,
                'city' => 'Alaska City',
                'street' => 'Alaska Street 2',
                'postcode' => '23456',
            ],
            [
                'name' => 'Retailer 3',
                'country_id' => 'US',
                'region_id' => 4,
                'city' => 'Arizona City 3',
                'street' => 'Arizona Street 3',
                'postcode' => '56789',
            ],
            [
                'name' => 'Retailer 4',
                'country_id' => 'US',
                'region_id' => 4,
                'city' => 'Arizona City 4',
                'street' => 'Arizona Street 4',
                'postcode' => '00000',
            ],
        ];

        foreach ($retailers as $retailer) {
            $install->getConnection()->insertForce('unit4_retailer', $retailer);
        }
        $install->endSetup();
    }
}
