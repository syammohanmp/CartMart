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
		$installer->getTable('cartmart/profile'),  'message', array(
			'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,                
			'nullable'  => true,
			'comment'   => 'Message',
		)
	);
$installer->getConnection()
	->addColumn(
		$installer->getTable('cartmart/profile'),  'contact_number', array(
			'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,                
			'nullable'  => true,
			'comment'   => 'Contact Number',
		)
	);
$installer->getConnection()
	->addColumn(
		$installer->getTable('cartmart/profile'),  'country', array(
			'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,                
			'nullable'  => true,
			'comment'   => 'Country',
		)
	);
$installer->endSetup();
?>
