<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2/27/18
 * Time: 14:39
 */

namespace Unit4\Retailer\Setup;


use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $intaller = $setup;
        $intaller->startSetup();

//        $intaller->getConnection()->getTableName('');
//        $intaller->getTable('');


        $table = $intaller->getConnection()
            ->newTable('unit4_retailer')
            ->addColumn(
                'retailer_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Retailer Id'
            )->addColumn(
                'name',
                Table::TYPE_TEXT,
                255,
                [],
                'Name'
            )->addColumn(
                'country_id',
                Table::TYPE_TEXT,
                2,
                [
                    'nullable' => false,
                    'default' => false,
                ],
                'Country Id'
            )->addColumn(
                'region_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'unsigned' => true,
                    'nullable' => false
                ],
                'Region Id'
            )->addColumn(
                'city',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'City'
            )->addColumn(
                'street',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Street'
            )->addColumn(
                'postcode',
                Table::TYPE_TEXT,
                10,
                ['nullable' => false],
                'Street'
            )->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['default'=>Table::TIMESTAMP_INIT]
            )->addIndex(
                $intaller->getIdxName('unit4_retailer', ['name']),
                ['name']
            )->addForeignKey(
                $intaller->getFkName(
                    'unit4_retailer',
                    'country_id',
                    'directory_country',
                    'country_id'
                ),
                'country_id',
                'directory_country',
                'country_id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $intaller->getFkName(
                    'unit4_retailer',
                    'region_id',
                    'directory_country_region',
                    'region_id'
                ),
                'region_id',
                'directory_country_region',
                'region_id',
                Table::ACTION_CASCADE
            )->setComment('Retailer Table');

        $intaller->getConnection()->createTable($table);

        $intaller->endSetup();
    }
}