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
class Medma_MarketPlace_Block_Adminhtml_Transaction_Empty extends Mage_Core_Block_Template
{
    protected function _prepareLayout()
    {
        $this->setTemplate('marketplace/vendor/transaction/empty.phtml');
        return parent::_prepareLayout();
    }
    
    public function getVendorGridUrl()
    {
        return Mage::helper('adminhtml')->getUrl('admin_marketplace/adminhtml_vendor/index', array('_current' => true));
    }
}
?>
