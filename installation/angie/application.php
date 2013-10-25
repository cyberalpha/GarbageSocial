<?php
/**
 * @package angi4j
 * @copyright Copyright (C) 2009-2013 Nicholas K. Dionysopoulos. All rights reserved.
 * @author Nicholas K. Dionysopoulos - http://www.dionysopoulos.me
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL v3 or later
 *
 * Akeeba Next Generation Installer For Joomla!
 */

defined('_AKEEBA') or die();

class AngieApplication extends AApplication
{
	public function initialise()
	{
		// Load the version file
		require_once APATH_INSTALLATION . '/version.php';
	}
}