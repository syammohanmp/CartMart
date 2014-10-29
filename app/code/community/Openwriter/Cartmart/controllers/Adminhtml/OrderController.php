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
class Openwriter_Cartmart_Adminhtml_OrderController extends Mage_Adminhtml_Controller_action {

    public function indexAction() {

		$roleId = Mage::helper('cartmart')->getConfig('general', 'vendor_role');
		
        // $role = Mage::getModel('admin/roles')->load($roleId);

        $current_user = Mage::getSingleton('admin/session')->getUser();

        if ($current_user->getRole()->getRoleId() != $roleId) {
            $this->_forward('empty');
            return;
        }

        $this->loadLayout()->_setActiveMenu('vendor/orders');
        $this->_addContent($this->getLayout()->createBlock('cartmart/adminhtml_order'));
        $this->renderLayout();
    }

    public function emptyAction() {
        $this->loadLayout()->_setActiveMenu('vendor/orders');
        $this->_addContent($this->getLayout()->createBlock('cartmart/adminhtml_order_empty'));
        $this->renderLayout();
    }

    public function viewAction() {
        $id = $this->getRequest()->getParam('order_id');

        if ($id != 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            Mage::register('current_order', Mage::getModel('sales/order')->load($id));

            $this->loadLayout()->_setActiveMenu('vendor/orders');
            $this->_addContent($this->getLayout()->createBlock('cartmart/adminhtml_order_form'));
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cartmart')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function shipAction() {
        try {
            $orderId = $this->getRequest()->getParam('order_id');
            $order = Mage::getModel('sales/order')->load($orderId);
            $convertor = Mage::getModel('sales/convert_order');
            $shipment = $convertor->toShipment($order);

            $productIds = $this->getProductIdsCollection();
            $current_user = Mage::getSingleton('admin/session')->getUser()->getName();

            $current_user_id = Mage::getSingleton('admin/session')->getUser()->getId();

            $profile = Mage::getModel('cartmart/profile')->getCollection()->addFieldToFilter('user_id', $current_user_id)->getFirstItem();
            $admin_commission_percentage = $profile->getAdminCommissionPercentage();

            $total_admin_commission = $profile->getData('total_admin_commission');
            $total_vendor_amount = $profile->getData('total_vendor_amount');
            $vendor_amount = 0;

            foreach ($order->getAllItems() as $orderItem) {
                if (!$orderItem->getQtyToShip())
                    continue;
                if ($orderItem->getIsVirtual())
                    continue;

                if (!in_array($orderItem->getProductId(), $productIds))
                    continue;

                $item = $convertor->itemToShipmentItem($orderItem);
                $qty = $orderItem->getQtyToShip();
                $item->setQty($qty);
                $shipment->addItem($item);

                $total_price = ($orderItem->getPriceInclTax() * $orderItem->getQtyOrdered());
                $total_commission = ($total_price * $admin_commission_percentage) / 100;
                $total_admin_commission += $total_commission;
                $total_vendor_amount += ($total_price - $total_commission);
                $vendor_amount += ($total_price - $total_commission);
            }
                    
            $transactionCollection = Mage::getModel('cartmart/transaction')
				->getCollection()
				->addFieldToFilter('order_number', $order->getIncrementId())
				->addFieldToFilter('vendor_id', $current_user_id);
				
			if($transactionCollection->count() == 0)
			{
				$profile->setData('total_admin_commission', $total_admin_commission)
                    ->setData('total_vendor_amount', $total_vendor_amount)
                    ->save();
                    
				$transaction = Mage::getModel('cartmart/transaction');
				$transaction->setData('vendor_id', $current_user_id)
					->setData('transaction_date', date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time())))
					->setData('order_number', $order->getIncrementId())
					->setData('information', 'Order')
					->setData('amount', $vendor_amount)
					->setData('type', Openwriter_Cartmart_Model_Transaction::CREDIT)
					->save();
			}
			
            $shipment->register();
            $email = false;
            $includeComment = true;
            $comment = 'Order Shipped By Vendor - ' . $current_user;

            $shipment->addComment($comment, $email && $includeComment);
            $shipment->getOrder()->setIsInProcess(true);

            $transactionSave = Mage::getModel('core/resource_transaction')
                    ->addObject($shipment)
                    ->addObject($shipment->getOrder())
                    ->save();

            $order->addStatusToHistory($order->getStatus(), 'Order Shipped By Vendor ' . $current_user, false);

            $shipment->save();

            $shipment->sendEmail(true);
            $shipment->setEmailSent(true);
            $shipment->save();

            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('cartmart')->__('The Shipment has been created.'));
            $this->_redirect('*/*/view', array('order_id' => $orderId));
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cartmart')->__('The Shipment cannot be created for the order.'));
            $this->_redirect('*/*/view', array('order_id' => $orderId));
        }
    }

    public function invoiceAction() {
        try {
            $productIds = $this->getProductIdsCollection();
            $current_user = Mage::getSingleton('admin/session')->getUser()->getName();

            $orderId = $this->getRequest()->getParam('order_id');
            $order = Mage::getModel('sales/order')->load($orderId);

            $items = $order->getItemsCollection();
            $invoice_quentities = array();

            foreach ($items as $item) {
                $qty_to_invoice = $item->getQtyOrdered();
                if (!in_array($item->getProductId(), $productIds))
                    $qty_to_invoice = 0;

                $invoice_quentities[$item->getId()] = $qty_to_invoice;
            }

            $invoice = Mage::getModel('sales/service_order', $order)->prepareInvoice($invoice_quentities);

            $amount = $invoice->getGrandTotal();
            $invoice->register()->pay();
            $invoice->getOrder()->setIsInProcess(true);

            $history = $invoice->getOrder()->addStatusHistoryComment(
                    'Partial amount of $' . $amount . ' captured automatically.', false
            );

            $history->setIsCustomerNotified(true);

            $order->save();

            Mage::getModel('core/resource_transaction')
                    ->addObject($invoice)
                    ->addObject($invoice->getOrder())
                    ->save();

            $order->addStatusToHistory($order->getStatus(), 'Order Invoice Created By Vendor ' . $current_user, false);

            $invoice->save();

            $invoice->sendEmail(true);

            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('cartmart')->__('The Invoice has been created.'));

            $this->_redirect('*/*/view', array('order_id' => $orderId));
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cartmart')->__('The Invoice cannot be created for the order.'));
            $this->_redirect('*/*/view', array('order_id' => $orderId));
        }
    }

    public function getProductIdsCollection() {
        $roleId = Mage::helper('cartmart')->getConfig('general', 'vendor_role');
		
        // $role = Mage::getModel('admin/roles')->load($roleId);

        $current_user = Mage::getSingleton('admin/session')->getUser();

        $collection = Mage::getModel('catalog/product')->getCollection()
                ->addAttributeToFilter('status', 1);

        if ($current_user->getRole()->getRoleId() == $roleId)
            $collection->addAttributeToFilter('vendor', $current_user->getId());

        return $collection->getAllIds();
    }

}

?>
