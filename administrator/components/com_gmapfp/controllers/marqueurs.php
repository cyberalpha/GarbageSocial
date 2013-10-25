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

class GMapFPsControllerMarqueurs extends GMapFPsController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'unpublish', 	'publish');
	}

	/**
	 * display the edit form
	 * @return void
	 */
	function view()
	{
		JRequest::setVar( 'view', 'marqueurs' );
		JRequest::setVar( 'layout', 'liste'  );

		parent::display();
	}

	/**
	 * display the edit form
	 * @return void
	 */
	function edit()
	{
		JRequest::setVar( 'view', 'marqueurs' );
		JRequest::setVar( 'layout', 'detail'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();
	}

	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()
	{
		$post	= JRequest::get('post');
		$model = $this->getModel('marqueurs');

		$returnid=$model->store($post);
		if ($returnid>0) {
			$msg = JText::_( 'GMAPFP_SAVED' );
		} else {
			$msg = JText::_( 'GMAPFP_SAVED_ERROR' );
		}

		$link = 'index.php?option=com_gmapfp&controller=marqueurs&task=view';
		// Check the table in so it can be edited.... we are done with it anyway
		$this->setRedirect($link, $msg);
	}

	/**
	 * save a record (and not redirect to main page)
	 * @return void
	 */
	function apply()
	{
		$post	= JRequest::get('post');
		$model = $this->getModel('marqueurs');

		$returnid=$model->store($post);
		if ($returnid>0) {
			$msg = JText::_( 'GMAPFP_SAVED' );
		} else {
			$msg = JText::_( 'GMAPFP_SAVED_ERROR' );
		}

		$link = 'index.php?option=com_gmapfp&controller=marqueurs&task=edit&cid[]='.$returnid;
		// Check the table in so it can be edited.... we are done with it anyway
		$this->setRedirect($link, $msg);
	}

	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('marqueurs');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or more GMapFPs could not be Deleted' );
		} else {
			$msg = JText::_( 'GMapFP(s) Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_gmapfp&controller=marqueurs&task=view', $msg );
	}

	
	/**
	* Publishes or Unpublishes one or more records
	* @param array An array of unique category id numbers
	* @param integer 0 if unpublishing, 1 if publishing
	* @param string The current url option
	*/
	function publish()
	{
		$this->setRedirect( 'index.php?option=com_gmapfp&controller=marqueurs&task=view' );

		// Initialize variables
		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$cid		= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$task		= JRequest::getCmd( 'task' );
		$publish	= ($task == 'publish');
		$n			= count( $cid );

		if (empty( $cid )) {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}

		JArrayHelper::toInteger( $cid );
		$cids = implode( ',', $cid );

		$query = 'UPDATE #__gmapfp_marqueurs'
		. ' SET published = ' . (int) $publish
		. ' WHERE id IN ( '. $cids .' )'
		;
		$db->setQuery( $query );
		if (!$db->query()) {
			return JError::raiseWarning( 500, $row->getError() );
		}
		$this->setMessage( JText::sprintf( $publish ? 'Items published' : 'Items unpublished', $n ) );

	}
	
	
	
	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_gmapfp&controller=marqueurs&task=view', $msg );
	}
}
?>
