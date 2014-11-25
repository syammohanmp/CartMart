<?php

/**
 * Openwriter Cartmart
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Team
 * that is bundled with this package of Openwriter.
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento COMMUNITY edition
 * Contact us Support does not guarantee correct work of this package
 * on any other Magento edition except Magento COMMUNITY edition.
 * =================================================================
 * 
 * @category    Openwriter
 * @package     Openwriter_Cartmart
**/

$installer = $this;
$installer->startSetup();
$table = $installer->getConnection()->newTable($installer->getTable('cartmart/profile'))
        ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true,
            ), 'Id')
        ->addColumn('user_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'nullable' => true,
            ), 'User Id')
        ->addColumn('image', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
                'nullable' => true,
            ), 'Image')
        ->addColumn('admin_commission_percentage', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
                'nullable' => true,
            ), 'Admin Commission Percentage')
        ->addColumn('total_admin_commission', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
                'nullable' => true,
            ), 'Total Admin Commission')
        ->addColumn('total_vendor_amount', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
                'nullable' => true,
            ), 'Total Vendor Amount')
        ->addColumn('total_vendor_paid', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
                'nullable' => true,
            ), 'Total Vendor Paid');
$installer->getConnection()->createTable($table);

$installer->endSetup();

?>
