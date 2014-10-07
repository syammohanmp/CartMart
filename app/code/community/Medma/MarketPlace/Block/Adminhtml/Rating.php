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
class Medma_MarketPlace_Block_Adminhtml_Rating extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{		
		$this->_controller = 'adminhtml_rating';
		$this->_blockGroup = 'marketplace';
		$this->_headerText = Mage::helper('marketplace')->__('Manage Ratings');
		$this->_addButtonLabel = Mage::helper('marketplace')->__('Add Rating');
		
		parent::__construct();
	}
}
?>
