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

class Medma_MarketPlace_Model_Profile_Products extends Mage_Catalog_Model_Product
{
	const ITEM_COUNT = 5;
	
    public function getItemsCollection($vendorId)
    {
        $collection = $this->getCollection()
            ->addAttributeToSelect('*')
            ->addFieldToFilter('status', 1)
            ->addFieldToFilter('visibility', array('in' => array(2, 4)))
            ->addAttributeToFilter('vendor', $vendorId)
            ->setOrder('created_at', 'desc');
            
        $collection->getSelect()->limit($this::ITEM_COUNT);
        
        Mage::getSingleton('cataloginventory/stock')->addInStockFilterToCollection($collection);
        return $collection;
    }
}
?>
