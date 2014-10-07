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
class Medma_MarketPlace_Block_Adminhtml_Transaction_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {
        parent::__construct();
        $this->_objectId = 'user_id';
        $this->_blockGroup = 'marketplace';
        $this->_controller = 'adminhtml_transaction';
        $this->_updateButton('save', 'label', 'Save Transaction');
        $this->_updateButton('delete', 'label', 'Delete Transaction');

        $data = array(
            'label' => 'Back',
            'onclick' => 'setLocation(\'' . $this->getUrl('*/*/index', array('id' => Mage::registry('vendor_user')->getId())) . '\')',
            'class' => 'back'
        );
        $this->addButton('my_back', $data, 0, 0, 'header');

        $this->_removeButton('back');
        $this->_removeButton('reset');
    }

    public function getHeaderText() {
        return Mage::helper('adminhtml')->__('New Transaction');
    }

}

?>
