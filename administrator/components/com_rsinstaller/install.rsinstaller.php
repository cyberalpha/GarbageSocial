<?php
/**
* @version 1.3.0
* @package RSform!Pro 1.3.0
* @copyright (C) 2007-2010 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

// Get a new installer
$plg_installer = new JInstaller();

$plg_installer->install($this->parent->getPath('source').DS.'rsfpmailchimp');
$db->setQuery("UPDATE #__plugins SET published=1 WHERE `element`='rsfpmailchimp' AND `folder`='system'");
$db->query();

$path = array(
	'type' => 'folder',
	'src' => $this->parent->getPath('source').DS.'admin',
	'dest' => JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rsform'
);

$plg_installer->copyFiles(array($path));

require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rsform'.DS.'helpers'.DS.'rsform.php');

if (RSFormProHelper::isJ16())
	$this->parent->parseSQLFiles($this->manifest->install->sql);