<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.12
	* Creation date: Mars 2012
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class GMapFPsViewMarqueurs extends JView
{
	function display($tpl = null)
	{
		$this->form		= $this->get('Form');

		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 
		$controller = JRequest::getWord('controller');

		if (JRequest::getWord('task')=='view') 
		{
			JToolBarHelper::title(   JText::_( 'GMAPFP_MARQUEURS_MANAGER' ), 'checkin.png' );
			JToolBarHelper::addNewX();
			JToolBarHelper::editListX();
			JToolBarHelper::divider();
			JToolBarHelper::publishList();
			JToolBarHelper::unpublishList();
			JToolBarHelper::divider();
			JToolBarHelper::deleteList();
		
			// Get data from the model
			$marqueurs		= & $this->get('List');
		}
		else
		{
			// Get data from the model
			$marqueurs		=& $this->get('Data');
			$isNew		= ($marqueurs->id < 1);
	
			$text = $isNew ? JText::_( 'JTOOLBAR_NEW' ) : JText::_( 'JTOOLBAR_EDIT' );
			JToolBarHelper::title(   JText::_( 'GMAPFP_MARQUEURS_MANAGER' ).': <small>[ ' . $text.' ]</small>', 'checkin.png' );
			JToolBarHelper::apply();
			JToolBarHelper::save();
			if ($isNew)  {
				JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'JTOOLBAR_CLOSE' );
		}
		}
		JHTML::_('behavior.tooltip');

		$this->assignRef('marqueurs', $marqueurs);
		
		$pageNav = & $this->get( 'Pagination' );				
		$this->assignRef('pageNav', $pageNav);

		$filter_order 		= $mainframe->getUserStateFromRequest( $option.$controller.'filter_order', 'filter_order', 'nom', 'cmd');
		$filter_order_Dir 	= $mainframe->getUserStateFromRequest( $option.$controller.'filter_order_Dir', 'filter_order_Dir', '', 'word');
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;
		$this->assignRef('lists', $lists);

		parent::display($tpl);

	}
}
