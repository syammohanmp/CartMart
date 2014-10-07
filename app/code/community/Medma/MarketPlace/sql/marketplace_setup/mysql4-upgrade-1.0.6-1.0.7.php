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

$role = Mage::getModel('admin/roles')
	->getCollection()
	->addFieldToFilter('role_name', Medma_MarketPlace_Model_Vendor::ROLE)
	->getFirstItem();

Mage::getConfig()->saveConfig('marketplace/general/vendor_role', $role->getId());
Mage::getConfig()->reinit();
Mage::app()->reinitStores();

$installer->endSetup();
?>
