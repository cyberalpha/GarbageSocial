<?php
/*------------------------------------------------------------------------
# mod_zhgooglemap - Zh GoogleMap Module
# ------------------------------------------------------------------------
# author    Dmitry Zhuk
# copyright Copyright (C) 2011 zhuk.cc. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
# Websites: http://zhuk.cc
# Technical Support Forum: http://forum.zhuk.cc/
-------------------------------------------------------------------------*/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$allowUserMarker = 0;
$scripttext = '';

$divmapheader ="";
$divmapfooter ="";
$currentUserInfo ="";
$currentUserID = 0;

$mapcompatiblemodersf = modZhGoogleMapHelper::getCompatibleModeRSF();
$mapcompatiblemode = modZhGoogleMapHelper::getCompatibleMode();
$httpsprotocol = modZhGoogleMapHelper::getHttpsProtocol();
$loadtype = modZhGoogleMapHelper::getLoadType();

$urlProtocol = 'http';
if ((int)$httpsprotocol == 0)
{
	$urlProtocol = 'https';
}

$id = $params->get('mapid', '');
$placemarkListId = $params->get('placemarklistid', '');
$explacemarkListId = $params->get('explacemarklistid', '');
$groupListId = $params->get('grouplistid', '');
$categoryListId = $params->get('categorylistid', '');

$cssClassSuffix = $params->get('moduleclass_sfx', '');

$map = modZhGoogleMapHelper::getMap((int)$id);

if (isset($map) && (int)$map->id != 0)
{

$markergroups = modZhGoogleMapHelper::getMarkerGroups($map->id, $placemarkListId, $explacemarkListId, $groupListId, $categoryListId);
$markers = modZhGoogleMapHelper::getMarkers($map->id, $placemarkListId, $explacemarkListId, $groupListId, $categoryListId, $map->usermarkers, $map->usermarkersfilter, $map->usercontact);
$routers = modZhGoogleMapHelper::getRouters($map->id);
$paths = modZhGoogleMapHelper::getPaths($map->id);
$mapapikey4map = modZhGoogleMapHelper::getMapAPIKey();
$mapapikey4earth = modZhGoogleMapHelper::getEarthAPIKey();
$maptypes = modZhGoogleMapHelper::getMapTypes();
$adsences = modZhGoogleMapHelper::getAdSences($map->id);
$apiversion = modZhGoogleMapHelper::getMapAPIVersion();


// Change translation language and load translation
if (isset($map->lang) && $map->lang != "")
{
	$currentLanguage = JFactory::getLanguage();
	$currentLangTag = $currentLanguage->getTag();

	$currentLanguage->load('mod_zhgooglemap', JPATH_SITE, $map->lang, true);	
	$currentLanguage->load('mod_zhgooglemap', JPATH_COMPONENT, $map->lang, true);	
}

require_once JPATH_SITE . '/modules/mod_zhgooglemap/helpers/placemarks.php';

if (isset($map->usermarkers) && (int)$map->usermarkers == 1) 
{
    $currentUser = JFactory::getUser();

    if ($currentUser->id == 0)
    {
		$currentUserInfo .= JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_NOTLOGIN' );
		$allowUserMarker = 0;
		$currentUserID = 0;
    }
    else
    {
		$currentUserInfo .= JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_LOGIN' ) .' '. $currentUser->name;
		$allowUserMarker = 1;
		$currentUserID = $currentUser->id;
    }
    
} 
else
{
	$allowUserMarker = 0;
	$currentUserID = 0;
}

// if post data to load
if ($allowUserMarker == 1
 && isset($_POST['marker_action'])
 )
{		
$scripttext .= '<script type="text/javascript">';
	
	$db = JFactory::getDBO();

	if (isset($_POST['marker_action']) && 
		($_POST['marker_action'] == "insert") ||
		($_POST['marker_action'] == "update") 
		)
	{

		$title = substr($_POST["markername"], 0, 249);
		if ($title == "")
		{
			$title = 'Placemark';
		}

		$markericon = substr($_POST["markerimage"], 0, 249);
		if ($markericon == "")
		{
			$markericon ='default#';
		}
		
		$description = $_POST["markerdescription"];
		$latitude = substr($_POST["markerlat"], 0, 100);
		$longitude = substr($_POST["markerlng"], 0, 100);
		$group = substr($_POST["markergroup"], 0, 100);
		$markercatid = substr($_POST["markercatid"], 0, 100);
		$markerbaloon = substr($_POST["markerbaloon"], 0, 100);
		$markermarkercontent = substr($_POST["markermarkercontent"], 0, 100);
		$markerid = (int)substr($_POST["markerid"], 0, 100);
		$markerhrefimage = substr($_POST["markerhrefimage"], 0, 500);
		
		$contactid = substr($_POST["contactid"], 0, 100);
		
		$contactDoInsert = 0;
		
		if (isset($map->usercontact) && (int)$map->usercontact == 1) 
		{
			$contact_name = substr($_POST["contactname"], 0, 250);
			$contact_position = substr($_POST["contactposition"], 0, 250);
			$contact_phone = substr($_POST["contactphone"], 0, 250);
			$contact_mobile = substr($_POST["contactmobile"], 0, 250);
			$contact_fax = substr($_POST["contactfax"], 0, 250);
			$contact_address = substr($_POST["contactaddress"], 0, 250);
			$contact_email = substr($_POST["contactemail"], 0, 250);
			
			if (($contact_name != "") 
			  ||($contact_position != "")
			  ||($contact_phone != "")
			  ||($contact_mobile != "")
			  ||($contact_fax != "")
			  ||($contact_email != "")
			  ||($contact_address != "")
				)
			{
				$contactDoInsert = 1;
			}
		}

		$newRow = new stdClass;
		
		if ($_POST['marker_action'] == "insert")
		{
			$newRow->id = NULL;
			$newRow->userprotection = 0;
			$newRow->openbaloon = 0;
			$newRow->actionbyclick = 1;
			
			if ((isset($map->usercontact) && (int)$map->usercontact == 1) 
			 &&($contactDoInsert == 1))
			{				
				$newRow->showcontact = 2;
			}
			else
			{				
				$newRow->showcontact = 0;
			}
		}
		else
		{
			$newRow->id = $markerid;

			if ((isset($map->usercontact) && (int)$map->usercontact == 1) 
			 &&($contactDoInsert == 1) && ((int)$contactid == 0))
			{				
				$newRow->showcontact = 2;
			}
			
		}
		
		// Data for Contacts - begin
		if ((isset($map->usercontact) && (int)$map->usercontact == 1) 
		  &&($contactDoInsert == 1))
		{
			$newContactRow = new stdClass;
			
			if ($_POST['marker_action'] == "insert")
			{
				$newContactRow->id = NULL;
				$newContactRow->published = (int)$map->usercontactpublished;
				$newContactRow->language = '*';
				$newContactRow->access = 1;
			}
			else
			{
				if ((int)$contactid == 0)
				{
					$newContactRow->id = NULL;
					$newContactRow->published = (int)$map->usercontactpublished;
					$newContactRow->language = '*';
					$newContactRow->access = 1;
				}
				else
				{
					$newContactRow->id = $contactid;
				}
			}
			
		}			
		// Data for Contacts - end
		
		// because it (quotes) escaped
		$newRow->title = str_replace('\\','', htmlspecialchars($title, ENT_NOQUOTES, 'UTF-8'));
		$newRow->description = str_replace('\\','', htmlspecialchars($description, ENT_NOQUOTES, 'UTF-8'));
		// because it escaped
		$newRow->latitude = htmlspecialchars($latitude, ENT_QUOTES, 'UTF-8');
		$newRow->longitude = htmlspecialchars($longitude, ENT_QUOTES, 'UTF-8');
		$newRow->mapid = $map->id;
		$newRow->icontype = htmlspecialchars($markericon, ENT_QUOTES, 'UTF-8');
		$newRow->published = (int)$map->usermarkerspublished;
		$newRow->createdbyuser = $currentUserID;
		$newRow->markergroup = htmlspecialchars($group, ENT_QUOTES, 'UTF-8');
		$newRow->catid = htmlspecialchars($markercatid, ENT_QUOTES, 'UTF-8');

		$newRow->baloon = htmlspecialchars($markerbaloon, ENT_QUOTES, 'UTF-8');
		$newRow->markercontent = htmlspecialchars($markermarkercontent, ENT_QUOTES, 'UTF-8');
		$newRow->hrefimage = htmlspecialchars($markerhrefimage, ENT_QUOTES, 'UTF-8');

		if ((isset($map->usercontact) && (int)$map->usercontact == 1) 
		  &&($contactDoInsert == 1))
		{
			$newContactRow->name = str_replace('\\','', htmlspecialchars($contact_name, ENT_NOQUOTES, 'UTF-8'));
			if ($newContactRow->name == "")
			{
				$newContactRow->name = $newRow->title;
			}
			$newContactRow->con_position = str_replace('\\','', htmlspecialchars($contact_position, ENT_NOQUOTES, 'UTF-8'));
			$newContactRow->telephone = str_replace('\\','', htmlspecialchars($contact_phone, ENT_NOQUOTES, 'UTF-8'));
			$newContactRow->mobile = str_replace('\\','', htmlspecialchars($contact_mobile, ENT_NOQUOTES, 'UTF-8'));
			$newContactRow->fax = str_replace('\\','', htmlspecialchars($contact_fax, ENT_NOQUOTES, 'UTF-8'));
			$newContactRow->email_to = str_replace('\\','', htmlspecialchars($contact_email, ENT_NOQUOTES, 'UTF-8'));
			$newContactRow->address = str_replace('\\','', htmlspecialchars($contact_address, ENT_NOQUOTES, 'UTF-8'));
		}
		
		if ($_POST['marker_action'] == "insert")
		{
			if ((isset($map->usercontact) && (int)$map->usercontact == 1) 
			  &&($contactDoInsert == 1))
			{
				$dml_contact_result = $db->insertObject( '#__contact_details', $newContactRow, 'id' );
				
				$newRow->contactid = $newContactRow->id;
			}

			$dml_result = $db->insertObject( '#__zhgooglemaps_markers', $newRow, 'id' );
		}
		else
		{
			if ((isset($map->usercontact) && (int)$map->usercontact == 1) 
			  &&($contactDoInsert == 1))
			{
				if (isset($newContactRow->id))
				{
					$dml_contact_result = $db->updateObject( '#__contact_details', $newContactRow, 'id' );
				}
				else
				{
					$dml_contact_result = $db->insertObject( '#__contact_details', $newContactRow, 'id' );
					$newRow->contactid = $newContactRow->id;
				}
			}

			$dml_result = $db->updateObject( '#__zhgooglemaps_markers', $newRow, 'id' );
			//$scripttext .= 'alert("Updated");'."\n";
		}
		
		if ((!$dml_result) || 
			(isset($map->usercontact) && (int)$map->usercontact == 1 && ($contactDoInsert == 1) && (!$dml_result))
			)
		{
			//$this->setError($db->getErrorMsg());
			$scripttext .= 'alert("Error (Insert New Marker or Update): " + "' . $db->getEscaped($db->getErrorMsg()).'");';
		}
		else
		{
			//$scripttext .= 'alert("Complete, redirect");'."\n";
			$scripttext .= 'window.location = "'.JURI::current().'";'."\n";
			
			$new_id = $newRow->id;

		}
	}
	else if (isset($_POST['marker_action']) && $_POST['marker_action'] == "delete") 
	{

		$contactid = substr($_POST["contactid"], 0, 100);
		$markerid = substr($_POST["markerid"], 0, 100);
	
		if (isset($map->usercontact) && (int)$map->usercontact == 1) 
		{
		
			if ((int)$contactid != 0)
			{
				$query = $db->getQuery(true);

				$db->setQuery( 'DELETE FROM `#__contact_details` '.
				'WHERE `id`='.(int)$contactid);
				
				if (!$db->query()) {
					//$this->setError($db->getErrorMsg());
					$scripttext .= 'alert("Error (Delete Exist Marker Contact): " + "' . $db->getEscaped($db->getErrorMsg()).'");';
				}
			}
		}


		$query = $db->getQuery(true);

		$db->setQuery( 'DELETE FROM `#__zhgooglemaps_markers` '.
		'WHERE `createdbyuser`='.$currentUserID.
		' and `id`='.$markerid);

		
		if (!$db->query()) {
			//$this->setError($db->getErrorMsg());
			$scripttext .= 'alert("Error (Delete Exist Marker): " + "' . $db->getEscaped($db->getErrorMsg()).'");';
		}
		else
		{
			$scripttext .= 'window.location = "'.JURI::current().'";'."\n";
		}
	}
$scripttext .= '</script>';

echo $scripttext;

}
else
{
// main part where not post data
$document	= JFactory::getDocument();

$apikey4earth = $mapapikey4earth;
$apikey4map = $mapapikey4map;

$credits ='';

$compatiblemode = $mapcompatiblemode;
if ($compatiblemode == "")
{
  $compatiblemode = 0;
}
$compatiblemodersf = $mapcompatiblemodersf;
if ($compatiblemodersf == "")
{
  $compatiblemodersf = 0;
}

if ($compatiblemodersf == 0)
{
	$imgpathIcons = JURI::root() .'administrator/components/com_zhgooglemap/assets/icons/';
	$imgpathUtils = JURI::root() .'administrator/components/com_zhgooglemap/assets/utils/';
	$directoryIcons = 'administrator/components/com_zhgooglemap/assets/icons/';
}
else
{
	$imgpathIcons = JURI::root() .'components/com_zhgooglemap/assets/icons/';
	$imgpathUtils = JURI::root() .'components/com_zhgooglemap/assets/utils/';
	$directoryIcons = 'components/com_zhgooglemap/assets/icons/';
}

if ($compatiblemodersf == 0)
{
	$document->addStyleSheet(JURI::root() .'administrator/components/com_zhgooglemap/assets/css/common.css');
}
else
{
	$document->addStyleSheet(JURI::root() .'components/com_zhgooglemap/assets/css/common.css');
}


$custMapTypeList = explode(";", $map->custommaptypelist);
if (count($custMapTypeList) != 0)
{
	$custMapTypeFirst = $custMapTypeList[0];
}
else
{
	$custMapTypeFirst = 0;
}

if (isset($map->css2load) && ($map->css2load != ""))
{
	$loadCSSList = explode(';', str_replace(array("\r", "\r\n", "\n"), ';', $map->css2load));


	for($i = 0; $i < count($loadCSSList); $i++) 
	{
		$currCSS = trim($loadCSSList[$i]);
		if ($currCSS != "")
		{
			$document->addStyleSheet($currCSS);
		}
	}
}

if (isset($map->usermarkers) && (int)$map->usermarkers == 1) 
{
	if ($compatiblemodersf == 0)
	{
		$document->addStyleSheet(JURI::root() .'administrator/components/com_zhgooglemap/assets/css/usermarkers.css');
	}
	else
	{
		$document->addStyleSheet(JURI::root() .'components/com_zhgooglemap/assets/css/usermarkers.css');
	}
	
	function get_UpdateContentString($usermarkersicon, $usercontact, $currentmarker, $imgpathIcons, $imgpathUtils, $directoryIcons, $newMarkerGroupList)
	{
			$scripttext ='';

			// contentString - User Placemark can Update - Begin
					// Change UserMarker - begin
						
						$scripttext .= 'var contentStringPart1'.$currentmarker->id.' = "" +' ."\n";
						$scripttext .= '\'<div id="contentUpdatePlacemark">\'+'."\n";
						//$scripttext .= '    \'<br />\'+' ."\n";
						//$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_LNG' ).' \'+'.$currentLng.' + ' ."\n";
						//$scripttext .= '    \'<br />'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_LAT' ).' \'+'.$currentLat.' + ' ."\n";
						//$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_LNG' ).' \'+latlng'.$currentmarker->id.'.lng() + ' ."\n";
						//$scripttext .= '    \'<br />'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_LAT' ).' \'+latlng'.$currentmarker->id.'.lat() + ' ."\n";
						
						// Form Update
						$scripttext .= '    \'<form id="updatePlacemarkForm'.$currentmarker->id.'" action="'.JURI::current().'" method="post">\'+'."\n";
						$scripttext .= '    \''.'<img src="'.$imgpathUtils.'published'.(int)$currentmarker->published.'.png" alt="" />  \'+' ."\n";
						$scripttext .= '    \'<br />\'+' ."\n";

					// Begin Placemark Properties
					$scripttext .= '\'<div id="bodyInsertPlacemarkDivA'.$currentmarker->id.'"  class="bodyInsertProperties">\'+'."\n";
					$scripttext .= '\'<a id="bodyInsertPlacemarkA'.$currentmarker->id.'" href="javascript:showonlyone(\\\'Placemark\\\',\\\''.$currentmarker->id.'\\\');" ><img src="'.$imgpathUtils.'collapse.png">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_BASIC_PROPERTIES' ).'</a>\'+'."\n";
					$scripttext .= '\'</div>\'+'."\n";
					$scripttext .= '\'<div id="bodyInsertPlacemark'.$currentmarker->id.'"  class="bodyInsertPlacemarkProperties">\'+'."\n";
						$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_NAME' ).' \'+' ."\n";
						$scripttext .= '    \'<br />\'+' ."\n";
						$scripttext .= '    \'<input name="markername" type="text" maxlength="250" size="50" value="'. htmlspecialchars($currentmarker->title, ENT_QUOTES, 'UTF-8').'" />\'+' ."\n";
						$scripttext .= '    \'<br />\'+' ."\n";
						//$scripttext .= '    \'<br />\'+' ."\n";
						$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_DESCRIPTION' ).' \'+' ."\n";
						$scripttext .= '    \'<br />\'+' ."\n";
						$scripttext .= '    \'<input name="markerdescription" type="text" maxlength="250" size="50" value="'. htmlspecialchars($currentmarker->description, ENT_QUOTES, 'UTF-8').'" />\'+' ."\n";
						$scripttext .= '    \'<br />\';' ."\n";

						// icon type
						/*
						if(isset($usermarkersicon) && (int)$usermarkersicon == 1) 
						{
							$iconTypeJS = " onchange=\"javascript: ";
							$iconTypeJS .= " if (document.forms.updatePlacemarkForm".$currentmarker->id.".markerimage.options[selectedIndex].value!=\'\') ";
							$iconTypeJS .= " {document.markericonimage".$currentmarker->id.".src=\'".$imgpathIcons."\' + document.forms.updatePlacemarkForm".$currentmarker->id.".markerimage.options[selectedIndex].value.replace(/#/g,\'%23\') + \'.png\'}";
							$iconTypeJS .= " else ";
							$iconTypeJS .= " {document.markericonimage".$currentmarker->id.".src=\'\'}\"";
							
							$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_ICON_TYPE' ).' \'+' ."\n";
							$scripttext .= ' \'';
							$scripttext .= '<img name="markericonimage'.$currentmarker->id.'" src="'.$imgpathIcons .str_replace("#", "%23", $currentmarker->icontype).'.png" alt="" />';
							$scripttext .= '\'+' ."\n";
							$scripttext .= '    \'<br />\'+' ."\n";
							$scripttext .= ' \'';
							$scripttext .= str_replace('.png<', '<', 
												str_replace('.png"', '"', 
													str_replace('JOPTION_SELECT_IMAGE', JText::_('MOD_ZHGOOGLEMAP_MAP_USER_IMAGESELECT'),
														str_replace(array("\r", "\r\n", "\n"),'', JHTML::_('list.images',  'markerimage', $active = $currentmarker->icontype.'.png', $iconTypeJS, $directoryIcons, $extensions =  "png")))));
							$scripttext .= '\'+' ."\n";
							$scripttext .= '    \'<br />\'+' ."\n";		
						}
						else
						{
							$scripttext .= '    \'<input name="markerimage" type="hidden" value="default#" />\'+' ."\n";	
						}
						*/

						$scripttext .= 'var contentStringPart2'.$currentmarker->id.' = "" +' ."\n";						
						$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_BALOON' ).' \'+' ."\n";
						$scripttext .= '    \'<br />\'+' ."\n";

						if ($currentmarker->baloon == 1)
						{
						}
						
						$scripttext .= '    \' <select name="markerbaloon" > \'+' ."\n";
						$scripttext .= '    \' <option value="1" ';
						if ($currentmarker->baloon == 1)
						{
							$scripttext .= 'selected="selected"';
						}
						$scripttext .= '>'.JText::_( 'MOD_ZHGOOGLEMAP_MAPMARKER_DETAIL_BALOON_DROP').'</option> \'+' ."\n";
						$scripttext .= '    \' <option value="2" ';
						if ($currentmarker->baloon == 2)
						{
							$scripttext .= 'selected="selected"';
						}
						$scripttext .= '>'.JText::_( 'MOD_ZHGOOGLEMAP_MAPMARKER_DETAIL_BALOON_BOUNCE').'</option> \'+' ."\n";
						$scripttext .= '    \' <option value="3" ';
						if ($currentmarker->baloon == 3)
						{
							$scripttext .= 'selected="selected"';
						}
						$scripttext .= '>'.JText::_( 'MOD_ZHGOOGLEMAP_MAPMARKER_DETAIL_BALOON_SIMPLE').'</option> \'+' ."\n";
						$scripttext .= '    \' </select> \'+' ."\n";
						$scripttext .= '    \'<br />\'+' ."\n";

						$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAPMARKER_USER_MARKERCONTENT' ).' \'+' ."\n";
						$scripttext .= '    \'<br />\'+' ."\n";
						
						$scripttext .= '    \' <select name="markermarkercontent" > \'+' ."\n";
						$scripttext .= '    \' <option value="0" ';
						if ($currentmarker->baloon == 0)
						{
							$scripttext .= 'selected="selected"';
						}
						$scripttext .= '>'.JText::_( 'MOD_ZHGOOGLEMAP_MAPMARKER_DETAIL_MARKERCONTENT_TITLE_DESC').'</option> \'+' ."\n";
						$scripttext .= '    \' <option value="1" ';
						if ($currentmarker->baloon == 1)
						{
							$scripttext .= 'selected="selected"';
						}
						$scripttext .= '>'.JText::_( 'MOD_ZHGOOGLEMAP_MAPMARKER_DETAIL_MARKERCONTENT_TITLE').'</option> \'+' ."\n";
						$scripttext .= '    \' <option value="2" ';
						if ($currentmarker->baloon == 2)
						{
							$scripttext .= 'selected="selected"';
						}
						$scripttext .= '>'.JText::_( 'MOD_ZHGOOGLEMAP_MAPMARKER_DETAIL_MARKERCONTENT_DESCRIPTION').'</option> \'+' ."\n";
						$scripttext .= '    \' <option value="100" ';
						if ($currentmarker->baloon == 100)
						{
							$scripttext .= 'selected="selected"';
						}
						$scripttext .= '>'.JText::_( 'MOD_ZHGOOGLEMAP_MAPMARKER_DETAIL_MARKERCONTENT_NONE').'</option> \'+' ."\n";
						$scripttext .= '    \' </select> \'+' ."\n";
						$scripttext .= '    \'<br />\'+' ."\n";

						$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAPMARKER_DETAIL_HREFIMAGE_LABEL' ).' \'+' ."\n";
						$scripttext .= '    \'<br />\'+' ."\n";
						$scripttext .= '    \'<input name="markerhrefimage" type="text" maxlength="500" size="50" value="'. htmlspecialchars($currentmarker->hrefimage, ENT_QUOTES, 'UTF-8').'" />\'+' ."\n";
						$scripttext .= '    \'<br />\'+' ."\n";
						
						$scripttext .= '    \'<br />\'+' ."\n";

					$scripttext .= '\'</div>\'+'."\n";
					// End Placemark Properties
									
					// Begin Placemark Group Properties
					$scripttext .= '\'<div id="bodyInsertPlacemarkGrpDivA'.$currentmarker->id.'"  class="bodyInsertProperties">\'+'."\n";
					$scripttext .= '\'<a id="bodyInsertPlacemarkGrpA'.$currentmarker->id.'" href="javascript:showonlyone(\\\'PlacemarkGroup\\\',\\\''.$currentmarker->id.'\\\');" ><img src="'.$imgpathUtils.'expand.png">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_BASIC_GROUP_PROPERTIES' ).'</a>\'+'."\n";
					$scripttext .= '\'</div>\'+'."\n";
					$scripttext .= '\'<div id="bodyInsertPlacemarkGrp'.$currentmarker->id.'"  class="bodyInsertPlacemarkGrpProperties">\'+'."\n";
						$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_GROUP' ).' \'+' ."\n";
						$scripttext .= '    \'<br />\'+' ."\n";
						
						$scripttext .= '    \' <select name="markergroup" > \'+' ."\n";
						if ($currentmarker->markergroup == 0)
						{
							$scripttext .= '    \' <option value="" selected="selected">'.JText::_( 'MOD_ZHGOOGLEMAP_MAPMARKER_FILTER_PLACEMARK_GROUP').'</option> \'+' ."\n";
						}
						else
						{
							$scripttext .= '    \' <option value="">'.JText::_( 'MOD_ZHGOOGLEMAP_MAPMARKER_FILTER_PLACEMARK_GROUP').'</option> \'+' ."\n";
						}
						foreach ($newMarkerGroupList as $key => $newGrp) 
						{
							if ($currentmarker->markergroup == $newGrp->value)
							{
								$scripttext .= '    \' <option value="'.$newGrp->value.'" selected="selected">'.$newGrp->text.'</option> \'+' ."\n";
							}
							else
							{
								$scripttext .= '    \' <option value="'.$newGrp->value.'">'.$newGrp->text.'</option> \'+' ."\n";
							}
						}
						$scripttext .= '    \' </select> \'+' ."\n";
						$scripttext .= '    \'<br />\'+' ."\n";


				
				$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CATEGORY' ).' \'+' ."\n";
				$scripttext .= '    \'<br />\'+' ."\n";
				$scripttext .= '    \' <select name="markercatid" > \'+' ."\n";
				$scripttext .= '    \' <option value="" selected="selected">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_FILTER_CATEGORY').'</option> \'+' ."\n";
				$scripttext .= '    \''.str_replace(array("\r", "\r\n", "\n"),'', 
									   JHtml::_('select.options', JHtml::_('category.options', 'com_zhgooglemap'), 'value', 'text', $currentmarker->catid)) .
									   '\'+' ."\n";
				$scripttext .= '    \' </select> \'+' ."\n";
				$scripttext .= '    \'<br />\'+' ."\n";

				$scripttext .= '    \'<br />\'+' ."\n";
				$scripttext .= '\'</div>\'+'."\n";
				// End Placemark Group Properties

				// Begin Contact Properties
				if (isset($usercontact) && (int)$usercontact == 1) 
				{

					$scripttext .= '\'<div id="bodyInsertContactDivA'.$currentmarker->id.'"  class="bodyInsertProperties">\'+'."\n";
					$scripttext .= '\'<a id="bodyInsertContactA'.$currentmarker->id.'" href="javascript:showonlyone(\\\'Contact\\\',\\\''.$currentmarker->id.'\\\');" ><img src="'.$imgpathUtils.'expand.png">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_PROPERTIES' ).'</a>\'+'."\n";
					$scripttext .= '\'</div>\'+'."\n";
					$scripttext .= '\'<div id="bodyInsertContact'.$currentmarker->id.'"  class="bodyInsertContactProperties">\'+'."\n";
					$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_NAME' ).' \'+' ."\n";
					$scripttext .= '    \'<br />\'+' ."\n";
					$scripttext .= '    \'<input name="contactname" type="text" maxlength="250" size="50" value="'. htmlspecialchars($currentmarker->contact_name, ENT_QUOTES, 'UTF-8').'" />\'+' ."\n";
					$scripttext .= '    \'<br />\'+' ."\n";
					$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_POSITION' ).' \'+' ."\n";
					$scripttext .= '    \'<br />\'+' ."\n";
					$scripttext .= '    \'<input name="contactposition" type="text" maxlength="250" size="50" value="'. htmlspecialchars($currentmarker->contact_position, ENT_QUOTES, 'UTF-8').'" />\'+' ."\n";
					$scripttext .= '    \'<br />\'+' ."\n";
					$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_PHONE' ).' \'+' ."\n";
					$scripttext .= '    \'<br />\'+' ."\n";
					$scripttext .= '    \'<input name="contactphone" type="text" maxlength="250" size="50" value="'. htmlspecialchars($currentmarker->contact_phone, ENT_QUOTES, 'UTF-8').'" />\'+' ."\n";
					$scripttext .= '    \'<br />\'+' ."\n";
					$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_MOBILE' ).' \'+' ."\n";
					$scripttext .= '    \'<br />\'+' ."\n";
					$scripttext .= '    \'<input name="contactmobile" type="text" maxlength="250" size="50" value="'. htmlspecialchars($currentmarker->contact_mobile, ENT_QUOTES, 'UTF-8').'" />\'+' ."\n";
					$scripttext .= '    \'<br />\'+' ."\n";
					$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_FAX' ).' \'+' ."\n";
					$scripttext .= '    \'<br />\'+' ."\n";
					$scripttext .= '    \'<input name="contactfax" type="text" maxlength="250" size="50" value="'. htmlspecialchars($currentmarker->contact_fax, ENT_QUOTES, 'UTF-8').'" />\'+' ."\n";
					$scripttext .= '    \'<br />\'+' ."\n";
					$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_EMAIL' ).' \'+' ."\n";
					$scripttext .= '    \'<br />\'+' ."\n";
					$scripttext .= '    \'<input name="contactemail" type="text" maxlength="250" size="50" value="'. htmlspecialchars($currentmarker->contact_email, ENT_QUOTES, 'UTF-8').'" />\'+' ."\n";
					$scripttext .= '\'</div>\'+'."\n";
					// Contact Address
					$scripttext .= '\'<div id="bodyInsertContactAdrDivA'.$currentmarker->id.'"  class="bodyInsertProperties">\'+'."\n";
					$scripttext .= '\'<a id="bodyInsertContactAdrA'.$currentmarker->id.'" href="javascript:showonlyone(\\\'ContactAddress\\\',\\\''.$currentmarker->id.'\\\');" ><img src="'.$imgpathUtils.'expand.png">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_ADDRESS_PROPERTIES' ).'</a>\'+'."\n";
					$scripttext .= '\'</div>\'+'."\n";
					$scripttext .= '\'<div id="bodyInsertContactAdr'.$currentmarker->id.'"  class="bodyInsertContactAdrProperties">\'+'."\n";
					$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_ADDRESS' ).' \'+' ."\n";
					$scripttext .= '    \'<br />\'+' ."\n";
					$scripttext .= '    \'<textarea name="contactaddress" cols="35" rows="4" >'. str_replace("\n\n", "'+'\\n'+'", str_replace(array("\r", "\r\n", "\n"), "\n",htmlspecialchars($currentmarker->contact_address, ENT_QUOTES, 'UTF-8'))).'</textarea>\'+' ."\n";
					$scripttext .= '    \'<br />\'+' ."\n";
					$scripttext .= '    \'<br />\'+' ."\n";
					$scripttext .= '\'</div>\'+'."\n";
				}
				// End Contact Properties
		
				$scripttext .= '\'\';'."\n";

					// Change UserMarker - end
					// contentString - User Placemark can Update - End

			return $scripttext;
	}
}

// Extra checking - begin

	$featurePathElevation = 0;
	$featurePathElevationKML = 0;
	// Do you need Elevation feature
	if (isset($paths) && !empty($paths)) 
	{
		foreach ($paths as $key => $currentpath) 
		{
			if (($currentpath->path != ""
			 && (int)$currentpath->objecttype == 0
			 && (int)$currentpath->elevation != 0)
			 ||
			 ($currentpath->kmllayer != ""
			 && (int)$currentpath->elevation != 0))
			{
				$featurePathElevation = 1;
				break;
			}
		}
		foreach ($paths as $key => $currentpath) 
		{
			if (($currentpath->kmllayer != ""
			 && (int)$currentpath->elevation != 0))
			{
				$featurePathElevationKML = 1;
				break;
			}
		}
	}

// Extra checking - begin



$fullWidth = 0;
$fullHeight = 0;


if ($map->headerhtml != "")
{
        $divmapheader .= '<div id="GMapInfoHeader">'.$map->headerhtml;
        if (isset($map->headersep) && (int)$map->headersep == 1) 
        {
            $divmapheader .= '<hr id="mapHeaderLine" />';
        }
        $divmapheader .= '</div>';
}

if ($map->footerhtml != "")
{
       $divmapfooter .= '<div id="GMapInfoFooter">';
        if (isset($map->footersep) && (int)$map->footersep == 1) 
        {
            $divmapfooter .= '<hr id="mapFooterLine" />';
        }
       $divmapfooter .= $map->footerhtml.'</div>';
}

if ((!isset($map->width)) || (isset($map->width) && (int)$map->width < 1)) 
{
	$fullWidth = 1;
}
if ((!isset($map->height)) || (isset($map->height) && (int)$map->height < 1)) 
{
	$fullHeight = 1;
}

if (isset($map->markergroupcontrol) && (int)$map->markergroupcontrol != 0) 
{
	if ($compatiblemodersf == 0)
	{
		$document->addStyleSheet(JURI::root() .'administrator/components/com_zhgooglemap/assets/css/markergroups.css');
	}
	else
	{
		$document->addStyleSheet(JURI::root() .'components/com_zhgooglemap/assets/css/markergroups.css');
	}
	
	
	switch ((int)$map->markergroupcss) 
	{
		
		case 0:
			$markergroupcssstyle = '-simple';
		break;
		case 1:
			$markergroupcssstyle = '-advanced';
		break;
		case 2:
			$markergroupcssstyle = '-external';
		break;
		default:
			$markergroupcssstyle = '-simple';
		break;
	}


       	$divmarkergroup =  '<div id="GMapsMenu'.$markergroupcssstyle.'" style="margin:0;padding:0;width=100%;">'."\n";
        if ($map->markergrouptitle != "")
        {
            $divmarkergroup .= '<div id="groupList"><h2 id="groupListHeadTitle" class="groupListHead">'.htmlspecialchars($map->markergrouptitle , ENT_QUOTES, 'UTF-8').'</h2></div>';
        }
        
        if ($map->markergroupdesc1 != "")
        {
            $divmarkergroup .= '<div id="groupListBodyTopContent" class="groupListBodyTop">'.htmlspecialchars($map->markergroupdesc1 , ENT_QUOTES, 'UTF-8').'</div>';
        }

        if (isset($map->markergroupsep1) && (int)$map->markergroupsep1 == 1) 
        {
            $divmarkergroup .= '<hr id="groupListLineTop" />';
        }

        
        $divmarkergroup .= '<ul id="zhgm-menu'.$markergroupcssstyle.'">'."\n";

        if (isset($markergroups) && !empty($markergroups)) 
		{

			foreach ($markergroups as $key => $currentmarkergroup) 
			{
				if (((int)$currentmarkergroup->published == 1) || ($allowUserMarker == 1))
				{
					$imgimg = $imgpathIcons.str_replace("#", "%23", $currentmarkergroup->icontype).'.png';

					$markergroupname ='';
					$markergroupname = 'markergroup'. $currentmarkergroup->id;

					if ((int)$currentmarkergroup->activeincluster == 1)
					{
						$markergroupactive = 'class="active"';
					}
					else
					{
						$markergroupactive = 'class=""';
					}


					if (isset($map->markercluster) && (int)$map->markercluster == 1)
					{
						if ((isset($map->markerclustergroup) && (int)$map->markerclustergroup == 1))
						{

							switch ((int)$map->markergroupshowicon) 
							{
								
								case 0:
									$divmarkergroup .= '<li id="li-'.$markergroupname.'"><div id="zhgm-markergroup-a-'.$markergroupname.'" class="zhgm-markergroup-a'.$markergroupcssstyle.'"><a '.$markergroupactive.' id="a-'.$markergroupname.'" href="#" onclick="callMarkerChangeGroup(\'a-'.$markergroupname.'\', markerCluster'.$currentmarkergroup->id.', '.$currentmarkergroup->id.');return false;"><div id="zhgm-markergroup-text-'.$markergroupname.'" class="zhgm-markergroup-text'.$markergroupcssstyle.'">'.htmlspecialchars(str_replace('\\', '/',$currentmarkergroup->title), ENT_QUOTES, 'UTF-8').'</div></a></div></li>'."\n";
								break;
								case 1:
									$divmarkergroup .= '<li id="li-'.$markergroupname.'"><div id="zhgm-markergroup-a-'.$markergroupname.'" class="zhgm-markergroup-a'.$markergroupcssstyle.'"><a '.$markergroupactive.' id="a-'.$markergroupname.'" href="#" onclick="callMarkerChangeGroup(\'a-'.$markergroupname.'\', markerCluster'.$currentmarkergroup->id.', '.$currentmarkergroup->id.');return false;"><div id="zhgm-markergroup-img-'.$markergroupname.'" class="zhgm-markergroup-img'.$markergroupcssstyle.'"><img src="'.$imgimg.'" alt="" /></div><div id="zhgm-markergroup-text-'.$markergroupname.'" class="zhgm-markergroup-text'.$markergroupcssstyle.'">'.htmlspecialchars(str_replace('\\', '/',$currentmarkergroup->title), ENT_QUOTES, 'UTF-8').'</div></a></div></li>'."\n";
								break;
								case 2:
									$divmarkergroup .= '<li id="li-'.$markergroupname.'"><div id="zhgm-markergroup-a-'.$markergroupname.'" class="zhgm-markergroup-a'.$markergroupcssstyle.'"><a '.$markergroupactive.' id="a-'.$markergroupname.'" href="#" onclick="callMarkerChangeGroup(\'a-'.$markergroupname.'\', markerCluster'.$currentmarkergroup->id.', '.$currentmarkergroup->id.');return false;"><div id="zhgm-markergroup-img-'.$markergroupname.'" class="zhgm-markergroup-img'.$markergroupcssstyle.'"><img src="'.$imgimg.'" alt="" /></div></a></div></li>'."\n";
								break;
								default:
									$divmarkergroup .= '<li id="li-'.$markergroupname.'"><div id="zhgm-markergroup-a-'.$markergroupname.'" class="zhgm-markergroup-a'.$markergroupcssstyle.'"><a '.$markergroupactive.' id="a-'.$markergroupname.'" href="#" onclick="callMarkerChangeGroup(\'a-'.$markergroupname.'\', markerCluster'.$currentmarkergroup->id.', '.$currentmarkergroup->id.');return false;"><div id="zhgm-markergroup-text-'.$markergroupname.'" class="zhgm-markergroup-text'.$markergroupcssstyle.'">'.htmlspecialchars(str_replace('\\', '/',$currentmarkergroup->title), ENT_QUOTES, 'UTF-8').'</div></a></div></li>'."\n";
								break;
							}
						}   
						else
						{
							switch ((int)$map->markergroupshowicon) 
							{
								
								case 0:
									$divmarkergroup .= '<li id="li-'.$markergroupname.'"><div id="zhgm-markergroup-a-'.$markergroupname.'" class="zhgm-markergroup-a'.$markergroupcssstyle.'"><a '.$markergroupactive.' id="a-'.$markergroupname.'" href="#" onclick="callMarkerChange(\'a-'.$markergroupname.'\', clustermarkers'.$currentmarkergroup->id.');return false;"><div id="zhgm-markergroup-text-'.$markergroupname.'" class="zhgm-markergroup-text'.$markergroupcssstyle.'">'.htmlspecialchars(str_replace('\\', '/',$currentmarkergroup->title), ENT_QUOTES, 'UTF-8').'</div></a></div></li>'."\n";
								break;
								case 1:
									$divmarkergroup .= '<li id="li-'.$markergroupname.'"><div id="zhgm-markergroup-a-'.$markergroupname.'" class="zhgm-markergroup-a'.$markergroupcssstyle.'"><a '.$markergroupactive.' id="a-'.$markergroupname.'" href="#" onclick="callMarkerChange(\'a-'.$markergroupname.'\', clustermarkers'.$currentmarkergroup->id.');return false;"><div id="zhgm-markergroup-img-'.$markergroupname.'" class="zhgm-markergroup-img'.$markergroupcssstyle.'"><img src="'.$imgimg.'" alt="" /></div><div id="zhgm-markergroup-text-'.$markergroupname.'" class="zhgm-markergroup-text'.$markergroupcssstyle.'">'.htmlspecialchars(str_replace('\\', '/',$currentmarkergroup->title), ENT_QUOTES, 'UTF-8').'</div></a></div></li>'."\n";
								break;
								case 2:
									$divmarkergroup .= '<li id="li-'.$markergroupname.'"><div id="zhgm-markergroup-a-'.$markergroupname.'" class="zhgm-markergroup-a'.$markergroupcssstyle.'"><a '.$markergroupactive.' id="a-'.$markergroupname.'" href="#" onclick="callMarkerChange(\'a-'.$markergroupname.'\', clustermarkers'.$currentmarkergroup->id.');return false;"><div id="zhgm-markergroup-img-'.$markergroupname.'" class="zhgm-markergroup-img'.$markergroupcssstyle.'"><img src="'.$imgimg.'" alt="" /></div></a></div></li>'."\n";
								break;
								default:
									$divmarkergroup .= '<li id="li-'.$markergroupname.'"><div id="zhgm-markergroup-a-'.$markergroupname.'" class="zhgm-markergroup-a'.$markergroupcssstyle.'"><a '.$markergroupactive.' id="a-'.$markergroupname.'" href="#" onclick="callMarkerChange(\'a-'.$markergroupname.'\', clustermarkers'.$currentmarkergroup->id.');return false;"><div id="zhgm-markergroup-text-'.$markergroupname.'" class="zhgm-markergroup-text'.$markergroupcssstyle.'">'.htmlspecialchars(str_replace('\\', '/',$currentmarkergroup->title), ENT_QUOTES, 'UTF-8').'</div></a></div></li>'."\n";
								break;
							}
						}
					}   
					else
					{
						switch ((int)$map->markergroupshowicon) 
						{
							
							case 0:
								$divmarkergroup .= '<li id="li-'.$markergroupname.'"><div id="zhgm-markergroup-a-'.$markergroupname.'" class="zhgm-markergroup-a'.$markergroupcssstyle.'"><a '.$markergroupactive.' id="a-'.$markergroupname.'" href="#" onclick="callMarkerArrayChange(\'a-'.$markergroupname.'\', clustermarkers'.$currentmarkergroup->id.');return false;"><div id="zhgm-markergroup-text-'.$markergroupname.'" class="zhgm-markergroup-text'.$markergroupcssstyle.'">'.htmlspecialchars(str_replace('\\', '/',$currentmarkergroup->title), ENT_QUOTES, 'UTF-8').'</div></a></div></li>'."\n";
							break;
							case 1:
								$divmarkergroup .= '<li id="li-'.$markergroupname.'"><div id="zhgm-markergroup-a-'.$markergroupname.'" class="zhgm-markergroup-a'.$markergroupcssstyle.'"><a '.$markergroupactive.' id="a-'.$markergroupname.'" href="#" onclick="callMarkerArrayChange(\'a-'.$markergroupname.'\', clustermarkers'.$currentmarkergroup->id.');return false;"><div id="zhgm-markergroup-img-'.$markergroupname.'" class="zhgm-markergroup-img'.$markergroupcssstyle.'"><img src="'.$imgimg.'" alt="" /></div><div id="zhgm-markergroup-text-'.$markergroupname.'" class="zhgm-markergroup-text'.$markergroupcssstyle.'">'.htmlspecialchars(str_replace('\\', '/',$currentmarkergroup->title), ENT_QUOTES, 'UTF-8').'</div></a></div></li>'."\n";
							break;
							case 2:
								$divmarkergroup .= '<li id="li-'.$markergroupname.'"><div id="zhgm-markergroup-a-'.$markergroupname.'" class="zhgm-markergroup-a'.$markergroupcssstyle.'"><a '.$markergroupactive.' id="a-'.$markergroupname.'" href="#" onclick="callMarkerArrayChange(\'a-'.$markergroupname.'\', clustermarkers'.$currentmarkergroup->id.');return false;"><div id="zhgm-markergroup-img-'.$markergroupname.'" class="zhgm-markergroup-img'.$markergroupcssstyle.'"><img src="'.$imgimg.'" alt="" /></div></a></div></li>'."\n";
							break;
							default:
								$divmarkergroup .= '<li id="li-'.$markergroupname.'"><div id="zhgm-markergroup-a-'.$markergroupname.'" class="zhgm-markergroup-a'.$markergroupcssstyle.'"><a '.$markergroupactive.' id="a-'.$markergroupname.'" href="#" onclick="callMarkerArrayChange(\'a-'.$markergroupname.'\', clustermarkers'.$currentmarkergroup->id.');return false;"><div id="zhgm-markergroup-text-'.$markergroupname.'" class="zhgm-markergroup-text'.$markergroupcssstyle.'">'.htmlspecialchars(str_replace('\\', '/',$currentmarkergroup->title), ENT_QUOTES, 'UTF-8').'</div></a></div></li>'."\n";
							break;
						}
					} 
				}
			}
		}


        $divmarkergroup .= '</ul>'."\n";

        if (isset($map->markergroupsep2) && (int)$map->markergroupsep2 == 1) 
        {
            $divmarkergroup .= '<hr id="groupListLineBottom" />';
        }
        
        if ($map->markergroupdesc2 != "")
        {
            $divmarkergroup .= '<div id="groupListBodyBottomContent" class="groupListBodyBottom">'.htmlspecialchars($map->markergroupdesc2 , ENT_QUOTES, 'UTF-8').'</div>';
        }
        
        $divmarkergroup .= '</div>'."\n";

}

$mainScriptBegin = "\n".' <script type="text/javascript" src="'.$urlProtocol.'://maps.googleapis.com/maps/api/js?';
if ($apiversion != "")
{
	$mainScriptBegin .= 'v='.$apiversion.'&amp;';
}
if ($apikey4map != "")
{
	$mainScriptBegin .= 'key='.$apikey4map.'&sensor=false';
}
else
{
	$mainScriptBegin .= 'sensor=false';
}

$mainScriptEnd = '"></script>' ."\n";
$mainScriptAdd ="";
$mainScriptLibrary ="";

 
$mainLang = "";

if (isset($map->lang) && $map->lang != "")
{
	$mainLang = substr($map->lang,0, strpos($map->lang, '-'));

	if ($mainLang != "")
	{
		$mainScriptAdd .= '&amp;language='.$mainLang;
	}
	
}
 
if (isset($map->placesenable) && (int)$map->placesenable == 1)
{
	if ($mainScriptLibrary == "")
	{
		$mainScriptLibrary .= '&amp;libraries=places';
	}
	else
	{
		$mainScriptLibrary .= ',places';
	}
}

if (isset($map->panoramioenable) && (int)$map->panoramioenable == 1)
{
	if ($mainScriptLibrary == "")
	{
		$mainScriptLibrary .= '&amp;libraries=panoramio';
	}
	else
	{
		$mainScriptLibrary .= ',panoramio';
	}
}

if (isset($adsences) && !empty($adsences)) 
{
	if ($mainScriptLibrary == "")
	{
		$mainScriptLibrary .= '&amp;libraries=adsense';
	}
	else
	{
		$mainScriptLibrary .= ',adsense';
	}
}

if (isset($map->weathertypeid) && (int)$map->weathertypeid != 0)
{
	if ($mainScriptLibrary == "")
	{
		$mainScriptLibrary .= '&amp;libraries=weather';
	}
	else
	{
		$mainScriptLibrary .= ',weather';
	}
}

$mainScriptAdd .= $mainScriptLibrary;

echo $mainScriptBegin . $mainScriptAdd . $mainScriptEnd;


if (isset($map->markercluster) && (int)$map->markercluster == 1)
{
	//new version of MarkerClusterer
	//echo "\n".' <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/tags/markerclusterer/1.0/src/markerclusterer_compiled.js"></script>' ."\n";
    echo "\n".' <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/tags/markerclustererplus/2.0.15/src/markerclusterer_packed.js"></script>' ."\n";
}

if (  (isset($map->markermanager) && (int)$map->markermanager == 1)
   && (isset($map->markercluster) && (int)$map->markercluster == 0)
   && (isset($map->markergroupcontrol) && (int)$map->markergroupcontrol == 0)
   )
{
    echo "\n".' <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/tags/markermanager/1.0/src/markermanager.js"></script>' ."\n";
}



if (isset($map->earth) && (int)$map->earth != 0 && $apikey4earth != "")
{
	//echo "\n".' <script type="text/javascript" src="https://www.google.com/jsapi"></script>' ."\n";
    echo "\n".' <script type="text/javascript" src="'.$urlProtocol.'://www.google.com/jsapi?key='.$apikey4earth.'"></script>' ."\n";
    echo "\n".' <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/googleearth/src/googleearth-compiled.js"></script>' ."\n";
    //echo "\n".' <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/googleearth/src/googleearth.js"></script>' ."\n";
}
else
{
	if ($featurePathElevation == 1)
	{
		echo "\n".' <script type="text/javascript" src="'.$urlProtocol.'://www.google.com/jsapi"></script>' ."\n";
		
		if ($featurePathElevationKML == 1)
		{
			echo "\n".' <script type="text/javascript" src="'.$urlProtocol.'://geoxml3.googlecode.com/svn/branches/polys/geoxml3.js"></script>' ."\n";
			echo "\n".' <script type="text/javascript" src="'.$urlProtocol.'://geoxml3.googlecode.com/svn/trunk/ProjectedOverlay.js"></script>' ."\n";
		}
	}
}

if (isset($markers) && !empty($markers)) 
{
	foreach ($markers as $key => $currentmarker) 
	{
		if ((int)$currentmarker->actionbyclick == 4)
		{
			echo "\n".' <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobubble/src/infobubble-compiled.js"></script>' ."\n";
			break; 
		}
	}
}

$divmap = "";

if (isset($map->placesenable) && (int)$map->placesenable == 1) 
{
	// Add autocomplete field only if find control is off
	if ((isset($map->placesautocomplete) && (int)$map->placesautocomplete == 1)
	 && (isset($map->findcontrol) && (int)$map->findcontrol == 0) )
	{
		$divmap .='<div id="placesAutocomplete">';
		if (isset($map->placesdirection) 
		&& (int)$map->placesdirection == 1) 
		{
			$divmap .= '<select id="searchTravelMode" >' ."\n";
			if ((int)$map->routedriving == 1
			   || ((int)$map->routewalking == 0 
			    && (int)$map->routetransit == 0 
			    && (int)$map->routebicycling == 0))
			{
				$divmap .= '<option value="google.maps.TravelMode.DRIVING" selected="selected">'.JText::_('MOD_ZHGOOGLEMAP_ROUTER_TRAVELMODE_DRIVING').'</option>' ."\n";
			}
			if ((int)$map->routewalking == 1)
			{
				$divmap .= '<option value="google.maps.TravelMode.WALKING">'.JText::_('MOD_ZHGOOGLEMAP_ROUTER_TRAVELMODE_WALKING').'</option>' ."\n";
			}
			if ((int)$map->routebicycling == 1)
			{
				$divmap .= '<option value="google.maps.TravelMode.BICYCLING">'.JText::_('MOD_ZHGOOGLEMAP_ROUTER_TRAVELMODE_BICYCLING').'</option>' ."\n";
			}
			if ((int)$map->routetransit == 1)
			{
				$divmap .= '<option value="google.maps.TravelMode.TRANSIT">'.JText::_('MOD_ZHGOOGLEMAP_ROUTER_TRAVELMODE_TRANSIT').'</option>' ."\n";
			}
			$divmap .= '</select>' ."\n";
		}
		$divmap .= '<input id="searchTextField" type="text"'; 
		if (isset($map->placesacwidth) && (int)$map->placesacwidth != 0)
		{
			$divmap .= ' size="'.(int)$map->placesacwidth.'"';
		}
		$divmap .=' />';
		$divmap .='</div>'."\n";
	}
}

if (isset($map->panoramioenable) && (int)$map->panoramioenable == 1) 
{
	if (isset($map->panoramiofiltercontrol) && (int)$map->panoramiofiltercontrol == 1)
	{
		$divmap .='<div id="panoramioFilter">';
		$divmap .= '  '.JText::_('MOD_ZHGOOGLEMAP_MAP_PANORAMIOTAG');
		$divmap .= '  <input id="panoramioFilterTag" type="text" />';
		$divmap .= '  <button id="panoramioFilterButton">'.JText::_('MOD_ZHGOOGLEMAP_MAP_PANORAMIOBUTTON').'</button>';
		$divmap .='</div>'."\n";
	}
}

if (isset($map->geolocationcontrol) && (int)$map->geolocationcontrol == 1) 
{
	$divmap .='<div id="geoLocation">';
	$divmap .= '  <button id="geoLocationButton">';

	switch ((int)$map->geolocationbutton) 
	{
		
		case 1:
			$divmap .= '<img src="'.$imgpathUtils.'geolocation.png" alt="'.JText::_('MOD_ZHGOOGLEMAP_MAP_GEOLOCATIONBUTTON').'" style="vertical-align: middle" />';
		break;
		case 2:
			$divmap .= JText::_('MOD_ZHGOOGLEMAP_MAP_GEOLOCATIONBUTTON');
		break;
		case 3:
			$divmap .= '<img src="'.$imgpathUtils.'geolocation.png" alt="'.JText::_('MOD_ZHGOOGLEMAP_MAP_GEOLOCATIONBUTTON').'" style="vertical-align: middle" />';
			$divmap .= JText::_('MOD_ZHGOOGLEMAP_MAP_GEOLOCATIONBUTTON');
		break;
		default:
			$divmap .= '<img src="'.$imgpathUtils.'geolocation.png" alt="'.JText::_('MOD_ZHGOOGLEMAP_MAP_GEOLOCATIONBUTTON').'" style="vertical-align: middle" />';
		break;
	}
	
	$divmap .= '</button>';
	$divmap .='</div>'."\n";
}


$divmapbefore = "";
$divmapafter = "";


	if ((isset($map->placesenable) && (int)$map->placesenable == 1)
	 && (isset($map->placesautocomplete) && (int)$map->placesautocomplete == 1)
	 && (isset($map->findcontrol) && (int)$map->findcontrol == 0))
	{
		if (isset($map->placesdirection) && (int)$map->placesdirection == 1)
		{
			$service_DoDirection = 1;
		}
		else
		{
			$service_DoDirection = 0;
		}
	}
	else if (isset($map->findcontrol) && (int)$map->findcontrol == 1)
	{
		if (isset($map->findroute) && (int)$map->findroute != 0)
		{
			$service_DoDirection = 1;
		}
		else
		{
			$service_DoDirection = 0;
		}
	}
	else
	{
		$service_DoDirection = 0;
	}

if (isset($map->findcontrol) && (int)$map->findcontrol == 1) 
{
	if (isset($map->findpos) && (int)$map->findpos == 101)
	{
		$divmapbefore .='<div id="GMapFindAddress" class="zhgm-find-address">';
		$divmapbefore .='<div id="GMapFindTarget" class="zhgm-find-target">'."\n";
		$divmapbefore .='<span id="GMapFindTargetIcon"></span>'."\n";
		$divmapbefore .='<span id="GMapFindTargetText"></span>'."\n";
		$divmapbefore .='</div>'."\n";
		$divmapbefore .='<div id="GMapFindPanel" class="zhgm-find-panel">'."\n";
		$divmapbefore .='<span id="GMapFindPanelIcon"></span>'."\n";
		if (((int)$map->findroute != 0) || ((int)$map->placesdirection == 1)) 
		{
			$divmapbefore .= '<select id="findAddressTravelMode" >' ."\n";
			if ((int)$map->routedriving == 1
			   || ((int)$map->routewalking == 0 
			    && (int)$map->routetransit == 0 
			    && (int)$map->routebicycling == 0))
			{
				$divmapbefore .= '<option value="google.maps.TravelMode.DRIVING" selected="selected">'.JText::_('MOD_ZHGOOGLEMAP_ROUTER_TRAVELMODE_DRIVING').'</option>' ."\n";
			}
			if ((int)$map->routewalking == 1)
			{
				$divmapbefore .= '<option value="google.maps.TravelMode.WALKING">'.JText::_('MOD_ZHGOOGLEMAP_ROUTER_TRAVELMODE_WALKING').'</option>' ."\n";
			}
			if ((int)$map->routebicycling == 1)
			{
				$divmapbefore .= '<option value="google.maps.TravelMode.BICYCLING">'.JText::_('MOD_ZHGOOGLEMAP_ROUTER_TRAVELMODE_BICYCLING').'</option>' ."\n";
			}
			if ((int)$map->routetransit == 1)
			{
				$divmapbefore .= '<option value="google.maps.TravelMode.TRANSIT">'.JText::_('MOD_ZHGOOGLEMAP_ROUTER_TRAVELMODE_TRANSIT').'</option>' ."\n";
			}
			$divmapbefore .= '</select>' ."\n";
		}
		$divmapbefore .= '  <input id="findAddressField" type="text"';
		if (isset($map->findwidth) && (int)$map->findwidth != 0)
		{
			$divmapbefore .= ' size="'.(int)$map->findwidth.'"';
		}
		$divmapbefore .=' />';
		if (isset($map->findroute) && (int)$map->findroute == 0) 
		{
			$divmapbefore .= '  <button id="findAddressButton">';
			$divmapbefore .= JText::_('MOD_ZHGOOGLEMAP_MAP_DOFINDBUTTON');
			$divmapbefore .='</button>';
		}
		else if (isset($map->findroute) && (int)$map->findroute == 1) 
		{
			$divmapbefore .= '  <button id="findAddressButton">';
			$divmapbefore .= JText::_('MOD_ZHGOOGLEMAP_MAP_ROUTE');
			$divmapbefore .='</button>';
		}
		else if (isset($map->findroute) && (int)$map->findroute == 2) 
		{
			$divmapbefore .= '  <button id="findAddressButtonFind">';
			$divmapbefore .= JText::_('MOD_ZHGOOGLEMAP_MAP_DOFINDBUTTON');
			$divmapbefore .='</button>';
			$divmapbefore .= '  <button id="findAddressButton">';
			$divmapbefore .= JText::_('MOD_ZHGOOGLEMAP_MAP_ROUTE');
			$divmapbefore .='</button>';
		}
		else
		{
			$divmapbefore .= '  <button id="findAddressButton">';
			$divmapbefore .= JText::_('MOD_ZHGOOGLEMAP_MAP_DOFINDBUTTON');
			$divmapbefore .='</button>';
		}
		$divmapbefore .='</div>'."\n";
		$divmapbefore .='</div>'."\n";
	}
	else if (isset($map->findpos) && (int)$map->findpos == 102)
	{
		$divmapafter .='<div id="GMapFindAddress" class="zhgm-find-address">';
		$divmapafter .='<div id="GMapFindTarget" class="zhgm-find-target">'."\n";
		$divmapafter .='<span id="GMapFindTargetIcon"></span>'."\n";
		$divmapafter .='<span id="GMapFindTargetText"></span>'."\n";
		$divmapafter .='</div>'."\n";
		$divmapafter .='<div id="GMapFindPanel" class="zhgm-find-panel">'."\n";
		$divmapafter .='<span id="GMapFindPanelIcon"></span>'."\n";
		if (isset($map->findroute) && (int)$map->findroute != 0) 
		{
			$divmapafter .= '<select id="findAddressTravelMode" >' ."\n";
			if ((int)$map->routedriving == 1
			   || ((int)$map->routewalking == 0 
			    && (int)$map->routetransit == 0 
			    && (int)$map->routebicycling == 0))
			{
				$divmapafter .= '<option value="google.maps.TravelMode.DRIVING" selected="selected">'.JText::_('MOD_ZHGOOGLEMAP_ROUTER_TRAVELMODE_DRIVING').'</option>' ."\n";
			}
			if ((int)$map->routewalking == 1)
			{
				$divmapafter .= '<option value="google.maps.TravelMode.WALKING">'.JText::_('MOD_ZHGOOGLEMAP_ROUTER_TRAVELMODE_WALKING').'</option>' ."\n";
			}
			if ((int)$map->routebicycling == 1)
			{
				$divmapafter .= '<option value="google.maps.TravelMode.BICYCLING">'.JText::_('MOD_ZHGOOGLEMAP_ROUTER_TRAVELMODE_BICYCLING').'</option>' ."\n";
			}
			if ((int)$map->routetransit == 1)
			{
				$divmapafter .= '<option value="google.maps.TravelMode.TRANSIT">'.JText::_('MOD_ZHGOOGLEMAP_ROUTER_TRAVELMODE_TRANSIT').'</option>' ."\n";
			}
			$divmapafter .= '</select>' ."\n";
		}
		$divmapafter .= '  <input id="findAddressField" type="text"';
		if (isset($map->findwidth) && (int)$map->findwidth != 0)
		{
			$divmapafter .= ' size="'.(int)$map->findwidth.'"';
		}
		$divmapafter .=' />';
		if (isset($map->findroute) && (int)$map->findroute == 0) 
		{
			$divmapafter .= '  <button id="findAddressButton">';
			$divmapafter .= JText::_('MOD_ZHGOOGLEMAP_MAP_DOFINDBUTTON');
			$divmapafter .='</button>';
		}
		else if (isset($map->findroute) && (int)$map->findroute == 1) 
		{
			$divmapafter .= '  <button id="findAddressButton">';
			$divmapafter .= JText::_('MOD_ZHGOOGLEMAP_MAP_ROUTE');
			$divmapafter .='</button>';
		}
		else if (isset($map->findroute) && (int)$map->findroute == 2) 
		{
			$divmapafter .= '  <button id="findAddressButtonFind">';
			$divmapafter .= JText::_('MOD_ZHGOOGLEMAP_MAP_DOFINDBUTTON');
			$divmapafter .='</button>';
			$divmapafter .= '  <button id="findAddressButton">';
			$divmapafter .= JText::_('MOD_ZHGOOGLEMAP_MAP_ROUTE');
			$divmapafter .='</button>';
		}
		else
		{
			$divmapafter .= '  <button id="findAddressButton">';
			$divmapafter .= JText::_('MOD_ZHGOOGLEMAP_MAP_DOFINDBUTTON');
			$divmapafter .='</button>';
		}
		$divmapafter .='</div>'."\n";
		$divmapafter .='</div>'."\n";
	}
	else
	{
		$divmap .='<div id="GMapFindAddress" class="zhgm-find-address">' ."\n";
		$divmap .='<div id="GMapFindTarget" class="zhgm-find-target">'."\n";
		$divmap .='<span id="GMapFindTargetIcon"></span>'."\n";
		$divmap .='<span id="GMapFindTargetText"></span>'."\n";
		$divmap .='</div>'."\n";
		$divmap .='<div id="GMapFindPanel" class="zhgm-find-panel">'."\n";
		$divmap .='<span id="GMapFindPanelIcon"></span>'."\n";
		if (isset($map->findroute) && (int)$map->findroute != 0) 
		{
			$divmap .= '<select id="findAddressTravelMode" >' ."\n";
			if ((int)$map->routedriving == 1
			   || ((int)$map->routewalking == 0 
			    && (int)$map->routetransit == 0
			    && (int)$map->routebicycling == 0))
			{
				$divmap .= '<option value="google.maps.TravelMode.DRIVING" selected="selected">'.JText::_('MOD_ZHGOOGLEMAP_ROUTER_TRAVELMODE_DRIVING').'</option>' ."\n";
			}
			if ((int)$map->routewalking == 1)
			{
				$divmap .= '<option value="google.maps.TravelMode.WALKING">'.JText::_('MOD_ZHGOOGLEMAP_ROUTER_TRAVELMODE_WALKING').'</option>' ."\n";
			}
			if ((int)$map->routebicycling == 1)
			{
				$divmap .= '<option value="google.maps.TravelMode.BICYCLING">'.JText::_('MOD_ZHGOOGLEMAP_ROUTER_TRAVELMODE_BICYCLING').'</option>' ."\n";
			}
			if ((int)$map->routetransit == 1)
			{
				$divmap .= '<option value="google.maps.TravelMode.TRANSIT">'.JText::_('MOD_ZHGOOGLEMAP_ROUTER_TRAVELMODE_TRANSIT').'</option>' ."\n";
			}
			$divmap .= '</select>' ."\n";
		}
		$divmap .= '  <input id="findAddressField" type="text"';
		if (isset($map->findwidth) && (int)$map->findwidth != 0)
		{
			$divmap .= ' size="'.(int)$map->findwidth.'"';
		}
		$divmap .=' />' ."\n";;
		if (isset($map->findroute) && (int)$map->findroute == 0) 
		{
			$divmap .= '  <button id="findAddressButton">';
			$divmap .= JText::_('MOD_ZHGOOGLEMAP_MAP_DOFINDBUTTON');
			$divmap .='</button>';
		}
		else if (isset($map->findroute) && (int)$map->findroute == 1) 
		{
			$divmap .= '  <button id="findAddressButton">';
			$divmap .= JText::_('MOD_ZHGOOGLEMAP_MAP_ROUTE');
			$divmap .='</button>';
		}
		else if (isset($map->findroute) && (int)$map->findroute == 2) 
		{
			$divmap .= '  <button id="findAddressButtonFind">';
			$divmap .= JText::_('MOD_ZHGOOGLEMAP_MAP_DOFINDBUTTON');
			$divmap .='</button>';
			$divmap .= '  <button id="findAddressButton">';
			$divmap .= JText::_('MOD_ZHGOOGLEMAP_MAP_ROUTE');
			$divmap .='</button>';
		}
		else
		{
			$divmap .= '  <button id="findAddressButton">';
			$divmap .= JText::_('MOD_ZHGOOGLEMAP_MAP_DOFINDBUTTON');
			$divmap .='</button>';
		}
		$divmap .='</div>'."\n";
		$divmap .='</div>'."\n";
	}
}

	$divwrapmapstyle = '';
	$divtabcolmapstyle = '';
	
	if ($fullWidth == 1)
	{
		$divwrapmapstyle .= 'width:100%;';
	}
	if ($fullHeight == 1)
	{
		$divwrapmapstyle .= 'height:100%;';
		$divtabcolmapstyle .= 'height:100%;';
	}
	if ($divwrapmapstyle != "")
	{
		$divwrapmapstyle = 'style="'.$divwrapmapstyle.'"';
	}
	if ($divtabcolmapstyle != "")
	{
		$divtabcolmapstyle = 'style="'.$divtabcolmapstyle.'"';
	}

// adding markerlist (div)
if (isset($map->markerlistpos) && (int)$map->markerlistpos != 0) 
{

	if ($compatiblemodersf == 0)
	{
		$document->addStyleSheet(JURI::root() .'administrator/components/com_zhgooglemap/assets/css/markerlists.css');
	}
	else
	{
		$document->addStyleSheet(JURI::root() .'components/com_zhgooglemap/assets/css/markerlists.css');
	}
	
	
	switch ((int)$map->markerlist) 
	{
		
		case 0:
			$markerlistcssstyle = 'markerList-simple';
		break;
		case 1:
			$markerlistcssstyle = 'markerList-advanced';
		break;
		case 2:
			$markerlistcssstyle = 'markerList-external';
		break;
		default:
			$markerlistcssstyle = 'markerList-simple';
		break;
	}


	$markerlistAddStyle ='';
	
	if ($map->markerlistbgcolor != "")
	{
		$markerlistAddStyle .= ' background: '.$map->markerlistbgcolor.';';
	}
	
	if ((int)$map->markerlistwidth == 0)
	{
		if ((int)$map->markerlistpos == 113
		  ||(int)$map->markerlistpos == 114
		  ||(int)$map->markerlistpos == 121)
		{
			$divMarkerlistWidth = '100%';
		}
		else
		{
			$divMarkerlistWidth = '200px';
		}
	}
	else
	{
		$divMarkerlistWidth = $map->markerlistwidth;
		$divMarkerlistWidth = $divMarkerlistWidth. 'px';
	}

	if ((int)$map->markerlistpos == 111
	  ||(int)$map->markerlistpos == 112)
	{
		if ($fullHeight == 1)
		{
			$divMarkerlistHeight = '100%';
		}
		else
		{
			$divMarkerlistHeight = $map->height;
			$divMarkerlistHeight = $divMarkerlistHeight. 'px';
		}
	}
	else
	{
		if ((int)$map->markerlistheight == 0)
		{
			$divMarkerlistHeight = 200;
		}
		else
		{
			$divMarkerlistHeight = $map->markerlistheight;
		}
		$divMarkerlistHeight = $divMarkerlistHeight. 'px';
	}		
	
	if ((int)$map->markerlistcontent < 100) 
	{
		$markerlisttag = '<ul id="GMapsMarkerUL" class="zhgm-ul-'.$markerlistcssstyle.'"></ul>';
	}
	else 
	{
		$markerlisttag =  '<table id="GMapsMarkerTABLE" class="zhgm-ul-table-'.$markerlistcssstyle.'" ';
		if (((int)$map->markerlistpos == 113) 
		|| ((int)$map->markerlistpos == 114) 
		|| ((int)$map->markerlistpos == 121))
		{
			if ($fullWidth == 1) 
			{
				$markerlisttag .= 'style="width:100%;" ';
			}
		}
		$markerlisttag .= '>';
		$markerlisttag .= '<tbody id="GMapsMarkerTABLEBODY" class="zhgm-ul-tablebody-'.$markerlistcssstyle.'">';
		$markerlisttag .= '</tbody>';
		$markerlisttag .= '</table>';
	}
	
	
	switch ((int)$map->markerlistpos) 
	{
		case 0:
			// None
		break;
		case 1:
			$divmap .= '<div id="GMMapWrapper" '.$divwrapmapstyle.' class="zhgm-wrap-'.$markerlistcssstyle.'">';
			$divmap .='<div id="GMapsMarkerList" class="zhgm-list-'.$markerlistcssstyle.'" style="'.$markerlistAddStyle.' display: none; float: left; padding: 0; margin: 5px; width:'.$divMarkerlistWidth.'; height:'.$divMarkerlistHeight.';">'.$markerlisttag.'</div>';
		break;
		case 2:
			$divmap .= '<div id="GMMapWrapper" '.$divwrapmapstyle.' class="zhgm-wrap-'.$markerlistcssstyle.'">';
			$divmap .='<div id="GMapsMarkerList" class="zhgm-list-'.$markerlistcssstyle.'" style="'.$markerlistAddStyle.' display: none; float: left; padding: 0; margin: 5px; width:'.$divMarkerlistWidth.'; height:'.$divMarkerlistHeight.';">'.$markerlisttag.'</div>';
		break;
		case 3:
			$divmap .= '<div id="GMMapWrapper" '.$divwrapmapstyle.' class="zhgm-wrap-'.$markerlistcssstyle.'">';
			$divmap .='<div id="GMapsMarkerList" class="zhgm-list-'.$markerlistcssstyle.'" style="'.$markerlistAddStyle.' display: none; float: left; padding: 0; margin: 5px; width:'.$divMarkerlistWidth.'; height:'.$divMarkerlistHeight.';">'.$markerlisttag.'</div>';
		break;
		case 4:
			$divmap .= '<div id="GMMapWrapper" '.$divwrapmapstyle.' class="zhgm-wrap-'.$markerlistcssstyle.'">';
			$divmap .='<div id="GMapsMarkerList" class="zhgm-list-'.$markerlistcssstyle.'" style="'.$markerlistAddStyle.' display: none; float: left; padding: 0; margin: 5px; width:'.$divMarkerlistWidth.'; height:'.$divMarkerlistHeight.';">'.$markerlisttag.'</div>';
		break;
		case 5:
			$divmap .= '<div id="GMMapWrapper" '.$divwrapmapstyle.' class="zhgm-wrap-'.$markerlistcssstyle.'">';
			$divmap .='<div id="GMapsMarkerList" class="zhgm-list-'.$markerlistcssstyle.'" style="'.$markerlistAddStyle.' display: none; float: left; padding: 0; margin: 5px; width:'.$divMarkerlistWidth.'; height:'.$divMarkerlistHeight.';">'.$markerlisttag.'</div>';
		break;
		case 6:
			$divmap .= '<div id="GMMapWrapper" '.$divwrapmapstyle.' class="zhgm-wrap-'.$markerlistcssstyle.'">';
			$divmap .='<div id="GMapsMarkerList" class="zhgm-list-'.$markerlistcssstyle.'" style="'.$markerlistAddStyle.' display: none; float: left; padding: 0; margin: 5px; width:'.$divMarkerlistWidth.'; height:'.$divMarkerlistHeight.';">'.$markerlisttag.'</div>';
		break;
		case 7:
			$divmap .= '<div id="GMMapWrapper" '.$divwrapmapstyle.' class="zhgm-wrap-'.$markerlistcssstyle.'">';
			$divmap .='<div id="GMapsMarkerList" class="zhgm-list-'.$markerlistcssstyle.'" style="'.$markerlistAddStyle.' display: none; float: left; padding: 0; margin: 5px; width:'.$divMarkerlistWidth.'; height:'.$divMarkerlistHeight.';">'.$markerlisttag.'</div>';
		break;
		case 8:
			$divmap .= '<div id="GMMapWrapper" '.$divwrapmapstyle.' class="zhgm-wrap-'.$markerlistcssstyle.'">';
			$divmap .='<div id="GMapsMarkerList" class="zhgm-list-'.$markerlistcssstyle.'" style="'.$markerlistAddStyle.' display: none; float: left; padding: 0; margin: 5px; width:'.$divMarkerlistWidth.'; height:'.$divMarkerlistHeight.';">'.$markerlisttag.'</div>';
		break;
		case 9:
			$divmap .= '<div id="GMMapWrapper" '.$divwrapmapstyle.' class="zhgm-wrap-'.$markerlistcssstyle.'">';
			$divmap .='<div id="GMapsMarkerList" class="zhgm-list-'.$markerlistcssstyle.'" style="'.$markerlistAddStyle.' display: none; float: left; padding: 0; margin: 5px; width:'.$divMarkerlistWidth.'; height:'.$divMarkerlistHeight.';">'.$markerlisttag.'</div>';
		break;
		case 10:
			$divmap .= '<div id="GMMapWrapper" '.$divwrapmapstyle.' class="zhgm-wrap-'.$markerlistcssstyle.'">';
			$divmap .='<div id="GMapsMarkerList" class="zhgm-list-'.$markerlistcssstyle.'" style="'.$markerlistAddStyle.' display: none; float: left; padding: 0; margin: 5px; width:'.$divMarkerlistWidth.'; height:'.$divMarkerlistHeight.';">'.$markerlisttag.'</div>';
		break;
		case 11:
			$divmap .= '<div id="GMMapWrapper" '.$divwrapmapstyle.' class="zhgm-wrap-'.$markerlistcssstyle.'">';
			$divmap .='<div id="GMapsMarkerList" class="zhgm-list-'.$markerlistcssstyle.'" style="'.$markerlistAddStyle.' display: none; float: left; padding: 0; margin: 5px; width:'.$divMarkerlistWidth.'; height:'.$divMarkerlistHeight.';">'.$markerlisttag.'</div>';
		break;
		case 12:
			$divmap .= '<div id="GMMapWrapper" '.$divwrapmapstyle.' class="zhgm-wrap-'.$markerlistcssstyle.'">';
			$divmap .='<div id="GMapsMarkerList" class="zhgm-list-'.$markerlistcssstyle.'" style="'.$markerlistAddStyle.' display: none; float: left; padding: 0; margin: 5px; width:'.$divMarkerlistWidth.'; height:'.$divMarkerlistHeight.';">'.$markerlisttag.'</div>';
		break;
		case 111:
			if ($fullWidth == 1) 
			{
				$divmap .= '<table id="GMMapTable" class="zhgm-table-'.$markerlistcssstyle.'" style="width:100%;" >';
			}
			else
			{
				$divmap .= '<table id="GMMapTable" class="zhgm-table-'.$markerlistcssstyle.'" >';
			}
			$divmap .= '<tbody>';
			$divmap .= '<tr>';
			$divmap .= '<td style="width:'.$divMarkerlistWidth.'">';
			$divmap .='<div id="GMapsMarkerList" class="zhgm-list-'.$markerlistcssstyle.'" style="'.$markerlistAddStyle.' float: left; padding: 0; margin: 0 10px 0 0; width:'.$divMarkerlistWidth.'; height:'.$divMarkerlistHeight.';">'.$markerlisttag.'</div>';
			$divmap .= '</td>';
			$divmap .= '<td>';
		break;
		case 112:
			if ($fullWidth == 1) 
			{
				$divmap .= '<table id="GMMapTable" class="zhgm-table-'.$markerlistcssstyle.'" style="width:100%;" >';
			}
			else
			{
				$divmap .= '<table id="GMMapTable" class="zhgm-table-'.$markerlistcssstyle.'" >';
			}
			$divmap .= '<tbody>';
			$divmap .= '<tr>';
			$divmap .= '<td>';
		break;
		case 113:
			$divmap .= '<div id="GMMapWrapper" '.$divwrapmapstyle.' class="zhgm-wrap-'.$markerlistcssstyle.'" >';
			$divmap .='<div id="GMapsMarkerList" class="zhgm-list-'.$markerlistcssstyle.'" style="'.$markerlistAddStyle.' display: none; float: left; padding: 0; margin: 0; width:'.$divMarkerlistWidth.'; height:'.$divMarkerlistHeight.';">'.$markerlisttag.'</div>';
		break;
		case 114:
			$divmap .= '<div id="GMMapWrapper" '.$divwrapmapstyle.' class="zhgm-wrap-'.$markerlistcssstyle.'" >';
		break;
		case 121:
		break;
		default:
		break;
	}

	
}

$mapDivCSSClassName = "";
$mapSVDivCSSClassName = "";

if (isset($map->cssclassname) && ($map->cssclassname != ""))
{
	$mapDivCSSClassName = ' class="'.$map->cssclassname . $cssClassSuffix . '"';
	$mapSVDivCSSClassName = ' class="'.$map->cssclassname.'-streetview'. $cssClassSuffix . '"';
}
else
{
	$mapDivCSSClassName = ' class="'. $cssClassSuffix . '"';
	$mapSVDivCSSClassName = ' class="'.'-streetview'. $cssClassSuffix . '"';
}


if ($fullWidth == 1) 
{
	if ($fullHeight == 1) 
	{
		if (isset($map->streetview))
		{
			switch ((int)$map->streetview) 
			{
				case 2:
					$divmap .= '<div id="GMapStreetView" '.$mapSVDivCSSClassName.' style="margin:0;padding:0;width:100%;height:30%;"></div>';
					$divmap .= '<div id="GMapsID" '.$mapDivCSSClassName.' style="margin:0;padding:0;width:100%;height:70%;"></div>';
				break;
				case 3:
					$divmap .= '<div id="GMapsID" '.$mapDivCSSClassName.' style="margin:0;padding:0;width:100%;height:70%;"></div>';
					$divmap .= '<div id="GMapStreetView" '.$mapSVDivCSSClassName.' style="margin:0;padding:0;width:100%;height:30%;"></div>';
				break;
				default:
					$divmap .= '<div id="GMapsID" '.$mapDivCSSClassName.' style="margin:0;padding:0;width:100%;height:100%;"></div>';
				break;
			}
		}
		else
		{
			$divmap .= '<div id="GMapsID" '.$mapDivCSSClassName.' style="margin:0;padding:0;width:100%;height:100%;"></div>';
		}
		
	}
	else
	{
		if (isset($map->streetview))
		{
			switch ((int)$map->streetview) 
			{
				case 2:
					$divmap .= '<div id="GMapStreetView" '.$mapSVDivCSSClassName.' style="margin:0;padding:0;width:100%;height:'.(int)($map->height / 2).'px;"></div>';
					$divmap .= '<div id="GMapsID" '.$mapDivCSSClassName.' style="margin:0;padding:0;width:100%;height:'.$map->height.'px;"></div>';
				break;
				case 3:
					$divmap .= '<div id="GMapsID" '.$mapDivCSSClassName.' style="margin:0;padding:0;width:100%;height:'.$map->height.'px;"></div>';
					$divmap .= '<div id="GMapStreetView" '.$mapSVDivCSSClassName.' style="margin:0;padding:0;width:100%;height:'.(int)($map->height / 2).'px;"></div>';
				break;
				default:
					$divmap .= '<div id="GMapsID" '.$mapDivCSSClassName.' style="margin:0;padding:0;width:100%;height:'.$map->height.'px;"></div>';
				break;
			}
		}
		else
		{
			$divmap .= '<div id="GMapsID" '.$mapDivCSSClassName.' style="margin:0;padding:0;width:100%;height:'.$map->height.'px;"></div>';
		}

	}		
}
else
{
	if ($fullHeight == 1) 
	{
		if (isset($map->streetview))
		{
			switch ((int)$map->streetview) 
			{
				case 2:
					$divmap .= '<div id="GMapStreetView" '.$mapSVDivCSSClassName.' style="margin:0;padding:0;width:'.$map->width.'px;height:30%;"></div>';			
					$divmap .= '<div id="GMapsID" '.$mapDivCSSClassName.' style="margin:0;padding:0;width:'.$map->width.'px;height:70%;"></div>';			
				break;
				case 3:
					$divmap .= '<div id="GMapsID" '.$mapDivCSSClassName.' style="margin:0;padding:0;width:'.$map->width.'px;height:70%;"></div>';			
					$divmap .= '<div id="GMapStreetView" '.$mapSVDivCSSClassName.' style="margin:0;padding:0;width:'.$map->width.'px;height:30%;"></div>';			
				break;
				default:
					$divmap .= '<div id="GMapsID" '.$mapDivCSSClassName.' style="margin:0;padding:0;width:'.$map->width.'px;height:100%;"></div>';			
				break;
			}
		}
		else
		{
			$divmap .= '<div id="GMapsID" '.$mapDivCSSClassName.' style="margin:0;padding:0;width:'.$map->width.'px;height:100%;"></div>';			
		}

	}
	else
	{
		if (isset($map->streetview))
		{
			switch ((int)$map->streetview) 
			{
				case 2:
					$divmap .= '<div id="GMapStreetView" '.$mapSVDivCSSClassName.' style="margin:0;padding:0;width:'.$map->width.'px;height:'.(int)($map->height / 2).'px;"></div>';			
					$divmap .= '<div id="GMapsID" '.$mapDivCSSClassName.' style="margin:0;padding:0;width:'.$map->width.'px;height:'.$map->height.'px;"></div>';			
				break;
				case 3:
					$divmap .= '<div id="GMapsID" '.$mapDivCSSClassName.' style="margin:0;padding:0;width:'.$map->width.'px;height:'.$map->height.'px;"></div>';			
					$divmap .= '<div id="GMapStreetView" '.$mapSVDivCSSClassName.' style="margin:0;padding:0;width:'.$map->width.'px;height:'.(int)($map->height / 2).'px;"></div>';			
				break;
				default:
					$divmap .= '<div id="GMapsID" '.$mapDivCSSClassName.' style="margin:0;padding:0;width:'.$map->width.'px;height:'.$map->height.'px;"></div>';			
				break;
			}
		}
		else
		{
			$divmap .= '<div id="GMapsID" '.$mapDivCSSClassName.' style="margin:0;padding:0;width:'.$map->width.'px;height:'.$map->height.'px;"></div>';			
		}

	}		
}

// adding markerlist (close div)
if (isset($map->markerlistpos) && (int)$map->markerlistpos != 0) 
{
	
	switch ((int)$map->markerlistpos) 
	{
		case 0:
			// None
		break;
		case 1:
			$divmap .='</div>';
		break;
		case 2:
			$divmap .='</div>';
		break;
		case 3:
			$divmap .='</div>';
		break;
		case 4:
			$divmap .='</div>';
		break;
		case 5:
			$divmap .='</div>';
		break;
		case 6:
			$divmap .='</div>';
		break;
		case 7:
			$divmap .='</div>';
		break;
		case 8:
			$divmap .='</div>';
		break;
		case 9:
			$divmap .='</div>';
		break;
		case 10:
			$divmap .='</div>';
		break;
		case 11:
			$divmap .='</div>';
		break;
		case 12:
			$divmap .='</div>';
		break;
		case 111:
			$divmap .= '</td>';
			$divmap .= '</tr>';
			$divmap .= '</tbody>';
			$divmap .='</table>';
		break;
		case 112:
			$divmap .= '</td>';
			$divmap .= '<td style="width:'.$divMarkerlistWidth.'">';
			$divmap .='<div id="GMapsMarkerList" class="zhgm-list-'.$markerlistcssstyle.'" style="'.$markerlistAddStyle.' float: left; padding: 0; margin: 0 0 0 10px; width:'.$divMarkerlistWidth.'; height:'.$divMarkerlistHeight.';">'.$markerlisttag.'</div>';
			$divmap .= '</td>';
			$divmap .= '</tr>';
			$divmap .= '</tbody>';
			$divmap .='</table>';
		break;
		case 113:
			$divmap .='</div>';
		break;
		case 114:
			$divmap .='<div id="GMapsMarkerList" class="zhgm-list-'.$markerlistcssstyle.'" style="'.$markerlistAddStyle.' display: none; float: left; padding: 0; margin: 0; width:'.$divMarkerlistWidth.'; height:'.$divMarkerlistHeight.';">'.$markerlisttag.'</div>';
			$divmap .='</div>';
		break;
		case 121:
		break;
		default:
		break;
	}


}


$divmap .= '<div id="GMapsCredit" class="zhgm-credit"></div>';

$divmap .= '<div id="GMapsLoading" style="display: none;" ><img class="zhgm-image-loading" src="'.$imgpathUtils.'loading.gif" alt="" /></div>';

echo $divmapheader . $currentUserInfo;

// adding route panel in any case
$divmap4route = '<div id="GMapsMainRoutePanel"><div id="GMapsMainRoutePanel_Total"></div></div>';
$divmap4route .= '<div id="GMapsRoutePanel"><div id="GMapsRoutePanel_Description"></div><div id="GMapsRoutePanel_Total"></div></div>';

if ($featurePathElevation == 1)
{
	$divmap4route .= '<div id="GMapsPathPanel" onmouseout="clearMarkerElevation(); return false;"></div>';
}

// adding before and after sections
$divmap = $divmapbefore . $divmap . $divmapafter;


if (isset($map->markergroupcontrol) && (int)$map->markergroupcontrol != 0) 
{
	switch ((int)$map->markergroupcontrol) 
	{
		
		case 1:
		       if ($fullWidth == 1) 
		       {
		          echo '<table class="zhgm-group-manage" '.$divwrapmapstyle.'>';
		          echo '<tr align="left" >';
				  if ((int)$map->markergroupwidth != 0)
				  {
					  echo '<td valign="top" width="'.(int)$map->markergroupwidth.'%">';
				  }
				  else
				  {
					  echo '<td valign="top" width="20%">';
				  }
       	          echo $divmarkergroup;
		          echo '</td>';
		          echo '<td '.$divtabcolmapstyle.'>';
		          echo $divmap;
		          echo '</td>';
		          echo '</tr>';
		       }
		       else
		       {
		          echo '<table class="zhgm-group-manage" '.$divwrapmapstyle.'>';
                  echo '<tr>';
		          echo '<td valign="top">';
        	      echo $divmarkergroup;
		          echo '</td>';
		          echo '<td '.$divtabcolmapstyle.'>';
		          echo $divmap;
		          echo '</td>';
		          echo '</tr>';
                       }
		       echo '</table>';
		break;
		case 2:
		       if ($fullWidth == 1) 
		       {
		          echo '<table class="zhgm-group-manage" '.$divwrapmapstyle.'>';
		       }
		       else
		       {
		          echo '<table class="zhgm-group-manage" '.$divwrapmapstyle.'>';
		       }
		       echo '<tr>';
		       echo '<td valign="top">';
		       echo $divmarkergroup;
		       echo '</td>';
		       echo '</tr>';
		       echo '<tr>';
		       echo '<td '.$divtabcolmapstyle.'>';
		       echo $divmap;
		       echo '</td>';
		       echo '</tr>';
		       echo '</table>';

		break;
		case 3:
		       if ($fullWidth == 1) 
		       {
		          echo '<table class="zhgm-group-manage" '.$divwrapmapstyle.'>';
		          echo '<tr>';
		          echo '<td '.$divtabcolmapstyle.'>';
		          echo $divmap;
		          echo '</td>';
				  if ((int)$map->markergroupwidth != 0)
				  {
					  echo '<td valign="top" width="'.(int)$map->markergroupwidth.'%">';
				  }
				  else
				  {
					  echo '<td valign="top" width="20%">';
				  }
		          echo $divmarkergroup;
		          echo '</td>';
		          echo '</tr>';
		       }
		       else
		       {
		          echo '<table class="zhgm-group-manage" '.$divwrapmapstyle.'>';
		          echo '<tr>';
		          echo '<td '.$divtabcolmapstyle.'>';
		          echo $divmap;
		          echo '</td>';
		          echo '<td valign="top">';
		          echo $divmarkergroup;
		          echo '</td>';
		          echo '</tr>';
		       }
		       echo '</table>';

		break;
		case 4:
		       if ($fullWidth == 1) 
		       {
		          echo '<table class="zhgm-group-manage" '.$divwrapmapstyle.'>';
		       }
		       else
		       {
		          echo '<table class="zhgm-group-manage" '.$divwrapmapstyle.'>';
		       }
		       echo '<tr>';
		       echo '<td '.$divtabcolmapstyle.'>';
		       echo $divmap;
		       echo '</td>';
		       echo '</tr>';
		       echo '<tr>';
		       echo '<td valign="top">';
		       echo $divmarkergroup;
		       echo '</td>';
		       echo '</tr>';
		       echo '</table>';
		break;
		case 5:
		       echo '<div id="zhgm-wrapper" '.$divwrapmapstyle.'>';
		       echo $divmarkergroup;
		       echo $divmap;
		       echo '</div>';
		break;
		case 6:
		       echo '<div id="zhgm-wrapper" '.$divwrapmapstyle.'>';
		       echo $divmap;
		       echo $divmarkergroup;
		       echo '</div>';
		break;
		default:
			echo $divmap;
		break;
	}


}
else
{
    echo $divmap;
}


echo $divmapfooter. $divmap4route;


$scripttext = '';



//Script begin
$scripttext .= '<script type="text/javascript" >/*<![CDATA[*/' ."\n";


	// Global variable scope (for access from all functions)
	$scripttext .= 'var map, infowindow;' ."\n";
	$scripttext .= 'var latlng, routeaddress;' ."\n";
	$scripttext .= 'var routedestination, routedirection;' ."\n";

    if (isset($map->earth) && (int)$map->earth != 0 && $apikey4earth != "")
	{
        	//$scripttext .= 'alert("Before load Earth");';

			if ($mainLang != "")
			{
				$scripttext .= 'google.load("earth", "1", { \'language\': \''.$mainLang.'\' });'."\n";
			}
			else
			{
				$scripttext .= 'google.load("earth", "1");'."\n";
			}
			
        	//$scripttext .= 'alert("After load Earth");';

			$scripttext .= 'var googleEarth, isGEinstalled;' ."\n";
		
	}

	// Load the Visualization API and the columnchart package.
	if ($featurePathElevation == 1)
	{
		$scripttext .= 'google.load("visualization", "1", {packages: ["corechart"]});'."\n";
	}
	
	// Elevation feature
	if ((isset($map->elevation) && (int)$map->elevation == 1)
	  || $featurePathElevation == 1)
    {	
		$scripttext .= 'var elevator;' ."\n";
		$scripttext .= 'var markerElevation;' ."\n";
	}

    // MarkerGroups
    if (
	     ((isset($map->markercluster) && (int)$map->markercluster == 1))
	     ||
	     ((isset($map->markerclustergroup) && (int)$map->markerclustergroup == 1))
	     ||
	     (isset($map->markergroupcontrol) && (int)$map->markergroupcontrol != 0) 
	   )
	{
	   $scripttext .= 'var clustermarkers0 = [];' ."\n";
	   $scripttext .= 'var markerCluster0;' ."\n";

	   if (isset($markergroups) && !empty($markergroups)) 
	   {
			foreach ($markergroups as $key => $currentmarkergroup) 
			{
				$scripttext .= 'var clustermarkers'.$currentmarkergroup->id.' = [];' ."\n";
				$scripttext .= 'var markerCluster'.$currentmarkergroup->id.';' ."\n";
			}
	   }
    }
 
 	$scripttext .= 'var icoIcon=\''.$imgpathIcons.'\';'."\n";
	$scripttext .= 'var icoUtils=\''.$imgpathUtils.'\';'."\n";
	$scripttext .= 'var icoDir=\''.$directoryIcons.'\';'."\n";

	if (isset($map->useajax) && (int)$map->useajax == 1)
	{
		$scripttext .= 'var ajaxmarkersLL = [];' ."\n";
		$scripttext .= 'var ajaxmarkersADR = [];' ."\n";
	}

	$scripttext .= 'var infobubblemarkers = [];' ."\n";
        
    $scripttext .= 'function initializeGMmod() {' ."\n";

	$scripttext .= 'latlng = new google.maps.LatLng('.$map->latitude.', ' .$map->longitude.');' ."\n";

	$scripttext .= 'routeaddress = "'.$map->routeaddress.'";' ."\n";

	if (isset($map->routeaddress) && $map->routeaddress != "")
	{
		$scripttext .= 'routedestination = routeaddress;'."\n";
	}
	else
	{
		$scripttext .= 'routedestination = latlng;'."\n";
	}
	
	$scripttext .= 'routedirection = 1;'."\n";

	$scripttext .= 'var myOptions = {' ."\n";

	$scripttext .= '    center: latlng,' ."\n";

	$scripttext .= '    zoom: '.$map->zoom.',' ."\n";

	if (isset($map->minzoom) && (int)$map->minzoom != 0)
	{
		$scripttext .= '  minZoom: '.(int)$map->minzoom.',' ."\n";
	}
	if (isset($map->maxzoom) && (int)$map->maxzoom != 0)
	{
		$scripttext .= '  maxZoom: '.(int)$map->maxzoom.',' ."\n";
	}
	if (isset($map->draggable) && (int)$map->draggable == 0)
	{
		$scripttext .= '  draggable: false ,' ."\n";
	}
	else
	{
		$scripttext .= '  draggable: true ,' ."\n";
	}

	
	// Map type
	if (isset($map->maptype)) 
	{
		switch ($map->maptype) 
		{
			
			case 1:
				$scripttext .= 'mapTypeId: google.maps.MapTypeId.ROADMAP,' ."\n";
			break;
			case 2:
				$scripttext .= 'mapTypeId: google.maps.MapTypeId.SATELLITE,' ."\n";
			break;
			case 3:
				$scripttext .= 'mapTypeId: google.maps.MapTypeId.HYBRID,' ."\n";
			break;
			case 4:
				$scripttext .= 'mapTypeId: google.maps.MapTypeId.TERRAIN,' ."\n";
			break;
			case 5: 
				// set it later (OSM)
				$scripttext .= 'mapTypeId: google.maps.MapTypeId.ROADMAP,' ."\n";
			break;
			case 6: 
				// set it later (NZ Topomaps)
				$scripttext .= 'mapTypeId: google.maps.MapTypeId.ROADMAP,' ."\n";
			break;
			case 7: 
				// set it later (First custom map type)
				$scripttext .= 'mapTypeId: google.maps.MapTypeId.ROADMAP,' ."\n";
			break;
			default:
				$scripttext .= '' ."\n";
			break;
		}
	}

	//Zoom Control
	if (isset($map->zoomcontrol) && (int)$map->zoomcontrol != 0)
	{
		$scripttext .= 'zoomControl: true,' ."\n";
		$scripttext .= '      zoomControlOptions: {' ."\n";
		if (isset($map->poszoom)) 
		{
			switch ($map->poszoom) 
			{
				case 0:
				break;
				case 1:
       					$scripttext .= 'position: google.maps.ControlPosition.TOP_CENTER ,' ."\n";
				break;
				case 2:
       					$scripttext .= 'position: google.maps.ControlPosition.TOP_LEFT ,' ."\n";
				break;
				case 3:
       					$scripttext .= 'position: google.maps.ControlPosition.TOP_RIGHT ,' ."\n";
				break;
				case 4:
       					$scripttext .= 'position: google.maps.ControlPosition.LEFT_TOP ,' ."\n";
				break;
				case 5:
       					$scripttext .= 'position: google.maps.ControlPosition.RIGHT_TOP ,' ."\n";
				break;
				case 6:
	       				$scripttext .= 'position: google.maps.ControlPosition.LEFT_CENTER ,' ."\n";
				break;
				case 7:
       					$scripttext .= 'position: google.maps.ControlPosition.RIGHT_CENTER ,' ."\n";
				break;
				case 8:
       					$scripttext .= 'position: google.maps.ControlPosition.LEFT_BOTTOM ,' ."\n";
				break;
				case 9:
       					$scripttext .= 'position: google.maps.ControlPosition.RIGHT_BOTTOM ,' ."\n";
				break;
				case 10:
       					$scripttext .= 'position: google.maps.ControlPosition.BOTTOM_CENTER ,' ."\n";
				break;
				case 11:
       					$scripttext .= 'position: google.maps.ControlPosition.BOTTOM_LEFT ,' ."\n";
				break;
				case 12:
       					$scripttext .= 'position: google.maps.ControlPosition.BOTTOM_RIGHT ,' ."\n";
				break;
				default:
					$scripttext .= '' ."\n";
				break;
			}
		}

		if ((int)$map->zoomcontrol == 1)
		{
			$scripttext .= '            style: google.maps.ZoomControlStyle.SMALL' ."\n";
		}
		else if ((int)$map->zoomcontrol == 2)
		{
			$scripttext .= '            style: google.maps.ZoomControlStyle.LARGE' ."\n";
		}
		else if ((int)$map->zoomcontrol == 3)
		{
			$scripttext .= '            style: google.maps.ZoomControlStyle.DEFAULT' ."\n";
		}
		else 
		{
			$scripttext .= '            style: google.maps.ZoomControlStyle.DEFAULT' ."\n";
		}
		$scripttext .= '          },' ."\n";
	} else 
	{
		$scripttext .= 'zoomControl: false,' ."\n";
	}


	// Map type Control
	if (isset($map->maptypecontrol) && (int)$map->maptypecontrol != 0) 
	{
		$scripttext .= 'mapTypeControl: true,' ."\n";
		$scripttext .= 'mapTypeControlOptions: {' ."\n";
		$scripttext .= '	mapTypeIds: [' ."\n";
		$scripttext .= '	  google.maps.MapTypeId.ROADMAP,' ."\n";
		$scripttext .= '	  google.maps.MapTypeId.TERRAIN,' ."\n";
		$scripttext .= '	  google.maps.MapTypeId.SATELLITE,' ."\n";
		$scripttext .= '	  google.maps.MapTypeId.HYBRID' ."\n";
		// Add Predefined MapTypes		
		// OSM
		if ((int)$map->openstreet == 1)
		{
			$scripttext .= '	  ,\'osm\'' ."\n";
		}
		// NZ Topomaps
		if ((int)$map->nztopomaps != 0)
		{
			if ((int)$map->nztopomaps == 1)
			{
			}
			else
			{
				$scripttext .= '	  ,\'nztopomaps\'' ."\n";
			}
		}
		// Add Custom MapTypes - Begin
		if ((int)$map->custommaptype == 1)
		{
			foreach ($maptypes as $key => $currentmaptype) 
			{
				for ($i=0; $i < count($custMapTypeList); $i++)
				{
					if ($currentmaptype->id == (int)$custMapTypeList[$i])
					{
						if ((int)$currentmaptype->layertype == 1)
						{
						}
						else
						{
							$scripttext .= '	  ,\'customMapType'.$currentmaptype->id.'\'' ."\n";
						}
					}
				}
				// End loop by Enabled CustomMapTypes
				
			}
			// End loop by All CustomMapTypes
			
		}
		// Add Custom MapTypes - End
		// Earth
		//if (isset($map->earth) && (int)$map->earth != 0 && $apikey4earth != "")
		//{
		//	$scripttext .= '	  , GoogleEarth.MAP_TYPE_ID' ."\n";
		//}	
		
		
		$scripttext .= '	],' ."\n";
		if (isset($map->posmaptype)) 
		{
			switch ($map->posmaptype) 
			{
				case 0:
				break;
				case 1:
       					$scripttext .= 'position: google.maps.ControlPosition.TOP_CENTER ,' ."\n";
				break;
				case 2:
	       				$scripttext .= 'position: google.maps.ControlPosition.TOP_LEFT ,' ."\n";
				break;
				case 3:
       					$scripttext .= 'position: google.maps.ControlPosition.TOP_RIGHT ,' ."\n";
				break;
				case 4:
       					$scripttext .= 'position: google.maps.ControlPosition.LEFT_TOP ,' ."\n";
				break;
				case 5:
       					$scripttext .= 'position: google.maps.ControlPosition.RIGHT_TOP ,' ."\n";
				break;
				case 6:
	       				$scripttext .= 'position: google.maps.ControlPosition.LEFT_CENTER ,' ."\n";
				break;
				case 7:
       					$scripttext .= 'position: google.maps.ControlPosition.RIGHT_CENTER ,' ."\n";
				break;
				case 8:
       					$scripttext .= 'position: google.maps.ControlPosition.LEFT_BOTTOM ,' ."\n";
				break;
				case 9:
       					$scripttext .= 'position: google.maps.ControlPosition.RIGHT_BOTTOM ,' ."\n";
				break;
				case 10:
	       				$scripttext .= 'position: google.maps.ControlPosition.BOTTOM_CENTER ,' ."\n";
				break;
				case 11:
       					$scripttext .= 'position: google.maps.ControlPosition.BOTTOM_LEFT ,' ."\n";
				break;
				case 12:
       					$scripttext .= 'position: google.maps.ControlPosition.BOTTOM_RIGHT ,' ."\n";
				break;
				default:
					$scripttext .= '' ."\n";
				break;
			}
		}

		if ((int)$map->maptypecontrol == 1)
		{
			$scripttext .= '            style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR' ."\n";
		}
		else if ((int)$map->maptypecontrol == 2)
		{
			$scripttext .= '            style: google.maps.MapTypeControlStyle.DROPDOWN_MENU' ."\n";
		}
		else if ((int)$map->maptypecontrol == 3)
		{
			$scripttext .= '            style: google.maps.MapTypeControlStyle.DEFAULT' ."\n";
		}
		else 
		{
			$scripttext .= '            style: google.maps.MapTypeControlStyle.DEFAULT' ."\n";
		}


		$scripttext .= '          },' ."\n";
	} else {
		$scripttext .= 'mapTypeControl: false,' ."\n";
	}

	//Double Click Zoom
	if (isset($map->doubleclickzoom) && (int)$map->doubleclickzoom == 0) 
	{
		$scripttext .= 'disableDoubleClickZoom: true,' ."\n";
	} 
	else 
	{
		$scripttext .= 'disableDoubleClickZoom: false,' ."\n";
	}

	//Scroll Wheel Zoom		
	if (isset($map->scrollwheelzoom) && (int)$map->scrollwheelzoom == 1) 
	{
		$scripttext .= 'scrollwheel: true,' ."\n";
	} 
	else 
	{
		$scripttext .= 'scrollwheel: false,' ."\n";
	}

	
	// Pan Control
	if (isset($map->pancontrol) && (int)$map->pancontrol == 1) 
	{
		$scripttext .= 'panControl: true,' ."\n";
 			if (isset($map->pospan)) 
			{
				switch ($map->pospan) 
				{
				case 0:
				break;
				case 1:
					$scripttext .= 'panControlOptions: {' ."\n";
        				$scripttext .= 'position: google.maps.ControlPosition.TOP_CENTER },' ."\n";
				break;
				case 2:
					$scripttext .= 'panControlOptions: {' ."\n";
        				$scripttext .= 'position: google.maps.ControlPosition.TOP_LEFT },' ."\n";
				break;
				case 3:
					$scripttext .= 'panControlOptions: {' ."\n";
        				$scripttext .= 'position: google.maps.ControlPosition.TOP_RIGHT },' ."\n";
				break;
				case 4:
					$scripttext .= 'panControlOptions: {' ."\n";
        				$scripttext .= 'position: google.maps.ControlPosition.LEFT_TOP },' ."\n";
				break;
				case 5:
					$scripttext .= 'panControlOptions: {' ."\n";
        				$scripttext .= 'position: google.maps.ControlPosition.RIGHT_TOP },' ."\n";
				break;
				case 6:
					$scripttext .= 'panControlOptions: {' ."\n";
        				$scripttext .= 'position: google.maps.ControlPosition.LEFT_CENTER },' ."\n";
				break;
				case 7:
					$scripttext .= 'panControlOptions: {' ."\n";
        				$scripttext .= 'position: google.maps.ControlPosition.RIGHT_CENTER },' ."\n";
				break;
				case 8:
					$scripttext .= 'panControlOptions: {' ."\n";
        				$scripttext .= 'position: google.maps.ControlPosition.LEFT_BOTTOM },' ."\n";
				break;
				case 9:
					$scripttext .= 'panControlOptions: {' ."\n";
        				$scripttext .= 'position: google.maps.ControlPosition.RIGHT_BOTTOM },' ."\n";
				break;
				case 10:
					$scripttext .= 'panControlOptions: {' ."\n";
        				$scripttext .= 'position: google.maps.ControlPosition.BOTTOM_CENTER },' ."\n";
				break;
				case 11:
					$scripttext .= 'panControlOptions: {' ."\n";
        				$scripttext .= 'position: google.maps.ControlPosition.BOTTOM_LEFT },' ."\n";
				break;
				case 12:
					$scripttext .= 'panControlOptions: {' ."\n";
        				$scripttext .= 'position: google.maps.ControlPosition.BOTTOM_RIGHT },' ."\n";
				break;
				default:
					$scripttext .= '' ."\n";
				break;
				}
			}
	} 
	else 
	{
		$scripttext .= 'panControl: false,' ."\n";
	}

	//Scale Control
	if (isset($map->scalecontrol) && (int)$map->scalecontrol == 1) 
	{
		$scripttext .= 'scaleControl: true,' ."\n";
		if (isset($map->posscale)) 
		{
			switch ($map->posscale) 
			{
			case 0:
			break;
			case 1:
				$scripttext .= 'scaleControlOptions: {' ."\n";
					$scripttext .= 'position: google.maps.ControlPosition.TOP_CENTER },' ."\n";
			break;
			case 2:
				$scripttext .= 'scaleControlOptions: {' ."\n";
					$scripttext .= 'position: google.maps.ControlPosition.TOP_LEFT },' ."\n";
			break;
			case 3:
				$scripttext .= 'scaleControlOptions: {' ."\n";
					$scripttext .= 'position: google.maps.ControlPosition.TOP_RIGHT },' ."\n";
			break;
			case 4:
				$scripttext .= 'scaleControlOptions: {' ."\n";
					$scripttext .= 'position: google.maps.ControlPosition.LEFT_TOP },' ."\n";
			break;
			case 5:
				$scripttext .= 'scaleControlOptions: {' ."\n";
					$scripttext .= 'position: google.maps.ControlPosition.RIGHT_TOP },' ."\n";
			break;
			case 6:
				$scripttext .= 'scaleControlOptions: {' ."\n";
					$scripttext .= 'position: google.maps.ControlPosition.LEFT_CENTER },' ."\n";
			break;
			case 7:
				$scripttext .= 'scaleControlOptions: {' ."\n";
					$scripttext .= 'position: google.maps.ControlPosition.RIGHT_CENTER },' ."\n";
			break;
			case 8:
				$scripttext .= 'scaleControlOptions: {' ."\n";
					$scripttext .= 'position: google.maps.ControlPosition.LEFT_BOTTOM },' ."\n";
			break;
			case 9:
				$scripttext .= 'scaleControlOptions: {' ."\n";
					$scripttext .= 'position: google.maps.ControlPosition.RIGHT_BOTTOM },' ."\n";
			break;
			case 10:
				$scripttext .= 'scaleControlOptions: {' ."\n";
					$scripttext .= 'position: google.maps.ControlPosition.BOTTOM_CENTER },' ."\n";
			break;
			case 11:
				$scripttext .= 'scaleControlOptions: {' ."\n";
					$scripttext .= 'position: google.maps.ControlPosition.BOTTOM_LEFT },' ."\n";
			break;
			case 12:
				$scripttext .= 'scaleControlOptions: {' ."\n";
					$scripttext .= 'position: google.maps.ControlPosition.BOTTOM_RIGHT },' ."\n";
			break;
			default:
				$scripttext .= '' ."\n";
			break;
			}
		}
	} 
	else 
	{
		$scripttext .= 'scaleControl: false,' ."\n";
	}


	if (isset($map->overviewmapcontrol) && (int)$map->overviewmapcontrol != 0) 
	{
		$scripttext .= 'overviewMapControl: true,' ."\n";
		if ((int)$map->overviewmapcontrol == 1)
		{
			$scripttext .= 'overviewMapControlOptions: { opened: false },' ."\n";			
		}
		else if ((int)$map->overviewmapcontrol == 2)
		{
			$scripttext .= 'overviewMapControlOptions: { opened: true },' ."\n";			
		}
	} 
	else 
	{
		$scripttext .= 'overviewMapControl: false,' ."\n";
	}

	if (
			(isset($map->streetviewcontrol) && (int)$map->streetviewcontrol == 1) 
		||
			(isset($map->streetview) && (int)$map->streetview != 0)
		)
	{
		$scripttext .= 'streetViewControl: true,' ."\n";
		if (isset($map->posstreet)) 
		{
			switch ($map->posstreet) 
			{
			case 0:
			break;
			case 1:
				$scripttext .= 'streetViewControlOptions: {' ."\n";
					$scripttext .= 'position: google.maps.ControlPosition.TOP_CENTER },' ."\n";
			break;
			case 2:
				$scripttext .= 'streetViewControlOptions: {' ."\n";
					$scripttext .= 'position: google.maps.ControlPosition.TOP_LEFT },' ."\n";
			break;
			case 3:
				$scripttext .= 'streetViewControlOptions: {' ."\n";
					$scripttext .= 'position: google.maps.ControlPosition.TOP_RIGHT },' ."\n";
			break;
			case 4:
				$scripttext .= 'streetViewControlOptions: {' ."\n";
					$scripttext .= 'position: google.maps.ControlPosition.LEFT_TOP },' ."\n";
			break;
			case 5:
				$scripttext .= 'streetViewControlOptions: {' ."\n";
					$scripttext .= 'position: google.maps.ControlPosition.RIGHT_TOP },' ."\n";
			break;
			case 6:
				$scripttext .= 'streetViewControlOptions: {' ."\n";
					$scripttext .= 'position: google.maps.ControlPosition.LEFT_CENTER },' ."\n";
			break;
			case 7:
				$scripttext .= 'streetViewControlOptions: {' ."\n";
					$scripttext .= 'position: google.maps.ControlPosition.RIGHT_CENTER },' ."\n";
			break;
			case 8:
				$scripttext .= 'streetViewControlOptions: {' ."\n";
					$scripttext .= 'position: google.maps.ControlPosition.LEFT_BOTTOM },' ."\n";
			break;
			case 9:
				$scripttext .= 'streetViewControlOptions: {' ."\n";
					$scripttext .= 'position: google.maps.ControlPosition.RIGHT_BOTTOM },' ."\n";
			break;
			case 10:
				$scripttext .= 'streetViewControlOptions: {' ."\n";
					$scripttext .= 'position: google.maps.ControlPosition.BOTTOM_CENTER },' ."\n";
			break;
			case 11:
				$scripttext .= 'streetViewControlOptions: {' ."\n";
					$scripttext .= 'position: google.maps.ControlPosition.BOTTOM_LEFT },' ."\n";
			break;
			case 12:
				$scripttext .= 'streetViewControlOptions: {' ."\n";
					$scripttext .= 'position: google.maps.ControlPosition.BOTTOM_RIGHT },' ."\n";
			break;
			default:
				$scripttext .= '' ."\n";
			break;
			}
		}
	} 
	else 
	{
		$scripttext .= 'streetViewControl: false,' ."\n";
	}


	if (isset($map->rotatecontrol) && (int)$map->rotatecontrol == 1) 
	{
		$scripttext .= 'rotateControl: true' ."\n";
	} 
	else 
	{
		$scripttext .= 'rotateControl: false' ."\n";
	}


	//end of options
	$scripttext .= '};' ."\n";
		

    if (isset($map->openstreet) && (int)$map->openstreet == 1)
	{
	
        $scripttext .= ' var openStreetType = new google.maps.ImageMapType({' ."\n";
		$scripttext .= '  getTileUrl: function(ll, z) {' ."\n";
		$scripttext .= '	var X = ll.x % (1 << z);  /* wrap */' ."\n";
		$scripttext .= '	return "http://tile.openstreetmap.org/" + z + "/" + X + "/" + ll.y + ".png";' ."\n";
		$scripttext .= '  },' ."\n";
		$scripttext .= '  tileSize: new google.maps.Size(256, 256),' ."\n";
		$scripttext .= '  isPng: true,' ."\n";
		$scripttext .= '  maxZoom: 18,' ."\n";
		$scripttext .= '  name: "OSM",' ."\n";
		$scripttext .= '  alt: "'.JText::_('MOD_ZHGOOGLEMAP_MAP_OPENSTREETLAYER').'"' ."\n";
		$scripttext .= '}); ' ."\n";
		
	}


    if (isset($map->nztopomaps) && (int)$map->nztopomaps != 0)
	{
	
        $scripttext .= ' var NZTopomapsType = new google.maps.ImageMapType({' ."\n";
		$scripttext .= '  	getTileUrl: function(coord, zoom) {' ."\n";
		$scripttext .= '  		var mapBounds = new google.maps.LatLngBounds(' ."\n";
		$scripttext .= '  		new google.maps.LatLng(-47.5, 165.39),' ."\n";
		$scripttext .= '  		new google.maps.LatLng(-33.03, 179));' ."\n";
		$scripttext .= '  		var mapMinZoom = 5;' ."\n";
		$scripttext .= '  		var mapMaxZoom = 15;' ."\n";
		$scripttext .= '  		var proj = map.getProjection();' ."\n";
		$scripttext .= '  	    var tileSize = 256 / Math.pow(2,zoom);' ."\n";
		$scripttext .= '  	    var tileBounds = new google.maps.LatLngBounds(' ."\n";
        $scripttext .= '  	        proj.fromPointToLatLng(new google.maps.Point(coord.x*tileSize, (coord.y+1)*tileSize)),' ."\n";
		$scripttext .= '  	    	proj.fromPointToLatLng(new google.maps.Point((coord.x+1)*tileSize, coord.y*tileSize))' ."\n";
        $scripttext .= '  	    );' ."\n";
        $scripttext .= '  		if (mapBounds.intersects(tileBounds) && (zoom >= mapMinZoom) && (zoom <= mapMaxZoom))' ."\n";
		$scripttext .= '  		{' ."\n";	
		$scripttext .= '  			 return "http://nz1.nztopomaps.com/" + zoom + "/" + coord.x + "/" + (Math.pow(2,zoom)-coord.y-1) + ".png";' ."\n";
		$scripttext .= '  		}' ."\n";	
        $scripttext .= '  		else' ."\n";
		$scripttext .= '  		{' ."\n";	
		if ((int)$map->nztopomaps == 1)
		{
			//$scripttext .= '  	    	return "http://m.nztopomaps.com/noimage.png";' ."\n";
			$scripttext .= '  	    	return "";' ."\n";
		}
		else
		{
			$scripttext .= '  	    	return "http://m.nztopomaps.com/noimage.png";' ."\n";
		}
		$scripttext .= '  		}' ."\n";	
		$scripttext .= '  			},' ."\n";	
		$scripttext .= '  tileSize: new google.maps.Size(256, 256),' ."\n";
		$scripttext .= '  isPng: true,' ."\n";
		$scripttext .= '  minZoom: 5,' ."\n";
		$scripttext .= '  maxZoom: 15,' ."\n";
		$scripttext .= '  name: "NZTopo",' ."\n";
		$scripttext .= '  alt: "'.JText::_('MOD_ZHGOOGLEMAP_MAP_NZTOPOMAPSLAYER').'"' ."\n";
		$scripttext .= '}); ' ."\n";

		
	}
	
	if ((int)$map->custommaptype != 0)
	{
		foreach ($maptypes as $key => $currentmaptype) 	
		{
		
			for ($i=0; $i < count($custMapTypeList); $i++)
			{
				if ($currentmaptype->id == (int)$custMapTypeList[$i]
				&& $currentmaptype->gettileurl != "")
				{

					$scripttext .= ' var customMapType'.$currentmaptype->id.' = new google.maps.ImageMapType({' ."\n";
					$scripttext .= '  getTileUrl: '.$currentmaptype->gettileurl.',' ."\n";
					$scripttext .= '  tileSize: new google.maps.Size('.$currentmaptype->tilewidth.', '.$currentmaptype->tileheight.'),' ."\n";
					if ((int)$currentmaptype->ispng == 1)
					{
						$scripttext .= '  isPng: true,' ."\n";
					}
					else
					{
						$scripttext .= '  isPng: false,' ."\n";
					}
					if ((int)$currentmaptype->minzoom != 0)
					{
						$scripttext .= '  minZoom: '.(int)$currentmaptype->minzoom.',' ."\n";
					}
					if ((int)$currentmaptype->maxzoom != 0)
					{
						$scripttext .= '  maxZoom: '.(int)$currentmaptype->maxzoom.',' ."\n";
					}
					if ($currentmaptype->opacity != "")
					{
						$scripttext .= '  opacity: '.$currentmaptype->opacity.','."\n";
					}
					$scripttext .= '  name: "'.str_replace('"','', $currentmaptype->title).'",' ."\n";
					$scripttext .= '  alt: "'.str_replace('"','', $currentmaptype->description).'"' ."\n";
					$scripttext .= '}); ' ."\n";
					
					// Add projection
					if ($currentmaptype->fromlatlngtopoint != "" && $currentmaptype->frompointtolatlng != "")
					{
						$scripttext .= $currentmaptype->projectionglobal."\n";
						
						$scripttext .= ' function customMapTypeProjection'.$currentmaptype->id.'() {'."\n";
						$scripttext .= $currentmaptype->projectiondefinition."\n";
						$scripttext .= ' }'."\n";
						
						$scripttext .= ' customMapTypeProjection'.$currentmaptype->id.'.prototype.fromLatLngToPoint  = ';
						$scripttext .= $currentmaptype->fromlatlngtopoint."\n";
						$scripttext .= ';'."\n";

						$scripttext .= ' customMapTypeProjection'.$currentmaptype->id.'.prototype.fromPointToLatLng = ';
						$scripttext .= $currentmaptype->frompointtolatlng."\n";
						$scripttext .= ';'."\n";
						
						$scripttext .= ' customMapType'.$currentmaptype->id.'.projection  = new customMapTypeProjection'.$currentmaptype->id.'();' ."\n";
					}

				}
			}
			// End loop by Enabled CustomMapTypes
		
		}
		// End loop by All CustomMapTypes
		
	}

    $scripttext .= 'map = new google.maps.Map(document.getElementById("GMapsID"), myOptions);' ."\n";

	// Map is created

    $layerWeatherAndCloud = modZhGoogleMapPlacemarksHelper::get_WeatherCloudLayers($map->weathertypeid);
	
	if ($layerWeatherAndCloud != "")
	{
		$scripttext .= $layerWeatherAndCloud;
	}
	
	if (isset($map->mapbounds) && $map->mapbounds != "")
	{
		$mapBoundsArray = explode(";", str_replace(',',';',$map->mapbounds));
		if (count($mapBoundsArray) != 4)
		{
			$scripttext .= 'alert("'.JText::_('MOD_ZHGOOGLEMAP_MAP_ERROR_MAPBOUNDS').'");'."\n";
		}
		else
		{
			
			$scripttext .= '   var allowedBounds = new google.maps.LatLngBounds(' ."\n";
			$scripttext .= '	 new google.maps.LatLng('.$mapBoundsArray[0].', '.$mapBoundsArray[1].'), ' ."\n";
			$scripttext .= '	 new google.maps.LatLng('.$mapBoundsArray[2].', '.$mapBoundsArray[3].'));' ."\n";

			// Listen for the event
			// dragend
			// bounds_changed
			$scripttext .= '  google.maps.event.addListener(map, \'bounds_changed\', function() {' ."\n";
			$scripttext .= '	 if (allowedBounds.contains(map.getCenter())) return;' ."\n";

			// Out of bounds - Move the map back within the bounds
			$scripttext .= '	 var c = map.getCenter(),' ."\n";
			$scripttext .= '		 x = c.lng(),' ."\n";
			$scripttext .= '		 y = c.lat(),' ."\n";
			$scripttext .= '		 maxX = allowedBounds.getNorthEast().lng(),' ."\n";
			$scripttext .= '		 maxY = allowedBounds.getNorthEast().lat(),' ."\n";
			$scripttext .= '		 minX = allowedBounds.getSouthWest().lng(),' ."\n";
			$scripttext .= '		 minY = allowedBounds.getSouthWest().lat();' ."\n";

			$scripttext .= '	 if (x < minX) x = minX;' ."\n";
			$scripttext .= '	 if (x > maxX) x = maxX;' ."\n";
			$scripttext .= '	 if (y < minY) y = minY;' ."\n";
			$scripttext .= '	 if (y > maxY) y = maxY;' ."\n";

			$scripttext .= '	 map.setCenter(new google.maps.LatLng(y, x));' ."\n";
			$scripttext .= '   });' ."\n";
		}
	}	
	
	if (isset($map->streetview) && (int)$map->streetview != 0)
	{
		$scripttext .= 'var panoramaOptions = {' ."\n";
		$scripttext .= '  position: latlng' ."\n";
		
		$mapSV = modZhGoogleMapPlacemarksHelper::get_StreetViewOptions($map->streetviewstyleid);
		if ($mapSV != "")
		{
			$scripttext .= ', pov: '.$mapSV ."\n";
		}
		
		$scripttext .= '};' ."\n";
		$scripttext .= 'var panorama = new  google.maps.StreetViewPanorama(document.getElementById("GMapStreetView"), panoramaOptions);' ."\n";
		$scripttext .= 'map.setStreetView(panorama);' ."\n";		
	}	
	
	
	if (isset($map->markerlistpos) && (int)$map->markerlistpos != 0) 
	{
	
		if ((int)$map->markerlistpos == 111
		  ||(int)$map->markerlistpos == 112
		  ||(int)$map->markerlistpos == 121
		  ) 
		{
			// Do not create button when table or external
		}
		else
		{
			if ((int)$map->markerlistbuttontype == 0)
			{
				// Skip creation for non-button
			}
			else
			{
				// Define a property to hold the Placemark List state.
				$buttonPlacemarkListStyle = '';
				switch ($map->markerlistbuttontype) 
				{
					case 0:
						$scripttext .= '  PlacemarkListControl.prototype.panelState = 1;' ."\n";
					break;
					case 1:
						$scripttext .= '  PlacemarkListControl.prototype.panelState = 0;' ."\n";
						$buttonPlacemarkListStyle = '-star';
					break;
					case 2:
						$scripttext .= '  PlacemarkListControl.prototype.panelState = 0;' ."\n";
					break;
					case 11:
						$scripttext .= '  PlacemarkListControl.prototype.panelState = 1;' ."\n";
						$buttonPlacemarkListStyle = '-star';
					break;
					case 12:
						$scripttext .= '  PlacemarkListControl.prototype.panelState = 1;' ."\n";
					break;
					default:
						$scripttext .= '  PlacemarkListControl.prototype.panelState = 0;' ."\n";
					break;
				}
								
				// Define setters and getters for properties, and etc.
				$scripttext .= '  PlacemarkListControl.prototype.switchPanel = function() {' ."\n";
				$scripttext .= '    if (this.panelState == 1)' ."\n";
				$scripttext .= '  	{' ."\n";
				$scripttext .= '  		this.panelState = 0;' ."\n";
				$scripttext .= '		var toHideDiv = document.getElementById("GMapsMarkerList");' ."\n";
				$scripttext .= '		toHideDiv.style.display = "none";' ."\n";
				$scripttext .= '  	}' ."\n";
				$scripttext .= '  	else' ."\n";
				$scripttext .= '  	{' ."\n";
				$scripttext .= '  		this.panelState = 1;' ."\n";
				$scripttext .= '		var toShowDiv = document.getElementById("GMapsMarkerList");' ."\n";
				$scripttext .= '		toShowDiv.style.display = "block";' ."\n";
				$scripttext .= '  	}' ."\n";
				$scripttext .= '  }' ."\n";
				
				$scripttext .= 'function PlacemarkListControl(controlDiv, map) {' ."\n";

				// We set up a variable for the 'this' keyword since we're adding event
				// listeners later and 'this' will be out of scope.
				$scripttext .= '  var control = this;' ."\n";
				
				// Set CSS styles for the DIV containing the control
				// Setting padding to 5 px will offset the control
				// from the edge of the map.
				$scripttext .= '  controlDiv.style.padding = \'5px\';' ."\n";

				// Set CSS for the control border.
				$scripttext .= '  var controlUI = document.createElement(\'DIV\');' ."\n";
				$scripttext .= '  controlUI.className = "zhgm-placemarklist-button-ui'.$buttonPlacemarkListStyle.'";' ."\n";
				$scripttext .= '  controlUI.title = "'.JText::_('MOD_ZHGOOGLEMAP_MAP_PLACEMARKLIST').'";' ."\n";
				$scripttext .= '  controlDiv.appendChild(controlUI);' ."\n";

				// Set CSS for the control interior.
				$scripttext .= '  var controlText = document.createElement(\'DIV\');' ."\n";
				$scripttext .= '  controlText.className = "zhgm-placemarklist-button-text'.$buttonPlacemarkListStyle.'";' ."\n";

				switch ($map->markerlistbuttontype) 
				{
					case 0:
						$scripttext .= '  controlText.innerHTML = "";' ."\n";
					break;
					case 1:
						$scripttext .= '  controlText.innerHTML = \'<img style="border: 0px none; padding: 0px; margin: 0px; width: 16px; height: 16px;" src="'.$imgpathUtils.'star.png">\';';				break;
					case 2:
						$scripttext .= '  controlText.innerHTML = "'.JText::_('MOD_ZHGOOGLEMAP_MAP_PLACEMARKLIST').'";' ."\n";
					break;
					case 11:
						$scripttext .= '  controlText.innerHTML = \'<img style="border: 0px none; padding: 0px; margin: 0px; width: 16px; height: 16px;" src="'.$imgpathUtils.'star.png">\';';				break;
					break;
					case 12:
						$scripttext .= '  controlText.innerHTML = "'.JText::_('MOD_ZHGOOGLEMAP_MAP_PLACEMARKLIST').'";' ."\n";
					break;
					default:
						$scripttext .= '  controlText.innerHTML = "";' ."\n";
					break;
				}
				
				$scripttext .= '  controlUI.appendChild(controlText);' ."\n";

				// Setup the click event listeners
				$scripttext .= '  google.maps.event.addDomListener(controlUI, \'click\', function() {' ."\n";
				$scripttext .= '    control.switchPanel();' ."\n";
				$scripttext .= '  });' ."\n";
				$scripttext .= '}' ."\n";

				$scripttext .= '  var placemarklistControlDiv = document.createElement(\'DIV\');' ."\n";
				$scripttext .= '  var placemarklistControl = new PlacemarkListControl(placemarklistControlDiv, map);' ."\n";

				$scripttext .= '  placemarklistControlDiv.index = 1;' ."\n";
				
				if (isset($map->markerlistbuttonpos)) 
				{
					$controlPosition ="";
					switch ($map->markerlistbuttonpos) 
					{
						case 0:
						break;
						case 1:
								$controlPosition = 'google.maps.ControlPosition.TOP_CENTER';
						break;
						case 2:
								$controlPosition = 'google.maps.ControlPosition.TOP_LEFT';
						break;
						case 3:
								$controlPosition = 'google.maps.ControlPosition.TOP_RIGHT';
						break;
						case 4:
								$controlPosition = 'google.maps.ControlPosition.LEFT_TOP';
						break;
						case 5:
								$controlPosition = 'google.maps.ControlPosition.RIGHT_TOP';
						break;
						case 6:
								$controlPosition = 'google.maps.ControlPosition.LEFT_CENTER';
						break;
						case 7:
								$controlPosition = 'google.maps.ControlPosition.RIGHT_CENTER';
						break;
						case 8:
								$controlPosition = 'google.maps.ControlPosition.LEFT_BOTTOM';
						break;
						case 9:
								$controlPosition = 'google.maps.ControlPosition.RIGHT_BOTTOM';
						break;
						case 10:
								$controlPosition = 'google.maps.ControlPosition.BOTTOM_CENTER';
						break;
						case 11:
								$controlPosition = 'google.maps.ControlPosition.BOTTOM_LEFT';
						break;
						case 12:
								$controlPosition = 'google.maps.ControlPosition.BOTTOM_RIGHT';
						break;
						default:
							$controlPosition = '';
						break;
					}
				}
				
				if ($controlPosition != "")
				{
					$scripttext .= '  map.controls['.$controlPosition.'].push(placemarklistControlDiv);' ."\n";
				}
				
			}
		}
	
	}
	

	
	// Pushing controls - Begin

	
	// Begin 0
	if (isset($map->panoramioenable) && (int)$map->panoramioenable == 1) 
	{
		$scripttext .= 'var panoramioLayer = new google.maps.panoramio.PanoramioLayer();' ."\n";
		$scripttext .= 'panoramioLayer.setMap(map);' ."\n";

		if (isset($map->panoramiouser) && $map->panoramiouser != "") 
		{
			$scripttext .= 'panoramioLayer.setUserId("'.$map->panoramiouser.'");' ."\n";
		}
	
		if (isset($map->panoramiotag) && $map->panoramiotag != "") 
		{
			$scripttext .= 'panoramioLayer.setTag("'.$map->panoramiotag.'");' ."\n";
		}
	
		if (isset($map->panoramiofiltercontrol)) 
		{
			$controlPosition ="";
			switch ($map->panoramiofiltercontrolpos) 
			{
				case 0:
				break;
				case 1:
       					$controlPosition = 'google.maps.ControlPosition.TOP_CENTER';
				break;
				case 2:
       					$controlPosition = 'google.maps.ControlPosition.TOP_LEFT';
				break;
				case 3:
       					$controlPosition = 'google.maps.ControlPosition.TOP_RIGHT';
				break;
				case 4:
       					$controlPosition = 'google.maps.ControlPosition.LEFT_TOP';
				break;
				case 5:
       					$controlPosition = 'google.maps.ControlPosition.RIGHT_TOP';
				break;
				case 6:
	       				$controlPosition = 'google.maps.ControlPosition.LEFT_CENTER';
				break;
				case 7:
       					$controlPosition = 'google.maps.ControlPosition.RIGHT_CENTER';
				break;
				case 8:
       					$controlPosition = 'google.maps.ControlPosition.LEFT_BOTTOM';
				break;
				case 9:
       					$controlPosition = 'google.maps.ControlPosition.RIGHT_BOTTOM';
				break;
				case 10:
       					$controlPosition = 'google.maps.ControlPosition.BOTTOM_CENTER';
				break;
				case 11:
       					$controlPosition = 'google.maps.ControlPosition.BOTTOM_LEFT';
				break;
				case 12:
       					$controlPosition = 'google.maps.ControlPosition.BOTTOM_RIGHT';
				break;
				default:
					$controlPosition = '';
				break;
			}
		}
		
		if ($controlPosition != "")
		{
			$scripttext .= "\n";
			$scripttext .= 'var panoramioFilterButton = document.getElementById(\'panoramioFilterButton\');' ."\n";
			$scripttext .= 'var panoramioFilterTag = document.getElementById(\'panoramioFilterTag\');' ."\n";

			$scripttext .= "\n" . 'google.maps.event.addDomListener(panoramioFilterButton, \'click\', function() {' ."\n";
			$scripttext .= 'panoramioLayer.setTag(panoramioFilterTag.value);' ."\n";
			$scripttext .= '});' ."\n";
		
			$scripttext .= 'map.controls['.$controlPosition.'].push(';
            $scripttext .= 'document.getElementById(\'panoramioFilter\'));' ."\n";
		}
	
	}
	// End 0
	
	// Begin 1
	if (isset($map->findcontrol) && (int)$map->findcontrol == 1)
	{
		$scripttext .= '  var markerFind = new google.maps.Marker({' ."\n";
		$scripttext .= '    map: map' ."\n";
		$scripttext .= '  });' ."\n";

		if (isset($map->findpos)) 
		{
			$controlPosition ="";
			switch ($map->findpos) 
			{
				case 0:
				break;
				case 1:
       					$controlPosition = 'google.maps.ControlPosition.TOP_CENTER';
				break;
				case 2:
       					$controlPosition = 'google.maps.ControlPosition.TOP_LEFT';
				break;
				case 3:
       					$controlPosition = 'google.maps.ControlPosition.TOP_RIGHT';
				break;
				case 4:
       					$controlPosition = 'google.maps.ControlPosition.LEFT_TOP';
				break;
				case 5:
       					$controlPosition = 'google.maps.ControlPosition.RIGHT_TOP';
				break;
				case 6:
	       				$controlPosition = 'google.maps.ControlPosition.LEFT_CENTER';
				break;
				case 7:
       					$controlPosition = 'google.maps.ControlPosition.RIGHT_CENTER';
				break;
				case 8:
       					$controlPosition = 'google.maps.ControlPosition.LEFT_BOTTOM';
				break;
				case 9:
       					$controlPosition = 'google.maps.ControlPosition.RIGHT_BOTTOM';
				break;
				case 10:
       					$controlPosition = 'google.maps.ControlPosition.BOTTOM_CENTER';
				break;
				case 11:
       					$controlPosition = 'google.maps.ControlPosition.BOTTOM_LEFT';
				break;
				case 12:
       					$controlPosition = 'google.maps.ControlPosition.BOTTOM_RIGHT';
				break;
				case 101:
       					$controlPosition = '';
				break;
				case 102:
       					$controlPosition = '';
				break;
				default:
					$controlPosition = '';
				break;
			}
		}
		
		$scripttext .= "\n";
		$scripttext .= 'var findAddressButton = document.getElementById(\'findAddressButton\');' ."\n";
		$scripttext .= 'var findAddressField = document.getElementById(\'findAddressField\');' ."\n";
		if (isset($map->findroute) && (int)$map->findroute == 2) 
		{
			$scripttext .= 'var findAddressButtonFind = document.getElementById(\'findAddressButtonFind\');' ."\n";
		}

		$scripttext .= 'var findRouteDirectionsDisplay;' ."\n";
		$scripttext .= 'var findRouteDirectionsService;' ."\n";

		if ((isset($map->findroute) && (int)$map->findroute != 0) 
		    ||((isset($map->placesenable) && (int)$map->placesenable == 1)
		    && (isset($map->placesautocomplete) && (int)$map->placesautocomplete == 1)) )
		{
			$scripttext .= 'findRouteDirectionsDisplay = new google.maps.DirectionsRenderer();' ."\n";
			$scripttext .= 'findRouteDirectionsService = new google.maps.DirectionsService();' ."\n";
			$scripttext .= 'findRouteDirectionsDisplay.setMap(map);' ."\n";

			if (isset($map->routeshowpanel) && (int)$map->routeshowpanel == 1) 
			{
				$scripttext .= 'findRouteDirectionsDisplay.setPanel(document.getElementById("GMapsMainRoutePanel"));' ."\n";
			}

		}

				
		if ((isset($map->placesenable) && (int)$map->placesenable == 1)
		 && (isset($map->placesautocomplete) && (int)$map->placesautocomplete == 1))
		{
			$scripttext .= 'var optionsFindAC = {' ."\n";
			$scripttext .= '  types: ['.$map->placestypeac.']' ."\n";
			$scripttext .= '  };' ."\n";

			$scripttext .= '  var findAutocompleteField = new google.maps.places.Autocomplete(findAddressField, optionsFindAC);' ."\n";

			$scripttext .= '  findAutocompleteField.bindTo(\'bounds\', map);' ."\n";

			$scripttext .= '  google.maps.event.addListener(findAutocompleteField, \'place_changed\', function() {' ."\n";

            $scripttext .= '  var findPlace = findAutocompleteField.getPlace();' ."\n";
			
			$scripttext .= '  placesACbyButton('.(int)$map->placesdirection.', findRouteDirectionsDisplay, findRouteDirectionsService, markerFind, findPlace.name, "findAddressTravelMode", findPlace.geometry.location, routedestination);'."\n";
			
            $scripttext .= '  });' ."\n";
			
		}
		

		$scripttext .= "\n" . 'google.maps.event.addDomListener(findAddressButton, \'click\', function() {' ."\n";
		$scripttext .= '  geocoder.geocode( { \'address\': findAddressField.value}, function(results, status) {'."\n";
		$scripttext .= '  if (status == google.maps.GeocoderStatus.OK) {'."\n";
		$scripttext .= '    var latlngFind = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());' ."\n";

		if (isset($map->findroute) && (int)$map->findroute == 0) 
		{
			$scripttext .= '    placesACbyButton(0, findRouteDirectionsDisplay, findRouteDirectionsService, markerFind, "", "findAddressTravelMode", latlngFind, routedestination);'."\n";
		}
		else if (isset($map->findroute) && (int)$map->findroute == 1) 
		{
			$scripttext .= '    placesACbyButton(1, findRouteDirectionsDisplay, findRouteDirectionsService, markerFind, "", "findAddressTravelMode", latlngFind, routedestination);'."\n";
		}
		else if (isset($map->findroute) && (int)$map->findroute == 2) 
		{
			$scripttext .= '    placesACbyButton(1, findRouteDirectionsDisplay, findRouteDirectionsService, markerFind, "", "findAddressTravelMode", latlngFind, routedestination);'."\n";
		}
		else
		{
			$scripttext .= '    placesACbyButton(0, findRouteDirectionsDisplay, findRouteDirectionsService, markerFind, "", "findAddressTravelMode", latlngFind, routedestination);'."\n";
		}
		
		$scripttext .= '  }'."\n";
		$scripttext .= '  else'."\n";
		$scripttext .= '  {'."\n";
		$scripttext .= '    alert("'.JText::_('MOD_ZHGOOGLEMAP_MAPMARKER_GEOCODING_ERROR_REASON').': " + status + "\n" + "'.JText::_('MOD_ZHGOOGLEMAP_MAPMARKER_GEOCODING_ERROR_ADDRESS').': "+findAddressField.value);'."\n";
		$scripttext .= '  }'."\n";
		$scripttext .= '});'."\n";
		$scripttext .= '});' ."\n";

		if (isset($map->findroute) && (int)$map->findroute == 2) 
		{
			$scripttext .= "\n" . 'google.maps.event.addDomListener(findAddressButtonFind, \'click\', function() {' ."\n";
			$scripttext .= '  geocoder.geocode( { \'address\': findAddressField.value}, function(results, status) {'."\n";
			$scripttext .= '  if (status == google.maps.GeocoderStatus.OK) {'."\n";
			$scripttext .= '    var latlngFind = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());' ."\n";

			$scripttext .= '    placesACbyButton(0 , findRouteDirectionsDisplay, findRouteDirectionsService, markerFind, "", "findAddressTravelMode", latlngFind, routedestination);'."\n";
			
			$scripttext .= '  }'."\n";
			$scripttext .= '  else'."\n";
			$scripttext .= '  {'."\n";
			$scripttext .= '    alert("'.JText::_('MOD_ZHGOOGLEMAP_MAPMARKER_GEOCODING_ERROR_REASON').': " + status + "\n" + "'.JText::_('MOD_ZHGOOGLEMAP_MAPMARKER_GEOCODING_ERROR_ADDRESS').': "+findAddressField.value);'."\n";
			$scripttext .= '  }'."\n";
			$scripttext .= '});'."\n";
			$scripttext .= '});' ."\n";
		}
		
		if ($controlPosition != "")
		{
			$scripttext .= 'map.controls['.$controlPosition.'].push(';
            $scripttext .= 'document.getElementById(\'GMapFindAddress\'));' ."\n";
		}
	
	
	}
	//	End 1
	
	// Begin 2
	// Geo Location - begin
	if (isset($map->geolocationcontrol) && (int)$map->geolocationcontrol == 1) 
	{
	
		if (isset($map->geolocationpos)) 
		{
			$controlPosition ="";
			switch ($map->geolocationpos) 
			{
				case 0:
				break;
				case 1:
       					$controlPosition = 'google.maps.ControlPosition.TOP_CENTER';
				break;
				case 2:
       					$controlPosition = 'google.maps.ControlPosition.TOP_LEFT';
				break;
				case 3:
       					$controlPosition = 'google.maps.ControlPosition.TOP_RIGHT';
				break;
				case 4:
       					$controlPosition = 'google.maps.ControlPosition.LEFT_TOP';
				break;
				case 5:
       					$controlPosition = 'google.maps.ControlPosition.RIGHT_TOP';
				break;
				case 6:
	       				$controlPosition = 'google.maps.ControlPosition.LEFT_CENTER';
				break;
				case 7:
       					$controlPosition = 'google.maps.ControlPosition.RIGHT_CENTER';
				break;
				case 8:
       					$controlPosition = 'google.maps.ControlPosition.LEFT_BOTTOM';
				break;
				case 9:
       					$controlPosition = 'google.maps.ControlPosition.RIGHT_BOTTOM';
				break;
				case 10:
       					$controlPosition = 'google.maps.ControlPosition.BOTTOM_CENTER';
				break;
				case 11:
       					$controlPosition = 'google.maps.ControlPosition.BOTTOM_LEFT';
				break;
				case 12:
       					$controlPosition = 'google.maps.ControlPosition.BOTTOM_RIGHT';
				break;
				default:
					$controlPosition = '';
				break;
			}
		}
		
		if ($controlPosition != "")
		{
			$scripttext .= "\n";
			$scripttext .= 'var geoLocationButton = document.getElementById(\'geoLocationButton\');' ."\n";

			$scripttext .= "\n" . 'google.maps.event.addDomListener(geoLocationButton, \'click\', function() {' ."\n";

			if (((isset($map->placesenable) && (int)$map->placesenable == 1)
					&&(isset($map->placesautocomplete) && (int)$map->placesautocomplete == 1))
			 || (isset($map->findcontrol) && (int)$map->findcontrol == 1) )
			{
				if ((isset($map->placesenable) && (int)$map->placesenable == 1)
				 && (isset($map->placesautocomplete) && (int)$map->placesautocomplete == 1)
				 && (isset($map->findcontrol) && (int)$map->findcontrol == 0))
				{
					if (isset($map->placesdirection) && (int)$map->placesdirection == 1)
					{
						$scripttext .= 'findMyPosition("Button", placesDirectionsDisplay, placesDirectionsService, markerPlacesAC, "searchTravelMode", routedestination);' ."\n";
					}
					else
					{
						$scripttext .= 'findMyPosition("Button", placesDirectionsDisplay, placesDirectionsService, markerPlacesAC, "searchTravelMode", routedestination);' ."\n";
					}
				}
				else if (isset($map->findcontrol) && (int)$map->findcontrol == 1)
				{
					if (isset($map->findroute) && (int)$map->findroute != 0)
					{
						$scripttext .= 'findMyPosition("Button", findRouteDirectionsDisplay, findRouteDirectionsService, markerFind, "findAddressTravelMode", routedestination);' ."\n";
					}
					else
					{
						$scripttext .= 'findMyPosition("Button", findRouteDirectionsDisplay, findRouteDirectionsService, markerFind, "findAddressTravelMode", routedestination);' ."\n";
					}
				}
				else
				{
					$scripttext .= 'findMyPosition("Other");' ."\n";					
				}
			}
			else
			{
				$scripttext .= 'findMyPosition("Other");' ."\n";
			}
			
			$scripttext .= '});' ."\n";
		
			$scripttext .= 'map.controls['.$controlPosition.'].push(';
            $scripttext .= 'document.getElementById(\'geoLocation\'));' ."\n";
		}
	
	}
	// Geo Location - end
	// End 2
	
	// Begin 3
	if (isset($map->markerlistpos) && (int)$map->markerlistpos != 0) 
	{
		$controlPosition = '';
		switch ((int)$map->markerlistpos) 
		{
			case 0:
				// None
				$controlPosition = '';
			break;
			case 1:
				$controlPosition = 'google.maps.ControlPosition.TOP_CENTER';
			break;
			case 2:
				$controlPosition = 'google.maps.ControlPosition.TOP_LEFT';
			break;
			case 3:
				$controlPosition = 'google.maps.ControlPosition.TOP_RIGHT';
			break;
			case 4:
				$controlPosition = 'google.maps.ControlPosition.LEFT_TOP';
			break;
			case 5:
				$controlPosition = 'google.maps.ControlPosition.RIGHT_TOP';
			break;
			case 6:
				$controlPosition = 'google.maps.ControlPosition.LEFT_CENTER';
			break;
			case 7:
				$controlPosition = 'google.maps.ControlPosition.RIGHT_CENTER';
			break;
			case 8:
				$controlPosition = 'google.maps.ControlPosition.LEFT_BOTTOM';
			break;
			case 9:
				$controlPosition = 'google.maps.ControlPosition.RIGHT_BOTTOM';
			break;
			case 10:
				$controlPosition = 'google.maps.ControlPosition.BOTTOM_CENTER';
			break;
			case 11:
				$controlPosition = 'google.maps.ControlPosition.BOTTOM_LEFT';
			break;
			case 12:
				$controlPosition = 'google.maps.ControlPosition.BOTTOM_RIGHT';
			break;
			case 111:
				$controlPosition = '';
			break;
			case 112:
				$controlPosition = '';
			break;
			case 113:
				$controlPosition = '';
			break;
			case 114:
				$controlPosition = '';
			break;
			case 121:
				$controlPosition = '';
			break;
			default:
				$controlPosition = '';
			break;
		}

		if ($controlPosition != "")	
		{
			$scripttext .= 'map.controls['.$controlPosition.'].push(';
			$scripttext .= 'document.getElementById(\'GMapsMarkerList\'));' ."\n";
		}
	}
	// End 3
	
	// Pushing controls - End
	
	if ($map->mapstyles != "")
	{
		$scripttext .= 'var mapStyles = '.$map->mapstyles.';'."\n";
		
		$scripttext .= 'map.setOptions({styles: mapStyles});'."\n";
	}
	
	$scripttext .= 'var geocoder = new google.maps.Geocoder();'."\n";

    if (isset($map->openstreet) && (int)$map->openstreet == 1)
	{

		$scripttext .= ' map.mapTypes.set(\'osm\', openStreetType);' ."\n";

		
		if ((int)$map->maptype == 5)
		{
			$scripttext .= ' map.setMapTypeId(\'osm\');' ."\n";
		}
	}

    if (isset($map->nztopomaps) && (int)$map->nztopomaps != 0)
	{

		if ((int)$map->nztopomaps == 1)
		{
			$scripttext .= ' map.overlayMapTypes.insertAt(0, NZTopomapsType);' ."\n";
		}
		else
		{
			$scripttext .= ' map.mapTypes.set(\'nztopomaps\', NZTopomapsType);' ."\n";

			
			if ((int)$map->maptype == 6)
			{
				$scripttext .= ' map.setMapTypeId(\'nztopomaps\');' ."\n";
			}
		}

		if ($credits != '')
		{
			$credits .= '<br />';
		}
		$credits .= 'NZTopomaps '.JText::_('MOD_ZHGOOGLEMAP_MAP_POWEREDBY').': ';
		$credits .= '<a href="http://www.nztopomaps.com" target="_blank"><img src="http://nz1.nztopomaps.com/nztopomaps_com.png" width="88" height="17" alt="nztopomaps.com" style="border:none;padding:3px;" /></a>';
		$credits .= '&nbsp;';
		$credits .= '<a href="http://www.linz.govt.nz" target="_blank"><img src="http://nz1.nztopomaps.com/source.png" width="238" height="8" alt="linz.govt.nz" style="border:none;" /></a>';
		
	}
	if ((int)$map->openstreet == 1)
	{
		if ($credits != '')
		{
			$credits .= '<br />';
		}
		$credits .= 'OSM '.JText::_('MOD_ZHGOOGLEMAP_MAP_POWEREDBY').': ';
		$credits .= '<a href="http://www.openstreetmap.org/" target="_blank">OpenStreetMap</a>';
	}
	
	if ((int)$map->custommaptype != 0)
	{
		foreach ($maptypes as $key => $currentmaptype) 	
		{
			for ($i=0; $i < count($custMapTypeList); $i++)
			{
				if ($currentmaptype->id == (int)$custMapTypeList[$i])
				{
					if ((int)$currentmaptype->layertype == 1)
					{
						$scripttext .= ' map.overlayMapTypes.insertAt(0, customMapType'.$currentmaptype->id.');' ."\n";
					}
					else
					{
						$scripttext .= ' map.mapTypes.set(\'customMapType'.$currentmaptype->id.'\', customMapType'.$currentmaptype->id.');' ."\n";

						if ((int)$map->maptype == 7)
						{
							if (((int)$custMapTypeFirst != 0) && ((int)$custMapTypeFirst == $currentmaptype->id))
							{
								$scripttext .= ' map.setMapTypeId(\'customMapType'.$currentmaptype->id.'\');' ."\n";
							}
						}
					}
				}
			}
			// End loop by Enabled CustomMapTypes
			
		}
		// End loop by All CustomMapTypes
	}
	
	if ((isset($map->elevation) && (int)$map->elevation == 1)
	  || $featurePathElevation == 1)
    {	
		// Create an ElevationService
		$scripttext .= 'elevator = new google.maps.ElevationService();' ."\n";
	}

	// Elevation feature
	if ((isset($map->elevation) && (int)$map->elevation == 1))
    {	
		// Add a listener for the click event and call getElevation on that location
		$scripttext .= 'google.maps.event.addListener(map, \'click\', getElevation);' ."\n";
	}

	
	// Add Earth 
    if (isset($map->earth) && (int)$map->earth != 0 && $apikey4earth != "")
	{
		$scripttext .= 'isGEinstalled = google.earth.isInstalled();' ."\n";
		
		$scripttext .= 'if (isGEinstalled)' ."\n";
		$scripttext .= '{' ."\n";
        	//$scripttext .= '  alert("Google Earth Plugin is installed");';
        	//$scripttext .= 'alert("Before new Earth");';
	        $scripttext .= 'googleEarth = new GoogleEarth(map);' ."\n";
        	//$scripttext .= 'alert("After new Earth");';
		$scripttext .= '}' ."\n";
		$scripttext .= 'else' ."\n";
		$scripttext .= '{' ."\n";
		if ((int)$map->earth == 2)
		{
        		$scripttext .= '  alert("'.JText::_('MOD_ZHGOOGLEMAP_MAP_EARTH_PLUGIN').'");' ."\n";
		}
		$scripttext .= '}' ."\n";
	}
		

        
    if (  (isset($map->markermanager) && (int)$map->markermanager == 1)
	   && (isset($map->markercluster) && (int)$map->markercluster == 0)
	   && (isset($map->markergroupcontrol) && (int)$map->markergroupcontrol == 0)
	   )
	{

        $scripttext .= 'var mgrmarkers0 = [];' ."\n";
        $scripttext .= 'var mgrMarkerManager = new MarkerManager(map);' ."\n";

        if (isset($markergroups) && !empty($markergroups)) 
        {
			foreach ($markergroups as $key => $currentmarkergroup) 
			{
				$scripttext .= 'var mgrmarkers'.$currentmarkergroup->id.' = [];' ."\n";
            }
		}
	}


	$scripttext .= 'infowindow = new google.maps.InfoWindow();' ."\n";


	// Create Placemark for Insert Users Placemarks - Begin
	//UserMarker - begin
	if ($allowUserMarker == 1)
	{		
		$db = JFactory::getDBO();
		
		$scripttext .= 'var  latlngInsertPlacemark;' ."\n";
		$scripttext .= 'var  insertPlacemark = new google.maps.Marker({' ."\n";
		$scripttext .= '      draggable:true, ' ."\n";
		$scripttext .= '      map: map, ' ."\n";
		$scripttext .= '      animation: google.maps.Animation.DROP' ."\n";
		$scripttext .= '  });'."\n";
		
		$scripttext .= 'insertPlacemark.title = "'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_NEWMARKER' ).'";' ."\n";
		$scripttext .= 'insertPlacemark.description = "'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_NEWMARKER_DESC' ).'";' ."\n";


		$query = $db->getQuery(true);
		
		$query->select('h.title as text, h.id as value ');
		$query->from('#__zhgooglemaps_markergroups as h');
		$query->leftJoin('#__categories as c ON h.catid=c.id');
		$query->where('1=1');
		// get all groups, because you can add marker and disable group
		//$query->where('h.published=1');
		$query->order('h.title');
		
		$db->setQuery($query);    

		if (!$db->query())
		{
			$scripttext .= 'alert("Error (Load Group List Item): " + "' . $db->getEscaped($db->getErrorMsg()).'");';
		}
		else
		{
			$newMarkerGroupList = $db->loadObjectList();
		}

		$query = $db->getQuery(true);
				

		$scripttext .= 'var contentInsertPlacemarkPart1 = \'<div id="contentInsertPlacemark">\' +' ."\n";
		$scripttext .= '\'<h1 id="headContentInsertPlacemark" class="insertPlacemarkHead">'.
			'<img src="'.$imgpathUtils.'published'.(int)$map->usermarkerspublished.'.png" alt="" /> '.
			JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_NEWMARKER' ).'</h1>\'+' ."\n";
		$scripttext .= '\'<div id="bodyContentInsertPlacemark"  class="insertPlacemarkBody">\'+'."\n";
		//$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_LNG' ).' \'+current.lng() + ' ."\n";
		//$scripttext .= '    \'<br />'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_LAT' ).' \'+current.lat() + ' ."\n";
		$scripttext .= '    \'<form id="insertPlacemarkForm" action="'.JURI::current().'" method="post">\'+'."\n";

		// Begin Placemark Properties
		$scripttext .= '\'<div id="bodyInsertPlacemarkDivA"  class="bodyInsertProperties">\'+'."\n";
		$scripttext .= '\'<a id="bodyInsertPlacemarkA" href="javascript:showonlyone(\\\'Placemark\\\',\\\'\\\');" ><img src="'.$imgpathUtils.'collapse.png">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_BASIC_PROPERTIES' ).'</a>\'+'."\n";
		$scripttext .= '\'</div>\'+'."\n";
		$scripttext .= '\'<div id="bodyInsertPlacemark"  class="bodyInsertPlacemarkProperties">\'+'."\n";
		$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_NAME' ).' \'+' ."\n";
		$scripttext .= '    \'<br />\'+' ."\n";
		$scripttext .= '    \'<input name="markername" type="text" maxlength="250" size="50" />\'+' ."\n";
		$scripttext .= '    \'<br />\'+' ."\n";
		$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_DESCRIPTION' ).' \'+' ."\n";
		$scripttext .= '    \'<br />\'+' ."\n";
		$scripttext .= '    \'<input name="markerdescription" type="text" maxlength="250" size="50" />\'+' ."\n";
		$scripttext .= '    \'<br />\';' ."\n";

		// icon type
		$scripttext .= 'var contentInsertPlacemarkIcon = "" +' ."\n";
		if (isset($map->usermarkersicon) && (int)$map->usermarkersicon == 1) 
		{
			$iconTypeJS = " onchange=\"javascript: ";
			$iconTypeJS .= " if (document.forms.insertPlacemarkForm.markerimage.options[selectedIndex].value!=\'\') ";
			$iconTypeJS .= " {document.markericonimage.src=\'".$imgpathIcons."\' + document.forms.insertPlacemarkForm.markerimage.options[selectedIndex].value.replace(/#/g,\'%23\') + \'.png\'}";
			$iconTypeJS .= " else ";
			$iconTypeJS .= " {document.markericonimage.src=\'\'}\"";
			
			$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_ICON_TYPE' ).' \'+' ."\n";
			$scripttext .= ' \'';
			$scripttext .= '<img name="markericonimage" src="" alt="" />';
			$scripttext .= '\'+' ."\n";
			$scripttext .= '    \'<br />\'+' ."\n";
			$scripttext .= ' \'';
			$scripttext .= str_replace('.png<', '<', 
								str_replace('.png"', '"', 
									str_replace('JOPTION_SELECT_IMAGE', JText::_('MOD_ZHGOOGLEMAP_MAP_USER_IMAGESELECT'),
										str_replace(array("\r", "\r\n", "\n"),'', JHTML::_('list.images',  'markerimage', $active =  "", $iconTypeJS, $directoryIcons, $extensions =  "png")))));
			$scripttext .= '\'+' ."\n";

			$scripttext .= '    \'<br />\';' ."\n";
		}
		else
		{
			$scripttext .= '    \'<input name="markerimage" type="hidden" value="default#" />\'+' ."\n";	
			$scripttext .= '    \'\';' ."\n";
		}


		$scripttext .= 'var contentInsertPlacemarkPart2 = "" +' ."\n";
		$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_BALOON' ).' \'+' ."\n";
		$scripttext .= '    \'<br />\'+' ."\n";
		
		$scripttext .= '    \' <select name="markerbaloon" > \'+' ."\n";
		$scripttext .= '    \' <option value="1" selected="selected">'.JText::_( 'MOD_ZHGOOGLEMAP_MAPMARKER_DETAIL_BALOON_DROP').'</option> \'+' ."\n";
		$scripttext .= '    \' <option value="2" >'.JText::_( 'MOD_ZHGOOGLEMAP_MAPMARKER_DETAIL_BALOON_BOUNCE').'</option> \'+' ."\n";
		$scripttext .= '    \' <option value="3" >'.JText::_( 'MOD_ZHGOOGLEMAP_MAPMARKER_DETAIL_BALOON_SIMPLE').'</option> \'+' ."\n";
		$scripttext .= '    \' </select> \'+' ."\n";
		$scripttext .= '    \'<br />\'+' ."\n";

		$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAPMARKER_USER_MARKERCONTENT' ).' \'+' ."\n";
		$scripttext .= '    \'<br />\'+' ."\n";
		
		$scripttext .= '    \' <select name="markermarkercontent" > \'+' ."\n";
		$scripttext .= '    \' <option value="0" selected="selected">'.JText::_( 'MOD_ZHGOOGLEMAP_MAPMARKER_DETAIL_MARKERCONTENT_TITLE_DESC').'</option> \'+' ."\n";
		$scripttext .= '    \' <option value="1" >'.JText::_( 'MOD_ZHGOOGLEMAP_MAPMARKER_DETAIL_MARKERCONTENT_TITLE').'</option> \'+' ."\n";
		$scripttext .= '    \' <option value="2" >'.JText::_( 'MOD_ZHGOOGLEMAP_MAPMARKER_DETAIL_MARKERCONTENT_DESCRIPTION').'</option> \'+' ."\n";
		$scripttext .= '    \' <option value="100" >'.JText::_( 'MOD_ZHGOOGLEMAP_MAPMARKER_DETAIL_MARKERCONTENT_NONE').'</option> \'+' ."\n";
		$scripttext .= '    \' </select> \'+' ."\n";
		$scripttext .= '    \'<br />\'+' ."\n";
				
		$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAPMARKER_DETAIL_HREFIMAGE_LABEL' ).' \'+' ."\n";
		$scripttext .= '    \'<br />\'+' ."\n";
		$scripttext .= '    \'<input name="markerhrefimage" type="text" maxlength="500" size="50" value="" />\'+' ."\n";
		$scripttext .= '    \'<br />\'+' ."\n";

		$scripttext .= '    \'<br />\'+' ."\n";
		
		$scripttext .= '\'</div>\'+'."\n";
		// End Placemark Properties

		// Begin Placemark Group Properties
		$scripttext .= '\'<div id="bodyInsertPlacemarkGrpDivA"  class="bodyInsertProperties">\'+'."\n";
		$scripttext .= '\'<a id="bodyInsertPlacemarkGrpA" href="javascript:showonlyone(\\\'PlacemarkGroup\\\',\\\'\\\');" ><img src="'.$imgpathUtils.'expand.png">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_BASIC_GROUP_PROPERTIES' ).'</a>\'+'."\n";
		$scripttext .= '\'</div>\'+'."\n";
		$scripttext .= '\'<div id="bodyInsertPlacemarkGrp"  class="bodyInsertPlacemarkGrpProperties">\'+'."\n";
		$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_GROUP' ).' \'+' ."\n";
		$scripttext .= '    \'<br />\'+' ."\n";
		
		$scripttext .= '    \' <select name="markergroup" > \'+' ."\n";
		$scripttext .= '    \' <option value="" selected="selected">'.JText::_( 'MOD_ZHGOOGLEMAP_MAPMARKER_FILTER_PLACEMARK_GROUP').'</option> \'+' ."\n";
		foreach ($newMarkerGroupList as $key => $newGrp) 
		{
			$scripttext .= '    \' <option value="'.$newGrp->value.'">'.$newGrp->text.'</option> \'+' ."\n";
		}
		$scripttext .= '    \' </select> \'+' ."\n";
		
		$scripttext .= '    \'<br />\'+' ."\n";

		
		$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CATEGORY' ).' \'+' ."\n";
		$scripttext .= '    \'<br />\'+' ."\n";
		$scripttext .= '    \' <select name="markercatid" > \'+' ."\n";
		$scripttext .= '    \' <option value="" selected="selected">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_FILTER_CATEGORY').'</option> \'+' ."\n";
		$scripttext .= '    \''.str_replace(array("\r", "\r\n", "\n"),'', 
		                       JHtml::_('select.options', JHtml::_('category.options', 'com_zhgooglemap'), 'value', 'text', '')) .
							   '\'+' ."\n";
		$scripttext .= '    \' </select> \'+' ."\n";
		$scripttext .= '    \'<br />\'+' ."\n";

		$scripttext .= '    \'<br />\'+' ."\n";
		$scripttext .= '\'</div>\'+'."\n";
		// End Placemark Group Properties
		
		// Begin Contact Properties
		if (isset($map->usercontact) && (int)$map->usercontact == 1) 
		{

			$scripttext .= '\'<div id="bodyInsertContactDivA"  class="bodyInsertProperties">\'+'."\n";
			$scripttext .= '\'<a id="bodyInsertContactA" href="javascript:showonlyone(\\\'Contact\\\',\\\'\\\');" ><img src="'.$imgpathUtils.'expand.png">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_PROPERTIES' ).'</a>\'+'."\n";
			$scripttext .= '\'</div>\'+'."\n";
			$scripttext .= '\'<div id="bodyInsertContact"  class="bodyInsertContactProperties">\'+'."\n";
			$scripttext .= '\'<img src="'.$imgpathUtils.'published'.(int)$map->usercontactpublished.'.png" alt="" /> \'+'."\n";
			$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_NAME' ).' \'+' ."\n";
			$scripttext .= '    \'<br />\'+' ."\n";
			$scripttext .= '    \'<input name="contactname" type="text" maxlength="250" size="50" />\'+' ."\n";
			$scripttext .= '    \'<br />\'+' ."\n";
			$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_POSITION' ).' \'+' ."\n";
			$scripttext .= '    \'<br />\'+' ."\n";
			$scripttext .= '    \'<input name="contactposition" type="text" maxlength="250" size="50" />\'+' ."\n";
			$scripttext .= '    \'<br />\'+' ."\n";
			$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_PHONE' ).' \'+' ."\n";
			$scripttext .= '    \'<br />\'+' ."\n";
			$scripttext .= '    \'<input name="contactphone" type="text" maxlength="250" size="50" />\'+' ."\n";
			$scripttext .= '    \'<br />\'+' ."\n";
			$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_MOBILE' ).' \'+' ."\n";
			$scripttext .= '    \'<br />\'+' ."\n";
			$scripttext .= '    \'<input name="contactmobile" type="text" maxlength="250" size="50" />\'+' ."\n";
			$scripttext .= '    \'<br />\'+' ."\n";
			$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_FAX' ).' \'+' ."\n";
			$scripttext .= '    \'<br />\'+' ."\n";
			$scripttext .= '    \'<input name="contactfax" type="text" maxlength="250" size="50" />\'+' ."\n";
			$scripttext .= '    \'<br />\'+' ."\n";
			$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_EMAIL' ).' \'+' ."\n";
			$scripttext .= '    \'<br />\'+' ."\n";
			$scripttext .= '    \'<input name="contactemail" type="text" maxlength="250" size="50" />\'+' ."\n";
			$scripttext .= '    \'<br />\'+' ."\n";
			$scripttext .= '    \'<input name="contactid" type="hidden" value="" />\'+' ."\n";
			$scripttext .= '\'</div>\'+'."\n";
			// Contact Address
			$scripttext .= '\'<div id="bodyInsertContactAdrDivA"  class="bodyInsertProperties">\'+'."\n";
			$scripttext .= '\'<a id="bodyInsertContactAdrA" href="javascript:showonlyone(\\\'ContactAddress\\\',\\\'\\\');" ><img src="'.$imgpathUtils.'expand.png">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_ADDRESS_PROPERTIES' ).'</a>\'+'."\n";
			$scripttext .= '\'</div>\'+'."\n";
			$scripttext .= '\'<div id="bodyInsertContactAdr"  class="bodyInsertContactAdrProperties">\'+'."\n";
			$scripttext .= '    \''.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_ADDRESS' ).' \'+' ."\n";
			$scripttext .= '    \'<br />\'+' ."\n";
			$scripttext .= '    \'<textarea name="contactaddress" cols="35" rows="4"></textarea>\'+' ."\n";
			$scripttext .= '    \'<br />\'+' ."\n";
			$scripttext .= '    \'<br />\'+' ."\n";
			$scripttext .= '\'</div>\'+'."\n";
		}
		// End Contact Properties
		
		$scripttext .= '\'\';'."\n";


		$scripttext .= '    google.maps.event.addListener(insertPlacemark, \'drag\', function(event) {' ."\n";
		$scripttext .= '  	  infowindow.close();' ."\n";
		$scripttext .= '      latlngInsertPlacemark = event.latLng;' ."\n";

		$scripttext .= '    });' ."\n";

		$scripttext .= '    google.maps.event.addListener(insertPlacemark, \'click\', function(event) {' ."\n";
		$scripttext .= '        latlngInsertPlacemark = event.latLng;' ."\n";

		$scripttext .= '  contentInsertPlacemarkButtons = \'<div id="contentInsertPlacemarkButtons">\' +' ."\n";
		$scripttext .= '    \'<hr />\'+' ."\n";					
		$scripttext .= '    \'<input name="markerlat" type="hidden" value="\'+latlngInsertPlacemark.lat() + \'" />\'+' ."\n";
		$scripttext .= '    \'<input name="markerlng" type="hidden" value="\'+latlngInsertPlacemark.lng() + \'" />\'+' ."\n";
		$scripttext .= '    \'<input name="marker_action" type="hidden" value="insert" />\'+' ."\n";	
		$scripttext .= '    \'<input name="markersubmit" type="submit" value="'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_BUTTON_ADD' ).'" />\'+' ."\n";
		$scripttext .= '    \'</form>\'+' ."\n";		
		$scripttext .= '\'</div>\'+'."\n";
		$scripttext .= '\'</div>\';'."\n";
		
		$scripttext .= '  		infowindow.setContent(contentInsertPlacemarkPart1+';
		$scripttext .= 'contentInsertPlacemarkIcon+';
		//$scripttext .= 'contentInsertPlacemarkIcon.replace(\'"markericonimage" src="\', \'"markericonimage" src="'.$imgpathIcons.str_replace("#", "%23", "default#").'.png"\')+';
		$scripttext .= 'contentInsertPlacemarkPart2+';
		$scripttext .= 'contentInsertPlacemarkButtons);' ."\n";
		$scripttext .= '  		infowindow.setPosition(latlngInsertPlacemark);' ."\n";
		$scripttext .= '  		infowindow.open(map);' ."\n";
		$scripttext .= '    });' ."\n";
		
		$scripttext .= '    google.maps.event.addListener(map, \'click\', function(event) {' ."\n";
		$scripttext .= '  	  infowindow.close();' ."\n";
		$scripttext .= '      latlngInsertPlacemark = event.latLng;' ."\n";
		$scripttext .= '  	  insertPlacemark.setPosition(latlngInsertPlacemark);' ."\n";

		$scripttext .= '    });' ."\n";
		
	}
	// New Marker - End
	
	// Create Placemark for Insert Users Placemarks - End
	
    if (isset($map->balloon)) 
	{

		$scripttext .= 'var contentString = \'<div id="placemarkContent">\' +' ."\n";
		$scripttext .= '\'<h1 id="headContent" class="placemarkHead">'.htmlspecialchars(str_replace('\\', '/', $map->title), ENT_QUOTES, 'UTF-8').'</h1>\'+' ."\n";
		$scripttext .= '\'<div id="bodyContent"  class="placemarkBody">\'+'."\n";
		$scripttext .= '\''.htmlspecialchars(str_replace('\\', '/', $map->description) , ENT_QUOTES, 'UTF-8').'\'+'."\n";
		$scripttext .= '\'</div>\'+'."\n";
		$scripttext .= '\'</div>\';'."\n";


		if ((int)$map->balloon != 0) 
		{
			$scripttext .= '  var marker = new google.maps.Marker({' ."\n";
			$scripttext .= '      position: latlng, ' ."\n";

			if ((isset($map->markercluster) && (int)$map->markercluster == 0)
			  && (isset($map->markermanager) && (int)$map->markermanager == 0))
			{
					$scripttext .= '      map: map, ' ."\n";
			}

			switch ($map->balloon) 
			{
						case 1:
							$scripttext .= '      animation: google.maps.Animation.DROP,' ."\n";
						break;
						case 2:
							$scripttext .= '      animation: google.maps.Animation.BOUNCE,' ."\n";
						break;
						case 3:
							$scripttext .= '' ."\n";
						break;
						default:
							$scripttext .= '' ."\n";
						break;
			}
                        
			// Replace to new, because all charters are shown
			//$scripttext .= '      title:"'.htmlspecialchars(str_replace('\\', '/', $map->title) , ENT_QUOTES, 'UTF-8').'"' ."\n";
			$scripttext .= '      title:"'.str_replace('\\', '/', str_replace('"', '\'\'', $map->title)).'"' ."\n";
			$scripttext .= '});'."\n";

			$scripttext .= '  google.maps.event.addListener(marker, \'click\', function(event) {' ."\n";
			$scripttext .= '  infowindow.setContent(contentString);' ."\n";
			$scripttext .= '  infowindow.setPosition(latlng);' ."\n";
			$scripttext .= '  infowindow.open(map);' ."\n";
			$scripttext .= '    });' ."\n";
			

			if ((isset($map->markergroupcontrol) && (int)$map->markergroupcontrol != 0))
			{
				$scripttext .= 'clustermarkers0.push(marker);' ."\n";
			}
			else
			{
				if ((isset($map->markercluster) && (int)$map->markercluster == 1))
				{
					if ((isset($map->markerclustergroup) && (int)$map->markerclustergroup == 1))
					{
						$scripttext .= 'clustermarkers0.push(marker);' ."\n";
					}
					else
					{
						$scripttext .= 'clustermarkers0.push(marker);' ."\n";
					}
				}
				else
				{
					if ((isset($map->markerclustergroup) && (int)$map->markerclustergroup == 1))
					{
						$scripttext .= 'clustermarkers0.push(marker);' ."\n";
					}
				}
			}


			if (  (isset($map->markermanager) && (int)$map->markermanager == 1)
			   && (isset($map->markercluster) && (int)$map->markercluster == 0)
			   && (isset($map->markergroupcontrol) && (int)$map->markergroupcontrol == 0)
			   )
			{
			   $scripttext .= 'mgrmarkers0.push(marker);' ."\n";
			}

            
            }
            
            if ((int)$map->openballoon == 1)
            {
				if ((int)$map->balloon != 0)
				{
					$scripttext .= '  google.maps.event.trigger(marker, "click");' ."\n";
				}
				else
				{
                    $scripttext .= '  infowindow.setContent(contentString);' ."\n";
                    $scripttext .= '  infowindow.setPosition(latlng);' ."\n";
                    $scripttext .= '  infowindow.open(map);' ."\n";
				}
            }
            
	}

	// Creating Clusters in the beginning for using in geocoding
	if ((isset($map->markercluster) && (int)$map->markercluster == 1))
	{      
		if ((int)$map->clusterzoom == 0)
		{
			$scripttext .= 'markerCluster0 = new MarkerClusterer(map, []);' ."\n";
		}
		else
		{
			$scripttext .= 'markerCluster0 = new MarkerClusterer(map, [], { maxZoom: '.$map->clusterzoom.'});' ."\n";
		}


        if ((isset($map->markerclustergroup) && (int)$map->markerclustergroup == 1))
		{
			if ($compatiblemodersf == 0)
			{
				$imgpath4size = JPATH_ADMINISTRATOR .'/components/com_zhgooglemap/assets/icons/';
			}
			else
			{
				$imgpath4size = JPATH_SITE .'/components/com_zhgooglemap/assets/icons/';
			}

			if (isset($markergroups) && !empty($markergroups)) 
			{
				foreach ($markergroups as $key => $currentmarkergroup) 
				{
					if ((int)$currentmarkergroup->overridegroupicon == 1)
					{
						$imgimg = $imgpathIcons.str_replace("#", "%23", $currentmarkergroup->icontype).'.png';
						$imgimg4size = $imgpath4size.$currentmarkergroup->icontype.'.png';
						
						list ($imgwidth, $imgheight) = getimagesize($imgimg4size);

						$markergroupstyle = 'styles: [{' ."\n";
						$markergroupstyle .='height: '.$imgheight.',' ."\n";
						$markergroupstyle .='width: '.$imgwidth.',' ."\n";
						$markergroupstyle .='url: "'.$imgimg.'"' ."\n";
						$markergroupstyle .='}]' ."\n";
					}

					if ((int)$map->clusterzoom == 0)
					{
						if ((int)$currentmarkergroup->overridegroupicon == 1)
						{
							$scripttext .= 'markerCluster'.$currentmarkergroup->id.' = new MarkerClusterer(map, [], {'.$markergroupstyle.'});' ."\n";
						}
						else
						{
							$scripttext .= 'markerCluster'.$currentmarkergroup->id.' = new MarkerClusterer(map, []);' ."\n";
						}
					}
					else
					{
						if ((int)$currentmarkergroup->overridegroupicon == 1)
						{
							$scripttext .= 'markerCluster'.$currentmarkergroup->id.' = new MarkerClusterer(map, [], { maxZoom: '.$map->clusterzoom.','."\n".$markergroupstyle.'});' ."\n";
						}
						else
						{
							$scripttext .= 'markerCluster'.$currentmarkergroup->id.' = new MarkerClusterer(map, [], { maxZoom: '.$map->clusterzoom.'});' ."\n";
						}
					}
				}
			}

		}
		
	}




	if (isset($map->markerlistpos) && (int)$map->markerlistpos != 0) 
	{
		if ((int)$map->markerlistcontent < 100) 
		{
			$scripttext .= 'var markerUL = document.getElementById("GMapsMarkerUL");'."\n";
			$scripttext .= 'if (!markerUL)'."\n";
			$scripttext .= '{'."\n";
			$scripttext .= ' alert("'.JText::_('MOD_ZHGOOGLEMAP_MAP_MARKERUL_NOTFIND').'");'."\n";
			$scripttext .= '}'."\n";
		}
		else
		{
			$scripttext .= 'var markerUL = document.getElementById("GMapsMarkerTABLEBODY");'."\n";
			$scripttext .= 'if (!markerUL)'."\n";
			$scripttext .= '{'."\n";
			$scripttext .= ' alert("'.JText::_('MOD_ZHGOOGLEMAP_MAP_MARKERTABLE_NOTFIND').'");'."\n";
			$scripttext .= '}'."\n";
		}
	}
		
	// External Group Control
	if (isset($map->markergroupcontrol) && (int)$map->markergroupcontrol == 10) 
	{
			$scripttext .= 'var groupDivTag = document.getElementById("GMapsGroupDIV");'."\n";
			$scripttext .= 'if (!groupDivTag)'."\n";
			$scripttext .= '{'."\n";
			$scripttext .= ' alert("'.JText::_('MOD_ZHGOOGLEMAP_MAP_GROUPDIV_NOTFIND').'");'."\n";
			$scripttext .= '}'."\n";
			$scripttext .= 'else'."\n";
			$scripttext .= '{'."\n";
			$scripttext .= ' groupDivTag.innerHTML = \''.str_replace('\'', '\\\'', str_replace(array("\r", "\r\n", "\n"),'', $divmarkergroup)).'\';'."\n";
			$scripttext .= '}'."\n";
	}
		
	// Markers
	if (isset($map->usercontactattributes) && $map->usercontactattributes != "")
	{
		$userContactAttrs = str_replace(";", ',',$map->usercontactattributes);
	}
	else
	{
		$userContactAttrs = str_replace(";", ',', 'name;position;address;phone;mobile;fax;email');
	}
	$scripttext .= 'var userContactAttrs = \''.$userContactAttrs.'\';' ."\n";
	
	
	$doAddToListCount = 0;
	if (isset($markers) && !empty($markers)) 
	{
		//$scripttext .= '    alert("$map->markercluster='. $map->markercluster.'");'."\n";
		//$scripttext .= '    alert("$map->markerclustergroup='. $map->markerclustergroup.'");'."\n";
		//$scripttext .= '    alert("$map->markergroupcontrol='. $map->markergroupcontrol.'");'."\n";
			
		// Main loop
		foreach ($markers as $key => $currentmarker) 
		{

			//$scripttext .= '    alert("try marker '. $currentmarker->id.'");'."\n";
			//$scripttext .= '    alert("$currentmarker->publishedgroup='. $currentmarker->publishedgroup.'");'."\n";

		// Begin restriction 
			if (
				((($currentmarker->markergroup != 0)
					&& ((int)$currentmarker->published == 1)
					&& ((int)$currentmarker->publishedgroup == 1)) || ($allowUserMarker == 1)
				) || 
				((($currentmarker->markergroup == 0)
					&& ((int)$currentmarker->published == 1)) || ($allowUserMarker == 1)
				) 
 			)
			{

   				//$scripttext .= '    alert("Work on marker '. $currentmarker->id.'");'."\n";
			    if (($currentmarker->latitude != "" && $currentmarker->longitude != "")
				   ||($currentmarker->addresstext != ""))
				{

					$scripttext .= 'var titlePlacemark'. $currentmarker->id.' = "'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'";'."\n";
				
					if ($currentmarker->latitude != "" && $currentmarker->longitude != "")
					{
						$scripttext .= 'var latlng'. $currentmarker->id.' = new google.maps.LatLng('.$currentmarker->latitude.', ' .$currentmarker->longitude.');' ."\n";
						// Begin marker creation with lat,lng
						// contentString - Begin
						if (($allowUserMarker == 0)
						 || (isset($currentmarker->userprotection) && (int)$currentmarker->userprotection == 1)
						 || ($currentUserID == 0)
						 || (isset($currentmarker->createdbyuser) 
						    && (((int)$currentmarker->createdbyuser != $currentUserID )
							   || ((int)$currentmarker->createdbyuser == 0)))
						 )
						{
							if (isset($map->useajax) && (int)$map->useajax == 1)
							{
								// do not create content string, create by loop only in the end
							}
							else
							{
								if ((int)$currentmarker->actionbyclick == 1)
								{
									$scripttext .= 'var contentString'. $currentmarker->id.' = '.
										modZhGoogleMapPlacemarksHelper::get_placemark_content_string(
											'',
											$currentmarker, $map->usercontact, $map->useruser,
											$userContactAttrs, $service_DoDirection,
											$imgpathIcons, $imgpathUtils, $directoryIcons);
								}
							}
						}
						else
						{
							// contentString - User Placemark can Update - Begin
							
							$scripttext .= get_UpdateContentString(
													$map->usermarkersicon, 
													$map->usercontact, 
													$currentmarker,
													$imgpathIcons, $imgpathUtils, $directoryIcons,
													$newMarkerGroupList
													);
													
							// contentString - User Placemark can Update - End
						}

						if ((int)$currentmarker->baloon != 0) 
						{
							// Infographics
							if (((int)$currentmarker->baloon == 11)
							  || ((int)$currentmarker->baloon == 12)
							  || ((int)$currentmarker->baloon == 13))
							{
							  //if (isset($currentmarker->infographicstype) && $currentmarker->infographicstype != "")
							  //{
								 $scripttext .= 'var imageUrl'.$currentmarker->id.' = \'http://chart.googleapis.com/chart?';
								 $scripttext .= str_replace('\'','\\\'', $currentmarker->infographicstype).'\';'."\n";
								 $scripttext .= 'var markerImage'.$currentmarker->id.' = new google.maps.MarkerImage(imageUrl'.$currentmarker->id;
								 if ((int)$currentmarker->infographicswidth != 0
									 && (int)$currentmarker->infographicsheight != 0)
								 {
									 $scripttext .= ', new google.maps.Size('.(int)$currentmarker->infographicswidth.','.(int)$currentmarker->infographicsheight.')';
								 }
								 $scripttext .= ');'."\n";
							  //}     
							}								  

							$scripttext .= '  var marker'. $currentmarker->id.' = new google.maps.Marker({' ."\n";
							$scripttext .= '      position: latlng'. $currentmarker->id.', ' ."\n";

							if ((isset($map->markercluster) && (int)$map->markercluster == 0)
							   && (isset($map->markermanager) && (int)$map->markermanager == 0))
							{
									$scripttext .= '      map: map, ' ."\n";
							}

							if ((int)$currentmarker->overridemarkericon == 0)
							{
								switch ((int)$currentmarker->baloon) 
								{
								case 1:
									// DROP
									$scripttext .= '      icon: icoIcon + "'.str_replace("#", "%23", $currentmarker->icontype).'.png", ' ."\n";
								break;
								case 2:
									// BOUNCE
									$scripttext .= '      icon: icoIcon + "'.str_replace("#", "%23", $currentmarker->icontype).'.png", ' ."\n";
								break;
								case 3:
									// SIMPLE
									$scripttext .= '      icon: icoIcon + "'.str_replace("#", "%23", $currentmarker->icontype).'.png", ' ."\n";
								break;
								case 11:
									// DROP INFOGRAPHICS									  
									if (isset($currentmarker->infographicstype) && $currentmarker->infographicstype != "")
									{
										$scripttext .=  '      icon: markerImage'.$currentmarker->id.','."\n";
									}
									else
									{
										$scripttext .= '      icon: icoIcon + "'.str_replace("#", "%23", $currentmarker->icontype).'.png", ' ."\n";
									}
								break;
								case 12:
									// BOUNCE INFOGRAPHICS
									if (isset($currentmarker->infographicstype) && $currentmarker->infographicstype != "")
									{
										$scripttext .=  '      icon: markerImage'.$currentmarker->id.','."\n";
									}
									else
									{
										$scripttext .= '      icon: icoIcon + "'.str_replace("#", "%23", $currentmarker->icontype).'.png", ' ."\n";
									}
								break;
								case 13:
									// SIMPLE INFOGRAPHICS
									if (isset($currentmarker->infographicstype) && $currentmarker->infographicstype != "")
									{
										$scripttext .=  '      icon: markerImage'.$currentmarker->id.','."\n";
									}
									else
									{
										$scripttext .= '      icon: icoIcon + "'.str_replace("#", "%23", $currentmarker->icontype).'.png", ' ."\n";
									}
								break;
								default:
									$scripttext .= '      icon: icoIcon + "'.str_replace("#", "%23", $currentmarker->icontype).'.png", ' ."\n";
								break;
								}
							}	
							else
							{
								$scripttext .= '      icon: icoIcon + "'.str_replace("#", "%23", $currentmarker->groupicontype).'.png", ' ."\n";
							}

							switch ($currentmarker->baloon) 
							{
							case 1:
									$scripttext .= '      animation: google.maps.Animation.DROP,' ."\n";
							break;
							case 2:
									$scripttext .= '      animation: google.maps.Animation.BOUNCE,' ."\n";
							break;
							case 3:
									$scripttext .= '' ."\n";
							break;
							case 11:
									$scripttext .= '      animation: google.maps.Animation.DROP,' ."\n";
							break;
							case 12:
									$scripttext .= '      animation: google.maps.Animation.BOUNCE,' ."\n";
							break;
							case 13:
									$scripttext .= '' ."\n";
							break;
							default:
									$scripttext .= '' ."\n";
							break;
							}

							if (($allowUserMarker == 0)
							 || (isset($currentmarker->userprotection) && (int)$currentmarker->userprotection == 1)
							 || ($currentUserID == 0)
							 || (isset($currentmarker->createdbyuser) 
								&& (((int)$currentmarker->createdbyuser != $currentUserID )
								   || ((int)$currentmarker->createdbyuser == 0))))
							{
									$scripttext .= 'draggable: false,' ."\n";
							}
							else
							{
									$scripttext .= 'draggable: true,' ."\n";
							}
							
							// Replace to new, because all charters are shown
							//$scripttext .= '      title:"'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'"' ."\n";
							if (isset($currentmarker->markercontent) &&
								(((int)$currentmarker->markercontent == 0) ||
								 ((int)$currentmarker->markercontent == 1))
								)
							{
								$scripttext .= '      title:"'.str_replace('\\', '/', str_replace('"', '\'\'', $currentmarker->title)).'"' ."\n";
							}
							else
							{
								$scripttext .= '      title:""' ."\n";
							}

							
							$scripttext .= '});'."\n";

							$scripttext .= '  marker'. $currentmarker->id.'.set("zhgmPlacemarkID", '.$currentmarker->id.');' ."\n";
							$scripttext .= '  marker'. $currentmarker->id.'.set("zhgmContactAttrs", userContactAttrs);' ."\n";
							$scripttext .= '  marker'. $currentmarker->id.'.set("zhgmUserContact", "'.str_replace(';', ',', $map->usercontact).'");' ."\n";
							$scripttext .= '  marker'. $currentmarker->id.'.set("zhgmUserUser", "'.str_replace(';', ',', $map->useruser).'");' ."\n";
							
							//  If user can change placemark - override content string - begin
							//  override content string
							if (($allowUserMarker == 0)
							 || (isset($currentmarker->userprotection) && (int)$currentmarker->userprotection == 1)
							 || ($currentUserID == 0)
							 || (isset($currentmarker->createdbyuser) 
								&& (((int)$currentmarker->createdbyuser != $currentUserID )
								   || ((int)$currentmarker->createdbyuser == 0)))
							)
							{
								if (isset($map->useajax) && (int)$map->useajax == 1)
								{
									// do not create listeners, create by loop only in the end
									$scripttext .= '  ajaxmarkersLL.push(marker'. $currentmarker->id.');'."\n";
								}
								else
								{
								// Action By Click - Begin							
								switch ((int)$currentmarker->actionbyclick)
								{
									// None
									case 0:
										if ((int)$currentmarker->zoombyclick != 100)
										{
											$scripttext .= '  google.maps.event.addListener(marker'. $currentmarker->id.', \'click\', function(event) {' ."\n";
											$scripttext .= '  map.setCenter(latlng'. $currentmarker->id.');' ."\n";
											$scripttext .= '  map.setZoom('.(int)$currentmarker->zoombyclick.');' ."\n";
											$scripttext .= '  });' ."\n";
										}
									break;
									// Info
									case 1:
											$scripttext .= '  google.maps.event.addListener(marker'. $currentmarker->id.', \'click\', function(event) {' ."\n";
											if ((int)$currentmarker->zoombyclick != 100)
											{
												$scripttext .= '  map.setCenter(latlng'. $currentmarker->id.');' ."\n";
												$scripttext .= '  map.setZoom('.(int)$currentmarker->zoombyclick.');' ."\n";
											}
												$scripttext .= '  infowindow.close();' ."\n";
												// Close the other infobubbles
												$scripttext .= '  for (i = 0; i < infobubblemarkers.length; i++) {' ."\n";
												$scripttext .= '      infobubblemarkers[i].close();' ."\n";
												$scripttext .= '  }' ."\n";
												// Open Infowin
												$scripttext .= '  infowindow.set("zhgmPlacemarkTitle", titlePlacemark'. $currentmarker->id.');' ."\n";
												$scripttext .= '  infowindow.setContent(contentString'. $currentmarker->id.');' ."\n";
												$scripttext .= '  infowindow.setPosition(latlng'. $currentmarker->id.');' ."\n";
												$scripttext .= '  infowindow.open(map);' ."\n";
											$scripttext .= '  });' ."\n";
									break;
									// Link
									case 2:
										if ($currentmarker->hrefsite != "")
										{
											$scripttext .= '  google.maps.event.addListener(marker'. $currentmarker->id.', \'click\', function(event) {' ."\n";
											if ((int)$currentmarker->zoombyclick != 100)
											{
												$scripttext .= '  map.setCenter(latlng'. $currentmarker->id.');' ."\n";
												$scripttext .= '  map.setZoom('.(int)$currentmarker->zoombyclick.');' ."\n";
											}
											$scripttext .= '  window.open("'.$currentmarker->hrefsite.'");' ."\n";
											$scripttext .= '  });' ."\n";
										}
										else
										{
											if ((int)$currentmarker->zoombyclick != 100)
											{
												$scripttext .= '  google.maps.event.addListener(marker'. $currentmarker->id.', \'click\', function(event) {' ."\n";
												$scripttext .= '  map.setCenter(latlng'. $currentmarker->id.');' ."\n";
												$scripttext .= '  map.setZoom('.(int)$currentmarker->zoombyclick.');' ."\n";
												$scripttext .= '  });' ."\n";
											}
										}
									break;
									// Link in self
									case 3:
										if ($currentmarker->hrefsite != "")
										{
											$scripttext .= '  google.maps.event.addListener(marker'. $currentmarker->id.', \'click\', function(event) {' ."\n";
											if ((int)$currentmarker->zoombyclick != 100)
											{
												$scripttext .= '  map.setCenter(latlng'. $currentmarker->id.');' ."\n";
												$scripttext .= '  map.setZoom('.(int)$currentmarker->zoombyclick.');' ."\n";
											}
											$scripttext .= '  window.location = "'.$currentmarker->hrefsite.'";' ."\n";
											$scripttext .= '  });' ."\n";
										}
										else
										{
											if ((int)$currentmarker->zoombyclick != 100)
											{
												$scripttext .= '  google.maps.event.addListener(marker'. $currentmarker->id.', \'click\', function(event) {' ."\n";
												$scripttext .= '  map.setCenter(latlng'. $currentmarker->id.');' ."\n";
												$scripttext .= '  map.setZoom('.(int)$currentmarker->zoombyclick.');' ."\n";
												$scripttext .= '  });' ."\n";
											}
										}
									break;
									// InfoBubble
									case 4:
										// InfoBubble Create - Begin
										$scriptInfoBubbleStyle = '';
										
										$scripttext .= '  infoBubble'. $currentmarker->id.' = new InfoBubble('."\n";
										$scripttext .= modZhGoogleMapPlacemarksHelper::get_placemark_infobubble_style_string($currentmarker);
										$scripttext .= '  );'."\n";

										$scripttext .= '  infobubblemarkers.push(infoBubble'. $currentmarker->id.');'."\n";
										
										if ($currentmarker->tab1 != "")
										{
											$scripttext .= '  infoBubble'. $currentmarker->id.'.addTab(\''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab1title)).'\', \''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab1)).'\');'."\n";
										}
										if ($currentmarker->tab2 != "")
										{
											$scripttext .= '  infoBubble'. $currentmarker->id.'.addTab(\''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab2title)).'\', \''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab2)).'\');'."\n";
										}
										if ($currentmarker->tab3 != "")
										{
											$scripttext .= '  infoBubble'. $currentmarker->id.'.addTab(\''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab3title)).'\', \''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab3)).'\');'."\n";
										}
										if ($currentmarker->tab4 != "")
										{
											$scripttext .= '  infoBubble'. $currentmarker->id.'.addTab(\''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab4title)).'\', \''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab4)).'\');'."\n";
										}
										if ($currentmarker->tab5 != "")
										{
											$scripttext .= '  infoBubble'. $currentmarker->id.'.addTab(\''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab5title)).'\', \''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab5)).'\');'."\n";
										}
										if ($currentmarker->tab6 != "")
										{
											$scripttext .= '  infoBubble'. $currentmarker->id.'.addTab(\''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab6title)).'\', \''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab6)).'\');'."\n";
										}
										if ($currentmarker->tab7 != "")
										{
											$scripttext .= '  infoBubble'. $currentmarker->id.'.addTab(\''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab7title)).'\', \''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab7)).'\');'."\n";
										}
										if ($currentmarker->tab8 != "")
										{
											$scripttext .= '  infoBubble'. $currentmarker->id.'.addTab(\''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab8title)).'\', \''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab8)).'\');'."\n";
										}
										if ($currentmarker->tab9 != "")
										{
											$scripttext .= '  infoBubble'. $currentmarker->id.'.addTab(\''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab9title)).'\', \''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab9)).'\');'."\n";
										}
										// InfoBubble Create - End
										$scripttext .= '  google.maps.event.addListener(marker'. $currentmarker->id.', \'click\', function(event) {' ."\n";
										if ((int)$currentmarker->zoombyclick != 100)
										{
											$scripttext .= '  map.setCenter(latlng'. $currentmarker->id.');' ."\n";
											$scripttext .= '  map.setZoom('.(int)$currentmarker->zoombyclick.');' ."\n";
										}
										$scripttext .= '  if (!infoBubble'. $currentmarker->id.'.isOpen())'."\n";
										$scripttext .= '  {'."\n";
										// Close the other infowin and infobubbles
										$scripttext .= '  infowindow.close();'."\n";
										$scripttext .= '  for (i = 0; i < infobubblemarkers.length; i++) {' ."\n";
										$scripttext .= '      infobubblemarkers[i].close();' ."\n";
										$scripttext .= '  }' ."\n";
										// Open infobubble
										$scripttext .= '  	infoBubble'. $currentmarker->id.'.open(map, marker'. $currentmarker->id.');'."\n";
										$scripttext .= '  }'."\n";
										$scripttext .= '  });' ."\n";
									break;
									// Open Street View
									case 5:
										if (isset($map->streetview) && (int)$map->streetview != 0) 
										{
											$scripttext .= '  google.maps.event.addListener(marker'. $currentmarker->id.', \'click\', function(event) {' ."\n";
											if ((int)$currentmarker->zoombyclick != 100)
											{
												$scripttext .= '  map.setCenter(latlng'. $currentmarker->id.');' ."\n";
												$scripttext .= '  map.setZoom('.(int)$currentmarker->zoombyclick.');' ."\n";
											}
											$scripttext .= '  panorama.setPosition(latlng'. $currentmarker->id.');' ."\n";
											$mapSV = modZhGoogleMapPlacemarksHelper::get_StreetViewOptions($currentmarker->streetviewstyleid);
											if ($mapSV != "")
											{
												$scripttext .= '  panorama.setPov('.$mapSV.');'."\n";
											}
											$scripttext .= '  });' ."\n";
										}
										else
										{
											$scripttext .= 'google.maps.event.addListener(marker'. $currentmarker->id.', \'click\', function(event) {' ."\n";
											if ((int)$currentmarker->zoombyclick != 100)
											{
												$scripttext .= '  map.setCenter(latlng'. $currentmarker->id.');' ."\n";
												$scripttext .= '  map.setZoom('.(int)$currentmarker->zoombyclick.');' ."\n";												
											}
											$mapSV = modZhGoogleMapPlacemarksHelper::get_StreetViewOptions($currentmarker->streetviewstyleid);
											$scripttext .= '  infowindow.close();' ."\n";
											$scripttext .= '  for (i = 0; i < infobubblemarkers.length; i++) {' ."\n";
											$scripttext .= '      infobubblemarkers[i].close();' ."\n";
											$scripttext .= '  }' ."\n";
											$scripttext .= '  infowindow.setPosition(latlng'. $currentmarker->id.');' ."\n";
											if ($mapSV == "")
											{
												$scripttext .= 'showPlacemarkPanorama('.$currentmarker->streetviewinfowinw.','.$currentmarker->streetviewinfowinh.', \'\');'."\n";
											}
											else
											{
												$scripttext .= 'showPlacemarkPanorama('.$currentmarker->streetviewinfowinw.','.$currentmarker->streetviewinfowinh.', '.$mapSV.');'."\n";
											}
 											$scripttext .= '});' ."\n";
										}
									break;
									default:
										$scripttext .= '' ."\n";
									break;
								}
								
								// Action By Click - End
								}
							}
							else
							{
								// Action By click for update placemark = Open InfoWin
									$scripttext .= '  google.maps.event.addListener(marker'. $currentmarker->id.', \'click\', function(event) {' ."\n";

									$scripttext .= 'var contentStringButtons'.$currentmarker->id.' = "" +' ."\n";
									$scripttext .= '    \'<hr />\'+' ."\n";					
									$scripttext .= '    \'<input name="markerlat" type="hidden" value="\'+latlng'. $currentmarker->id.'.lat() + \'" />\'+' ."\n";
									$scripttext .= '    \'<input name="markerlng" type="hidden" value="\'+latlng'.$currentmarker->id.'.lng() + \'" />\'+' ."\n";
									$scripttext .= '    \'<input name="marker_action" type="hidden" value="update" />\'+' ."\n";
									$scripttext .= '    \'<input name="markerid" type="hidden" value="'.$currentmarker->id.'" />\'+' ."\n";
									$scripttext .= '    \'<input name="contactid" type="hidden" value="'.$currentmarker->contactid.'" />\'+' ."\n";
									$scripttext .= '    \'<input name="markersubmit" type="submit" value="'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_BUTTON_UPDATE' ).'" />\'+' ."\n";
									$scripttext .= '    \'</form>\'+' ."\n";		
									$scripttext .= '\'</div>\'+'."\n";
									// Form Delete
									$scripttext .= '\'<div id="contentDeletePlacemark">\'+'."\n";
									$scripttext .= '    \'<form id="deletePlacemarkForm'.$currentmarker->id.'" action="'.JURI::current().'" method="post">\'+'."\n";
									$scripttext .= '    \'<input name="marker_action" type="hidden" value="delete" />\'+' ."\n";
									$scripttext .= '    \'<input name="markerid" type="hidden" value="'.$currentmarker->id.'" />\'+' ."\n";
									$scripttext .= '    \'<input name="contactid" type="hidden" value="'.$currentmarker->contactid.'" />\'+' ."\n";
									$scripttext .= '    \'<input name="markersubmit" type="submit" value="'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_BUTTON_DELETE' ).'" />\'+' ."\n";
									$scripttext .= '    \'</form>\'+' ."\n";		
									$scripttext .= '\'</div>\';'."\n";
									
									$scripttext .= '  infowindow.setContent(contentStringPart1'.$currentmarker->id.'+';
									$scripttext .= 'contentInsertPlacemarkIcon.replace(/insertPlacemarkForm/g,"updatePlacemarkForm'. $currentmarker->id.'")';
									$scripttext .= '.replace(\'"markericonimage" src="\', \'"markericonimage" src="'.$imgpathIcons.str_replace("#", "%23", $currentmarker->icontype).'.png"\')';
									$scripttext .= '.replace(\'<option value="'.$currentmarker->icontype.'">'.$currentmarker->icontype.'</option>\', \'<option value="'.$currentmarker->icontype.'" selected="selected">'.$currentmarker->icontype.'</option>\')';
									$scripttext .= '+';
									$scripttext .= 'contentStringPart2'.$currentmarker->id.'+';
									$scripttext .= 'contentStringButtons'.$currentmarker->id;
									$scripttext .= ');' ."\n";
									$scripttext .= '  infowindow.setPosition(latlng'. $currentmarker->id.');' ."\n";
									$scripttext .= '  infowindow.open(map);' ."\n";
									
									$scripttext .= '  });' ."\n";

									$scripttext .= '  google.maps.event.addListener(marker'. $currentmarker->id.', \'drag\', function(event) {' ."\n";

									$scripttext .= '	infowindow.close();' ."\n";
									$scripttext .= '	latlng'. $currentmarker->id.' = event.latLng;';
									
									$scripttext .= '  });' ."\n";


							}
							
							// If user can change placemark - override content string - end
							

							if ((isset($map->markergroupcontrol) && (int)$map->markergroupcontrol != 0))
							{
								$scripttext .= 'clustermarkers'.$currentmarker->markergroup.'.push(marker'. $currentmarker->id.');' ."\n";
							}
							else
							{
								if ((isset($map->markercluster) && (int)$map->markercluster == 1))
								{
									if ((isset($map->markerclustergroup) && (int)$map->markerclustergroup == 1))
									{
										$scripttext .= 'clustermarkers'.$currentmarker->markergroup.'.push(marker'. $currentmarker->id.');' ."\n";
									}
									else
									{
										$scripttext .= 'clustermarkers0.push(marker'. $currentmarker->id.');' ."\n";
									}
								}
								else
								{
									if ((isset($map->markerclustergroup) && (int)$map->markerclustergroup == 1))
									{
										$scripttext .= 'clustermarkers'.$currentmarker->markergroup.'.push(marker'. $currentmarker->id.');' ."\n";
									}
								}
							}

							if (  (isset($map->markermanager) && (int)$map->markermanager == 1)
							&& (isset($map->markercluster) && (int)$map->markercluster == 0)
							&& (isset($map->markergroupcontrol) && (int)$map->markergroupcontrol == 0)
							)
							{
							   $scripttext .= 'mgrmarkers'.$currentmarker->markergroup.'.push(marker'. $currentmarker->id.');' ."\n";
							}

																	
							//
							// Generate list elements for each marker.
							if (isset($map->markerlistpos) && (int)$map->markerlistpos != 0) 
							{						
								$doAddToList = 1;
								
								if ($doAddToList == 1)
								{
									$doAddToListCount += 1;
									$scripttext .= 'if (markerUL)'."\n";
									$scripttext .= '{'."\n";
									if ((int)$map->markerlistcontent < 100) 
									{								
											$scripttext .= ' var markerLI = document.createElement(\'li\');'."\n";
											$scripttext .= ' markerLI.className = "zhgm-li-'.$markerlistcssstyle.'"'."\n";
											$scripttext .= ' var markerLIWrp = document.createElement(\'div\');'."\n";
											$scripttext .= ' markerLIWrp.className = "zhgm-li-wrp-'.$markerlistcssstyle.'"'."\n";
											$scripttext .= ' var markerASelWrp = document.createElement(\'div\');'."\n";
											$scripttext .= ' markerASelWrp.className = "zhgm-li-wrp-a-'.$markerlistcssstyle.'"'."\n";
											$scripttext .= ' var markerASel = document.createElement(\'a\');'."\n";
											$scripttext .= ' markerASel.className = "zhgm-li-a-'.$markerlistcssstyle.'"'."\n";
											$scripttext .= ' markerASel.href = \'javascript:void(0);\';'."\n";
											if ((int)$map->markerlistcontent == 0) 
											{
												$scripttext .= ' markerASel.innerHTML = \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-0-li-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 1) 
											{
												$scripttext .= ' markerASel.innerHTML = \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-1-lit-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";
												$scripttext .= ' var markerDSel = document.createElement(\'div\');'."\n";
												$scripttext .= ' markerDSel.className = "zhgm-1-liw-'.$markerlistcssstyle.'"'."\n";
												$scripttext .= ' markerDSel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDDesc'. $currentmarker->id.'" class="zhgm-1-lid-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->description), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 5) 
											{
												$scripttext .= ' markerASel.innerHTML = \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-5-lit-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";
												$scripttext .= ' var markerDSel = document.createElement(\'div\');'."\n";
												$scripttext .= ' markerDSel.className = "zhgm-5-liw-'.$markerlistcssstyle.'"'."\n";
												$scripttext .= ' markerDSel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDDesc'. $currentmarker->id.'" class="zhgm-5-lid-'.$markerlistcssstyle.'">'.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->descriptionhtml)).'</div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 2) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDWrp'. $currentmarker->id.'" class="zhgm-2-liw-icon-'.$markerlistcssstyle.'">\'+'."\n";
												$scripttext .= ' \'<div id="markerDIcon'. $currentmarker->id.'" class="zhgm-2-lii-icon-'.$markerlistcssstyle.'"><img src="'.$imgpathIcons.str_replace("#", "%23", $currentmarker->icontype).'.png" alt="" /></div>\'+'."\n";
												$scripttext .= ' \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-2-lit-icon-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'\'+'."\n";
												$scripttext .= ' \'</div></div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 3) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDWrp'. $currentmarker->id.'" class="zhgm-3-liw-icon-'.$markerlistcssstyle.'">\'+'."\n";
												$scripttext .= ' \'<div id="markerDIcon'. $currentmarker->id.'" class="zhgm-3-lii-icon-'.$markerlistcssstyle.'"><img src="'.$imgpathIcons.str_replace("#", "%23", $currentmarker->icontype).'.png" alt="" /></div>\'+'."\n";
												$scripttext .= ' \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-3-lit-icon-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";
												$scripttext .= ' var markerDSel = document.createElement(\'div\');'."\n";
												$scripttext .= ' markerDSel.className = "zhgm-3-liwd-icon-'.$markerlistcssstyle.'"'."\n";
												$scripttext .= ' markerDSel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDDesc'. $currentmarker->id.'" class="zhgm-3-lid-icon-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->description), ENT_QUOTES, 'UTF-8').'</div>\'+'."\n";
												$scripttext .= ' \'</div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 6) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDWrp'. $currentmarker->id.'" class="zhgm-6-liw-icon-'.$markerlistcssstyle.'">\'+'."\n";
												$scripttext .= ' \'<div id="markerDIcon'. $currentmarker->id.'" class="zhgm-6-lii-icon-'.$markerlistcssstyle.'"><img src="'.$imgpathIcons.str_replace("#", "%23", $currentmarker->icontype).'.png" alt="" /></div>\'+'."\n";
												$scripttext .= ' \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-6-lit-icon-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";
												$scripttext .= ' var markerDSel = document.createElement(\'div\');'."\n";
												$scripttext .= ' markerDSel.className = "zhgm-6-liwd-icon-'.$markerlistcssstyle.'"'."\n";
												$scripttext .= ' markerDSel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDDesc'. $currentmarker->id.'" class="zhgm-6-lid-icon-'.$markerlistcssstyle.'">'.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->descriptionhtml)).'</div>\'+'."\n";
												$scripttext .= ' \'</div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 4) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'';									
												$scripttext .= '<table class="zhgm-4-table-icon-'.$markerlistcssstyle.'">';
												$scripttext .= '<tbody>';
												$scripttext .= '<tr class="zhgm-4-row-icon-'.$markerlistcssstyle.'">';
												$scripttext .= '<td rowspan=2 class="zhgm-4-tdicon-icon-'.$markerlistcssstyle.'">';
												$scripttext .= '<img src="'.$imgpathIcons.str_replace("#", "%23", $currentmarker->icontype).'.png" alt="" />';
												$scripttext .= '</td>';
												$scripttext .= '<td class="zhgm-4-tdtitle-icon-'.$markerlistcssstyle.'">';
												$scripttext .= htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8');
												$scripttext .= '</td>';
												$scripttext .= '</tr>';
												$scripttext .= '<tr>';
												$scripttext .= '<td class="zhgm-4-tddesc-icon-'.$markerlistcssstyle.'">';
												$scripttext .= htmlspecialchars(str_replace('\\', '/', $currentmarker->description), ENT_QUOTES, 'UTF-8');
												$scripttext .= '</td>';
												$scripttext .= '</tr>';
												$scripttext .= '</tbody>';
												$scripttext .= '</table>';
												$scripttext .= ' \';'."\n";
											}
											else if ((int)$map->markerlistcontent == 7) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'';									
												$scripttext .= '<table class="zhgm-7-table-icon-'.$markerlistcssstyle.'">';
												$scripttext .= '<tbody>';
												$scripttext .= '<tr class="zhgm-7-row-icon-'.$markerlistcssstyle.'">';
												$scripttext .= '<td rowspan=2 class="zhgm-7-tdicon-icon-'.$markerlistcssstyle.'">';
												$scripttext .= '<img src="'.$imgpathIcons.str_replace("#", "%23", $currentmarker->icontype).'.png" alt="" />';
												$scripttext .= '</td>';
												$scripttext .= '<td class="zhgm-7-tdtitle-icon-'.$markerlistcssstyle.'">';
												$scripttext .= htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8');
												$scripttext .= '</td>';
												$scripttext .= '</tr>';
												$scripttext .= '<tr>';
												$scripttext .= '<td class="zhgm-7-tddesc-icon-'.$markerlistcssstyle.'">';
												$scripttext .= str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->descriptionhtml));
												$scripttext .= '</td>';
												$scripttext .= '</tr>';
												$scripttext .= '</tbody>';
												$scripttext .= '</table>';
												$scripttext .= ' \';'."\n";
											}
											else if ((int)$map->markerlistcontent == 11) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDWrp'. $currentmarker->id.'" class="zhgm-11-liw-image-'.$markerlistcssstyle.'">\'+'."\n";
												$scripttext .= ' \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-11-lit-image-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\'+'."\n";
												$scripttext .= ' \'<div id="markerDImage'. $currentmarker->id.'" class="zhgm-11-lii-image-'.$markerlistcssstyle.'"><img src="'.$currentmarker->hrefimagethumbnail.'" alt="" />\'+'."\n";
												$scripttext .= ' \'</div></div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 12) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDWrp'. $currentmarker->id.'" class="zhgm-12-liw-image-'.$markerlistcssstyle.'">\'+'."\n";
												$scripttext .= ' \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-12-lit-image-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\'+'."\n";
												$scripttext .= ' \'<div id="markerDImage'. $currentmarker->id.'" class="zhgm-12-lii-image-'.$markerlistcssstyle.'"><img src="'.$currentmarker->hrefimagethumbnail.'" alt="" /></div>\';'."\n";
												$scripttext .= ' var markerDSel = document.createElement(\'div\');'."\n";
												$scripttext .= ' markerDSel.className = "zhgm-12-liwd-image-'.$markerlistcssstyle.'"'."\n";
												$scripttext .= ' markerDSel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDDesc'. $currentmarker->id.'" class="zhgm-12-lid-image-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->description), ENT_QUOTES, 'UTF-8').'</div>\'+'."\n";
												$scripttext .= ' \'</div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 16) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDWrp'. $currentmarker->id.'" class="zhgm-16-liw-image-'.$markerlistcssstyle.'">\'+'."\n";
												$scripttext .= ' \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-16-lit-image-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\'+'."\n";
												$scripttext .= ' \'<div id="markerDImage'. $currentmarker->id.'" class="zhgm-16-lii-image-'.$markerlistcssstyle.'"><img src="'.$currentmarker->hrefimagethumbnail.'" alt="" /></div>\';'."\n";
												$scripttext .= ' var markerDSel = document.createElement(\'div\');'."\n";
												$scripttext .= ' markerDSel.className = "zhgm-16-liwd-image-'.$markerlistcssstyle.'"'."\n";
												$scripttext .= ' markerDSel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDDesc'. $currentmarker->id.'" class="zhgm-16-lid-image-'.$markerlistcssstyle.'">'.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->descriptionhtml)).'</div>\'+'."\n";
												$scripttext .= ' \'</div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 13) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDWrp'. $currentmarker->id.'" class="zhgm-13-liw-image-'.$markerlistcssstyle.'">\'+'."\n";
												$scripttext .= ' \'<div id="markerDImage'. $currentmarker->id.'" class="zhgm-13-lii-image-'.$markerlistcssstyle.'"><img src="'.$currentmarker->hrefimagethumbnail.'" alt="" /></div>\'+'."\n";
												$scripttext .= ' \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-13-lit-image-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'\'+'."\n";
												$scripttext .= ' \'</div></div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 14) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDWrp'. $currentmarker->id.'" class="zhgm-14-liw-image-'.$markerlistcssstyle.'">\'+'."\n";
												$scripttext .= ' \'<div id="markerDImage'. $currentmarker->id.'" class="zhgm-14-lii-image-'.$markerlistcssstyle.'"><img src="'.$currentmarker->hrefimagethumbnail.'" alt="" /></div>\'+'."\n";
												$scripttext .= ' \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-14-lit-image-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";
												$scripttext .= ' var markerDSel = document.createElement(\'div\');'."\n";
												$scripttext .= ' markerDSel.className = "zhgm-14-liwd-image-'.$markerlistcssstyle.'"'."\n";
												$scripttext .= ' markerDSel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDDesc'. $currentmarker->id.'" class="zhgm-14-lid-image-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->description), ENT_QUOTES, 'UTF-8').'</div>\'+'."\n";
												$scripttext .= ' \'</div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 17) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDWrp'. $currentmarker->id.'" class="zhgm-17-liw-image-'.$markerlistcssstyle.'">\'+'."\n";
												$scripttext .= ' \'<div id="markerDImage'. $currentmarker->id.'" class="zhgm-17-lii-image-'.$markerlistcssstyle.'"><img src="'.$currentmarker->hrefimagethumbnail.'" alt="" /></div>\'+'."\n";
												$scripttext .= ' \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-17-lit-image-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";
												$scripttext .= ' var markerDSel = document.createElement(\'div\');'."\n";
												$scripttext .= ' markerDSel.className = "zhgm-17-liwd-image-'.$markerlistcssstyle.'"'."\n";
												$scripttext .= ' markerDSel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDDesc'. $currentmarker->id.'" class="zhgm-17-lid-image-'.$markerlistcssstyle.'">'.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->descriptionhtml)).'</div>\'+'."\n";
												$scripttext .= ' \'</div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 15) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'';									
												$scripttext .= '<table class="zhgm-15-table-image-'.$markerlistcssstyle.'">';
												$scripttext .= '<tbody>';
												$scripttext .= '<tr class="zhgm-15-row-image-'.$markerlistcssstyle.'">';
												$scripttext .= '<td rowspan=2 class="zhgm-15-tdicon-image-'.$markerlistcssstyle.'">';
												$scripttext .= '<img src="'.$currentmarker->hrefimagethumbnail.'" alt="" />';
												$scripttext .= '</td>';
												$scripttext .= '<td class="zhgm-15-tdtitle-image-'.$markerlistcssstyle.'">';
												$scripttext .= htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8');
												$scripttext .= '</td>';
												$scripttext .= '</tr>';
												$scripttext .= '<tr>';
												$scripttext .= '<td class="zhgm-15-tddesc-image-'.$markerlistcssstyle.'">';
												$scripttext .= htmlspecialchars(str_replace('\\', '/', $currentmarker->description), ENT_QUOTES, 'UTF-8');
												$scripttext .= '</td>';
												$scripttext .= '</tr>';
												$scripttext .= '</tbody>';
												$scripttext .= '</table>';
												$scripttext .= ' \';'."\n";
											}
											else if ((int)$map->markerlistcontent == 18) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'';									
												$scripttext .= '<table class="zhgm-18-table-image-'.$markerlistcssstyle.'">';
												$scripttext .= '<tbody>';
												$scripttext .= '<tr class="zhgm-18-row-image-'.$markerlistcssstyle.'">';
												$scripttext .= '<td rowspan=2 class="zhgm-18-tdicon-image-'.$markerlistcssstyle.'">';
												$scripttext .= '<img src="'.$currentmarker->hrefimagethumbnail.'" alt="" />';
												$scripttext .= '</td>';
												$scripttext .= '<td class="zhgm-18-tdtitle-image-'.$markerlistcssstyle.'">';
												$scripttext .= htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8');
												$scripttext .= '</td>';
												$scripttext .= '</tr>';
												$scripttext .= '<tr>';
												$scripttext .= '<td class="zhgm-18-tddesc-image-'.$markerlistcssstyle.'">';
												$scripttext .= str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->descriptionhtml));
												$scripttext .= '</td>';
												$scripttext .= '</tr>';
												$scripttext .= '</tbody>';
												$scripttext .= '</table>';
												$scripttext .= ' \';'."\n";
											}
											else
											{
												$scripttext .= ' markerASel.innerHTML = \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-0-li-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";
											}


											if ((int)$map->markerlistaction == 0) 
											{
												$scripttext .= ' markerASel.onclick = function(){ map.setCenter(latlng'. $currentmarker->id.')};'."\n";
											}
											else if ((int)$map->markerlistaction == 1) 
											{
												$scripttext .= ' markerASel.onclick = function(){ google.maps.event.trigger(marker'. $currentmarker->id.', "click")};'."\n";
											}
											else
											{
												$scripttext .= ' markerASel.onclick = function(){ map.setCenter(latlng'. $currentmarker->id.')};'."\n";
											}

											$scripttext .= ' markerASelWrp.appendChild(markerASel);'."\n";
											$scripttext .= ' markerLIWrp.appendChild(markerASelWrp);'."\n";
											if ((int)$map->markerlistcontent == 1
											 || (int)$map->markerlistcontent == 5) 
											{
												$scripttext .= ' markerLIWrp.appendChild(markerDSel);'."\n";
											}
											else if ((int)$map->markerlistcontent == 3
											      || (int)$map->markerlistcontent == 6) 
											{
												$scripttext .= ' markerLIWrp.appendChild(markerDSel);'."\n";
											}
											else if ((int)$map->markerlistcontent == 12
											      || (int)$map->markerlistcontent == 16) 
											{
												$scripttext .= ' markerLIWrp.appendChild(markerDSel);'."\n";
											}
											else if ((int)$map->markerlistcontent == 14
											      || (int)$map->markerlistcontent == 17) 
											{
												$scripttext .= ' markerLIWrp.appendChild(markerDSel);'."\n";
											}
											
											
											$scripttext .= ' markerLI.appendChild(markerLIWrp);'."\n";
											$scripttext .= ' markerUL.appendChild(markerLI);'."\n";
									}
									else
									{
											$scripttext .= ' var markerLI = document.createElement(\'tr\');'."\n";
											$scripttext .= ' markerLI.className = "zhgm-li-table-tr-'.$markerlistcssstyle.'"'."\n";
											$scripttext .= ' var markerLI_C1 = document.createElement(\'td\');'."\n";
											$scripttext .= ' markerLI_C1.className = "zhgm-li-table-c1-'.$markerlistcssstyle.'"'."\n";
											$scripttext .= ' var markerASelWrp = document.createElement(\'div\');'."\n";
											$scripttext .= ' markerASelWrp.className = "zhgm-li-table-a-wrp-'.$markerlistcssstyle.'"'."\n";
											$scripttext .= ' var markerASel = document.createElement(\'a\');'."\n";
											$scripttext .= ' markerASel.className = "zhgm-li-table-a-'.$markerlistcssstyle.'"'."\n";
											$scripttext .= ' markerASel.href = \'javascript:void(0);\';'."\n";
											if ((int)$map->markerlistcontent == 101) 
											{
												$scripttext .= ' markerASel.innerHTML = \'<div id="markerASelTable'. $currentmarker->id.'" class="zhgm-101-td-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 102) 
											{
												$scripttext .= ' markerASel.innerHTML = \'<div id="markerASelTable'. $currentmarker->id.'" class="zhgm-102-td1-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";

												$scripttext .= ' var markerLI_C2 = document.createElement(\'td\');'."\n";
												$scripttext .= ' markerLI_C2.className = "zhgm-li-table-c2-'.$markerlistcssstyle.'"'."\n";
												$scripttext .= ' var markerDSel = document.createElement(\'div\');'."\n";
												$scripttext .= ' markerDSel.className = "zhgm-li-table-desc2-'.$markerlistcssstyle.'"'."\n";
												$scripttext .= ' markerDSel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDDescTable'. $currentmarker->id.'" class="zhgm-102-td2-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->description), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 103) 
											{
												$scripttext .= ' markerASel.innerHTML = \'<div id="markerASelTable'. $currentmarker->id.'" class="zhgm-103-td1-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";

												$scripttext .= ' var markerLI_C2 = document.createElement(\'td\');'."\n";
												$scripttext .= ' markerLI_C2.className = "zhgm-li-table-c3-'.$markerlistcssstyle.'"'."\n";
												$scripttext .= ' var markerDSel = document.createElement(\'div\');'."\n";
												$scripttext .= ' markerDSel.className = "zhgm-li-table-desc3-'.$markerlistcssstyle.'"'."\n";
												$scripttext .= ' markerDSel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDDescTable'. $currentmarker->id.'" class="zhgm-103-td2-'.$markerlistcssstyle.'">'.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->descriptionhtml)).'</div>\';'."\n";
											}
											
											if ((int)$map->markerlistaction == 0) 
											{
												$scripttext .= ' markerASel.onclick = function(){ map.setCenter(latlng'. $currentmarker->id.')};'."\n";
											}
											else if ((int)$map->markerlistaction == 1) 
											{
												$scripttext .= ' markerASel.onclick = function(){ google.maps.event.trigger(marker'. $currentmarker->id.', "click")};'."\n";
											}
											else
											{
												$scripttext .= ' markerASel.onclick = function(){ map.setCenter(latlng'. $currentmarker->id.')};'."\n";
											}

											$scripttext .= ' markerASelWrp.appendChild(markerASel);'."\n";
											$scripttext .= ' markerLI_C1.appendChild(markerASelWrp);'."\n";
											if ((int)$map->markerlistcontent == 102
											 || (int)$map->markerlistcontent == 103) 
											{
												$scripttext .= ' markerLI_C2.appendChild(markerDSel);'."\n";
											}
											
											
											$scripttext .= ' markerLI.appendChild(markerLI_C1);'."\n";
											if ((int)$map->markerlistcontent == 102
											 || (int)$map->markerlistcontent == 103) 
											{
												$scripttext .= ' markerLI.appendChild(markerLI_C2);'."\n";
											}
											$scripttext .= ' markerUL.appendChild(markerLI);'."\n";
									}
									$scripttext .= '}'."\n";
								}
							}
							// Generating Placemark List - End
						}
									
						if ((int)$currentmarker->openbaloon == 1)
						{
							$lastmarker2open = $currentmarker;
						}
						
						// End marker creation with lat,lng
					}
					else
					{
						// Begin marker creation with address by geocoding
						$scripttext .= '  geocoder.geocode( { \'address\': "'.$currentmarker->addresstext.'"}, function(results, status) {'."\n";
      					$scripttext .= '  if (status == google.maps.GeocoderStatus.OK) {'."\n";
						$scripttext .= '    var latlng'. $currentmarker->id.' = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());' ."\n";
        				//$scripttext .= '    alert("Geocode was successful");'."\n";
        				//$scripttext .= '    alert("latlng="+latlng'. $currentmarker->id.');'."\n";

						// contentString - Begin
						if (($allowUserMarker == 0)
						 || (isset($currentmarker->userprotection) && (int)$currentmarker->userprotection == 1)
						 || ($currentUserID == 0)
						 || (isset($currentmarker->createdbyuser) 
						    && (((int)$currentmarker->createdbyuser != $currentUserID )
							   || ((int)$currentmarker->createdbyuser == 0)))
						 )
						{
							if (isset($map->useajax) && (int)$map->useajax == 1)
							{
								// do not create content string, create by loop only in the end
							}
							else
							{
								if ((int)$currentmarker->actionbyclick == 1)
								{
									$scripttext .= 'var contentString'. $currentmarker->id.' = '.
										modZhGoogleMapPlacemarksHelper::get_placemark_content_string(
											'',
											$currentmarker, $map->usercontact, $map->useruser,
											$userContactAttrs, $service_DoDirection,
											$imgpathIcons, $imgpathUtils, $directoryIcons);
								}
							}
						}
						else
						{
							// contentString - User Placemark can Update - Begin
							
							$scripttext .= get_UpdateContentString(
													$map->usermarkersicon, 
													$map->usercontact, 
													$currentmarker,
													$imgpathIcons, $imgpathUtils, $directoryIcons,
													$newMarkerGroupList
													);
													
							// contentString - User Placemark can Update - End
						}

						
						
						if ((int)$currentmarker->baloon != 0) 
						{

							// Infographics
							if (((int)$currentmarker->baloon == 11)
							  || ((int)$currentmarker->baloon == 12)
							  || ((int)$currentmarker->baloon == 13))
							{
							  //if (isset($currentmarker->infographicstype) && $currentmarker->infographicstype != "")
							  //{
								 $scripttext .= 'var imageUrl'.$currentmarker->id.' = \'http://chart.googleapis.com/chart?';
								 $scripttext .= str_replace('\'','\\\'', $currentmarker->infographicstype).'\';'."\n";
								 $scripttext .= 'var markerImage'.$currentmarker->id.' = new google.maps.MarkerImage(imageUrl'.$currentmarker->id;
								 if ((int)$currentmarker->infographicswidth != 0
									 && (int)$currentmarker->infographicsheight != 0)
								 {
									 $scripttext .= ', new google.maps.Size('.(int)$currentmarker->infographicswidth.','.(int)$currentmarker->infographicsheight.')';
								 }
								 $scripttext .= ');'."\n";
							  //}     
							}								  

							$scripttext .= '  var marker'. $currentmarker->id.' = new google.maps.Marker({' ."\n";
							$scripttext .= '      position: latlng'. $currentmarker->id.', ' ."\n";

							if ((isset($map->markercluster) && (int)$map->markercluster == 0)
							   && (isset($map->markermanager) && (int)$map->markermanager == 0))
							{
									$scripttext .= '      map: map, ' ."\n";
							}

							if ((int)$currentmarker->overridemarkericon == 0)
							{
								switch ((int)$currentmarker->baloon) 
								{
								case 1:
									// DROP
									$scripttext .= '      icon: icoIcon + "'.str_replace("#", "%23", $currentmarker->icontype).'.png", ' ."\n";
								break;
								case 2:
									// BOUNCE
									$scripttext .= '      icon: icoIcon + "'.str_replace("#", "%23", $currentmarker->icontype).'.png", ' ."\n";
								break;
								case 3:
									// SIMPLE
									$scripttext .= '      icon: icoIcon + "'.str_replace("#", "%23", $currentmarker->icontype).'.png", ' ."\n";
								break;
								case 11:
									// DROP INFOGRAPHICS									  
									if (isset($currentmarker->infographicstype) && $currentmarker->infographicstype != "")
									{
										$scripttext .=  '      icon: markerImage'.$currentmarker->id.','."\n";
									}
									else
									{
										$scripttext .= '      icon: icoIcon + "'.str_replace("#", "%23", $currentmarker->icontype).'.png", ' ."\n";
									}
								break;
								case 12:
									// BOUNCE INFOGRAPHICS
									if (isset($currentmarker->infographicstype) && $currentmarker->infographicstype != "")
									{
										$scripttext .=  '      icon: markerImage'.$currentmarker->id.','."\n";
									}
									else
									{
										$scripttext .= '      icon: icoIcon + "'.str_replace("#", "%23", $currentmarker->icontype).'.png", ' ."\n";
									}
								break;
								case 13:
									// SIMPLE INFOGRAPHICS
									if (isset($currentmarker->infographicstype) && $currentmarker->infographicstype != "")
									{
										$scripttext .=  '      icon: markerImage'.$currentmarker->id.','."\n";
									}
									else
									{
										$scripttext .= '      icon: icoIcon + "'.str_replace("#", "%23", $currentmarker->icontype).'.png", ' ."\n";
									}
								break;
								default:
									$scripttext .= '      icon: icoIcon + "'.str_replace("#", "%23", $currentmarker->icontype).'.png", ' ."\n";
								break;
								}
							}	
							else
							{
								$scripttext .= '      icon: icoIcon + "'.str_replace("#", "%23", $currentmarker->groupicontype).'.png", ' ."\n";
							}


							switch ($currentmarker->baloon) 
							{
							case 1:
									$scripttext .= '      animation: google.maps.Animation.DROP,' ."\n";
							break;
							case 2:
									$scripttext .= '      animation: google.maps.Animation.BOUNCE,' ."\n";
							break;
							case 3:
									$scripttext .= '' ."\n";
							break;
							case 11:
									$scripttext .= '      animation: google.maps.Animation.DROP,' ."\n";
							break;
							case 12:
									$scripttext .= '      animation: google.maps.Animation.BOUNCE,' ."\n";
							break;
							case 13:
									$scripttext .= '' ."\n";
							break;
							default:
									$scripttext .= '' ."\n";
							break;
							}

							if (($allowUserMarker == 0)
							 || (isset($currentmarker->userprotection) && (int)$currentmarker->userprotection == 1)
							 || ($currentUserID == 0)
							 || (isset($currentmarker->createdbyuser) 
								&& (((int)$currentmarker->createdbyuser != $currentUserID )
								   || ((int)$currentmarker->createdbyuser == 0))))
							{
									$scripttext .= 'draggable: false,' ."\n";
							}
							else
							{
									$scripttext .= 'draggable: true,' ."\n";
							}
							
							// Replace to new, because all charters are shown
							//$scripttext .= '      title:"'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'"' ."\n";
							if (isset($currentmarker->markercontent) &&
								(((int)$currentmarker->markercontent == 0) ||
								 ((int)$currentmarker->markercontent == 1))
								)
							{
								$scripttext .= '      title:"'.str_replace('\\', '/', str_replace('"', '\'\'', $currentmarker->title)).'"' ."\n";
							}
							else
							{
								$scripttext .= '      title:""' ."\n";
							}
							$scripttext .= '});'."\n";

							$scripttext .= '  marker'. $currentmarker->id.'.set("zhgmPlacemarkID", '.$currentmarker->id.');' ."\n";
							$scripttext .= '  marker'. $currentmarker->id.'.set("zhgmContactAttrs", userContactAttrs);' ."\n";
							$scripttext .= '  marker'. $currentmarker->id.'.set("zhgmUserContact", "'.str_replace(';', ',', $map->usercontact).'");' ."\n";
							$scripttext .= '  marker'. $currentmarker->id.'.set("zhgmUserUser", "'.str_replace(';', ',', $map->useruser).'");' ."\n";
							
							//  If user can change placemark - override content string - begin
							//  override content string
							if (($allowUserMarker == 0)
							 || (isset($currentmarker->userprotection) && (int)$currentmarker->userprotection == 1)
							 || ($currentUserID == 0)
							 || (isset($currentmarker->createdbyuser) 
								&& (((int)$currentmarker->createdbyuser != $currentUserID )
								   || ((int)$currentmarker->createdbyuser == 0)))
							 )
							{
								if (isset($map->useajax) && (int)$map->useajax == 1)
								{
									$scripttext .= '  ajaxmarkersADR.push(marker'. $currentmarker->id.');'."\n";
									
									$scripttext .= '    google.maps.event.addListener(marker'.$currentmarker->id.', \'click\', function(event) {' ."\n";
									$scripttext .= 'var url=\'index.php?option=com_zhgooglemap&amp;format=raw&amp;task=getPlacemarkDetails\';' ."\n";
									$scripttext .= 'var data = \'id=\'+this.get("zhgmPlacemarkID")';
									$scripttext .= '+\'&amp;contactattrs=\'+this.get("zhgmContactAttrs")';
									$scripttext .= '+\'&amp;usercontact=\'+this.get("zhgmUserContact")';
									$scripttext .= '+\'&amp;useruser=\'+this.get("zhgmUserUser")';
									$scripttext .= '+\'&amp;servicedirection=\'+'.$service_DoDirection;
									$scripttext .= '+\'&amp;iconicon=\'+icoIcon';
									$scripttext .= '+\'&amp;iconutil=\'+icoUtils';
									$scripttext .= '+\'&amp;icondir=\'+icoDir';
									$scripttext .= ';' ."\n";
									$scripttext .= 'var markerObject = this;' ."\n";
									$scripttext .= 'var request = new Request({' ."\n";
									$scripttext .= 'url: url,' ."\n";
									$scripttext .= 'method:\'get\',' ."\n";
									$scripttext .= 'data: data,' ."\n";
									$scripttext .= 'async: false,' ."\n";
									$scripttext .= 'onSuccess: function(responseText){' ."\n";
									$scripttext .= '	var toShowLoading = document.getElementById("GMapsLoading");' ."\n";
									$scripttext .= '	toShowLoading.style.display = \'none\';' ."\n";
									$scripttext .= '	var responseObject = JSON.decode(responseText);' ."\n";	
									//$scripttext .= '	alert(responseText);' ."\n";										
									$scripttext .= '	ShowPlacemarkInformation(responseObject, markerObject);' ."\n";
									$scripttext .= '},' ."\n";
									$scripttext .= 'onRequest: function(){' ."\n";
									$scripttext .= '	var toShowLoading = document.getElementById("GMapsLoading");' ."\n";
									$scripttext .= '	toShowLoading.style.display = \'block\';' ."\n";
									$scripttext .= '},' ."\n";
									$scripttext .= 'onFailure: function(xhr){' ."\n";
									$scripttext .= '	var toShowLoading = document.getElementById("GMapsLoading");' ."\n";
									$scripttext .= '	toShowLoading.style.display = \'none\';' ."\n";
									$scripttext .= '	alert(xhr.status +\',\'+xhr.statusText+\',\'+xhr.responseText);' ."\n";
									$scripttext .= '}' ."\n";
									$scripttext .= '}).send();' ."\n";

									$scripttext .= '    });' ."\n";
								}
								else
								{
								// Action By Click - Begin
								switch ((int)$currentmarker->actionbyclick)
								{
									// None
									case 0:
										if ((int)$currentmarker->zoombyclick != 100)
										{
											$scripttext .= '  google.maps.event.addListener(marker'. $currentmarker->id.', \'click\', function(event) {' ."\n";
											$scripttext .= '  map.setCenter(latlng'. $currentmarker->id.');' ."\n";
											$scripttext .= '  map.setZoom('.(int)$currentmarker->zoombyclick.');' ."\n";
											$scripttext .= '  });' ."\n";
										}
									break;
									// Info
									case 1:
											$scripttext .= '  google.maps.event.addListener(marker'. $currentmarker->id.', \'click\', function(event) {' ."\n";
											if ((int)$currentmarker->zoombyclick != 100)
											{
												$scripttext .= '  map.setCenter(latlng'. $currentmarker->id.');' ."\n";
												$scripttext .= '  map.setZoom('.(int)$currentmarker->zoombyclick.');' ."\n";
											}
												$scripttext .= '  infowindow.close();' ."\n";
												// Close the other infobubbles
												$scripttext .= '  for (i = 0; i < infobubblemarkers.length; i++) {' ."\n";
												$scripttext .= '      infobubblemarkers[i].close();' ."\n";
												$scripttext .= '  }' ."\n";
												// Open Infowin
												$scripttext .= '  infowindow.set("zhgmPlacemarkTitle", titlePlacemark'. $currentmarker->id.');' ."\n";
												$scripttext .= '  infowindow.setContent(contentString'. $currentmarker->id.');' ."\n";
												$scripttext .= '  infowindow.setPosition(latlng'. $currentmarker->id.');' ."\n";
												$scripttext .= '  infowindow.open(map);' ."\n";
											$scripttext .= '  });' ."\n";
									break;
									// Link
									case 2:
										if ($currentmarker->hrefsite != "")
										{
											$scripttext .= '  google.maps.event.addListener(marker'. $currentmarker->id.', \'click\', function(event) {' ."\n";
											if ((int)$currentmarker->zoombyclick != 100)
											{
												$scripttext .= '  map.setCenter(latlng'. $currentmarker->id.');' ."\n";
												$scripttext .= '  map.setZoom('.(int)$currentmarker->zoombyclick.');' ."\n";
											}
											$scripttext .= '  window.open("'.$currentmarker->hrefsite.'");' ."\n";
											$scripttext .= '  });' ."\n";
										}
										else
										{
											if ((int)$currentmarker->zoombyclick != 100)
											{
												$scripttext .= '  google.maps.event.addListener(marker'. $currentmarker->id.', \'click\', function(event) {' ."\n";
												$scripttext .= '  map.setCenter(latlng'. $currentmarker->id.');' ."\n";
												$scripttext .= '  map.setZoom('.(int)$currentmarker->zoombyclick.');' ."\n";
												$scripttext .= '  });' ."\n";
											}
										}
									break;
									// Link in self
									case 3:
										if ($currentmarker->hrefsite != "")
										{
											$scripttext .= '  google.maps.event.addListener(marker'. $currentmarker->id.', \'click\', function(event) {' ."\n";
											if ((int)$currentmarker->zoombyclick != 100)
											{
												$scripttext .= '  map.setCenter(latlng'. $currentmarker->id.');' ."\n";
												$scripttext .= '  map.setZoom('.(int)$currentmarker->zoombyclick.');' ."\n";
											}
											$scripttext .= '  window.location = "'.$currentmarker->hrefsite.'";' ."\n";
											$scripttext .= '  });' ."\n";
										}
										else
										{
											if ((int)$currentmarker->zoombyclick != 100)
											{
												$scripttext .= '  google.maps.event.addListener(marker'. $currentmarker->id.', \'click\', function(event) {' ."\n";
												$scripttext .= '  map.setCenter(latlng'. $currentmarker->id.');' ."\n";
												$scripttext .= '  map.setZoom('.(int)$currentmarker->zoombyclick.');' ."\n";
												$scripttext .= '  });' ."\n";
											}
										}
									break;
									// InfoBubble
									case 4:
										// InfoBubble Create - Begin
										$scripttext .= '  infoBubble'. $currentmarker->id.' = new InfoBubble('."\n";
										$scripttext .= modZhGoogleMapPlacemarksHelper::get_placemark_infobubble_style_string($currentmarker);
										$scripttext .= '  );'."\n";

										$scripttext .= '  infobubblemarkers.push(infoBubble'. $currentmarker->id.');'."\n";
										
										if ($currentmarker->tab1 != "")
										{
											$scripttext .= '  infoBubble'. $currentmarker->id.'.addTab(\''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab1title)).'\', \''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab1)).'\');'."\n";
										}
										if ($currentmarker->tab2 != "")
										{
											$scripttext .= '  infoBubble'. $currentmarker->id.'.addTab(\''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab2title)).'\', \''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab2)).'\');'."\n";
										}
										if ($currentmarker->tab3 != "")
										{
											$scripttext .= '  infoBubble'. $currentmarker->id.'.addTab(\''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab3title)).'\', \''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab3)).'\');'."\n";
										}
										if ($currentmarker->tab4 != "")
										{
											$scripttext .= '  infoBubble'. $currentmarker->id.'.addTab(\''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab4title)).'\', \''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab4)).'\');'."\n";
										}
										if ($currentmarker->tab5 != "")
										{
											$scripttext .= '  infoBubble'. $currentmarker->id.'.addTab(\''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab5title)).'\', \''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab5)).'\');'."\n";
										}
										if ($currentmarker->tab6 != "")
										{
											$scripttext .= '  infoBubble'. $currentmarker->id.'.addTab(\''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab6title)).'\', \''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab6)).'\');'."\n";
										}
										if ($currentmarker->tab7 != "")
										{
											$scripttext .= '  infoBubble'. $currentmarker->id.'.addTab(\''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab7title)).'\', \''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab7)).'\');'."\n";
										}
										if ($currentmarker->tab8 != "")
										{
											$scripttext .= '  infoBubble'. $currentmarker->id.'.addTab(\''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab8title)).'\', \''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab8)).'\');'."\n";
										}
										if ($currentmarker->tab9 != "")
										{
											$scripttext .= '  infoBubble'. $currentmarker->id.'.addTab(\''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab9title)).'\', \''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->tab9)).'\');'."\n";
										}

										// InfoBubble Create - End
										$scripttext .= '  google.maps.event.addListener(marker'. $currentmarker->id.', \'click\', function(event) {' ."\n";
										if ((int)$currentmarker->zoombyclick != 100)
										{
											$scripttext .= '  map.setCenter(latlng'. $currentmarker->id.');' ."\n";
											$scripttext .= '  map.setZoom('.(int)$currentmarker->zoombyclick.');' ."\n";
										}
										$scripttext .= '  if (!infoBubble'. $currentmarker->id.'.isOpen())'."\n";
										$scripttext .= '  {'."\n";
										// Close the other infowin and infobubbles
										$scripttext .= '  infowindow.close();'."\n";
										$scripttext .= '  for (i = 0; i < infobubblemarkers.length; i++) {' ."\n";
										$scripttext .= '      infobubblemarkers[i].close();' ."\n";
										$scripttext .= '  }' ."\n";
										// Open infobubble
										$scripttext .= '  	infoBubble'. $currentmarker->id.'.open(map, marker'. $currentmarker->id.');'."\n";
										$scripttext .= '  }'."\n";
										$scripttext .= '  });' ."\n";
									break;
									// Open Street View
									case 5:
										if (isset($map->streetview) && (int)$map->streetview != 0) 
										{
											$scripttext .= '  google.maps.event.addListener(marker'. $currentmarker->id.', \'click\', function(event) {' ."\n";
											if ((int)$currentmarker->zoombyclick != 100)
											{
												$scripttext .= '  map.setCenter(latlng'. $currentmarker->id.');' ."\n";
												$scripttext .= '  map.setZoom('.(int)$currentmarker->zoombyclick.');' ."\n";
											}
											$scripttext .= '  panorama.setPosition(latlng'. $currentmarker->id.');' ."\n";
											$mapSV = modZhGoogleMapPlacemarksHelper::get_StreetViewOptions($currentmarker->streetviewstyleid);
											if ($mapSV != "")
											{
												$scripttext .= '  panorama.setPov('.$mapSV.');'."\n";
											}
											$scripttext .= '  });' ."\n";
										}
										else
										{
											$scripttext .= 'google.maps.event.addListener(marker'. $currentmarker->id.', \'click\', function(event) {' ."\n";
											if ((int)$currentmarker->zoombyclick != 100)
											{
												$scripttext .= '  map.setCenter(latlng'. $currentmarker->id.');' ."\n";
												$scripttext .= '  map.setZoom('.(int)$currentmarker->zoombyclick.');' ."\n";												
											}
											$mapSV = modZhGoogleMapPlacemarksHelper::get_StreetViewOptions($currentmarker->streetviewstyleid);
											$scripttext .= '  infowindow.close();' ."\n";
											$scripttext .= '  for (i = 0; i < infobubblemarkers.length; i++) {' ."\n";
											$scripttext .= '      infobubblemarkers[i].close();' ."\n";
											$scripttext .= '  }' ."\n";
											$scripttext .= '  infowindow.setPosition(latlng'. $currentmarker->id.');' ."\n";
											if ($mapSV == "")
											{
												$scripttext .= 'showPlacemarkPanorama('.$currentmarker->streetviewinfowinw.','.$currentmarker->streetviewinfowinh.', \'\');'."\n";
											}
											else
											{
												$scripttext .= 'showPlacemarkPanorama('.$currentmarker->streetviewinfowinw.','.$currentmarker->streetviewinfowinh.', '.$mapSV.');'."\n";
											}
 											$scripttext .= '});' ."\n";
										}
									break;
									default:
										$scripttext .= '' ."\n";
									break;
								}
								// Action By Click - End
								}
							}
							else
							{
								// Action By click for update placemark = Open InfoWin
									$scripttext .= '  google.maps.event.addListener(marker'. $currentmarker->id.', \'click\', function(event) {' ."\n";

									$scripttext .= 'var contentStringButtons'.$currentmarker->id.' = "" +' ."\n";
									$scripttext .= '    \'<hr />\'+' ."\n";					
									$scripttext .= '    \'<input name="markerlat" type="hidden" value="\'+latlng'. $currentmarker->id.'.lat() + \'" />\'+' ."\n";
									$scripttext .= '    \'<input name="markerlng" type="hidden" value="\'+latlng'.$currentmarker->id.'.lng() + \'" />\'+' ."\n";
									$scripttext .= '    \'<input name="marker_action" type="hidden" value="update" />\'+' ."\n";
									$scripttext .= '    \'<input name="markerid" type="hidden" value="'.$currentmarker->id.'" />\'+' ."\n";
									$scripttext .= '    \'<input name="contactid" type="hidden" value="'.$currentmarker->contactid.'" />\'+' ."\n";
									$scripttext .= '    \'<input name="markersubmit" type="submit" value="'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_BUTTON_UPDATE' ).'" />\'+' ."\n";
									$scripttext .= '    \'</form>\'+' ."\n";		
									$scripttext .= '\'</div>\'+'."\n";
									// Form Delete
									$scripttext .= '\'<div id="contentDeletePlacemark">\'+'."\n";
									$scripttext .= '    \'<form id="deletePlacemarkForm'.$currentmarker->id.'" action="'.JURI::current().'" method="post">\'+'."\n";
									$scripttext .= '    \'<input name="marker_action" type="hidden" value="delete" />\'+' ."\n";
									$scripttext .= '    \'<input name="markerid" type="hidden" value="'.$currentmarker->id.'" />\'+' ."\n";
									$scripttext .= '    \'<input name="contactid" type="hidden" value="'.$currentmarker->contactid.'" />\'+' ."\n";
									$scripttext .= '    \'<input name="markersubmit" type="submit" value="'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_BUTTON_DELETE' ).'" />\'+' ."\n";
									$scripttext .= '    \'</form>\'+' ."\n";		
									$scripttext .= '\'</div>\';'."\n";
									
									$scripttext .= '  infowindow.setContent(contentStringPart1'.$currentmarker->id.'+';
									$scripttext .= 'contentInsertPlacemarkIcon.replace(/insertPlacemarkForm/g,"updatePlacemarkForm'. $currentmarker->id.'")';
									$scripttext .= '.replace(\'"markericonimage" src="\', \'"markericonimage" src="'.$imgpathIcons.str_replace("#", "%23", $currentmarker->icontype).'.png"\')';
									$scripttext .= '.replace(\'<option value="'.$currentmarker->icontype.'">'.$currentmarker->icontype.'</option>\', \'<option value="'.$currentmarker->icontype.'" selected="selected">'.$currentmarker->icontype.'</option>\')';
									$scripttext .= '+';
									$scripttext .= 'contentStringPart2'.$currentmarker->id.'+';
									$scripttext .= 'contentStringButtons'.$currentmarker->id;
									$scripttext .= ');' ."\n";
									$scripttext .= '  infowindow.setPosition(latlng'. $currentmarker->id.');' ."\n";
									$scripttext .= '  infowindow.open(map);' ."\n";
									
									$scripttext .= '  });' ."\n";

									$scripttext .= '  google.maps.event.addListener(marker'. $currentmarker->id.', \'drag\', function(event) {' ."\n";

									$scripttext .= '	infowindow.close();' ."\n";
									$scripttext .= '	latlng'. $currentmarker->id.' = event.latLng;';
									
									$scripttext .= '  });' ."\n";


							}
							
							// If user can change placemark - override content string - end

							if ((isset($map->markergroupcontrol) && (int)$map->markergroupcontrol != 0))
							{
								if ((isset($map->markercluster) && (int)$map->markercluster == 1))
								{
									if ((isset($map->markerclustergroup) && (int)$map->markerclustergroup == 1))
									{
										$scripttext .= 'clustermarkers'.$currentmarker->markergroup.'.push(marker'. $currentmarker->id.');' ."\n";
										if ($currentmarker->activeincluster == 1
										|| $currentmarker->markergroup == 0)
										{
											$scripttext .= 'markerCluster'.$currentmarker->markergroup.'.addMarker(marker'. $currentmarker->id.');' ."\n";
										}
									}
									else
									{
										$scripttext .= 'clustermarkers'.$currentmarker->markergroup.'.push(marker'. $currentmarker->id.');' ."\n";
										if ($currentmarker->activeincluster == 1
										|| $currentmarker->markergroup == 0)
										{
											$scripttext .= 'markerCluster0.addMarker(marker'. $currentmarker->id.');' ."\n";
										}
									}
								}
								else
								{
									if ((isset($map->markerclustergroup) && (int)$map->markerclustergroup == 1))
									{
										$scripttext .= 'clustermarkers'.$currentmarker->markergroup.'.push(marker'. $currentmarker->id.');' ."\n";
										// No need add to cluster
									}
								}
							}
							else
							{
								if ((isset($map->markercluster) && (int)$map->markercluster == 1))
								{
									if ((isset($map->markerclustergroup) && (int)$map->markerclustergroup == 1))
									{
										$scripttext .= 'clustermarkers'.$currentmarker->markergroup.'.push(marker'. $currentmarker->id.');' ."\n";
										$scripttext .= 'markerCluster'.$currentmarker->markergroup.'.addMarker(marker'. $currentmarker->id.');' ."\n";
									}
									else
									{
										$scripttext .= 'clustermarkers0.push(marker'. $currentmarker->id.');' ."\n";
										$scripttext .= 'markerCluster0.addMarker(marker'. $currentmarker->id.');' ."\n";
									}
								}
								else
								{
									if ((isset($map->markerclustergroup) && (int)$map->markerclustergroup == 1))
									{
										$scripttext .= 'clustermarkers'.$currentmarker->markergroup.'.push(marker'. $currentmarker->id.');' ."\n";
										// No need add to cluster
									}
								}
							}

							if (  (isset($map->markermanager) && (int)$map->markermanager == 1)
							&& (isset($map->markercluster) && (int)$map->markercluster == 0)
							&& (isset($map->markergroupcontrol) && (int)$map->markergroupcontrol == 0)
							)
							{
								$scripttext .= 'mgrmarkers'.$currentmarker->markergroup.'.push(marker'. $currentmarker->id.');' ."\n";
								$scripttext .= 'mgrMarkerManager.addMarker(marker'. $currentmarker->id.','.(int)$currentmarker->markermanagerminzoom.','.(int)$currentmarker->markermanagermaxzoom.');' ."\n";
						    }

						
					
							//
							// Generate list elements for each marker.
							if (isset($map->markerlistpos) && (int)$map->markerlistpos != 0) 
							{						
								$doAddToList = 1;
															
								if ($doAddToList == 1)
								{
									$doAddToListCount += 1;
									$scripttext .= 'if (markerUL)'."\n";
									$scripttext .= '{'."\n";
									if ((int)$map->markerlistcontent < 100) 
									{								
											$scripttext .= ' var markerLI = document.createElement(\'li\');'."\n";
											$scripttext .= ' markerLI.className = "zhgm-li-'.$markerlistcssstyle.'"'."\n";
											$scripttext .= ' var markerLIWrp = document.createElement(\'div\');'."\n";
											$scripttext .= ' markerLIWrp.className = "zhgm-li-wrp-'.$markerlistcssstyle.'"'."\n";
											$scripttext .= ' var markerASelWrp = document.createElement(\'div\');'."\n";
											$scripttext .= ' markerASelWrp.className = "zhgm-li-wrp-a-'.$markerlistcssstyle.'"'."\n";
											$scripttext .= ' var markerASel = document.createElement(\'a\');'."\n";
											$scripttext .= ' markerASel.className = "zhgm-li-a-'.$markerlistcssstyle.'"'."\n";
											$scripttext .= ' markerASel.href = \'javascript:void(0);\';'."\n";
											if ((int)$map->markerlistcontent == 0) 
											{
												$scripttext .= ' markerASel.innerHTML = \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-0-li-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 1) 
											{
												$scripttext .= ' markerASel.innerHTML = \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-1-lit-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";
												$scripttext .= ' var markerDSel = document.createElement(\'div\');'."\n";
												$scripttext .= ' markerDSel.className = "zhgm-1-liw-'.$markerlistcssstyle.'"'."\n";
												$scripttext .= ' markerDSel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDDesc'. $currentmarker->id.'" class="zhgm-1-lid-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->description), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 5) 
											{
												$scripttext .= ' markerASel.innerHTML = \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-5-lit-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";
												$scripttext .= ' var markerDSel = document.createElement(\'div\');'."\n";
												$scripttext .= ' markerDSel.className = "zhgm-5-liw-'.$markerlistcssstyle.'"'."\n";
												$scripttext .= ' markerDSel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDDesc'. $currentmarker->id.'" class="zhgm-5-lid-'.$markerlistcssstyle.'">'.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->descriptionhtml)).'</div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 2) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDWrp'. $currentmarker->id.'" class="zhgm-2-liw-icon-'.$markerlistcssstyle.'">\'+'."\n";
												$scripttext .= ' \'<div id="markerDIcon'. $currentmarker->id.'" class="zhgm-2-lii-icon-'.$markerlistcssstyle.'"><img src="'.$imgpathIcons.str_replace("#", "%23", $currentmarker->icontype).'.png" alt="" /></div>\'+'."\n";
												$scripttext .= ' \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-2-lit-icon-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'\'+'."\n";
												$scripttext .= ' \'</div></div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 3) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDWrp'. $currentmarker->id.'" class="zhgm-3-liw-icon-'.$markerlistcssstyle.'">\'+'."\n";
												$scripttext .= ' \'<div id="markerDIcon'. $currentmarker->id.'" class="zhgm-3-lii-icon-'.$markerlistcssstyle.'"><img src="'.$imgpathIcons.str_replace("#", "%23", $currentmarker->icontype).'.png" alt="" /></div>\'+'."\n";
												$scripttext .= ' \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-3-lit-icon-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";
												$scripttext .= ' var markerDSel = document.createElement(\'div\');'."\n";
												$scripttext .= ' markerDSel.className = "zhgm-3-liwd-icon-'.$markerlistcssstyle.'"'."\n";
												$scripttext .= ' markerDSel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDDesc'. $currentmarker->id.'" class="zhgm-3-lid-icon-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->description), ENT_QUOTES, 'UTF-8').'</div>\'+'."\n";
												$scripttext .= ' \'</div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 6) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDWrp'. $currentmarker->id.'" class="zhgm-6-liw-icon-'.$markerlistcssstyle.'">\'+'."\n";
												$scripttext .= ' \'<div id="markerDIcon'. $currentmarker->id.'" class="zhgm-6-lii-icon-'.$markerlistcssstyle.'"><img src="'.$imgpathIcons.str_replace("#", "%23", $currentmarker->icontype).'.png" alt="" /></div>\'+'."\n";
												$scripttext .= ' \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-6-lit-icon-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";
												$scripttext .= ' var markerDSel = document.createElement(\'div\');'."\n";
												$scripttext .= ' markerDSel.className = "zhgm-6-liwd-icon-'.$markerlistcssstyle.'"'."\n";
												$scripttext .= ' markerDSel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDDesc'. $currentmarker->id.'" class="zhgm-6-lid-icon-'.$markerlistcssstyle.'">'.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->descriptionhtml)).'</div>\'+'."\n";
												$scripttext .= ' \'</div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 4) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'';									
												$scripttext .= '<table class="zhgm-4-table-icon-'.$markerlistcssstyle.'">';
												$scripttext .= '<tbody>';
												$scripttext .= '<tr class="zhgm-4-row-icon-'.$markerlistcssstyle.'">';
												$scripttext .= '<td rowspan=2 class="zhgm-4-tdicon-icon-'.$markerlistcssstyle.'">';
												$scripttext .= '<img src="'.$imgpathIcons.str_replace("#", "%23", $currentmarker->icontype).'.png" alt="" />';
												$scripttext .= '</td>';
												$scripttext .= '<td class="zhgm-4-tdtitle-icon-'.$markerlistcssstyle.'">';
												$scripttext .= htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8');
												$scripttext .= '</td>';
												$scripttext .= '</tr>';
												$scripttext .= '<tr>';
												$scripttext .= '<td class="zhgm-4-tddesc-icon-'.$markerlistcssstyle.'">';
												$scripttext .= htmlspecialchars(str_replace('\\', '/', $currentmarker->description), ENT_QUOTES, 'UTF-8');
												$scripttext .= '</td>';
												$scripttext .= '</tr>';
												$scripttext .= '</tbody>';
												$scripttext .= '</table>';
												$scripttext .= ' \';'."\n";
											}
											else if ((int)$map->markerlistcontent == 7) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'';									
												$scripttext .= '<table class="zhgm-7-table-icon-'.$markerlistcssstyle.'">';
												$scripttext .= '<tbody>';
												$scripttext .= '<tr class="zhgm-7-row-icon-'.$markerlistcssstyle.'">';
												$scripttext .= '<td rowspan=2 class="zhgm-7-tdicon-icon-'.$markerlistcssstyle.'">';
												$scripttext .= '<img src="'.$imgpathIcons.str_replace("#", "%23", $currentmarker->icontype).'.png" alt="" />';
												$scripttext .= '</td>';
												$scripttext .= '<td class="zhgm-7-tdtitle-icon-'.$markerlistcssstyle.'">';
												$scripttext .= htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8');
												$scripttext .= '</td>';
												$scripttext .= '</tr>';
												$scripttext .= '<tr>';
												$scripttext .= '<td class="zhgm-7-tddesc-icon-'.$markerlistcssstyle.'">';
												$scripttext .= str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->descriptionhtml));
												$scripttext .= '</td>';
												$scripttext .= '</tr>';
												$scripttext .= '</tbody>';
												$scripttext .= '</table>';
												$scripttext .= ' \';'."\n";
											}
											else if ((int)$map->markerlistcontent == 11) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDWrp'. $currentmarker->id.'" class="zhgm-11-liw-image-'.$markerlistcssstyle.'">\'+'."\n";
												$scripttext .= ' \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-11-lit-image-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\'+'."\n";
												$scripttext .= ' \'<div id="markerDImage'. $currentmarker->id.'" class="zhgm-11-lii-image-'.$markerlistcssstyle.'"><img src="'.$currentmarker->hrefimagethumbnail.'" alt="" />\'+'."\n";
												$scripttext .= ' \'</div></div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 12) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDWrp'. $currentmarker->id.'" class="zhgm-12-liw-image-'.$markerlistcssstyle.'">\'+'."\n";
												$scripttext .= ' \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-12-lit-image-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\'+'."\n";
												$scripttext .= ' \'<div id="markerDImage'. $currentmarker->id.'" class="zhgm-12-lii-image-'.$markerlistcssstyle.'"><img src="'.$currentmarker->hrefimagethumbnail.'" alt="" /></div>\';'."\n";
												$scripttext .= ' var markerDSel = document.createElement(\'div\');'."\n";
												$scripttext .= ' markerDSel.className = "zhgm-12-liwd-image-'.$markerlistcssstyle.'"'."\n";
												$scripttext .= ' markerDSel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDDesc'. $currentmarker->id.'" class="zhgm-12-lid-image-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->description), ENT_QUOTES, 'UTF-8').'</div>\'+'."\n";
												$scripttext .= ' \'</div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 16) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDWrp'. $currentmarker->id.'" class="zhgm-16-liw-image-'.$markerlistcssstyle.'">\'+'."\n";
												$scripttext .= ' \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-16-lit-image-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\'+'."\n";
												$scripttext .= ' \'<div id="markerDImage'. $currentmarker->id.'" class="zhgm-16-lii-image-'.$markerlistcssstyle.'"><img src="'.$currentmarker->hrefimagethumbnail.'" alt="" /></div>\';'."\n";
												$scripttext .= ' var markerDSel = document.createElement(\'div\');'."\n";
												$scripttext .= ' markerDSel.className = "zhgm-16-liwd-image-'.$markerlistcssstyle.'"'."\n";
												$scripttext .= ' markerDSel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDDesc'. $currentmarker->id.'" class="zhgm-16-lid-image-'.$markerlistcssstyle.'">'.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->descriptionhtml)).'</div>\'+'."\n";
												$scripttext .= ' \'</div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 13) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDWrp'. $currentmarker->id.'" class="zhgm-13-liw-image-'.$markerlistcssstyle.'">\'+'."\n";
												$scripttext .= ' \'<div id="markerDImage'. $currentmarker->id.'" class="zhgm-13-lii-image-'.$markerlistcssstyle.'"><img src="'.$currentmarker->hrefimagethumbnail.'" alt="" /></div>\'+'."\n";
												$scripttext .= ' \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-13-lit-image-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'\'+'."\n";
												$scripttext .= ' \'</div></div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 14) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDWrp'. $currentmarker->id.'" class="zhgm-14-liw-image-'.$markerlistcssstyle.'">\'+'."\n";
												$scripttext .= ' \'<div id="markerDImage'. $currentmarker->id.'" class="zhgm-14-lii-image-'.$markerlistcssstyle.'"><img src="'.$currentmarker->hrefimagethumbnail.'" alt="" /></div>\'+'."\n";
												$scripttext .= ' \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-14-lit-image-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";
												$scripttext .= ' var markerDSel = document.createElement(\'div\');'."\n";
												$scripttext .= ' markerDSel.className = "zhgm-14-liwd-image-'.$markerlistcssstyle.'"'."\n";
												$scripttext .= ' markerDSel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDDesc'. $currentmarker->id.'" class="zhgm-14-lid-image-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->description), ENT_QUOTES, 'UTF-8').'</div>\'+'."\n";
												$scripttext .= ' \'</div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 17) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDWrp'. $currentmarker->id.'" class="zhgm-17-liw-image-'.$markerlistcssstyle.'">\'+'."\n";
												$scripttext .= ' \'<div id="markerDImage'. $currentmarker->id.'" class="zhgm-17-lii-image-'.$markerlistcssstyle.'"><img src="'.$currentmarker->hrefimagethumbnail.'" alt="" /></div>\'+'."\n";
												$scripttext .= ' \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-17-lit-image-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";
												$scripttext .= ' var markerDSel = document.createElement(\'div\');'."\n";
												$scripttext .= ' markerDSel.className = "zhgm-17-liwd-image-'.$markerlistcssstyle.'"'."\n";
												$scripttext .= ' markerDSel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDDesc'. $currentmarker->id.'" class="zhgm-17-lid-image-'.$markerlistcssstyle.'">'.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->descriptionhtml)).'</div>\'+'."\n";
												$scripttext .= ' \'</div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 15) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'';									
												$scripttext .= '<table class="zhgm-15-table-image-'.$markerlistcssstyle.'">';
												$scripttext .= '<tbody>';
												$scripttext .= '<tr class="zhgm-15-row-image-'.$markerlistcssstyle.'">';
												$scripttext .= '<td rowspan=2 class="zhgm-15-tdicon-image-'.$markerlistcssstyle.'">';
												$scripttext .= '<img src="'.$currentmarker->hrefimagethumbnail.'" alt="" />';
												$scripttext .= '</td>';
												$scripttext .= '<td class="zhgm-15-tdtitle-image-'.$markerlistcssstyle.'">';
												$scripttext .= htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8');
												$scripttext .= '</td>';
												$scripttext .= '</tr>';
												$scripttext .= '<tr>';
												$scripttext .= '<td class="zhgm-15-tddesc-image-'.$markerlistcssstyle.'">';
												$scripttext .= htmlspecialchars(str_replace('\\', '/', $currentmarker->description), ENT_QUOTES, 'UTF-8');
												$scripttext .= '</td>';
												$scripttext .= '</tr>';
												$scripttext .= '</tbody>';
												$scripttext .= '</table>';
												$scripttext .= ' \';'."\n";
											}
											else if ((int)$map->markerlistcontent == 18) 
											{
												$scripttext .= ' markerASel.innerHTML = ';
												$scripttext .= ' \'';									
												$scripttext .= '<table class="zhgm-18-table-image-'.$markerlistcssstyle.'">';
												$scripttext .= '<tbody>';
												$scripttext .= '<tr class="zhgm-18-row-image-'.$markerlistcssstyle.'">';
												$scripttext .= '<td rowspan=2 class="zhgm-18-tdicon-image-'.$markerlistcssstyle.'">';
												$scripttext .= '<img src="'.$currentmarker->hrefimagethumbnail.'" alt="" />';
												$scripttext .= '</td>';
												$scripttext .= '<td class="zhgm-18-tdtitle-image-'.$markerlistcssstyle.'">';
												$scripttext .= htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8');
												$scripttext .= '</td>';
												$scripttext .= '</tr>';
												$scripttext .= '<tr>';
												$scripttext .= '<td class="zhgm-18-tddesc-image-'.$markerlistcssstyle.'">';
												$scripttext .= str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->descriptionhtml));
												$scripttext .= '</td>';
												$scripttext .= '</tr>';
												$scripttext .= '</tbody>';
												$scripttext .= '</table>';
												$scripttext .= ' \';'."\n";
											}
											else
											{
												$scripttext .= ' markerASel.innerHTML = \'<div id="markerASel'. $currentmarker->id.'" class="zhgm-0-li-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";
											}


											if ((int)$map->markerlistaction == 0) 
											{
												$scripttext .= ' markerASel.onclick = function(){ map.setCenter(latlng'. $currentmarker->id.')};'."\n";
											}
											else if ((int)$map->markerlistaction == 1) 
											{
												$scripttext .= ' markerASel.onclick = function(){ google.maps.event.trigger(marker'. $currentmarker->id.', "click")};'."\n";
											}
											else
											{
												$scripttext .= ' markerASel.onclick = function(){ map.setCenter(latlng'. $currentmarker->id.')};'."\n";
											}

											$scripttext .= ' markerASelWrp.appendChild(markerASel);'."\n";
											$scripttext .= ' markerLIWrp.appendChild(markerASelWrp);'."\n";
											if ((int)$map->markerlistcontent == 1
											 || (int)$map->markerlistcontent == 5) 
											{
												$scripttext .= ' markerLIWrp.appendChild(markerDSel);'."\n";
											}
											else if ((int)$map->markerlistcontent == 3
											      || (int)$map->markerlistcontent == 6) 
											{
												$scripttext .= ' markerLIWrp.appendChild(markerDSel);'."\n";
											}
											else if ((int)$map->markerlistcontent == 12
											      || (int)$map->markerlistcontent == 16) 
											{
												$scripttext .= ' markerLIWrp.appendChild(markerDSel);'."\n";
											}
											else if ((int)$map->markerlistcontent == 14
											      || (int)$map->markerlistcontent == 17) 
											{
												$scripttext .= ' markerLIWrp.appendChild(markerDSel);'."\n";
											}
											
											
											$scripttext .= ' markerLI.appendChild(markerLIWrp);'."\n";
											$scripttext .= ' markerUL.appendChild(markerLI);'."\n";
									}
									else
									{
											$scripttext .= ' var markerLI = document.createElement(\'tr\');'."\n";
											$scripttext .= ' markerLI.className = "zhgm-li-table-tr-'.$markerlistcssstyle.'"'."\n";
											$scripttext .= ' var markerLI_C1 = document.createElement(\'td\');'."\n";
											$scripttext .= ' markerLI_C1.className = "zhgm-li-table-c1-'.$markerlistcssstyle.'"'."\n";
											$scripttext .= ' var markerASelWrp = document.createElement(\'div\');'."\n";
											$scripttext .= ' markerASelWrp.className = "zhgm-li-table-a-wrp-'.$markerlistcssstyle.'"'."\n";
											$scripttext .= ' var markerASel = document.createElement(\'a\');'."\n";
											$scripttext .= ' markerASel.className = "zhgm-li-table-a-'.$markerlistcssstyle.'"'."\n";
											$scripttext .= ' markerASel.href = \'javascript:void(0);\';'."\n";
											if ((int)$map->markerlistcontent == 101) 
											{
												$scripttext .= ' markerASel.innerHTML = \'<div id="markerASelTable'. $currentmarker->id.'" class="zhgm-101-td-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 102) 
											{
												$scripttext .= ' markerASel.innerHTML = \'<div id="markerASelTable'. $currentmarker->id.'" class="zhgm-102-td1-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";

												$scripttext .= ' var markerLI_C2 = document.createElement(\'td\');'."\n";
												$scripttext .= ' markerLI_C2.className = "zhgm-li-table-c2-'.$markerlistcssstyle.'"'."\n";
												$scripttext .= ' var markerDSel = document.createElement(\'div\');'."\n";
												$scripttext .= ' markerDSel.className = "zhgm-li-table-desc2-'.$markerlistcssstyle.'"'."\n";
												$scripttext .= ' markerDSel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDDescTable'. $currentmarker->id.'" class="zhgm-102-td2-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->description), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";
											}
											else if ((int)$map->markerlistcontent == 103) 
											{
												$scripttext .= ' markerASel.innerHTML = \'<div id="markerASelTable'. $currentmarker->id.'" class="zhgm-103-td1-'.$markerlistcssstyle.'">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'</div>\';'."\n";

												$scripttext .= ' var markerLI_C2 = document.createElement(\'td\');'."\n";
												$scripttext .= ' markerLI_C2.className = "zhgm-li-table-c3-'.$markerlistcssstyle.'"'."\n";
												$scripttext .= ' var markerDSel = document.createElement(\'div\');'."\n";
												$scripttext .= ' markerDSel.className = "zhgm-li-table-desc3-'.$markerlistcssstyle.'"'."\n";
												$scripttext .= ' markerDSel.innerHTML = ';
												$scripttext .= ' \'<div id="markerDDescTable'. $currentmarker->id.'" class="zhgm-103-td2-'.$markerlistcssstyle.'">'.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->descriptionhtml)).'</div>\';'."\n";
											}
											
											if ((int)$map->markerlistaction == 0) 
											{
												$scripttext .= ' markerASel.onclick = function(){ map.setCenter(latlng'. $currentmarker->id.')};'."\n";
											}
											else if ((int)$map->markerlistaction == 1) 
											{
												$scripttext .= ' markerASel.onclick = function(){ google.maps.event.trigger(marker'. $currentmarker->id.', "click")};'."\n";
											}
											else
											{
												$scripttext .= ' markerASel.onclick = function(){ map.setCenter(latlng'. $currentmarker->id.')};'."\n";
											}

											$scripttext .= ' markerASelWrp.appendChild(markerASel);'."\n";
											$scripttext .= ' markerLI_C1.appendChild(markerASelWrp);'."\n";
											if ((int)$map->markerlistcontent == 102
											 || (int)$map->markerlistcontent == 103) 
											{
												$scripttext .= ' markerLI_C2.appendChild(markerDSel);'."\n";
											}
											
											
											$scripttext .= ' markerLI.appendChild(markerLI_C1);'."\n";
											if ((int)$map->markerlistcontent == 102
											 || (int)$map->markerlistcontent == 103) 
											{
												$scripttext .= ' markerLI.appendChild(markerLI_C2);'."\n";
											}
											$scripttext .= ' markerUL.appendChild(markerLI);'."\n";
									}
									$scripttext .= '}'."\n";
								}
							}
							// Generating Placemark List - End

						}
						
						if ((int)$currentmarker->openbaloon == 1)
						{
							$lastmarker2open = $currentmarker;
						}

						// End marker creation with address
      					$scripttext .= '  }'."\n";
						$scripttext .= '  else'."\n";
						$scripttext .= '  {'."\n";
        				$scripttext .= '    alert("'.JText::_('MOD_ZHGOOGLEMAP_MAPMARKER_GEOCODING_ERROR_REASON').': " + status + "\n" + "'.JText::_('MOD_ZHGOOGLEMAP_MAPMARKER_GEOCODING_ERROR_ADDRESS').': '.$currentmarker->addresstext.'" + "\n"+"id:'. $currentmarker->id.'");'."\n";
      					$scripttext .= '  }'."\n";
    					$scripttext .= '});'."\n";
					}
					

					
				}
				
				
			}
			// End restriction
		}
		// Main loop by markers - End
	
	}

	// Ajax Marker Listeners
	if (isset($map->useajax) && (int)$map->useajax == 1) 
	{
        $scripttext .= ' for (var i=0; i<ajaxmarkersLL.length; i++)' ."\n";
        $scripttext .= ' {' ."\n";
		//$scripttext .= '    alert("Call:"+ajaxmarkersLL[i].get("zhgmPlacemarkID"));' ."\n";
		$scripttext .= '    google.maps.event.addListener(ajaxmarkersLL[i], \'click\', function(event) {' ."\n";
		
		$scripttext .= 'var url=\'index.php?option=com_zhgooglemap&amp;format=raw&amp;task=getPlacemarkDetails\';' ."\n";
		$scripttext .= 'var data = \'id=\'+this.get("zhgmPlacemarkID")';
		$scripttext .= '+\'&amp;contactattrs=\'+this.get("zhgmContactAttrs")';
		$scripttext .= '+\'&amp;usercontact=\'+this.get("zhgmUserContact")';
		$scripttext .= '+\'&amp;useruser=\'+this.get("zhgmUserUser")';
		$scripttext .= '+\'&amp;servicedirection=\'+'.$service_DoDirection;
		$scripttext .= '+\'&amp;iconicon=\'+icoIcon';
		$scripttext .= '+\'&amp;iconutil=\'+icoUtils';
		$scripttext .= '+\'&amp;icondir=\'+icoDir';
		$scripttext .= ';' ."\n";
		$scripttext .= 'var markerObject = this;' ."\n";
		$scripttext .= 'var request = new Request({' ."\n";
		$scripttext .= 'url: url,' ."\n";
		$scripttext .= 'method:\'get\',' ."\n";
		$scripttext .= 'data: data,' ."\n";
		$scripttext .= 'async: false,' ."\n";
		$scripttext .= 'onSuccess: function(responseText){' ."\n";
		$scripttext .= '	var toShowLoading = document.getElementById("GMapsLoading");' ."\n";
		$scripttext .= '	toShowLoading.style.display = \'none\';' ."\n";
		$scripttext .= '	var responseObject = JSON.decode(responseText);' ."\n";
		$scripttext .= '	ShowPlacemarkInformation(responseObject, markerObject);' ."\n";
		$scripttext .= '},' ."\n";
		$scripttext .= 'onRequest: function(){' ."\n";
		$scripttext .= '	var toShowLoading = document.getElementById("GMapsLoading");' ."\n";
		$scripttext .= '	toShowLoading.style.display = \'block\';' ."\n";
		$scripttext .= '},' ."\n";
		$scripttext .= 'onFailure: function(xhr){' ."\n";
		$scripttext .= '	var toShowLoading = document.getElementById("GMapsLoading");' ."\n";
		$scripttext .= '	toShowLoading.style.display = \'none\';' ."\n";
		$scripttext .= '	alert(xhr.status +\',\'+xhr.statusText+\',\'+xhr.responseText);' ."\n";
		$scripttext .= '}' ."\n";
		$scripttext .= '}).send();' ."\n";

        $scripttext .= '    });' ."\n";

        $scripttext .= ' }' ."\n";
	   
	}

	// Execute Action - Open InfoWin and etc
	if (isset($lastmarker2open)
	&& (isset($map->useajax) && (int)$map->useajax == 0))
	{
		if ((int)$lastmarker2open->baloon != 0)
		{
			switch ((int)$lastmarker2open->actionbyclick)
			{
				case 0:
					$scripttext .= '  infowindow.close();' ."\n";
					$scripttext .= '  infowindow.setPosition(latlng'. $lastmarker2open->id.');' ."\n";
					$scripttext .= '  google.maps.event.trigger(marker'. $lastmarker2open->id.', "click");' ."\n";
				break;
				case 1:
					$scripttext .= '  infowindow.close();' ."\n";
					$scripttext .= '  infowindow.setPosition(latlng'. $lastmarker2open->id.');' ."\n";
					$scripttext .= '  google.maps.event.trigger(marker'. $lastmarker2open->id.', "click");' ."\n";
				break;
				case 2:
					$scripttext .= '  infowindow.close();' ."\n";
					$scripttext .= '  infowindow.setPosition(latlng'. $lastmarker2open->id.');' ."\n";
					$scripttext .= '  google.maps.event.trigger(marker'. $lastmarker2open->id.', "click");' ."\n";
				break;
				case 3:
					$scripttext .= '  infowindow.close();' ."\n";
					$scripttext .= '  infowindow.setPosition(latlng'. $lastmarker2open->id.');' ."\n";
					$scripttext .= '  google.maps.event.trigger(marker'. $lastmarker2open->id.', "click");' ."\n";
				break;
				case 4:
					$scripttext .= '  infowindow.close();' ."\n";
					$scripttext .= '  infowindow.setPosition(latlng'. $lastmarker2open->id.');' ."\n";
					$scripttext .= '  google.maps.event.trigger(marker'. $lastmarker2open->id.', "click");' ."\n";
				break;
				case 5:
					$scripttext .= '  infowindow.close();' ."\n";
					$scripttext .= '  infowindow.setPosition(latlng'. $lastmarker2open->id.');' ."\n";
					$scripttext .= '  google.maps.event.trigger(marker'. $lastmarker2open->id.', "click");' ."\n";
				break;
				default:
					$scripttext .= '' ."\n";
				break;
			}
		}
		else
		{
				$scripttext .= 'var contentString'. $lastmarker2open->id.' = '.
					modZhGoogleMapPlacemarksHelper::get_placemark_content_string(
						'',
						$lastmarker2open, $map->usercontact, $map->useruser,
						$userContactAttrs, $service_DoDirection,
						$imgpathIcons, $imgpathUtils, $directoryIcons);
				$scripttext .= '  infowindow.close();' ."\n";
				$scripttext .= '  infowindow.setContent(contentString'. $lastmarker2open->id.');' ."\n";
				$scripttext .= '  infowindow.setPosition(latlng'. $lastmarker2open->id.');' ."\n";
				$scripttext .= '  infowindow.open(map);' ."\n";
		}

	}
	

	// Routers
	if (isset($routers) && !empty($routers)) 
	{
		$routepanelcount = 0;
		$routepaneltotalcount = 0;
		$scripttext .= 'var directionsService = new google.maps.DirectionsService();' ."\n";

		$routeHTMLdescription ='';
		
		//Begin for each Route
		foreach ($routers as $key => $currentrouter) 
		{
			// Start Route by Address
			if ($currentrouter->route != "")
			{
				$routername ='';
				$routername = 'route'. $currentrouter->id;
				$scripttext .= 'var directionsDisplay'. $currentrouter->id.' = new google.maps.DirectionsRenderer();' ."\n";
				$scripttext .= 'directionsDisplay'. $currentrouter->id.'.setMap(map);' ."\n";

				if (isset($currentrouter->showpanel) && (int)$currentrouter->showpanel == 1) 
				{
					$scripttext .= 'directionsDisplay'. $currentrouter->id.'.setPanel(document.getElementById("GMapsRoutePanel"));' ."\n";
					$routepanelcount++;
					if (isset($currentrouter->showpaneltotal) && (int)$currentrouter->showpaneltotal == 1) 
					{
						$routepaneltotalcount++;
					}
				}
				
				$cs = explode(";", $currentrouter->route);
				$cs_total = count($cs)-1;
				$cs_idx = 0;
				$wp_list = '';
				foreach($cs as $curroute)
				{	
					if ($cs_idx == 0)
					{
						$scripttext .= 'var startposition='.$curroute.';'."\n";
					}
					else if ($cs_idx == $cs_total)
					{
						$scripttext .= 'var endposition='.$curroute.';'."\n";
					}
					else
					{
						if ($wp_list == '')
						{
							$wp_list .= '{ location: '.$curroute.', stopover:true }';
						}
						else
						{
							$wp_list .= ', '."\n".'{ location: '.$curroute.', stopover:true }';
						}
					}

					$cs_idx += 1;
				}

					  
				
				$scripttext .= 'var rendererOptions'. $currentrouter->id.' = {' ."\n";
				if (isset($currentrouter->draggable))
				{
					switch ($currentrouter->draggable) 
					{
					case 0:
						$scripttext .= 'draggable:false' ."\n";
					break;
					case 1:
						$scripttext .= 'draggable:true' ."\n";
					break;
					default:
						$scripttext .= 'draggable:false' ."\n";
					break;
					}
				}
				if (isset($currentrouter->showtype))
				{
					switch ($currentrouter->showtype) 
					{
					case 0:
						$scripttext .= ', preserveViewport:false' ."\n";
					break;
					case 1:
						$scripttext .= ', preserveViewport:true' ."\n";
					break;
					default:
						$scripttext .= '' ."\n";
					break;
					}
				}

				if (isset($currentrouter->suppressmarkers))
				{
					switch ($currentrouter->suppressmarkers) 
					{
					case 0:
						$scripttext .= ', suppressMarkers:false' ."\n";
					break;
					case 1:
						$scripttext .= ', suppressMarkers:true' ."\n";
					break;
					default:
						$scripttext .= '' ."\n";
					break;
					}
				}
				
				$scripttext .= '};' ."\n";
				
				$scripttext .= 'directionsDisplay'. $currentrouter->id.'.setOptions(rendererOptions'. $currentrouter->id.');' ."\n";

				$scripttext .= '  var directionsRequest'. $currentrouter->id.' = {' ."\n";
				$scripttext .= '    origin: startposition, ' ."\n";
				$scripttext .= '    destination: endposition,' ."\n";
				if ($wp_list != '')
				{
					$scripttext .= ' waypoints: ['.$wp_list.'],'."\n";
				}
				if (isset($currentrouter->providealt) && (int)$currentrouter->providealt == 1) 
				{
					$scripttext .= 'provideRouteAlternatives: true,' ."\n";
				} else {
					$scripttext .= 'provideRouteAlternatives: false,' ."\n";
				}
				if (isset($currentrouter->avoidhighways) && (int)$currentrouter->avoidhighways == 1) 
				{
					$scripttext .= 'avoidHighways: true,' ."\n";
				} else {
					$scripttext .= 'avoidHighways: false,' ."\n";
				}
				if (isset($currentrouter->avoidtolls) && (int)$currentrouter->avoidtolls == 1) 
				{
					$scripttext .= 'avoidTolls: true,' ."\n";
				} else {
					$scripttext .= 'avoidTolls: false,' ."\n";
				}
				if (isset($currentrouter->optimizewaypoints) && (int)$currentrouter->optimizewaypoints == 1) 
				{
					$scripttext .= 'optimizeWaypoints: true,' ."\n";
				} else {
					$scripttext .= 'optimizeWaypoints: false,' ."\n";
				}

				if (isset($currentrouter->travelmode)) 
				{
					switch ($currentrouter->travelmode) 
					{
					case 0:
					break;
					case 1:
						$scripttext .= 'travelMode: google.maps.TravelMode.DRIVING,' ."\n";
					break;
					case 2:
						$scripttext .= 'travelMode: google.maps.TravelMode.WALKING,' ."\n";
					break;
					case 3:
						$scripttext .= 'travelMode: google.maps.TravelMode.BICYCLING,' ."\n";
					break;
					case 4:
						$scripttext .= 'travelMode: google.maps.TravelMode.TRANSIT,' ."\n";
					break;
					default:
						$scripttext .= '' ."\n";
					break;
					}
				}

				if (isset($currentrouter->unitsystem)) 
				{
					switch ($currentrouter->unitsystem) 
					{
					case 0:
					break;
					case 1:
						$scripttext .= 'unitSystem: google.maps.UnitSystem.METRIC' ."\n";
					break;
					case 2:
						$scripttext .= 'unitSystem: google.maps.UnitSystem.IMPERIAL' ."\n";
					break;
					default:
						$scripttext .= '' ."\n";
					break;
					}
				}
				$scripttext .= '  };' ."\n";

				
				if (isset($currentrouter->showpanel) && (int)$currentrouter->showpanel == 1) 
				{
					$scripttext .= 'google.maps.event.addListener(directionsDisplay'. $currentrouter->id.', \'directions_changed\', function() {' ."\n";
					$scripttext .= '  computeTotalDistance(directionsDisplay'. $currentrouter->id.'.directions);' ."\n";
					$scripttext .= '});' ."\n";
				}
				
				$scripttext .= '  directionsService.route(directionsRequest'. $currentrouter->id.', function(result, status) {' ."\n";
				$scripttext .= '    if (status == google.maps.DirectionsStatus.OK) {' ."\n";
				$scripttext .= '      directionsDisplay'. $currentrouter->id.'.setDirections(result);' ."\n";
				$scripttext .= '    }' ."\n";
				$scripttext .= '    else {' ."\n";
				$scripttext .= '		alert("'.JText::_('MOD_ZHGOOGLEMAP_MAP_DIRECTION_FAILED').' " + status);' ."\n";
				$scripttext .= '    }' ."\n";
				$scripttext .= '});' ."\n";

			}
			// End Route by Address
			// Start Route by Marker
			if ($currentrouter->routebymarker != "")
			{
				$routername ='';
				$routername = 'routeByMarker'. $currentrouter->id;
				$scripttext .= 'var directionsDisplayByMarker'. $currentrouter->id.' = new google.maps.DirectionsRenderer();' ."\n";
				$scripttext .= 'directionsDisplayByMarker'. $currentrouter->id.'.setMap(map);' ."\n";

				if (isset($currentrouter->showpanel) && (int)$currentrouter->showpanel == 1) 
				{
					$scripttext .= 'directionsDisplayByMarker'. $currentrouter->id.'.setPanel(document.getElementById("GMapsRoutePanel"));' ."\n";
					$routepanelcount++;
					if (isset($currentrouter->showpaneltotal) && (int)$currentrouter->showpaneltotal == 1) 
					{
						$routepaneltotalcount++;
					}
				}
				
				$cs = explode(";", $currentrouter->routebymarker);
				$cs_total = count($cs)-1;
				$cs_idx = 0;
				$wp_list = '';
				$skipRouteCreation = 0;
				foreach($cs as $curroute)
				{	
					$currouteLatLng = modZhGoogleMapPlacemarksHelper::parse_route_by_markers($curroute);
					//$scripttext .= 'alert("'.$currouteLatLng.'");'."\n";

					if ($currouteLatLng != "")
					{
						if ($currouteLatLng == "geocode")
						{
							$scripttext .= 'alert(\''.JText::_('MOD_ZHGOOGLEMAP_MAPROUTER_FINDMARKER_ERROR_GEOCODE').' '.$curroute.'\');'."\n";
							$skipRouteCreation = 1;
						}
						else
						{
							if ($cs_idx == 0)
							{
								$scripttext .= 'var startposition='.$currouteLatLng.';'."\n";
							}
							else if ($cs_idx == $cs_total)
							{
								$scripttext .= 'var endposition='.$currouteLatLng.';'."\n";
							}
							else
							{
								if ($wp_list == '')
								{
									$wp_list .= '{ location: '.$currouteLatLng.', stopover:true }';
								}
								else
								{
									$wp_list .= ', '."\n".'{ location: '.$currouteLatLng.', stopover:true }';
								}
							}
						}
					}
					else
					{
						$scripttext .= 'alert(\''.JText::_('MOD_ZHGOOGLEMAP_MAPROUTER_FINDMARKER_ERROR_REASON').' '.$curroute.'\');'."\n";
						$skipRouteCreation = 1;
					}

					$cs_idx += 1;
				}

					  
				if ($skipRouteCreation == 0)
				{
					$scripttext .= 'var rendererOptionsByMarker'. $currentrouter->id.' = {' ."\n";
					if (isset($currentrouter->draggable))
					{
						switch ($currentrouter->draggable) 
						{
						case 0:
							$scripttext .= 'draggable:false' ."\n";
						break;
						case 1:
							$scripttext .= 'draggable:true' ."\n";
						break;
						default:
							$scripttext .= 'draggable:false' ."\n";
						break;
						}
					}
					if (isset($currentrouter->showtype))
					{
						switch ($currentrouter->showtype) 
						{
						case 0:
							$scripttext .= ', preserveViewport:false' ."\n";
						break;
						case 1:
							$scripttext .= ', preserveViewport:true' ."\n";
						break;
						default:
							$scripttext .= '' ."\n";
						break;
						}
					}

					if (isset($currentrouter->suppressmarkers))
					{
						switch ($currentrouter->suppressmarkers) 
						{
						case 0:
							$scripttext .= ', suppressMarkers:false' ."\n";
						break;
						case 1:
							$scripttext .= ', suppressMarkers:true' ."\n";
						break;
						default:
							$scripttext .= '' ."\n";
						break;
						}
					}


					$scripttext .= '};' ."\n";
					
					$scripttext .= 'directionsDisplayByMarker'. $currentrouter->id.'.setOptions(rendererOptionsByMarker'. $currentrouter->id.');' ."\n";

					$scripttext .= '  var directionsRequestByMarker'. $currentrouter->id.' = {' ."\n";
					$scripttext .= '    origin: startposition, ' ."\n";
					$scripttext .= '    destination: endposition,' ."\n";
					if ($wp_list != '')
					{
						$scripttext .= ' waypoints: ['.$wp_list.'],'."\n";
					}
					if (isset($currentrouter->providealt) && (int)$currentrouter->providealt == 1) 
					{
						$scripttext .= 'provideRouteAlternatives: true,' ."\n";
					} else {
						$scripttext .= 'provideRouteAlternatives: false,' ."\n";
					}
					if (isset($currentrouter->avoidhighways) && (int)$currentrouter->avoidhighways == 1) 
					{
						$scripttext .= 'avoidHighways: true,' ."\n";
					} else {
						$scripttext .= 'avoidHighways: false,' ."\n";
					}
					if (isset($currentrouter->avoidtolls) && (int)$currentrouter->avoidtolls == 1) 
					{
						$scripttext .= 'avoidTolls: true,' ."\n";
					} else {
						$scripttext .= 'avoidTolls: false,' ."\n";
					}
					if (isset($currentrouter->optimizewaypoints) && (int)$currentrouter->optimizewaypoints == 1) 
					{
						$scripttext .= 'optimizeWaypoints: true,' ."\n";
					} else {
						$scripttext .= 'optimizeWaypoints: false,' ."\n";
					}

					if (isset($currentrouter->travelmode)) 
					{
						switch ($currentrouter->travelmode) 
						{
						case 0:
						break;
						case 1:
							$scripttext .= 'travelMode: google.maps.TravelMode.DRIVING,' ."\n";
						break;
						case 2:
							$scripttext .= 'travelMode: google.maps.TravelMode.WALKING,' ."\n";
						break;
						case 3:
							$scripttext .= 'travelMode: google.maps.TravelMode.BICYCLING,' ."\n";
						break;
						case 4:
							$scripttext .= 'travelMode: google.maps.TravelMode.TRANSIT,' ."\n";
						break;
						default:
							$scripttext .= '' ."\n";
						break;
						}
					}

					if (isset($currentrouter->unitsystem)) 
					{
						switch ($currentrouter->unitsystem) 
						{
						case 0:
						break;
						case 1:
							$scripttext .= 'unitSystem: google.maps.UnitSystem.METRIC' ."\n";
						break;
						case 2:
							$scripttext .= 'unitSystem: google.maps.UnitSystem.IMPERIAL' ."\n";
						break;
						default:
							$scripttext .= '' ."\n";
						break;
						}
					}
					$scripttext .= '  };' ."\n";
					
					if (isset($currentrouter->showpanel) && (int)$currentrouter->showpanel == 1) 
					{
						$scripttext .= 'google.maps.event.addListener(directionsDisplayByMarker'. $currentrouter->id.', \'directions_changed\', function() {' ."\n";
						$scripttext .= '  computeTotalDistance(directionsDisplayByMarker'. $currentrouter->id.'.directions);' ."\n";
						$scripttext .= '});' ."\n";
					}
					
					$scripttext .= '  directionsService.route(directionsRequestByMarker'. $currentrouter->id.', function(result, status) {' ."\n";
					$scripttext .= '    if (status == google.maps.DirectionsStatus.OK) {' ."\n";
					$scripttext .= '      directionsDisplayByMarker'. $currentrouter->id.'.setDirections(result);' ."\n";
					$scripttext .= '    }' ."\n";
					$scripttext .= '    else {' ."\n";
					$scripttext .= '		alert("'.JText::_('MOD_ZHGOOGLEMAP_MAP_DIRECTION_FAILED').' " + status);' ."\n";
					$scripttext .= '    }' ."\n";
					$scripttext .= '});' ."\n";

				}
			}
			// End Route by Marker

			if (isset($currentrouter->showdescription) && (int)$currentrouter->showdescription == 1) 
			{
				if ($currentrouter->description != "")
				{
					$routeHTMLdescription .= '<h2>';
					$routeHTMLdescription .= htmlspecialchars($currentrouter->description, ENT_QUOTES, 'UTF-8');
					$routeHTMLdescription .= '</h2>';
				}
				if ($currentrouter->descriptionhtml != "")
				{
					$routeHTMLdescription .= str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentrouter->descriptionhtml));
				}
			}
			
		}
		// End for each Route
		
		if ($routepanelcount > 1 || $routepanelcount == 0 || $routepaneltotalcount == 0)
		{
			$scripttext .= 'var toHideRouteDiv = document.getElementById("GMapsRoutePanel_Total");' ."\n";
			$scripttext .= 'toHideRouteDiv.style.display = "none";' ."\n";
			//$scripttext .= 'alert("Hide because > 1 or = 0");';
		}

		if ($routeHTMLdescription != "")
		{
			$scripttext .= '  document.getElementById("GMapsRoutePanel_Description").innerHTML =  "<p>'. $routeHTMLdescription .'</p>";'."\n";
		}
		
		$scripttext .= 'function computeTotalDistance(result) {' ."\n";
		if ($routepaneltotalcount == 1)
		{
			$scripttext .= '  var total = 0;' ."\n";
			$scripttext .= '  var myroute = result.routes[0];' ."\n";
			$scripttext .= '  for (i = 0; i < myroute.legs.length; i++) {' ."\n";
			$scripttext .= '      total += myroute.legs[i].distance.value;' ."\n";
			$scripttext .= '  }' ."\n";
			$scripttext .= '  total = total / 1000.;' ."\n";
			$scripttext .= '  total = total.toFixed(1);' ."\n";
			
			$scripttext .= '  document.getElementById("GMapsRoutePanel_Total").innerHTML = "<p>'.JText::_('MOD_ZHGOOGLEMAP_MAPROUTER_DETAIL_SHOWPANEL_HDR_TOTAL').' " + total + " '.JText::_('MOD_ZHGOOGLEMAP_MAPROUTER_DETAIL_SHOWPANEL_HDR_KM').'</p>";' ."\n";
		}
		$scripttext .= '};' ."\n";
		
	}


	// Paths
	if (isset($paths) && !empty($paths)) 
	{
		foreach ($paths as $key => $currentpath) 
		{

			if (isset($currentpath->objecttype))
			{
				if ($currentpath->path != "")
				{

					switch ($currentpath->objecttype) 
					{
						case 0:
							$scripttext .= ' var allCoordinates'. $currentpath->id.' = [ '."\n";
							$scripttext .=' new google.maps.LatLng('.str_replace(";","), new google.maps.LatLng(", $currentpath->path).') '."\n";
							$scripttext .= ' ]; '."\n";
							$scripttext .= ' var plPath'. $currentpath->id.' = new google.maps.Polyline({'."\n";
							$scripttext .= ' path: allCoordinates'. $currentpath->id.','."\n";

							if (isset($currentpath->geodesic) && (int)$currentpath->geodesic == 1) 
							{
								$scripttext .= ' geodesic: true, '."\n";
							}
							else
							{
								$scripttext .= ' geodesic: false, '."\n";
							}
							$scripttext .= ' strokeColor: "'.$currentpath->color.'"'."\n";
							$scripttext .= ',strokeOpacity: '.$currentpath->opacity."\n";
							$scripttext .= ',strokeWeight: '.$currentpath->weight."\n";
							$scripttext .= ' });'."\n";

							$scripttext .= 'plPath'. $currentpath->id.'.setMap(map);'."\n";

							if ((int)$currentpath->actionbyclick == 1)
							{
								// contentPathString - Begin
								$scripttext .= 'var contentPathString'. $currentpath->id.' = \'<div id="pathContent'. $currentpath->id.'">\' +	' ."\n";
								if (isset($currentpath->infowincontent) &&
									(((int)$currentpath->infowincontent == 0) ||
									 ((int)$currentpath->infowincontent == 1))
									)
								{
									$scripttext .= '\'<h1 id="headContent'. $currentpath->id.'" class="placemarkHead">'.'\'+' ."\n";
									$scripttext .= '\''.htmlspecialchars(str_replace('\\', '/', $currentpath->title), ENT_QUOTES, 'UTF-8').'\'+'."\n";
									$scripttext .= '\'</h1>\'+' ."\n";
								}
								$scripttext .= '\'<div id="bodyContent'. $currentpath->id.'"  class="placemarkBody">\'+'."\n";


								if (isset($currentpath->infowincontent) &&
									(((int)$currentpath->infowincontent == 0) ||
									 ((int)$currentpath->infowincontent == 2))
									)
								{
									$scripttext .= '\''.htmlspecialchars(str_replace('\\', '/', $currentpath->description), ENT_QUOTES, 'UTF-8').'\'+'."\n";
								}
								$scripttext .= '\''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentpath->descriptionhtml)).'\'+'."\n";


								$scripttext .= '\'</div>\'+'."\n";
								$scripttext .= '\'</div>\';'."\n";
								// contentPathString - End
							}
							
							// Mouse hover - begin
							if ($currentpath->hover_color != "")
							{
								$scripttext .= '  google.maps.event.addListener(plPath'. $currentpath->id.', \'mouseover\', function(event) {' ."\n";
								$scripttext .= '    plPath'. $currentpath->id.'.setOptions({' ."\n";	
								$scripttext .= ' 	  strokeColor: "'.$currentpath->hover_color.'"'."\n";
								$scripttext .= '  	});' ."\n";
								$scripttext .= '  });' ."\n";
								$scripttext .= '  google.maps.event.addListener(plPath'. $currentpath->id.', \'mouseout\', function(event) {' ."\n";
								$scripttext .= '    plPath'. $currentpath->id.'.setOptions({' ."\n";	
								$scripttext .= ' 	  strokeColor: "'.$currentpath->color.'"'."\n";
								$scripttext .= '  	});' ."\n";
								$scripttext .= '  });' ."\n";
							}
							// Mouse hover - end
							// Action By Click Path - Begin							
							switch ((int)$currentpath->actionbyclick)
							{
								// None
								case 0:
								break;
								// Info
								case 1:
										$scripttext .= '  google.maps.event.addListener(plPath'. $currentpath->id.', \'click\', function(event) {' ."\n";
										$scripttext .= '  infowindow.close();' ."\n";
										// Close the other infobubbles
										$scripttext .= '  for (i = 0; i < infobubblemarkers.length; i++) {' ."\n";
										$scripttext .= '      infobubblemarkers[i].close();' ."\n";
										$scripttext .= '  }' ."\n";
										// Open infowin
										$scripttext .= '  infowindow.setContent(contentPathString'. $currentpath->id.');' ."\n";
										$scripttext .= '  infowindow.setPosition(event.latLng);' ."\n";
										$scripttext .= '  infowindow.open(map);' ."\n";
										$scripttext .= '  });' ."\n";
								break;
								default:
									$scripttext .= '' ."\n";
								break;
							}
							
							// Action By Click Path - End
						break;
						case 1:
							$scripttext .= ' var allCoordinates'. $currentpath->id.' = [ '."\n";
							$scripttext .=' new google.maps.LatLng('.str_replace(";","), new google.maps.LatLng(", $currentpath->path).') '."\n";
							$scripttext .= ' ]; '."\n";
							$scripttext .= ' var plPath'. $currentpath->id.' = new google.maps.Polygon({'."\n";
							$scripttext .= ' path: allCoordinates'. $currentpath->id.','."\n";

							if (isset($currentpath->geodesic) && (int)$currentpath->geodesic == 1) 
							{
								$scripttext .= ' geodesic: true, '."\n";
							}
							else
							{
								$scripttext .= ' geodesic: false, '."\n";
							}
							$scripttext .= ' strokeColor: "'.$currentpath->color.'"'."\n";
							$scripttext .= ',strokeOpacity: '.$currentpath->opacity."\n";
							$scripttext .= ',strokeWeight: '.$currentpath->weight."\n";
							if ($currentpath->fillcolor != "")
							{
								$scripttext .= ',fillColor: "'.$currentpath->fillcolor.'"'."\n";
							}
							if ($currentpath->fillopacity != "")
							{
								$scripttext .= ',fillOpacity: '.$currentpath->fillopacity."\n";
							}
							$scripttext .= ' });'."\n";
							
							$scripttext .= 'plPath'. $currentpath->id.'.setMap(map);'."\n";

							if ((int)$currentpath->actionbyclick == 1)
							{
								// contentPathString - Begin
								$scripttext .= 'var contentPathString'. $currentpath->id.' = \'<div id="pathContent'. $currentpath->id.'">\' +	' ."\n";
								if (isset($currentpath->infowincontent) &&
									(((int)$currentpath->infowincontent == 0) ||
									 ((int)$currentpath->infowincontent == 1))
									)
								{
									$scripttext .= '\'<h1 id="headContent'. $currentpath->id.'" class="placemarkHead">'.'\'+' ."\n";
									$scripttext .= '\''.htmlspecialchars(str_replace('\\', '/', $currentpath->title), ENT_QUOTES, 'UTF-8').'\'+'."\n";
									$scripttext .= '\'</h1>\'+' ."\n";
								}
								$scripttext .= '\'<div id="bodyContent'. $currentpath->id.'"  class="placemarkBody">\'+'."\n";


								if (isset($currentpath->infowincontent) &&
									(((int)$currentpath->infowincontent == 0) ||
									 ((int)$currentpath->infowincontent == 2))
									)
								{
									$scripttext .= '\''.htmlspecialchars(str_replace('\\', '/', $currentpath->description), ENT_QUOTES, 'UTF-8').'\'+'."\n";
								}
								$scripttext .= '\''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentpath->descriptionhtml)).'\'+'."\n";


								$scripttext .= '\'</div>\'+'."\n";
								$scripttext .= '\'</div>\';'."\n";
								// contentPathString - End
							}
							
							// Mouse hover - begin
							if ($currentpath->hover_color != "")
							{
								$scripttext .= '  google.maps.event.addListener(plPath'. $currentpath->id.', \'mouseover\', function(event) {' ."\n";
								$scripttext .= '    plPath'. $currentpath->id.'.setOptions({' ."\n";	
								$scripttext .= ' 	  strokeColor: "'.$currentpath->hover_color.'"'."\n";
								$scripttext .= '  	});' ."\n";
								$scripttext .= '  });' ."\n";
								$scripttext .= '  google.maps.event.addListener(plPath'. $currentpath->id.', \'mouseout\', function(event) {' ."\n";
								$scripttext .= '    plPath'. $currentpath->id.'.setOptions({' ."\n";	
								$scripttext .= ' 	  strokeColor: "'.$currentpath->color.'"'."\n";
								$scripttext .= '  	});' ."\n";
								$scripttext .= '  });' ."\n";
							}
							// Mouse hover - end							
							// Action By Click Path - Begin							
							switch ((int)$currentpath->actionbyclick)
							{
								// None
								case 0:
								break;
								// Info
								case 1:
										$scripttext .= '  google.maps.event.addListener(plPath'. $currentpath->id.', \'click\', function(event) {' ."\n";
										$scripttext .= '  infowindow.close();' ."\n";
										// Close the other infobubbles
										$scripttext .= '  for (i = 0; i < infobubblemarkers.length; i++) {' ."\n";
										$scripttext .= '      infobubblemarkers[i].close();' ."\n";
										$scripttext .= '  }' ."\n";
										// Open infowin
										$scripttext .= '  infowindow.setContent(contentPathString'. $currentpath->id.');' ."\n";
										$scripttext .= '  infowindow.setPosition(event.latLng);' ."\n";
										$scripttext .= '  infowindow.open(map);' ."\n";
										$scripttext .= '  });' ."\n";
								break;
								default:
									$scripttext .= '' ."\n";
								break;
							}
							
							// Action By Click Path - End
						break;
						case 2:
						    if ($currentpath->radius != "")
							{
								$arrayPathCoords = explode(';', $currentpath->path);
								$arrayPathIndex = 0;
								foreach ($arrayPathCoords as $currentpathcoordinates) 
								{
									$arrayPathIndex += 1;
									$scripttext .= ' var plPath'.$arrayPathIndex.'_'. $currentpath->id.' = new google.maps.Circle({'."\n";
									$scripttext .= ' center: new google.maps.LatLng('.$currentpathcoordinates.')'."\n";
									$scripttext .= ',radius: '.$currentpath->radius."\n";
									$scripttext .= ',strokeColor: "'.$currentpath->color.'"'."\n";
									$scripttext .= ',strokeOpacity: '.$currentpath->opacity."\n";
									$scripttext .= ',strokeWeight: '.$currentpath->weight."\n";
									if ($currentpath->fillcolor != "")
									{
										$scripttext .= ',fillColor: "'.$currentpath->fillcolor.'"'."\n";
									}
									if ($currentpath->fillopacity != "")
									{
										$scripttext .= ',fillOpacity: '.$currentpath->fillopacity."\n";
									}
									$scripttext .= '  });' ."\n";
									$scripttext .= 'plPath'.$arrayPathIndex.'_'. $currentpath->id.'.setMap(map);'."\n";

									if ((int)$currentpath->actionbyclick == 1)
									{
										// contentPathString - Begin
										$scripttext .= 'var contentPathString'.$arrayPathIndex.'_'. $currentpath->id.' = \'<div id="pathContent'. $currentpath->id.'">\' +	' ."\n";
										if (isset($currentpath->infowincontent) &&
											(((int)$currentpath->infowincontent == 0) ||
											 ((int)$currentpath->infowincontent == 1))
											)
										{
											$scripttext .= '\'<h1 id="headContent'.$arrayPathIndex.'_'. $currentpath->id.'" class="placemarkHead">'.'\'+' ."\n";
											$scripttext .= '\''.htmlspecialchars(str_replace('\\', '/', $currentpath->title), ENT_QUOTES, 'UTF-8').'\'+'."\n";
											$scripttext .= '\'</h1>\'+' ."\n";
										}
										$scripttext .= '\'<div id="bodyContent'.$arrayPathIndex.'_'. $currentpath->id.'"  class="placemarkBody">\'+'."\n";


										if (isset($currentpath->infowincontent) &&
											(((int)$currentpath->infowincontent == 0) ||
											 ((int)$currentpath->infowincontent == 2))
											)
										{
											$scripttext .= '\''.htmlspecialchars(str_replace('\\', '/', $currentpath->description), ENT_QUOTES, 'UTF-8').'\'+'."\n";
										}
										$scripttext .= '\''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentpath->descriptionhtml)).'\'+'."\n";


										$scripttext .= '\'</div>\'+'."\n";
										$scripttext .= '\'</div>\';'."\n";
										// contentPathString - End
									}
									
									// Mouse hover - begin
									if ($currentpath->hover_color != "")
									{
										$scripttext .= '  google.maps.event.addListener(plPath'.$arrayPathIndex.'_'. $currentpath->id.', \'mouseover\', function(event) {' ."\n";
										$scripttext .= '    plPath'.$arrayPathIndex.'_'. $currentpath->id.'.setOptions({' ."\n";	
										$scripttext .= ' 	  strokeColor: "'.$currentpath->hover_color.'"'."\n";
										$scripttext .= '  	});' ."\n";
										$scripttext .= '  });' ."\n";
										$scripttext .= '  google.maps.event.addListener(plPath'.$arrayPathIndex.'_'. $currentpath->id.', \'mouseout\', function(event) {' ."\n";
										$scripttext .= '    plPath'.$arrayPathIndex.'_'. $currentpath->id.'.setOptions({' ."\n";	
										$scripttext .= ' 	  strokeColor: "'.$currentpath->color.'"'."\n";
										$scripttext .= '  	});' ."\n";
										$scripttext .= '  });' ."\n";
									}
									// Mouse hover - end
									// Action By Click Path - Begin							
									switch ((int)$currentpath->actionbyclick)
									{
										// None
										case 0:
										break;
										// Info
										case 1:
												$scripttext .= '  google.maps.event.addListener(plPath'.$arrayPathIndex.'_'. $currentpath->id.', \'click\', function(event) {' ."\n";
												$scripttext .= '  infowindow.close();' ."\n";
												// Close the other infobubbles
												$scripttext .= '  for (i = 0; i < infobubblemarkers.length; i++) {' ."\n";
												$scripttext .= '      infobubblemarkers[i].close();' ."\n";
												$scripttext .= '  }' ."\n";
												// Open infowin
												$scripttext .= '  infowindow.setContent(contentPathString'.$arrayPathIndex.'_'. $currentpath->id.');' ."\n";
												$scripttext .= '  infowindow.setPosition(event.latLng);' ."\n";
												$scripttext .= '  infowindow.open(map);' ."\n";
												$scripttext .= '  });' ."\n";
										break;
										default:
											$scripttext .= '' ."\n";
										break;
									}
									
									// Action By Click Path - End
									
									
									
								}
							}
						break;
					}
					
					if ((int)$currentpath->elevation != 0
					 && (int)$currentpath->objecttype == 0
					 )
					{
						if ($currentpath->elevationicontype == "")
						{
							$elevationMouseOverIcon = 'gm#simple-lightblue';
						}
						else
						{
							$elevationMouseOverIcon = $currentpath->elevationicontype;
						}
						$elevationMouseOverIcon = str_replace("#", "%23", $elevationMouseOverIcon).'.png';
						
						$scripttext .= 'elevationPlotDiagram(allCoordinates'. $currentpath->id.', '.
															(int)$currentpath->elevationcount.', '.
															(int)$currentpath->elevationwidth.', '.
															(int)$currentpath->elevationheight.', '.
															'"'.$elevationMouseOverIcon.'", '.
															(int)$currentpath->elevation.','.
															(int)$currentpath->elevationbaseline.','.
															'"'.$currentpath->v_baseline_color.'", '.
															'"'.$currentpath->v_gridline_color.'", '.
															(int)(int)$currentpath->v_gridline_count.', '.
															'"'.$currentpath->v_minor_gridline_color.'", '.
															(int)$currentpath->v_minor_gridline_count.', '.
															'"'.$currentpath->background_color_stroke.'", '.
															(int)$currentpath->background_color_width.', '.
															'"'.$currentpath->background_color_fill.'", '.
															'"'.$currentpath->v_max_value.'", '.
															'"'.$currentpath->v_min_value.'"'.
															');' ."\n";
					
					}

					
					
				}
			}
		
			if ($currentpath->kmllayer != "") 
			{
				$scripttext .= 'var kmlOptions'. $currentpath->id.' = {' ."\n";
				if (isset($currentpath->showtype))
				{
					switch ($currentpath->showtype) 
					{
					case 0:
						$scripttext .= 'preserveViewport:false' ."\n";
					break;
					case 1:
						$scripttext .= 'preserveViewport:true' ."\n";
					break;
					default:
						$scripttext .= '' ."\n";
					break;
					}
				}
				$scripttext .= '};' ."\n";
			
				$scripttext .= 'var kmlLayer'. $currentpath->id.' = new google.maps.KmlLayer(\''.$currentpath->kmllayer.'\', kmlOptions'. $currentpath->id.');' ."\n";
				$scripttext .= 'kmlLayer'. $currentpath->id.'.setMap(map);' ."\n";

				if ((int)$currentpath->elevation != 0)
				{
						if ($currentpath->elevationicontype == "")
						{
							$elevationMouseOverIcon = 'gm#simple-lightblue';
						}
						else
						{
							$elevationMouseOverIcon = $currentpath->elevationicontype;
						}
						$elevationMouseOverIcon = str_replace("#", "%23", $elevationMouseOverIcon).'.png';
						
						$scripttext .= '	var myParser = new geoXML3.parser({afterParse: useTheData});' ."\n";
						$scripttext .= '	myParser.parse(\''.$currentpath->kmllayer.'\');' ."\n";
						$scripttext .= '	function useTheData(doc) {' ."\n";
						// Geodata handling goes here, using JSON properties of the doc object
						$scripttext .= '		var SAMPLES = '.(int)$currentpath->elevationcountkml.';' ."\n";
						$scripttext .= '		var pathx;' ."\n";
						$scripttext .= '		var geoXmlDoc = doc[0];' ."\n";
						$scripttext .= '		  for (var i = 0; i < geoXmlDoc.placemarks.length; i++) {' ."\n";
						$scripttext .= '			var placemark = geoXmlDoc.placemarks[i];' ."\n";
						$scripttext .= '			if (placemark.polyline) {' ."\n";
						$scripttext .= '			  if (!pathx) {' ."\n";
						$scripttext .= '				pathx = [];' ."\n";
						$scripttext .= '				var samples = placemark.polyline.getPath().getLength();' ."\n";
						$scripttext .= '				var incr = 1;' ."\n";
						$scripttext .= '				if (SAMPLES != 0) ' ."\n";
						$scripttext .= '				{' ."\n";
						$scripttext .= '					incr = samples/SAMPLES;' ."\n";
						$scripttext .= '					if (incr < 1) incr = 1;' ."\n";
						$scripttext .= '				}' ."\n";
						$scripttext .= '				for (var i=0;i<samples; i+=incr)' ."\n";
						$scripttext .= '				{' ."\n";
						$scripttext .= '				  pathx.push(placemark.polyline.getPath().getAt(parseInt(i)));' ."\n";
						$scripttext .= '				}' ."\n";
						$scripttext .= '			  }' ."\n";					 
						$scripttext .= '			}' ."\n";
						$scripttext .= '		  }' ."\n";
						$scripttext .= '		if (pathx) {' ."\n";
						$scripttext .= '    	elevationPlotDiagram(pathx, '.
															(int)$currentpath->elevationcount.', '.
															(int)$currentpath->elevationwidth.', '.
															(int)$currentpath->elevationheight.', '.
															'"'.$elevationMouseOverIcon.'", '.
															(int)$currentpath->elevation.','.
															(int)$currentpath->elevationbaseline.','.
															'"'.$currentpath->v_baseline_color.'", '.
															'"'.$currentpath->v_gridline_color.'", '.
															(int)(int)$currentpath->v_gridline_count.', '.
															'"'.$currentpath->v_minor_gridline_color.'", '.
															(int)$currentpath->v_minor_gridline_count.', '.
															'"'.$currentpath->background_color_stroke.'", '.
															(int)$currentpath->background_color_width.', '.
															'"'.$currentpath->background_color_fill.'", '.
															'"'.$currentpath->v_max_value.'", '.
															'"'.$currentpath->v_min_value.'"'.
															');' ."\n";
						$scripttext .= '		}' ."\n";
						$scripttext .= '	};' ."\n";
				}
				
			}

			
		}
	}

	if (isset($map->trafficcontrol) && (int)$map->trafficcontrol == 1) 
	{
		$scripttext .= 'var trafficLayer = new google.maps.TrafficLayer();' ."\n";
		$scripttext .= 'trafficLayer.setMap(map);' ."\n";
	}

	if (isset($map->transitcontrol) && (int)$map->transitcontrol == 1) 
	{
		$scripttext .= 'var transitLayer = new google.maps.TransitLayer();' ."\n";
		$scripttext .= 'transitLayer.setMap(map);' ."\n";
	}
	
	if (isset($map->bikecontrol) && (int)$map->bikecontrol == 1) 
	{
		$scripttext .= 'var bikeLayer = new google.maps.BicyclingLayer();' ."\n";
		$scripttext .= 'bikeLayer.setMap(map);' ."\n";
	}


	if (isset($map->kmllayer) && $map->kmllayer != "") 
	{
		$scripttext .= 'var kmlLayer = new google.maps.KmlLayer(\''.$map->kmllayer.'\');' ."\n";
		$scripttext .= 'kmlLayer.setMap(map);' ."\n";
	}

	

	

	
	// Places Library - Begin
	if (isset($map->placesenable) && (int)$map->placesenable == 1) 
	{
		if ((int)$map->placesradius != 0)
		{
			$scripttext .= 'var requestPlaces = {' ."\n";
			$scripttext .= '  location: latlng,' ."\n";
			$scripttext .= '  radius: '.(int)$map->placesradius.',' ."\n";
			$scripttext .= '  types: ['.$map->placestype.']' ."\n";
			$scripttext .= '  };' ."\n";

			$scripttext .= '  var servicePlaces = new google.maps.places.PlacesService(map);' ."\n";
			$scripttext .= '  servicePlaces.search(requestPlaces, callbackPlaces);' ."\n";
		}

		$scripttext .= 'var placesDirectionsDisplay;' ."\n";
		$scripttext .= 'var placesDirectionsService;' ."\n";
		
		if ((isset($map->placesenable) && (int)$map->placesenable == 1)
		 && (isset($map->placesautocomplete) && (int)$map->placesautocomplete == 1) 
		 && (isset($map->findcontrol) && (int)$map->findcontrol == 0) )
		{
			if (isset($map->placesdirection) && (int)$map->placesdirection == 1) 
			{
				$scripttext .= 'placesDirectionsDisplay = new google.maps.DirectionsRenderer();' ."\n";
				$scripttext .= 'placesDirectionsService = new google.maps.DirectionsService();' ."\n";
				$scripttext .= 'placesDirectionsDisplay.setMap(map);' ."\n";

				if (isset($map->routeshowpanel) && (int)$map->routeshowpanel == 1) 
				{
					$scripttext .= 'placesDirectionsDisplay.setPanel(document.getElementById("GMapsMainRoutePanel"));' ."\n";
				}
				
			}

			
			$scripttext .= 'var optionsPlacesAC = {' ."\n";
			$scripttext .= '  types: ['.$map->placestypeac.']' ."\n";
			$scripttext .= '  };' ."\n";

		    $scripttext .= '  var inputPlacesAC = document.getElementById(\'searchTextField\');' ."\n";
			$scripttext .= '  var autocompletePlaces = new google.maps.places.Autocomplete(inputPlacesAC, optionsPlacesAC);' ."\n";
			$scripttext .= '  var markerPlacesAC = new google.maps.Marker({' ."\n";
			$scripttext .= '    map: map' ."\n";
			$scripttext .= '  });' ."\n";
			// Strange bug with clicking on bouncing marker, or others
			//   scrolls to markerAC and show infowin from bouncing
            //$scripttext .= '  google.maps.event.addListener(markerPlacesAC, \'click\', function(event) {' ."\n";
            //$scripttext .= '  infowindow.close();' ."\n";
            //$scripttext .= '  infowindow.setContent(markerPlacesAC.getTitle());' ."\n";
            //$scripttext .= '  infowindow.open(map, markerPlacesAC);' ."\n";
            //$scripttext .= '    });' ."\n";

			$scripttext .= '  autocompletePlaces.bindTo(\'bounds\', map);' ."\n";

			$scripttext .= '  google.maps.event.addListener(autocompletePlaces, \'place_changed\', function() {' ."\n";

            $scripttext .= '  var place = autocompletePlaces.getPlace();' ."\n";
			
			$scripttext .= '  placesACbyButton('.(int)$map->placesdirection.', placesDirectionsDisplay, placesDirectionsService, markerPlacesAC, place.name, "searchTravelMode", place.geometry.location, routedestination);'."\n";
			
            $scripttext .= '  });' ."\n";
		}


	}
	// Places Library - End
	

	
	
	
    if ( (isset($map->markermanager) && (int)$map->markermanager == 1)
       && (isset($map->markercluster) && (int)$map->markercluster == 0)
       && (isset($map->markergroupcontrol) && (int)$map->markergroupcontrol == 0)
       )
    {   
	//$scripttext .= 'alert("before call create markermanager");' ."\n";                                                         

		// Moved up to geocodimg support
        //$scripttext .= 'mgrMarkerManager = new MarkerManager(map);' ."\n";

        $scripttext .= '  google.maps.event.addListener(mgrMarkerManager, \'loaded\', function(){' ."\n";
        $scripttext .= '    mgrMarkerManager.addMarkers(mgrmarkers0, 0);' ."\n";

		if (isset($markergroups) && !empty($markergroups)) 
		{
			foreach ($markergroups as $key => $currentmarkergroup) 
			{
				if (((int)$currentmarkergroup->published == 1) || ($allowUserMarker == 1))
				{
					$scripttext .= '    mgrMarkerManager.addMarkers(mgrmarkers'.$currentmarkergroup->id.', '.(int)$currentmarkergroup->markermanagerminzoom.', '.(int)$currentmarkergroup->markermanagermaxzoom.');' ."\n";
				}
			}
		}

        $scripttext .= '    mgrMarkerManager.refresh(); ' ."\n";
        $scripttext .= '  });  ' ."\n";
	//$scripttext .= 'alert("after call create marker manager");' ."\n";                                                         
    }
       

    if ((isset($map->markergroupcontrol) && (int)$map->markergroupcontrol != 0))
     {
             if ((isset($map->markercluster) && (int)$map->markercluster == 1))
             {      
                $scripttext .= 'markerCluster0.addMarkers(clustermarkers0);' ."\n";
                 
                if ((isset($map->markerclustergroup) && (int)$map->markerclustergroup == 1))
                {
					if (isset($markergroups) && !empty($markergroups)) 
					{
						foreach ($markergroups as $key => $currentmarkergroup) 
						{
							if (((int)$currentmarkergroup->published == 1) || ($allowUserMarker == 1))
							{
									if ((int)$currentmarkergroup->activeincluster == 1)
									{
											$scripttext .= 'callClusterFill('.$currentmarkergroup->id.');' ."\n";
									}
							}
						}
					}
                }
                else
                {
					if (isset($markergroups) && !empty($markergroups)) 
					{
						foreach ($markergroups as $key => $currentmarkergroup) 
						{
							if (((int)$currentmarkergroup->published == 1) || ($allowUserMarker == 1))
							{
									if ((int)$currentmarkergroup->activeincluster == 1)
									{
											$scripttext .= 'markerCluster0.addMarkers(clustermarkers'.$currentmarkergroup->id.');' ."\n";
									}
							}
						}
					}
                }
            }
            else
            {
				if (isset($markergroups) && !empty($markergroups)) 
				{
                    foreach ($markergroups as $key => $currentmarkergroup) 
                    {
						if (((int)$currentmarkergroup->published == 1) || ($allowUserMarker == 1))
						{
                            if ((int)$currentmarkergroup->activeincluster == 0)
                            {
                                    $scripttext .= 'callMarkerDisable(clustermarkers'.$currentmarkergroup->id.');' ."\n";
                            }
						}
                    }
				}
            }
     }
     else
     {
             if ((isset($map->markercluster) && (int)$map->markercluster == 1))
             {      
                $scripttext .= 'markerCluster0.addMarkers(clustermarkers0);' ."\n";
                 
                if ((isset($map->markerclustergroup) && (int)$map->markerclustergroup == 1))
                {
					if (isset($markergroups) && !empty($markergroups)) 
					{
						foreach ($markergroups as $key => $currentmarkergroup) 
						{
							if (((int)$currentmarkergroup->published == 1) || ($allowUserMarker == 1))
							{
								//if ((int)$currentmarkergroup->activeincluster == 1)
								//{
										$scripttext .= 'callClusterFill('.$currentmarkergroup->id.');' ."\n";
								//}
							}
						}
					}
                }
                else
                {
					if (isset($markergroups) && !empty($markergroups)) 
					{
						foreach ($markergroups as $key => $currentmarkergroup) 
						{
							if (((int)$currentmarkergroup->published == 1) || ($allowUserMarker == 1))
							{
								//if ((int)$currentmarkergroup->activeincluster == 1)
								//{
										$scripttext .= 'markerCluster0.addMarkers(clustermarkers'.$currentmarkergroup->id.');' ."\n";
								//}
							}
						}
					}
                }
            }
			/*
            else
            {
                if ((isset($map->markerclustergroup) && (int)$map->markerclustergroup == 1))
                {      
					if (isset($markergroups) && !empty($markergroups)) 
					{
						foreach ($markergroups as $key => $currentmarkergroup) 
						{
							//if ((int)$currentmarkergroup->published == 1)
							if ((int)$currentmarkergroup->published == 0)
							{
								//if ((int)$currentmarkergroup->activeincluster == 0)
								//{
										$scripttext .= 'callMarkerDisable(clustermarkers'.$currentmarkergroup->id.');' ."\n";
								//}
							}
						}
					}
                }
            }
			*/
     }

	if ((isset($map->autoposition) && (int)$map->autoposition == 1))
	{
			$scripttext .= 'findMyPosition("Map");' ."\n";
	}

	if ($credits != '')
	{
		$scripttext .= '  document.getElementById("GMapsCredit").innerHTML = \''.$credits.'\';'."\n";
	}


	//$scripttext .= 'alert("'.$doAddToListCount.'");'."\n";

	// Do open list if preset to yes
	if (isset($map->markerlistpos) && (int)$map->markerlistpos != 0) 
	{
		if ((int)$map->markerlistpos == 111
		  ||(int)$map->markerlistpos == 112
		  ||(int)$map->markerlistpos == 121
		  ) 
		{
			// We don't have to do in any case when table or external
			// because it displayed		
		}
		else
		{
			if ((int)$map->markerlistbuttontype == 0)
			{
				// Open because for non-button
				$scripttext .= '	var toShowDiv = document.getElementById("GMapsMarkerList");' ."\n";
				$scripttext .= '	toShowDiv.style.display = "block";' ."\n";
			}
			else
			{
				switch ($map->markerlistbuttontype) 
				{
					case 0:
						$scripttext .= '	var toShowDiv = document.getElementById("GMapsMarkerList");' ."\n";
						$scripttext .= '	toShowDiv.style.display = "block";' ."\n";
					break;
					case 1:
						$scripttext .= '';
					break;
					case 2:
						$scripttext .= '';
					break;
					case 11:
						$scripttext .= '	var toShowDiv = document.getElementById("GMapsMarkerList");' ."\n";
						$scripttext .= '	toShowDiv.style.display = "block";' ."\n";
					break;
					case 12:
						$scripttext .= '	var toShowDiv = document.getElementById("GMapsMarkerList");' ."\n";
						$scripttext .= '	toShowDiv.style.display = "block";' ."\n";
					break;
					default:
						$scripttext .= '';
					break;
				}
			}
								
		}	
	}
	// Open Placemark List Presets

	// AdSence - begin
	if (isset($adsences) && !empty($adsences)) 
	{
			
		// Main loop
		foreach ($adsences as $key => $currentadsence) 
		{

			$scripttext .= 'var adUnitDiv'.$currentadsence->id.' = document.createElement(\'div\');' ."\n";

			$scripttext .= 'var adUnitOptions'.$currentadsence->id.' = {' ."\n";
			

  			if (isset($currentadsence->unitformat)) 
			{
				switch ($currentadsence->unitformat) 
				{
					case 0:
					break;
					case 1:
							$scripttext .= 'format: google.maps.adsense.AdFormat.BANNER ,' ."\n";
					break;
					case 2:
							$scripttext .= 'format: google.maps.adsense.AdFormat.BUTTON ,' ."\n";
					break;
					case 3:
							$scripttext .= 'format: google.maps.adsense.AdFormat.HALF_BANNER ,' ."\n";
					break;
					case 4:
							$scripttext .= 'format: google.maps.adsense.AdFormat.LARGE_RECTANGLE ,' ."\n";
					break;
					case 5:
							$scripttext .= 'format: google.maps.adsense.AdFormat.LEADERBOARD ,' ."\n";
					break;
					case 6:
							$scripttext .= 'format: google.maps.adsense.AdFormat.MEDIUM_RECTANGLE ,' ."\n";
					break;
					case 7:
							$scripttext .= 'format: google.maps.adsense.AdFormat.SKYSCRAPER ,' ."\n";
					break;
					case 8:
							$scripttext .= 'format: google.maps.adsense.AdFormat.SMALL_RECTANGLE ,' ."\n";
					break;
					case 9:
							$scripttext .= 'format: google.maps.adsense.AdFormat.SMALL_SQUARE ,' ."\n";
					break;
					case 10:
							$scripttext .= 'format: google.maps.adsense.AdFormat.SQUARE ,' ."\n";
					break;
					case 11:
							$scripttext .= 'format: google.maps.adsense.AdFormat.VERTICAL_BANNER ,' ."\n";
					break;
					case 12:
							$scripttext .= 'format: google.maps.adsense.AdFormat.WIDE_SKYSCRAPER ,' ."\n";
					break;
					default:
						$scripttext .= '' ."\n";
					break;
				}
			}
						
			if (isset($currentadsence->unitpos)) 
			{
				switch ($currentadsence->unitpos) 
				{
					case 0:
					break;
					case 1:
							$scripttext .= 'position: google.maps.ControlPosition.TOP_CENTER ,' ."\n";
					break;
					case 2:
							$scripttext .= 'position: google.maps.ControlPosition.TOP_LEFT ,' ."\n";
					break;
					case 3:
							$scripttext .= 'position: google.maps.ControlPosition.TOP_RIGHT ,' ."\n";
					break;
					case 4:
							$scripttext .= 'position: google.maps.ControlPosition.LEFT_TOP ,' ."\n";
					break;
					case 5:
							$scripttext .= 'position: google.maps.ControlPosition.RIGHT_TOP ,' ."\n";
					break;
					case 6:
							$scripttext .= 'position: google.maps.ControlPosition.LEFT_CENTER ,' ."\n";
					break;
					case 7:
							$scripttext .= 'position: google.maps.ControlPosition.RIGHT_CENTER ,' ."\n";
					break;
					case 8:
							$scripttext .= 'position: google.maps.ControlPosition.LEFT_BOTTOM ,' ."\n";
					break;
					case 9:
							$scripttext .= 'position: google.maps.ControlPosition.RIGHT_BOTTOM ,' ."\n";
					break;
					case 10:
							$scripttext .= 'position: google.maps.ControlPosition.BOTTOM_CENTER ,' ."\n";
					break;
					case 11:
							$scripttext .= 'position: google.maps.ControlPosition.BOTTOM_LEFT ,' ."\n";
					break;
					case 12:
							$scripttext .= 'position: google.maps.ControlPosition.BOTTOM_RIGHT ,' ."\n";
					break;
					default:
						$scripttext .= '' ."\n";
					break;
				}
			}

			$scripttext .= '  publisherId: \''.$currentadsence->publisherid.'\',' ."\n";
			
			if ($currentadsence->channelnumber != "")
			{
				$scripttext .= '  channelNumber: \''.$currentadsence->channelnumber.'\',' ."\n";
			}
			
			$scripttext .= '  map: map,' ."\n";
			$scripttext .= '  visible: true' ."\n";
			$scripttext .= '};' ."\n";
			$scripttext .= 'var adUnit'.$currentadsence->id.' = new google.maps.adsense.AdUnit(adUnitDiv'.$currentadsence->id.', adUnitOptions'.$currentadsence->id.');' ."\n";
		
		}
	}
	// AdSence - end
	
	
// end initialize
$scripttext .= '};' ."\n";

//
//

	$scripttext .= 'function showPlacemarkPanorama(p_width, p_height, p_pov) {' ."\n";
	$scripttext .= '  var contentStringStreetView = "" + ' ."\n";
	$scripttext .= '\'<div id="contentStringStreetView" style="width:\'+p_width+\'px;height:\'+p_height+\'px;">\'+'."\n";
	$scripttext .= '\'</div>\';'."\n";
	
	$scripttext .= '  infowindow.close();' ."\n";
	$scripttext .= '  infowindow.setContent(contentStringStreetView);' ."\n";												
	$scripttext .= '  infowindow.open(map);' ."\n";

	$scripttext .= '  var infowindowpanorama = new google.maps.StreetViewPanorama(document.getElementById("contentStringStreetView"),' ."\n";
	$scripttext .= '   {' ."\n";
	$scripttext .= '  	navigationControl: true,' ."\n";
	//$scripttext .= '  		navigationControlOptions: {style: google.maps.NavigationControlStyle.ANDROID},' ."\n";
	$scripttext .= '  	enableCloseButton: false,' ."\n";
	$scripttext .= '  	addressControl: false,' ."\n";
	$scripttext .= '  	linksControl: false' ."\n";
	$scripttext .= '   }' ."\n";
	$scripttext .= '  );' ."\n";
	
	$scripttext .= '  infowindowpanorama.setPosition(infowindow.getPosition());' ."\n";
	$scripttext .= '  if (p_pov != "")' ."\n";
	$scripttext .= '  {' ."\n";
	$scripttext .= '    infowindowpanorama.setPov(p_pov);'."\n";
	$scripttext .= '  }' ."\n";
	
	$scripttext .= '  var infowindowListenterHandle = google.maps.event.addListener(infowindow, \'domready\', function() {' ."\n";
	$scripttext .= '  	google.maps.event.trigger(infowindowpanorama, \'resize\');' ."\n";
	$scripttext .= '  	google.maps.event.removeListener(infowindowListenterHandle);' ."\n";
	$scripttext .= '  });' ."\n";
	$scripttext .= '};' ."\n";

	$scripttext .= 'function setRouteDestination(p_direction) {' ."\n";
	$scripttext .= '  routedirection = p_direction;' ."\n";
	$scripttext .= '  var cur_panel = document.getElementById("GMapFindPanelIcon");' ."\n";
	$scripttext .= '  var cur_target = document.getElementById("GMapFindTargetIcon");' ."\n";
	$scripttext .= '  var cur_target_text = document.getElementById("GMapFindTargetText");' ."\n";
	$scripttext .= '  cur_target_text.innerHTML = \'\'+infowindow.get("zhgmPlacemarkTitle")+\'\''."\n";
	$scripttext .= '  if (routedirection == 1)' ."\n";
	$scripttext .= '  {' ."\n";
	$scripttext .= '  	cur_panel.innerHTML = \'<a href="#" onclick="';
	$scripttext .= 'setRouteDestinationChange();';
	$scripttext .= 'return false;"><img style="border: 0px none; padding: 0px; margin: 0px;" src="'.$imgpathUtils.'a.png"></a>\';'."\n";
	$scripttext .= '  	cur_target.innerHTML = \'<a href="#" onclick="';
	$scripttext .= 'setRouteDestinationChange();';
	$scripttext .= 'return false;"><img style="border: 0px none; padding: 0px; margin: 0px;" src="'.$imgpathUtils.'b.png"></a>\';'."\n";
	$scripttext .= '  }' ."\n";
	$scripttext .= '  else' ."\n";
	$scripttext .= '  {' ."\n";
	$scripttext .= '  	cur_panel.innerHTML = \'<a href="#" onclick="';
	$scripttext .= 'setRouteDestinationChange();';
	$scripttext .= 'return false;"><img style="border: 0px none; padding: 0px; margin: 0px;" src="'.$imgpathUtils.'b.png"></a>\';'."\n";
	$scripttext .= '  	cur_target.innerHTML = \'<a href="#" onclick="';
	$scripttext .= 'setRouteDestinationChange();';
	$scripttext .= 'return false;"><img style="border: 0px none; padding: 0px; margin: 0px;" src="'.$imgpathUtils.'a.png"></a>\';'."\n";
	$scripttext .= '  }' ."\n";
	$scripttext .= '  routedestination = infowindow.getPosition();' ."\n";
	$scripttext .= '};' ."\n";

	$scripttext .= 'function setRouteDestinationChange() {' ."\n";
	$scripttext .= '	if (routedirection == 0)' ."\n";
	$scripttext .= '	{' ."\n";
	$scripttext .= '		setRouteDestination(1);' ."\n";
	$scripttext .= '	}' ."\n";
	$scripttext .= '	else' ."\n";
	$scripttext .= '	{' ."\n";
	$scripttext .= '		setRouteDestination(0);' ."\n";
	$scripttext .= '	}' ."\n";
	$scripttext .= '};' ."\n";

if ($featurePathElevation == 1)
{
	$scripttext .= 'function elevationPlotDiagram(';
	$scripttext .= ' el_coords, ';
	$scripttext .= ' el_count, ';
	$scripttext .= ' el_width, ';
	$scripttext .= ' el_height, ';
	$scripttext .= ' el_icon, ';
	$scripttext .= ' el_type, ';
	$scripttext .= ' el_baseline,';
	$scripttext .= ' el_baseline_color,' ."\n";
	$scripttext .= ' el_gridline_color,' ."\n";
	$scripttext .= ' el_gridline_count,' ."\n";
	$scripttext .= ' el_minor_gridline_color,' ."\n";
	$scripttext .= ' el_minor_gridline_count,'."\n";
	$scripttext .= ' el_bg_color,' ."\n";
	$scripttext .= ' el_bg_width,' ."\n";
	$scripttext .= ' el_bg_fill,' ."\n";
	$scripttext .= ' el_max_value,' ."\n";
	$scripttext .= ' el_min_value' ."\n";
	$scripttext .= ' ) ';
	$scripttext .= ' {' ."\n";
	$scripttext .= ' if (el_count == 0)' ."\n";
	$scripttext .= ' {' ."\n";
	$scripttext .= ' 	var chartPathRequest = {' ."\n";
	$scripttext .= '		  \'path\': el_coords,' ."\n";
	$scripttext .= '		  \'samples\': el_width'."\n";
	$scripttext .= '		};' ."\n";
	$scripttext .= ' }' ."\n";
	$scripttext .= ' else' ."\n";
	$scripttext .= ' {' ."\n";
	$scripttext .= ' 	var chartPathRequest = {' ."\n";
	$scripttext .= '		  \'path\': el_coords,' ."\n";
	$scripttext .= '		  \'samples\': el_count'."\n";
	$scripttext .= '		};' ."\n";
	$scripttext .= ' }' ."\n";
	
	// Initiate the path request.
	$scripttext .= '  elevator.getElevationAlongPath(chartPathRequest, plotChartElevation);	' ."\n";
	// Takes an array of ElevationResult objects, plots the elevation profile on a Visualization API ColumnChart.
	$scripttext .= '  function plotChartElevation(results, status) ' ."\n";
	$scripttext .= '  {' ."\n";
	$scripttext .= '	if (status == google.maps.ElevationStatus.OK) {' ."\n";
	$scripttext .= '	  elevations = results;' ."\n";

	// Create a new chart in the DIV.
	$scripttext .= 'if (el_type == 1)' ."\n";
	$scripttext .= '{' ."\n";
	$scripttext .= '	var chart = new google.visualization.AreaChart(document.getElementById(\'GMapsPathPanel\'));' ."\n";
	$scripttext .= '}' ."\n";
	$scripttext .= 'else if (el_type == 2)' ."\n";
	$scripttext .= '{' ."\n";
	$scripttext .= '	var chart = new google.visualization.LineChart(document.getElementById(\'GMapsPathPanel\'));' ."\n";
	$scripttext .= '}' ."\n";
	$scripttext .= 'else if (el_type == 3)' ."\n";
	$scripttext .= '{' ."\n";
	$scripttext .= '	var chart = new google.visualization.ColumnChart(document.getElementById(\'GMapsPathPanel\'));' ."\n";
	$scripttext .= '}' ."\n";
	$scripttext .= 'else' ."\n";
	$scripttext .= '{' ."\n";
	$scripttext .= '	var chart = new google.visualization.AreaChart(document.getElementById(\'GMapsPathPanel\'));' ."\n";
	$scripttext .= '}' ."\n";

	// Extract the data from which to populate the chart.
	// Because the samples are equidistant, the 'Sample'
	// column here does double duty as distance along the
	// X axis.
	$scripttext .= '	  var data = new google.visualization.DataTable();' ."\n";
	$scripttext .= '	  data.addColumn(\'string\', \'Sample\');' ."\n";
	$scripttext .= '	  data.addColumn(\'number\', \''.
		JText::_('MOD_ZHGOOGLEMAP_MAP_ELEVATION1').
		' ('.JText::_('MOD_ZHGOOGLEMAP_MAP_ELEVATION_M').')'.'\');' ."\n";
	$scripttext .= '	  data.addColumn(\'number\', \'Lat\');' ."\n";
	$scripttext .= '	  data.addColumn(\'number\', \'Lng\');' ."\n";
	$scripttext .= '	  for (var i = 0; i < elevations.length; i++) {' ."\n";
	$scripttext .= '		data.addRow([\'\', elevations[i].elevation, elevations[i].location.lat(), elevations[i].location.lng()]);' ."\n";
	$scripttext .= '	  }' ."\n";

	$scripttext .= '	  var formatter_2d = new google.visualization.NumberFormat({' ."\n";
	$scripttext .= '	  	  fractionDigits: 2' ."\n";
	$scripttext .= '	  	, decimalSymbol: \'.\'' ."\n";
	$scripttext .= '	  	, groupingSymbol: \'\'' ."\n";
	$scripttext .= '	  });' ."\n";
    $scripttext .= '	  formatter_2d.format(data, 1);' ."\n";

	$scripttext .= '	  var dataView = new google.visualization.DataView(data);' ."\n";
	$scripttext .= '	  dataView.setColumns([0, 1]);' ."\n";

	// Draw the chart using the data within its DIV.
	$scripttext .= '	  document.getElementById(\'GMapsPathPanel\').style.display = \'block\';' ."\n";
	$scripttext .= ' 	  var chartOptions = {' ."\n";
	$scripttext .= '		width: el_width,' ."\n";
	$scripttext .= '		height: el_height,' ."\n";
	$scripttext .= '		legend: \'none\',' ."\n";
	$scripttext .= '		backgroundColor: {' ."\n";
	$scripttext .= '				 stroke: el_bg_color,' ."\n";
	$scripttext .= '				 strokeWidth: el_bg_width,' ."\n";
	$scripttext .= '				 fill: el_bg_fill' ."\n";
	$scripttext .= '		},' ."\n";
	$scripttext .= '		vAxis: { baseline: el_baseline,' ."\n";
	$scripttext .= '				 baselineColor: el_baseline_color,' ."\n";
	$scripttext .= '				 gridlines: {' ."\n";
	$scripttext .= '				 	color: el_gridline_color,' ."\n";
	$scripttext .= '				 	count: el_gridline_count' ."\n";
	$scripttext .= '				 },' ."\n";
	$scripttext .= '				 minorGridlines: {' ."\n";
	$scripttext .= '				 	color: el_minor_gridline_color,' ."\n";
	$scripttext .= '				 	count: el_minor_gridline_count'."\n";
	$scripttext .= '				 },' ."\n";
	$scripttext .= '				 maxValue: el_max_value,' ."\n";
	$scripttext .= '				 minValue: el_min_value,' ."\n";
	$scripttext .= '				 title: \''.JText::_('MOD_ZHGOOGLEMAP_MAP_ELEVATION').'\'' ."\n";
	$scripttext .= '			   }' ."\n";
	$scripttext .= '		};' ."\n";
	$scripttext .= '	  chart.draw(dataView, chartOptions);' ."\n";


	// When the chart is selected, update the table chart.
	$scripttext .= '	google.visualization.events.addListener(chart, \'select\', function() {' ."\n";
	$scripttext .= '	  var selectedItem = chart.getSelection()[0];' ."\n";
	$scripttext .= '	  if (selectedItem)' ."\n";
	$scripttext .= '	  {' ."\n";
    $scripttext .= '	      var value0 = data.getValue(selectedItem.row, 1);' ."\n";
    $scripttext .= '	      var valuelat = data.getValue(selectedItem.row, 2);' ."\n";
    $scripttext .= '	      var valuelng = data.getValue(selectedItem.row, 3);' ."\n";
    $scripttext .= '  	infowindow.close();' ."\n";
	$scripttext .= '	infowindow.setContent("'.JText::_('MOD_ZHGOOGLEMAP_MAP_ELEVATION1').
					' '.JText::_('MOD_ZHGOOGLEMAP_MAP_ELEVATION2').
					' " + value0.toFixed(1) + " '.JText::_('MOD_ZHGOOGLEMAP_MAP_ELEVATION_M').'");' ."\n";
	$scripttext .= '	infowindow.setPosition(new google.maps.LatLng(valuelat, valuelng));' ."\n";
	$scripttext .= '	infowindow.open(map);' ."\n";
	$scripttext .= '	  }' ."\n";
	$scripttext .= '	});' ."\n";

    $scripttext .= '	google.visualization.events.addListener(chart, \'onmouseover\', function(e) {' ."\n";
    $scripttext .= '	    if (markerElevation == null) {' ."\n";
    $scripttext .= '	      markerElevation = new google.maps.Marker({' ."\n";
    $scripttext .= '	        position: elevations[e.row].location,' ."\n";
    $scripttext .= '	        map: map,' ."\n";
    $scripttext .= '	        icon: icoIcon + el_icon' ."\n";
    $scripttext .= '	      });' ."\n";
    $scripttext .= '	    } else {' ."\n";
    $scripttext .= '	      markerElevation.setPosition(elevations[e.row].location);' ."\n";
    $scripttext .= '	    }' ."\n";
    $scripttext .= '	});' ."\n";
	$scripttext .= '	google.visualization.events.addListener(chart, \'onmouseout\', function(e) {' ."\n";
	$scripttext .= '  		if (markerElevation != null) {' ."\n";
	$scripttext .= '   		 markerElevation.setMap(null);' ."\n";
	$scripttext .= '   		 markerElevation = null;' ."\n";
	$scripttext .= '  		}' ."\n";
	$scripttext .= '	});' ."\n";
	
	$scripttext .= '	}' ."\n";
	$scripttext .= '  }' ."\n";						
	$scripttext .= '}' ."\n";

	
	// Remove the green rollover marker when the mouse leaves the chart
	$scripttext .= 'function clearMarkerElevation() {' ."\n";
	//$scripttext .= '  if (markerElevation != null) {' ."\n";
	//$scripttext .= '    markerElevation.setMap(null);' ."\n";
	//$scripttext .= '    markerElevation = null;' ."\n";
	//$scripttext .= '  }' ."\n";
	$scripttext .= '}' ."\n";
}
	
if ($compatiblemode == 1)
{
	// for IE under 8
	$scripttext .= '		function myHasClass(ele,cls) {' ."\n";
	$scripttext .= '		    var reg = new RegExp(\'(\\s|^)\'+cls+\'(\\s|$)\');' ."\n";
	$scripttext .= '			return ele.className.match(reg);' ."\n";
	$scripttext .= '		}' ."\n";

	$scripttext .= '		function myAddClass(ele,cls) {' ."\n";
	$scripttext .= '			if (!myHasClass(ele,cls)) {' ."\n";
	$scripttext .= '			   if (ele.className == "")' ."\n";
	$scripttext .= '		   	   {' ."\n";
	$scripttext .= '			    ele.className += cls;' ."\n";
	$scripttext .= '			   }' ."\n";
	$scripttext .= '			   else' ."\n";
	$scripttext .= '			   {' ."\n";
	$scripttext .= '			    ele.className += " "+cls;' ."\n";
	$scripttext .= '			   }' ."\n";
	$scripttext .= '		    }' ."\n";
	$scripttext .= '		 }' ."\n";
			  
	$scripttext .= '		function myRemoveClass(ele,cls) {' ."\n";
	$scripttext .= '			if (myHasClass(ele,cls)) {' ."\n";
	$scripttext .= '				var reg = new RegExp(\'(\\s|^)\'+cls+\'(\\s|$)\');' ."\n";
	$scripttext .= '				ele.className=ele.className.replace(reg,\' \');' ."\n";
	$scripttext .= '				ele.className=ele.className.replace(/\s+/g,\' \');' ."\n";
	$scripttext .= '				ele.className=ele.className.replace(/^\s|\s$/,\'\');' ."\n";
	$scripttext .= '				if (ele.className == " ")' ."\n";
	$scripttext .= '				{' ."\n";
	$scripttext .= '				  ele.className ="";' ."\n";
	$scripttext .= '				}' ."\n";
	$scripttext .= '			}' ."\n";
	$scripttext .= '		}' ."\n";
					 
	$scripttext .= '	    function myToggleClass(elem, cls){' ."\n";
	$scripttext .= '	        if(myHasClass(elem, cls)){' ."\n";
	$scripttext .= '	            myRemoveClass(elem, cls);' ."\n";
	$scripttext .= '	        } else  {' ."\n";
	$scripttext .= '	            myAddClass(elem, cls);' ."\n";
	$scripttext .= '	        }' ."\n";
	$scripttext .= '	    }' ."\n";
}
//
//

// ajax request action function
if (isset($map->useajax) && (int)$map->useajax == 1) 
{

	$scripttext .= 'function ShowPlacemarkInformation(responseObject, markerObject){' ."\n";
	$scripttext .= 'if (responseObject.dataexists == 1)' ."\n";
	$scripttext .= ' {' ."\n";
	$scripttext .= '  var map = markerObject.getMap();' ."\n";
	$scripttext .= '  var actionbyclick = parseInt(responseObject.actionbyclick);' ."\n";
	$scripttext .= '  var zoombyclick = parseInt(responseObject.zoombyclick);' ."\n";
	
	$scripttext .= ' if (actionbyclick == 0)' ."\n";
	$scripttext .= ' {' ."\n";
	$scripttext .= '    if (zoombyclick != 100)' ."\n";
	$scripttext .= '    {' ."\n";
	$scripttext .= '  		map.setCenter(markerObject.getPosition());' ."\n";
	$scripttext .= '  		map.setZoom(zoombyclick);' ."\n";
	$scripttext .= '    }' ."\n";
	$scripttext .= ' }' ."\n";
	$scripttext .= ' else if (actionbyclick == 1)' ."\n";
	$scripttext .= ' {' ."\n";
	$scripttext .= '    if (zoombyclick != 100)' ."\n";
	$scripttext .= '    {' ."\n";
	$scripttext .= '  		map.setCenter(markerObject.getPosition());' ."\n";
	$scripttext .= '  		map.setZoom(zoombyclick);' ."\n";
	$scripttext .= '    }' ."\n";
	$scripttext .= '  infowindow.close();' ."\n";
	// Close the other infobubbles
	$scripttext .= '  for (i = 0; i < infobubblemarkers.length; i++) {' ."\n";
	$scripttext .= '      infobubblemarkers[i].close();' ."\n";
	$scripttext .= '  }' ."\n";
	// Open Infowin
	$scripttext .= 'var contentstring = eval(responseObject.contentstring);' ."\n";
	$scripttext .= '  infowindow.set("zhgmPlacemarkTitle", responseObject.titleplacemark);' ."\n";
	$scripttext .= '  infowindow.setContent(contentstring);' ."\n";
	$scripttext .= '  infowindow.setPosition(markerObject.getPosition());' ."\n";
	$scripttext .= '  infowindow.open(map);' ."\n";

	$scripttext .= ' }' ."\n";
	$scripttext .= ' else if (actionbyclick == 2)' ."\n";
	$scripttext .= ' {' ."\n";
	$scripttext .= '    if (zoombyclick != 100)' ."\n";
	$scripttext .= '    {' ."\n";
	$scripttext .= '  		map.setCenter(markerObject.getPosition());' ."\n";
	$scripttext .= '  		map.setZoom(zoombyclick);' ."\n";
	$scripttext .= '    }' ."\n";
	$scripttext .= '    var sitelocation = responseObject.hrefsite;'."\n";	
	$scripttext .= '    window.open(sitelocation);' ."\n";
	$scripttext .= ' }' ."\n";
	$scripttext .= ' else if (actionbyclick == 3)' ."\n";
	$scripttext .= ' {' ."\n";
	$scripttext .= '    if (zoombyclick != 100)' ."\n";
	$scripttext .= '    {' ."\n";
	$scripttext .= '  		map.setCenter(markerObject.getPosition());' ."\n";
	$scripttext .= '  		map.setZoom(zoombyclick);' ."\n";
	$scripttext .= '    }' ."\n";
	$scripttext .= '    var sitelocation = responseObject.hrefsite;'."\n";	
	$scripttext .= '    window.location = sitelocation;' ."\n";
	$scripttext .= ' }' ."\n";
	$scripttext .= ' else if (actionbyclick == 4)' ."\n";
	$scripttext .= ' {' ."\n";
	$scripttext .= '    if (zoombyclick != 100)' ."\n";
	$scripttext .= '    {' ."\n";
	$scripttext .= '  		map.setCenter(markerObject.getPosition());' ."\n";
	$scripttext .= '  		map.setZoom(zoombyclick);' ."\n";
	$scripttext .= '    }' ."\n";
	$scripttext .= '    var infobubblestyle;'."\n";	
	$scripttext .= '    if (responseObject.infobubblestyle != "")'."\n";
	$scripttext .= '    {'."\n";
	$scripttext .= '    	infobubblestyle = eval("("+responseObject.infobubblestyle+")");'."\n";	
	$scripttext .= '    }'."\n";
	$scripttext .= '    else'."\n";
	$scripttext .= '    {'."\n";
	$scripttext .= '    	infobubblestyle = "";'."\n";	
	$scripttext .= '    }'."\n";
	$scripttext .= '   var infoBubble = new InfoBubble('."\n";
	$scripttext .= '     infobubblestyle'."\n";
	$scripttext .= '  );'."\n";
	$scripttext .= '  infobubblemarkers.push(infoBubble);'."\n";
	$scripttext .= '  if (responseObject.tab1 != "")'."\n";
	$scripttext .= '  {'."\n";
	$scripttext .= '  	infoBubble.addTab(responseObject.tab1title, responseObject.tab1);'."\n";
	$scripttext .= '  }'."\n";
	$scripttext .= '  if (responseObject.tab2 != "")'."\n";
	$scripttext .= '  {'."\n";
	$scripttext .= '  	infoBubble.addTab(responseObject.tab2title, responseObject.tab2);'."\n";
	$scripttext .= '  }'."\n";
	$scripttext .= '  if (responseObject.tab3 != "")'."\n";
	$scripttext .= '  {'."\n";
	$scripttext .= '  	infoBubble.addTab(responseObject.tab3title, responseObject.tab3);'."\n";
	$scripttext .= '  }'."\n";
	$scripttext .= '  if (responseObject.tab4 != "")'."\n";
	$scripttext .= '  {'."\n";
	$scripttext .= '  	infoBubble.addTab(responseObject.tab4title, responseObject.tab4);'."\n";
	$scripttext .= '  }'."\n";
	$scripttext .= '  if (responseObject.tab5 != "")'."\n";
	$scripttext .= '  {'."\n";
	$scripttext .= '  	infoBubble.addTab(responseObject.tab5title, responseObject.tab5);'."\n";
	$scripttext .= '  }'."\n";
	$scripttext .= '  if (responseObject.tab6 != "")'."\n";
	$scripttext .= '  {'."\n";
	$scripttext .= '  	infoBubble.addTab(responseObject.tab6title, responseObject.tab6);'."\n";
	$scripttext .= '  }'."\n";
	$scripttext .= '  if (responseObject.tab7 != "")'."\n";
	$scripttext .= '  {'."\n";
	$scripttext .= '  	infoBubble.addTab(responseObject.tab7title, responseObject.tab7);'."\n";
	$scripttext .= '  }'."\n";
	$scripttext .= '  if (responseObject.tab8 != "")'."\n";
	$scripttext .= '  {'."\n";
	$scripttext .= '  	infoBubble.addTab(responseObject.tab8title, responseObject.tab8);'."\n";
	$scripttext .= '  }'."\n";
	$scripttext .= '  if (responseObject.tab9 != "")'."\n";
	$scripttext .= '  {'."\n";
	$scripttext .= '  	infoBubble.addTab(responseObject.tab9title, responseObject.tab9);'."\n";
	$scripttext .= '  }'."\n";
	$scripttext .= '  if (!infoBubble.isOpen())'."\n";
	$scripttext .= '  {'."\n";
	$scripttext .= '  	infowindow.close();' ."\n";
	// Close the other infobubbles
	$scripttext .= ' 	 for (i = 0; i < infobubblemarkers.length; i++) {' ."\n";
	$scripttext .= '    	  infobubblemarkers[i].close();' ."\n";
	$scripttext .= '  	}' ."\n";
	// Open infobubble
	$scripttext .= '  	infoBubble.open(map, markerObject);'."\n";
	$scripttext .= '  }'."\n";
	$scripttext .= ' }' ."\n";
	$scripttext .= ' else if (actionbyclick == 5)' ."\n";
	$scripttext .= ' {' ."\n";
	$scripttext .= '    if (zoombyclick != 100)' ."\n";
	$scripttext .= '    {' ."\n";
	$scripttext .= '  		map.setCenter(markerObject.getPosition());' ."\n";
	$scripttext .= '  		map.setZoom(zoombyclick);' ."\n";
	$scripttext .= '    }' ."\n";
	$scripttext .= '  	var streetviewinfowinmapsv = responseObject.streetviewinfowinmapsv;' ."\n";
	$scripttext .= '  	var streetviewinfowinw = parseInt(responseObject.streetviewinfowinw);' ."\n";
	$scripttext .= '  	var streetviewinfowinh = parseInt(responseObject.streetviewinfowinh);' ."\n";
	if (isset($map->streetview) && (int)$map->streetview != 0) 
	{
		$scripttext .= '  panorama.setPosition(markerObject.getPosition());' ."\n";

		
		$scripttext .= '  if (streetviewinfowinmapsv != "")' ."\n";
		$scripttext .= '  {' ."\n";
		$scripttext .= '  	panorama.setPov(streetviewinfowinmapsv);'."\n";
		$scripttext .= '  }' ."\n";
	}
	else
	{
		$scripttext .= '  infowindow.close();' ."\n";
		$scripttext .= '  for (i = 0; i < infobubblemarkers.length; i++) {' ."\n";
		$scripttext .= '      infobubblemarkers[i].close();' ."\n";
		$scripttext .= '  }' ."\n";
		$scripttext .= '  infowindow.setPosition(markerObject.getPosition());' ."\n";
		$scripttext .= '  if (streetviewinfowinmapsv == "")' ."\n";
		$scripttext .= '  {' ."\n";
		$scripttext .= '	showPlacemarkPanorama(streetviewinfowinw, streetviewinfowinh, \'\');'."\n";
		$scripttext .= '  }' ."\n";
		$scripttext .= '  else' ."\n";
		$scripttext .= '  {' ."\n";
		$scripttext .= '	showPlacemarkPanorama(streetviewinfowinw, streetviewinfowinh, streetviewinfowinmapsv);'."\n";
		$scripttext .= '  }' ."\n";
	}
	$scripttext .= ' }' ."\n";
	$scripttext .= ' else' ."\n";
	$scripttext .= ' {' ."\n";
	$scripttext .= '   alert("Unexpected action by click: "+responseObject.actionbyclick);' ."\n";
	$scripttext .= ' }' ."\n";
	
	$scripttext .= '}' ."\n";
	$scripttext .= 'else' ."\n";
	$scripttext .= '{' ."\n";
	$scripttext .= '   alert("No data found");' ."\n";
	$scripttext .= '}' ."\n";
	/*
		$scripttext .= '	document.getElementById(\'GMapsMainRoutePanel\').innerHTML = \'id=\'+responseObject.id
		+ \'<br />dataexists=\' + responseObject.dataexists 
		+ \'<br />usercontact=\' + responseObject.usercontact 
		+ \'<br />useruser=\' + responseObject.useruser 
		+ \'<br />streetviewinfowinw=\' + responseObject.streetviewinfowinw 
		+ \'<br />streetviewinfowinh=\' + responseObject.streetviewinfowinh 
		+ \'<br />streetviewinfowinmapsv=\' + responseObject.streetviewinfowinmapsv;' ."\n";
	*/
	
	// function end
	$scripttext .= '}' ."\n";
}

// For Marker Cluster Support Functions - begin
if (
    ((isset($map->markercluster) && (int)$map->markercluster == 1))            
    ||
    ((isset($map->markerclustergroup) && (int)$map->markerclustergroup == 1))
    ||
    (isset($map->markergroupcontrol) && (int)$map->markergroupcontrol != 0)             
   )
{          
    if ((isset($map->markercluster) && (int)$map->markercluster == 1))
    {

        if ((isset($map->markerclustergroup) && (int)$map->markerclustergroup == 1))
		{

			$scripttext .= 'function callClusterFill (clusterid){   ' ."\n";

				if (isset($markergroups) && !empty($markergroups)) 
				{
                    foreach ($markergroups as $key => $currentmarkergroup) 
                    {
                        $scripttext .= 'if ('.$currentmarkergroup->id.' == clusterid)' ."\n";
                        $scripttext .= '{'."\n";

                        if ((int)$map->clusterzoom == 0)
                        {
                            if ((int)$currentmarkergroup->overridegroupicon == 1)
                            {
                                $scripttext .= 'markerCluster'.$currentmarkergroup->id.'.addMarkers(clustermarkers'.$currentmarkergroup->id.');' ."\n";
                            }
                            else
                            {
                                $scripttext .= 'markerCluster'.$currentmarkergroup->id.'.addMarkers(clustermarkers'.$currentmarkergroup->id.');' ."\n";
                            }
                        }
                        else
                        {
                            if ((int)$currentmarkergroup->overridegroupicon == 1)
                            {
                                $scripttext .= 'markerCluster'.$currentmarkergroup->id.'.addMarkers(clustermarkers'.$currentmarkergroup->id.');' ."\n";
                            }
                            else
                            {
                                $scripttext .= 'markerCluster'.$currentmarkergroup->id.'.addMarkers(clustermarkers'.$currentmarkergroup->id.');' ."\n";
                            }
                        }
                        $scripttext .= '}'."\n";
                    }
				}
			$scripttext .= '};' ."\n";


                if (isset($map->markergroupcontrol) && (int)$map->markergroupcontrol != 0) 
                {
                    $scripttext .= 'function callMarkerChangeGroup (ancorname, clustername, groupid){   ' ."\n";
                    $scripttext .= 'var link = document.getElementById(ancorname);' ."\n";
					if ($compatiblemode == 1)
					{
						$scripttext .= '       if (myHasClass(link, "active")) ' ."\n";
					}
					else
					{
						$scripttext .= '       if (link.hasClass("active"))' ."\n";
					}
                    $scripttext .= '           { ' ."\n";
                    $scripttext .= '           clustername.clearMarkers();' ."\n";
                    $scripttext .= '       } else ' ."\n";
                    $scripttext .= '           {    ' ."\n";
                    $scripttext .= '           if (clustername) ' ."\n";
                    $scripttext .= '           {' ."\n";
                    $scripttext .= '               clustername.clearMarkers();' ."\n";
                    $scripttext .= '           }' ."\n";
                    $scripttext .= '           callClusterFill(groupid);' ."\n";
                    $scripttext .= '       }' ."\n";
					if ($compatiblemode == 1)
					{
						$scripttext .= ' myToggleClass(link, "active"); ' ."\n";
					}
					else
					{
						$scripttext .= ' link.toggleClass("active"); ' ."\n";
					}
                    $scripttext .= '};' ."\n";
                }
		}
		else
		{
            if (isset($map->markergroupcontrol) && (int)$map->markergroupcontrol != 0) 
            {
			$scripttext .= 'function callMarkerChange (ancorname, markersArray){   ' ."\n";
			$scripttext .= 'var link = document.getElementById(ancorname);' ."\n";
			if ($compatiblemode == 1)
			{
				$scripttext .= '       if (myHasClass(link, "active")) {' ."\n";
			}
			else
			{
				$scripttext .= '       if (link.hasClass("active")) { ' ."\n";
			}
			//
			// new version of MarkerClusterer
	        //$scripttext .= '   	     for (var i=0; i<markersArray.length; i++)' ."\n";
	        //$scripttext .= '   	     {' ."\n";
	        //$scripttext .= '               markerCluster0.removeMarker(markersArray[i]);' ."\n";
	        //$scripttext .= '             }' ."\n";
			//
	        $scripttext .= '             markerCluster0.removeMarkers(markersArray);' ."\n";
			//
	        $scripttext .= '       } else {    ' ."\n";
	        $scripttext .= '             markerCluster0.addMarkers(markersArray);' ."\n";
        	$scripttext .= '       }' ."\n";
			if ($compatiblemode == 1)
			{
				$scripttext .= ' myToggleClass(link, "active"); ' ."\n";
			}
			else
			{
				$scripttext .= ' link.toggleClass("active"); ' ."\n";
			}
			$scripttext .= '};' ."\n";
            }
		}
     }
     else
     {
        if (isset($map->markergroupcontrol) && (int)$map->markergroupcontrol != 0) 
        {
            $scripttext .= 'function callMarkerArrayChange (ancorname, markersArray){   ' ."\n";
            $scripttext .= 'var link = document.getElementById(ancorname);' ."\n";
			if ($compatiblemode == 1)
			{
				$scripttext .= '       if (myHasClass(link, "active")) {' ."\n";
			}
			else
			{
				$scripttext .= '       if (link.hasClass("active")) { ' ."\n";
			}
            $scripttext .= '   	     for (var i=0; i<markersArray.length; i++)' ."\n";
            $scripttext .= '   	     {' ."\n";
            $scripttext .= '               markersArray[i].setMap(null);' ."\n";
            $scripttext .= '             }' ."\n";
            $scripttext .= '       } else {    ' ."\n";
            $scripttext .= '   	     for (var i=0; i<markersArray.length; i++)' ."\n";
            $scripttext .= '   	     {' ."\n";
            $scripttext .= '               markersArray[i].setMap(map);' ."\n";
            $scripttext .= '             }' ."\n";
            $scripttext .= '       }' ."\n";
			if ($compatiblemode == 1)
			{
				$scripttext .= ' myToggleClass(link, "active"); ' ."\n";
			}
			else
			{
				$scripttext .= ' link.toggleClass("active"); ' ."\n";
			}
            $scripttext .= '};' ."\n";
        }
        
        $scripttext .= 'function callMarkerDisable (markersArray){   ' ."\n";
        $scripttext .= ' for (var i=0; i<markersArray.length; i++)' ."\n";
        $scripttext .= ' {' ."\n";
        $scripttext .= '    markersArray[i].setMap(null);' ."\n";
        $scripttext .= ' }' ."\n";
        $scripttext .= '};' ."\n";
        
     }

}
// For Marker Cluster Support Functions - end


    // For Places Support functions
    if ((isset($map->placesenable) && (int)$map->placesenable == 1))
    {
      $scripttext .= 'function callbackPlaces(results, status) {' ."\n";
      $scripttext .= '  if (status == google.maps.places.PlacesServiceStatus.OK) {' ."\n";
      $scripttext .= '    for (var i = 0; i < results.length; i++) {' ."\n";
      $scripttext .= '      createPlacesMarker(results[i]);' ."\n";
      $scripttext .= '    }' ."\n";
      $scripttext .= '  }' ."\n";
      $scripttext .= '};' ."\n";

      $scripttext .= 'function createPlacesMarker(place) {' ."\n";
	  // Clusterization not implementing (like map baloon, into clusterer0)
	  //   because limit = only 20 in result
      $scripttext .= '  var marker = new google.maps.Marker({' ."\n";
	  $scripttext .= '      map: map, ' ."\n";
      $scripttext .= '    position: place.geometry.location' ."\n";
      $scripttext .= '  });' ."\n";

      $scripttext .= '  var image = new google.maps.MarkerImage(' ."\n";
      $scripttext .= '  place.icon, null,' ."\n";
      $scripttext .= '  new google.maps.Point(0, 0), null,' ."\n";
      $scripttext .= '  new google.maps.Size(25, 25));' ."\n";
	  $scripttext .= '  marker.setIcon(image);' ."\n";

      $scripttext .= ' google.maps.event.addListener(marker, \'click\', function(event) {' ."\n";
	  $scripttext .= '  var markerTitle = place.name;' ."\n";
      $scripttext .= '  infowindow.close();' ."\n";
      $scripttext .= '  infowindow.setContent(markerTitle);' ."\n";
      $scripttext .= '  infowindow.open(map, marker);' ."\n";
      $scripttext .= ' });' ."\n";
      $scripttext .= '};' ."\n";
	}

    // For Elevation Support functions - Begin
    if ((isset($map->elevation) && (int)$map->elevation == 1))
    {
		$scripttext .= 'function getElevation(event) {' ."\n";

		$scripttext .= 'var locationsElevation = [];' ."\n";

		// Retrieve the clicked location and push it on the array
		$scripttext .= 'var clickedLocationElevation = event.latLng;' ."\n";
		$scripttext .= 'locationsElevation.push(clickedLocationElevation);' ."\n";

		// Create a LocationElevationRequest object using the array's one value
		$scripttext .= 'var positionalRequestElevation = {' ."\n";
		$scripttext .= '	\'locations\': locationsElevation' ."\n";
		$scripttext .= '}' ."\n";

		// Initiate the location request
		$scripttext .= 'elevator.getElevationForLocations(positionalRequestElevation, function(results, status) {' ."\n";
		$scripttext .= 'if (status == google.maps.ElevationStatus.OK) {' ."\n";

		// Retrieve the first result
		$scripttext .= '	if (results[0]) {' ."\n";

		// Open an info window indicating the elevation at the clicked position
		$scripttext .= '	infowindow.setContent("'.JText::_('MOD_ZHGOOGLEMAP_MAP_ELEVATION1').
						' '.JText::_('MOD_ZHGOOGLEMAP_MAP_ELEVATION2').
						' " + results[0].elevation.toFixed(1) + " '.JText::_('MOD_ZHGOOGLEMAP_MAP_ELEVATION_M').'");' ."\n";
		$scripttext .= '	infowindow.setPosition(clickedLocationElevation);' ."\n";
		$scripttext .= '	infowindow.open(map);' ."\n";
		$scripttext .= '	} else {' ."\n";
		$scripttext .= '		alert("'.JText::_('MOD_ZHGOOGLEMAP_MAP_ELEVATION_NO_DATA').'");' ."\n";
		$scripttext .= '	}' ."\n";
		$scripttext .= '} else {' ."\n";
		$scripttext .= 'alert("'.JText::_('MOD_ZHGOOGLEMAP_MAP_ELEVATION_FAILED').' " + status);' ."\n";
		$scripttext .= '}' ."\n";
		$scripttext .= '});' ."\n";
		$scripttext .= '};' ."\n";
	}
	//For Elevation Support functions - End
	
	// Geo Position - Begin
	if ((isset($map->autoposition) && (int)$map->autoposition == 1)
	 || (isset($map->geolocationcontrol) && (int)$map->geolocationcontrol == 1))
	{
			$scripttext .= 'function findMyPosition(AutoPosition, DirectionsDisplay, DirectionsService, Marker, SearchTravelMode, LocationDestination) {' ."\n";
	        // Try W3C Geolocation method (Preferred)
			//$scripttext .= 'alert("Try to find");'."\n";
	        $scripttext .= '    if (navigator.geolocation) {' ."\n";
			//$scripttext .= 'alert("Try W3C Geolocation method");'."\n";
        	$scripttext .= '        browserSupportFlag = true;' ."\n";
	        $scripttext .= '        navigator.geolocation.getCurrentPosition(function(position) {' ."\n";
        	$scripttext .= '        initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);' ."\n";
			$scripttext .= '        map.setCenter(initialLocation);' ."\n";
	        //$scripttext .= '          alertContentString = "Location found using W3C standard";' ."\n";
	        //$scripttext .= '          infowindow.setContent(alertContentString);' ."\n";
        	//$scripttext .= '          infowindow.setPosition(initialLocation);' ."\n";
	        //$scripttext .= '          infowindow.open(map);' ."\n";

			$scripttext .= '     if (AutoPosition == "Button")' ."\n";
			$scripttext .= '     {' ."\n";
			$scripttext .= '    	 placesACbyButton(0, DirectionsDisplay, DirectionsService, Marker, "", SearchTravelMode, initialLocation, LocationDestination);' ."\n";
			$scripttext .= '     }' ."\n";

        	$scripttext .= '        }, function() {' ."\n";
	        $scripttext .= '          handleNoGeolocation(browserSupportFlag);' ."\n";
        	$scripttext .= '        });' ."\n";
	        $scripttext .= '    } else if (google.gears) {' ."\n";
        	// Try Google Gears Geolocation
			//$scripttext .= 'alert("Try Google Gears Geolocation");'."\n";
	        $scripttext .= '        browserSupportFlag = true;' ."\n";
        	$scripttext .= '        var geo = google.gears.factory.create(\'beta.geolocation\');' ."\n";
	        $scripttext .= '        geo.getCurrentPosition(function(position) {' ."\n";
        	$scripttext .= '        initialLocation = new google.maps.LatLng(position.latitude,position.longitude);' ."\n";
			$scripttext .= '        map.setCenter(initialLocation);' ."\n";
	        //$scripttext .= '          alertContentString = "Location found using Google Gears";' ."\n";
	        //$scripttext .= '          infowindow.setContent(alertContentString);' ."\n";
        	//$scripttext .= '          infowindow.setPosition(initialLocation);' ."\n";
	        //$scripttext .= '          infowindow.open(map);' ."\n";

			$scripttext .= '     if (AutoPosition == "Button")' ."\n";
			$scripttext .= '     {' ."\n";
			$scripttext .= '    	 placesACbyButton(0, DirectionsDisplay, DirectionsService, Marker, "", SearchTravelMode, initialLocation, LocationDestination);' ."\n";
			$scripttext .= '     }' ."\n";

	        $scripttext .= '        }, function() {' ."\n";
        	$scripttext .= '          handleNoGeolocation(browserSupportFlag);' ."\n";
        	$scripttext .= '        });' ."\n";
	        $scripttext .= '    } else {' ."\n";
        	// Browser doesn\'t support Geolocation
			//$scripttext .= 'alert("Browser doesn\'t support Geolocation");'."\n";
	        $scripttext .= '        browserSupportFlag = false;' ."\n";
        	$scripttext .= '        handleNoGeolocation(browserSupportFlag);' ."\n";
	        $scripttext .= '    }' ."\n";
			$scripttext .= '};' ."\n";

			$scripttext .= 'function handleNoGeolocation(errorFlag) {' ."\n";
			$scripttext .= '  if (errorFlag == true) {' ."\n";
			$scripttext .= '    alertContentString = "'.JText::_('MOD_ZHGOOGLEMAP_MAP_GEOLOCATION_FAILED').'";' ."\n";
			$scripttext .= '  } else {' ."\n";
			$scripttext .= '    alertContentString = "'.JText::_('MOD_ZHGOOGLEMAP_MAP_GEOLOCATION_BROWSER_NOT_SUPPORT').'";' ."\n";
			$scripttext .= '  }' ."\n";
			$scripttext .= '  infowindow.setPosition(map.getCenter());' ."\n";
			$scripttext .= '  infowindow.setContent(alertContentString);' ."\n";
			$scripttext .= '  infowindow.open(map);' ."\n";
			$scripttext .= '};' ."\n";

			
	}
	// Geo Position - End
	
	// Begin placesACbyButton (for geo position button)
		if ((isset($map->placesautocomplete) && (int)$map->placesautocomplete == 1) 
		 || (isset($map->findcontrol) && (int)$map->findcontrol == 1) )
		{
			
			$scripttext .= ' function placesACbyButton (routeDoIt, placesDDisplay, placesDService, markerPlacesAC, markerPlacesACText, searchTravelModeAC, placeLocation, placeDestination) {' ."\n";
			
            $scripttext .= '  infowindow.close();' ."\n";
			
			$scripttext .= '  if (routeDoIt == 1) ' ."\n";
			$scripttext .= '  {' ."\n";
				$scripttext .= '  var searchTravelMode = document.getElementById(searchTravelModeAC);' ."\n";
				$scripttext .= '  var searchTravelModeText = searchTravelMode.options[searchTravelMode.selectedIndex].value;' ."\n";
				//$scripttext .= '  alert("Mode="+searchTravelModeText);' ."\n";
				$scripttext .= '  var searchTravelModeValue;'."\n";
				$scripttext .= '  if (searchTravelModeText == "google.maps.TravelMode.DRIVING") ';
				$scripttext .= '  {' ."\n";
				$scripttext .= '    searchTravelModeValue = google.maps.TravelMode.DRIVING;';
				$scripttext .= '  }' ."\n";
				$scripttext .= '  else if (searchTravelModeText == "google.maps.TravelMode.WALKING")' ."\n";
				$scripttext .= '  {' ."\n";
				$scripttext .= '    searchTravelModeValue = google.maps.TravelMode.WALKING;';
				$scripttext .= '  }' ."\n";
				$scripttext .= '  else if (searchTravelModeText == "google.maps.TravelMode.BICYCLING")' ."\n";
				$scripttext .= '  {' ."\n";
				$scripttext .= '    searchTravelModeValue = google.maps.TravelMode.BICYCLING;';
				$scripttext .= '  }' ."\n";
				$scripttext .= '  else if (searchTravelModeText == "google.maps.TravelMode.TRANSIT")' ."\n";
				$scripttext .= '  {' ."\n";
				$scripttext .= '    searchTravelModeValue = google.maps.TravelMode.TRANSIT;';
				$scripttext .= '  }' ."\n";
				$scripttext .= '  else' ."\n";
				$scripttext .= '  {' ."\n";
				$scripttext .= '    searchTravelModeValue = ""';
				$scripttext .= '  }' ."\n";

				$scripttext .= 'var placesDirectionsRendererOptions = {' ."\n";
				if (isset($map->routedraggable))
				{
					switch ($map->routedraggable) 
					{
					case 0:
						$scripttext .= 'draggable:false' ."\n";
					break;
					case 1:
						$scripttext .= 'draggable:true' ."\n";
					break;
					default:
						$scripttext .= 'draggable:false' ."\n";
					break;
					}
				}
				$scripttext .= '};' ."\n";

				$scripttext .= '  placesDDisplay.setOptions(placesDirectionsRendererOptions);' ."\n";
				
				$scripttext .= '  if (routedirection == 1)' ."\n";
				$scripttext .= '  {' ."\n";
				$scripttext .= '    var placesDirectionsRequest = {' ."\n";
				$scripttext .= '      origin: placeLocation, ' ."\n";
				$scripttext .= '      destination: placeDestination,' ."\n";
				$scripttext .= '      travelMode: searchTravelModeValue ' ."\n";
				$scripttext .= '    };' ."\n";
				$scripttext .= '  }' ."\n";
				$scripttext .= '  else' ."\n";
				$scripttext .= '  {' ."\n";
				$scripttext .= '    var placesDirectionsRequest = {' ."\n";
				$scripttext .= '      origin: placeDestination, ' ."\n";
				$scripttext .= '      destination: placeLocation,' ."\n";
				$scripttext .= '      travelMode: searchTravelModeValue ' ."\n";
				$scripttext .= '    };' ."\n";
				$scripttext .= '  }' ."\n";

				$scripttext .= '  placesDService.route(placesDirectionsRequest, function(result, status) {' ."\n";
				$scripttext .= '    if (status == google.maps.DirectionsStatus.OK) {' ."\n";
				$scripttext .= '      placesDDisplay.setDirections(result);' ."\n";
				$scripttext .= '    }' ."\n";
				$scripttext .= '    else {' ."\n";
				$scripttext .= '		alert("'.JText::_('MOD_ZHGOOGLEMAP_MAP_DIRECTION_FAILED').' " + status);' ."\n";
				$scripttext .= '    }' ."\n";
				$scripttext .= '});' ."\n";
			$scripttext .= '  }' ."\n";

            $scripttext .= '  map.setCenter(placeLocation);' ."\n";

			$scripttext .= '  markerPlacesAC.setPosition(placeLocation);' ."\n";
			$scripttext .= '  markerPlacesAC.setTitle(markerPlacesACText);' ."\n";

            $scripttext .= '};' ."\n";
		}
		// End function placesACbyButton


		// Toggle for Insert Markers - Begin
	if (isset($map->usermarkers) && (int)$map->usermarkers == 1) 
	{
		if ($allowUserMarker == 1)
		{
				$scripttext .= 'function showonlyone(thename, theid) {'."\n";
				$scripttext .= '  var xPlacemarkA = document.getElementById("bodyInsertPlacemarkA"+theid);'."\n";
				$scripttext .= '  var xPlacemarkGrpA = document.getElementById("bodyInsertPlacemarkGrpA"+theid);'."\n";
			if (isset($map->usercontact) && (int)$map->usercontact == 1)
			{
				$scripttext .= '  var xContactA = document.getElementById("bodyInsertContactA"+theid);'."\n";
				$scripttext .= '  var xContactAdrA = document.getElementById("bodyInsertContactAdrA"+theid);'."\n";
			}
				$scripttext .= '  if (thename == \'Contact\')'."\n";
				$scripttext .= '  {'."\n";
				$scripttext .= '    var toHide2 = document.getElementById("bodyInsertPlacemark"+theid);'."\n";
				$scripttext .= '    var toHide3 = document.getElementById("bodyInsertPlacemarkGrp"+theid);'."\n";
			if (isset($map->usercontact) && (int)$map->usercontact == 1)
			{
				$scripttext .= '    var toHide1 = document.getElementById("bodyInsertContactAdr"+theid);'."\n";
				$scripttext .= '    var toShow = document.getElementById("bodyInsertContact"+theid);'."\n";
			}
				$scripttext .= '    xPlacemarkA.innerHTML = \'<img src="'.$imgpathUtils.'expand.png">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_BASIC_PROPERTIES' ).'\';'."\n";
				$scripttext .= '    xPlacemarkGrpA.innerHTML = \'<img src="'.$imgpathUtils.'expand.png">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_BASIC_GROUP_PROPERTIES' ).'\';'."\n";
			if (isset($map->usercontact) && (int)$map->usercontact == 1)
			{
				$scripttext .= '    xContactA.innerHTML = \'<img src="'.$imgpathUtils.'collapse.png">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_PROPERTIES' ).'\';'."\n";
				$scripttext .= '    xContactAdrA.innerHTML = \'<img src="'.$imgpathUtils.'expand.png">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_ADDRESS_PROPERTIES' ).'\';'."\n";
			}
				$scripttext .= '  }'."\n";
				$scripttext .= '  else if (thename == \'Placemark\')'."\n";
				$scripttext .= '  {'."\n";
				$scripttext .= '    var toHide1 = document.getElementById("bodyInsertPlacemarkGrp"+theid);'."\n";
				$scripttext .= '    var toShow = document.getElementById("bodyInsertPlacemark"+theid);'."\n";
			if (isset($map->usercontact) && (int)$map->usercontact == 1)
			{
				$scripttext .= '    var toHide2 = document.getElementById("bodyInsertContact"+theid);'."\n";
				$scripttext .= '    var toHide3 = document.getElementById("bodyInsertContactAdr"+theid);'."\n";
			}
				$scripttext .= '    xPlacemarkA.innerHTML = \'<img src="'.$imgpathUtils.'collapse.png">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_BASIC_PROPERTIES' ).'\';'."\n";
				$scripttext .= '    xPlacemarkGrpA.innerHTML = \'<img src="'.$imgpathUtils.'expand.png">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_BASIC_GROUP_PROPERTIES' ).'\';'."\n";
			if (isset($map->usercontact) && (int)$map->usercontact == 1)
			{
				$scripttext .= '    xContactA.innerHTML = \'<img src="'.$imgpathUtils.'expand.png">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_PROPERTIES' ).'\';'."\n";
				$scripttext .= '    xContactAdrA.innerHTML = \'<img src="'.$imgpathUtils.'expand.png">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_ADDRESS_PROPERTIES' ).'\';'."\n";
			}
				$scripttext .= '  }'."\n";
				$scripttext .= '  else if (thename == \'PlacemarkGroup\')'."\n";
				$scripttext .= '  {'."\n";
				$scripttext .= '    var toShow = document.getElementById("bodyInsertPlacemarkGrp"+theid);'."\n";
				$scripttext .= '    var toHide1 = document.getElementById("bodyInsertPlacemark"+theid);'."\n";
			if (isset($map->usercontact) && (int)$map->usercontact == 1)
			{
				$scripttext .= '    var toHide2 = document.getElementById("bodyInsertContact"+theid);'."\n";
				$scripttext .= '    var toHide3 = document.getElementById("bodyInsertContactAdr"+theid);'."\n";
			}
				$scripttext .= '    xPlacemarkA.innerHTML = \'<img src="'.$imgpathUtils.'expand.png">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_BASIC_PROPERTIES' ).'\';'."\n";
				$scripttext .= '    xPlacemarkGrpA.innerHTML = \'<img src="'.$imgpathUtils.'collapse.png">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_BASIC_GROUP_PROPERTIES' ).'\';'."\n";
			if (isset($map->usercontact) && (int)$map->usercontact == 1)
			{
				$scripttext .= '    xContactA.innerHTML = \'<img src="'.$imgpathUtils.'expand.png">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_PROPERTIES' ).'\';'."\n";
				$scripttext .= '    xContactAdrA.innerHTML = \'<img src="'.$imgpathUtils.'expand.png">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_ADDRESS_PROPERTIES' ).'\';'."\n";
			}
				$scripttext .= '  }'."\n";
				$scripttext .= '  else if (thename == \'ContactAddress\')'."\n";
				$scripttext .= '  {'."\n";
				$scripttext .= '    var toHide2 = document.getElementById("bodyInsertPlacemark"+theid);'."\n";
				$scripttext .= '    var toHide3 = document.getElementById("bodyInsertPlacemarkGrp"+theid);'."\n";
			if (isset($map->usercontact) && (int)$map->usercontact == 1)
			{
				$scripttext .= '    var toHide1 = document.getElementById("bodyInsertContact"+theid);'."\n";
				$scripttext .= '    var toShow = document.getElementById("bodyInsertContactAdr"+theid);'."\n";
			}
				$scripttext .= '    xPlacemarkA.innerHTML = \'<img src="'.$imgpathUtils.'expand.png">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_BASIC_PROPERTIES' ).'\';'."\n";
				$scripttext .= '    xPlacemarkGrpA.innerHTML = \'<img src="'.$imgpathUtils.'expand.png">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_BASIC_GROUP_PROPERTIES' ).'\';'."\n";
			if (isset($map->usercontact) && (int)$map->usercontact == 1)
			{
				$scripttext .= '    xContactA.innerHTML = \'<img src="'.$imgpathUtils.'expand.png">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_PROPERTIES' ).'\';'."\n";
				$scripttext .= '    xContactAdrA.innerHTML = \'<img src="'.$imgpathUtils.'collapse.png">'.JText::_( 'MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_ADDRESS_PROPERTIES' ).'\';'."\n";
			}
				$scripttext .= '  }'."\n";
				$scripttext .= '  toHide1.style.display = \'none\';'."\n";
				$scripttext .= '  toShow.style.display = \'block\';'."\n";
			if (isset($map->usercontact) && (int)$map->usercontact == 1)
			{
				$scripttext .= '  toHide2.style.display = \'none\';'."\n";
				$scripttext .= '  toHide3.style.display = \'none\';'."\n";
			}
				$scripttext .= '}'."\n";
		}   
	}
	// Toggle for Insert Markers - End


if ($loadtype == "1")
{
	$scripttext .= ' window.addEvent(\'domready\', initializeGMmod);' ."\n";
}
else
{
	$scripttext .= ' function addLoadEvent(func) {' ."\n";
	$scripttext .= '  var oldonload = window.onload;' ."\n";
	$scripttext .= '  if (typeof window.onload != \'function\') {' ."\n";
	$scripttext .= '    window.onload = func;' ."\n";
	$scripttext .= '  } else {' ."\n";
	$scripttext .= '    window.onload = function() {' ."\n";
	$scripttext .= '      if (oldonload) {' ."\n";
	$scripttext .= '        oldonload();' ."\n";
	$scripttext .= '      }' ."\n";
	$scripttext .= '      func();' ."\n";
	$scripttext .= '    }' ."\n";
	$scripttext .= '  }' ."\n";
	$scripttext .= '}	' ."\n";	

	$scripttext .= 'addLoadEvent(initializeGMmod);' ."\n";
		
}

//$scripttext .= 'window.onload = initialize;' ."\n";

	
$scripttext .= '/*]]>*/</script>' ."\n";
// Script end


echo $scripttext;


}
// end of main part


}
else
{
  echo JText::_( 'MOD_ZHGOOGLEMAP_MAP_NOTFIND_ID' ).' '. $id;
}
