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
$document->addStyleSheet(JURI::base() . 'templates/zt_zizia/css/zt_slideshow.css');
$document->addScript(JURI::base() . 'modules/mod_zt_headline/assets/js/jquery.nivo.slider.js');
$document->addScript(JURI::base() . 'modules/mod_zt_headline/assets/js/jquery.jparallax.min.js');
$cssMod 	= "width:".$moduleWidth."px; height: ".$moduleHeight."px;";
$effect = $params->get('zt_slideshow_effect');
$pagenav = $params->get('zt_slideshow_enable_btn');
$noslide = $params->get('zt_slideshow_no_slice');
$ThumbWidth = $params->get('thumbWidth');
$ThumbHeight = $params->get('thumbHeight');
$ThumbnavWidth = $params->get('thumbnavWidth');
$ThumbnavHeight = $params->get('thumbnavHeight');
$mainWidth = $params->get('thumbWidth');
$pautime = $params->get('timming');
$animSpeed = $params->get('trans_duration');
$auto = $params->get('zt_slideshow_autorun');
if($auto>0) $setauto = 'true';
else $setauto = 'false';
$enabledesc = $params->get('zt_slideshow_enable_description');
if($enabledesc){
	$opacity='0.7';
}else{
	$opacity='0';
} 
$controlnavthumb = $params->get('zt_slideshow_enable_controlNavThumbs');
if($controlnavthumb>0) $controlnav = 'true';
else $controlnav = 'false';
if($pagenav>0) $pagenavc = 'true';
else $pagenavc = 'false';
?> 
<div class="slider-wrapper theme-default <?php if($controlnavthumb>0) echo 'thumbnav';?>" style="<?php echo $cssMod;?>">
	<div id="nivoSlider-wrapper">
		<div id="slider<?php echo $moduleId; ?>" class="nivoSlider nivoSliderleft loading" style="width: <?php echo $mainWidth;?>px; height: <?php echo $ThumbHeight;?>px;"> 
			<?php
			$i=0;
			foreach($slides as $item) { ?>
				<?php if($item->thumbs) { ?>
					<?php if($linkimg){?>
						<a href="<?php echo $item->link; ?>">
							<img src="<?php echo JURI::root().'modules/mod_zt_headline/timthumb.php?src='.$item->thumbs.'&amp;h='.$ThumbHeight.'&amp;w='.$ThumbWidth; ?>" alt="<?php echo $item->title; ?>" rel="<?php echo JURI::root().'modules/mod_zt_headline/timthumb.php?src='.$item->thumbs.'&amp;h='.$ThumbnavHeight.'&amp;w='.$ThumbnavWidth; ?>" title="#htmlcaption<?php echo $i;?>" />
						</a>
					<?php }else{?>
						<img src="<?php echo JURI::root().'modules/mod_zt_headline/timthumb.php?src='.$item->thumbs.'&amp;h='.$ThumbHeight.'&amp;w='.$ThumbWidth; ?>" alt="<?php echo $item->title; ?>" rel="<?php echo JURI::root().'modules/mod_zt_headline/timthumb.php?src='.$item->thumbs.'&amp;h='.$ThumbnavHeight.'&amp;w='.$ThumbnavWidth; ?>" title="#htmlcaption<?php echo $i;?>" />
					<?php }?>
				<?php } ?>
			<?php
			$i++;
			} ?> 
		</div>
	</div>
	<div id="pagenav<?php echo $moduleId; ?>" class="nivo-controlNav Navleft"></div>
	<?php
	$j=0;
	foreach($slides as $item) { ?>
		<div id="htmlcaption<?php echo $j;?>" class="nivo-html-caption"> 
			<h2><a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h2> 
			<?php if($enabledesc){?>
			<p><?php echo $item->introtext; ?></p>
			<?php }?>
		</div>
	<?php
	$j++;
	}
	?> 
</div>
<script type="text/javascript"> 
Zoo(window).load(function() { 
	Zoo('#slider<?php echo $moduleId; ?>').nivoSlider({ 
		effect: '<?php echo $effect;?>',
		slices: <?php echo $noslide;?>,
		boxCols: 8,
		boxRows: 4,
		animSpeed: <?php echo $animSpeed;?>,
		pauseTime: <?php echo $pautime;?>,
		startSlide: 0,
		directionNav: true,
		directionNavHide: true,
		controlNav: <?php echo $pagenavc;?>,
		controlNavThumbs: <?php echo $controlnav;?>,
        controlNavThumbsFromRel: true,
		controlNavID: <?php echo $moduleId;?>,
		keyboardNav: true,
		pauseOnHover: true,
		manualAdvance: false,
		captionOpacity: <?php echo $opacity;?>,
		prevText: 'Prev',
		nextText: 'Next',
		autoplay: <?php echo $setauto;?>,
		beforeChange: function(){Zoo('#slider<?php echo $moduleId; ?> div.bgslide img').animate({opacity:'0' }, 2000);},
		afterChange: function(){}
	}); 
}); 
</script>