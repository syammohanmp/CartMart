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
class Medma_MarketPlace_Block_Adminhtml_Review_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {
        parent::__construct();
        $this->_objectId = 'entity_id';
        $this->_blockGroup = 'marketplace';
        $this->_controller = 'adminhtml_review';
        $this->_updateButton('save', 'label', 'Save Review');
        $this->_updateButton('delete', 'label', 'Delete Review');        
    }

    public function getHeaderText() {
        if (Mage::registry('review_data') && Mage::registry('review_data')->getId()) {
            return 'Edit Review';
        } else {
            return 'Add New Review';
        }
    }

}

?>
