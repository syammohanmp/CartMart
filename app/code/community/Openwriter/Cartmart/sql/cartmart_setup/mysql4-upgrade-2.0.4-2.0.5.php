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

$installer = $this;

$table = $installer->getTable('dataflow/profile');

$data[0] = array(
							'name' => 'Vendor Export Products',
							'actions_xml' => "<action type=\"cartmart/convert_adapter_product\" method=\"load\">
												<var name=\"store\"><![CDATA[0]]></var>
										</action>

										<action type=\"catalog/convert_parser_product\" method=\"unparse\">
												<var name=\"store\"><![CDATA[0]]></var>
												<var name=\"url_field\"><![CDATA[0]]></var>
										</action>

										<action type=\"dataflow/convert_mapper_column\" method=\"map\">
										</action>

										<action type=\"dataflow/convert_parser_csv\" method=\"unparse\">
												<var name=\"delimiter\"><![CDATA[,]]></var>
												<var name=\"enclose\"><![CDATA[\"]]></var>
												<var name=\"fieldnames\">true</var>
										</action>

										<action type=\"cartmart/dataflow_convert_adapter_io\" method=\"save\">
												<var name=\"type\">file</var>
												<var name=\"path\">var/export</var>
												<var name=\"filename\"><![CDATA[export_product.csv]]></var>
										</action>",
										
							'gui_data' => "a:5:{s:6:\"export\";a:1:{s:13:\"add_url_field\";s:1:\"0\";}s:4:\"file\";a:5:{s:4:\"host\";s:0:\"\";s:4:\"user\";s:0:\"\";s:8:\"password\";s:9:\"openwriter1234\";s:9:\"file_mode\";s:1:\"2\";s:7:\"passive\";s:0:\"\";}s:5:\"parse\";a:3:{s:12:\"single_sheet\";s:0:\"\";s:4:\"type\";s:3:\"csv\";s:10:\"fieldnames\";b:1;}s:3:\"map\";a:2:{s:7:\"product\";a:2:{s:2:\"db\";a:1:{i:0;s:1:\"0\";}s:4:\"file\";a:1:{i:0;s:0:\"\";}}s:8:\"customer\";a:2:{s:2:\"db\";a:2:{i:0;s:1:\"0\";i:1;s:1:\"0\";}s:4:\"file\";a:2:{i:0;s:0:\"\";i:1;s:0:\"\";}}}s:8:\"customer\";a:1:{s:6:\"filter\";a:10:{s:9:\"firstname\";s:0:\"\";s:8:\"lastname\";s:0:\"\";s:5:\"email\";s:0:\"\";s:5:\"group\";s:1:\"0\";s:10:\"adressType\";s:15:\"default_billing\";s:9:\"telephone\";s:0:\"\";s:8:\"postcode\";s:0:\"\";s:7:\"country\";s:0:\"\";s:6:\"region\";s:0:\"\";s:10:\"created_at\";a:2:{s:4:\"from\";s:0:\"\";s:2:\"to\";s:0:\"\";}}}}",
							
							'direction' => 'export',
							
							'entity_type' => 'product',
							
							'store_id' => 0,
							
							'data_transfer' => 'file'
					);
					
					
$data[1] = array(
							'name' => 'Vendor Import Products',
							'actions_xml' => "<action type=\"dataflow/convert_parser_csv\" method=\"parse\">
    <var name=\"delimiter\"><![CDATA[,]]></var>
    <var name=\"enclose\"><![CDATA[\"]]></var>
    <var name=\"fieldnames\">true</var>
    <var name=\"store\"><![CDATA[0]]></var>
    <var name=\"number_of_records\">1</var>
    <var name=\"decimal_separator\"><![CDATA[.]]></var>
    <var name=\"adapter\">cartmart/convert_adapter_product</var>
    <var name=\"method\">parse</var>
</action>",
										
							'gui_data' => "a:7:{s:6:\"export\";a:1:{s:13:\"add_url_field\";s:1:\"0\";}s:6:\"import\";a:2:{s:17:\"number_of_records\";s:1:\"1\";s:17:\"decimal_separator\";s:1:\".\";}s:4:\"file\";a:8:{s:4:\"type\";s:4:\"file\";s:8:\"filename\";s:18:\"export_product.csv\";s:4:\"path\";s:10:\"var/export\";s:4:\"host\";s:0:\"\";s:4:\"user\";s:0:\"\";s:8:\"password\";s:9:\"openwriter1234\";s:9:\"file_mode\";s:1:\"2\";s:7:\"passive\";s:0:\"\";}s:5:\"parse\";a:5:{s:4:\"type\";s:3:\"csv\";s:12:\"single_sheet\";s:0:\"\";s:9:\"delimiter\";s:1:\",\";s:7:\"enclose\";s:1:\"\"\";s:10:\"fieldnames\";s:4:\"true\";}s:3:\"map\";a:3:{s:14:\"only_specified\";s:0:\"\";s:7:\"product\";a:2:{s:2:\"db\";a:0:{}s:4:\"file\";a:0:{}}s:8:\"customer\";a:2:{s:2:\"db\";a:0:{}s:4:\"file\";a:0:{}}}s:7:\"product\";a:1:{s:6:\"filter\";a:8:{s:4:\"name\";s:0:\"\";s:3:\"sku\";s:0:\"\";s:4:\"type\";s:1:\"0\";s:13:\"attribute_set\";s:0:\"\";s:5:\"price\";a:2:{s:4:\"from\";s:0:\"\";s:2:\"to\";s:0:\"\";}s:3:\"qty\";a:2:{s:4:\"from\";s:0:\"\";s:2:\"to\";s:0:\"\";}s:10:\"visibility\";s:1:\"0\";s:6:\"status\";s:1:\"0\";}}s:8:\"customer\";a:1:{s:6:\"filter\";a:10:{s:9:\"firstname\";s:0:\"\";s:8:\"lastname\";s:0:\"\";s:5:\"email\";s:0:\"\";s:5:\"group\";s:1:\"0\";s:10:\"adressType\";s:15:\"default_billing\";s:9:\"telephone\";s:0:\"\";s:8:\"postcode\";s:0:\"\";s:7:\"country\";s:0:\"\";s:6:\"region\";s:0:\"\";s:10:\"created_at\";a:2:{s:4:\"from\";s:0:\"\";s:2:\"to\";s:0:\"\";}}}}",
							
							'direction' => 'import',
							
							'entity_type' => 'product',
							
							'store_id' => 0,
							
							'data_transfer' => 'interactive'
					);
     		
$connection = $installer->getConnection();
$connection->insertMultiple($table, $data);


$installer->endSetup();
?>
