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
class Openwriter_Cartmart_Block_Adminhtml_Rating_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

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

        $model = Mage::registry('rating_data');

        $fieldset = $form->addFieldset('rating_form', array('legend' => 'General'));

        $fieldset->addField('name', 'text', array(
            'name' => 'name',
            'required' => true,
            'label' => Mage::helper('adminhtml')->__('Name'),
            'title' => Mage::helper('adminhtml')->__('Name'),            
        ));

        $fieldset->addField('sort_order', 'text', array(
            'name' => 'sort_order',
            'required' => true,
            'label' => Mage::helper('adminhtml')->__('Sort Order'),
            'title' => Mage::helper('adminhtml')->__('Sort Order'),
            'class' => 'validate-number',
            'style' => 'width:50px',
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
