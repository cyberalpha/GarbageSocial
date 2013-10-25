<?php defined('_JEXEC') or die('Restricted access');
/*
This file is part of "Content Map Joomla Extension".
Author: Open Source solutions http://www.opensourcesolutions.es

You can redistribute and/or modify it under the terms of the GNU
General Public License as published by the Free Software Foundation,
either version 2 of the License, or (at your option) any later version.

GNU/GPL license gives you the freedom:
* to use this software for both commercial and non-commercial purposes
* to share, copy, distribute and install this software and charge for it if you wish.

Under the following conditions:
* You must attribute the work to the original author

This software is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this software.  If not, see http://www.gnu.org/licenses/gpl-2.0.html.

@copyright Copyright (C) 2012 Open Source Solutions S.L.U. All rights reserved.
*/

// Avoid multiple instances of the same module when called by both template and content (using loadposition)
if (isset($GLOBALS["contentmap_mid_" . $module->id])) return;
else $GLOBALS["contentmap_mid_" . $module->id] = true;

// Load shared language files for frontend side
require_once(JPATH_ROOT . "/libraries/contentmap/language/contentmap.inc");

// Api key parameter for Google map
$api_key = $params->get('api_key', NULL);
$api_key = $api_key ? "&amp;key=" . $api_key : "";

// Language parameter for Google map
// See Google maps Language coverage at https://spreadsheets.google.com/pub?key=p9pdwsai2hDMsLkXsoM05KQ&gid=1
// Use JFactory::getLanguage(), because we can't rely on $lang variable
$language = JFactory::getLanguage()->get("tag", NULL);
$language = $language ? "&amp;language=" . $language : "";

// Itemid required in order to build SEF links (see markers.php)
/*
$itemid = JFactory::getApplication()->getMenu()->getActive();
$itemid = $itemid ? "&amp;Itemid=" . $itemid->id : "";
*/
$menu = JFactory::getApplication()->getMenu();
$itemid = $menu->getActive() or $itemid = $menu->getDefault();
$itemid = "&amp;Itemid=" . $itemid->id;

// Used by templates
$document = JFactory::getDocument();

echo "<!-- mod_contentmap " . $GLOBALS["contentmap"]["version"] . "-->";
$prefix = JURI::base(true) . "/index.php?option=com_contentmap&amp;view=smartloader";
$postfix = "&amp;owner=module&amp;id=" . $module->id . $itemid;
require JModuleHelper::getLayoutPath($app->scope, $params->get('layout', 'default'));
$icons = icons_path(JPATH_ROOT . DS . "media" . DS . "contentmap") . DS . "markers" . DS . "icons";
