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

$list = ModSobiproCategoriesHelper::getList($parentid, $count, $sorder, $require_stats, $debug);
if (!count($list))
{
	echo 'Empty Section';
	return;
}
?>
<ul class="sobipcateg<?php echo $params->get('moduleclass_sfx'); ?>"><?php
/* index.php?option=com_sobipro&sid=64:Homeopatia&Itemid=235 */

$outpcount = '';
$i = 0;
foreach ($list as $item)
{
	$evenoddd = ($i % 2 == 0 ? 'even' : 'odd');
	$iid = ModSobiproCategoriesHelper::getItemId($scitemid, $subItemsid, $item->id, $defaultItemid);

	// $url = "index.php?option=com_sobipro&sid=" . $item->id . ":" . str_replace('_', '-', $item->alias) . ($iid ? "&Itemid=" . $iid : null);
	// $url = JRoute::_($url);

	$urlparams = array('sid' => $item->id, 'title' => $item->name);
	if ($iid)
	{
		$urlparams['Itemid'] = $iid;
	}
	$url = Sobi::Url($urlparams);

	$total = (property_exists($item, 'total') ? $item->total : 0 );
	$counter = $item->counter;
	$c = ModSobiproCategoriesHelper::getCounter($scounter, $total, $counter);
	if ($c)
	{
		$outpcount = ' <span class="counter"> (' . $c . ')</span>';
	}

	$class = ($actual_sid == $item->id ? ' active sobiprocateg_active' : null);

	if ((!$hide_empty) || ($total > 0))
	{
		?>
			<li class="<?php echo $evenoddd . $class; ?>">
				<a href="<?php echo $url; ?>" 
				   class="<?php echo $class; ?>">
			<?php echo $item->name; ?></a>
				<?php echo $outpcount; ?>
			</li>
			<?php
	}
		$i++;
}
	?>
</ul>
