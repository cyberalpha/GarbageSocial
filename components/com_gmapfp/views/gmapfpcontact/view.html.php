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

class GMapFPsViewGMapFPContact extends JView
{
    function display($tpl = null)
    {
		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 
		$Itemid    = JRequest::getInt('Itemid'); 

        $document   =& JFactory::getDocument();

        $params = clone($mainframe->getParams('com_gmapfp'));

        // Parametres
        $params->def('show_headings',           1);

        $model      = &$this->getModel(); 
        $rows       = $model->getGMapFPList();
		$row		= @$rows[0];
       	$map        = $model->getView();
		$perso		= $model->getPersonnalisation();

		JHTML::_('behavior.formvalidation');
		
        $this->assignRef('map'          , $map );	        
        $this->assignRef('row'         , $row);
        $this->assignRef('perso'        , $perso);
        $this->assignRef('params'       , $params);

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
