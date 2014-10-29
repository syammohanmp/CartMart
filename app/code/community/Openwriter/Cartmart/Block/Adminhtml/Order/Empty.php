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
class OpenWriter_Cartmart_Block_Adminhtml_Order_Empty extends Mage_Core_Block_Template
{
    protected function _prepareLayout()
    {
        $this->setTemplate('marketplace/sales/order/empty.phtml');
        return parent::_prepareLayout();
    }
    
    public function getSalesOrderUrl()
    {
        return $this->getUrl('adminhtml/sales_order/index', array('_current' => true));
    }
}
?>
