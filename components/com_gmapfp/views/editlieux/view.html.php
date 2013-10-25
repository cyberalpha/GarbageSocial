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

class GMapFPsViewEditLieux extends JView
{
	function display($tpl = null)
	{
		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 
		$Itemid    = JRequest::getInt('Itemid'); 
		$layout = JRequest::getVar('layout',  0, '', 'string');
		$document 	=& JFactory::getDocument();

		//only registered user can add events
		$user		= JFactory::getUser();
		$userId		= $user->get('id');

		$config_media =& JComponentHelper::getParams('com_media');
		if ($config_media->get('enable_flash', 0)) {
			//JHTML::_('behavior.uploader', 'file-upload', array('onAllComplete' => 'function(){ MediaManager.refreshFrame(); }'));
		}

		$params = clone($mainframe->getParams('com_gmapfp'));
		/*$niveau_utilisateur_ok=$params->get('gmapfp_acces_groups');
		// Make sure you are logged in and have the necessary access rights
		if ($userId < $niveau_utilisateur_ok) {
			  JResponse::setHeader('HTTP/1.0 403',true);
              JError::raiseWarning( 403, JText::_('JERROR_ALERTNOAUTHOR') );
			return;
		}*/

		//dectection si android pour affichage de léditeur par défaut ou d'une zone textearea
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		define('GMAPFP_ANDROID', stristr($user_agent,'iPhone') || stristr($user_agent,'iPod') || stristr($user_agent,'android'));

		$lang = JFactory::getLanguage(); 
		$tag_lang=(substr($lang->getTag(),0,2)); 
		
		if (!defined( '_JOS_GMAPFP_APIV3' ))
		{
			/** verifi que la fonction n'est défini qu'une faois */
			define( '_JOS_GMAPFP_APIV3', 1 );
		
			$http = strstr(JUri::base(), '://', true);
			$document->addCustomTag( '<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />'); 
			$document->addCustomTag( '<script type="text/javascript" src="'.$http.'://maps.google.com/maps/api/js?sensor=true&language='.$tag_lang.'"></script>'); 
		}

        if (!defined( '_JOS_GMAPFP_LIGHTBOX' ))
        {
            /** verifi que la fonction n'est défini qu'une faois */
            define( '_JOS_GMAPFP_LIGHTBOX', 1 );    
            
            $document->addCustomTag( '<link rel="stylesheet" type="text/css" href="'.JURI::base().'components/com_gmapfp/floatbox/floatbox.css" />');
            $document->addCustomTag( '<script type="text/javascript" src="'.JURI::base().'components/com_gmapfp/floatbox/floatbox.js"></script>');
        }
        
		 /**
		  * Affichage de la barre de menu
		   **/
		$document->addCustomTag ('<link rel="stylesheet" href="'.$this->baseurl.'/components/com_gmapfp/views/editlieux/css/icon.css" type="text/css" media="screen" />');
		$document->addCustomTag ('<link rel="stylesheet" href="'.$this->baseurl.'/components/com_gmapfp/views/editlieux/css/general.css" type="text/css" media="screen" />');
		$document->addCustomTag ('<link rel="stylesheet" href="'.$this->baseurl.'/components/com_gmapfp/views/editlieux/css/medialist-thumbs.css" type="text/css" media="screen" />');

		$items		=& $this->get('Data');
		$marqueurs	=& $this->get('Marqueurs');
		$custom		=& $this->get('Custom');
        $images     =& $this->get('images');
		$isNew		= ($items->id < 1);

		// build the html select list for ordering
		$query = 'SELECT ordering AS value, nom AS text'
			. ' FROM #__gmapfp'
			. ' ORDER BY ordering';

		$lists['ordering'] 			= JHtml::_('list.specificordering',  $items, $items->id, $query );

		// build list of categories
		$select[] = JHtml::_('select.option', '', '-- '.JText::_( 'GMAPFP_SELECT_ITEM' ).' --' );
		$catids = JHtml::_('category.options', 'com_gmapfp');
		$catids = array_merge($select, $catids);
		$lists['catid'] = JHtml::_('select.genericlist', $catids, 'catid', 'size="1" class="inputbox required"', 'value', 'text', intval( $items->catid ) );

		$this->assignRef('config_media',$config_media);
		$this->assignRef('custom',		$custom);
		$this->assignRef('items',		$items);
		$this->assignRef('marqueurs',	$marqueurs);
		$this->assignRef('params',		$params);
		$this->assignRef('lists',		$lists);
		$this->assignRef('images',		$images);

		if ($this->params->get('menu-meta_description'))
			$document->setDescription($this->params->get('menu-meta_description'));
		if ($this->params->get('menu-meta_keywords'))
			$document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		if ($this->params->get('robots'))
			$document->setMetadata('robots', $this->params->get('robots'));

		parent::display($tpl);
	}

    function setImage($index = 0)
    {
        if (isset($this->images[$index])) {
            $this->_tmp_img = &$this->images[$index];
        } else {
            $this->_tmp_img = new JObject;
        }
    }

}
