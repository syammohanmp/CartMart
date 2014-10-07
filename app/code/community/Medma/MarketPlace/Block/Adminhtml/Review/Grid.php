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
class Medma_MarketPlace_Block_Adminhtml_Review_Grid extends Mage_Adminhtml_Block_Widget_Grid {    

    public function __construct() {
        parent::__construct();
        $this->setId('reviewGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }   
    
    protected function _prepareMassaction()
	{
		$this->setMassactionIdField('entity_id');
		$this->getMassactionBlock()->setFormFieldName('review_id');
		$this->getMassactionBlock()->addItem('pending', array(
			'label'=> Mage::helper('core')->__('Pending'),
			'url'  => $this->getUrl('*/*/massPending', array('' => '')),
			'confirm' => Mage::helper('core')->__('Are you sure?')
		));
		$this->getMassactionBlock()->addItem('approve', array(
			'label'=> Mage::helper('core')->__('Approved'),
			'url'  => $this->getUrl('*/*/massApprove', array('' => '')),
			'confirm' => Mage::helper('core')->__('Are you sure?')
		));
		$this->getMassactionBlock()->addItem('cancel', array(
			'label'=> Mage::helper('core')->__('Cancel'),
			'url'  => $this->getUrl('*/*/massCancel', array('' => '')),
			'confirm' => Mage::helper('core')->__('Are you sure?')
		));					
		return $this;
	}

    protected function _prepareCollection() {
        $collection = Mage::getModel('marketplace/review')->getCollection();       
        
        if(Mage::getSingleton('core/session')->getReviewType() == Medma_MarketPlace_Model_Review::PENDING) 
			$collection->addFieldToFilter('status', Medma_MarketPlace_Model_Review::PENDING);
		
		$roleId = Mage::helper('marketplace')->getConfig('general', 'vendor_role');
        $current_user = Mage::getSingleton('admin/session')->getUser();
        if ($current_user->getRole()->getRoleId() == $roleId) 
		{
			$productIds = Mage::getModel('catalog/product')->getCollection()
				->addAttributeToFilter('vendor', $current_user->getId())->getAllIds();
			
			$invoiceItemIds = Mage::getModel('sales/order_invoice_item')->getCollection()
				->addFieldToFilter('product_id', array('in' => $productIds))->getAllIds();
				
			$collection->addFieldToFilter('invoice_item_id', array('in' => $invoiceItemIds));
		}
			
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
		
		$roleId = Mage::helper('marketplace')->getConfig('general', 'vendor_role');
        $current_user = Mage::getSingleton('admin/session')->getUser();
        
        $this->addColumn('entity_id', array(
            'header' => Mage::helper('adminhtml')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'entity_id',
        ));
		
		if ($current_user->getRole()->getRoleId() != $roleId) 
		{
			$this->addColumn('vendor_name', array(
				'header' => Mage::helper('adminhtml')->__('Vendor Name'),
				'align' => 'left',
				'index' => 'invoice_item_id',
				'renderer' => 'Medma_MarketPlace_Block_Adminhtml_Review_Renderer_Vendor'            
			));
        }
        
        $this->addColumn('product_name', array(
            'header' => Mage::helper('adminhtml')->__('Product Name'),
            'align' => 'left',
            'index' => 'invoice_item_id',
            'renderer' => 'Medma_MarketPlace_Block_Adminhtml_Review_Renderer_Product'
        ));
        
        $this->addColumn('title', array(
            'header' => Mage::helper('adminhtml')->__('Title'),
            'align' => 'left',
            'index' => 'title',
        ));
        
        $this->addColumn('summary', array(
            'header' => Mage::helper('adminhtml')->__('Summary'),
            'align' => 'left',
            'index' => 'summary',
        ));        
        
        $this->addColumn('posted_date', array(
            'header' => Mage::helper('adminhtml')->__('Posted Date'),
            'align' => 'left',
            'index' => 'posted_date',
        )); 
        
         $this->addColumn('type', array(
            'header' => Mage::helper('adminhtml')->__('Type'),
            'align' => 'left',
            'index' => 'type',
            'width' => '90px',
            'type' => 'options',
            'options' => array(
                Medma_MarketPlace_Model_Review::POSITIVE => Mage::helper('adminhtml')->__('Positive'), 
				Medma_MarketPlace_Model_Review::NEUTRAL => Mage::helper('adminhtml')->__('Neutral'), 
				Medma_MarketPlace_Model_Review::NEGATIVE => Mage::helper('adminhtml')->__('Negative')
            ),
        ));     

		if(Mage::getSingleton('core/session')->getReviewType() != Medma_MarketPlace_Model_Review::PENDING) 
		{			
			$this->addColumn('status', array(
				'header' => Mage::helper('adminhtml')->__('Status'),
				'align' => 'left',
				'index' => 'status',
				'width' => '90px',
				'type' => 'options',
				'options' => array(
					Medma_MarketPlace_Model_Review::PENDING => Mage::helper('adminhtml')->__('Pending'), 
					Medma_MarketPlace_Model_Review::APPROVED => Mage::helper('adminhtml')->__('Approved'), 
					Medma_MarketPlace_Model_Review::CANCEL => Mage::helper('adminhtml')->__('Cancel')
				),
			));
		}
		
        return parent::_prepareColumns();
    }

    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row) 
    {
		$roleId = Mage::helper('marketplace')->getConfig('general', 'vendor_role');
        $current_user = Mage::getSingleton('admin/session')->getUser();
        
		if ($current_user->getRole()->getRoleId() != $roleId) 
			return $this->getUrl('*/*/edit', array('id' => $row->getId()));		
    }

}

?>
