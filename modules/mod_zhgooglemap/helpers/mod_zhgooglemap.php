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

/**
 * Zh GoogleMap Helper
 */
class modZhGoogleMapHelper
{

	public static function getMap($id) 
	{
			$db = JFactory::getDBO();

            $query = $db->getQuery(true);

			$query->select('h.*, c.title as category')
				->from('#__zhgooglemaps_maps as h')
				->leftJoin('#__categories as c ON h.catid=c.id')
				->where('h.id=' . (int)$id);

            $db->setQuery($query);        
				
			$item = $db->loadObject();

		return $item;
	}

	public static function getMarkers($id, $placemarkListId, $explacemarkListId, $groupListId, $categoryListId, $usermarkers, $usermarkersfilter, $usercontact) 
	{		
			$db = JFactory::getDBO();

            $query = $db->getQuery(true);

			$addWhereClause = '';
			
			if ($placemarkListId == ""
				&& $groupListId == ""
				&& $categoryListId == ""
				)
			{
				
				$addWhereClause .= ' and h.mapid='.(int)$id;
				
				if ($explacemarkListId != "")
				{
					$tmp_expl_ids = str_replace(';',',', $explacemarkListId);
					
					if (strpos($tmp_expl_ids, ','))
					{
						$addWhereClause .= ' and h.id NOT IN ('.$tmp_expl_ids.')';
					}
					else
					{
						$addWhereClause .= ' and h.id != '.(int)$tmp_expl_ids;
					}
				}
			}
			else
			{
				if ($placemarkListId != "")
				{
					$tmp_pl_ids = str_replace(';',',', $placemarkListId);
					
					if (strpos($tmp_pl_ids, ','))
					{
						$addWhereClause .= ' and h.id IN ('.$tmp_pl_ids.')';
					}
					else
					{
						$addWhereClause .= ' and h.id = '.(int)$tmp_pl_ids;
					}
				}
				if ($explacemarkListId != "")
				{
					$tmp_expl_ids = str_replace(';',',', $explacemarkListId);
					
					if (strpos($tmp_expl_ids, ','))
					{
						$addWhereClause .= ' and h.id NOT IN ('.$tmp_expl_ids.')';
					}
					else
					{
						$addWhereClause .= ' and h.id != '.(int)$tmp_expl_ids;
					}
				}
				if ($groupListId != "")
				{
					$tmp_grp_ids = str_replace(';',',', $groupListId);
					
					if (strpos($tmp_grp_ids, ','))
					{
						$addWhereClause .= ' and h.markergroup IN ('.$tmp_grp_ids.')';
					}
					else
					{
						$addWhereClause .= ' and h.markergroup = '.(int)$tmp_grp_ids;
					}
				}
				if ($categoryListId != "")
				{
					$tmp_cat_ids = str_replace(';',',', $categoryListId);
					
					if (strpos($tmp_cat_ids, ','))
					{
						$addWhereClause .= ' and h.catid IN ('.$tmp_cat_ids.')';
					}
					else
					{
						$addWhereClause .= ' and h.catid = '.(int)$tmp_cat_ids;
					}
				}
			}
			
			
			// Create some addition filters - Begin
			
			if ($usermarkers == 0)
			{
				// You can not enter markers

				// You can see all published, and you can't enter markers
				
				switch ((int)$usermarkersfilter)
				{
					case 0:
						$addWhereClause .= ' and h.published=1';
					break;
					case 1:
						$currentUser = JFactory::getUser();
						$addWhereClause .= ' and h.published=1';
						$addWhereClause .= ' and h.createdbyuser='.(int)$currentUser->id;
					break;
					default:
						$addWhereClause .= ' and h.published=1';
					break;					
				}
			}
			else
			{
				// You can enter markers
				
				switch ((int)$usermarkersfilter)
				{
					case 0:
						$currentUser = JFactory::getUser();
						if ((int)$currentUser->id == 0)
						{
							$addWhereClause .= ' and h.published=1';
						}
						else
						{
							$addWhereClause .= ' and (h.published=1 or h.createdbyuser='.(int)$currentUser->id .')';
						}
					break;
					case 1:
						$currentUser = JFactory::getUser();
						if ((int)$currentUser->id == 0)
						{
							$addWhereClause .= ' and h.published=1';
							$addWhereClause .= ' and h.createdbyuser='.(int)$currentUser->id;
						}
						else
						{
							$addWhereClause .= ' and h.createdbyuser='.(int)$currentUser->id;
						}
					break;
					default:
						$addWhereClause .= ' and h.published=1';
					break;					
				}
			}
			// Create some addition filters - End

				
			if ((int)$usercontact == 1)
			{
				$query->select('h.*, '.
					' c.title as category, g.icontype as groupicontype, g.overridemarkericon as overridemarkericon, g.published as publishedgroup, g.markermanagerminzoom as markermanagerminzoom, g.markermanagermaxzoom as markermanagermaxzoom, g.activeincluster as activeincluster, '.
					' cn.name as contact_name, cn.address as contact_address, cn.con_position as contact_position, cn.telephone as contact_phone, cn.mobile as contact_mobile, cn.fax as contact_fax, cn.email_to as contact_email, '.
					' cn.suburb as contact_suburb, cn.state as contact_state, cn.country as contact_country, cn.postcode as contact_postcode, '.
					' bub.disableanimation, bub.shadowstyle, bub.padding, bub.borderradius, bub.borderwidth, bub.bordercolor, bub.backgroundcolor, bub.minwidth, bub.maxwidth, bub.minheight, bub.maxheight, bub.arrowsize, bub.arrowposition, bub.arrowstyle, bub.disableautopan, bub.hideclosebutton, bub.backgroundclassname, bub.published infobubblepublished ')
					->from('#__zhgooglemaps_markers as h')
					->leftJoin('#__categories as c ON h.catid=c.id')
					->leftJoin('#__zhgooglemaps_markergroups as g ON h.markergroup=g.id')
					->leftJoin('#__zhgooglemaps_infobubbles as bub ON h.tabid=bub.id')
					->leftJoin('#__contact_details as cn ON h.contactid=cn.id')
					->where('1=1' . $addWhereClause)
					->order('h.title');
			}
			else
			{
				$query->select('h.*, '.
					' c.title as category, g.icontype as groupicontype, g.overridemarkericon as overridemarkericon, g.published as publishedgroup, g.markermanagerminzoom as markermanagerminzoom, g.markermanagermaxzoom as markermanagermaxzoom, g.activeincluster as activeincluster, '.
					' bub.disableanimation, bub.shadowstyle, bub.padding, bub.borderradius, bub.borderwidth, bub.bordercolor, bub.backgroundcolor, bub.minwidth, bub.maxwidth, bub.minheight, bub.maxheight, bub.arrowsize, bub.arrowposition, bub.arrowstyle, bub.disableautopan, bub.hideclosebutton, bub.backgroundclassname, bub.published infobubblepublished ')
					->from('#__zhgooglemaps_markers as h')
					->leftJoin('#__categories as c ON h.catid=c.id')
					->leftJoin('#__zhgooglemaps_markergroups as g ON h.markergroup=g.id')
					->leftJoin('#__zhgooglemaps_infobubbles as bub ON h.tabid=bub.id')
					->where('1=1' . $addWhereClause)
					->order('h.title');

			}

			$nullDate = $db->Quote($db->getNullDate());
			$nowDate = $db->Quote(JFactory::getDate()->toMySQL());
			$query->where('(h.publish_up = ' . $nullDate . ' OR h.publish_up <= ' . $nowDate . ')');
			$query->where('(h.publish_down = ' . $nullDate . ' OR h.publish_down >= ' . $nowDate . ')');
			
            $db->setQuery($query);        
			
			// Markers
			$markers = $db->loadObjectList();


		return $markers;

	}
	
