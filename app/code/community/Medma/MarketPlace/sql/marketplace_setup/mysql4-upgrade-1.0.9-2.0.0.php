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

$table = $installer->getConnection()->newTable($installer->getTable('marketplace/prooftype'))
	->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'identity' => true,
			'unsigned' => true,
			'nullable' => false,
			'primary' => true,
		), 'Id')
	->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR,50, null, array(
			'nullable' => false,
		), 'Rating Name')	
	->addColumn('status', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null, array(
			'nullable' => false,
			'default' => 0,			
		), 'Status');
		
$installer->getConnection()->createTable($table);

$installer->getConnection()
	->addColumn(
		$installer->getTable('marketplace/profile'),  'proof_type', array(
			'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,         
			'nullable'  => true,
			'comment'   => 'Proof Type',
		)
	);

$installer->getConnection()
	->addColumn(
		$installer->getTable('marketplace/profile'),  'varification_files', array(
			'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
			'nullable'  => true,
			'comment'   => 'Varification Files',
		)
	);

$table = $installer->getConnection()
	->newTable($installer->getTable('marketplace/review'))
		->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
				'auto_increment' => true,
				'unsigned' => true,
				'nullable' => false,
				'primary' => true,
			 ), 'Id')
		->addColumn('invoice_item_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
				'nullable' => false,
			), 'Invoice Item Id')
		 ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
				'nullable' => false,			
			), 'Title')
		->addColumn('summary', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
				'nullable' => false,			
			), 'Summary')
		->addColumn('posted_date', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
				'nullable' => true,
			), 'Time Stamp')
		->addColumn('type', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
				'nullable' => false,
			), 'Type')		
		->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
				'nullable' => false,				
			), 'Status');

$installer->getConnection()->createTable($table);	
	
$installer->endSetup();

?>
