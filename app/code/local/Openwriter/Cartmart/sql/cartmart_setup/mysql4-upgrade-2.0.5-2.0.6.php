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
$installer->getConnection()
    ->addColumn(
        $installer->getTable('cartmart/profile'),  'profile_order', array(
            'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'nullable'  => true,
            'comment'   => 'Profile Order',
        )
    );
$installer->getConnection()
    ->addColumn(
        $installer->getTable('cartmart/profile'),  'featured', array(
            'type'      => Varien_Db_Ddl_Table::TYPE_BOOLEAN,
            'nullable'  => true,
            'comment'   => 'Featured',
        )
    );

$installer->endSetup();
?>
