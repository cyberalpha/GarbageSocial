<?php
/*
This file is part of "Fox Joomla Extensions".

You can redistribute it and/or modify it under the terms of the GNU General Public License
GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html

Author: Demis Palma
Documentation at http://www.fox.ra.it/forum/2-documentation.html
*/

define('_JEXEC', 1 );
define('DS', DIRECTORY_SEPARATOR);
define('JPATH_BASE', realpath(dirname(__FILE__) . DS . '..' . DS . '..' . DS . '..'));
require_once(JPATH_BASE . DS . 'includes' . DS . 'defines.php');
require_once(JPATH_BASE . DS . 'includes' . DS . 'framework.php');

// @ avoids Warning: ini_set() has been disabled for security reasons in /var/www/libraries/joomla/[...]
/*$mainframe =&*/ @JFactory::getApplication('site');  // Needed to get the correct session with JFactory::getSession() below
$jsession = JFactory::getSession();
$jsession->set("debug", 0);

?>
<html><body>Debug disabled</body></html>
