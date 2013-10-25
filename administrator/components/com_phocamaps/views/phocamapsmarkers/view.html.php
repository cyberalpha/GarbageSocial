<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );
 
class PhocaMapsCpViewPhocaMapsMarkers extends JView
{
	protected $items;
	protected $pagination;
	protected $state;
	
	function display($tpl = null) {
		
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');

		JHTML::stylesheet('administrator/components/com_phocamaps/assets/phocamaps.css' );
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
		$this->addToolbar();
		parent::display($tpl);
		
	}
	
	function addToolbar() {
	
		require_once JPATH_COMPONENT.'/helpers/phocamapsmarkers.php';
	
		$state	= $this->get('State');
		$canDo	= PhocaMapsMarkersHelper::getActions($state->get('filter.marker_id'));
	
		JToolBarHelper::title( JText::_( 'COM_PHOCAMAPS_MARKERS' ), 'marker.png' );
	
		if ($canDo->get('core.create')) {
			JToolBarHelper::addNew('phocamapsmarker.add','JTOOLBAR_NEW');
		}
	
		if ($canDo->get('core.edit')) {
			JToolBarHelper::editList('phocamapsmarker.edit','JTOOLBAR_EDIT');
		}
		if ($canDo->get('core.edit.state')) {

			JToolBarHelper::divider();
			JToolBarHelper::custom('phocamapsmarkers.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			JToolBarHelper::custom('phocamapsmarkers.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
		}
	
		if ($canDo->get('core.delete')) {
			JToolBarHelper::deleteList( 'COM_PHOCAMAPS_WARNING_DELETE_ITEMS', 'phocamapsmarkers.delete', 'COM_PHOCAMAPS_DELETE');
		}
		JToolBarHelper::divider();
		JToolBarHelper::help( 'screen.phocamaps', true );
	}
	
}
?>