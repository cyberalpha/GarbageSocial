<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.0.beat1
	* Creation date: Mai 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die('Restricted access');

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_gmapfp')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

require_once (JPATH_COMPONENT.DS.'controller.php');
require_once( JPATH_COMPONENT.DS.'helper.php' );

// Require the base controller

$controllerName = JRequest::getWord('controller');

// Require specific controller if requested
if (!($controllerName = JRequest::getWord('controller')))
	{$controllerName = 'accueil';};


if($controllerName)
	{
   		$path = JPATH_COMPONENT.DS.'controllers'.DS.$controllerName.'.php';
    	if( file_exists($path))
    		{
        		require_once $path;
    		} else
    		{
        		$controllerName = '';
    		}
	}
$classname = 'GMapFPsController'.$controllerName;

// Create the controller
$controllerName = new $classname();

// Perform the Request task
if (!(JRequest::getVar('task'))) {
	$task = 'view';
}else{
	$task = JRequest::getVar('task');
};
$controllerName->execute( $task );

// Redirect if set by the controller
$controllerName->redirect();


?>
