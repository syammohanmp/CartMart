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
class Medma_MarketPlace_Adminhtml_TransactionController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {
        $this->loadLayout()->_setActiveMenu('medma/marketplace/manage_vendors');
        return $this;
    }
    
    public function vendorAction()
    {         
        $roleId = Mage::helper('marketplace')->getConfig('general', 'vendor_role');
		
        // $role = Mage::getModel('admin/roles')->load($roleId);

        $current_user = Mage::getSingleton('admin/session')->getUser();

        if ($current_user->getRole()->getRoleId() != $roleId) {
            $this->_forward('empty');
            return;
        }
        
        Mage::register('vendor_user', $current_user);

        $this->loadLayout()->_setActiveMenu('vendor/orders');
        $this->_addContent($this->getLayout()->createBlock('marketplace/adminhtml_transaction'));
        $this->renderLayout();
    }

    public function emptyAction() {
        $this->loadLayout()->_setActiveMenu('vendor/orders');
        $this->_addContent($this->getLayout()->createBlock('marketplace/adminhtml_transaction_empty'));
        $this->renderLayout();
    }

    public function indexAction() {
        $vendor_id = $this->getRequest()->getParam('id');
        $transactionCollection = Mage::getModel('marketplace/transaction')->getCollection()->addFieldToFilter('vendor_id', $vendor_id);
        $testModel = Mage::getModel('admin/user')->load($vendor_id);

        if ($transactionCollection->count() > 0) {
            $data = Mage::getSingleton('adminhtml/session')->getUserData(true);
            Mage::register('vendor_user', $testModel);
            $this->loadLayout();
            $this->_setActiveMenu('medma/marketplace/manage_vendors');
            $this->_addBreadcrumb('Vendor Manager', 'Vendor Manager');
            $this->_addBreadcrumb('Vendor Description', 'Vendor Description');
            $this->getLayout()->getBlock('head')
                    ->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()
                            ->createBlock('marketplace/adminhtml_transaction'));
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')
                    ->addNotice('Transaction(s) not found');
            $this->_redirect('*/adminhtml_vendor/');
        }
    }

    public function newAction() {
        $vendor_id = $this->getRequest()->getParam('vendor_id');
        $testModel = Mage::getModel('admin/user')->load($vendor_id);
        Mage::register('vendor_user', $testModel);

        $profileModel = Mage::getModel('marketplace/profile')->getCollection()->addFieldToFilter('user_id', $vendor_id)->getFirstItem();
        Mage::register('vendor_profile', $profileModel);

        $this->loadLayout();
        $this->_setActiveMenu('medma/marketplace/manage_vendors');
        $this->_addBreadcrumb('Transaction Manager', 'Transaction Manager');
        $this->_addBreadcrumb('Transaction Description', 'Transaction Description');
        $this->getLayout()->getBlock('head')
                ->setCanLoadExtJs(true);
        $this->_addContent($this->getLayout()
                        ->createBlock('marketplace/adminhtml_transaction_edit'))
                ->_addLeft($this->getLayout()
                        ->createBlock('marketplace/adminhtml_transaction_edit_tabs')
        );
        $this->renderLayout();
    }

    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {
            try {
                $vendor_id = $this->getRequest()->getParam('vendor_id');
                $postData = $this->getRequest()->getPost();

                $profileModel = Mage::getModel('marketplace/profile')->getCollection()->addFieldToFilter('user_id', $vendor_id)->getFirstItem();
                $remaining_amount = ($profileModel->getTotalVendorAmount() - $profileModel->getTotalVendorPaid());

                if ($remaining_amount < $postData['amount']) {
                    $remaining_amount = Mage::helper('core')->currency($remaining_amount, true, false);

                    Mage::getSingleton('adminhtml/session')
                            ->addError('You can not transfer more then ' . $remaining_amount);

                    Mage::getSingleton('adminhtml/session')->setAmount($postData['amount']);

                    $this->_redirect('*/*/new', array('vendor_id' => $this->getRequest()
                                ->getParam('vendor_id')));
                    return;
                }

                $amount_paid = $profileModel->getTotalVendorPaid();
                $amount_paid += floatval($postData['amount']);

                $profileModel->setData('total_vendor_paid', $amount_paid)
                        ->save();

                $transaction = Mage::getModel('marketplace/transaction');
                $transaction->setData('vendor_id', $vendor_id)
                        ->setData('transaction_date', date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time())))
                        ->setData('order_number', '')
                        ->setData('information', $data['information'])
                        ->setData('amount', $postData['amount'])
                        ->setData('type', Medma_MarketPlace_Model_Transaction::DEBIT)
                        ->save();
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')
                        ->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')
                        ->settestData($this->getRequest()
                                ->getPost()
                );
                $this->_redirect('*/*/new', array('vendor_id' => $this->getRequest()
                            ->getParam('vendor_id')));
                return;
            }
        }

        $this->_redirect('*/*/', array('id' => $this->getRequest()->getParam('vendor_id')));
    }

}

?>
