<?php
/*
 * @package		Joomla.Framework
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */
defined('_JEXEC') or die();
class PhocaMapsCpControllerPhocaMapsInstall extends PhocaMapsCpController
{
	function __construct() {
		parent::__construct();
		$this->registerTask( 'install'  , 'install' );
		$this->registerTask( 'upgrade'  , 'upgrade' );		
	}

	
	
	function install() {		
		$db			= &JFactory::getDBO();
		//$dbPref 	= $db->getPrefix();
		$msgSQL 	= '';
		$msgFile	= '';
		$msgError	= '';
		
		// ------------------------------------------
		// Phoca Maps - Maps
		// ------------------------------------------
		
		$query =' DROP TABLE IF EXISTS `#__phocamaps_map`;';
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		$query ='CREATE TABLE IF NOT EXISTS `#__phocamaps_map` ('."\n";
		$query.=' `id` int(11) NOT NULL auto_increment,'."\n";
		$query.=' `title` varchar(255) NOT NULL default \'\','."\n";
		$query.=' `alias` varchar(255) NOT NULL default \'\','."\n";
		$query.=' `width` int(5) NOT NULL default \'0\','."\n";
		$query.=' `height` int(5) NOT NULL default \'0\','."\n";
		$query.=' `latitude` varchar(20) NOT NULL default \'\','."\n";
		$query.=' `longitude` varchar(20) NOT NULL default \'\','."\n";
		$query.=' `zoom` int(3) NOT NULL default \'0\','."\n";
		$query.=' `lang` varchar(6) NOT NULL default \'\','."\n";
		$query.=' `border` tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' `continuouszoom` tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' `doubleclickzoom` tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' `scrollwheelzoom` tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' `zoomcontrol` tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' `scalecontrol` tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' `typeid` tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' `typecontrol` tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' `typecontrolposition` tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' `collapsibleoverview` tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' `dynamiclabel` tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' `googlebar` tinyint(1) NOT NULL default \'0\',';
		$query.=' `displayroute` tinyint(1) NOT NULL default \'0\',';
		$query.=' `kmlfile` varchar(255) NOT NULL default \'\','."\n";
		$query.=' `description` text NOT NULL,'."\n";
		$query.=' `published` tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' `checked_out` int(11) unsigned NOT NULL default \'0\','."\n";
		$query.=' `checked_out_time` datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' `ordering` int(11) NOT NULL default \'0\','."\n";
		$query.=' `access` tinyint(3) unsigned NOT NULL default \'0\','."\n";
		$query.=' `hits` int(11) NOT NULL default \'0\','."\n";
		$query.=' `params` text NOT NULL,'."\n";
		$query.=' `language` char(7) NOT NULL default \'\','."\n";
		$query.=' PRIMARY KEY  (`id`),'."\n";
		$query.=' KEY `cat_idx` (`published`,`access`),'."\n";
		$query.=' KEY `idx_access` (`access`),'."\n";
		$query.=' KEY `idx_checkout` (`checked_out`)'."\n";
		$query.=') CHARACTER SET `utf8`;';
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		
		// ------------------------------------------
		// Phoca Maps - Markers
		// ------------------------------------------
		
		$query=' DROP TABLE IF EXISTS `#__phocamaps_marker`;'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		$query ='CREATE TABLE IF NOT EXISTS `#__phocamaps_marker` ('."\n";
		$query.=' `id` int(11) unsigned NOT NULL auto_increment,'."\n";
		$query.=' `catid` int(11) NOT NULL default \'0\','."\n";
		$query.=' `title` varchar(250) NOT NULL default \'\','."\n";
		$query.=' `alias` varchar(255) NOT NULL default \'\','."\n";
		$query.=' `latitude` varchar(20) NOT NULL default \'\','."\n";
		$query.=' `longitude` varchar(20) NOT NULL default \'\','."\n";
		$query.=' `gpslatitude` varchar(50) NOT NULL default \'\','."\n";
		$query.=' `gpslongitude` varchar(50) NOT NULL default \'\','."\n";
		$query.=' `displaygps` tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' `icon` tinyint(1) NOT NULL default \'0\',';
		$query.=' `iconext` int(11) NOT NULL default \'0\',';
		$query.=' `description` text NOT NULL,'."\n";
		$query.=' `contentwidth` varchar(8) NOT NULL default \'\','."\n";
		$query.=' `contentheight` varchar(8) NOT NULL default \'\','."\n";
		$query.=' `markerwindow` tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' `published` tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' `checked_out` int(11) unsigned NOT NULL default \'0\','."\n";
		$query.=' `checked_out_time` datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' `ordering` int(11) NOT NULL default \'0\','."\n";
		$query.=' `access` tinyint(3) unsigned NOT NULL default \'0\','."\n";
		$query.=' `hits` int(11) NOT NULL default \'0\','."\n";
		$query.=' `params` text NOT NULL,'."\n";
		$query.=' `language` char(7) NOT NULL default \'\','."\n";
		$query.=' PRIMARY KEY  (`id`),'."\n";
		$query.=' KEY `catid` (`catid`,`published`)'."\n";
		$query.=') CHARACTER SET `utf8`;';
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		
		// ------------------------------------------
		// Phoca Maps - ICONS
		// ------------------------------------------
		
		$query=' DROP TABLE IF EXISTS `#__phocamaps_icon`;'."\n";
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		$query ='CREATE TABLE IF NOT EXISTS `#__phocamaps_icon` ('."\n";
		$query.=' `id` int(11) unsigned NOT NULL auto_increment,'."\n";
		$query.=' `title` varchar(250) NOT NULL default \'\','."\n";
		$query.=' `alias` varchar(255) NOT NULL default \'\','."\n";
		$query.=' `url` text NOT NULL,'."\n";
		$query.=' `urls` text NOT NULL,'."\n";
		$query.=' `object` varchar(255) NOT NULL default \'\','."\n";
		$query.=' `objects` varchar(255) NOT NULL default \'\','."\n";
		$query.=' `objectshape` varchar(255) NOT NULL default \'\','."\n";
		$query.=' `published` tinyint(1) NOT NULL default \'0\','."\n";
		$query.=' `checked_out` int(11) unsigned NOT NULL default \'0\','."\n";
		$query.=' `checked_out_time` datetime NOT NULL default \'0000-00-00 00:00:00\','."\n";
		$query.=' `ordering` int(11) NOT NULL default \'0\','."\n";
		$query.=' `access` tinyint(3) unsigned NOT NULL default \'0\','."\n";
		$query.=' `hits` int(11) NOT NULL default \'0\','."\n";
		$query.=' `params` text NOT NULL,'."\n";
		$query.=' `language` char(7) NOT NULL default \'\','."\n";
		$query.=' PRIMARY KEY  (`id`)'."\n";
		$query.=') CHARACTER SET `utf8`;';
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}
		
