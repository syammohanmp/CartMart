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

$roleCollection = Mage::getModel('admin/roles')
        ->getCollection()
        ->addFieldToFilter('role_name', Medma_MarketPlace_Model_Vendor::ROLE);

if ($roleCollection->count() == 0) {
    $role = Mage::getModel('admin/roles')
            ->setName(Medma_MarketPlace_Model_Vendor::ROLE)
            ->setRoleType(Medma_MarketPlace_Model_Vendor::ROLE_TYPE)
            ->save();

    Mage::getModel('admin/rules')
            ->setRoleId($role->getId())
            ->setResources(array('admin/catalog', 'admin/catalog/products', 'admin/system', 'admin/system/myaccount', 'admin/vendor', 'admin/vendor/orders', 'admin/vendor/transaction', 'admin/vendor/review'))
            ->saveRel();
}

?>
