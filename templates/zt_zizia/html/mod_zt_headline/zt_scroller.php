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
$document->addScript(JURI::base() . 'modules/mod_zt_headline/assets/js/plugins.js');
$document->addScriptDeclaration('var Zoo = jQuery.noConflict();');
$document->addStyleSheet(JURI::base() . 'templates/zt_zizia/css/zt_scroller.css');
$document->addScript(JURI::base() . 'modules/mod_zt_headline/assets/js/jquery.jcarousellite.js');
$cssMod 	= "width:".$moduleWidth."px; height: ".$moduleHeight."px;";
$effect = $params->get('zt_scroller_effect');
$itemwidth = $params->get('itemWidth', 250);
$pagenav = $params->get('zt_scroller_enable_btn');
$noslide = $params->get('zt_scroller_no_item'); 
$enabledesc = $params->get('zt_scroller_enable_description');
$auto = $params->get('zt_scroller_autorun');
$ThumbWidth = $params->get('thumbWidth');
$ThumbHeight = $params->get('thumbHeight');
$pautime = $params->get('timming');
$animSpeed = $params->get('trans_duration');
$scroll = $params->get('zt_scroller_running',1);
$com = $params->get('content_type');
if($com=='k2'){
	$article =$params->get('k2article_id');
	$arrArticle = explode(';',$article); 
}else{
	$article 	= $params->get('article_id');
	$arrArticle = explode(';',$article);
}

$pagenavWidth = $noslide*$itemwidth;
?>
<div class="zt_scroller">
<div id="zt_scroller<?php echo $moduleId;?>" class="scroller-slider" style="<?php echo $cssMod;?>">  
	<ul style="margin: 0pt; padding: 0pt; position: relative; list-style-type: none; z-index: 1;">
	<?php
	$j=0;
	foreach($slides as $item) { ?>
		<li style="overflow: hidden; float: left; width: <?php echo $itemwidth;?>px; height: <?php echo $moduleHeight;?>px;"> 
			<div class="catpanel "> 
				<div class="block"> 
					<?php if($item->thumbs) { ?>
						<?php if($linkimg){?>
						<a class="img" href="<?php echo $item->link; ?>"><img src="<?php echo JURI::root().'modules/mod_zt_headline/timthumb.php?src='.$item->thumbs.'&amp;h='.$ThumbHeight.'&amp;w='.$ThumbWidth; ?>" alt="<?php echo $item->title; ?>" title="<?php echo $item->title;?>" /></a>
						<?php }else{?>
						<span class="img"><img src="<?php echo JURI::root().'modules/mod_zt_headline/timthumb.php?src='.$item->thumbs.'&amp;h='.$ThumbHeight.'&amp;w='.$ThumbWidth; ?>" alt="<?php echo $item->title; ?>" title="<?php echo $item->title;?>" /></span> 
						<?php }?>
					<?php } ?> 
					<a class="title" href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a>
					<?php if($enabledesc){?>
					<?php echo $item->introtext; ?>
					<?php }?>
				</div>  
			</div> 							
		</li>
	<?php
	$j++;
	}
	?> 
	</ul> 
	
</div>

<?php if($pagenav){?>
	<div class="pagenave" style="width:<?php echo $pagenavWidth;?>px;top:<?php echo ($ThumbHeight/2)-10 ?>px ">
		<button id="prev<?php echo $moduleId;?>" class="prev"></button>
		<button id="next<?php echo $moduleId;?>" class="next"></button>
	</div>
<?php }?>
</div>
<script type="text/javascript">  
Zoo(document).ready(function() { 
	Zoo(function() {
		Zoo("#zt_scroller<?php echo $moduleId;?>").jCarouselLite({
			<?php if($pagenav){?>
			btnNext: "#next<?php echo $moduleId;?>",
			btnPrev: "#prev<?php echo $moduleId;?>", 
			<?php }?>
			visible: <?php echo $noslide;?>,
			<?php if($auto){?> 
			auto: <?php echo $pautime;?>, 
			<?php }?>
			scroll: <?php echo $scroll;?>,
			easing: "<?php echo $effect;?>",
			speed: <?php echo $animSpeed;?>
		});
	}); 
});
</script>