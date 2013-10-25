<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.0.beat1
	* Creation date: Mai 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die();
jimport('joomla.application.component.controller');

class GMapFPsController extends JController
{
	function display()
	{
		$view = JRequest::getVar('view', '', '', 'str');
		if ($view == 'gmapfplist') {
			$view = & $this->getView( 'gmapfplist', 'html');
			$view->setModel( $this->getModel( 'gmapfp' ), true );
			$view->display();
		} else {	
			if ($view == 'gmapfpcontact') {
				$view = & $this->getView( 'gmapfpcontact', 'html');
				$view->setModel( $this->getModel( 'gmapfp' ), true );
				$view->display();
			} else{
				parent::display();
			};
		};
	}
}
