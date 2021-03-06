<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.27
	* Creation date: D�cembre 2012
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class GMapFPsViewGestionLieux extends JView
{
	function display($tpl = null)
	{
		$mainframe 	=& JFactory::getApplication(); 
		$option    	=  JRequest::getCMD('option', ''); 
		$document 		=& JFactory::getDocument();

		//only registered user can add events
		$user		= JFactory::getUser();
		$userId		= $user->get('id');

		$params = clone($mainframe->getParams('com_gmapfp'));
		$niveau_utilisateur_ok=$params->get('gmapfp_acces_groups');
		
		// Make sure you are logged in and have the necessary access rights
		if ($userId < $niveau_utilisateur_ok) {
			  JResponse::setHeader('HTTP/1.0 403',true);
              JError::raiseWarning( 403, JText::_('JERROR_ALERTNOAUTHOR') );
			return;
		}

		 /**
		  * Affichage de la barre de menu
		   **/
		$document->addCustomTag ('<link rel="stylesheet" href="'.$this->baseurl.'/components/com_gmapfp/views/editlieux/css/icon.css" type="text/css" media="screen" />');
		$document->addCustomTag ('<link rel="stylesheet" href="'.$this->baseurl.'/components/com_gmapfp/views/editlieux/css/general.css" type="text/css" media="screen" />');

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

		$filtrecategories = array();
		$select[] = JHTML::_('select.option', '', '-- '.JText::_( 'GMAPFP_CATEGORIE_FILTRE' ).' --');
		$filtrecategories = JHtml::_('category.options', 'com_gmapfp');
		$filtrecategories = array_merge($select, $filtrecategories);

		$filter_order		= $mainframe->getUserStateFromRequest( $option.'filter_order',		'filter_order',		'a.ordering',	'cmd' );
		$filter_order_Dir 	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir', 	'filter_order_Dir', 	'', 											'word');
		$search				= $mainframe->getUserStateFromRequest( $option.'search', 			'search', 				'',												'string' );
		$filtreville 		= $mainframe->getUserStateFromRequest( $option.'filtreville', 		'filtreville', 			'-- '.JText::_( 'GMAPFP_VILLE' ).' --', 		'string' );
		$filtredepartement 	= $mainframe->getUserStateFromRequest( $option.'filtredepartement', 'filtredepartement', 	'-- '.JText::_( 'GMAPFP_DEPARTEMENT' ).' --', 	'string' );
		$filtrecategorie 	= $mainframe->getUserStateFromRequest( $option.'filtrecategorie', 	'filtrecategorie', 		'-- '.JText::_( 'GMAPFP_CATEGORIE' ).' --', 	'string' );

		$lists['ville'] 		= JHTML::_('select.genericlist', $filtrevilles, 'filtreville', 'size="1" class="inputbox" onchange="form.submit()"', 'value', 'text', $filtreville );
		$lists['departement'] 	= JHTML::_('select.genericlist', $filtredepartements, 'filtredepartement', 'size="1" class="inputbox" onchange="form.submit()"', 'value', 'text', $filtredepartement );
		$lists['categorie'] 	= JHTML::_('select.genericlist', $filtrecategories, 'filtrecategorie', 'size="1" class="inputbox" onchange="form.submit()"', 'value', 'text', $filtrecategorie );

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;

		// search filter
		$lists['search'] = $search;
		
		$this->assignRef('lists', $lists);
		$this->assignRef('items',	$items);
		$this->assignRef('pageNav', $pageNav);
		$this->assignRef('params', $params);

		if ($this->params->get('menu-meta_description'))
			$document->setDescription($this->params->get('menu-meta_description'));
		if ($this->params->get('menu-meta_keywords'))
			$document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		if ($this->params->get('robots'))
			$document->setMetadata('robots', $this->params->get('robots'));

		parent::display($tpl);

	}

	public static function published($value, $i)
	{
		if (is_object($value)) {
			$value = $value->published;
		}
		$img	= $value ? 'components/com_gmapfp/views/editlieux/toolbar/tick.png' : 'components/com_gmapfp/views/editlieux/toolbar/publish_x.png';
		$task	= $value ? 'unpublish' : 'publish';
		$alt	= $value ? JText::_('JPUBLISHED') : JText::_('JUNPUBLISHED');
		$action = $value ? JText::_('JLIB_HTML_UNPUBLISH_ITEM') : JText::_('JLIB_HTML_PUBLISH_ITEM');

		$href = '
		<a href="javascript:void(0);" onclick="return listItemTask(\'cb'. $i .'\',\''. $task .'\')" title="'. $action .'">'.
		'<img src="'.$img.'" alt="'.$alt.'"/>';

		return $href;
	}
}
