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

jimport('joomla.event.plugin');

class plgContentcontentmap extends JPlugin
{
	protected $document;


	public function __construct(&$subject, $config = array())
	{
		$this->document = JFactory::getDocument();
		parent::__construct($subject, $config);
	}


	function onContentPrepareForm($form, $data)
	{
		// Only works on JForms
		if (!($form instanceof JForm)) return false;

		// which belong to the following components
		$components_list = array(
			"com_content.article",
			"com_flexicontent.item"
		);
		if (!in_array($form->getName(), $components_list)) return true;

		JHtml::_('behavior.framework', true);

		$this->document->addStyleSheet("../plugins/content/contentmap/css/picker.css");
		$this->document->addScript("../plugins/content/contentmap/js/api.js");
		//$this->document->addScript(JURI::root(true) . "/libraries/contentmap/js/geopicker-min.js");
		$this->document->addScript(JURI::root(true)
			. "/index.php"
			. "?option=com_contentmap"
			. "&amp;view=smartloader"
			. "&amp;owner=article"
			. "&amp;id=" . $data->id
			. "&amp;type=js"
			. "&amp;filename=geopicker");

		require_once(JPATH_ROOT . DS . "libraries" . DS . "contentmap" . DS . "language" . DS . "contentmap.inc");
		if ($GLOBALS["contentmap"]["version"][strlen($GLOBALS["contentmap"]["version"]) - 1] == " ")
		{
			$this->document->addStyleSheet("../plugins/content/contentmap/css/picker.css");
			$this->document->addScript(JURI::root(true)
				. "/index.php"
				. "?option=com_contentmap"
				. "&amp;view=smartloader"
				. "&amp;owner=article"
				. "&amp;id=" . $data->id
				. "&amp;type=js"
				. "&amp;filename=register");
			return "";
		}

		return true;
	}


	function onContentAfterDisplay($context, $article, $params, $offset = 0)
	{
		if (JRequest::getCmd("option") != "com_content" || JRequest::getCmd("view") != "article") return;

		// Beware:
		// components/com_content/views/article/view.html.php trigs onContentAfterDisplay and passes $article->metadata as JRegistry while
		// modules/mod_articles_news/helper.php trigs onContentAfterDisplay but passes $article->metadata as string
		// String to JRegistry conversion if needed
		if (is_string($article->metadata)) $article->metadata = new JRegistry($article->metadata);

		// Does current article have a map?
		$xreference = $article->metadata->get("xreference");
		//$pattern = '/[+-]?([0-9]+)(\.[0-9]+)?,( +)?[+-]?([0-9]+)(\.[0-9]+)?/';
		$pattern = '/[+-]?[0-9]{1,2}([.][0-9]{1,})?[ ]{0,},[ ]{0,}[+-]?[0-9]{1,3}([.][0-9]{1,})?/';
		if (!(bool)preg_match($pattern, $xreference)) return;

		// Load shared language files for frontend side
		require_once(JPATH_ROOT . DS . "libraries" . DS . "contentmap" . DS . "language" . DS . "contentmap.inc");

		// Api key parameter for Google map
		$api_key = $this->params->get('api_key', NULL);
		$api_key = $api_key ? "&amp;key=" . $api_key : "";

		// Language parameter for Google map
		// See Google maps Language coverage at https://spreadsheets.google.com/pub?key=p9pdwsai2hDMsLkXsoM05KQ&gid=1
		// Use JFactory::getLanguage(), because we can't rely on $lang variable
		$language = JFactory::getLanguage()->get("tag", NULL);
		$language = $language ? "&amp;language=" . $language : "";

		// Plugin id passed to the component
		$db = JFactory::getDbo();
		jimport("joomla.database.databasequery");
		$query = $db->getQuery(true);
		$query->select("extension_id");
		$query->from("#__extensions");
		$query->where("element = 'contentmap'");
		$query->where("client_id = 0");
		$query->where("type = 'plugin'");
		$db->setQuery($query);
		$id = $db->loadResult() or $id = 0;

		// Itemid required in order to build SEF links (see markers.php)
		/*
		$itemid = JFactory::getApplication()->getMenu()->getActive();
		$itemid = $itemid ? "&Itemid=" . $itemid->id : "";
		*/
		$menu = JFactory::getApplication()->getMenu();
		$itemid = $menu->getActive() or $itemid = $menu->getDefault();
		$itemid = "&amp;Itemid=" . $itemid->id;
		$template = "template";
		$article->text .= "<!-- plg_contentmap " . $GLOBALS["contentmap"]["version"] . "-->";

		if (empty($GLOBALS["contentmap"]["gapi"]))
		{
			// Add Google api to the document only once
			$this->document->addScript("http://maps.google.com/maps/api/js?sensor=false" . $language . $api_key);
			$GLOBALS["contentmap"]["gapi"] = true;
		}

		$prefix = JURI::base(true) . "/index.php?option=com_contentmap&amp;owner=plugin&amp;view=smartloader&amp;id=" . $id . $itemid;

		$stylesheet = pathinfo($this->params->get("css", "default"));
		$this->document->addStyleSheet($prefix . "&amp;type=css&amp;filename=" . $stylesheet["filename"]);
		// Necessario perche' in map.php per default il raggruppamento e' attivo per chiunque, plugin compreso! :(
		$this->document->addScript(JURI::base(true) . "/libraries/contentmap/js/markerclusterer_compiled.js");
		$this->document->addScript($prefix . "&amp;type=json&amp;filename=articlesmarkers&amp;source=article&amp;contentid=" . $article->id);
		$this->document->addScript($prefix . "&amp;type=js&amp;filename=map");

		$article->text .= $template($id, JText::_("CONTENTMAP_JAVASCRIPT_REQUIRED"));
	}
}
