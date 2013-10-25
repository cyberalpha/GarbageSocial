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

class PhocaMapsCpViewPhocaMapsGMap extends JView
{
	protected $latitude;
	protected $longitude;
	protected $zoom;
	protected $type;
	
	public function display($tpl = null) {

		JHTML::stylesheet('administrator/components/com_phocamaps/assets/phocamaps.css' );
		
		$this->latitude		= JRequest::getVar( 'lat', '50', 'get', 'string' );
		$this->longitude	= JRequest::getVar( 'lng', '-30', 'get', 'string' );
		$this->zoom			= JRequest::getVar( 'zoom', '2', 'get', 'string' );
		$this->type			= JRequest::getVar( 'type', 'map', 'get', 'string' );
		parent::display($tpl);
	}
}
?>