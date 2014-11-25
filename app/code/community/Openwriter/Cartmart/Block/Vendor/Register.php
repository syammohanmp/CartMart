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
class Openwriter_Cartmart_Block_Vendor_Register extends Mage_Core_Block_Template {
        
	public function getPostActionUrl()
	{
		return $this->getUrl('cartmart/vendor/save');
	}
	
	public function getCountryList()
    {
		$countries[''] = '';
		
		$coutryCollection = Mage::getResourceModel('directory/country_collection')->loadData()->toOptionArray(false);
		
		foreach($coutryCollection as $country)		
			$countries[$country['value']] = $country['label'];		
		
		return $countries;
	}
	
	public function getProofTypeList()
	{
		return Mage::getModel('cartmart/prooftype')->getCollection()->addFieldToFilter('status', 1);
	}
}

?>
