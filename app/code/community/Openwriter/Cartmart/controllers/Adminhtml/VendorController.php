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
class Openwriter_Cartmart_Adminhtml_VendorController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {
        $this->loadLayout()->_setActiveMenu('openwriter/cartmart/manage_vendors');
        return $this;
    }

    public function indexAction() {
        $this->_initAction();
        $this->_addContent($this->getLayout()->createBlock('cartmart/adminhtml_vendor'));
        $this->renderLayout();
    }

    public function editAction() {
        $testId = $this->getRequest()->getParam('id');
        $testModel = Mage::getModel('admin/user')->load($testId);
        $generalEmail = Mage::getStoreConfig('trans_email/ident_general/email');
        $domainName = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
        if ($testModel->getId() || $testId == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getUserData(true);
            if (!empty($data)) {
                $testModel->setData($data);
            }
            Mage::register('vendor_user', $testModel);
            $this->loadLayout();
            $this->_setActiveMenu('openwriter/cartmart/manage_vendors');
            $this->_addBreadcrumb('Vendor Manager', 'Vendor Manager');
            $this->_addBreadcrumb('Vendor Description', 'Vendor Description');
            $this->getLayout()->getBlock('head')
                    ->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()
                            ->createBlock('cartmart/adminhtml_vendor_edit'))
                    ->_addLeft($this->getLayout()
                            ->createBlock('cartmart/adminhtml_vendor_edit_tabs')
            );
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')
                    ->addError('Vendor does not exist');
            $this->_redirect('*/*/');
        }
        
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function saveAction() {

        if ($data = $this->getRequest()->getPost()) {
            try {
                $model = Mage::getModel('admin/user');

                $model->setUserId($this->getRequest()->getParam('id'))
                        ->setData($data);                

                if ($model->hasNewPassword() && $model->getNewPassword() === '') {
                    $model->unsNewPassword();
                }
                if ($model->hasPasswordConfirmation() && $model->getPasswordConfirmation() === '') {
                    $model->unsPasswordConfirmation();
                }                

                $result = $model->validate();

                if (is_array($result)) {
                    Mage::getSingleton('adminhtml/session')->setUserData($data);
                    foreach ($result as $message) {
                        Mage::getSingleton('adminhtml/session')->addError($message);
                    }
                    $this->_redirect('*/*/edit', array('_current' => true));
                    return $this;
                }

                $model->save();

                $role_id = Mage::helper('cartmart')->getConfig('general', 'vendor_role');

                $model->setRoleIds(array($role_id))
                        ->setRoleUserId($model->getUserId())
                        ->saveRelations();

                $model->save();

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

                $profileCollection = Mage::getModel('cartmart/profile')
                        ->getCollection()
                        ->addFieldToFilter('user_id', $model->getUserId());

                if ($profileCollection->count() > 0)
                    $profile = Mage::getModel('cartmart/profile')->load($profileCollection->getFirstItem()->getId());
                else
                    $profile = Mage::getModel('cartmart/profile')
                            ->setTotalAdminCommission(0)
                            ->setTotalVendorAmount(0)
                            ->setTotalVendorPaid(0);

                if (!is_null($image))
                    $profile->setImage($image);

                $profile->setUserId($model->getUserId())
						->setShopName($this->getRequest()->getParam('shop_name', false))
						->setMessage($this->getRequest()->getParam('message', false))
						->setContactNumber($this->getRequest()->getParam('contact_number', false))
						->setCountry($this->getRequest()->getParam('country', false))						
                        ->setAdminCommissionPercentage($this->getRequest()->getParam('admin_commission_percentage', false));
				
				$profileOrder = $this->getRequest()->getParam('profile_order', false);
                if(!empty($profileOrder)){$profile->setProfileOrder($profileOrder);}

                $featured = $this->getRequest()->getParam('featured');
                if(in_array($featured,array('0','1'))){$profile->setFeatured($featured);}
                        
                Mage::dispatchEvent('vendor_profile_save_before', array('profile' => $profile, 'post_data' => $this->getRequest()->getPost()));
                
				$profile->save();
                        
                $proofList = Mage::helper('cartmart')->getVarificationProofTypeList();
                if(count($proofList) > 1)
					$profile->setProofType($this->getRequest()->getParam('proof_type', false))->save();

                Mage::getSingleton('adminhtml/session')
                        ->addSuccess('Vendor has been saved.');
                Mage::getSingleton('adminhtml/session')
                        ->settestData(false);
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')
                        ->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')
                        ->settestData($this->getRequest()
                                ->getPost()
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()
                            ->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction() {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $testModel = Mage::getModel('admin/user');
                $testModel->setId($this->getRequest()
                                ->getParam('id'))
                        ->delete();
                Mage::getSingleton('adminhtml/session')
                        ->addSuccess('Vendor has been deleted.');
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')
                        ->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

}

?>
