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
class Medma_MarketPlace_Block_Sales_Order_Item_Renderer_Default extends Mage_Sales_Block_Order_Item_Renderer_Default {
    
    public function getVendorProfile()
    {
        $productModel = Mage::getModel('catalog/product')->load($this->getItem()->getProductId());
        return Mage::getModel('marketplace/profile')
                ->getCollection()
                ->addFieldToFilter('user_id', $productModel->getVendor())
                ->getFirstItem();
    }
    
    public function getRatingSaveUrl($invoiceItemId, $orderId)
    {
		return $this->getUrl('marketplace/rating/save', 
			array('invoice_item_id' => $invoiceItemId, 'order_id' => $orderId)
		);
	}
	
	public function getVendorProfileUrl($vendorId) {
        return $this->getUrl('marketplace/vendor/profile', array('id' => $vendorId));
    }
	
	public function getInvoiceItemId()
	{
		$order_item_id = $this->getItem()->getId();
		
		$invoiceCollection = Mage::getModel('sales/order_invoice_item')->getCollection()
			->addFieldToFilter('order_item_id', $order_item_id);		
			
		if($invoiceCollection->count() == 0)
			return 0;
		else
			return $invoiceCollection->getFirstItem()->getId();		
	}
	
	public function setInvoiceItemId($invoice_item_id)
	{
		Mage::registry('invoice_item_id', $invoice_item_id);
	}
	
	public function getFormId($invoiceItemId)
	{
		return 'review_form_' . $invoiceItemId;
	}
}

?>
