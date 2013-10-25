<?php
/**
 * @version		$Id: default.php 2012-03-18 vinaora $
 * @package		Vinaora Cu3er 3D Slideshow
 * @subpackage	mod_vinaora_cu3er_3d_slideshow
 * @copyright	Copyright (C) 2010 - 2012 VINAORA. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @website		http://vinaora.com
 * @twitter		http://twitter.com/vinaora
 * @facebook	http://facebook.com/vinaora
 */

// no direct access
defined('_JEXEC') or die;
?>

<!-- BEGIN: VINAORA CU3ER 3D SLIDE SHOW -->
<!-- Website http://vinaora.com -->
<style>
#v3dslideshow<?php echo $module_id; ?>{
	width:<?php echo $width; ?>px;
	height:<?php echo $height; ?>px;
}
<?php if($border_width){ ?>
#v3dslideshow<?php echo $module_id; ?> {
	border-color:<?php echo $border_color; ?>;
	border-style:<?php echo $border_style; ?>;
	border-width:<?php echo $border_width; ?>px;
}

<?php if($border_rounded){ ?>
#v3dslideshow<?php echo $module_id; ?> {
	-moz-border-radius: 8px 8px 8px 8px;
	-webkit-border-radius: 8px 8px 8px 8px;
	border-radius: 8px 8px 8px 8px;
}
<?php } ?>
<?php if($border_shadow){ ?>
#v3dslideshow<?php echo $module_id; ?> {
	-webkit-box-shadow: 0px 1px 5px 0px #4a4a4a;
	-moz-box-shadow: 0px 1px 5px 0px #4a4a4a;
	box-shadow: 0px 1px 5px 0px #4a4a4a;
}
<?php } ?>
<?php } ?>
<?php if($footer != "-1"){ ?>
#v3dslideshow<?php echo $module_id; ?>-footer{
	text-align:center;
	width:<?php echo $width+($border_width*2); ?>px;
	margin: -<?php echo ($width/20); ?>px 0 0 0;
	padding: 0;
}
#v3dslideshow<?php echo $module_id; ?>-footer img{
	width:<?php echo $width+($border_width*2); ?>px;
	height:auto;
	border: 0 none;
}
<?php } ?>
</style>
<script type="text/javascript">
	var flashvars = {};
		flashvars.xml = "<?php echo $config_name; ?>";
		flashvars.font = "<?php echo $font_path; ?>";
	var attributes = {};
		attributes.wmode = "<?php echo $flash_wmode; ?>";
		attributes.id = "slider<?php echo $module_id; ?>";
	swfobject.embedSWF(<?php echo "\"$slideshow_path\", \"$container\", \"$width\", \"$height\", \"$flash_version\", \"$expressInstall_path\""; ?>, flashvars, attributes);
</script>
<div id="v3dslideshow<?php echo $module_id; ?>" class="v3dslideshow<?php echo $moduleclass_sfx; ?>">
	<div id="<?php echo $container; ?>">
		<a href="http://www.adobe.com/go/getflashplayer">
			<img src="<?php echo $media; ?>images/get_flash_player.gif" alt="Get Adobe Flash player for Vinaora Cu3er 3D Slideshow" />
		</a>
		<br />
		<a href="http://vinaora.com/">Free Joomla Templates, extensions &amp; tutorials</a>
	</div>
</div>
<?php if($footer != "-1"){ ?>
<div id="v3dslideshow<?php echo $module_id; ?>-footer">
	<img src="<?php echo $media; ?>images/footer/<?php echo $footer; ?>.png" alt="Vinaora C3er 3D Slideshow"/>
</div>
<?php } ?>
<!-- Website http://vinaora.com -->
<!-- END: VINAORA CU3ER 3D SLIDE SHOW -->
