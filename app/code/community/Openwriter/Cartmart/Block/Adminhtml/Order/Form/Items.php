<?php
/**
 * OpenWriter Cartmart
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Team
 * that is bundled with this package of OpenWriter.
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento COMMUNITY edition
 * Contact us Support does not guarantee correct work of this package
 * on any other Magento edition except Magento COMMUNITY edition.
 * =================================================================
 * 
 * @category    OpenWriter
 * @package     OpenWriter_Cartmart
**/
class OpenWriter_Cartmart_Block_Adminhtml_Order_Form_Items extends Mage_Adminhtml_Block_Template {

    public function __construct() {
        $this->setTemplate('marketplace/sales/order/view/form/items.phtml');
        parent::__construct();
    }

    public function getOrder() {
        return Mage::registry('current_order');
    }

    public function getItemsCollection() {
        return $this->getOrder()->getItemsCollection();
    }

    public function getProductIdsCollection() {
        $roleId = Mage::helper('marketplace')->getConfig('general', 'vendor_role');
		
        // $role = Mage::getModel('admin/roles')->load($roleId);

        $current_user = Mage::getSingleton('admin/session')->getUser();

        $collection = Mage::getModel('catalog/product')->getCollection()
                ->addAttributeToFilter('status', 1);

        if ($current_user->getRole()->getRoleId() == $roleId)
            $collection->addAttributeToFilter('vendor', $current_user->getId());

        return $collection->getAllIds();
    }

    public function getAdminCommission($item) {
        $product_id = $item->getProductId();
        $product = Mage::getModel('catalog/product')->load($product_id);
        if (!is_null($product)) {
            $vendor_id = $product->getData('vendor');
            $profile = Mage::getModel('marketplace/profile')->getCollection()->addFieldToFilter('user_id', $vendor_id)->getFirstItem();
            if (!is_null($profile)) {
                $commission_percentage = $profile->getAdminCommissionPercentage();
                $commission_amount = (($item->getPriceInclTax() * $item->getQtyOrdered()) * $commission_percentage) / 100;
                return $commission_amount;
            }
        }
        return 0;
    }

    public function getVendorAmount($item) {
        $product_id = $item->getProductId();
        $product = Mage::getModel('catalog/product')->load($product_id);
        if (!is_null($product)) {
            $vendor_id = $product->getData('vendor');
            $profile = Mage::getModel('marketplace/profile')->getCollection()->addFieldToFilter('user_id', $vendor_id)->getFirstItem();
            if (!is_null($profile)) {
                $commission_percentage = $profile->getAdminCommissionPercentage();
                $total_price = ($item->getPriceInclTax() * $item->getQtyOrdered());
                $vendor_amount = $total_price - (($total_price * $commission_percentage) / 100);
                return $vendor_amount;
            }
        }
        return 0;
    }

}

?>
