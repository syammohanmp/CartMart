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
class Medma_MarketPlace_FavouriteController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		if(!Mage::getSingleton('customer/session')->isLoggedIn()) 
		{
			$this->_redirect('customer/account/login');
			return;			
		}
		
		$this->loadLayout();
		$this->renderLayout();
	}
	
	public function addAction()
	{
		if(!Mage::getSingleton('customer/session')->isLoggedIn()) 
		{
			$this->_redirect('customer/account/login');
			return;			
		}		
			
		$vendorId = $this->getRequest()->getParam('id');
		
		$profileModel = Mage::getModel('marketplace/profile')->load($vendorId);
		$favourites = $profileModel->getFavourites();
		$customerId = Mage::getSingleton('customer/session')->getCustomer()->getId();
				
		if(is_null($favourites) || empty($favourites))
			$favourites = array($customerId);				
		else
		{
			$favourites = json_decode($favourites, true);
			if(!in_array($customerId, $favourites))
			{
				$favourites[] = $customerId;
				$message = $this->__('Seller added to your favorite list.');
				Mage::getSingleton('core/session')->addSuccess($message);
			}
			else			
			{
				$message = $this->__('Seller already added to your favorite list.');			
				Mage::getSingleton('core/session')->addNotice($message);
			}
		}		
		
		$profileModel->setFavourites(json_encode($favourites))->save();				
		$this->_redirect('*/*/index');
	}
	
	public function removeAction()
	{
		if(!Mage::getSingleton('customer/session')->isLoggedIn()) 
		{
			$this->_redirect('customer/account/login');
			return;			
		}		
			
		$vendorId = $this->getRequest()->getParam('id');
		
		$profileModel = Mage::getModel('marketplace/profile')->load($vendorId);
		$favourites = $profileModel->getFavourites();
		$customerId = Mage::getSingleton('customer/session')->getCustomer()->getId();
				
		if(!is_null($favourites) && !empty($favourites))			
		{
			$favourites = json_decode($favourites, true);			
			if (($key = array_search($customerId, $favourites)) !== false)
				unset($favourites[$key]);			
		}		
		
		$profileModel->setFavourites(json_encode($favourites))->save();		
		
		$message = $this->__('Seller removed to your favorite list.');
		Mage::getSingleton('core/session')->addSuccess($message);
		
		$this->_redirect('*/*/index');
	}
}
?>
