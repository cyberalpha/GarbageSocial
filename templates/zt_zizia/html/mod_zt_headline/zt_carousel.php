<?php
/**
 * @package ZT Headline module 
 * @author http://www.ZooTemplate.com
 * @copyright (C) 2010- ZooTemplate.com
 * @license PHP files are GNU/GPL
**/
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.mootools');

$document 	= JFactory::getDocument();
$document->addScript(JURI::base() . 'modules/mod_zt_headline/assets/js/jquery-1.7.1.min.js'); 
$document->addScriptDeclaration('var Zoo = jQuery.noConflict();'); 
$document->addStyleSheet(JURI::base() . 'templates/zt_zizia/css/zt_carousel.css');
$document->addScript(JURI::base() . 'modules/mod_zt_headline/assets/js/jquery.roundabout.js');
$cssMod 	= "width:".$moduleWidth."px; height: ".$moduleHeight."px;";
$ThumbWidth = $params->get('thumbWidth');
$ThumbHeight = $params->get('thumbHeight');
$duration = $params->get('zt_carousel_duration', 3000); 
$autorun = $params->get('zt_carousel_autorun', 1);
$animSpeed = $params->get('trans_duration');
$pautime = $params->get('timming');
?>
<div id="zt_carousel">
	<ul id="myRoundabout_<?php echo $moduleId;?>" class="roundabout-holder" style="<?php echo $cssMod;?> display: block; padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; position: relative; z-index: 100; ">
		<?php
		$j=0;
		foreach($slides as $item) { ?>	
		<li class="roundabout-moveable-item" style="width: <?php echo $ThumbWidth;?>px; height: <?php echo $ThumbHeight;?>px;">
			<div class="roundabout-moveable-inner">
				<div class="roundabout-image">
					<img src="<?php echo JURI::root().'modules/mod_zt_headline/timthumb.php?src='.$item->thumbs.'&amp;h='.$ThumbHeight.'&amp;w='.$ThumbWidth; ?>" alt="<?php echo $item->title; ?>"/>
				</div>
				<div class="roundabout-description" style="width:800px !important; left: -190px;">
					<p class="caption">
						<a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a>
					</p>
				</div>
				<div class="roundabout-shadow">
					<img src="<?php echo JURI::root();?>modules/mod_zt_headline/assets/images/zt_carousel/shadow.png" alt=""/>
				</div>
			</div>
		</li>
		<?php
		$j++;
		}
		?> 
	</ul>
	<ul id="pagenav<?php echo $moduleId;?>" class="pagenav">
		<?php
		$i=0;
		foreach($slides as $row){?>
			<li class="items"><?php echo $i;?></li>
		<?php $i++;
		}?>
	</ul>
</div>
<script type="text/javascript"> 
	Zoo('ul#myRoundabout_<?php echo $moduleId;?>').hide();        
	Zoo(window).bind('load', function($) {
		var interval;
		Zoo('ul#myRoundabout_<?php echo $moduleId;?>:hidden').fadeIn(500);                    
		Zoo('ul#myRoundabout_<?php echo $moduleId;?>').roundabout({
			pagenav: Zoo('ul#pagenav<?php echo $moduleId;?>'),
			duration: <?php echo $animSpeed;?>, 
			minOpacity: 1.0,
			minScale: 0.75,
			reflect: false 
		}).hover(
			function() { 
				clearInterval(interval);
			},
			function() {
				<?php if($autorun){?>
				interval = startAutoPlay();
				<?php }?>
			}
		);
		<?php if($autorun){?>
		interval = startAutoPlay();
		<?php }?>
		function startAutoPlay() {
			return setInterval(function() {
				Zoo('ul#myRoundabout_<?php echo $moduleId;?>').roundabout("animateToNextChild");
			}, <?php echo $pautime;?>);
		}
	});
</script> 