<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.27
	* Creation date: Décembre 2012
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

jimport( 'joomla.application.component.view');

class GMapFPsViewGMapFP extends JView
{
    function display($tpl = null)
    {
		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 
		$Itemid    = JRequest::getInt('Itemid'); 

        $document   =& JFactory::getDocument();

        $params = clone($mainframe->getParams('com_gmapfp'));

        // Parametres
        $params->def('nombre_articles',         4);
        $params->def('show_headings',           1);
        $params->def('show_pagination',         1);
        $params->def('show_pagination_results', 1);
        $params->def('show_pagination_limit',   1);
        $params->def('filter',                  1);

        $limitstart = JRequest::getVar('limitstart', 0, '', 'int');
        $default_limit = $params->get('nombre_articles');
        $limit = $mainframe->getUserStateFromRequest($option.$Itemid.'.limit', 'limit', $default_limit, 'int');

        JRequest::setVar('limit', (int) $limit);

        $total      = & $this->get( 'Total' );
        jimport('joomla.html.pagination');
        $pagination = new JPagination($total, $limitstart, $limit);

        $filtrevilles = array();
        $filtrevilles[] = JHTML::_('select.option', '-- '.JText::_( 'GMAPFP_VILLE_FILTRE' ).' --' );
                $cn = 0;
				$doublon_filtre ='';
                foreach($this->get('listville') as $temp) {
					if ($temp['ville']) {
						if ($temp['ville']!=$doublon_filtre) {
							$cn++;
							$filtrevilles[] = JHTML::_('select.option', $temp['id'], $temp['ville'] );
							$doublon_filtre=$temp['ville'];
						}
					} else {
						//$filtredepartements[] = JHTML::_('select.option', $temp['id'], '?' );
						//$cn++;
					};
                }
        $filtreville = $mainframe->getUserStateFromRequest( $option.$Itemid.'filtreville', 'filtreville', '-- '.JText::_( 'GMAPFP_VILLE' ).' --', 'string' );
        if ($cn>1) {
            $lists['ville'] = JHTML::_('select.genericlist', $filtrevilles, 'filtreville', 'size="1" class="inputbox" onchange="form.submit()"', 'value', 'text', $filtreville );
        }

        $filtredepartements = array();
        $filtredepartements[] = JHTML::_('select.option', '-- '.JText::_( 'GMAPFP_DEPARTEMENT_FILTRE' ).' --' );
                $cn = 0;
				$doublon_filtre ='';
                foreach($this->get('listdepartement') as $temp) {
					if ($temp['departement']) {
						if ($temp['departement']!=$doublon_filtre) {
							$cn++;
							$filtredepartements[] = JHTML::_('select.option', $temp['id'], $temp['departement'] );
							$doublon_filtre=$temp['departement'];
						}
					} else {
						//$filtredepartements[] = JHTML::_('select.option', $temp['id'], '?' );
						//$cn++;
					};
                }
        $filtredepartement = $mainframe->getUserStateFromRequest( $option.$Itemid.'filtredepartement', 'filtredepartement', '-- '.JText::_( 'GMAPFP_DEPARTEMENT' ).' --', 'string' );
        if ($cn>1) {
            $lists['departement'] = JHTML::_('select.genericlist', $filtredepartements, 'filtredepartement', 'size="1" class="inputbox" onchange="form.submit()"', 'value', 'text', $filtredepartement );
        }

        $filtrepayss = array();
        $filtrepayss[] = JHTML::_('select.option', '-- '.JText::_( 'GMAPFP_PAYS_FILTRE' ).' --' );
                $cn = 0;
				$doublon_filtre ='';
                foreach($this->get('listpays') as $temp) {
 					if ($temp['pay']) {
						if ($temp['pay']!=$doublon_filtre) {
							$cn++;
							$filtrepayss[] = JHTML::_('select.option', $temp['id'], $temp['pay'] );
							$doublon_filtre=$temp['pay'];
						}
					} else {
						//$filtrepayss[] = JHTML::_('select.option', $temp['id'], '?' );
						//$cn++;
					};
                }
        $filtrepays = $mainframe->getUserStateFromRequest( $option.$Itemid.'filtrepays', 'filtrepays', '-- '.JText::_( 'GMAPFP_PAYS' ).' --', 'string' );
        if ($cn>1) {
            $lists['pays'] = JHTML::_('select.genericlist', $filtrepayss, 'filtrepays', 'size="1" class="inputbox" onchange="form.submit()"', 'value', 'text', $filtrepays );
        }

        $filtrecategories = array();
        $filtrecategories[] = JHTML::_('select.option', '-- '.JText::_( 'GMAPFP_CATEGORIE_FILTRE' ).' --' );
                $cn = 0;
				if ($this->get('listcategorie')) {
					foreach($this->get('listcategorie') as $temp) {
						$cn++;
						$filtrecategories[] = JHTML::_('select.option', $temp->id, $temp->title );
					}
				};
        $filtrecategorie = $mainframe->getUserStateFromRequest( $option.$Itemid.'filtrecategorie', 'filtrecategorie', '-- '.JText::_( 'GMAPFP_CATEGORIE' ).' --', 'string' );
        if ($cn>1) {
            $lists['categorie'] = JHTML::_('select.genericlist', $filtrecategories, 'filtrecategorie', 'size="1" class="inputbox" onchange="form.submit()"', 'value', 'text', $filtrecategorie );
        }

        $search_gmapfp = $mainframe->getUserStateFromRequest( $option.$Itemid.'search_gmapfp', 'search_gmapfp', '',    'string' );
        $lists['search_gmapfp'] = $search_gmapfp;
        $this->assignRef('lists', $lists);

        $model      = &$this->getModel(); 
        $lieux      = $model->getGMapFPList();
       	$map        = $model->getView();
		$perso		= $model->getPersonnalisation();
		
		$lieu = array();
        $this->assignRef('lieu'          , $lieu );	 
		
        $this->assignRef('map'          , $map );	        
        $this->assignRef('lieux'         , $lieux);
        $this->assignRef('perso'        , $perso);
        $this->assignRef('pagination'   , $pagination);
        $this->assignRef('params'       , $params);
        $this->assign('total',      $total);

		if ($this->params->get('menu-meta_description'))
			$document->setDescription($this->params->get('menu-meta_description'));
		if ($this->params->get('menu-meta_keywords'))
			$document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		if ($this->params->get('robots'))
			$document->setMetadata('robots', $this->params->get('robots'));

        parent::display($tpl);
    }   
}
?>
