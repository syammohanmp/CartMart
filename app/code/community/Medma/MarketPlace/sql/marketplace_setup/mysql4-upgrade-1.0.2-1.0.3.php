<?php

/**
 * Medma Marketplace
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Team
 * that is bundled with this package of Medma Infomatix Pvt. Ltd.
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento COMMUNITY edition
 * Contact us Support does not guarantee correct work of this package
 * on any other Magento edition except Magento COMMUNITY edition.
 * =================================================================
 * 
 * @category    Medma
 * @package     Medma_MarketPlace
**/

$installer = $this;
$installer->startSetup();
$table = $installer->getConnection()->newTable($installer->getTable('marketplace/transaction'))
        ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
                ), 'Id')
        ->addColumn('vendor_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => true,
                ), 'Vendor Id')
        ->addColumn('transaction_date', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => true,
                ), 'Transaction Date')
        ->addColumn('order_number', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
            'nullable' => true,
                ), 'Order Number')
        ->addColumn('information', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
            'nullable' => true,
                ), 'Information')
        ->addColumn('amount', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
            'nullable' => true,
                ), 'Amount')
        ->addColumn('type', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
    'nullable' => true,
        ), 'Type');
$installer->getConnection()->createTable($table);
$installer->endSetup();
?>