	public static function getRouters($id) 
	{
			$db = JFactory::getDBO();

            $query = $db->getQuery(true);
			
			$query->select('h.*, c.title as category ')
				->from('#__zhgooglemaps_routers as h')
				->leftJoin('#__categories as c ON h.catid=c.id')
				->where('h.published=1 and h.mapid=' . (int)$id);

            $db->setQuery($query);        
				
        // Routers
        $routers = $db->loadObjectList();

		return $routers;
	}

	public static function getMarkerGroups($id, $placemarkListId, $explacemarkListId, $groupListId, $categoryListId) 
	{

			$db = JFactory::getDBO();

            $query = $db->getQuery(true);
			
			$addWhereClause = "";

			if ($placemarkListId == ""
				&& $groupListId == ""
				&& $categoryListId == "")
			{
				$addWhereClause .= ' and m.mapid='.(int)$id;
				if ($explacemarkListId != "")
				{
					$tmp_expl_ids = str_replace(';',',', $explacemarkListId);
					
					if (strpos($tmp_expl_ids, ','))
					{
						$addWhereClause .= ' and m.id NOT IN ('.$tmp_expl_ids.')';
					}
					else
					{
						$addWhereClause .= ' and m.id != '.(int)$tmp_expl_ids;
					}
				}
			}
			else
			{
				if ($placemarkListId != "")
				{
					$tmp_pl_ids = str_replace(';',',', $placemarkListId);
					
					if (strpos($tmp_pl_ids, ','))
					{
						$addWhereClause .= ' and m.id IN ('.$tmp_pl_ids.')';
					}
					else
					{
						$addWhereClause .= ' and m.id = '.(int)$tmp_pl_ids;
					}
				}
				if ($explacemarkListId != "")
				{
					$tmp_expl_ids = str_replace(';',',', $explacemarkListId);
					
					if (strpos($tmp_expl_ids, ','))
					{
						$addWhereClause .= ' and m.id NOT IN ('.$tmp_expl_ids.')';
					}
					else
					{
						$addWhereClause .= ' and m.id != '.(int)$tmp_expl_ids;
					}
				}
				if ($groupListId != "")
				{
					$tmp_grp_ids = str_replace(';',',', $groupListId);
					
					if (strpos($tmp_grp_ids, ','))
					{
						$addWhereClause .= ' and m.markergroup IN ('.$tmp_grp_ids.')';
					}
					else
					{
						$addWhereClause .= ' and m.markergroup = '.(int)$tmp_grp_ids;
					}
				}
				if ($categoryListId != "")
				{
					$tmp_cat_ids = str_replace(';',',', $categoryListId);
					
					if (strpos($tmp_cat_ids, ','))
					{
						$addWhereClause .= ' and m.catid IN ('.$tmp_cat_ids.')';
					}
					else
					{
						$addWhereClause .= ' and m.catid = '.(int)$tmp_cat_ids;
					}
				}
			}
			

			// Remove 'h.published=1 and m.published=1
			// because group may be disabled, but manual edit users placemark enable
			
			$query->select('distinct h.*, c.title as category ')
				->from('#__zhgooglemaps_markergroups as h')
				->leftJoin('#__categories as c ON h.catid=c.id')
				->leftJoin('#__zhgooglemaps_markers as m ON m.markergroup=h.id')
				->where('1=1 ' . $addWhereClause)
				->order('h.title');

			$nullDate = $db->Quote($db->getNullDate());
			$nowDate = $db->Quote(JFactory::getDate()->toMySQL());
			$query->where('(m.publish_up = ' . $nullDate . ' OR m.publish_up <= ' . $nowDate . ')');
			$query->where('(m.publish_down = ' . $nullDate . ' OR m.publish_down >= ' . $nowDate . ')');
				
			$db->setQuery($query);        

			// MarkerGroups
			$markergroups = $db->loadObjectList();


		return $markergroups;
	}


