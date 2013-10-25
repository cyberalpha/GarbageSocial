<?php
/**
 * @package		Joomla.Site
 * @subpackage	TTw mod_automailing
 * @copyright	Copyright (C) 2011 - 2012 TTwebs All rights reserved.
 * @license		GNU General Public License version 2 or later
 */

// no direct access
defined('_JEXEC') or die;

$document = JFactory::getDocument();

$document->addScript('http://maps.google.com/maps/api/js?sensor=false');
$document->addScript(JURI::root().'modules/mod_lat_lon/js/scripts.js');

// Get the layout
require JModuleHelper::getLayoutPath('mod_lat_lon');
