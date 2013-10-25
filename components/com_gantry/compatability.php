<?php
/**
 * @version   $Id: compatability.php 4060 2012-10-02 18:03:24Z btowles $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2012 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
defined('_JEXEC') or die('Restricted access');

if (!class_exists('GantryLegacyJView', false)) {
	if (version_compare(new JVersion()->getShortVersion(), '2.5.5','>'))
	{
		class GantryLegacyJView extends JViewLegacy
		{
		}

		class GantryLegacyJController extends JControllerLegacy
		{
		}

		class GantryLegacyJModel extends JModelLegacy
		{
		}
	}
	else {
		jimport('joomla.application.component.view');
		jimport('joomla.application.component.controller');
		jimport('joomla.application.component.model');
		class GantryLegacyJView extends JView
		{
		}

		class GantryLegacyJController extends JController
		{
		}

		class GantryLegacyJModel extends JModel
		{
		}
	}
}