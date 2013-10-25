<?php defined('_JEXEC') or die('Restricted access');

$source = JRequest::getVar("source", "", "GET");
// Only admit lowercase a-z, underscore and minus. Forbid numbers, symbols, slashes and other stuff.
// For your security, *don't* touch the following regular expression.
preg_match('/^[a-z_-]+$/', $source) or $source = "invalid";

$classname = $source . "GoogleMapMarkers";
// Call the helper to load data
$markers = new $classname($this->Params);
$markers->PrepareInfoWindows();

// Load additional data
$markers_icon = $this->Params->get("markers_icon", NULL);
$markers_icon = $markers_icon ? '"icon":' . json_encode(JURI::base(true) . '/media/contentmap/markers/icons/' . $markers_icon) . ',' : "";

$source =
$markers_icon .
'"places":' . $markers->asJSON();
echo $source;


// Required for ContentHelperRoute::getArticleRoute()
require_once(JPATH_SITE . DS . "components" . DS . "com_content" . DS . "helpers" . DS . "route.php");
require_once(JPATH_ROOT . DS . "libraries" . DS . "contentmap" . DS . "language" . DS . "contentmap.inc");

abstract class GoogleMapMarkers
{
	public $Contents;
	// Values used in order to automatically scale and center the map
	public $Zoom;
	protected $Params;

	abstract protected function Load();

	public function __construct(&$params)
	{
		$this->Params = $params;
		//$load = "load_" . JRequest::getVar("owner", "", "GET");
		//$this->$load();
		$this->Load();

		// Set default zoom level to 17, just in case we are on the module and (sad but true, it can happen) there is only one marker
		$this->Zoom = $this->Params->get('zoom', 17);
	}


	public function PrepareInfoWindows()
	{
		require_once JPATH_SITE . "/components/com_content/helpers/route.php";

		//$baseuri = str_replace("modules/mod_contentmap/lib", "", JURI::base(true));
		foreach ($this->Contents as &$content)
		{
			$content["html"] = "";

			// We haven't the active menu item, since we are acting in background, so we hope it is in the URL request
			// Itemid variable influences ContentHelperRoute::getArticleRoute() link creation
			$unsef_link = ContentHelperRoute::getArticleRoute($content["id"], $content["catid"]);

			// Sef Link examples:
			// without &Itemid : http://site/index.php/component/content/article/2-categoryalias/2-articlealias - This is always valid
			// with &Itemid :    http://site/index.php/2-categoryalias/2-articlealias - Generated if the homepage is a blog item
			// with &Itemid :    http://site/index.php/blog/2-categoryalias/2-articlealias - Generated if the homepage is *not* a blog item
			$sef_link = JRoute::_($unsef_link);

			// Prepare the title
			if ($this->Params->get('show_title', 0))
			{
				$content["html"] .= "<h3>";
				$content["html"] .= $content["title"];

				if ($this->Params->get('link_titles', 0))
				{
					$target = ' target="' . $this->Params->get("link_target", "_self") . '"';
					$content["html"] =
					'<a href="' . $sef_link . '"' . $target . '>' .
					$content["html"] .
					"</a>";
				}

				$content["html"] .= "</h3>";
			}
			unset($content["id"]);
			unset($content["alias"]);
			unset($content["catid"]);
			// Article url is useful when Marker action is set to "directly redirect", rather than "open the infowindow"
			$content["article_url"] = $sef_link;

			// Prepare the image
			if ($this->Params->get('show_image', 0) && $content["image"])
			{
				// Image size
				$format = "";
				if (function_exists("getimagesize"))
				{
					$size = getimagesize(JPATH_SITE . "/" . $content["image"]);
					$format = " " . $size[3];
				}

				// Add the base url to the image. Used by both infowindow innerhtml and preload() function
				$content["image"] = JURI::base(true) . "/" . $content["image"];
				// Image URL
				$content["html"] .=
				"<div style=\"float:" . $content["float_image"] . ";\">" .
				"<img class=\"intro_image\"" .
				$format .
				" src=\"" . $content["image"] . "\"";
				if ($content["image_intro_alt"]) $content["html"] .= " alt=\"" . $content["image_intro_alt"] . "\"";
				if ($content["image_intro_caption"]) $content["html"] .= " title=\"" . $content["image_intro_caption"] . "\"";
				$content["html"] .= ">" .
				"</div>";
			}
			else
			{
				$content["image"] = NULL;
			}
			unset($content["image_intro_alt"]);
			unset($content["image_intro_caption"]);
			unset($content["float_image"]);
			// unset($content["image"]);

			// Other content
			if ($this->Params->get('show_created_by_alias', 0) && $content["created_by_alias"])
			{
				$content["html"] .= "<div class=\"created_by_alias\">" . $content["created_by_alias"] . "</div>";
			}
			unset($content["created_by_alias"]);

			if ($this->Params->get('show_created', 0) && $content["created"] != "0000-00-00 00:00:00")
			{
				// Search for the first empty space into the string
				//$offset = strpos($content["created"], " ") or $offset = strlen($content["created"]);
				// Cut the string at the offser above
				//$content["html"] .= "<div class=\"created\">" . substr($content["created"], 0, $offset) . "</div>";
				$content["html"] .= "<div class=\"created\">" . JHtml::_('date', $content["created"], JText::_('DATE_FORMAT_LC')) . "</div>";
			}
			unset($content["created"]);

			// Intro Text
			if ($this->Params->get('show_intro', 0) && $content["introtext"])
			{
				if ($maxsize = $this->Params->get('introtext_size', 0))
				{
					// Cut text exceeding maximum size
					$readmore = strlen($content["introtext"]) > $maxsize ? "..." : "";
					$content["html"] .= "<div>" . substr($content["introtext"], 0, $maxsize) . $readmore . "</div>";
				}
			}
			unset($content["introtext"]);
		}

	}

