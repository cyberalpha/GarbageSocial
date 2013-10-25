<?php
	/*
	* GMapFP Plugin Google Map for Joomla! 1.6.x
	* Version 4.0.6
	* Creation date: Septembre 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*
	* Version php >= 5.1.0
	*/

defined('_JEXEC') or die('Restricted access');

if (!defined('COM_GMAPFP_IMAGES_HTTP_RELATIVE')) define('COM_GMAPFP_IMAGES_HTTP_RELATIVE', '/images/gmapfp');
if (!defined('COM_GMAPFP_IMAGES_HTTP')) define('COM_GMAPFP_IMAGES_HTTP',    JURI::root().COM_GMAPFP_IMAGES_HTTP_RELATIVE);
if (!defined('COM_GMAPFP_IMAGES_FOLDER')) define('COM_GMAPFP_IMAGES_FOLDER',  JPath::clean(JPATH_ROOT.COM_GMAPFP_IMAGES_HTTP_RELATIVE));
if (!defined('COM_GMAPFP_PRO')) define('COM_GMAPFP_PRO',    1);
?>