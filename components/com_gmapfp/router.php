<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.12
	* Creation date: Mars 2012
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

function GMapFPBuildRoute(&$query)
{
	$segments = array();

	// get a menu item based on Itemid or currently active
	$menu = &JSite::getMenu();
	if (empty($query['Itemid'])) {
		$menuItem = &$menu->getActive();
	} else {
		$menuItem = &$menu->getItem($query['Itemid']);
	}

	$mView		= (empty($menuItem->query['view'])) ? null : $menuItem->query['view'];
	$mLayout	= (empty($menuItem->query['layout'])) ? null : $menuItem->query['layout'];
	$mCatid		= (empty($menuItem->query['catid'])) ? null : $menuItem->query['catid'];
	$mId		= (empty($menuItem->query['id'])) ? null : $menuItem->query['id'];

	if(isset($mView))
	{
		if(empty($query['Itemid'])) {
			$segments[] = $query['view'];
		}else {
			if($mView=='gmapfplist') {
				if((@$query['layout']=='categorie')or(@$query['layout']=='groupe')) {
					unset($query['layout']);
					unset($query['catid']);
				}
			}
		}

/*		if ($query['view']=='editlieux')  {
			$segments[] = 'editlieux';
			$query['controller'] = 'editlieux';
			unset($query['layout']);
		}
*/				
		unset($query['view']);
	};

	if(isset($query['layout']))
	{
		$segments[] = $query['layout'];
		unset($query['layout']);
	};

	if (isset($query['catid'])) {
		$segments[] = $query['catid'];
		unset($query['catid']);
	};

	if(isset($query['id'])) {
		$segments[] = $query['id'];
		unset($query['id']);
	};

	if(isset($query['cid'])) {
		$segments[] = $query['cid'];
		unset($query['cid']);
	};

	if(isset($query['controller']))
	{
		unset($query['controller']);
	};

	if(isset($query['task']))
	{
		unset($query['task']);
	};

	if(isset($query['tmpl']))
	{
//		unset($query['tmpl']);
	};

	if(isset($query['id_perso']))
	{
		unset($query['id_perso']);
	};


	return $segments;
}

function GMapFPParseRoute($segments)
{
	$vars = array();

	//Get the active menu item
	$menu =& JSite::getMenu();
	$item =& $menu->getActive();

	// Count route segments
	$count = count($segments);
//die(print_r($segments));
	if ($segments[0] == 'print_article')
	{
		$vars['view']  = 'gmapfp';
		$vars['layout']  = $segments[0];
		$vars['id']    = $segments[1];
		return $vars;
	}

	//Standard routing for articles
	if(!isset($item))
	{
		if ($count == 2)
		{
			$vars['view']  = 'gmapfp';
			$vars['layout']  = $segments[0];
			$vars['id']    = $segments[1];
			return $vars;
		}
		if ($count > 2)
		{
			$vars['view']  = $segments[0];
			$vars['layout']  = $segments[1];
			$vars['id']    = $segments[$count - 1];
			return $vars;
		}
	}

	//Handle View and Identifier
	switch(@$item->query['view'])
	{
		case 'gmapfp' :
		{
			if($count == 2) {
				$vars['view']  = 'gmapfp';
				$vars['layout']  = $segments[0];
				$vars['id'] = $segments[1];
			}
		} break;

		case 'gmapfplist'   :
		{
			if($count == 2) {
				$vars['view']  = 'gmapfp';
				$vars['layout']  = $segments[0];
				$vars['id'] = $segments[1];
			}
		} break;

		case 'gmapfpcontact' :
		{
			if($count == 2) {
				$vars['view']  = 'gmapfp';
				$vars['layout']  = $segments[0];
				$vars['id'] = $segments[1];
			}
		} break;

		case 'editlieux'   :
		{
			$vars['view'] = 'editlieux';
			if ($segments[0] == 'article') $vars['view'] = 'gmapfp';
			$vars['layout']  = $segments[0];
			$vars['id'] = $segments[1];
		} break;

		case 'gestionlieux'   :
		{
			if (!empty($segments[0]))
			{
				switch ($segments[0])
				{
					case 'default' :
					{
						$vars['view'] = 'gestionlieux';
						$vars['layout'] = 'default';
					} break;

					default :
					{
						$vars['view'] = 'editlieux';
						if ($segments[0] == 'article') $vars['view'] = 'gmapfp';
						$vars['layout'] = $segments[0];
						$vars['cid'] = $segments[$count-1];						
					}
				}
			}else{
				$vars['view'] = 'gestionlieux';
			}
		} break;

	}
//die(print_r($item->query['view']));
//die(print_r($segments));
	return $vars;
}
