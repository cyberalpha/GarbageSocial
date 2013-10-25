<?php
/**
* googleDirections plugin
* allows you to include one or more driving or walking directions
* provided by Google Maps right inside your content item or article.
* Author: kksou
* Copyright (C) 2006-2010. kksou.com. All Rights Reserved
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Website: http://www.kksou.com/php-gtk2
* v1.5 April 16, 2009
* v1.51 April 30, 2009 added support for mod_googleMaps
* v1.52 May 3, 2009 improved javascript
* v1.6 Mar 3, 2011 support for Joomla 1.6
*/

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

//@session_start();

jimport( 'joomla.event.plugin' );
$joomla_ver = '1.7';

$path_info = pathinfo(dirname(__FILE__));
#$path_base = dirname(__FILE__);
$path_base = $path_info['dirname'];
global $googleMaps_util;
$googleMaps_util = $path_base.'/googleMaps/googleMaps.util.php';
if (file_exists($googleMaps_util)) {
	require_once($googleMaps_util);
} else {
	return 0;
}

list($googleMaps_lib, $googleDirections_lib, $googleDirections_tohere_lib) = get_paths($path_base);
$googleMaps_ver = get_googleMaps_ver($path_base);
$googleDirections_ver = get_googleDirections_ver($path_base);

global $gdir_lib_ok, $gdir2_lib_ok;
if (file_exists($googleMaps_lib)) {
	require_once($googleMaps_lib);
	//$lib = dirname(__FILE__).'/googleDirections/googleDirections.lib.php';
	require_once($googleDirections_lib);
	$gdir_lib_ok = 1;
	#if (!googleMaps_ver_ok($googleMaps_ver)) $gdir_lib_ok = 2; 
	if (! isset ( $googleMaps_ver ) || $googleMaps_ver < '010717') {
		$gdir_lib_ok = 2;
		if (!$gdir2_lib_ok==3) error_msg2('googleMaps-plugin.php', 'latest version of googleMaps plugin', 'googleDirections');
	}
} else {
	$gdir_lib_ok = 0;
}

class plgContentgoogleDirections extends JPlugin {

	function plgContentgoogleDirections( &$subject, $params ) {
		parent::__construct( $subject, $params );
 	}

	function onContentPrepare( $context, &$row, &$params, $limitstart ) {
		
		global $googleMaps_util;
		if (!file_exists ( $googleMaps_util )) {
			print "<p style=\"background:#ffff00;padding:20px;line-height:4em\"><b>ttt1 ERROR >>> </b>You need to install the <a href=\"http://www.kksou.com/php-gtk2/Joomla-Gadgets/googleMaps-plugin.php#download\"><b>latest version of googleMaps plugin</b></a> for the googleDirections plugin to work.</p>";
			
			return false;
		}
		
		global $gdir_lib_ok;
		if ($gdir_lib_ok == 2) return false;
		
		if ($gdir_lib_ok==0) {
			error_msg2('googleMaps-plugin.php', 'googleMaps plugin', 'googleDirections');
			return false;
		}

		#$plugin =& JPluginHelper::getPlugin('content', 'googleDirections');
		$pluginParams = $this->params;

		/*if ( !$pluginParams->get( 'enabled', 1 ) ) {
			$row->text = preg_replace( $regex, '', $row->text );
			return true;
		}*/

		$param = new stdClass;
		$param->api_key = $pluginParams->get('api_key');
		$param->width = $pluginParams->get('width', 400);
		$param->height = $pluginParams->get('height', 480);
		$param->zoom = $pluginParams->get('zoom', 15);
		$param->dir_width = $pluginParams->get('dir_width', 275);
		$param->header_map = $pluginParams->get('header_map');
		$param->header_dir = $pluginParams->get('header_dir');
		$param->map_on_right = $pluginParams->get('map_on_right');

		$is_mod = 0;
		if (isset($params->is_mod)) $is_mod = 1;

		global $gdir_lib_ok;
		global $googleMaps_ver;
		if ($gdir_lib_ok) {
			$plugin = new Plugin_googleDirections($row, $param, $is_mod);
		}
		return true;
	}
}

?>
