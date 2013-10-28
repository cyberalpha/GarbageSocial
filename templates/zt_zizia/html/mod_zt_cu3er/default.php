<?php
/**
 * @package ZT Cu3er 3D Slideshow module for Joomla! 2.5.0
 * @author http://www.zootemplate.com
 * @copyright (C) 2012- zootemplate.Com
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

JHTML::_('script','swfobject.js','modules/mod_zt_cu3er/assets/js/swfobject/');
$xmlFile = JURI::base().'modules/mod_zt_cu3er/assets/config/config_'.$module->id.'.xml';
$width = $params->get('slide_panel_width');
$height = $params->get('slide_panel_height');
$flashCu3er = JURI::base().'modules/mod_zt_cu3er/assets/cu3er.swf';
$installExpress = JURI::base().'modules/mod_zt_cu3er/assets/js/swfobject/expressInstall.swf';
 ?>
 <div id="cu3er-wrapper">
 <script type="text/javascript">
		var flashvars = {};
		flashvars.xml = "<?php echo $xmlFile; ?>";		
		var attributes = {};
		attributes.wmode = "transparent";
		attributes.id = "slider<?php echo $module->id; ?>";
		swfobject.embedSWF("<?php echo $flashCu3er; ?>", "jv_cu3er<?php echo $module->id; ?>", "<?php echo $width; ?>", "<?php echo $height; ?>", "9", "<?php echo $installExpress; ?>", flashvars, attributes);
</script>

<div id="jv_cu3er<?php echo $module->id; ?>">
	<a href="http://www.zootemplate.com/joomla-templates.html" title="joomla templates">joomla templates</a> and <a href="http://www.zootemplate.com/joomla-extensions.html" title="joomla extensions">joomla extensions</a> by zootemplate.com
    <a href="http://www.adobe.com/go/getflashplayer">
        <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
    </a>
</div>
</div>