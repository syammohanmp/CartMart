<?php

/**
 * OpenWriter Cartmart
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Team
 * that is bundled with this package of OpenWriter.
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento COMMUNITY edition
 * Contact us Support does not guarantee correct work of this package
 * on any other Magento edition except Magento COMMUNITY edition.
 * =================================================================
 * 
 * @category    OpenWriter
 * @package     OpenWriter_Cartmart
**/

$installer = $this;
$installer->startSetup();
$installer->getConnection()
        ->addColumn(
            $installer->getTable('cartmart/profile'),  'shop_name', array(
                'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,                
                'nullable'  => true,
                'comment'   => 'Shop Name',
            )
        );
$installer->endSetup();
?>