		$query = 'INSERT INTO `#__phocamaps_icon` (`id`, `title`, `alias`, `url`, `urls`, `object`, `objects`, `objectshape`, `published`, `checked_out`, `checked_out_time`, `ordering`, `access`, `hits`, `params`, `language`) VALUES
(1, \'Tree\', \'tree\', \'http://maps.google.com/mapfiles/ms/icons/tree.png\', \'http://maps.google.com/mapfiles/ms/icons/tree.shadow.png\', \'\', \'59,32;0,0;16,34\', \'rect;0,0,25,30\', 1, 0, \'0000-00-00 00:00:00\', 1, 1, 0, \'\', \'\'),
(2, \'Pushpin\', \'pushpin\', \'http://maps.google.com/mapfiles/ms/icons/red-pushpin.png\', \'\', \'\', \'\', \'rect;0,0,25,30\', 1, 0, \'0000-00-00 00:00:00\', 2, 1, 0, \'\', \'\'),
(3, \'Blue Dot\', \'blue-dot\', \'http://maps.google.com/mapfiles/ms/icons/blue-dot.png\', \'\', \'\', \'\', \'rect;0,0,25,30\', 1, 0, \'0000-00-00 00:00:00\', 3, 1, 0, \'\', \'\'),
(4, \'Flag\', \'flag\', \'http://maps.google.com/mapfiles/ms/icons/flag.png\', \'http://maps.google.com/mapfiles/ms/icons/flag.shadow.png\', \'\', \'59,32;0,0;16,34\', \'rect;0,0,25,30\', 1, 0, \'0000-00-00 00:00:00\', 3, 1, 0, \'\', \'\'),
(5, \'Info\', \'info\', \'http://maps.google.com/mapfiles/ms/icons/info.png\', \'http://maps.google.com/mapfiles/ms/icons/info.shadow.png\', \'\', \'59,32;0,0;16,34\', \'rect;0,0,25,30\', 1, 0, \'0000-00-00 00:00:00\', 5, 1, 0, \'\', \'\'),
(6, \'Snack Bar\', \'snack-bar\', \'http://maps.google.com/mapfiles/ms/icons/snack_bar.png\', \'http://maps.google.com/mapfiles/ms/icons/snack_bar.shadow.png\', \'\', \'59,32;0,0;16,34\', \'rect;0,0,32,30\', 1, 0, \'0000-00-00 00:00:00\', 6, 1, 0, \'\', \'\');';
		
		$db->setQuery( $query );
		if (!$result = $db->query()){$msgSQL .= $db->stderr() . '<br />';}

		// Error
		if ($msgSQL !='') {
			$msgError .= '<br />' . $msgSQL;
		}
		/*
		if ($msgFile !='') {
			$msgError .= '<br />' . $msgFile;
		}
		*/	
		// End Message
		if ($msgError !='') {
			$msg = JText::_( 'Phoca Maps not successfully installed' ) . ': ' . $msgError;
		} else {
			$msg = JText::_( 'Phoca Maps successfully installed' );
		}
		
		$link = 'index.php?option=com_phocamaps';
		$this->setRedirect($link, $msg);
	}
	
	
	function upgrade() {
		
		$db			=& JFactory::getDBO();
		$dbPref 	= $db->getPrefix();
		$msgSQL 	= '';
		$msgFile	= '';
		$msgError	= '';
		
		// CHECK TABLES
		
		$query =' SELECT * FROM `#__phocamaps_map` LIMIT 1;';
		$db->setQuery( $query );
		$result = $db->loadResult();
		if ($db->getErrorNum()) {
			$msgSQL .= $db->getErrorMsg(). '<br />';
		}
		
		
		$query=' SELECT * FROM `#__phocamaps_marker` LIMIT 1;'."\n";
		
		$db->setQuery( $query );
		$result = $db->loadResult();
		if ($db->getErrorNum()) {
			$msgSQL .= $db->getErrorMsg(). '<br />';
		}
		
		//Version 1.0.1
		// UPDATE displayroute
		$updateDR 	= false;
		$updateDR	= $this->AddColumnIfNotExists("#__phocamaps_map", "displayroute", "tinyint(1) NOT NULL default '0'", "googlebar" );
		if (!$updateDR) {
			$msgSQL .= 'Error while updating Display Route column<br />';
		}
		
		// Version 1.1.0
		$updateTCP 	= false;
		$updateTCP	= $this->AddColumnIfNotExists("#__phocamaps_map", "typecontrolposition", "tinyint(1) NOT NULL default '0'", "typecontrol" );
		if (!$updateTCP) {
			$msgSQL .= 'Error while updating Type Control Position column<br />';
		}
		$updateTID 	= false;
		$updateTID	= $this->AddColumnIfNotExists("#__phocamaps_map", "typeid", "tinyint(1) NOT NULL default '0'", "typecontrol" );
		if (!$updateTID) {
			$msgSQL .= 'Error while updating Type ID column<br />';
		}
		
		$updateKML 	= false;
		$updateKML	= $this->AddColumnIfNotExists("#__phocamaps_map", "kmlfile", "varchar(255) NOT NULL default ''", "displayroute" );
		if (!$updateKML) {
			$msgSQL .= 'Error while updating KML File column<br />';
		}
		
		$updateCW 	= false;
		$updateCW	= $this->AddColumnIfNotExists("#__phocamaps_marker", "contentwidth", "varchar(8) NOT NULL default ''", "description" );
		if (!$updateCW) {
			$msgSQL .= 'Error while updating Marker Content Width column<br />';
		}
		$updateCH 	= false;
		$updateCH	= $this->AddColumnIfNotExists("#__phocamaps_marker", "contentheight", "varchar(8) NOT NULL default ''", "description" );
		if (!$updateCH) {
			$msgSQL .= 'Error while updating Marker Content Height column<br />';
		}
		
		$updateMW 	= false;
		$updateMW	= $this->AddColumnIfNotExists("#__phocamaps_marker", "markerwindow", "tinyint(1) NOT NULL default '0'", "description" );
		if (!$updateMW) {
			$msgSQL .= 'Error while updating Open Marker Window column<br />';
		}

		// Error
		if ($msgSQL !='') {
			$msgError .= '<br />' . $msgSQL;
		}
		/*
		if ($msgFile !='') {
			$msgError .= '<br />' . $msgFile;
		}
		*/	
		// End Message
		if ($msgError !='') {
			$msg = JText::_( 'Phoca Maps not successfully upgraded' ) . ': ' . $msgError;
		} else {
			$msg = JText::_( 'Phoca Maps successfully upgraded' );
		}
		
		$link = 'index.php?option=com_phocamaps';
		$this->setRedirect($link, $msg);
	}
	
	
	function AddColumnIfNotExists($table, $column, $attributes = "INT( 11 ) NOT NULL DEFAULT '0'", $after = '' ) {
		
		global $mainframe;
		$db				=& JFactory::getDBO();
		$columnExists 	= false;

		$query = 'SHOW COLUMNS FROM '.$table;
		$db->setQuery( $query );
		if (!$result = $db->query()){return false;}
		$columnData = $db->loadObjectList();
		
		
		foreach ($columnData as $valueColumn) {
			if ($valueColumn->Field == $column) {
				$columnExists = true;
				break;
			}
		}
		
		if (!$columnExists) {
			if ($after != '') {
				$query = "ALTER TABLE `".$table."` ADD `".$column."` ".$attributes." AFTER `".$after."`";
			} else {
				$query = "ALTER TABLE `".$table."` ADD `".$column."` ".$attributes."";
			}
			$db->setQuery( $query );
			if (!$result = $db->query()){return false;}
		}
		
		return true;
	}
}
// utf-8 test: ä,ö,ü,ř,ž
?>