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
$table = $installer->getConnection()->newTable($installer->getTable('marketplace/rate'))
	->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'identity' => true,
			'unsigned' => true,
			'nullable' => false,
			'primary' => true,
		), 'Id')
	->addColumn('rating_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'nullable' => false,
		), 'Rating Id')		
	->addColumn('invoice_item_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'nullable' => false,
		), 'Invoice Item Id')	
	->addColumn('value', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'nullable' => false,
		), 'Value')		
	->addIndex($installer->getIdxName('marketplace/rating', array('rating_id')),
			array('rating_id')
		)
	->addForeignKey($installer->getFkName('marketplace/rate', 'rating_id', 'marketplace/rating', 'entity_id'),
			'rating_id', 
			$installer->getTable('marketplace/rating'), 
			'entity_id', 
			Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
		) 
	->setComment('Rating');	
$installer->getConnection()->createTable($table);
$installer->endSetup();

?>
