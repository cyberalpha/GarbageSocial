<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.5.x
	* Version 5.0
	* Creation date: Janvier 2010
	* Author: Fabrice4821 - www.gmapfp.francejoomla.net
	* Author email: fayauxlogescpa@gmail.com
	* License GNU/GPL
	*/

defined('_JEXEC') or die();

class GMapFPsControllerPersonnalisation extends GMapFPsController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();

	}

	/**
	 * display the edit form
	 * @return void
	 */
	function edit()
	{
		JRequest::setVar( 'view', 'personnalisation' );
		JRequest::setVar( 'layout', 'form'  );

		parent::display();
	}

	/**
	 * save a record (and not redirect to main page)
	 * @return void
	 */
	function apply()
	{
		$post	= JRequest::get('post');
		$model = $this->getModel('personnalisation');
		$returnid=$model->store($post);
		if ($returnid>0) {
			$msg = JText::_( 'GMAPFP_SAVED' );
		} else {
			$msg = JText::_( 'GMAPFP_SAVED_ERROR' );
		}

		$link = 'index.php?option=com_gmapfp&controller=personnalisation&task=edit';
		// Check the table in so it can be edited.... we are done with it anyway
		$this->setRedirect($link, $msg);
	}

	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('personnalisation');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or more GMapFPs could not be Deleted' );
		} else {
			$msg = JText::_( 'GMapFP(s) Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_gmapfp&controller=personnalisation&task=edit', $msg );
	}
	
	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_gmapfp&controller=personnalisation&task=edit', $msg );
	}

}
?>
