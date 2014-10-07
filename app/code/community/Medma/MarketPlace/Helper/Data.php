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
class Medma_MarketPlace_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getImagesDir($type)
	{
		$path = Mage::getBaseDir('media') . DS . 'marketplace' . DS . 'vendor' . DS . $type . DS;
		if(!is_dir($path))
			mkdir($path, 0777, true);
			
		return $path;
	}
	
	public function getImagesUrl($type)
	{
		return Mage::getBaseUrl('media') . 'marketplace' . DS . 'vendor' . DS . $type . DS;	
	}
	
	public function getCountryName($countryCode)
	{		
		return Mage::app()->getLocale()->getCountryTranslation($countryCode);
	}
	
	public function getConfig($group, $field)
	{
		return Mage::getStoreConfig('marketplace/' . $group . '/' . $field, Mage::app()->getStore());
	}
	
	public function getVarificationProofTypeList()
	{
		$proofType[''] = '';
		
		$prooftypeCollection = Mage::getModel('marketplace/prooftype')->getCollection()->addFieldToFilter('status', 1);
		
		foreach($prooftypeCollection as $prooftype)		
			$proofType[$prooftype->getId()] = $prooftype->getName();
		
		return $proofType;
	}
}
?>
