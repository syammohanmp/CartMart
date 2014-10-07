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
class Medma_MarketPlace_Block_Adminhtml_Vendor_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $model = Mage::registry('vendor_user');

        $profileCollection = Mage::getModel('marketplace/profile')
                        ->getCollection()->addFieldToFilter('user_id', $this->getRequest()->getParam('id'));

        $profile = Mage::getModel('marketplace/profile');
        if ($profileCollection->count() > 0)
            $profile->load($profileCollection->getFirstItem()->getId());
       
        $form = new Varien_Data_Form(
                        array(
                            'id' => 'edit_form',
                            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))
                            ),
                            'method' => 'post',
                            'enctype' => 'multipart/form-data'
                        )
        );

        $form->setUseContainer(true);

        $this->setForm($form);

        $form->setHtmlIdPrefix('user_');

        $base_fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('adminhtml')->__('Account Information')));

        if ($model->getUserId()) {
            $base_fieldset->addField('user_id', 'hidden', array(
                'name' => 'user_id',
            ));
        } else {
            if (!$model->hasData('is_active')) {
                $model->setIsActive(1);
            }
        }        

        $base_fieldset->addField('username', 'text', array(
            'name' => 'username',
            'label' => Mage::helper('adminhtml')->__('User Name'),
            'id' => 'username',
            'title' => Mage::helper('adminhtml')->__('User Name'),
            'required' => true,
        ));

        $base_fieldset->addField('firstname', 'text', array(
            'name' => 'firstname',
            'label' => Mage::helper('adminhtml')->__('First Name'),
            'id' => 'firstname',
            'title' => Mage::helper('adminhtml')->__('First Name'),
            'required' => true,
        ));

        $base_fieldset->addField('lastname', 'text', array(
            'name' => 'lastname',
            'label' => Mage::helper('adminhtml')->__('Last Name'),
            'id' => 'lastname',
            'title' => Mage::helper('adminhtml')->__('Last Name'),
            'required' => true,
        ));

        $base_fieldset->addField('email', 'text', array(
            'name' => 'email',
            'label' => Mage::helper('adminhtml')->__('Email'),
            'id' => 'customer_email',
            'title' => Mage::helper('adminhtml')->__('User Email'),
            'class' => 'required-entry validate-email',
            'required' => true,
        ));

        if ($model->getUserId()) {
            $base_fieldset->addField('password', 'password', array(
                'name' => 'new_password',
                'label' => Mage::helper('adminhtml')->__('New Password'),
                'id' => 'new_pass',
                'title' => Mage::helper('adminhtml')->__('New Password'),
                'class' => 'input-text validate-admin-password',
            ));

            $base_fieldset->addField('confirmation', 'password', array(
                'name' => 'confirmation',
                'label' => Mage::helper('adminhtml')->__('Password Confirmation'),
                'id' => 'confirmation',
                'class' => 'input-text validate-cpassword',
            ));
        } else {
            $base_fieldset->addField('password', 'password', array(
                'name' => 'new_password',
                'label' => Mage::helper('adminhtml')->__('Password'),
                'id' => 'customer_pass',
                'title' => Mage::helper('adminhtml')->__('Password'),
                'class' => 'input-text required-entry validate-admin-password',
                'required' => true,
            ));
            $base_fieldset->addField('confirmation', 'password', array(
                'name' => 'password_confirmation',
                'label' => Mage::helper('adminhtml')->__('Password Confirmation'),
                'id' => 'confirmation',
                'title' => Mage::helper('adminhtml')->__('Password Confirmation'),
                'class' => 'input-text required-entry validate-cpassword',
                'required' => true,
            ));
        }        

        if (Mage::getSingleton('admin/session')->getUser()->getId() != $model->getUserId()) {
            $base_fieldset->addField('is_active', 'select', array(
                'name' => 'is_active',
                'label' => Mage::helper('adminhtml')->__('This account is'),
                'id' => 'is_active',
                'title' => Mage::helper('adminhtml')->__('Account Status'),
                'class' => 'input-select',
                'style' => 'width: 80px',
                'options' => array('1' => Mage::helper('adminhtml')->__('Active'), '0' => Mage::helper('adminhtml')->__('Inactive')),
            ));
        }

        $base_fieldset->addField('user_roles', 'hidden', array(
            'name' => 'user_roles',
            'id' => '_user_roles',
        ));

        $data = $model->getData();

        unset($data['password']);

        $form->setValues($data);

        $profile_fieldset = $form->addFieldset('profile_fieldset', array('legend' => Mage::helper('adminhtml')->__('Profile Information')));
        
        $profile_fieldset->addField('shop_name', 'text', array(
				'name' => 'shop_name',
				'label' => Mage::helper('adminhtml')->__('Shop Name'),
				'title' => Mage::helper('adminhtml')->__('Shop Name'),
				'required' => true,
				'value' => $profile->getShopName(),
					)
			);
		
		$profile_fieldset->addField('message', 'textarea', array(
				'name' => 'message',
				'label' => Mage::helper('adminhtml')->__('Message'),
				'title' => Mage::helper('adminhtml')->__('Message'),				
				'value' => $profile->getMessage(),
				'style'	=> 'width: 400px; height: 90px;'
					)
			);
			
		$profile_fieldset->addField('contact_number', 'text', array(
				'name' => 'contact_number',
				'label' => Mage::helper('adminhtml')->__('Contact Number'),
				'title' => Mage::helper('adminhtml')->__('Contact Number'),				
				'value' => $profile->getContactNumber(),
				'required' => true,
				'class' => 'validate-phoneLax'
					)
			);
			
		$profile_fieldset->addField('country', 'select', array(
                'name' => 'country',
                'label' => Mage::helper('adminhtml')->__('Country'),                
                'title' => Mage::helper('adminhtml')->__('Country'),
                'class' => 'input-select', 
                'required' => true,
                'value' => $profile->getCountry(),
                'options' => $this->_getCountryList()
            ));
        
        $profile_fieldset->addField('image', 'file', array(
            'name' => 'image',
            'label' => Mage::helper('adminhtml')->__('Profile Picture'),
            'title' => Mage::helper('adminhtml')->__('Profile Picture'),
            'after_element_html' => '<br />' . $this->_getImage($profile->getImage())
        ));
        
        $proofList = Mage::helper('marketplace')->getVarificationProofTypeList();
            
        if(count($proofList) > 1)
        {
			$profile_fieldset->addField('proof_type', 'text', array(
					'name' => 'proof_type',
					'label' => Mage::helper('adminhtml')->__('Proof Type'),                
					'title' => Mage::helper('adminhtml')->__('Proof Type'),
					'value' => $profile->getProofType(),
					'style' => 'display: none;',					
					'after_element_html' => $this->_getFiles($profile->getProofType(), $profile->getVarificationFiles())
				));
        }

        $profile_fieldset->addField('admin_commission_percentage', 'text', array(
            'name' => 'admin_commission_percentage',
            'label' => Mage::helper('adminhtml')->__('Commission (in %)'),
            'title' => Mage::helper('adminhtml')->__('Commission (in %)'),
            'class' => 'validate-number',
            'required' => true,
            'value' => $profile->getAdminCommissionPercentage(),
                )
        );

        $profile_fieldset->addField('total_admin_commission', 'text', array(
            'name' => 'total_admin_commission',
            'label' => Mage::helper('adminhtml')->__('Admin Earnings'),
            'title' => Mage::helper('adminhtml')->__('Admin Earnings'),
            'disabled' => true,
            'style' => 'display:none;',
            'value' => $profile->getTotalAdminCommission(),
            'after_element_html' => '<b>' . $this->formatPrice($profile->getTotalAdminCommission()) . '</b>',
                )
        );

        $profile_fieldset->addField('total_vendor_amount', 'text', array(
            'name' => 'total_vendor_amount',
            'label' => Mage::helper('adminhtml')->__('Vendor Balance'),
            'title' => Mage::helper('adminhtml')->__('Vendor Balance'),
            'disabled' => true,
            'style' => 'display:none;',
            'value' => number_format(($profile->getTotalVendorAmount() - $profile->getTotalVendorPaid()), 4, '.', ''),
            'after_element_html' => '<b>' . $this->formatPrice(($profile->getTotalVendorAmount() - $profile->getTotalVendorPaid())) . '</b>',
                )
        );

        $this->setForm($form);

        return parent::_prepareForm();
    }

    protected function _getImage($image_name) {
        if (!isset($image_name) || $image_name == '')
            return '';
            
		$dir_name = 'vendor' . DS . 'images';
        $dir_path = Mage::helper('marketplace')->getImagesUrl($dir_name);

        $str = '<img width="150" src="' . $dir_path . $image_name . '" alt="" style="margin-top: 10px;" /><input type="hidden" name="old_image" id="old_image" value="' . $image_name . '" />';
        $str .= '<br /><a href="javascript:void(0)" onclick="$(this).previous().remove(); $(this).previous().remove();$(this).previous().remove();$(this).previous().remove();$(this).remove();">Remove</a>';
        return $str;
    }

    protected function formatPrice($price) {
        return Mage::helper('core')->currency($price, true, false);
    }   
    
    protected function _getCountryList()
    {
		$countries[''] = '';
		
		$coutryCollection = Mage::getResourceModel('directory/country_collection')->loadData()->toOptionArray(false);
		
		foreach($coutryCollection as $country)		
			$countries[$country['value']] = $country['label'];		
		
		return $countries;
	}
	
	protected function _getFiles($proofType, $fileList)
	{
		$fileListArray = json_decode($fileList, true);
		$proofTypeModel = Mage::getModel('marketplace/prooftype')->load($proofType);
		$proofName = $proofTypeModel->getName();
		if(isset($proofName))
		{
			$fileString = '<div style="margin: 0 0 1px;"><b>' . $proofName . '</b></div>';
			foreach($fileListArray as $file)
			{
				$dir_name = 'vendor' . DS . 'varifications';
				$dir_url = Mage::helper('marketplace')->getImagesUrl($dir_name);
							
				$fileString .= '<div style="margin: 2px 0 1px;"><a href="' . $dir_url . $file . '" target="_blank">' . $file . '</a></div>';
			}
		}
		else
			$fileString = '<div style=""><b>N/A</b></div>';
		return $fileString;
	}

}

?>
