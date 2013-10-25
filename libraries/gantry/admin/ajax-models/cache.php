<?php
/**
 * @version   $Id: cache.php 2466 2012-08-17 03:30:15Z btowles $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2012 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */
defined('JPATH_BASE') or die();

/** @var $gantry Gantry */
global $gantry;

$action = JRequest::getString('action');
gantry_import('core.gantryjson');


switch ($action) {
	case 'clear':
		echo gantryAjaxClearGantryCache();
		break;
	default:
		echo "error";
}

function gantryAjaxClearGantryCache()
{
	/** @var $gantry Gantry */
	global $gantry;
	$admincache = GantryCache::getCache(GantryCache::ADMIN_GROUP_NAME, null, true);
	$admincache->clearGroupCache();
	$sitecache = GantryCache::getCache(GantryCache::GROUP_NAME, null, true);
	$sitecache->clearGroupCache();
	return JText::_('Gantry caches cleared.');
}
