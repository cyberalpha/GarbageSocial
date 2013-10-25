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
	$path  = $src.DS."templates".DS.$tname;
	
	$installer  = new JInstaller;
	$result 	= $installer->install($path);
}

//Install plugin
$plugins = &$this->manifest->xpath('plugins/plugin');
foreach($plugins as $plugin)
{
	$pname 	= $plugin->getAttribute('plugin');
	$pgroup = $plugin->getAttribute('group');
	$path 	= $src.DS.'plugins'.DS.$pgroup;
	
	$installer 	= new JInstaller;
	$result 	= $installer->install($path);
	
	$status->plugins[] = array('name' => $pname, 'group' => $pgroup, 'result' => $result);

	$query = "UPDATE #__extensions SET enabled=1 WHERE type='plugin' AND element=".$db->Quote($pname)." AND folder=".$db->Quote($pgroup);
	$db->setQuery($query);
	$db->query();
}
?>