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
class Openwriter_Cartmart_Block_Vendor_Reviews extends Mage_Core_Block_Template 
{
    public function __construct() 
    {
        $this->setTemplate('cartmart/vendor/reviews.phtml');
        parent::__construct();
    }    
	
	public function getReviewItem()
	{
		$reviewCollection = Mage::getModel('cartmart/review')->getCollection()
			->addFieldToFilter('invoice_item_id', $this->getInvoiceItemId());			
			
		if($reviewCollection->count() > 0)
			return $reviewCollection->getFirstItem();
		else 
			return null;
	}
		  
}

?>
