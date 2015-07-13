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
class Openwriter_Cartmart_Block_Vendor_Profile_Latest extends Mage_Catalog_Block_Product_Abstract {

    protected $_itemCollection = null;

    public function getItems() {
        $profileId = $this->getRequest()->getParam('id');

        $vendorId = Mage::getModel('cartmart/profile')->load($profileId)->getUserId();

        if (is_null($this->_itemCollection)) {
            $this->_itemCollection = Mage::getModel('cartmart/profile_products')->getItemsCollection($vendorId);
        }

        return $this->_itemCollection;
    }
    
    public function getHighestSellingProduct()
    {
		$profileId = $this->getRequest()->getParam('id');

        $vendorId = Mage::getModel('cartmart/profile')->load($profileId)->getUserId();
        
        $productsCollection = Mage::getModel('catalog/product')->getCollection()
			->addFieldToFilter('status', 1)
			->addAttributeToFilter('vendor', $vendorId);
			
		if($productsCollection->count() > 0)
			$productIds = $productsCollection->getAllIds();
		else
			return null;		
		
		if(count($productIds) == 0 )
			return null;

		$productReportCollection = Mage::getResourceModel('reports/product_collection')
			->addOrderedQty()
			->addAttributeToSelect('*')
			->setOrder('ordered_qty', 'desc')
			->addFieldToFilter('entity_id', array('in', $productIds));		
		
		if($productReportCollection->count() > 0)
			return Mage::getModel('catalog/product')->load($productReportCollection->getFirstItem()->getId());
		else
			return null;		
	}

}

?>
