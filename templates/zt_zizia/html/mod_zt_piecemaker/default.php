<?php
/**
 * @package ZT Piecemaker module for Joomla! 2.5
 * @author http://www.zootemplate.com * @copyright (C) 2011- ZooTemplate.Com
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
defined('_JEXEC') or die('Restricted access!');
$urlBase = JURI::base();
$jsSwfObject = $urlBase . "modules/mod_zt_piecemaker/js/swfobject.js";
JHTML::_('script','swfobject.js','modules/mod_zt_piecemaker/js/');
$swfExpress = $urlBase . "modules/mod_zt_piecemaker/js/expressInstall.swf";
$xmlFile = JPATH_BASE.DS."modules".DS."mod_zt_piecemaker".DS."assets".DS."xml".DS."piecemakerXML".$module->id.".xml";
$modWidth = $params->get('module_width');
$modHeight = $params->get('module_height');
?>
<script type="text/javascript">
	var flashvars = {};
	flashvars.xmlSource = "<?php echo $urlBase; ?>modules/mod_zt_piecemaker/assets/xml/piecemakerXML<?php echo $module->id;?>.xml";
	flashvars.cssSource = "<?php echo $urlBase; ?>modules/mod_zt_piecemaker/assets/css/piecemakerCSS.css";
	flashvars.imageSource = "<?php echo $urlBase; ?>";
	var attributes = {};
	attributes.wmode = "transparent";
	swfobject.embedSWF("<?php echo $urlBase; ?>modules/mod_zt_piecemaker/piecemaker.swf", "jv_piecemaker<?php echo $module->id;?>", "<?php echo $modWidth; ?>", "<?php echo $modHeight; ?>", "10", "$swfExpress", flashvars, attributes);	
</script>
<div class="jv_piecemaker_wrap">
<div id="jv_piecemaker<?php echo $module->id;?>">
      <p>In order to view this object you need Flash Player 9+ support!</p>
	   <a href="http://www.zootemplate.com/joomla-templates.html" title="joomla templates">joomla templates</a> and <a href="http://www.zootemplate.com/joomla-extensions.html" title="joomla extensions">joomla extensions</a> by zootemplate.com
       <a href="http://www.adobe.com/go/getflashplayer">
          <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player"/>
       </a> 
</div>
</div>  