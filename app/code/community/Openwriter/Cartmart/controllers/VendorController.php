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
class OpenWriter_Cartmart_VendorController extends Mage_Core_Controller_Front_Action
{
	public function registerAction()
	{
		$this->loadLayout();
		$this->renderLayout();
	}
	
	public function profileAction()
	{
		$vendorId = $this->getRequest()->getParam('id');
		$this->loadLayout();
		$this->renderLayout();
	}
	
	public function itemsAction()
	{		
		$this->loadLayout();
		$this->renderLayout();
	}
	
	public function saveAction()
	{
		if ($data = $this->getRequest()->getPost()) 
		{
            try 
            {				
				$total_file_upload = $this->getRequest()->getParam('total_file_upload', false);
				
				$uploaded_files = array();
				for($i = 1; $i <= $total_file_upload; $i++)
				{
					$file_control_name = 'varification_proof_' . $i;					
					
					if (isset($_FILES[$file_control_name]['name']) && $_FILES[$file_control_name]['name'] != '') 
					{
						$uploader = new Varien_File_Uploader($file_control_name);
						$uploader->setAllowedExtensions(array('jpg', 'jpeg', 'pdf', 'png'));

						$uploader->setAllowRenameFiles(false);
						$uploader->setFilesDispersion(false);

						$dir_name = 'vendor' . DS . 'varifications';
						$dir_path = Mage::helper('cartmart')->getImagesDir($dir_name);

						$uploader->save($dir_path, $_FILES[$file_control_name]['name']);
						$uploaded_files[] = $_FILES[$file_control_name]['name'];
					}				
				}
				
				$user = Mage::getModel("admin/user");

				$user->setUsername($this->getRequest()->getParam('username', false))
					->setFirstname($this->getRequest()->getParam('firstname', false))
					->setLastname($this->getRequest()->getParam('lastname', false))
					->setPassword($this->getRequest()->getParam('password', false))
					->setEmail(strtolower($this->getRequest()->getParam('email', false)))
					->setIsActive(0);

				if ($this->getRequest()->getParam('password', false)) {
					$user->setNewPassword($this->getRequest()->getParam('password', false));
				}

				if ($this->getRequest()->getParam('confirmation', false)) {
					$user->setPasswordConfirmation($this->getRequest()->getParam('confirmation', false));
				}
				
				$result = $user->validate();
				if (is_array($result)) {
					foreach($result as $error) {
						Mage::getSingleton('core/session')->addError($error);
					}
					Mage::getSingleton('core/session')->setTestData($data);
					$this->_redirect('*/*/register');
					return;
				}
                
                $user->save();
				
				$role_id = Mage::helper('cartmart')->getConfig('general', 'vendor_role');

                $user->setRoleIds(array($role_id))
					->setRoleUserId($user->getUserId())
					->saveRelations();

                $user->save();
                
                $profile = Mage::getModel('marketplace/profile')
					->setTotalAdminCommission(0)
					->setTotalVendorAmount(0)
					->setTotalVendorPaid(0);                
                        
                $profile->setUserId($user->getUserId())
					->setShopName($this->getRequest()->getParam('shop_name', false))						
					->setContactNumber($this->getRequest()->getParam('contact_number', false))
					->setCountry($this->getRequest()->getParam('country', false))                        
					->setProofType($this->getRequest()->getParam('proof_type', false))
					->setVarificationFiles(json_encode($uploaded_files))
					->save();
                
                Mage::getSingleton('core/session')
                        ->addSuccess('Request has been sent successfully, we will contact you soon.');
                        
                $this->_redirect('*/*/register');
                return;	
			} catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')
                        ->addError($e->getMessage());     
				Mage::getSingleton('core/session')->setTestData($data);
                $this->_redirect('*/*/register');
                return;
            }
		}
	}
}

?>
