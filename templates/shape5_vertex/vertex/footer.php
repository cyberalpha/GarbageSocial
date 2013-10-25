<?php
/**
* @version $Id: footer.php 85 2005-09-15 23:12:03Z eddieajau $
* @package Joomla
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted index access' );

global $mainframe;

jimport('joomla.utilities.date');
$app = JFactory::getApplication();

$date = new JDate();
$cur_year	= $date->toFormat('%Y');
$csite_name	= $app->getCfg('sitename');

// NOTE - You may change this file to suit your site needs
?>
<span class="footerc">
<p style="text-align: center;"><a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/3.0/deed.es_AR"><img alt="Licencia Creative Commons" style="border-width: 0;" src="http://i.creativecommons.org/l/by-nc-nd/3.0/80x15.png" /></a></><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">   Social Garbage</span> por <a xmlns:cc="http://creativecommons.org/ns#" href="http://www.socialgarbage.com.ar" property="cc:attributionName" rel="cc:attributionURL">Norberto Márquez</a> se encuentra bajo una <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/3.0/deed.es_AR">Licencia Creative Commons Atribución-NoComercial-SinDerivadas 3.0 Unported</a>.</p>

</span>
