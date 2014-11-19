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
class Openwriter_Cartmart_Block_Adminhtml_Vendor_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('vendorGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
		
		$roleId = Mage::helper('cartmart')->getConfig('general', 'vendor_role');
		
        $role = Mage::getModel('admin/roles')->load($roleId);

        $userIds = Mage::getResourceModel('admin/roles')->getRoleUsers($role);

        $collection = Mage::getModel('admin/user')
                ->getCollection()
                ->addFieldToFilter('user_id', array('in' => $userIds));

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn('user_id', array(
            'header' => Mage::helper('adminhtml')->__('ID'),
            'width' => 5,
            'align' => 'right',
            'sortable' => true,
            'index' => 'user_id'
        ));

        $this->addColumn('username', array(
            'header' => Mage::helper('adminhtml')->__('User Name'),
            'index' => 'username'
        ));

        $this->addColumn('firstname', array(
            'header' => Mage::helper('adminhtml')->__('First Name'),
            'index' => 'firstname'
        ));

        $this->addColumn('lastname', array(
            'header' => Mage::helper('adminhtml')->__('Last Name'),
            'index' => 'lastname'
        ));

        $this->addColumn('email', array(
            'header' => Mage::helper('adminhtml')->__('Email'),            
            'align' => 'left',
            'index' => 'email'
        ));

        $this->addColumn('is_active', array(
            'header' => Mage::helper('adminhtml')->__('Status'),
            'index' => 'is_active',
            'type' => 'options',
            'options' => array('1' => Mage::helper('adminhtml')->__('Active'), '0' => Mage::helper('adminhtml')->__('Inactive')),
        ));

        $this->addColumn('action', array(
            'header' => Mage::helper('adminhtml')->__('Action'),
            'width' => '100',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('adminhtml')->__('Balance Sheet'),
                    'url' => array('base' => '*/adminhtml_transaction/index'),
                    'field' => 'id'
                )
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
            'is_system' => true,
        ));

        return parent::_prepareColumns();
    }

    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}

?>
