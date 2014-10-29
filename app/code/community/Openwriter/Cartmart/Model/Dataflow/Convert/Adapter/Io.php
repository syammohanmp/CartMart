<?php
class Openwriter_Cartmart_Model_Dataflow_Convert_Adapter_Io extends Mage_Dataflow_Model_Convert_Adapter_Io
{
		/**
     * Save result to destination file from temporary
     *
     * @return Mage_Dataflow_Model_Convert_Adapter_Io
     */
    public function save()
    {
        if (!$this->getResource(true)) {
            return $this;
        }

        $batchModel = Mage::getSingleton('dataflow/batch');

        $dataFile = $batchModel->getIoAdapter()->getFile(true);

        $filename = $this->getVar('filename');
        
        /**Start Code For Vendor**/
        $isVendor = Mage::helper('cartmart')->isVendor();//current user is vendor or not
        
        if($isVendor)
        {
        		/**Fetch Current User Name**/    
						$user = Mage::getSingleton('admin/session');
						$userName = $user->getUser()->getUsername();
						
						$filename = 'export_product_'.$userName.'.csv';
				}
				/**End Code For Vendor**/

        $result   = $this->getResource()->write($filename, $dataFile, 0777);

        if (false === $result) {
            $message = Mage::helper('dataflow')->__('Could not save file: %s.', $filename);
            Mage::throwException($message);
        } else {
        
        		/**Start Code For Vendor**/
        		if($isVendor)
        		{
				    		$localpath = 'vendor/';
								//create path if not exist
								if (!file_exists($localpath)) {
										mkdir($localpath, 0777, true);
								}
								$fileWithPath = $localpath.'/'.$filename;

								$localResource = new Varien_Io_File();

								$localResource->write($fileWithPath, $dataFile, 0777);
								
						}
        		/**End Code For Vendor**/
        
        
            $message = Mage::helper('dataflow')->__('Saved successfully: "%s" [%d byte(s)].', $filename, $batchModel->getIoAdapter()->getFileSize());
            if ($this->getVar('link')) {
                $message .= Mage::helper('dataflow')->__('<a href="%s" target="_blank">Link</a>', $this->getVar('link'));
            }
            $this->addException($message);
        }
        return $this;
    }
}

