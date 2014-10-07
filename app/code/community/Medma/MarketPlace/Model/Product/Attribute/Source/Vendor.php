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

class Medma_MarketPlace_Model_Product_Attribute_Source_Vendor extends Mage_Eav_Model_Entity_Attribute_Source_Abstract {

    public function getAllOptions() {
        $roleId = Mage::helper('marketplace')->getConfig('general', 'vendor_role');
		
        $role = Mage::getModel('admin/roles')->load($roleId);

        $current_user = Mage::getSingleton('admin/session')->getUser();

        if ($current_user->getRole()->getRoleId() == $role->getRoleId())
            $options[] = array('value' => $current_user->getId(), 'label' => $current_user->getName());
        else {
            $options = array(array('value' => '', 'label' => ''));

            $userIds = Mage::getResourceModel('admin/roles')->getRoleUsers($role);

            $collection = Mage::getModel('admin/user')
                    ->getCollection()
                    ->addFieldToFilter('is_active', 1)
                    ->addFieldToFilter('user_id', array('in' => $userIds));

            foreach ($collection as $user)
                $options[] = array('value' => $user->getId(), 'label' => $user->getName());
        }
        return $options;
    }

}

?>
