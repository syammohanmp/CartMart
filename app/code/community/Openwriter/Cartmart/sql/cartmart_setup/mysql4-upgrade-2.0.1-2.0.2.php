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

$storeId = Mage::app()->getStore()->getStoreId();

$productIds = Mage::getModel('catalog/product')
	->getCollection()->getAllIds();
	
$attributesData = array('vendor' => null);

Mage::getSingleton('catalog/product_action')
	->updateAttributes($productIds, $attributesData, $storeId);
?>
