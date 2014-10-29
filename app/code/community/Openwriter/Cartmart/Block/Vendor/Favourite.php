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
class Openwriter_Cartmart_Block_Vendor_Favourite extends Mage_Core_Block_Template {

    public function getFavouriteVendors() {
        $profileCollection = Mage::getModel('cartmart/profile')->getCollection();

        $customerId = Mage::getSingleton('customer/session')->getCustomer()->getId();

        $profiles = array();
        foreach ($profileCollection as $profile) {
            $favorites = $profile->getFavourites();

            if (!is_null($favorites) && !empty($favorites)) {
                $favorites = json_decode($favorites, true);
                if (in_array($customerId, $favorites))
                    $profiles[] = $profile->getId();
            }
        }
        
        $userIds = Mage::getModel('admin/user')->getCollection()
			->addFieldToFilter('is_active', 1)
			->getAllIds();

        $profileCollection = Mage::getModel('cartmart/profile')->getCollection()
                ->addFieldToFilter('entity_id', array('in' => $profiles))
                ->addFieldToFilter('user_id', array('in' => $userIds));

        return $profileCollection;
    }

    public function getUserObject($userId) {
        return Mage::getModel('admin/user')->load($userId);
    }

    public function getRemoveFavouriteUrl($vendorId) {
        return $this->getUrl('cartmart/favourite/remove', array('id' => $vendorId));
    }

    public function getCountryName($countryCode) {
        return Mage::helper('cartmart')->getCountryName($countryCode);
    }

    public function getVendorProfileUrl($vendorId) {
        return $this->getUrl('cartmart/vendor/profile', array('id' => $vendorId));
    }
    
    public function getVendorItemsUrl($profileId) {
        return $this->getUrl('cartmart/vendor/items', array('id' => $profileId));
    }
    
    public function getMessage($vendorInfo, $userObject)
    {
        $message = $vendorInfo->getMessage();
        if(trim($message) != '')        
            return $message;    
        else
            return ($this->__('Based in ') .
                $this->getCountryName($vendorInfo->getCountry()) . ' ' .
                $vendorInfo->getShopName() . ' has been member since ' .
                date("M j, Y", strtotime($userObject->getCreated())));
    }
}

?>
