<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.8
	* Creation date: Décembre 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die();

class GMapFPsControllerGestionLieux extends GMapFPsController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add', 'edit' );
		$this->registerTask( 'unpublish', 	'publish');
	}

	/**
	 * display the edit form
	 * @return void
	 */
	function edit()
	{
		JRequest::setVar( 'view', 'editlieux' );
		JRequest::setVar( 'layout', 'edit_form'  );

		parent::display();
	}

	function view()
	{
		JRequest::setVar( 'view', 'gestionlieux' );
		JRequest::setVar( 'layout', 'default'  );

		parent::display();
	}

	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('gestionlieux');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or more GMapFPs could not be Deleted' );
		} else {
			$msg = JText::_( 'GMapFP(s) Deleted' );
		}

		$this->setRedirect( JRoute::_('index.php?option=com_gmapfp&view=gestionlieux&controller=gestionlieux&task=view'), $msg );
	}

	/**
	* Publishes or Unpublishes one or more records
	* @param array An array of unique category id numbers
	* @param integer 0 if unpublishing, 1 if publishing
	* @param string The current url option
	*/
	function publish()
	{
		$this->setRedirect( JRoute::_('index.php?option=com_gmapfp&view=gestionlieux&controller=gestionlieux&task=view') );;

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

		$query = 'UPDATE #__gmapfp'
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
	 * Copie un lieux sélectionné
	 **/	
	function copy()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$this->setRedirect( JRoute::_('index.php?option=com_gmapfp&view=gestionlieux&controller=gestionlieux&task=view') );

		$cid	= JRequest::getVar( 'cid', null, 'post', 'array' );
		$db		=& JFactory::getDBO();
		$model = $this->getModel('gestionlieux');
		$table	=$model->getTable('GMapFP', 'GMapFPTable');
		$user	= &JFactory::getUser();
		$n		= count( $cid );

		if ($n > 0)
		{
			foreach ($cid as $id)
			{
				if ($table->load( (int)$id ))
				{
					$table->id			= 0;
					$table->nom			= '('.JText::_( 'GMAPFP_COPIE_DE').') ' . $table->nom;
					$table->alias		= '';
					$table->published	= 0;
					$table->userid 		= $user->get('id');
			
					if (!$table->store()) {
						return JError::raiseWarning( $table->getError() );
					}
				}
				else {
					return JError::raiseWarning( 500, $table->getError() );
				}
			}
		}
		else {
			return JError::raiseWarning( 500, JText::_( 'No items selected' ) );
		}
		$table->reorder();
		$this->setMessage( JText::sprintf( 'Items copied', $n ) );
	}
	
	function orderup()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 
		$filter_order		= $mainframe->getUserStateFromRequest( $option.'filter_order',		'filter_order',		'a.ordering',	'cmd' );
		$filter_order_Dir 	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir', 	'filter_order_Dir', 	'', 											'word');
		$model = $this->getModel('gestionlieux');
		if (($filter_order=='a.ordering')and(($filter_order_Dir=='asc')or(!($filter_order_Dir)))) {
			$model->move(-1);
		};
		if (($filter_order=='a.ordering')and($filter_order_Dir=='desc')) {
			$model->move(1);
		};

		$this->setRedirect( JRoute::_('index.php?option=com_gmapfp&view=gestionlieux&controller=gestionlieux&task=view'));
	}

	function orderdown()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 
		$filter_order		= $mainframe->getUserStateFromRequest( $option.'filter_order',		'filter_order',		'a.ordering',	'cmd' );
		$filter_order_Dir 	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir', 	'filter_order_Dir', 	'', 											'word');
		$model = $this->getModel('gestionlieux');
		
		if (($filter_order=='a.ordering')and(($filter_order_Dir=='asc')or(!($filter_order_Dir)))) {
			$model->move(1);
		};
		if (($filter_order=='a.ordering')and($filter_order_Dir=='desc')) {
			$model->move(-1);
		};

		$this->setRedirect( JRoute::_('index.php?option=com_gmapfp&view=gestionlieux&controller=gestionlieux&task=view'));
	}

	function saveorder()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid 	= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order 	= JRequest::getVar( 'order', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);

		$model = $this->getModel('gestionlieux');
		$model->saveorder($cid, $order);

		$msg = JText::_( 'New ordering saved' );
		$this->setRedirect( JRoute::_('index.php?option=com_gmapfp&view=gestionlieux&controller=gestionlieux&task=view'), $msg );
	}
			
}
?>
