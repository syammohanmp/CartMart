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
class Medma_MarketPlace_Block_Adminhtml_Prooftype_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $form = new Varien_Data_Form(
			array(
				'id' => 'edit_form',
				'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
				'method' => 'post',
			)
        );

        $form->setUseContainer(true);

        $this->setForm($form);

        $model = Mage::registry('type_data');

        $fieldset = $form->addFieldset('type_form', array('legend' => 'General'));

        $fieldset->addField('name', 'text', array(
            'name' => 'name',
            'required' => true,
            'label' => Mage::helper('adminhtml')->__('Name'),
            'title' => Mage::helper('adminhtml')->__('Name'),            
        ));       

        $fieldset->addField('status', 'select', array(
            'name' => 'status',
            'required' => true,
            'label' => Mage::helper('adminhtml')->__('Status'),
            'title' => Mage::helper('adminhtml')->__('Status'),
            'values' => array('1' => 'Enabled', '0' => 'Disabled'),
            'value' => '1',
            'style' => 'width: 100px',
        ));

        if ($model) {
            $form->addValues($model->getData());
        }
        return parent::_prepareForm();
    }

}

?>
