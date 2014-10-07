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
class Medma_MarketPlace_Block_Vendor_Ratings extends Mage_Core_Block_Template {

    public function __construct() {
        $this->setTemplate('marketplace/vendor/ratings.phtml');
        parent::__construct();
    }

    public function getRatings() {		
        return Mage::getModel('marketplace/rating')->getCollection()
			->addFieldToFilter('status', 1)
			->setOrder('sort_order', 'ASC');
    }
    
    public function getValue($ratingId)
    {
		$invoiceItemId = $this->getInvoiceItemId();
		
		$rateCollection = Mage::getModel('marketplace/rate')
			->getCollection()
			->addFieldToFilter('rating_id', $ratingId)
			->addFieldToFilter('invoice_item_id', $invoiceItemId);
			
		if($rateCollection->count())
			return $rateCollection->getFirstItem()->getValue();
		else
			return 0;
	}
    
}

?>
