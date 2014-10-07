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
class Medma_MarketPlace_Block_Adminhtml_Transaction_Items extends Mage_Adminhtml_Block_Template {
    
    public function __construct() {
        $this->setTemplate('marketplace/vendor/transaction/items.phtml');
        parent::__construct();
    }
    
    public function getTransactions() {
        return Mage::getModel('marketplace/transaction')
            ->getCollection()
            ->addFieldToFilter('vendor_id', Mage::registry('vendor_user')->getId());
    }

    public function formatAmount($amount) {
        return Mage::helper('core')->currency($amount, true, false);
    }
}

?>
