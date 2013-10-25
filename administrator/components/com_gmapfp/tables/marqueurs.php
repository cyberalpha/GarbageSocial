<?php
/*
* GMapFP Component Google Map for Joomla! 1.6.x
* Version 9.8
* Creation date: Décembre 2011
* Author: Fabrice4821 - www.gmapfp.org
* Author email: webmaster@gmapfp.org
* License GNU/GPL
*/

defined('_JEXEC') or die('Restricted access');

class gmapfpTableMarqueurs extends JTable
{

	function __construct( &$db ) {
		parent::__construct('#__gmapfp_marqueurs', 'id', $db);
	}
}
?>