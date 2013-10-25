<?php

/**
 * @package     Extly.Modules
 * @subpackage  mod_sobipro_categories - Categories of SobiPro
 * 
 * @author      Prieco S.A. <support@extly.com>
 * @copyright   Copyright (C) 2007 - 2012 Prieco, S.A. All rights reserved.
 * @license     http://http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL 
 * @link        http://www.prieco.com http://www.extly.com http://support.extly.com 
 */
// No direct access
defined('_JEXEC') or die('Restricted access');

defined('DS') || define('DS', DIRECTORY_SEPARATOR);
defined('SOBI_ROOT') || define('SOBI_ROOT', JPATH_ROOT);
defined('SOBI_PATH') || define('SOBI_PATH', SOBI_ROOT . DS . 'components' . DS . 'com_sobipro');

require_once SOBI_PATH . '/lib/sobi.php';
Sobi::Init(SOBI_ROOT, JFactory::getConfig()->getValue('config.language'));
SPLoader::loadClass('mlo.input');
SPFactory::config()->set('live_site', JURI::root());

// Include the syndicate functions only once
require_once dirname(__FILE__) . DS . 'helper.php';
require_once dirname(__FILE__) . DS . 'stats.php';

/* --------------------------------------------------------------- */

// Section Id
$parentid = $params->get('parentid', null);
if (count($parentid) > 0)
{
	$parentid = $parentid[0];
}

// To force a global itemid
$scitemid = $params->get('scitemid', null);

$count = intval($params->get('count', 100));
$sorder = intval($params->get('sorder', 0));

$scounter = intval($params->get('scounter', 0));

$categorymode = intval($params->get('categorymode', 1));

$hide_empty = intval($params->get('hide_empty', false));
$require_stats = (($hide_empty) || ($scounter == 2));

// Default Itemid
$defaultItemid = ModSobiproCategoriesHelper::getDefaultItemid($parentid);

$categorystartlevel = intval($params->get('categorystartlevel', 1));

$moduleclass_sfx = $params->get('moduleclass_sfx', null);

$debug = intval($params->get('debug', 0));

/* --------------------------------------------------------------- */

// Current Url, SID
$raw_sid_full = JRequest::getVar('sid');
$actual_sid_full = explode(":", $raw_sid_full);
$actual_sid = (count($actual_sid_full) == 2 ? $actual_sid_full[0] : null);

// Specific Itemid per category
$subItemsid = ModSobiproCategoriesHelper::getSubItemsid($parentid);

// Multimode
$isMultimode = ModSobiproCategoriesHelper::getMultimode($debug);

if ($require_stats)
{
	if (ModSobiproCategoriesStatsHelper::init())
	{
		$totals = ModSobiproCategoriesStatsHelper::calculateTotalEntries($parentid, $debug);
	}
	else
	{
		$require_stats = false;
		$hide_empty = false;
		$scounter = 0;
	}

	if ($debug)
	{
		echo 'totals: ' . print_r($totals, true);
	}
}

require JModuleHelper::getLayoutPath('mod_sobipro_categories');
