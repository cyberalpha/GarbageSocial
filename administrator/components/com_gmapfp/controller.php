<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.0.beat1
	* Creation date: Mai 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

jimport('joomla.application.component.controller');

class GMapFPsController extends JController
{
	function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT.'/helpers/gmapfp.php';
		//GMapFPHelper::updateReset();

		// Load the submenu.
		GMapFPHelper::addSubmenu(JRequest::getCmd('controller', 'accueil'));
		
		parent::display();
		
		return $this;
	}
	
	function orderup()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 
		$filter_order		= $mainframe->getUserStateFromRequest( $option.'filter_order',		'filter_order',		'a.ordering',	'cmd' );
		$filter_order_Dir 	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir', 	'filter_order_Dir', 	'', 											'word');
		$model = $this->getModel('gmapfp');
		
		if (($filter_order=='a.ordering')and(($filter_order_Dir=='asc')or(!($filter_order_Dir)))) {
			$model->move(-1);
		};
		if (($filter_order=='a.ordering')and($filter_order_Dir=='desc')) {
			$model->move(1);
		};

		$this->setRedirect( 'index.php?option=com_gmapfp&controller=gmapfp&task=view');
	}

	function orderdown()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 
		$filter_order		= $mainframe->getUserStateFromRequest( $option.'filter_order',		'filter_order',		'a.ordering',	'cmd' );
		$filter_order_Dir 	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir', 	'filter_order_Dir', 	'', 											'word');
		$model = $this->getModel('gmapfp');
		
		if (($filter_order=='a.ordering')and(($filter_order_Dir=='asc')or(!($filter_order_Dir)))) {
			$model->move(1);
		};
		if (($filter_order=='a.ordering')and($filter_order_Dir=='desc')) {
			$model->move(-1);
		};

		$this->setRedirect( 'index.php?option=com_gmapfp&controller=gmapfp&task=view');
	}

	function saveorder()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid 	= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order 	= JRequest::getVar( 'order', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);

		$model = $this->getModel('gmapfp');
		$model->saveorder($cid, $order);

		$msg = JText::_( 'New ordering saved' );
		$this->setRedirect( 'index.php?option=com_gmapfp&controller=gmapfp&task=view', $msg );
	}

}
?>
