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
class Medma_MarketPlace_RatingController extends Mage_Core_Controller_Front_Action
{
	public function saveAction()
	{
		$postData = $this->getRequest()->getPost();
		
		$invoice_item_id = $this->getRequest()->getParam('invoice_item_id');
		
		if(isset($postData['title']))
		{
			$reviewModel = Mage::getModel('marketplace/review')
					->setData($postData)
					->setInvoiceItemId($invoice_item_id)
					->setPostedDate(Mage::getModel('core/date')->timestamp(time()))
					->setStatus(Medma_MarketPlace_Model_Review::PENDING)
					->save();
		}
		
		if(count($postData['ratings']) > 0)
		{		
			foreach($postData['ratings'] as $key => $value)
			{
				Mage::getModel('marketplace/rate')
					->setRatingId($key)
					->setInvoiceItemId($invoice_item_id)
					->setValue($value)
					->save();
			}
		}		
		
		if(isset($postData['title']) || count($postData['ratings']) > 0)
			Mage::getSingleton('core/session')->addSuccess('Feedback has been submitted successfully.'); 
		else
			Mage::getSingleton('core/session')->addNotice('Please enter proper values to submit feedback.'); 
			
		$this->_redirect('sales/order/view', array('order_id' => $this->getRequest()->getParam('order_id')));
	}
}

?>
