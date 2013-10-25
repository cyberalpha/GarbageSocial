<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.0.beat1
	* Creation date: Mai 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class GMapFPsModelAccueil extends JModel
{

	/**
	 * Gère la list des onglets publiés
	 */
	function getPublishedTabs() {
	
		$config =& JComponentHelper::getParams('com_gmapfp');

		$tabs = array();

		$onglet = new stdClass();
		$onglet->title = 'Donation';
		$onglet->name = 'Donation';
		$onglet->alert = false;
		$tabs[] = $onglet;

		if ($config->get('gmapfp_news')) {
			$onglet = new stdClass();
			$onglet->title = 'News';
			$onglet->name = 'News';
			$onglet->alert = false;
			$tabs[] = $onglet;
		}

		return $tabs;
	}




}
?>