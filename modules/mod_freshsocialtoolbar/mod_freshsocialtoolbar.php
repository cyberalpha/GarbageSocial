<?php
/*------------------------------------------------------------------------
# mod_freshsocialtoolbar - Fresh Social Toolbar by Fresh Extension
# author    Fresh Extension http://www.FreshExtension.com
# copyright Copyright (C) 2012 Fresh Extension http://www.FreshExtension.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.FreshExtension.com
# Technical Support:  http://www.FreshExtension.com
-------------------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die;
	
	// parameters
	// jquery
	$jqueryload = $params->get('jqueryload', '1');
	$toolbarheight = $params->get('toolbarheight', '386');
	$topdistance = $params->get('topdistance', '10');
	$faceurl = $params->get('faceurl', '10');
	$direction = $params->get('direction', 'right');
	$showfb = $params->get('showfb', '1');
	$showtw = $params->get('showtw', '1');
	$showtwf = $params->get('showtwf', '1');
	$showtwname = $params->get('showtwname', '0');
	$twurl = $params->get('twurl', '');
	$tweettext = $params->get('tweettext', '');
	$showg = $params->get('showg', '1');
	$showpin = $params->get('showpin', '1');
	$showlinkedin = $params->get('showlinkedin', '1');
	$linkedintype = $params->get('linkedintype', '1');
	$showutube = $params->get('showutube', '1');
	$showrss = $params->get('showrss', '1');
	$youtubeid = $params->get('youtubeid', '');
	$rssurl = $params->get('rssurl', 'http://');
	$twname = $params->get('twname', '');
	$twlang = $params->get('twlang', 'en');
	$bordertype = $params->get('bordertype', '1');
	$lcid = $params->get('lcid', '');
	$toolbaropen = $params->get('toolbaropen', '1');
	// after calling parameters lets add the js and css
	$document =& JFactory::getDocument();
	$baseUrl = JURI::base();
	
	// jquery
	if($jqueryload):
		$document->addScript( 'modules/mod_freshsocialtoolbar/assets/jquery/jquery.min.js' );
	endif;
	
	// css
	$document->addStyleSheet( 'modules/mod_freshsocialtoolbar/assets/css/styles.css' );
	// end adding scripts and css
		
	// get current url, title
	$page_title = $document->getTitle();	
	// include the helper file
	require_once(dirname(__FILE__).DS.'helper.php');
	
	// show default tmpl
	switch ($direction)	{
	case "right":
	// call the items
		require(JModuleHelper::getLayoutPath('mod_freshsocialtoolbar', 'default'));	
	break;
	case "left":
	// call the items
		require(JModuleHelper::getLayoutPath('mod_freshsocialtoolbar', 'left'));	
	break;
	case "top":
	// call the items
		require(JModuleHelper::getLayoutPath('mod_freshsocialtoolbar', 'top'));	
	break;
	case "bottom":
	// call the items
		require(JModuleHelper::getLayoutPath('mod_freshsocialtoolbar', 'bottom'));	
	break;
	}	