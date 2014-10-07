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

class Medma_MarketPlace_Model_System_Config_Source_Roles
{
	protected function _construct() 
	{
		$this->_init('marketplace/system_config_source_roles');	
	}
    
	public function toOptionArray()
    {
		$roleCollection = Mage::getModel('admin/roles')->getCollection();
		$result = array();
		
		foreach($roleCollection as $role)
		{
			$result[] = array('value' => $role->getId(), 'label' => $role->getRoleName());
		}
        
        return $result;
    }    
}
?>
