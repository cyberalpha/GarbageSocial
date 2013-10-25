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
	if (empty($GLOBALS["contentmap"]["gapi"]))
	{
		// Add Google api to the document only once
		$document->addScript("http://maps.google.com/maps/api/js?sensor=false" . $language . $api_key);
		$GLOBALS["contentmap"]["gapi"] = true;
	}

	$stylesheet = pathinfo($params->get("css", "default"));
	$document->addStyleSheet($prefix . "&amp;type=css&amp;filename=" . $stylesheet["filename"] . $postfix);
	/*
	if ($params->get("data_source", NULL))
	$document->addScript($params->get("data_url") . "?source=custom" . $postfix);
	else
	$document->addScript($prefix . "&amp;type=json&amp;filename=articlesmarkers&amp;source=articles" . $postfix);
	*/

	switch ($params->get("data_source", "0"))
	{
		case "0":
			$document->addScript($prefix . "&amp;type=json&amp;filename=articlesmarkers&amp;source=articles" . $postfix);
			break;
		case "1":
			$document->addScript($params->get("data_url") . "?source=custom" . $postfix);
			break;
		default:
			$document->addScript(JURI::base(true) . "/libraries/contentmap/json/" . $params->get("data_source") . ".php?source=custom" . $postfix);
	}

	if ($params->get("cluster", "1"))
	{
		$document->addScript(JURI::base(true) . "/libraries/contentmap/js/markerclusterer_compiled.js");
	}

	$document->addScript($prefix . "&amp;type=js&amp;filename=map" . $postfix);
?>

<div id="contentmap_wrapper_module_<?php echo $module->id; ?>">
	<div id="contentmap_container_module_<?php echo $module->id; ?>">
		<div id="contentmap_module_<?php echo $module->id; ?>">
			<noscript><?php echo JText::_("CONTENTMAP_JAVASCRIPT_REQUIRED"); ?></noscript>
		</div>
	</div>
</div>
