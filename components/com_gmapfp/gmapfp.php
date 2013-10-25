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
define('COM_GMAPFP_PRO',    0);

require_once (JPATH_COMPONENT.DS.'controller.php');
if($controller = JRequest::getWord('controller')) {
	$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
	if (file_exists($path)) {
		require_once $path;
	} else {
		$controller = '';
	}
}
$classname	= 'GMapFPsController'.ucfirst($controller);
$controller = new $classname( );

$controller->execute(JRequest::getCmd('task'));

$controller->redirect();

?>