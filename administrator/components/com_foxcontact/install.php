<?php defined('_JEXEC') or die('Restricted access');
/*
This file is part of "Fox Joomla Extensions".

You can redistribute it and/or modify it under the terms of the GNU General Public License
GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html

Author: Demis Palma
Documentation at http://www.fox.ra.it/forum/2-documentation.html
*/

require_once(realpath(dirname(__FILE__) . DS . 'foxinstall.php'));

class com_foxcontactInstallerScript extends FoxInstaller
{
	function update($parent)
	{
		@unlink(JPATH_ROOT . DS . 'components' . DS . $parent->get('element') . DS . 'helpers' . DS . 'debug-on.php');
		@unlink(JPATH_ROOT . DS . 'components' . DS . $parent->get('element') . DS . 'helpers' . DS . 'debug-off.php');
		@unlink(JPATH_ROOT . DS . 'components' . DS . $parent->get('element') . DS . 'helpers' . DS . 'fcaptcha-drawer.php');
		@unlink(JPATH_ROOT . DS . 'components' . DS . $parent->get('element') . DS . 'helpers' . DS . 'functions.php');
		@unlink(JPATH_ROOT . DS . 'components' . DS . $parent->get('element') . DS . 'helpers' . DS . 'qqfileuploader.php');
		@unlink(JPATH_ROOT . DS . 'components' . DS . $parent->get('element') . DS . 'helpers' . DS . 'vfdebugger.php');
		@unlink(JPATH_ROOT . DS . 'components' . DS . $parent->get('element') . DS . 'helpers' . DS . 'fmailer.php');

		@unlink(JPATH_ADMINISTRATOR . DS . 'components' . DS . $parent->get('element') . DS . 'models' . DS . 'fields' . DS . 'vfheader.php');
		@unlink(JPATH_ADMINISTRATOR . DS . 'components' . DS . $parent->get('element') . DS . 'models' . DS . 'fields' . DS . 'vftext.php');
		@unlink(JPATH_ADMINISTRATOR . DS . 'components' . DS . $parent->get('element') . DS . 'models' . DS . 'fields' . DS . 'vftextarea.php');
		@unlink(JPATH_ADMINISTRATOR . DS . 'components' . DS . $parent->get('element') . DS . 'foxcontact.inc');
		parent::install($parent);
	}
}
