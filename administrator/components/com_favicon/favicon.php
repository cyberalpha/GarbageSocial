<?php
/**
 * @version		$Id: favicon.php 14963 2010-02-21 09:48:58Z infograf768 $
 * @package		Joomla.Administrator
 * @subpackage	com_favicon
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_favicon')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

$document =& JFactory::getDocument();
$document->addStyleSheet(JURI::root(true).DS.'media'.DS.'com_favicon'.DS.'assets'.DS.'css'.DS.'favicon.css');
// Execute the task.
$controller	= &JController::getInstance('Favicon');
$controller->execute(JRequest::getCmd('task','favicons'));
$controller->redirect();
