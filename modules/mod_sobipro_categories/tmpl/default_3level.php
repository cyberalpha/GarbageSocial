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

$list = ModSobiproCategoriesHelper::getList3Level($parentid, $count, $sorder, $require_stats, $debug);
if (!count($list))
{
	echo 'Empty Section';
	return;
}
?>
<ul class="sobipcateg<?php echo $params->get('moduleclass_sfx'); ?>">
	<?php
	/* index.php?option=com_sobipro&sid=64:Homeopatia&Itemid=235 */

	$outpcount = '';
	$i = 0;
	$j = 0;
	$k = 0;
	while ($i < count($list))
	{
		$catid = $list[$i]->id;
		$evenoddd = ($j % 2 == 0 ? 'even' : 'odd');
		$j++;
		$iid = ModSobiproCategoriesHelper::getItemId($scitemid, $subItemsid, $catid, $defaultItemid);

		// $url = "index.php?option=com_sobipro&sid=" . $catid . ":" . str_replace('_', '-', $list[$i]->alias) . ($iid ? "&Itemid=" . $iid : null);
		// $url = JRoute::_($url);

		$urlparams = array('sid' => $catid, 'title' => $list[$i]->name);
		if ($iid)
		{
			$urlparams['Itemid'] = $iid;
		}
		$url = Sobi::Url($urlparams);

		$total = (property_exists($list[$i], 'total') ? $list[$i]->total : 0 );
		$counter = $list[$i]->counter;
		$c = ModSobiproCategoriesHelper::getCounter($scounter, $total, $counter);
		if ($c)
		{
			$outpcount = ' <span class="counter"> (' . $c . ')</span>';
		}

		$class = ($actual_sid == $catid ? ' active sobiprocateg_active' : null);

		if ((!$hide_empty) || ($total > 0))
		{
			echo "\t<li class=\"sobipcateg_l1 {$evenoddd}{$class}\"><a href=\"{$url}\" class=\"{$class}\">{$list[$i]->name}</a>{$outpcount}\n";
			echo "\t<ul class=\"sobipcateg_l1 {$evenoddd}{$class}\">\n";
		}

		while (($i < count($list)) && ($catid == $list[$i]->id))
		{
			$cat1id = $list[$i]->c1id;

			if ((!$hide_empty) || ($total > 0))
			{
				$evenoddd = ($k % 2 == 0 ? 'even' : 'odd');
				$k++;
				$iid = ModSobiproCategoriesHelper::getItemId($scitemid, $subItemsid, $cat1id, $defaultItemid);

				// $url = "index.php?option=com_sobipro&sid=" . $cat1id . ":" . str_replace('_', '-', $list[$i]->c1alias) . ($iid ? "&Itemid=" . $iid : null);
				// $url = JRoute::_($url);

				$urlparams = array('sid' => $cat1id, 'title' => $list[$i]->c1name);
				if ($iid)
				{
					$urlparams['Itemid'] = $iid;
				}
				$url = Sobi::Url($urlparams);

				$total_l1 = (property_exists($list[$i], 'c1total') ? $list[$i]->c1total : 0 );
				$counter_l1 = $list[$i]->c1counter;
				$c = ModSobiproCategoriesHelper::getCounter($scounter, $total_l1, $counter_l1);
				if ($c)
				{
					$outpcount = ' <span class="counter"> (' . $c . ')</span>';
				}

				$class = ($actual_sid == $cat1id ? ' active sobiprocateg_active' : null);

				if ((!$hide_empty) || ($total_l1 > 0))
				{
					echo "\t\t<li class=\"sobipcateg_l2 {$evenoddd}{$class}\"><a href=\"{$url}\" class=\"{$class}\">{$list[$i]->c1name}</a>{$outpcount}";
					$buff = "\n\t\t<ul class=\"sobipcateg_l2 {$evenoddd}{$class}\">\n";
					$buff_available = false;
				}
			}

			while (($i < count($list)) && ($catid == $list[$i]->id) && ($cat1id == $list[$i]->c1id))
			{
				$myId = $list[$i]->c2id;
				if (($myId) && ((!$hide_empty) || ($total > 0)) && ((!$hide_empty) || ($total_l1 > 0)))
				{
					$evenoddd = ($i % 2 == 0 ? 'even' : 'odd');
					$iid = ModSobiproCategoriesHelper::getItemId($scitemid, $subItemsid, $myId, $defaultItemid);

					// $url = "index.php?option=com_sobipro&sid=" . $myId . ":" . str_replace('_', '-', $list[$i]->c2alias) . ($iid ? "&Itemid=" . $iid : null);
					// $url = JRoute::_($url);

					$urlparams = array('sid' => $myId, 'title' => $list[$i]->c2name);
					if ($iid)
					{
						$urlparams['Itemid'] = $iid;
					}
					$url = Sobi::Url($urlparams);

					// $total = ModSobiproCategoriesHelper::getTotal($scounter, $list[$i]->c2counter, $totals, $myId);

					$counter = $list[$i]->c2counter;
					$total = (property_exists($list[$i], 'c2total') ? $list[$i]->c2total : 0 );
					$c = ModSobiproCategoriesHelper::getCounter($scounter, $total, $counter);
					if ($c)
					{
						$outpcount = ' <span class="counter"> (' . $c . ')</span>';
					}

					$class = ($actual_sid == $myId ? ' active sobiprocateg_active' : null);

					$buff_available = true;
					$buff = $buff . "\t\t\t<li class=\"sobipcateg_l3 {$evenoddd}{$class}\">
						<a href=\"{$url}\" class=\"{$class}\">{$list[$i]->c2name}</a>{$outpcount}</li>\n";
				}
				$i++;
			}
			if (((!$hide_empty) || ($total > 0)) && ((!$hide_empty) || ($total_l1 > 0)))
			{
				$buff = $buff . "\t\t</ul>\n";
				if ($buff_available)
				{
					echo$buff;
				}
				echo "\t\t</li>\n";
			}
		}
		if ((!$hide_empty) || ($total > 0))
		{
			echo "\t</ul>\n";
			echo "\t</li>\n";
		}
	}
	?>
</ul>
