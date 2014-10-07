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
class Medma_MarketPlace_Block_Adminhtml_Transaction_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $profile = Mage::registry('vendor_profile');
        $remaining_amount = ($profile->getTotalVendorAmount() - $profile->getTotalVendorPaid());
        $remaining_amount = Mage::helper('core')->currency($remaining_amount, true, false);

        $form = new Varien_Data_Form(
                        array(
                            'id' => 'edit_form',
                            'action' => $this->getUrl('*/*/save', array('vendor_id' => $profile->getData('user_id'))),
                            'method' => 'post',
                        )
        );

        $form->setUseContainer(true);

        $this->setForm($form);

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('adminhtml')->__('Transaction Information')));

        $fieldset->addField('Information', 'note', array(
            'text' => Mage::helper('adminhtml')->__('You can not transfer more then ') . '<b>' . $remaining_amount . '</b>',
        ));

        $fieldset->addField('information', 'select', array(
            'name' => 'information',
            'label' => Mage::helper('adminhtml')->__('Method'),
            'id' => 'information',
            'title' => Mage::helper('adminhtml')->__('Method'),
            'required' => true,
            'class' => 'input-select',
            'options' => array('Cash' => Mage::helper('adminhtml')->__('Cash'), 'Check' => Mage::helper('adminhtml')->__('Check')),
        ));

        $fieldset->addField('amount', 'text', array(
            'name' => 'amount',
            'label' => Mage::helper('adminhtml')->__('Amount'),
            'id' => 'amount',
            'title' => Mage::helper('adminhtml')->__('Amount'),
            'class' => 'required-entry validate-number',
            'required' => true,
            'value' => Mage::getSingleton('adminhtml/session')->getAmount(),
        ));

        Mage::getSingleton('adminhtml/session')->unsAmount();

        $this->setForm($form);

        return parent::_prepareForm();
    }

}

?>
