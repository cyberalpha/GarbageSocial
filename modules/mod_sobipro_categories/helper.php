<?php

/**
 * @package     Extly.Modules
 * @subpackage  mod_sobipro_categories - Categories of SobiPro
 * 
 * @author      Prieco S.A. <support@extly.com>
 * @copyright   Copyright (C) 2007 - 2012 Prieco, S.A. All rights reserved.
 * @license     http://http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL 
 * @link        http://www.prieco.com http://www.extly.com http://support.extly.com 
 */
// No direct access
defined('_JEXEC') or die('Restricted access');

require_once JPATH_SITE . DS . 'components' . DS . 'com_content' . DS . 'helpers' . DS . 'route.php';

/**
 * ModSobiproCategoriesHelper Helper class.
 *
 * @package     Extly.Modules
 * @subpackage  mod_sobiextsearch
 * @since       1.0
 */
class ModSobiproCategoriesHelper
{

	/**
	 * getListNLevel
	 *
	 * @param   mixed  $parentid            the params
	 * @param   mixed  $categorystartlevel  the params
	 * @param   mixed  $categorymode        the params
	 * @param   mixed  $count               the params
	 * @param   mixed  $sorder              the params
	 * @param   mixed  $require_stats       the params
	 * @param   mixed  $isMultimode         the params
	 * @param   mixed  $debug               the params
	 *
	 * @return  the list
	 *
	 * @since   1.0
	 */
	public function getListNLevel($parentid, $categorystartlevel, $categorymode, $count, $sorder, $require_stats, $isMultimode, $debug)
	{
		if ($debug)
		{
			echo "getListNLevel: parentid: {$parentid}, categorystartlevel: {$categorystartlevel}, categorymode: {$categorymode}, count: {$count}, sorder: {$sorder}, require_stats: {$require_stats}, isMultimode: {$isMultimode}, debug: {$debug}";
		}

		$db = & JFactory::getDBO();
		$results = array();

		$lang = JFactory::getLanguage();
		$current_lang = $lang->getTag();

		$parents = array();
		$parents[] = $parentid;

		$qorder = self::getQueryOrder($sorder, $require_stats);

		for ($level = 1; $level <= $categorymode; $level++)
		{
			$next_parents = array();
			$n = count($parents);
			for ($i = 0; ($i < $n); $i++)
			{
				$sectionid = $parents[$i];

				if ($isMultimode)
				{
					$query = 'SELECT c.id AS id, IF(l.sValue IS NULL, c.name, l.sValue) AS name, 
						c.nid AS alias, c.counter AS counter' . ($require_stats ? ', t.total AS total' : '') .
							' FROM #__sobipro_object AS c ' .
							($sorder == 5 ? ' JOIN #__sobipro_relations AS cc ON c.id = cc.id' : '') .
							' LEFT OUTER JOIN #__sobipro_language l ON l.sKey = ' . $db->Quote('name') . ' AND l.id = c.id AND l.language = ' . $db->Quote($current_lang) .
							($require_stats ? ' LEFT OUTER JOIN tmptotals AS t ON c.id = t.id' : '') .
							' WHERE c.parent = ' . $sectionid .
							' AND c.state = 1 AND c.oType=' . $db->Quote('category') . $qorder;
				}
				else
				{
					$query = 'SELECT c.id AS id, c.name AS name, c.nid AS alias, c.counter AS counter' . ($require_stats ? ', t.total AS total' : '') .
							' FROM #__sobipro_object AS c ' .
							($sorder == 5 ? ' JOIN #__sobipro_relations AS cc ON c.id = cc.id' : '') .
							($require_stats ? ' LEFT OUTER JOIN tmptotals AS t ON c.id = t.id' : '') .
							' WHERE c.parent = ' . $db->Quote($sectionid) .
							' AND c.state = 1 AND oType=' . $db->Quote('category') . $qorder;
				}

				/* if ($debug)
				  {
				  echo 'QUERY:' . $query . '</br>';
				  } */

				$db->setQuery($query, 0, $count);
				$rows = $db->loadObjectList('id');

				if ($db->getErrorNum() != 0)
				{
					echo "</br>ERROR: " . nl2br($db->getErrorMsg());
					return null;
				}
				$results[$sectionid] = $rows;
				$next_parents = array_merge($next_parents, array_keys($rows));
			}
			$parents = $next_parents;
		}
		return $results;
	}

