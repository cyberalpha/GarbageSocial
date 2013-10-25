<?php
/*------------------------------------------------------------------------
# mod_zhgooglemap - Zh GoogleMap Component
# ------------------------------------------------------------------------
# author    Dmitry Zhuk
# copyright Copyright (C) 2011 zhuk.cc. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
# Websites: http://zhuk.cc
# Technical Support Forum: http://forum.zhuk.cc/
-------------------------------------------------------------------------*/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Zh GoogleMap Helper
 */
abstract class modZhGoogleMapPlacemarksHelper
{

	public static function get_StreetViewOptions($svId)
	{
		$povSV = '';
		
		if ((int)$svId != 0)
		{
			$dbSV = JFactory::getDBO();

			$querySV = $dbSV->getQuery(true);
			$querySV->select('h.*')
				->from('#__zhgooglemaps_streetviews as h')
				->where('h.id = '.(int) $svId);
			$dbSV->setQuery($querySV);        
			$mySV = $dbSV->loadObject();
			
			
			// new lines is prohibited, because it is used in function parameters
			if (isset($mySV))
			{
				$povSV .= '{';
				$povSV .= '	heading: '.(int)$mySV->heading.',';
				$povSV .= '	zoom: '.(int)$mySV->zoom.',';
				$povSV .= '	pitch: '.(int)$mySV->pitch;
				$povSV .= '}';
			}
		}

		return $povSV;
	}

	public static function get_WeatherCloudLayers($wclId)
	{
		$layerWCL = '';
		
		if ((int)$wclId != 0)
		{
			$dbWCL = JFactory::getDBO();

			$queryWCL = $dbWCL->getQuery(true);
			$queryWCL->select('h.*')
				->from('#__zhgooglemaps_weathertypes as h')
				->where('h.id = '.(int) $wclId);
			$dbWCL->setQuery($queryWCL);        
			$myWCL = $dbWCL->loadObject();
			
			
			if (isset($myWCL))
			{
				// Weather Layer
				if ((int)$myWCL->weatherlayer != 0)
				{
					$layerWCL .= 'var weatherLayer = new google.maps.weather.WeatherLayer({'."\n";
				
					if ((int)$myWCL->clickable != 0)
					{
						$layerWCL .= 'clickable: true'."\n";
					}
					else
					{
						$layerWCL .= 'clickable: false'."\n";
					}
					if ((int)$myWCL->suppressinfowindows != 0)
					{
						$layerWCL .= ', suppressInfoWindows: true'."\n";
					}
					else
					{
						$layerWCL .= ', suppressInfoWindows: false'."\n";
					}
					switch ((int)$myWCL->temperatureunits) 
					{
						case 1:
							$layerWCL .= ', temperatureUnits: google.maps.weather.TemperatureUnit.CELSIUS'."\n";
						break;
						case 2:
							$layerWCL .= ', temperatureUnits: google.maps.weather.TemperatureUnit.FAHRENHEIT'."\n";
						break;
						default:
							$layerWCL .= '';
						break;										
					}
					switch ((int)$myWCL->windspeedunits) 
					{
						case 1:
							$layerWCL .= ', windSpeedUnits: google.maps.weather.WindSpeedUnit.KILOMETERS_PER_HOUR'."\n";
						break;
						case 2:
							$layerWCL .= ', windSpeedUnits: google.maps.weather.WindSpeedUnit.METERS_PER_SECOND'."\n";
						break;
						case 3:
							$layerWCL .= ', windSpeedUnits: google.maps.weather.WindSpeedUnit.MILES_PER_HOUR'."\n";
						break;
						default:
							$layerWCL .= '';
						break;										
					}
					switch ((int)$myWCL->labelcolor) 
					{
						case 0:
							$layerWCL .= '';
						break;
						case 1:
							$layerWCL .= ', labelColor: google.maps.weather.LabelColor.BLACK'."\n";
						break;
						case 2:
							$layerWCL .= ', labelColor: google.maps.weather.LabelColor.WHITE'."\n";
						break;
						default:
							$layerWCL .= '';
						break;										
					}

					$layerWCL .= '});'."\n";
					
					$layerWCL .= 'weatherLayer.setMap(map);'."\n";

				}
				
				// Cloud Layer
				if ((int)$myWCL->cloudlayer != 0)
				{
					$layerWCL .= 'var cloudLayer = new google.maps.weather.CloudLayer({'."\n";				
					$layerWCL .= '});'."\n";
					$layerWCL .= 'cloudLayer.setMap(map);'."\n";
					
				}
			}
		}

		return $layerWCL;
	}

