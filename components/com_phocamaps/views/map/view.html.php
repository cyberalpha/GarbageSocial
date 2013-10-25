<?php
/*
 * @package		Joomla.Framework
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view');
class PhocaMapsViewMap extends JView
{
	function display($tpl = null) {
		
		$tmpl = array();
		
		// PLUGIN WINDOW - we get information from plugin
		$get		= '';
		$get['tmpl']	= JRequest::getVar( 'tmpl', '', 'get', 'string' );
		
		$document	= & JFactory::getDocument();		
		$app		= JFactory::getApplication();
		$params				= $app->getParams();
		
		//$document->addStyleSheet(JURI::base(true).'/components/com_phocamaps/assets/phocamaps.css');
		JHTML::stylesheet('components/com_phocamaps/assets/phocamaps.css' );
		
		$tmpl['enable_kml']				= $params->get( 'enable_kml', 0 );
		$tmpl['display_print_route']	= $params->get( 'display_print_route', 1 );
		$tmpl['close_opened_window']	= $params->get( 'close_opened_window', 0 );
		// Moved to marker table
		//$tmpl['width_marker_content']	= $params->get( 'width_marker_content', '' );
		//$tmpl['height_marker_content']	= $params->get( 'height_marker_content', '' );
		//$tmpl['open_marker_window']		= $params->get( 'open_marker_window', 0 );
			
		// MODEL
		$model	= &$this->getModel();
		$item	= $model->getData();
		
		if( (!isset($item['map'])) || (isset($item['map']) && $item['map'] == null) ) {
			echo '<div id="phocamaps"><div class="error">'.JText::_('COM_PHOCAMAPS_WARNING_SELECT_MAP').'</div></div>';
			return true;
		}
		
		// Plugin information
		$tmpl['pluginmap'] = 0;
		if (isset($get['tmpl']) && $get['tmpl'] == 'component') {
			$tmpl['pluginmap'] = 1;
			// NO SCROLLBAR if windows is called by plugin but if there is a route form, display it
			if (isset($item['map']->displayroute) && $item['map']->displayroute == 1) {
				$document->addCustomTag( "<style type=\"text/css\"> \n" 
			." html,body, .contentpane{background:#ffffff;text-align:left;} \n" 
			." </style> \n");
			} else {
				$document->addCustomTag( "<style type=\"text/css\"> \n" 
			." html,body, .contentpane{overflow:hidden;background:#ffffff;} \n" 
			." </style> \n");
			}
		}
		
		// Display Description
		$tmpl['description'] = '';
		if (isset($item['map']->description) && $item['map']->description != '' && $tmpl['pluginmap'] == 0) {
			$tmpl['description'] = '<div class="pm-desc">'.$item['map']->description.'</div>';
		}
		
		// Check Width and Height
		$tmpl['fullwidth'] = 0;
		if (!isset($item['map']->width)) {
			$item['map']->width = 400;
		}
		if (isset($item['map']->width) && (int)$item['map']->width < 1) {
			$tmpl['fullwidth'] = 1;
		}
		if (!isset($item['map']->height) || (isset($item['map']->height) && (int)$item['map']->height < 1)) {
			$item['map']->height = 400;
		}
		if (!isset($item['map']->zoom) || (isset($item['map']->zoom) && (int)$item['map']->zoom < 1)) {
			$item['map']->zoom = 2;
		}
		
		// Map Langugage
		
		
		$tmpl['params'] = '';
		if (!isset($item['map']->lang) || (isset($item['map']->lang) && $item['map']->lang == '')) {
			$tmpl['params'] 		= '{other_params:"sensor=false"}';
			$tmpl['paramssearch'] 	= '';
			$tmpl['lang']			= '';
		} else {
			//$tmpl['params'] = '{"language":"'.$item['map']->lang.'", "other_params":"sensor=false"}';
			$tmpl['params'] 		= '{other_params:"sensor=false&language='.$item['map']->lang.'"}';
			$tmpl['paramssearch'] 	= '{"language":"'.$item['map']->lang.'"}';
			$tmpl['lang']			= $item['map']->lang;
		}
		
		// Design
		$tmpl['border'] = '';
		if (isset($item['map']->border)) {
			switch ($item['map']->border) {
				case 1:
					$tmpl['border'] = '-grey';
				break;
				case 2:
					$tmpl['border'] = '-greywb';
				break;
				case 3:
					$tmpl['border'] = '-greyrc';
				break;
				case 4:
					$tmpl['border'] = '-black';
				break;
			}
		}
		
		// Plugin - no border
		if ($tmpl['pluginmap'] == 1) {
			$tmpl['border'] 	= '';
			$tmpl['stylesite'] 	= 'margin:10px;';
		} else {
			$tmpl['stylesite'] 	= 'margin:0;padding:0;margin-top:10px;';
		}
		
		$tmpl['stylesitewidth']	= '';
		if ($tmpl['fullwidth'] == 1) {
			$tmpl['stylesitewidth'] = 'style="width:100%"';
		}
		
		// Parameters
		if (isset($item['map']->continuouszoom) && (int)$item['map']->continuouszoom == 1) {
			$item['map']->continuouszoom = 1;
		} else {
			$item['map']->continuouszoom = 0;
		}
		
		if (isset($item['map']->doubleclickzoom) && (int)$item['map']->doubleclickzoom == 1) {
			$item['map']->disabledoubleclickzoom = 0;
		} else {
			$item['map']->disabledoubleclickzoom = 1;
		}
		
		if (isset($item['map']->scrollwheelzoom) && (int)$item['map']->scrollwheelzoom == 1) {
			$item['map']->scrollwheelzoom = 1;
		} else {
			$item['map']->scrollwheelzoom = 0;
		}
		
		// Since 1.1.0 zoomcontrol is alias for navigationcontrol
		if (empty($item['map']->zoomcontrol)) {
			$item['map']->zoomcontrol = 0;
		}
		
		if (empty($item['map']->scalecontrol)) {
			$item['map']->scalecontrol = 0;
		}
		
		if (empty($item['map']->typecontrol)) {
			$item['map']->typecontrol = 0;
		}
		if (empty($item['map']->typecontrolposition)) {
			$item['map']->typecontrolposition = 0;
		}
		
		
		if (empty($item['map']->typeid)) {
			$item['map']->typeid = 0;
		}
		
		
		// Display Direction
		$tmpl['displaydir'] = 0;
		if (isset($item['map']->displayroute) && $item['map']->displayroute == 1) {
			if (isset($item['marker']) && !empty($item['marker'])) {
				$tmpl['displaydir'] = 1;
			}
		}
		
		// KML Support
		$tmpl['load_kml'] = FALSE;
		if($tmpl['enable_kml'] == 1) {
			jimport( 'joomla.filesystem.folder' ); 
			jimport( 'joomla.filesystem.file' );
			$path = PhocaMapsPath::getPath();
			if (isset($item['map']->kmlfile) && JFile::exists($path->kml_abs . $item['map']->kmlfile)) {
				$tmpl['load_kml'] = $path->kml_rel_full . $item['map']->kmlfile;
			}
		}
		

		// ASIGN
		$this->assignRef( 'tmpl', $tmpl );
		$this->assignRef( 'map', $item['map'] );
		$this->assignRef( 'marker', $item['marker'] );
		$this->assignRef( 'pluginmap', $tmpl['pluginmap']);
		$this->assignRef( 'params', $params );
		parent::display($tpl);
	}
}
