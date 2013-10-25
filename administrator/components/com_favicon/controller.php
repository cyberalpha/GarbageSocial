<?php
/**
 * @version		$Id: controller.php 16398 2010-04-24 00:28:26Z eddieajau $
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'favicon.php');

/**
 * Favicon master display controller.
 *
 * @package		Favicon
 * @subpackage	com_favicon
 * @since		1.6
 */
class FaviconController extends JController
{
	/**
	 * Method to display a view.
	 */
	public function display()
	{
		if(!JRequest::getVar('view')) JRequest::setVar('view','favicons');
		parent::display();

		// Load the submenu.
		FaviconHelper::addSubmenu(JRequest::getWord('view','favicons'));
	}
}
