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
class Openwriter_Cartmart_Block_Vendor_Profile_Reviews extends Mage_Core_Block_Template {
	
	protected function _prepareLayout()
	{
		parent::_prepareLayout();

		$type = $this->getRequest()->getParam('type');
		if(!isset($type))
			$type = Openwriter_Cartmart_Model_Review::ALL;
					
		$vendorId = $this->getVendorInfo()->getUserId();

		$pager = $this->getLayout()->createBlock('page/html_pager', 'productlist.pager')->setTemplate('page/html/pager.phtml');
		
		$pageConfigOption = Mage::helper('cartmart')->getConfig('review', 'page_size');		
				
		$pageConfigOptionArray = explode(',', $pageConfigOption);		
		$pageCountArray = array();
		foreach($pageConfigOptionArray as $pageCount)		
			$pageCountArray[$pageCount] = $pageCount;		
		$pageCountArray['all'] = 'all';
				
		$pager->setAvailableLimit($pageCountArray);		
		$pager->setCollection($this->getReviewCollection($vendorId, $type));
		$this->setChild('pager', $pager);		
		return $this;
	}
	
	public function getVendorInfo() {
        $profileId = $this->getRequest()->getParam('id');
        return Mage::getModel('cartmart/profile')->load($profileId);
    }

    public function getUserObject($userId) {
        return Mage::getModel('admin/user')->load($userId);
    }
    
    protected function getReviewCollection($vendorId, $type)
	{
		if (is_null($this->_myCollection)) 
		{	
			$productIds = Mage::getModel('catalog/product')->getCollection()
				->addFieldToFilter('vendor', $vendorId)
				->getAllIds();
					
			$invoiceItemIds = Mage::getModel('sales/order_invoice_item')->getCollection()
				->addFieldToFilter('product_id', array('in' => $productIds))
				->getAllIds();
					
			if($type == Openwriter_Cartmart_Model_Review::ALL)
				$this->_myCollection = Mage::getModel('cartmart/review')->getCollection()
					->addFieldToFilter('invoice_item_id', array('in' => $invoiceItemIds))					
					->addFieldToFilter('status', Openwriter_Cartmart_Model_Review::APPROVED);			
			else			
				$this->_myCollection = Mage::getModel('cartmart/review')->getCollection()
					->addFieldToFilter('invoice_item_id', array('in' => $invoiceItemIds))
					->addFieldToFilter('type', $type)
					->addFieldToFilter('status', Openwriter_Cartmart_Model_Review::APPROVED);			
		} 
		return $this->_myCollection;
	}
	
	public function getProductData($id, $column)
	{
		$invoiceItemModel = Mage::getModel('sales/order_invoice_item')->load($id);       
		$productModel = Mage::getModel('catalog/product')->load($invoiceItemModel->getProductId());
		
		if($column == 'name')
			return $productModel->getName();
		else if($column == 'price')
			return Mage::helper('core')->currency($productModel->getPrice());
		else
			return $productModel->getProductUrl();			
	}
	
	public function getReviewTypeImageClass($type)
	{
		if($type == Openwriter_Cartmart_Model_Review::POSITIVE)
			return 'positive-type-image';
		else if($type == Openwriter_Cartmart_Model_Review::NEUTRAL)
			return 'neutral-type-image';
		else
			return 'negative-type-image';
	}
	
	public function getActiveTypeLink($linkType)
	{
		$type = $this->getRequest()->getParam('type');
		
		if(isset($type))
		{
			if($type == $linkType)
				return 'active';
			else
				return '';
		}
		else if($linkType == Openwriter_Cartmart_Model_Review::ALL)
			return 'active';
		else
			return '';
	}
	
	public function getTypeUrl($vendorId, $linkType)
	{
		return Mage::getUrl('cartmart/vendor/profile', array('id' => $vendorId, 'type'=> $linkType));
	}
}

?>
