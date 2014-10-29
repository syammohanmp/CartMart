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

class Openwriter_Cartmart_Model_Product_Observer {

    public function filterProductCollection($observer) {
        $roleId = Mage::helper('cartmart')->getConfig('general', 'vendor_role');
		
        // $role = Mage::getModel('admin/roles')->load($roleId);

        $current_user = Mage::getSingleton('admin/session')->getUser();

        if ($current_user->getRole()->getRoleId() == $roleId) {
            if (Mage::app()->getFrontController()->getRequest()->getControllerName() == 'catalog_product') {
                $event = $observer->getEvent();
                $collection = $event->getCollection();
                $collection->addAttributeToFilter('vendor', $current_user->getUserId());
                return $this;
            }
        }
    }

}

?>