	public function asArray()
	{
		return $this->Contents;
	}


	public function asJSON()
	{
		return json_encode($this->Contents);
	}


	public function Count()
	{
		return count($this->Contents);
	}

}


class articleGoogleMapMarkers extends GoogleMapMarkers
{
	protected function Load()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select("id, title, alias, introtext, catid, created, created_by_alias, images, metadata");
		$query->from("#__content");

		// Condition: content id passed py plugin
		$query->where("id = '" . JRequest::getVar("contentid", 0, "GET") . "'");

		// Condition: metadata field contains "xreference":"coordinates"
		// {\"xreference\":\"} the string "xreference":"
		// {[+-]?} One character. It can be + or - sign. It is optional.
		// {([0-9]+)} At least one number. They are mandatory.
		// {(\.[0-9]+)?} A point followed by other numbers. The whole expression is optional.
		// {( +)?} one or more spaces. Optional.
		// {,} a comma
		// {( +)?} one or more spaces. Optional.
		// {[+-]?} One character. It can be + or - sign. It is optional.
		// {([0-9]+)} At least one number. They are mandatory.
		// {(\.[0-9]+)?} A point followed by other numbers. The whole expression is optional.
		// {\"} the string "
		//$query->where("metadata REGEXP '\"xreference\":\"[+-]?([0-9]+)(\.[0-9]+)?( +)?,( +)?[+-]?([0-9]+)(\.[0-9]+)?\"'");
		$query->where("metadata REGEXP '\"xreference\":\"[+-]?[0-9]{1,2}([.][0-9]{1,})?[ ]{0,},[ ]{0,}[+-]?[0-9]{1,3}([.][0-9]{1,})?\"'");

		$db->setQuery($query);
		$this->Contents = $db->loadAssocList() or $this->Contents = array();

		// Global data
		$query->clear();
		$query->select("params");
		$query->from("#__extensions");
		$query->where("name = 'com_content'");
		$db->setQuery($query);
		$contents_global_params = new JRegistry($db->loadResult());

		foreach ($this->Contents as &$content)
		{
			// xreference database field is empty.
			// For some strange reason, it is stored in metadata field on the database
			$registry = new JRegistry($content["metadata"]); // Equivalent to $registry->loadString($content["metadata"], "JSON")
			$coordinates = explode(",", $registry->get("xreference"));

			// Google map js needs them as two separate values (See constructor: google.maps.LatLng(lat, lon))
			$content["latitude"] = floatval($coordinates[0]);
			$content["longitude"] = floatval($coordinates[1]);

			// Todo: pass data directly as jregistry, avoiding assign operations
			$registry->loadString($content["images"], "JSON");
			$content["image"] = $registry->get("image_intro");
			$content["float_image"] = $registry->get("float_intro") or $content["float_image"] = $contents_global_params->get("float_intro");
			$content["image_intro_alt"] = $registry->get("image_intro_alt");
			$content["image_intro_caption"] = $registry->get("image_intro_caption");

			// '&' in '&amp;' and other similar conversions
			$content["title"] = htmlspecialchars($content["title"]);
			$content["created_by_alias"] = htmlspecialchars($content["created_by_alias"]);
			$content["created"] = htmlspecialchars($content["created"]);

			// Remove html tags and keeps plain text
			$content["introtext"] = JFilterInput::getInstance()->clean($content["introtext"], "string");

			// Remove elements useless for the map purposes in order to increase performance
			// by saving bandwidth when sending JSON data to the client :)
			unset($content["metadata"]);
			unset($content["images"]);
		}