	public static function getPaths($id) 
	{
			$db = JFactory::getDBO();

            $query = $db->getQuery(true);
            $query->select('h.*, c.title as category ')
                ->from('#__zhgooglemaps_paths as h')
				->leftJoin('#__categories as c ON h.catid=c.id')
                ->where('h.published=1 and h.mapid='.(int)$id);
            $db->setQuery($query);        
			
			// Paths
			$paths = $db->loadObjectList();


		return $paths;
	}

	public static function getMapTypes() 
	{
			$db = JFactory::getDBO();

            $query = $db->getQuery(true);
            $query->select('h.*, c.title as category ')
                ->from('#__zhgooglemaps_maptypes as h')
				->leftJoin('#__categories as c ON h.catid=c.id')
                ->where('h.published=1');
            $db->setQuery($query);        
			
			// Map Types
			$maptypes = $db->loadObjectList(); 


		return $maptypes;
	}

	
	public static function getAdSences($id) 
	{

		$db = JFactory::getDBO();

		$query = $db->getQuery(true);

		$addWhereClause = "";
		
		$addWhereClause .= ' and h.mapid='.(int)$id;

		
		$query->select('h.*, c.title as category ')
			->from('#__zhgooglemaps_adsences as h')
			->leftJoin('#__categories as c ON h.catid=c.id')
			->where('h.published=1 ' . $addWhereClause)
			->order('h.title');

		$nullDate = $db->Quote($db->getNullDate());
		$nowDate = $db->Quote(JFactory::getDate()->toMySQL());
		$query->where('(h.publish_up = ' . $nullDate . ' OR h.publish_up <= ' . $nowDate . ')');
		$query->where('(h.publish_down = ' . $nullDate . ' OR h.publish_down >= ' . $nowDate . ')');

		$db->setQuery($query);        

		// AdSences
		$adsences = $db->loadObjectList();
		


		return $adsences;
	}
	
