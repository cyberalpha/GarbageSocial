<?php
/**
 * @package Install Template and Plugin for Joomla! 1.6
 * @author http://www.ZooTemplate.com
 * @copyright(C) 2010- ZooTemplate.com
 * @license PHP files are GNU/GPL
**/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.installer.installer');

$db 	= &JFactory::getDBO();
$status = new JObject();
$status->plugins = array();
$src 	= $this->parent->getPath('source');

//Install Template
$templates = &$this->manifest->xpath('templates/template');
foreach($templates as $template)
{
	$tname = $template->getAttribute('template');
	$query = "SELECT `extension_id` FROM #__extensions WHERE `type`='template' AND element = ".$db->Quote($tname);
	
	$db->setQuery($query);
	$IDs = $db->loadResultArray();
	
	if(count($IDs)) {
		foreach($IDs as $id) {
			$installer 	= new JInstaller;
			$result 	= $installer->uninstall('template', $id);
		}
	}
}

//Install plugin
$plugins = & $this->manifest->xpath('plugins/plugin');
foreach($plugins as $plugin)
{
	$pname 	= $plugin->getAttribute('plugin');
	$pgroup = $plugin->getAttribute('group');
	$query 	= "SELECT `extension_id` FROM #__extensions WHERE `type`='plugin' AND element = ".$db->Quote($pname)." AND folder = ".$db->Quote($pgroup);
	
	$db->setQuery($query);
	$IDs = $db->loadResultArray();
	
	if(count($IDs)) {
		foreach($IDs as $id) {
			$installer 	= new JInstaller;
			$result 	= $installer->uninstall('plugin', $id);
		}
	}
	$status->plugins[] = array ('name' => $pname, 'group' => $pgroup, 'result' => $result);
}
?>