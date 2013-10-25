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

$list = ModSobiproCategoriesHelper::getListNLevel($parentid, $categorystartlevel, $categorymode, $count, $sorder, $require_stats, $isMultimode, $debug);

$sectionid = $parentid;
$parents = array_keys($list);

if ((!count($list)) || ($list[$sectionid] == null))
{
	echo 'Empty Section';
	return;
}

echo "<ul class=\"sobipcateg{$moduleclass_sfx}\">";
echo ModSobiproCategoriesHelper::generate(
		$list, $sectionid,
		$actual_sid, $scitemid, $subItemsid, $defaultItemid,
		$scounter, $hide_empty, $categorystartlevel, $categorymode
		);
echo '</ul>';
