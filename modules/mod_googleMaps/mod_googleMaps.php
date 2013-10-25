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

@session_start();
#$_SESSION['mod_googleMaps'] = 1;
#$_SESSION['mod_googleMaps_id'] = 131;
require_once (dirname(__FILE__).DS.'helper.php');
#$str = modgoogleMapsHelper::getContent($params);
$str = $params->get( 'content' );
require(JModuleHelper::getLayoutPath('mod_googleMaps'));
?>