	/**
	 * generate
	 *
	 * @param   mixed  &$list               the params
	 * @param   mixed  $iterator_sid        the params
	 * @param   mixed  $actual_sid          the params
	 * @param   mixed  $scitemid            the params
	 * @param   mixed  $subItemsid          the params
	 * @param   mixed  $defaultItemid       the params
	 * @param   mixed  $scounter            the params
	 * @param   mixed  $hide_empty          the params
	 * @param   mixed  $categorystartlevel  the params
	 * @param   mixed  $categorymode        the params
	 * @param   mixed  $level               the params
	 * @param   mixed  $i                   the params
	 *
	 * @return  the list
	 *
	 * @since   1.0
	 */
	public function generate(
		&$list,
		$iterator_sid,
		$actual_sid,
		$scitemid,
		$subItemsid,
		$defaultItemid,
		$scounter,
		$hide_empty, $categorystartlevel, $categorymode, $level = 1, $i = 0)
	{
		$html_output = '';

		$items = $list[$iterator_sid];
		foreach ($items as $item)
		{
			$evenoddd = ($i % 2 == 0 ? 'even' : 'odd');
			$i++;

			// ItemId
			$iid = self::getItemId($scitemid, $subItemsid, $item->id, $defaultItemid);

			// Url
			$urlparams = array('sid' => $item->id, 'title' => $item->name);
			if ($iid)
			{
				$urlparams['Itemid'] = $iid;
			}
			$url = Sobi::Url($urlparams);

			// Counter
			$counter = $item->counter;
			$total = (property_exists($item, 'total') ? $item->total : 0 );
			$c = self::getCounter($scounter, $total, $counter);
			$outpcount = '';
			if ($c)
			{
				$outpcount = ' <span class="counter"> (' . $c . ')</span>';
			}

			// Current Page Sid
			$class = ($actual_sid == $item->id ? ' active sobiprocateg_active' : null);

			// Leaf
			$ok_to_display = (
					(($level >= $categorystartlevel) && ($level <= $categorymode)) &&
					((!$hide_empty) || ($total > 0))
					);
			if ($ok_to_display)
			{
				$output = "<li class=\"sobipcateg_l{$level} {$evenoddd} {$class}\"><a href=\"{$url}\" class=\"{$class}\">{$item->name}</a>{$outpcount}\n";
			}
			else
			{
				$output = '';
			}

			// It's a parent
			$childs = null;
			if (array_key_exists($item->id, $list))
			{
				$childs = $list[$item->id];
			}
			if (($childs) && ($level < $categorymode))
			{
				$output .= "<ul class=\"sobipcateg_l{$level} {$evenoddd}{$class}\">" .
						self::generate(
								$list, $item->id, $actual_sid, $scitemid, $subItemsid,
								$defaultItemid, $scounter, $hide_empty, $categorystartlevel,
								$categorymode, $level + 1, $i
						)
						. '</ul>';
			}
			if ($ok_to_display)
			{
				$output .= '</li>';
			}

			$html_output .= $output;
		}
		return $html_output;
	}

	/**
	 * getQueryOrder
	 *
	 * @param   mixed  $sorder         the params
	 * @param   mixed  $require_stats  the params
	 * 
	 * @return  the value
	 *
	 * @since   1.0
	 */
	public function getQueryOrder($sorder, $require_stats)
	{
		$qorder = '';
		if ($sorder == 1)
		{
			$qorder = ' ORDER BY c.name';
		}
		elseif ($sorder == 2)
		{
			$qorder = ' ORDER BY c.id';
		}
		elseif ($sorder == 3)
		{
			$qorder = ($require_stats ? ' ORDER BY t.total desc' : ' ORDER BY c.counter desc');
		}
		elseif ($sorder == 4)
		{
			$qorder = ' ORDER BY c.nid';
		}
		elseif ($sorder == 5)
		{
			$qorder = ' ORDER BY cc.position, c.name';
		}
		elseif ($sorder == 6)
		{
			$qorder = ' ORDER BY RAND()';
		}
		return $qorder;
	}

	/**
	 * getDefaultItemid
	 *
	 * @param   mixed  $parentid  the params
	 * 
	 * @return  the value
	 *
	 * @since   1.0
	 */
	public function getDefaultItemid($parentid)
	{
		$db = & JFactory::getDBO();
		$url = $db->quote("index.php?option=com_sobipro&sid=" . $parentid);
		$type = $db->quote('component');

		$query = 'SELECT ' . $db->nameQuote('id') . ' FROM ' . $db->nameQuote('#__menu')
				. ' WHERE ' . $db->nameQuote('link') . ' = ' . $url . ' AND ' . $db->nameQuote('published') . '=' . $db->Quote(1) . ' '
				. 'AND ' . $db->nameQuote('type') . '=' . $db->Quote('component');
		$db->setQuery($query);
		$defaultId = $db->loadResult();

		return $defaultId;
	}

