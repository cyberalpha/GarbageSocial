<?php
/**
* googleMaps module
* This module allows you to display one or more google maps
* in a module position
* Make sure you have the googleMaps plugin installed
* Author: kksou
* Copyright (C) 2006-2008. kksou.com. All Rights Reserved
* Website: http://www.kksou.com/php-gtk2
* v1.5 April 16, 2009
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

class modgoogleMapsHelper {
	function getContent(&$params) {
		$str = $params->get( 'content' );
		$str = str_replace('~', '<br />', $str);
		$str = str_replace('[p]', '</p>', $str);
		$str = str_replace('[/p]', '</p>', $str);
		return $str;
	}
}