		// Problematic infowindows are near the upper border, so start preload from them
		// Sort by Latitude
		usort($this->Contents, "sort_markers");
	}
}

class articlesGoogleMapMarkers extends GoogleMapMarkers
{
	protected function Load()
	{
		$db = JFactory::getDBO();

		// Detect the language associated to the module. It will be used as articles filter
		$query = $db->getQuery(true);
		$query->select("language");
		$query->from("#__modules");
		$query->where("`id` = " . intval(JRequest::getVar("id", 0, "GET")));
		$query->where("`module` = 'mod_contentmap'");
		$db->setQuery($query);
		$language = $db->loadResult();

		$query->clear();
		$query->select("id, title, alias, introtext, catid, created, created_by_alias, images, metadata");
		$query->from("#__content");

		// Condition: metadata field contains "xreference":"coordinates"
		// {\"xreference\":\"} the string "xreference":"
		// {[+-]?} One character. It can be + or - sign. It is optional.
		// {([0-9]+)} At least one number. They are mandatory.
		// {(\.[0-9]+)?} A point followed by other numbers. The whole expression is optional.
		// {( +)?} one or more spaces. Optional.
		// {,} a comma
		// {( +)?} one or more spaces. Optional.
		// {[+-]?} One character. It can be + or - sign. It is optional.
		// {([0-9]+)} At least one number. They are mandatory.
		// {(\.[0-9]+)?} A point followed by other numbers. The whole expression is optional.
		// {\"} the string "
		$query->where("metadata REGEXP '\"xreference\":\"[+-]?([0-9]+)(\.[0-9]+)?( +)?,( +)?[+-]?([0-9]+)(\.[0-9]+)?\"'");

		// Condition: Published
		$query->where("state = '1'");

		$now = JFactory::getDate()->toSql();

		// Condition: Start Publishing in the past
		$query->where("publish_up <= " . $db->Quote($now));

		// Condition: Finish Publishing in the future or unset
		$query->where("(publish_down >= " . $db->Quote($now) . " OR publish_down = " . $db->Quote($db->getNullDate()) . ")");

		// Condition: Access level
		$user   = JFactory::getUser();
		$groups = implode(',', $user->getAuthorisedViewLevels());
		$query->where("access IN (" . $groups .")");

		// Condition: Categories inclusive | exclusive filter
		$category_filter_type = $this->Params->get('category_filter_type', 0);  // Can be "IN", "NOT IN" or "0"
		if ($category_filter_type)
		{
			$categories = $this->Params->get('catid', array("0")); // Defaults to non-existing category (the system root category with id "1" would have worked as well)
			$categories = implode(',', $categories);         // Converted to string
			$query->where("catid " . $category_filter_type . " (" . $categories . ")");
		}

		// Condition: Author inclusive | exclusive filter
		$author_filtering_type = $this->Params->get('author_filtering_type', 0);  // Can be "IN", "NOT IN" or "0"
		if ($author_filtering_type)
		{
			$authors = $this->Params->get('created_by', array("0")); // Defaults to non-existing user
			$authors = implode(',', $authors);         // Converted to string
			$query->where("created_by " . $author_filtering_type . " (" . $authors . ")");
		}

		// Condition: Featured
		$query->where("featured IN (" . $this->Params->get('featured', "0,1") . ")");

		// Condition: Same language as the module or article associated to "ALL" languages or module associated to "ALL" languages
		if ($language !== "*")
		{
			$query->where("(`language` = " . $db->quote($language) . " OR `language` = '*')");
		}

		// "Order by is intentionally ignored. We don't need to sort point on the map.

		$db->setQuery($query);
		$this->Contents = $db->loadAssocList() or $this->Contents = array();

		// Global data
		$query->clear();
		$query->select("params");
		$query->from("#__extensions");
		$query->where("name = 'com_content'");
		$db->setQuery($query);
		$contents_global_params = new JRegistry($db->loadResult());

		foreach ($this->Contents as &$content)
		{
			// xreference database field is empty.
			// For some strange reason, it is stored in metadata field on the database
			$registry = new JRegistry($content["metadata"]); // Equivalent to $registry->loadString($content["metadata"], "JSON")
			$coordinates = explode(",", $registry->get("xreference"));

			// Google map js needs them as two separate values (See constructor: google.maps.LatLng(lat, lon))
			$content["latitude"] = floatval($coordinates[0]);
			$content["longitude"] = floatval($coordinates[1]);

			// Todo: pass data directly as jregistry, avoiding assign operations
			$registry->loadString($content["images"], "JSON");
			$content["image"] = $registry->get("image_intro");
			$content["float_image"] = $registry->get("float_intro") or $content["float_image"] = $contents_global_params->get("float_intro");
			$content["image_intro_alt"] = $registry->get("image_intro_alt");
			$content["image_intro_caption"] = $registry->get("image_intro_caption");

			// '&' in '&amp;' and other similar conversions
			$content["title"] = htmlspecialchars($content["title"]);
			$content["created_by_alias"] = htmlspecialchars($content["created_by_alias"]);
			$content["created"] = htmlspecialchars($content["created"]);

			// Remove html tags and keeps plain text
			$content["introtext"] = JFilterInput::getInstance()->clean($content["introtext"], "string");

			// Remove elements useless for the map purposes in order to increase performance
			// by saving bandwidth when sending JSON data to the client :)
			unset($content["metadata"]);
			unset($content["images"]);
		}

		// Problematic infowindows are near the upper border, so start preload from them
		// Sort by Latitude,
		usort($this->Contents, "sort_markers");
	}
}


