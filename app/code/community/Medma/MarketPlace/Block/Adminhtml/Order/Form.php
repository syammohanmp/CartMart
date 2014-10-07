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
class Medma_MarketPlace_Block_Adminhtml_Order_Form extends Mage_Adminhtml_Block_Template {

    public function __construct() {
        $this->setTemplate('marketplace/sales/order/view/form.phtml');
        parent::__construct();
    }

    public function getHeaderText() {
        if (Mage::registry('current_order') && Mage::registry('current_order')->getId()) {
            return Mage::helper('marketplace')->__("Order # %s | %s", $this->getOrder()->getIncrementId(), $this->formatDate($this->getOrder()->getCreatedAtDate(), 'medium', true)
            );
        }
    }

    public function getOrder() {
        return Mage::registry('current_order');
    }

    public function getPaymentHtml() {
        return $this->getChildHtml('order_payment');
    }

    public function getGiftmessageHtml() {
        return $this->getChildHtml('order_giftmessage');
    }

    public function displayPriceAttribute($code, $strong = false, $separator = '<br/>') {
        return Mage::helper('adminhtml/sales')->displayPriceAttribute($this->getPriceDataObject(), $code, $strong, $separator);
    }

    public function getPriceDataObject() {
        $obj = null;
        if (is_null($obj)) {
            return $this->getOrder();
        }
        return $obj;
    }

    public function displayShippingPriceInclTax($order) {
        $shipping = $order->getShippingInclTax();
        if ($shipping) {
            $baseShipping = $order->getBaseShippingInclTax();
        } else {
            $shipping = $order->getShippingAmount() + $order->getShippingTaxAmount();
            $baseShipping = $order->getBaseShippingAmount() + $order->getBaseShippingTaxAmount();
        }
        return $this->displayPrices($baseShipping, $shipping, false, ' ');
    }

    public function displayPrices($basePrice, $price, $strong = false, $separator = '<br/>') {
        return Mage::helper('adminhtml/sales')->displayPrices($this->getPriceDataObject(), $basePrice, $price, $strong, $separator);
    }

    public function getBackUrl() {
        return Mage::helper('adminhtml')->getUrl('*/*/index');
    }

    public function getShipUrl() {
        return Mage::helper('adminhtml')->getUrl('*/*/ship') . 'order_id/' . $this->getOrder()->getId();
    }

    public function getInvoiceUrl() {
        return Mage::helper('adminhtml')->getUrl('*/*/invoice') . 'order_id/' . $this->getOrder()->getId();
    }

    public function isShipButtonDisplay() {
        $roleId = Mage::helper('marketplace')->getConfig('general', 'vendor_role');
		
        // $role = Mage::getModel('admin/roles')->load($roleId);

        $current_user = Mage::getSingleton('admin/session')->getUser();

        if ($current_user->getRole()->getRoleId() == $roleId) {
            $productIds = $this->getProductIdsCollection();

            foreach ($this->getOrder()->getAllItems() as $item) {
                if (in_array($item->getProductId(), $productIds) && $item->canShip())
                    return true;
            }
        }
        return false;
    }

    public function isInvoiceButtonDisplay() {
        $roleId = Mage::helper('marketplace')->getConfig('general', 'vendor_role');
		
        // $role = Mage::getModel('admin/roles')->load($roleId);

        $current_user = Mage::getSingleton('admin/session')->getUser();

        if ($current_user->getRole()->getRoleId() == $roleId) {
            $productIds = $this->getProductIdsCollection();

            foreach ($this->getOrder()->getAllItems() as $item) {
                if (in_array($item->getProductId(), $productIds) && $item->canInvoice())
                    return true;
            }
        }
        return false;
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

}

?>
