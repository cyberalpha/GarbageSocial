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
jimport( 'joomla.application.component.view');
class PhocaMapsViewRoute extends JView
{
	function display($tpl = null) {
		global $mainframe;
		
		$document	= & JFactory::getDocument();			
		$document->addStyleSheet(JURI::base(true).'/components/com_phocamaps/assets/phocamaps.css');
		
		$tmpl = array();
		//$tmpl['printview'] 	= JRequest::getVar('print', 0, 'get', 'int');
		$tmpl['from'] 	= JRequest::getVar('from', '', 'get', 'string');
		$tmpl['to'] 	= JRequest::getVar('to', '', 'get', 'string');
		$tmpl['lang'] 	= JRequest::getVar('lang', '', 'get', 'string');
	
		// Map params - language not used
		if ($tmpl['lang'] == '') {
			$tmpl['params'] = '{other_params:"sensor=false"}';
		} else {
			//$tmpl['params'] = '{"language":"'.$item['map']->lang.'", "other_params":"sensor=false"}';
			$tmpl['params'] = '{other_params:"sensor=false&language='.$tmpl['lang'].'"}';
		}
	
		// Assing
		$this->assignRef( 'tmpl', $tmpl );
		parent::display($tpl);
	}
}
