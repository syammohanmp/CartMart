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
require_once(Mage::getModuleDir('controllers', 'Mage_Adminhtml') . DS . 'System' . DS . 'AccountController.php');

class Openwriter_Cartmart_Adminhtml_Core_System_AccountController extends Mage_Adminhtml_System_AccountController {

    public function saveAction() {
        
        $userId = Mage::getSingleton('admin/session')->getUser()->getId();
        
        $pwd = null;

        $user = Mage::getModel("admin/user")->load($userId);

        $user->setId($userId)
                ->setUsername($this->getRequest()->getParam('username', false))
                ->setFirstname($this->getRequest()->getParam('firstname', false))
                ->setLastname($this->getRequest()->getParam('lastname', false))
                ->setEmail(strtolower($this->getRequest()->getParam('email', false)));

        if ($this->getRequest()->getParam('new_password', false)) {
            $user->setNewPassword($this->getRequest()->getParam('new_password', false));
        }

        if ($this->getRequest()->getParam('password_confirmation', false)) {
            $user->setPasswordConfirmation($this->getRequest()->getParam('password_confirmation', false));
        }

        $result = $user->validate();
        if (is_array($result)) {
            foreach ($result as $error) {
                Mage::getSingleton('adminhtml/session')->addError($error);
            }
            $this->getResponse()->setRedirect($this->getUrl("*/*/"));
            return;
        }

        try {
            $user->save();

            $roleId = Mage::helper('cartmart')->getConfig('general', 'vendor_role');
		
			// $role = Mage::getModel('admin/roles')->load($roleId);

            $current_user = Mage::getSingleton('admin/session')->getUser();

            if ($current_user->getRole()->getRoleId() == $roleId) {
                $image = null;
                if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
                    $uploader = new Varien_File_Uploader('image');
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png')); // or pdf or anything

                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(false);
                        
					$dir_name = 'vendor' . DS . 'images';
					$dir_path = Mage::helper('cartmart')->getImagesDir($dir_name);

                    $uploader->save($dir_path, $_FILES['image']['name']);
                    $image = $_FILES['image']['name'];
                }
                else
                    $image = $this->getRequest()->getParam('old_image', false);

                $profileCollection = Mage::getModel('cartmart/profile')->getCollection()->addFieldToFilter('user_id', $userId);

                if ($profileCollection->count() > 0)
                    $profile = Mage::getModel('cartmart/profile')->load($profileCollection->getFirstItem()->getId());
                else
                    $profile = Mage::getModel('cartmart/profile')->setTotalAdminCommission(0)->setTotalVendorAmount(0)->setTotalVendorPaid(0);

                if (!is_null($image))
                    $profile->setImage($image);

                $profile->setUserId($userId)
						->setShopName($this->getRequest()->getParam('shop_name', false))
						->setMessage($this->getRequest()->getParam('message', false))
						->setContactNumber($this->getRequest()->getParam('contact_number', false))
						->setCountry($this->getRequest()->getParam('country', false))
                        ->setAdminCommissionPercentage($this->getRequest()->getParam('admin_commission_percentage', false));
                        
                Mage::dispatchEvent('vendor_profile_save_before', array('profile' => $profile, 'post_data' => $this->getRequest()->getPost()));
                        
				$profile->save();
            }
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The account has been saved.'));
        } catch (Mage_Core_Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('An error occurred while saving account.'));
        }
        $this->getResponse()->setRedirect($this->getUrl("*/*/"));
    }
}

?>
