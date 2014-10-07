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
class Medma_MarketPlace_Block_Adminhtml_Order_Form_Info extends Mage_Adminhtml_Block_Template {

    public function __construct() {
        $this->setTemplate('marketplace/sales/order/view/form/info.phtml');
        parent::__construct();
    }

    public function getOrder() {
        return Mage::registry('current_order');
    }

    public function shouldDisplayCustomerIp() {
        return !Mage::getStoreConfigFlag('sales/general/hide_customer_ip', $this->getOrder()->getStoreId());
    }

    public function getCustomerGroupName() {
        if ($this->getOrder()) {
            return Mage::getModel('customer/group')->load((int) $this->getOrder()->getCustomerGroupId())->getCode();
        }
        return null;
    }

    public function getOrderStoreName() {
        if ($this->getOrder()) {
            $storeId = $this->getOrder()->getStoreId();
            if (is_null($storeId)) {
                $deleted = Mage::helper('adminhtml')->__(' [deleted]');
                return nl2br($this->getOrder()->getStoreName()) . $deleted;
            }
            $store = Mage::app()->getStore($storeId);
            $name = array(
                $store->getWebsite()->getName(),
                $store->getGroup()->getName(),
                $store->getName()
            );
            return implode('<br/>', $name);
        }
        return null;
    }

}

?>
