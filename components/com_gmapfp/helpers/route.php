<?php
	/*
	* GMapFP Component Google Map for Joomla! 2.5.x
	* Version 9.22
	* Creation date: Septembre 2012
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.helper');
jimport('joomla.application.categories');

class GMapFPHelperRoute
{
	protected static $lookup;

	function getArticleRoute($id, $catid = 0)
	{
		$needles = array(
			'article'  => array((int) $id)
		);

		//Create the link
		$link = 'index.php?option=com_gmapfp&view=gmapfp&layout=article&id='. $id;
		if ((int)$catid > 1)
		{
			$categories = JCategories::getInstance('GMapFP');
			$category = $categories->get((int)$catid);
			if($category)
			{
				$needles['category'] = array_reverse($category->getPath());
			}
		}

		if ($item = self::_findItem($needles)) {
			if (array_key_exists('article', $item)) $link = 'index.php?&Itemid='.$item['article'];
			elseif (array_key_exists('cat', $item)) $link = 'index.php?option=com_gmapfp&view=gmapfp&layout=article&id='. $id.'&Itemid='.$item['cat'];
			elseif (array_key_exists('all', $item)) $link = 'index.php?option=com_gmapfp&view=gmapfp&layout=article&id='. $id.'&Itemid='.$item['all'];
		}

		return $link;
	}

	function getCategoryRoute($catid, $display = '')
	{
		$link = 'index.php?option=com_gmapfp&view=gmapfp&catid='.$catid;

		//recherche si cat appartient a un groupe
		if ((int)$catid > 1)
		{
			$categories = JCategories::getInstance('GMapFP');
			$category = $categories->get((int)$catid);
			if($category)
			{
				$needles['category'] = array_reverse($category->getPath());
			}
		}

		$view = '&view=gmapfp';
		if ($display  = 'list') $view = '&view=gmapfplist';

		//Create the link
		if ($item = self::_findItem($needles)) {
			if (array_key_exists('cat', $item)) $link = 'index.php?option=com_gmapfp'.$view.'&catid='. $id.'&Itemid='.$item['cat'];
			elseif (array_key_exists('all', $item)) $link = 'index.php?option=com_gmapfp'.$view.'&catid='. $id.'&Itemid='.$item['all'];
		}

		return $link;
	}

	protected static function _findItem($needles = null)
	{
		$app		= JFactory::getApplication();
		$menus		= $app->getMenu('site');
		$component	= JComponentHelper::getComponent('com_gmapfp');
		$items		= $menus->getItems('component_id', $component->id);

		$match = array();

		foreach($needles as $needle => $ids)
		{
			foreach($ids as $id)
			{
				foreach($items as $item)
				{
					//recherche article
					if (@$item->query['layout'] == $needle && @$item->params->get('id') == (int)$id) {
						$match['article'] = $item->id;
						break 3;
					}
					//recherche catégorie
					if ($needle == 'category' && (@$item->query['view'] == 'gmapfp' || @$item->query['view'] == 'gmapfplist') && @$item->params->get('catid') == (int)$id) {
						$match['cat'] = $item->id;
						break 3;
					}
					//recherche dans all
					if (empty($match['all']) && (@$item->query['view'] == 'gmapfp' || @$item->query['view'] == 'gmapfplist') && !isset($item->query['layout'])) {
						$match['all'] = $item->id;
					}
				}
			}
		}
		return $match;
	}
}
?>
