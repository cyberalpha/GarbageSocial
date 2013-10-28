<?php
/*
# ------------------------------------------------------------------------
# ZTTools plugin for Joomla 2.5.0
# ------------------------------------------------------------------------
# Copyright(C) 2008-2012 www.zootemplate.com. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: ZooTemplate
# Websites: http://www.zootemplate.com
# ------------------------------------------------------------------------
*/

defined('_JEXEC') or die();
jimport('joomla.plugin.plugin');
jimport('joomla.application.module.helper');
jimport('joomla.html.parameter');

require_once(dirname(__FILE__) . DS . 'plg_ztools' . DS . 'define.php');
require_once(dirname(__FILE__) . DS . 'plg_ztools' . DS . 'common.php');

class plgSystemPlg_ZTools extends JPlugin
{
	
	var $plugin 		= null;
	var $plgParams 		= null;
	var $time 			= 0;
	var $_cache 		= null;
	var $_components	= null;
	
	function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);
		$this->plugin 		= &JPluginHelper::getPlugin('system', 'plg_ztools');
		$this->plgParams 	= new JParameter($this->plugin->params);
		
		//Get exclude categories
		$components	= $this->plgParams->get('components', '');
		$this->_components 	= (is_array($components)) ? $components : array($components);
		
		//Set the language in the class
		$config = JFactory::getConfig();
		$options = array(
			'cachebase'		=> JPATH_ROOT.DS."cache",
			'lifetime'		=> (int)($this->plgParams->get('gzip_lifetime', 15) * 60),
			'defaultgroup'	=> 'page',
			'browsercache'	=> ($this->plgParams->get('gzip_browsercache', 0)) ? true : false,
			'caching'		=> false,
		);

		jimport('joomla.cache.cache');
		$this->_cache = JCache::getInstance('page', $options);
	}		
	
	function checkCurrentComp()
	{
		global $mainframe, $option;
		$return = true;
		$option = JRequest::getVar('option');
		$view	= JRequest::getVar('view');
		
		if(in_array($option, $this->_components)) {
			$return = false;
		}
		if(in_array($option.'.'.$view, $this->_components)) {
			$return = false;
		}
		
		return $return;		
	}
	
	function onAfterInitialise()
	{
		if($this->plgParams->get('gzip_browsercache', 0))
		{
			global $_PROFILER;
			$app  = JFactory::getApplication();
			$user = JFactory::getUser();
	
			if($app->isAdmin() || JDEBUG){return;}
	
			if(!$user->get('guest') && $_SERVER['REQUEST_METHOD'] == 'GET' && $this->checkCurrentComp()) {
				$this->_cache->setCaching(true);
			}
			
			$data  = $this->_cache->get();
	
			if($data !== false)
			{
				JResponse::setBody($data);
				echo JResponse::toString($app->getCfg('gzip'));
	
				if(JDEBUG)
				{
					$_PROFILER->mark('afterCache');
					echo implode('', $_PROFILER->getBuffer());
				}
	
				$app->close();
			}
		}
	}
	
	function onContentPrepareForm($form, $data)
	{
		if($form->getName()=='com_menus.item')
		{
			JForm::addFormPath(JPATH_SITE . DS . ZT_4BACKEND_MENU_PARAMS);
			$form->loadFile('params', false);
		}
	}
	
	function onAfterRender()
	{
		global $app;		
		$document = &JFactory::getDocument();
		$option   = JRequest::getVar('option', '');
		$task	  = JRequest::getVar('task', '');
		
		if($app->isSite() && $document->_type == 'html' && !$app->getCfg('offline') 
		&& (!($option == 'com_content' && $task =='edit')))
		{
			ZTimport('plg_ztools.libs.ztgzip');
			$Gzip = new ZTGzip;
			
			if($this->plgParams->get('gzip_lazyload', 0)) $Gzip->lazyload();
			if($app->getTemplate(true)->params->get('gzip_optimize_js', 0)) $Gzip->optimizejs();
			if($app->getTemplate(true)->params->get('gzip_optimize_css', 0)) $Gzip->optimizecss();
			if($app->getTemplate(true)->params->get('gzip_optimize_html', 1)) $Gzip->optimizehtml();
			
			$type	= JRequest::getVar('type');
			$action = JRequest::getVar('action');
			if($type == 'plugin' && $action == 'clearCache')
				$Gzip->clearCache();
			
			if($this->plgParams->get('gzip_browsercache', 0))
			{
				$user = JFactory::getUser();
				if(!$user->get('guest')) {
					//We need to check again here, because auto-login plugins have not been fired before the first aid check
					$this->_cache->store();
				}
			}
		}
		else
		{
			$uri 	= str_replace(DS, "/", str_replace(JPATH_SITE, JURI::base(), dirname(__FILE__)));
			$uri 	= str_replace("/administrator/", "", $uri);
			$html 	= '<script language="javascript" type="text/javascript" 
			src="'.$uri.'/plg_ztools/4backend/menu/element/assets/js/bt_clear_cache.js"></script>';
			$buffer = JResponse::getBody ();
			$buffer = preg_replace('/<\/head>/', $html . "\n</head>", $buffer);
			JResponse::setBody($buffer);						
		}
	}
}
?>