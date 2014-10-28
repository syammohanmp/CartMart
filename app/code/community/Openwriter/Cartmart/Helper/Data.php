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
 * @package     OpenWriter_Cartmart
**/
class OpenWriter_Cartmart_Helper_Data extends Mage_Core_Helper_Abstract
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
		return Mage::getBaseUrl('media') . 'marketplace' . '/' . 'vendor' . '/' . $type . '/';	
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
	
	
	/**Check current user is a vendor**/
	public function isVendor()
	{
			$result = '';
			
			/**Fetch Current User Id**/    
      $user = Mage::getSingleton('admin/session');
			$userId = $user->getUser()->getUserId();
			
			/**Fetch Parent Id For Current Role**/
			$role = Mage::getModel('admin/role')
										->getCollection()
										->addFieldToFilter('user_id',$userId)
										->getFirstItem();
										
			$parentId = $role->getParentId();
			
			
			/**Fetch Role Name of current parent id**/
			
			$parentRole = Mage::getModel('admin/role')
										->getCollection()
										->addFieldToFilter('role_id',$parentId)
										->getFirstItem();
										
			$roleName = $parentRole->getRoleName();
			
			if($roleName == 'VENDORS')
			{
					$result = true;
			}
			else
			{
					$result = false;
			}
			
			return $result;
	}
}
?>
