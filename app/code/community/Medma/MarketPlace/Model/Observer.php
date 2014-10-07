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

class Medma_MarketPlace_Model_Observer
{
	public function catalogProductSaveBefore($observer)
    {		
		$store = Mage::getModel('core/store')->load(Mage_Core_Model_App::DISTRO_STORE_ID);
		$rootId = $store->getRootCategoryId();

		$product = $observer->getProduct();		
		$categoryIds = $product->getCategoryIds();
				
		if(!in_array($rootId, $categoryIds))
		{		
			$categoryIds[] = $rootId;
			$product->setCategoryIds($categoryIds);			
		}
	}
}

?>
