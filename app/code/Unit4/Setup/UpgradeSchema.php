<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2/27/18
 * Time: 15:45
 */

namespace Unit4\Retailer\Setup;


use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{

    /**
     * Upgrades DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if(version_compare($context->getVersion(), '1.0.1', '<')) {
            $installer = $setup;
            $installer->startSetup();

            $table = $installer->getConnection()
                ->newTable('unit4_retailer2product')
                ->addColumn(
                    'retailer2product_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary' => true,
                    ],
                    'Retailer 2 Product Id'
                )->addColumn(
                    'retailer_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false
                    ],
                    'Retailer Id'
                )->addColumn(
                    'product_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false
                    ],
                    'Product Id'
                )->addIndex(
                    $installer->getIdxName(
                        'unit4_retailer2product',
                        ['product_id']
                    ),
                    ['product_id']
                )->addForeignKey(
                    $installer->getFkName(
                        'unit4_retailer2product',
                        'retailer_id',
                        'unit4_retailer',
                        'retailer_id'
                    ),
                    'retailer_id',
                    'unit4_retailer',
                    'retailer_id',
                    Table::ACTION_CASCADE
                )->addForeignKey(
                    $installer->getFkName(
                        'unit4_retailer2product',
                        'product_id',
                        'catalog_product_entity',
                        'entity_id'
                    ),
                    'product_id',
                    'catalog_product_entity',
                    'entity_id',
                    Table::ACTION_CASCADE
                )->setComment('Retailer 2 Product');

            $installer->getConnection()->createTable($table);

            $installer->endSetup();
        }
    }
}
