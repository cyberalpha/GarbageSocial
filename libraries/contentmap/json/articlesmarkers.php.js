<?php defined('_JEXEC') or die('Restricted access');
require JPATH_ROOT . "/libraries/contentmap/loader/markers.php";

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
'"minlatitude":' . $markers->MinLatitude . ',' .
'"maxlatitude":' . $markers->MaxLatitude . ',' .
'"minlongitude":' . $markers->MinLongitude . ',' .
'"maxlongitude":' . $markers->MaxLongitude . ',' .
'"zoom":' . $markers->Zoom . ',' .
'"baseurl":' . json_encode(JURI::base(true) . '/') . ',' .
$markers_icon .
'"nodata_msg":' . json_encode(JText::_("CONTENTMAP_NO_DATA")) . ',' .
'"markers_action":"' . $this->Params->get("markers_action", "infowindow") . '",' .
'"places":' . $markers->asJSON();
echo $source;
