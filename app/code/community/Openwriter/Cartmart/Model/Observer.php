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

class OpenWriter_Cartmart_Model_Observer
{
	public function catalogProductSaveBefore($observer)
    {		
		$store = Mage::getModel('core/store')->load(Mage_Core_Model_App::DISTRO_STORE_ID);
		$rootId = $store->getRootCategoryId();

		$product = $observer->getProduct();		
		$categoryIds = $product->getCategoryIds();
				
		if(!in_array($rootId, $categoryIds))
		{		
			$categoryIds[] = $rootId;
			$product->setCategoryIds($categoryIds);			
		}
	}
	
	public function notifyVendor($observer)
	{	
		$orderIncrementId = Mage::getSingleton('checkout/session')->getLastRealOrderId();
		$orderObject = Mage::getModel('sales/order')->loadByIncrementId($orderIncrementId);		

		$vars['billing_address'] = $orderObject->getBillingAddress()->format('html');
		$vars['shipping_address'] = $orderObject->getShippingAddress()->format('html');
		$vars['get_is_not_virtual'] = $orderObject->getIsNotVirtual();
		$vars['customer_name'] = $orderObject->getBillingAddress()->getName();
		$vars['order_no'] = $orderIncrementId;		
		
		$head = '<thead style="background:#f9f9f9;">
			<tr>
				<th align="left" bgcolor="#EAEAEA" style="font-size: 13px; padding: 3px 9px;"><strong>Product</strong></th>
				<th align="left" bgcolor="#EAEAEA" style="font-size: 13px; padding: 3px 9px;"><strong><span>Original Price</span></strong></th>
				<th align="left" bgcolor="#EAEAEA" style="font-size: 13px; padding: 3px 9px;"><strong>Price</strong></th>
				<th align="left" bgcolor="#EAEAEA" style="font-size: 13px; padding: 3px 9px;"><strong>Qty</strong></th>
				<th align="left" bgcolor="#EAEAEA" style="font-size: 13px; padding: 3px 9px;"><strong><span>Row Total</strong></span></th>
			</tr>
		</thead>';
		
		$orderItems = $orderObject->getAllItems();
		$orderDetails = array();
		foreach($orderItems as $item)
		{
			$attribute = '';
			if($options = $item->getProductOptions())
			{
				foreach ($options['attributes_info'] as $option)
					$attribute .='<div><strong>' . $option['label'] . ':</strong> ' . $option['value'] . '</div>';
			}
						
			$vendorId = Mage::getModel('catalog/product')->load($item->getProductId())->getVendor();
			$vendorModel = Mage::getModel('admin/user')->load($vendorId);
			
			$orderDetails[$vendorId]['vendor_name'] = $vendorModel->getName();
			$orderDetails[$vendorId]['vendor_mail_id'] = $vendorModel->getEmail();
			$orderDetails[$vendorId]['order_items'] .= '<tbody>
				<tr>
					<td align="left" valign="top" style="font-size: 11px; padding: 3px 9px; border-bottom: 1px dotted #CCCCCC;">
						' . $item->getName() . '<br />
						<strong>SKU:</strong> ' . $item->getSku()
						. $attribute .
					'</td>
					<td align="left" valign="top" style="font-size: 11px; padding: 3px 9px; border-bottom: 1px dotted #CCCCCC;">' . Mage::helper('core')->currency($item->getData("price_incl_tax"), true, false) . '</td>
					<td align="left" valign="top" style="font-size: 11px; padding: 3px 9px; border-bottom: 1px dotted #CCCCCC;">' . Mage::helper('core')->currency($item->getOriginalPrice(), true, false) . '</td>
					<td align="left" valign="top" style="font-size: 11px; padding: 3px 9px; border-bottom: 1px dotted #CCCCCC;">' . intval($item->getQtyOrdered()) . '</td>
					<td align="left" valign="top" style="font-size: 11px; padding: 3px 9px; border-bottom: 1px dotted #CCCCCC;">' . Mage::helper('core')->currency($item->getData("row_total_incl_tax"), true, false) . '</td>
				</tr>
			</tbody>';			
		}
		
		foreach($orderDetails as $key => $value) 
		{
			$vendorOrder = '<table cellspacing="0" cellpadding="0" border="0" width="650" style="border: 1px solid #EAEAEA;">';
			$vendorOrder .= $head;
			$vendorOrder .= $value['order_items'];
			$vendorOrder .= '</table>';
			
			$vars['sales_email_order_items'] = $vendorOrder;
			$vars['vendor_name'] = $value['vendor_name'];			
			$this->sendTransactionalEmail($value['vendor_mail_id'], $vars);
		}
	}
	
	public function sendTransactionalEmail($email, $vars)
	{
		// Transactional Email Template's ID
		$templateId = Mage::getStoreConfig('marketplace/email/email_template');		
		
		// Set sender information
		$senderInfo = Mage::getStoreConfig('marketplace/email/email_sender');		
		$senderName = Mage::getStoreConfig('trans_email/ident_'.$senderInfo.'/name');
		$senderEmail = Mage::getStoreConfig('trans_email/ident_'.$senderInfo.'/email');
	  
		$sender = array('name'  => $senderName,	'email' => $senderEmail);
				
		// Set recepient information
		$recepientEmail = $email;
		
		// Get Store ID
		$storeId = Mage::app()->getStore()->getId();
		
		$translate  = Mage::getSingleton('core/translate');
		
		// Send Transactional Email
		Mage::getModel('core/email_template')
		->sendTransactional($templateId, $sender, $recepientEmail, $email,$vars, $storeId);
		
		$translate->setTranslateInline(true);
	}
}

?>