	/**
	 * getSubItemsid
	 *
	 * @param   mixed  $parentid  the params
	 * 
	 * @return  the value
	 *
	 * @since   1.0
	 */
	public function getSubItemsid($parentid)
	{
		$db = & JFactory::getDBO();
		$url = $db->quote("index.php?option=com_sobipro&sid=%");
		$type = $db->quote('component');

		$query = 'SELECT ' . $db->nameQuote('id') . ',' . $db->nameQuote('link') . ' FROM ' . $db->nameQuote('#__menu')
				. ' WHERE ' . $db->nameQuote('link') . ' like ' . $url . ' AND ' . $db->nameQuote('published') . '=' . $db->Quote(1) . ' '
				. 'AND ' . $db->nameQuote('type') . '=' . $db->Quote('component');

		$db->setQuery($query);
		$results = $db->loadObjectList('id');

		$subItemsid = Array();

		foreach ($results as $key => $value)
		{
			$link = $value->link;
			if (preg_match("/sid\=([0-9]+)/", $link, $matches))
			{
				$subItemsid[$matches[1]] = $value->id;
			}
		}

		if (isset($subItemsid[$parentid]))
		{
			unset($subItemsid[$parentid]);
		}

		return $subItemsid;
	}

	/**
	 * getItemId
	 *
	 * @param   mixed  $scitemid       the params
	 * @param   mixed  &$subItemsid    the params
	 * @param   mixed  $id             the params
	 * @param   mixed  $defaultItemid  the params
	 * 
	 * @return  the value
	 *
	 * @since   1.0
	 */
	public function getItemId($scitemid, &$subItemsid, $id, $defaultItemid)
	{
		$iid = null;

		// Force a global itemid
		if (!empty($scitemid))
		{
			$iid = $scitemid;
		}
		else
		{
			if ((!empty($subItemsid)) && (count($subItemsid) > 0) && (array_key_exists($id, $subItemsid)))
			{
				// Try a Sub ItemId
				$iid = $subItemsid[$id];
				if (empty($iid))
				{
					// Just the default
					$iid = $defaultItemid;
				}
			}
			else
			{
				// Just the default
				$iid = $defaultItemid;
			}
		}
		return $iid;
	}

	/**
	 * getTotal
	 *
	 * @param   mixed  $scounter  the params
	 * @param   mixed  $hits      the params
	 * @param   mixed  &$totals   the params
	 * @param   mixed  $catid     the params
	 * 
	 * @return  the value
	 *
	 * @since   1.0
	 */
	public function getTotal($scounter, $hits, &$totals, $catid)
	{
		if ($scounter == 0)
		{
			return 0.999;
		}
		// Hits
		elseif ($scounter == 1)
		{
			return $hits;
		}
		// Entries
		elseif ($scounter == 2)
		{
			return ($totals[$catid] ? $totals[$catid] : 0);
		}
	}

	/**
	 * getTotal
	 *
	 * @param   mixed  $scounter  the params
	 * @param   mixed  $total     the params
	 * @param   mixed  $counter   the params
	 * 
	 * @return  the value
	 *
	 * @since   1.0
	 */
	public function getCounter($scounter, $total, $counter)
	{
		// Hits
		if ($scounter == 1)
		{
			return $counter;
		}
		// Entries
		if ($scounter == 2)
		{
			return $total;
		}
		return null;
	}

	/**
	 * getMultimode
	 * 
	 * @param   mixed  $debug  the params
	 *
	 * @return  the value
	 *
	 * @since   1.0
	 */
	public function getMultimode($debug = 0)
	{
		$db = & JFactory::getDBO();

		$query = 'SELECT ' . $db->nameQuote('sValue') . ' FROM ' . $db->nameQuote('#__sobipro_config')
				. ' WHERE ' . $db->nameQuote('cSection') . ' = ' . $db->Quote('lang') .
				' AND ' . $db->nameQuote('sKey') . ' = ' . $db->Quote('multimode') .
				' AND ' . $db->nameQuote('section') . '=0';
		$db->setQuery($query);

		if ($debug)
		{
			echo 'multimode: ' . $query . '</br>';
		}

		$multimode = $db->loadResult();

		return $multimode;
	}

}
