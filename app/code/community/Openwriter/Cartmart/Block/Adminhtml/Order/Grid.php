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
class Openwriter_Cartmart_Block_Adminhtml_Order_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('orderGrid');
        $this->setDefaultSort('id');
    }

    protected function _prepareCollection() {
        $roleId = Mage::helper('cartmart')->getConfig('general', 'vendor_role');
		
        // $role = Mage::getModel('admin/roles')->load($roleId);

        $current_user = Mage::getSingleton('admin/session')->getUser();

        if ($current_user->getRole()->getRoleId() == $roleId) {
            $productIds = Mage::getModel('catalog/product')->getCollection()
                            ->addAttributeToFilter('status', 1)
                            ->addAttributeToFilter('vendor', $current_user->getId())->getAllIds();

            $collection = Mage::getResourceModel($this->_getCollectionClass());

            foreach ($collection as $order) {
                foreach ($order->getAllItems() as $item) {
                    $productId = $item->getData('product_id');
                    if (in_array($productId, $productIds)) {
                        $orderIds[] = $order->getId();
                        break;
                    }
                }
            }

            $collection = Mage::getResourceModel($this->_getCollectionClass())
                    ->addFieldToFilter('entity_id', array('in' => $orderIds));
        }
        else
            $collection = Mage::getResourceModel($this->_getCollectionClass());

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _getCollectionClass() {
        return 'sales/order_grid_collection';
    }

    protected function _prepareColumns() {
        $hlp = Mage::helper('cartmart');

        $this->getIndex();

        $this->addColumn('increment_id', array(
            'header' => $hlp->__('Order #'),
            'align' => 'right',
            'width' => '80px',
            'index' => 'increment_id',
        ));

        $this->addColumn('created_at', array(
            'header' => $hlp->__('Purchased On'),
            'index' => 'created_at',
            'type' => 'datetime',
            'width' => '100px',
        ));

        $this->addColumn('billing_name', array(
            'header' => $hlp->__('Bill to Name'),
            'index' => 'billing_name',
            'width' => '400px',
        ));

        $this->addColumn('shipping_name', array(
            'header' => $hlp->__('Ship to Name'),
            'index' => 'shipping_name',
            'width' => '400px',
        ));

        $this->addColumn('status', array(
            'header' => $hlp->__('Status'),
            'index' => 'status',
            'type' => 'options',
            'width' => '70px',
            'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
        ));

        $this->addColumn('action', array(
            'header' => $hlp->__('Action'),
            'width' => '50px',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => $hlp->__('View'),
                    'url' => array('base' => '*/*/view'),
                    'field' => 'order_id'
                )
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
            'is_system' => true,
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row) {
        return $this->getUrl('*/*/view', array('order_id' => $row->getId()));
    }

}

?>
