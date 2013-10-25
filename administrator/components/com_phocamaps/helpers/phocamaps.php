<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */ 
defined('_JEXEC') or die();
class PhocaMapsHelper
{	
	function strTrimAll($input) {
		$output	= '';;
	    $input	= trim($input);
	    for($i=0;$i<strlen($input);$i++) {
	        if(substr($input, $i, 1) != " ") {
	            $output .= trim(substr($input, $i, 1));
	        } else {
	            $output .= " ";
	        }
	    }
	    return $output;
	}

	function getPhocaVersion($component = 'com_phocamaps') {
		$component = 'com_phocamaps';
		$folder = JPATH_ADMINISTRATOR .DS. 'components'.DS.$component;
		
		if (JFolder::exists($folder)) {
			$xmlFilesInDir = JFolder::files($folder, '.xml$');
		} else {
			$folder = JPATH_SITE .DS. 'components'.DS.$component;
			if (JFolder::exists($folder)) {
				$xmlFilesInDir = JFolder::files($folder, '.xml$');
			} else {
				$xmlFilesInDir = null;
			}
		}

		$xml_items = '';
		if (count($xmlFilesInDir))
		{
			foreach ($xmlFilesInDir as $xmlfile)
			{
				if ($data = JApplicationHelper::parseXMLInstallFile($folder.DS.$xmlfile)) {
					foreach($data as $key => $value) {
						$xml_items[$key] = $value;
					}
				}
			}
		}
		
		if (isset($xml_items['version']) && $xml_items['version'] != '' ) {
			return $xml_items['version'];
		} else {
			return '';
		}
	}
	
	function getInfo() {
		return '<div style="text-align: right; color: rgb(211, 211, 211); clear: both; margin-top: 10px;margin-bottom:10px;">Powered by <a href="http://www.phoca.cz" style="text-decoration: none;" target="_blank" title="Phoca.cz">Phoca</a> <a href="http://www.phoca.cz/phocamaps" style="text-decoration: none;" target="_blank" title="Phoca Maps">Maps</a></div>';	
	}
	
	function getAliasName($name) {
		/*
		//$paramsC		= &JComponentHelper::getParams( 'com_phocamaps' );
		//$alias_iconv	= $paramsC->get( 'alias_iconv', 0 );
		$alias_iconv 	= 0;
		$iconv 			= 0;
		if ($alias_iconv == 1) {
			if (function_exists('iconv')) {
				$name = preg_replace('~[^\\pL0-9_.]+~u', '-', $name);
				$name = trim($name, "-");
				$name = iconv("utf-8", "us-ascii//TRANSLIT", $name);
				$name = strtolower($name);
				$name = preg_replace('~[^-a-z0-9_.]+~', '', $name);
				$iconv = 1;
			} else {
				$iconv = 0;
			}
		}
		
		if ($iconv == 0) {
			$name = JFilterOutput::stringURLSafe($name);
		}
		
		if(trim(str_replace('-','',$name)) == '') {
			$datenow	= &JFactory::getDate();
			$name 		= $datenow->toFormat("%Y-%m-%d-%H-%M-%S");
		}
		return $name;*/
	}
	
	function fixImagePath($description) {
		$description = str_replace('<img src="'.JURI::root(true).'/', '', $description);// no double
		$description = str_replace('<img src="', '<img src="'.JURI::root(true).'/', $description);
		return $description;
	}
}
?>