	public static function parse_route_by_markers($markerId)
	{
		if ((int)$markerId != 0)
		{
			$dbMrk = JFactory::getDBO();

			$queryMrk = $dbMrk->getQuery(true);
			$queryMrk->select('h.*')
				->from('#__zhgooglemaps_markers as h')
				->where('h.id = '.(int) $markerId);
			$dbMrk->setQuery($queryMrk);        
			$myMarker = $dbMrk->loadObject();
			
			if (isset($myMarker))
			{
				if ($myMarker->latitude != "" && $myMarker->longitude != "")
				{
					return 'new google.maps.LatLng('.$myMarker->latitude.', ' .$myMarker->longitude.')';
				}
				else
				{
					return 'geocode';
				}
			}
			else
			{
				return '';
			}	
		}
	}

	public static function get_placemark_content_string(
						$currentArticleId,
						$currentmarker, $usercontact, $useruser,
						$usercontactattributes, $service_DoDirection,
						$imgpathIcons, $imgpathUtils, $directoryIcons)
	{
		$returnText = '';
		$userContactAttrs = explode(",", $usercontactattributes);

		for($i = 0; $i < count($userContactAttrs); $i++) 
		{
			$userContactAttrs[$i] = strtolower(trim($userContactAttrs[$i]));
		}
	  
			$returnText .= '\'<div id="placemarkContent'. $currentmarker->id.'">\' +	' ."\n";
			if (isset($currentmarker->markercontent) &&
				(((int)$currentmarker->markercontent == 0) ||
				 ((int)$currentmarker->markercontent == 1))
				)
			{
				$returnText .= '\'<h1 id="headContent'. $currentmarker->id.'" class="placemarkHead">'.'\'+' ."\n";
				$returnText .= '\''.htmlspecialchars(str_replace('\\', '/', $currentmarker->title), ENT_QUOTES, 'UTF-8').'\'+'."\n";
				$returnText .= '\'</h1>\'+' ."\n";
			}
			$returnText .= '\'<div id="bodyContent'. $currentmarker->id.'"  class="placemarkBody">\'+'."\n";

			if ($currentmarker->hrefimage!="")
			{
				$tmp_image_path = strtolower($currentmarker->hrefimage);
				if (substr($tmp_image_path,0,5) == "http:"
				|| substr($tmp_image_path,0,6) == "https:"
				|| substr($tmp_image_path,0,1) == "/"
				|| substr($tmp_image_path,0,1) == ".")
				{
					$tmp_image_path_add = "";
				}
				else
				{
					$tmp_image_path_add = "/";
				}
				$returnText .= '\'<img src="'.$tmp_image_path_add.$currentmarker->hrefimage.'" alt="" />\'+'."\n";
			}

			if (isset($currentmarker->markercontent) &&
				(((int)$currentmarker->markercontent == 0) ||
				 ((int)$currentmarker->markercontent == 2))
				)
			{
				$returnText .= '\''.htmlspecialchars(str_replace('\\', '/', $currentmarker->description), ENT_QUOTES, 'UTF-8').'\'+'."\n";
			}
			$returnText .= '\''.str_replace("'", "\'", str_replace(array("\r", "\r\n", "\n"), '', $currentmarker->descriptionhtml)).'\'+'."\n";

			//$returnText .= ' latlng'. $currentmarker->id. '.toString()+'."\n";

			// Contact info - begin
			if (isset($usercontact) && ((int)$usercontact != 0))
			{
				if (isset($currentmarker->showcontact) && ((int)$currentmarker->showcontact != 0))
				{
					switch ((int)$currentmarker->showcontact) 
					{
						case 1:
							for($i = 0; $i < count($userContactAttrs); $i++) 
							{
								if ($currentmarker->contact_name != ""
								&& $userContactAttrs[$i] == 'name') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.JText::_('MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_NAME').' '.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_name), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_position != ""
								&& $userContactAttrs[$i] == 'position') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.JText::_('MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_POSITION').' '.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_position), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_address != ""
								&& $userContactAttrs[$i] == 'address') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.JText::_('MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_ADDRESS').' '.str_replace('<br /><br />', '<br />',str_replace(array("\r", "\r\n", "\n"), '<br />', htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_address), ENT_QUOTES, 'UTF-8'))).'</p>\'+'."\n";
								}
								
								if ($currentmarker->contact_suburb != ""
								&& $userContactAttrs[$i] == 'suburb') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.JText::_('MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_ADDRESS_SUBURB_SUBURB').' '.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_suburb), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_suburb != ""
								&& $userContactAttrs[$i] == 'city') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.JText::_('MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_ADDRESS_SUBURB_CITY').' '.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_suburb), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_state != ""
								&& $userContactAttrs[$i] == 'state') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.JText::_('MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_ADDRESS_STATE_STATE').' '.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_state), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_state != ""
								&& $userContactAttrs[$i] == 'province') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.JText::_('MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_ADDRESS_STATE_PROVINCE').' '.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_state), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_country != ""
								&& $userContactAttrs[$i] == 'country') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.JText::_('MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_ADDRESS_COUNTRY').' '.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_country), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_postcode != ""
								&& $userContactAttrs[$i] == 'postcode') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.JText::_('MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_ADDRESS_POSTCODE_POSTAL').' '.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_postcode), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_postcode != ""
								&& $userContactAttrs[$i] == 'zipcode') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.JText::_('MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_ADDRESS_POSTCODE_ZIP').' '.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_postcode), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								
								if ($currentmarker->contact_phone != ""
								&& $userContactAttrs[$i] == 'phone') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.JText::_('MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_PHONE').' '.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_phone), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_mobile != ""
								&& $userContactAttrs[$i] == 'mobile') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.JText::_('MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_MOBILE').' '.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_mobile), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_fax != ""
								&& $userContactAttrs[$i] == 'fax') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.JText::_('MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_FAX').' '.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_fax), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								
								if ($currentmarker->contact_email != ""
								&& $userContactAttrs[$i] == 'email') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.JText::_('MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_EMAIL').' '.str_replace('@','&#64;',htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_email), ENT_QUOTES, 'UTF-8')).'</p>\'+'."\n";
								}
							}			

						break;
						case 2:
							for($i = 0; $i < count($userContactAttrs); $i++) 
							{
								if ($currentmarker->contact_name != ""
								&& $userContactAttrs[$i] == 'name') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_name), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_position != ""
								&& $userContactAttrs[$i] == 'position') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_position), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_address != ""
								&& $userContactAttrs[$i] == 'address') 
								{
									$returnText .= '\'<p class="placemarkBodyContact"><img src="'.$imgpathUtils.'address.png" alt="'.JText::_('MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_ADDRESS').'" />'.str_replace('<br /><br />', '<br />',str_replace(array("\r", "\r\n", "\n"), '<br />', htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_address), ENT_QUOTES, 'UTF-8'))).'</p>\'+'."\n";
								}

								if ($currentmarker->contact_suburb != ""
								&& $userContactAttrs[$i] == 'suburb') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_suburb), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_suburb != ""
								&& $userContactAttrs[$i] == 'city') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_suburb), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_state != ""
								&& $userContactAttrs[$i] == 'state') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_state), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_state != ""
								&& $userContactAttrs[$i] == 'province') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_state), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_country != ""
								&& $userContactAttrs[$i] == 'country') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_country), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_postcode != ""
								&& $userContactAttrs[$i] == 'postcode') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_postcode), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_postcode != ""
								&& $userContactAttrs[$i] == 'zipcode') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_postcode), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								
								if ($currentmarker->contact_phone != ""
								&& $userContactAttrs[$i] == 'phone') 
								{
									$returnText .= '\'<p class="placemarkBodyContact"><img src="'.$imgpathUtils.'phone.png" alt="'.JText::_('MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_PHONE').'" />'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_phone), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_mobile != ""
								&& $userContactAttrs[$i] == 'mobile') 
								{
									$returnText .= '\'<p class="placemarkBodyContact"><img src="'.$imgpathUtils.'mobile.png" alt="'.JText::_('MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_MOBILE').'" />'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_mobile), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_fax != ""
								&& $userContactAttrs[$i] == 'fax') 
								{
									$returnText .= '\'<p class="placemarkBodyContact"><img src="'.$imgpathUtils.'fax.png" alt="'.JText::_('MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_FAX').'" />'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_fax), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								
								if ($currentmarker->contact_email != ""
								&& $userContactAttrs[$i] == 'email') 
								{
									$returnText .= '\'<p class="placemarkBodyContact"><img src="'.$imgpathUtils.'email.png" alt="'.JText::_('MOD_ZHGOOGLEMAP_MAP_USER_CONTACT_EMAIL').'" />'.str_replace('@','&#64;',htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_email), ENT_QUOTES, 'UTF-8')).'</p>\'+'."\n";
								}
							}
						break;
						case 3:
							for($i = 0; $i < count($userContactAttrs); $i++) 
							{
								if ($currentmarker->contact_name != ""
								&& $userContactAttrs[$i] == 'name') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_name), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_position != ""
								&& $userContactAttrs[$i] == 'position') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_position), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_address != ""
								&& $userContactAttrs[$i] == 'address') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.str_replace('<br /><br />', '<br />',str_replace(array("\r", "\r\n", "\n"), '<br />', htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_address), ENT_QUOTES, 'UTF-8'))).'</p>\'+'."\n";
								}

								if ($currentmarker->contact_suburb != ""
								&& $userContactAttrs[$i] == 'suburb') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_suburb), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_suburb != ""
								&& $userContactAttrs[$i] == 'city') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_suburb), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_state != ""
								&& $userContactAttrs[$i] == 'state') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_state), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_state != ""
								&& $userContactAttrs[$i] == 'province') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_state), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_country != ""
								&& $userContactAttrs[$i] == 'country') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_country), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_postcode != ""
								&& $userContactAttrs[$i] == 'postcode') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_postcode), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_postcode != ""
								&& $userContactAttrs[$i] == 'zipcode') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_postcode), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								
								if ($currentmarker->contact_phone != ""
								&& $userContactAttrs[$i] == 'phone') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_phone), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_mobile != ""
								&& $userContactAttrs[$i] == 'mobile') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_mobile), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_fax != ""
								&& $userContactAttrs[$i] == 'fax') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_fax), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								
								if ($currentmarker->contact_email != ""
								&& $userContactAttrs[$i] == 'email') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.str_replace('@','&#64;',htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_email), ENT_QUOTES, 'UTF-8')).'</p>\'+'."\n";
								}
							}
						break;
						default:
							for($i = 0; $i < count($userContactAttrs); $i++) 
							{
								if ($currentmarker->contact_name != ""
								&& $userContactAttrs[$i] == 'name') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_name), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_position != ""
								&& $userContactAttrs[$i] == 'position') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_position), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_address != ""
								&& $userContactAttrs[$i] == 'address') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.str_replace('<br /><br />', '<br />',str_replace(array("\r", "\r\n", "\n"), '<br />', htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_address), ENT_QUOTES, 'UTF-8'))).'</p>\'+'."\n";
								}
								if ($currentmarker->contact_suburb != ""
								&& $userContactAttrs[$i] == 'suburb') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_suburb), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_suburb != ""
								&& $userContactAttrs[$i] == 'city') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_suburb), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_state != ""
								&& $userContactAttrs[$i] == 'state') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_state), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_state != ""
								&& $userContactAttrs[$i] == 'province') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_state), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_country != ""
								&& $userContactAttrs[$i] == 'country') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_country), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_postcode != ""
								&& $userContactAttrs[$i] == 'postcode') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_postcode), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_postcode != ""
								&& $userContactAttrs[$i] == 'zipcode') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_postcode), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_phone != ""
								&& $userContactAttrs[$i] == 'phone') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_phone), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_mobile != ""
								&& $userContactAttrs[$i] == 'mobile') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_mobile), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								if ($currentmarker->contact_fax != ""
								&& $userContactAttrs[$i] == 'fax') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_fax), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
								}
								
								if ($currentmarker->contact_email != ""
								&& $userContactAttrs[$i] == 'email') 
								{
									$returnText .= '\'<p class="placemarkBodyContact">'.str_replace('@','&#64;',htmlspecialchars(str_replace('\\', '/', $currentmarker->contact_email), ENT_QUOTES, 'UTF-8')).'</p>\'+'."\n";
								}
							}
						break;										
					}
				}
			}
			// Contact info - end
			// User info - begin
			if (isset($useruser) && ((int)$useruser != 0))
			{
				$returnText .= modZhGoogleMapPlacemarksHelper::get_userinfo_for_marker(
														$currentmarker->createdbyuser, $currentmarker->showuser,
														$imgpathIcons, $imgpathUtils, $directoryIcons);
			}
			// User info - end
			
			if ($currentmarker->hrefsite!="")
			{
				$returnText .= '\'<p><a class="placemarkHREF" href="'.$currentmarker->hrefsite.'" target="_blank">';
				if ($currentmarker->hrefsitename != "")
				{
					$returnText .= htmlspecialchars($currentmarker->hrefsitename, ENT_QUOTES, 'UTF-8');
				}
				else
				{
					$returnText .= $currentmarker->hrefsite;
				}
				$returnText .= '</a></p>\'+'."\n";
			}

			$returnText .= '\'</div>\'+'."\n";
			
			// Placemark Toolbar - begin
			if ((int)$currentmarker->streetviewinfowin != 0
			|| $service_DoDirection == 1)
			{
				$returnText .=  '\'<div id="GMapsMarkerActionDIV" class="zhgm-placemark-action-div">\'+'."\n";
				$returnText .=  '\'<div id="GMapsMarkerActionTOOLBAR" class="zhgm-placemark-action-toolbar">\'+'."\n";
				if ((int)$currentmarker->streetviewinfowin != 0)
				{
					$returnText .= '\'<div class="zhgm-placemark-action-toolbaritem">\'+'."\n";
					$returnText .= '\'<a href="#" onclick="';
					$mapSV = modZhGoogleMapPlacemarksHelper::get_StreetViewOptions($currentmarker->streetviewstyleid);
					if ($mapSV == "")
					{
						$returnText .= 'showPlacemarkPanorama('.$currentmarker->streetviewinfowinw.','.$currentmarker->streetviewinfowinh.', \\\'\\\');';
					}
					else
					{
						$returnText .= 'showPlacemarkPanorama('.$currentmarker->streetviewinfowinw.','.$currentmarker->streetviewinfowinh.', '.$mapSV.');';
					}									
					$returnText .= ' return false;"><img src="'.$imgpathUtils.'StreetView.png" alt="'.JText::_('MOD_ZHGOOGLEMAP_MAPMARKER_ACTION_STREETVEW').'" /></a>\'+'."\n";
					$returnText .= '\'</div>\'+'."\n";
				}
				if ($service_DoDirection == 1)
				{
					$returnText .= '\'<div class="zhgm-placemark-action-toolbaritem">\'+'."\n";
					$returnText .= '\'<a href="#" onclick="';
					$returnText .= 'setRouteDestination(0);';
					$returnText .= ' return false;"><img src="'.$imgpathUtils.'start.png" alt="'.JText::_('MOD_ZHGOOGLEMAP_MAPMARKER_ACTION_START').'" /></a>\'+'."\n";
					$returnText .= '\'</div>\'+'."\n";
					$returnText .= '\'<div class="zhgm-placemark-action-toolbaritem">\'+'."\n";
					$returnText .= '\'<a href="#" onclick="';
					$returnText .= 'setRouteDestination(1);';
					$returnText .= ' return false;"><img src="'.$imgpathUtils.'finish.png" alt="'.JText::_('MOD_ZHGOOGLEMAP_MAPMARKER_ACTION_FINISH').'" /></a>\'+'."\n";
					$returnText .= '\'</div>\'+'."\n";
				}
				$returnText .= '\'</div>\'+'."\n";
				$returnText .= '\'</div>\'+'."\n";
			}
			// Placemark Toolbar - end
			
			$returnText .= '\'</div>\';'."\n";
			// contentString - End

		return $returnText;
	}
	
	public static function get_placemark_infobubble_style_string($currentmarker)
	{
		$scriptInfoBubbleStyle = '';

		if (isset($currentmarker->infobubblepublished) && (int)$currentmarker->infobubblepublished == 1)
		{
			if (isset($currentmarker->shadowstyle) && $currentmarker->shadowstyle != "")
			{
				if ($scriptInfoBubbleStyle == "")
				{
					$scriptInfoBubbleStyle .= 'shadowStyle: '.$currentmarker->shadowstyle;
				}
				else
				{
					$scriptInfoBubbleStyle .= "\n".', shadowStyle: '.$currentmarker->shadowstyle;
				}
			}
			if (isset($currentmarker->padding) && $currentmarker->padding != "")
			{
				if ($scriptInfoBubbleStyle == "")
				{
					$scriptInfoBubbleStyle .= 'padding: '.$currentmarker->padding;
				}
				else
				{
					$scriptInfoBubbleStyle .= "\n".', padding: '.$currentmarker->padding;
				}
			}
			if (isset($currentmarker->borderradius) && $currentmarker->borderradius != "")
			{
				if ($scriptInfoBubbleStyle == "")
				{
					$scriptInfoBubbleStyle .= 'borderRadius: '.$currentmarker->borderradius;
				}
				else
				{
					$scriptInfoBubbleStyle .= "\n".', borderRadius: '.$currentmarker->borderradius;
				}
			}
			if (isset($currentmarker->borderwidth) && $currentmarker->borderwidth != "")
			{
				if ($scriptInfoBubbleStyle == "")
				{
					$scriptInfoBubbleStyle .= 'borderWidth: '.$currentmarker->borderwidth;
				}
				else
				{
					$scriptInfoBubbleStyle .= "\n".', borderWidth: '.$currentmarker->borderwidth;
				}
			}
			if (isset($currentmarker->bordercolor) && $currentmarker->bordercolor != "")
			{
				if ($scriptInfoBubbleStyle == "")
				{
					$scriptInfoBubbleStyle .= 'borderColor: \''.$currentmarker->bordercolor.'\'';
				}
				else
				{
					$scriptInfoBubbleStyle .= "\n".', borderColor: \''.$currentmarker->bordercolor.'\'';
				}
			}
			if (isset($currentmarker->backgroundcolor) && $currentmarker->backgroundcolor != "")
			{
				if ($scriptInfoBubbleStyle == "")
				{
					$scriptInfoBubbleStyle .= 'backgroundColor: \''.$currentmarker->backgroundcolor.'\'';
				}
				else
				{
					$scriptInfoBubbleStyle .= "\n".', backgroundColor: \''.$currentmarker->backgroundcolor.'\'';
				}
			}
			if (isset($currentmarker->minwidth) && $currentmarker->minwidth != "")
			{
				if ($scriptInfoBubbleStyle == "")
				{
					$scriptInfoBubbleStyle .= 'minWidth: '.$currentmarker->minwidth;
				}
				else
				{
					$scriptInfoBubbleStyle .= "\n".', minWidth: '.$currentmarker->minwidth;
				}
			}
			if (isset($currentmarker->maxwidth) && $currentmarker->maxwidth != "")
			{
				if ($scriptInfoBubbleStyle == "")
				{
					$scriptInfoBubbleStyle .= 'maxWidth: '.$currentmarker->maxwidth;
				}
				else
				{
					$scriptInfoBubbleStyle .= "\n".', maxWidth: '.$currentmarker->maxwidth;
				}
			}
			if (isset($currentmarker->minheight) && $currentmarker->minheight != "")
			{
				if ($scriptInfoBubbleStyle == "")
				{
					$scriptInfoBubbleStyle .= 'minHeight: '.$currentmarker->minheight;
				}
				else
				{
					$scriptInfoBubbleStyle .= "\n".', minHeight: '.$currentmarker->minheight;
				}
			}
			if (isset($currentmarker->maxheight) && $currentmarker->maxheight != "")
			{
				if ($scriptInfoBubbleStyle == "")
				{
					$scriptInfoBubbleStyle .= 'maxHeight: '.$currentmarker->maxheight;
				}
				else
				{
					$scriptInfoBubbleStyle .= "\n".', maxHeight: '.$currentmarker->maxheight;
				}
			}
			if (isset($currentmarker->arrowsize) && $currentmarker->arrowsize != "")
			{
				if ($scriptInfoBubbleStyle == "")
				{
					$scriptInfoBubbleStyle .= 'arrowSize: '.$currentmarker->arrowsize;
				}
				else
				{
					$scriptInfoBubbleStyle .= "\n".', arrowSize: '.$currentmarker->arrowsize;
				}
			}
			if (isset($currentmarker->arrowposition) && $currentmarker->arrowposition != "")
			{
				if ($scriptInfoBubbleStyle == "")
				{
					$scriptInfoBubbleStyle .= 'arrowPosition: '.$currentmarker->arrowposition;
				}
				else
				{
					$scriptInfoBubbleStyle .= "\n".', arrowPosition: '.$currentmarker->arrowposition;
				}
			}
			if (isset($currentmarker->arrowstyle) && $currentmarker->arrowstyle != "")
			{
				if ($scriptInfoBubbleStyle == "")
				{
					$scriptInfoBubbleStyle .= 'arrowStyle: '.$currentmarker->arrowstyle;
				}
				else
				{
					$scriptInfoBubbleStyle .= "\n".', arrowStyle: '.$currentmarker->arrowstyle;
				}
			}
			if (isset($currentmarker->disableautopan))
			{
				if ($scriptInfoBubbleStyle == "")
				{
					if ((int)$currentmarker->disableautopan == 1)
					{
						$scriptInfoBubbleStyle .= 'disableAutoPan: true';
					}
					else
					{
						$scriptInfoBubbleStyle .= 'disableAutoPan: false';
					}
					
				}
				else
				{
					if ((int)$currentmarker->disableautopan == 1)
					{
						$scriptInfoBubbleStyle .= "\n".', disableAutoPan: true';
					}
					else
					{
						$scriptInfoBubbleStyle .= "\n".', disableAutoPan: false';
					}
				}
			}
			if (isset($currentmarker->disableanimation))
			{
				if ($scriptInfoBubbleStyle == "")
				{
					if ((int)$currentmarker->disableanimation == 1)
					{
						$scriptInfoBubbleStyle .= 'disableAnimation: true';
					}
					else
					{
						$scriptInfoBubbleStyle .= 'disableAnimation: false';
					}
					
				}
				else
				{
					if ((int)$currentmarker->disableanimation == 1)
					{
						$scriptInfoBubbleStyle .= "\n".', disableAnimation: true';
					}
					else
					{
						$scriptInfoBubbleStyle .= "\n".', disableAnimation: false';
					}
				}
			}
			if (isset($currentmarker->hideclosebutton))
			{
				if ($scriptInfoBubbleStyle == "")
				{
					if ((int)$currentmarker->hideclosebutton == 1)
					{
						$scriptInfoBubbleStyle .= 'hideCloseButton: true';
					}
					else
					{
						$scriptInfoBubbleStyle .= 'hideCloseButton: false';
					}
					
				}
				else
				{
					if ((int)$currentmarker->hideclosebutton == 1)
					{
						$scriptInfoBubbleStyle .= "\n".', hideCloseButton: true';
					}
					else
					{
						$scriptInfoBubbleStyle .= "\n".', hideCloseButton: false';
					}
				}
			}
			if (isset($currentmarker->backgroundclassname) && $currentmarker->backgroundclassname != "")
			{
				if ($scriptInfoBubbleStyle == "")
				{
					$scriptInfoBubbleStyle .= 'backgroundClassName: \''.$currentmarker->backgroundclassname.'\'';
				}
				else
				{
					$scriptInfoBubbleStyle .= "\n".', backgroundClassName: \''.$currentmarker->backgroundclassname.'\'';
				}
			}
			
			if ($scriptInfoBubbleStyle != "")
			{
				$scriptInfoBubbleStyle = '{'."\n" . $scriptInfoBubbleStyle. '}'."\n";
			}
		}
		
		return $scriptInfoBubbleStyle;
	}	
	
	
	protected static function get_userinfo_for_marker($userId, $showuser, $imgpathIcons, $imgpathUtils, $directoryIcons)
	{
		
		if ((int)$userId != 0)
		{
			$cur_user_name = '';
			$cur_user_address = '';
			$cur_user_phone = '';
			
			$dbUsr = JFactory::getDBO();
			$queryUsr = $dbUsr->getQuery(true);
			
			$queryUsr->select('p.*, h.name as profile_username')
				->from('#__users as h')
				->leftJoin('#__user_profiles as p ON p.user_id=h.id')
				->where('h.id = '.(int)$userId);

			$dbUsr->setQuery($queryUsr);        
			$myUsr = $dbUsr->loadObjectList();
			
			if (isset($myUsr))
			{
				
				foreach ($myUsr as $key => $currentUsers) 
				{
					$cur_user_name = $currentUsers->profile_username;

					if ($currentUsers->profile_key == 'profile.address1')
					{
						$cur_user_address = $currentUsers->profile_value;
					}
					else if ($currentUsers->profile_key == 'profile.phone')
					{
						$cur_user_phone = $currentUsers->profile_value;
					}
					
					
				}
				
				$cur_scripttext = '';
				
				if (isset($showuser) && ((int)$showuser != 0))
				{
					switch ((int)$showuser) 
					{
						case 1:
							if ($cur_user_name != "") 
							{
								$cur_scripttext .= '\'<p class="placemarkBodyUser">'.JText::_('MOD_ZHGOOGLEMAP_MAP_USER_USER_NAME').' '.htmlspecialchars(str_replace('\\', '/', $cur_user_name), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
							}
							if ($cur_user_address != "") 
							{
								$cur_scripttext .= '\'<p class="placemarkBodyUser">'.JText::_('MOD_ZHGOOGLEMAP_MAP_USER_USER_ADDRESS').' '.str_replace('<br /><br />', '<br />',str_replace(array("\r", "\r\n", "\n"), '<br />', htmlspecialchars(str_replace('\\', '/', $cur_user_address), ENT_QUOTES, 'UTF-8'))).'</p>\'+'."\n";
							}
							if ($cur_user_phone != "") 
							{
								$cur_scripttext .= '\'<p class="placemarkBodyUser">'.JText::_('MOD_ZHGOOGLEMAP_MAP_USER_USER_PHONE').' '.htmlspecialchars(str_replace('\\', '/', $cur_user_phone), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
							}
						break;
						case 2:
							if ($cur_user_name != "") 
							{
								$cur_scripttext .= '\'<p class="placemarkBodyUser">'.htmlspecialchars(str_replace('\\', '/', $cur_user_name), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
							}
							if ($cur_user_address != "") 
							{
								$cur_scripttext .= '\'<p class="placemarkBodyUser"><img src="'.$imgpathUtils.'address.png" alt="'.JText::_('MOD_ZHGOOGLEMAP_MAP_USER_USER_ADDRESS').'" />'.str_replace('<br /><br />', '<br />',str_replace(array("\r", "\r\n", "\n"), '<br />', htmlspecialchars(str_replace('\\', '/', $cur_user_address), ENT_QUOTES, 'UTF-8'))).'</p>\'+'."\n";
							}
							if ($cur_user_phone != "") 
							{
								$cur_scripttext .= '\'<p class="placemarkBodyUser"><img src="'.$imgpathUtils.'phone.png" alt="'.JText::_('MOD_ZHGOOGLEMAP_MAP_USER_USER_PHONE').'" />'.htmlspecialchars(str_replace('\\', '/', $cur_user_phone), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
							}
						break;
						case 3:
							if ($cur_user_name != "") 
							{
								$cur_scripttext .= '\'<p class="placemarkBodyUser">'.htmlspecialchars(str_replace('\\', '/', $cur_user_name), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
							}
							if ($cur_user_address != "") 
							{
								$cur_scripttext .= '\'<p class="placemarkBodyUser">'.str_replace('<br /><br />', '<br />',str_replace(array("\r", "\r\n", "\n"), '<br />', htmlspecialchars(str_replace('\\', '/', $cur_user_address), ENT_QUOTES, 'UTF-8'))).'</p>\'+'."\n";
							}
							if ($cur_user_phone != "") 
							{
								$cur_scripttext .= '\'<p class="placemarkBodyUser">'.htmlspecialchars(str_replace('\\', '/', $cur_user_phone), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
							}
						break;
						default:
							if ($cur_user_name != "") 
							{
								$cur_scripttext .= '\'<p class="placemarkBodyUser">'.htmlspecialchars(str_replace('\\', '/', $cur_user_name), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
							}
							if ($cur_user_address != "") 
							{
								$cur_scripttext .= '\'<p class="placemarkBodyUser">'.str_replace('<br /><br />', '<br />',str_replace(array("\r", "\r\n", "\n"), '<br />', htmlspecialchars(str_replace('\\', '/', $cur_user_address), ENT_QUOTES, 'UTF-8'))).'</p>\'+'."\n";
							}
							if ($cur_user_phone != "") 
							{
								$cur_scripttext .= '\'<p class="placemarkBodyUser">'.htmlspecialchars(str_replace('\\', '/', $cur_user_phone), ENT_QUOTES, 'UTF-8').'</p>\'+'."\n";
							}
						break;										
					}
				}
				
				return $cur_scripttext;
			}
			else
			{
				return '';
			}	
		}
		else
		{
			return '';
		}	
		
		
	}
	
	
	
}
