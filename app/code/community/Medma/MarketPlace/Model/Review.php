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

class Medma_MarketPlace_Model_Review extends Mage_Core_Model_Abstract 
{
	const POSITIVE = 0;
	const NEUTRAL = 1;
	const NEGATIVE = 2;
	const ALL = 3;
	
	const PENDING = 0;
	const APPROVED = 1;
	const CANCEL = 2;
	
    protected function _construct() 
    {
        $this->_init('marketplace/review');
    }
}

?>
