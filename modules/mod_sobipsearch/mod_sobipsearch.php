<?php

/**
 * @package     Prieco.Modules
 * @subpackage  mod_sobipsearch - Search in Selected Section
 * 
 * @author      Prieco S.A. <support@extly.com>
 * @copyright   Copyright (C) 2010 - 2012 Prieco, S.A. All rights reserved.
 * @license     http://http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL 
 * @link        http://www.prieco.com http://www.extly.com http://support.extly.com 
 */
// No direct access
defined('_JEXEC') or die('Restricted access');

defined('DS') || define('DS', DIRECTORY_SEPARATOR);
define('SOBI_ROOT', JPATH_ROOT);
define('SOBI_PATH', SOBI_ROOT . DS . 'components' . DS . 'com_sobipro');

// Include the syndicate functions only once
require_once dirname(__FILE__) . DS . 'helper.php';

$button = $params->get('button', '');
$imagebutton = $params->get('imagebutton', '');
$button_pos = $params->get('button_pos', 'left');
$button_text = $params->get('button_text', JText::_('Search'));
$width = intval($params->get('width', 20));
$maxlength = $width > 20 ? $width : 20;
$text = $params->get('text', JText::_('search...'));
$set_Itemid = intval($params->get('set_itemid', 0));
$moduleclass_sfx = $params->get('moduleclass_sfx', '');

$listofsections = $params->get('listofsections', null);
$listofsections = modSobipSearchHelper::_cleanListOfNumerics($listofsections);

$mitemid = $set_Itemid > 0 ? $set_Itemid : JRequest::getInt('Itemid');

$islist = (strpos($listofsections, ',') >= 1);
$autocomplete = intval($params->get('autocomplete', 1)) && (!$islist);
$includejs = intval($params->get('includejs', 1));

$inputid = $params->get('inputid', 'sobipSearchBox');

/* --------------------------------------------------------------------- */

$select = null;
$counter = ModSobipSearchHelper::getSearchSectionSelect($moduleclass_sfx, $listofsections, $select);

$autocomplete = (($autocomplete) && ($counter == 1));
$document = & JFactory::getDocument();

if (($autocomplete) && ($includejs))
{
	require_once SOBI_PATH . '/lib/sobi.php';
	Sobi::Init(SOBI_ROOT, JFactory::getConfig()->getValue('config.language'));
	SPLoader::loadClass('mlo.input');
	SPFactory::config()->set('live_site', JURI::root());
	$head = SPFactory::header();
	$head->addJsFile('sobipro');
	$head->send();

	$document->addStyleSheet('media/sobipro/css/jquery-ui/smoothness/smoothness.css');

	$document->addScript('components/com_sobipro/lib/js/jquery.js');
}

$moduleid = $module->id;
$urlbase = JURI::root();

if ($autocomplete)
{
	$jqueryuilib = $urlbase . 'components/com_sobipro/lib/js/jquery-ui.js';
	$document->addScript('modules/mod_sobipsearch/js/search.min.js');

	$document->addScriptDeclaration("var extSearchHelper{$moduleid};");
	$document->addScriptDeclaration(
			"jQuery(document).ready(function() {	
	extSearchHelper{$moduleid} = new ExtSearchHelper3(
	{$listofsections},
	'#{$inputid}{$moduleid}');
	extSearchHelper{$moduleid}.bind('{$jqueryuilib}');
});"
);
};

require JModuleHelper::getLayoutPath('mod_sobipsearch');
