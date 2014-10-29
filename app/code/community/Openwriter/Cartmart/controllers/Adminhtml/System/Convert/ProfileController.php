<?php

require_once(Mage::getModuleDir('controllers', 'Mage_Adminhtml') . DS . 'System/Convert' . DS . 'ProfileController.php');

class Openwriter_Cartmart_Adminhtml_System_Convert_ProfileController extends Mage_Adminhtml_System_Convert_ProfileController
{
		public function runAction()
    {
        $this->_initProfile();
        $this->loadLayout();
        $this->renderLayout();
        
        /**Fetch Current User Id**/    
		    $user = Mage::getSingleton('admin/session');
				$userName = $user->getUser()->getUsername();
        $filename = 'vendor/export_product_'.$userName.'.csv';
        if(file_exists($filename))
        {
				    $baseUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
						$content = file_get_contents($baseUrl.$filename);
						$this->_prepareDownloadResponse('export_product.csv', $content);
				}
    }
    
    protected function _isAllowed()
    {
        return true;
    }
}
