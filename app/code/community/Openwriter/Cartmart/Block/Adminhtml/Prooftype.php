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
class OpenWriter_Cartmart_Block_Adminhtml_Prooftype extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{		
		$this->_controller = 'adminhtml_prooftype';
		$this->_blockGroup = 'marketplace';
		$this->_headerText = Mage::helper('cartmart')->__('Manage Types');
		$this->_addButtonLabel = Mage::helper('cartmart')->__('Add Type');
		
		parent::__construct();
	}
}
?>
