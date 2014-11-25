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

$vendorRoleId = Mage::getModel('admin/roles')
            ->getCollection()
        		->addFieldToFilter('role_name', Openwriter_Cartmart_Model_Vendor::ROLE)
        		->getFirstItem()
        		->getId();
     		
Mage::getModel('admin/rules')
            ->setRoleId($vendorRoleId)
            ->setResources(array('admin/catalog', 'admin/catalog/products', 'admin/system', 'admin/system/myaccount', 'admin/vendor', 'admin/vendor/orders', 'admin/vendor/transaction', 'admin/vendor/review','admin/system/convert','admin/system/convert/gui'))
            ->saveRel();
        		

?>
