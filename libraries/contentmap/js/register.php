<?php defined('_JEXEC') or die('Restricted access'); ?>

window.addEvent('domready',function()
{
	<?php
	$id = JRequest::getVar("id", "", "GET");

	require_once(JPATH_ROOT . DS . "libraries" . DS . "contentmap" . DS . "language" . DS . "contentmap.inc");
	$language = JFactory::getLanguage();
	$language->load("com_contentmap.sys", JPATH_ROOT . "/administrator/components/com_contentmap");
	$langcode = preg_replace("/-.*/", "", $language->get("tag"));
	?>
	// Articles manager
	var container = document.getElementById('content-sliders-<?php echo $id; ?>');
	// Plugins manager
	if (!container) container = document.getElementById('plugin-sliders-<?php echo $id; ?>');
	// Modules manager
	if (!container) container = document.getElementById('module-sliders');

	var new_element = document.createElement('div');
	new_element.className = 'contentmap_message contentmap_red';
	new_element.innerHTML =
	'<img style="margin:0; float:left' + ';" src="../media/contentmap/images/cross-circle-frame.png">' +
	'<span style="padding-left' + ':5px; line-height:16px;">' +
	'<?php echo($language->_("COM_CONTENTMAP_PURCHASE")); ?> <a href="http://www.opensourcesolutions.es/ext/contentmap.html" target="_blank"><?php echo($language->_("COM_CONTENTMAP_BUYNOW")); ?></a>' +
	'</span>';

	if (container) container.appendChild(new_element);

}
);