	public static function getEarthAPIKey() 
	{
		// Get global params
		$app = JFactory::getApplication();
        $comparams = JComponentHelper::getParams( 'com_zhgooglemap' );

		$mapapikey4earth = $comparams->get( 'map_key');
		
		return $mapapikey4earth;
	}

	public function getMapAPIKey() 
	{
		// Get global params
		$app = JFactory::getApplication();
        $comparams = JComponentHelper::getParams( 'com_zhgooglemap' );
		
		$mapapikey4map = $comparams->get( 'map_map_key');

		return $mapapikey4map;
	}

	public static function getCompatibleMode() 
	{
		// Get global params
		$app = JFactory::getApplication();
        $comparams = JComponentHelper::getParams( 'com_zhgooglemap' );
		
		$mapcompatiblemode = $comparams->get( 'map_compatiblemode');

		return $mapcompatiblemode;
	}

	public static function getCompatibleModeRSF() 
	{
		// Get global params
		$app = JFactory::getApplication();
        $comparams = JComponentHelper::getParams( 'com_zhgooglemap' );
		
		$mapcompatiblemodersf = $comparams->get( 'map_compatiblemode_rsf');

		return $mapcompatiblemodersf;
	}
	

	public static function getHttpsProtocol() 
	{
		// Get global params
		$app = JFactory::getApplication();
        $comparams = JComponentHelper::getParams( 'com_zhgooglemap' );
		$httpsprotocol = $comparams->get( 'httpsprotocol');
		
		return $httpsprotocol;
	}
	
	public static function getLoadType() 
	{
		// Get global params
		$app = JFactory::getApplication();
        $comparams = JComponentHelper::getParams( 'com_zhgooglemap' );
		$loadtype = $comparams->get( 'loadtype');
		
		return $loadtype;
	}
	
	public function getMapAPIVersion() 
	{
		// Get global params
		$app = JFactory::getApplication();
        $comparams = JComponentHelper::getParams( 'com_zhgooglemap' );
		
		$mapapiversion = $comparams->get( 'map_api_version');

		return $mapapiversion;
	}
	
}
