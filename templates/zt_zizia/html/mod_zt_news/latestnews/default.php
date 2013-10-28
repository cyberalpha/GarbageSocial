<?php 
/**
 * @package ZT News Module for Joomla! 2.5
 * @author http://www.ZooTemplate.com
 * @copyright (C) 2011- ZooTemplate.com
 * @license JS files are GNU/GPL
**/

// no direct access
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.mootools');
$document = &JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'modules/mod_zt_news/assets/css/latestnews.css'); 
$moduleId 			= $module->id;
$i 			= 0;
$listItems = $jvNews->getItemsByCatId(); 
$columns   = $params->get('columns', 1);
$showdesc   = $params->get('show_desc', 1);
$count_list = count($listItems);
$width  = round((100/$columns),1);
$imgAlign 		= $params->get('img_align');
?>
<div class="latestnews" style="width:100%">
<?php
	foreach($listItems as $item)
	{
		$i ++;
		
		if($i == $count_list)
			echo '<div class="latestnewsitems last-item" style="width:' . $width . '%">';
		else
			echo '<div class="latestnewsitems" style="width:' . $width . '%">';
			echo '<span class="latestnewsdate">' . JHTML::_('date', $item->created, 'DATE_FORMAT_LC3') . '</span>';
			if($params->get('is_image') == 1 && $item->thumb)
				echo '<a href="' . $item->link .'" class="latestnews' . $params->get('moduleclass_sfx') . '"><img class="'.$imgAlign.'" src="' . $item->thumb . '" border="0" alt="' . $item->title . '" /></a>'; 
			echo '<h4><a href="' . $item->link .'" class="latestnews' . $params->get('moduleclass_sfx') . '">' . $item->title .'</a></h4>';
			if($showdesc) 
				echo $item->introtext;
			 
			
			
			if($params->get('show_readmore')==1)
				echo '<a href="' . $item->link . '" class="readon">'. JText::sprintf('Read more...') . '</a>';
		
		echo '</div>';
	}
?>
</div>