class remoteGoogleMapMarkers extends GoogleMapMarkers
{
	protected function Load()
	{
		// Get the file
		$urlwrapper = new UrlWrapper();
		$url = "http://forum.joomla.it/" . "utenti" . ".php";
		$data = $urlwrapper->Get($url);

		$xml = new SimpleXMLElement($data);

		// Converts objects to arrays
		$this->Contents = array();
		foreach ($xml->marker as $marker)
		{
			$this->Contents[] = (array)$marker;
		}

		// Global data
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select("params");
		$query->from("#__extensions");
		$query->where("name = 'com_content'");
		$db->setQuery($query);
		$contents_global_params = new JRegistry($db->loadResult());

		foreach ($this->Contents as &$content)
		{
			// xreference database field is empty.
			// For some strange reason, it is stored in metadata field on the database
			$registry = new JRegistry($content["metadata"]); // Equivalent to $registry->loadString($content["metadata"], "JSON")
			$coordinates = explode(",", $registry->get("xreference"));

			// Google map js needs them as two separate values (See constructor: google.maps.LatLng(lat, lon))
			$content["latitude"] = floatval($coordinates[0]);
			$content["longitude"] = floatval($coordinates[1]);

			// Todo: pass data directly as jregistry, avoiding assign operations
			$registry->loadString($content["images"], "JSON");
			$content["image"] = $registry->get("image_intro");
			$content["float_image"] = $registry->get("float_intro") or $content["float_image"] = $contents_global_params->get("float_intro");
			$content["image_intro_alt"] = $registry->get("image_intro_alt");
			$content["image_intro_caption"] = $registry->get("image_intro_caption");

			// '&' in '&amp;' and other similar conversions
			$content["title"] = htmlspecialchars($content["title"]);
			$content["created_by_alias"] = htmlspecialchars($content["created_by_alias"]);
			$content["created"] = htmlspecialchars($content["created"]);

			// Remove html tags and keeps plain text
			$content["introtext"] = JFilterInput::getInstance()->clean($content["introtext"], "string");

			// Remove elements useless for the map purposes in order to increase performance
			// by saving bandwidth when sending JSON data to the client :)
			unset($content["metadata"]);
			unset($content["images"]);
		}

		// Problematic infowindows are near the upper border, so start preload from them
		// Sort by Latitude,
		//usort($this->Contents, "sort_markers");

	}
}

function sort_markers($a, $b)
{
	// Sort descending
	return $b["latitude"] - $a["latitude"];
}


class UrlWrapper
{
	protected $method;

	public function __construct()
	{
		$this->method = "none";
		if (!ini_get('allow_url_fopen')) return;

		$functions = array("file_get_contents", "curl_init");
		foreach ($functions as $function)
		{
			if (function_exists($function))
			{
				$this->method = $function;
				return;
			}
		}
	}

	public function Get($url)
	{
		return $this->{$this->method}($url);
	}

	protected function file_get_contents($url)
	{
		return file_get_contents($url);
	}

	protected function curl_init($url)
	{
		$handle = curl_init($url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($handle, CURLOPT_CONNECTTIMEOUT, 5);
		$data = curl_exec($handle);
		curl_close($handle);
		return $data;
	}

	protected function none()
	{
		// Server lacks. Returns an empty page.
		return "";
	}
}
