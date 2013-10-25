<?php
/**
 * @version		$Id: mod_vinaora_cu3er_3d_slideshow.php 2012-03-18 vinaora $
 * @package		Vinaora Cu3er 3D Slideshow
 * @subpackage	mod_vinaora_cu3er_3d_slideshow
 * @copyright	Copyright (C) 2010 - 2012 VINAORA. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @website		http://vinaora.com
 * @twitter		http://twitter.com/vinaora
 * @facebook	http://facebook.com/vinaora
 */

// no direct access
defined('_JEXEC') or die;

// Require Base Helper
require_once dirname(__FILE__).DS.'helper.php';

$module_id = $module->id;

$config_custom	= $params->get( 'config_custom' );
$lastedit		= $params->get( 'lastedit' );
$config_name	= "V$module_id-$lastedit.xml";

if( $config_custom=="-1" ){
	$config_name	= 'media/mod_vinaora_cu3er_3d_slideshow/config/'.$config_name;
}
else{
	$config_name	= 'media/mod_vinaora_cu3er_3d_slideshow/config/custom/'.$config_custom;
}

$config	= modVinaoraCu3er3DSlideshowHelper::getConfig($config_name);

// Config file (.xml or .xml.php) exits and valid XML
if ( $config ){
	$width	= intval($config->settings->general["slide_panel_width"]);
	$height	= intval($config->settings->general["slide_panel_height"]);
}
// Config File not exist
else{
	$configHelper = new modVinaoraCu3er3DSlideshowHelper($params);
	if($config_custom=="-1") $configHelper->createConfig($config_name);

	$width	= intval($params->get('slide_panel_width', 0));
	$height	= intval($params->get('slide_panel_height', 0));
}

if (!$width || !$height){
	JError::raiseNotice( 100, JText::_( 'MOD_VC3S_ERROR_NOTSET_DIMENSION' ) );
}

// Add SWFObject Library to <head> tag
modVinaoraCu3er3DSlideshowHelper::addSWFObject($params->get('swfobject_source'), $params->get('swfobject_version'));

// Initialize variables
$media					= modVinaoraCu3er3DSlideshowParam::getPath('media/mod_vinaora_cu3er_3d_slideshow/');
$config_name			= modVinaoraCu3er3DSlideshowParam::getPath($config_name);
$slideshow_path 		= $media.'flash/cu3er.swf';
$expressInstall_path 	= $media.'js/swfobject/expressInstall.swf';
$flash_version			= '9.0.124';

$swffont				= $params->get('swffont');
$font_path				= ($swffont!= '-1') ? $media.'flash/fonts/'.$swffont : '';

// Get flash params
$flash_wmode			= $params->get('flash_wmode');

$container				= 'vinaora-3d-slideshow'.$module_id;

// Get border parameters
$border_width			= intval($params->get('border_width', 0));
$border_color			= $params->get('border_color', '#000000');
$border_style			= $params->get('border_style', 'solid');
$border_rounded			= $params->get('border_rounded', 1);
$border_shadow			= $params->get('border_shadow', 1);

$footer					= $params->get('footer', '-1');

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

// Load Default Layout
require JModuleHelper::getLayoutPath('mod_vinaora_cu3er_3d_slideshow', $params->get('layout', 'default'));
