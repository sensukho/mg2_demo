<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2/27/18
 * Time: 15:58
 */

namespace Unit4\Retailer\Setup;


use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{

    /**
     * Upgrades data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if(version_compare($context->getVersion(), '1.0.1', '<')) {
            $install = $setup;
            $install->startSetup();

            $binds = [
                ['retailer_id'=>1, 'product_id'=>1],
                ['retailer_id'=>1, 'product_id'=>2],
                ['retailer_id'=>1, 'product_id'=>3],
                ['retailer_id'=>2, 'product_id'=>1],
                ['retailer_id'=>2, 'product_id'=>2],
                ['retailer_id'=>3, 'product_id'=>1],
                ['retailer_id'=>3, 'product_id'=>3],
                ['retailer_id'=>4, 'product_id'=>1],
            ];

            foreach ($binds as $bind) {
                $install->getConnection()->insertForce(
                    'unit4_retailer2product',
                    $bind
                );
            }

            $install->endSetup();
        }
    }
}