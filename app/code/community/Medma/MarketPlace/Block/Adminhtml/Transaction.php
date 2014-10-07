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
class Medma_MarketPlace_Block_Adminhtml_Transaction extends Mage_Adminhtml_Block_Template {

    public function __construct() {
        $this->setTemplate('marketplace/vendor/transaction.phtml');
        parent::__construct();
    }

    public function getHeaderText() {
        if (Mage::registry('vendor_user') && Mage::registry('vendor_user')->getId()) {
            return Mage::helper('marketplace')->__("Balance sheet | %s", Mage::registry('vendor_user')->getName()
            );
        }
    }

    public function getBackUrl() {
        return Mage::helper('adminhtml')->getUrl('*/adminhtml_vendor/index');
    }

    public function getAddUrl() {
        return Mage::helper('adminhtml')->getUrl('*/*/new', array('vendor_id' => $this->getRequest()->getParam('id')));
    }    
    
    public function isToShowButtons()
    {
        $roleId = Mage::helper('marketplace')->getConfig('general', 'vendor_role');
		
        // $role = Mage::getModel('admin/roles')->load($roleId);

        $current_user = Mage::getSingleton('admin/session')->getUser();

        if ($current_user->getRole()->getRoleId() == $roleId) {
            return false;
        }
        return true;
    }

}

?>
