<?php
/**
 * Created by PhpStorm.
 * User: marina
 * Date: 8/15/18
 * Time: 4:53 PM
 */

namespace Magento\CustomCatalog\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_exception $exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('stacklevel_customcatalog_product')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('stacklevel_customcatalog_product')
            )
                ->addColumn(
                    'entity_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'Post ID'
                )
                ->addColumn(
                    'copywrite_info',
                    Table::TYPE_TEXT,
                    '64k',
                    ['nullable => false'],
                    'Copy Write Info'
                )
                ->addColumn(
                    'vpn',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Vendor Product Number'
                )
                ->addColumn(
                    'sku',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'SKU'
                );
            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('stacklevel_customcatalog_product'),
                $setup->getIdxName(
                    $installer->getTable('stacklevel_customcatalog_product'),
                    ['copywrite_info','vpn','sku'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['copywrite_info','vpn','sku'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }
        $installer->endSetup();
    }


}