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
class OpenWriter_Cartmart_Block_Catalog_Product_Vendor_Sidebar extends Mage_Core_Block_Template {

    public function getProduct() {
        if (!Mage::registry('product') && $this->getProductId()) {
            $product = Mage::getModel('catalog/product')->load($this->getProductId());
            Mage::register('product', $product);
        }
        return Mage::registry('product');
    }

    public function getVendorInfo() {
        $userId = $this->getProduct()->getVendor();

        $vendorProfileCollection = Mage::getModel('cartmart/profile')->getCollection()
                ->addFieldToFilter('user_id', $userId);

        if ($vendorProfileCollection->count() > 0)
            return $vendorProfileCollection->getFirstItem();
        else
            return null;
    }

    public function getVendorProfileUrl($vendorId) {
        return $this->getUrl('cartmart/vendor/profile', array('id' => $vendorId));
    }

    public function getAddFavouriteUrl($vendorId) {
        return $this->getUrl('cartmart/favourite/add', array('id' => $vendorId));
    }

    public function getProductId() {
        return (int) $this->getRequest()->getParam('id');
    }

}

?>
