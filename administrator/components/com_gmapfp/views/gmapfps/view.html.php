<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.21
	* Creation date: Août 2012
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class GMapFPsViewGMapFPs extends JView
{
	function display($tpl = null)
	{
		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 

		JToolBarHelper::title(   JText::_( 'GMAPFP_LIEUX_MANAGER' ), 'frontpage.png' );
		JToolBarHelper::addNewX();
		JToolBarHelper::editListX();
		JToolBarHelper::divider();
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::divider();
		JToolBarHelper::customX( 'copy', 'copy.png', 'copy_f2.png', 'Copy' );
		JToolBarHelper::customX( 'user', 'restore.png', 'restore_f2.png', 'User' );
		JToolBarHelper::divider();
		JToolBarHelper::deleteList();
		JToolBarHelper::divider();
		JToolBarHelper::preferences('com_gmapfp');

		JHTML::_('behavior.tooltip');

		// Get data from the model
		$items		= & $this->get( 'Data');
		$total		= & $this->get( 'Total');
		$pageNav 	= & $this->get( 'Pagination' );

		$filtrevilles = array();
		$filtrevilles[] = JHTML::_('select.option', '-- '.JText::_( 'GMAPFP_VILLE_FILTRE' ).' --' );
				foreach($this->get('listville') as $temp) {
					$filtrevilles[] = JHTML::_('select.option', $temp->ville );
				}

		$filtredepartements = array();
		$filtredepartements[] = JHTML::_('select.option', '-- '.JText::_( 'GMAPFP_DEPARTEMENT_FILTRE' ).' --' );
				foreach($this->get('listdepartement') as $temp) {
					$filtredepartements[] = JHTML::_('select.option', $temp->departement );
				}

		$filter_order		= $mainframe->getUserStateFromRequest( $option.'filter_order',		'filter_order',		'a.ordering',	'cmd' );
		$filter_order_Dir 	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir', 	'filter_order_Dir', 	'', 											'word');
		$search				= $mainframe->getUserStateFromRequest( $option.'search', 			'search', 				'',												'string' );
		$filtreville 		= $mainframe->getUserStateFromRequest( $option.'filtreville', 		'filtreville', 			'-- '.JText::_( 'GMAPFP_VILLE' ).' --', 		'string' );
		$filtredepartement 	= $mainframe->getUserStateFromRequest( $option.'filtredepartement', 'filtredepartement', 	'-- '.JText::_( 'GMAPFP_DEPARTEMENT' ).' --', 	'string' );
		$filtrecategorie 	= $mainframe->getUserStateFromRequest( $option.'filtrecategorie', 	'filtrecategorie', 		'-- '.JText::_( 'GMAPFP_CATEGORIE' ).' --', 	'int' );

		$lists['ville'] 		= JHTML::_('select.genericlist', $filtrevilles, 'filtreville', 'size="1" class="inputbox" onchange="form.submit()"', 'value', 'text', $filtreville );
		$lists['departement'] 	= JHTML::_('select.genericlist', $filtredepartements, 'filtredepartement', 'size="1" class="inputbox" onchange="form.submit()"', 'value', 'text', $filtredepartement );
		$lists['categorie'] 	= JHTML::_('list.category',  'filtrecategorie', $option, intval( $filtrecategorie ), 'onchange="form.submit()"');

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;

		// search filter
		$lists['search'] = $search;
		
		$this->assignRef('lists', $lists);
		$this->assignRef('items',	$items);
		$this->assignRef('pageNav', $pageNav);

		parent::display($tpl);

	}
}
