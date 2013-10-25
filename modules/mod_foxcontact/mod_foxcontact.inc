<?php
$GLOBALS["ext_name"] = substr(basename(realpath(dirname(__FILE__))), 4);

$GLOBALS["com_name"] = "com_" . $GLOBALS["ext_name"];
$GLOBALS["mod_name"] = "mod_" . $GLOBALS["ext_name"];
$GLOBALS["EXT_NAME"] = strtoupper($GLOBALS["ext_name"]);
$GLOBALS["COM_NAME"] = strtoupper($GLOBALS["com_name"]);
$GLOBALS["MOD_NAME"] = strtoupper($GLOBALS["mod_name"]);

$version = new JVersion();
switch ($version->RELEASE)
{
	case "1.6":
		$GLOBALS["toSql"] = "toMySQL";
		$GLOBALS["quoteName"] = "nameQuote";
	break;

	case "1.7":
		$GLOBALS["toSql"] = "toMySQL";
		$GLOBALS["quoteName"] = "quoteName";
	break;

	default: // Versione corrente
		$GLOBALS["toSql"] = "toSql";
		$GLOBALS["quoteName"] = "quoteName";
}

$language = JFactory::getLanguage();
if (isset($language))
	{
	$direction = intval($language->get('rtl', 0));
	$GLOBALS["left"]  = $direction ? "right" : "left";
	$GLOBALS["right"] = $direction ? "left" : "right";
	}


?>
