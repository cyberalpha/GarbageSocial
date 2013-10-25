<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.29
	* Creation date: Janvier 2013
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class GMapFPsViewGMapFP extends JView
{
	function display($tpl = null)
	{
		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 

        $lang 		= JFactory::getLanguage(); 
        $tag_lang	= $lang->getTag();
		if (($tag_lang!='en-AU') AND ($tag_lang!='en-GB') AND ($tag_lang!='pt-BR') AND ($tag_lang!='pt-PT') AND ($tag_lang!='zh-CN') AND ($tag_lang!='zh-TW'))
			{$tag_lang=(substr($lang->getTag(),0,2)); };

		$http = strstr(JUri::base(), '://', true);
		$this->document->setMetaData('viewport', 'initial-scale=1.0, user-scalable=no');
        $this->document->addCustomTag( '<script type="text/javascript" src="'.$http.'://maps.googleapis.com/maps/api/js?sensor=true&language='.$tag_lang.'"></script>'); 

		$gmapfp		=& $this->get('Data');
		$marqueurs	=& $this->get('Marqueurs');
		$isNew		= ($gmapfp->id < 1);
		
 
		//die(print_r(JFactory::getConfig()));
		//die(print_r($this->_path['template']));
		$config =& JComponentHelper::getParams('com_gmapfp');

			$text = $isNew ? JText::_( 'JTOOLBAR_NEW' ) : JText::_( 'JTOOLBAR_EDIT' );
		JToolBarHelper::title(   JText::_( 'GMAPFP_LIEUX_MANAGER' ).': <small>[ ' . $text.' ]</small>', 'frontpage.png' );
		JToolBarHelper::apply();
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'JTOOLBAR_CLOSE' );
		}
		JHTML::_('behavior.tooltip');

		// build the html select list for ordering
		$query = 'SELECT ordering AS value, nom AS text'
			. ' FROM #__gmapfp'
			//. ' WHERE catid = ' . (int) $gmapfp->catid
			. ' ORDER BY ordering';

		$lists['ordering'] 			= JHTML::_('list.specificordering',  $gmapfp, $gmapfp->id, $query );

		// build list of categories
		//$lists['catid'] 	= JHTML::_('list.category',  'catid', $option, intval( $gmapfp->catid ) );
	//public static function category($name, $extension, $selected = NULL, $javascript = NULL, $order = null, $size = 1, $sel_cat = 1)
		$categories = JHtml::_('category.options', $option);
		array_unshift($categories, JHTML::_('select.option',  '', JText::_('JOPTION_SELECT_CATEGORY')));
		$lists['catid'] = JHTML::_(
			'select.genericlist',
			$categories,
			'catid',
			'class="inputbox required" size="1" ',
			'value', 'text',
			intval( $gmapfp->catid )
		);


		$this->assignRef('gmapfp',		$gmapfp);
		$this->assignRef('marqueurs',	$marqueurs);
		$this->assignRef('config',	$config);
		$this->assignRef('lists',		$lists);

		parent::display($tpl);
	}
}
