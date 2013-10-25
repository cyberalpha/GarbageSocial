<?php
/**
 * @package 	mod_bt_googlemaps - BT Google Maps
 * @version		1.0.1
 * @created		Jun 2012

 * @author		BowThemes
 * @email		support@bowthems.com
 * @website		http://bowthemes.com
 * @support		Forum - http://bowthemes.com/forum/
 * @copyright	Copyright (C) 2012 Bowthemes. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


class modbt_googlemapsHelper
{	
	public static function fetchHead($params, $module){
		$document	= JFactory::getDocument();
		$mainframe = JFactory::getApplication();
		$template = $mainframe->getTemplate();
		JHTML::_('behavior.framework');
		
		$language = JFactory::getLanguage();
		$mapApi= 'http://maps.google.com/maps/api/js?sensor=true&language='.$language->getTag();
		if($params->get('weather')) $mapApi .= '&libraries=weather';
		$document->addScript($mapApi);
		
		if(file_exists(JPATH_BASE.'/templates/'.$template.'/html/mod_bt_googlemaps/js/default.js'))
		{
			$document->addScript(JURI::root().'templates/'.$template.'/html/mod_bt_googlemaps/js/default.js');	
		}
		else{
			$document->addScript(JURI::root().'modules/mod_bt_googlemaps/tmpl/js/btbase64.min.js');
			if($params->get('enable-custom-infobox')){
				$document->addScript(JURI::root().'modules/mod_bt_googlemaps/tmpl/js/infobox.js');		
			}
			$document->addScript(JURI::root().'modules/mod_bt_googlemaps/tmpl/js/default.js');	
			
		}
	if(file_exists(JPATH_BASE.'/templates/'.$template.'/html/mod_bt_googlemaps/css/styles.css'))
		{
			$document->addStyleSheet(JURI::root().'templates/'.$template.'/html/mod_bt_googlemaps/css/style.css');	
		}
		else{
			$document->addStyleSheet(JURI::root().'modules/mod_bt_googlemaps/tmpl/css/style.css');
		}
		
		$script = 'window.addEvent(\'domready\', function(){';		
		$script .=  'var config = {';
		$script .=  'mapType				:\''.$params->get('mapType').'\',';
		$script .=  'width					:\''.$params->get('width').'\',';
		$script .=  'height					:\''.$params->get('height').'\',';
		$script .=  'cavas_id				:"cavas_id'.$module->id.'", ';
		$script .=  'zoom					:'.$params->get('zoom').',';
		$script .=  'zoomControl			:'.$params->get('zoomControl','true').',';
		$script .=  'scaleControl			:'.$params->get('scaleControl','true').',';
		$script .=  'panControl				:'.$params->get('panControl','true').',';
		$script .=  'mapTypeControl			:'.$params->get('mapTypeControl','true').',';
		$script .=  'streetViewControl		:'.$params->get('streetViewControl','true').',';
		$script .=  'overviewMapControl		:'.$params->get('overviewMapControl','true').',';
		$script .=  'weather				:'.$params->get('weather','true').',';
		$script .=  'temperatureUnit		:\''.$params->get('temperatureUnit','f').'\',';
		$script .=  'cloud					:'.$params->get('cloud','true').',';
		
		# for map address(map center)
		$script .=	'mapCenterType			:"'.$params->get('mapCenterType').'",';
		$script	.=	'mapCenterAddress		:"'.$params->get('mapCenterAddress').'",';
		$script	.=	'mapCenterCoordinate	:"'.$params->get('mapCenterCoordinate').'",';
		
		# for control custom style
		$script .=	'enableStyle			:"'.$params->get('enable-style').'",';
		$script .=	'styleTitle				:"'.$params->get('style-title').'",';
		$script .=	'createNewOrDefault		:"'.$params->get('createNewOrApplyDefaultStyle').'",';
		
		# for custom infobox
		$script .=	'enableCustomInfoBox	:"'.$params->get('enable-custom-infobox').'",';
		$script .=	'boxPosition			:"'.$params->get('pixelOffset').'",';
		$script .=	'closeBoxMargin			:"'.$params->get('closeBoxMargin').'",';
		$script .=	'closeBoxImage			:"'.$params->get('closeBoxURL').'",';
		
		$script .=	'url:"'.JURI::root().'"';
		$script .=  '};';
		
		# create box style object
		$boxcss = $params->get('boxcss');
		$boxcss = preg_replace("/[\n\r]/","",$boxcss);
		$boxcssArr = explode(',' ,$boxcss);
		$boxCssRender = array();
		$script .= 'var boxStyles = {';
		for ( $i=0; $i< count($boxcssArr); $i++){
			$boxcssArr[$i] = trim($boxcssArr[$i]);
			if($boxcssArr[$i]){
				$style = explode(':',$boxcssArr[$i]);
				$style[0] = str_replace(array(' ','-'),'',$style[0]);
				if($style[0]){
					$boxCssRender[]='"'.$style[0].'":"'.$style[1].'"';
					//if($style[0] == 'box-shadow'){
					//	$boxCssRender[]='"-moz-box-shadow":"'.$style[1].'"';
					//	$boxCssRender[]='"-webkit-box-shadow":"'.$style[1].'"';
					//}
				}
				
				
			}
		}
		$script .= implode($boxCssRender,',');
		$script .= '};';
		 
		$script .=  'var markersCode ="'.$params->get('markes').'"; ';
		$script .=  'var stylesCode ="'.$params->get('styles').'"; ';
		$script .=  'initializeMap(config, markersCode, stylesCode, boxStyles);';
		$script .=  '}) ';
		$document->addScriptDeclaration($script);
	}
	

		
	
}
