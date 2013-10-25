<?php

/**
 * @package     Prieco.Modules
 * @subpackage  mod_sobipro_categories - Categories of SobiPro
 * 
 * @author      Prieco S.A. <support@extly.com>
 * @copyright   Copyright (C) 2010 - 2012 Prieco, S.A. All rights reserved.
 * @license     http://http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL 
 * @link        http://www.prieco.com http://www.extly.com http://support.extly.com 
 */
// No direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');
jimport('joomla.error.error');

/**
 * ModSobiproCategoriesStatsHelper Helper class.
 *
 * @package     Prieco.Modules
 * @subpackage  mod_sobiextsearch
 * @since       1.0
 */
class ModSobiproCategoriesStatsHelper
{

	/**
	 * init
	 *
	 * @return  nil
	 *
	 * @since   1.0
	 */
	public function init()
	{
		$loaded = false;
		$pluginfile = JPATH_ROOT . DS . 'plugins' . DS . 'search' . DS . 'prsobiproplus' . DS . 'prsobiproplus.php';
		if (is_file($pluginfile))
		{
			require_once $pluginfile;
			$loaded = true;
		}

		$pluginfile = JPATH_ROOT . DS . 'plugins' . DS . 'search' . DS . 'prsobiproplus.php';
		if (is_file($pluginfile))
		{
			require_once $pluginfile;
			$loaded = true;
		}

		if ($loaded)
		{
			$plugin = & JPluginHelper::getPlugin('search', 'prsobiproplus');
			$className = 'plgSearch' . $plugin->name;
			if (class_exists($className))
			{
				$dispatcher = & JDispatcher::getInstance();
				$plugin = new $className($dispatcher, (array) $plugin);

				// Just to be sure
				$plugin->_checkLastRunRebuild();
			}
			return true;
		}
		else
		{
			echo 'ERROR: Stats require Search Plugin+ (Plus).';
			return false;
		}
	}

	/**
	 * calculateTotalEntries
	 * 
	 * @param   mixed  $section  the params
	 * @param   mixed  $debug    the params
	 *
	 * @return  nil
	 *
	 * @since   1.0
	 */
	public function calculateTotalEntries($section, $debug = 0)
	{
		$_db = JFactory::getDbo();
		$query = 'SELECT path FROM `#__prsobiproplus_tree` t, 
			`#__sobipro_object` AS e WHERE t.id = e.id AND 
			oType=\'entry\' AND e.state=1 AND 
			(validUntil = 0 OR validUntil > NOW()) AND section=' . $_db->quote($section);

		if ($debug)
		{
			echo "DEBUG Stats: $query<br>\n";
		}

		$_db->setQuery($query);

		$totals = array();
		$paths = $_db->loadResultArray();
		
		if ((!$paths) || (count($paths) == 0))
		{
			if ($debug)
			{
				echo 'WARN: Empty Directory or No selected section.<br/>';
				echo 'DEBUG Paths: ' . print_r($paths, true);
			}
		}
		else
		{
			foreach ($paths as $path)
			{
				if ($debug)
				{
					echo "DEBUG Entry: $path<br>\n";
				}

				$categories = explode('-', $path);
				foreach ($categories as $subcateg)
				{
					if (array_key_exists($subcateg, $totals))
					{
						$totals[$subcateg] = $totals[$subcateg] + 1;
					}
					else
					{
						$totals[$subcateg] = 1;
					}
				}
			}
		}

		// Lets try temporary table here
		$tmptablename = 'tmptotals';
		$drop = 'DROP TEMPORARY TABLE IF EXISTS ' . $tmptablename;
		$_db->setQuery($drop);
		$_db->query();
		if ($_db->getErrorNum())
		{
			echo 'Error: ' . $_db->getErrorMsg();
			return;
		}

		$query = 'CREATE TEMPORARY TABLE IF NOT EXISTS ' . $tmptablename . ' 
			(`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			`total` int(10) unsigned NOT NULL DEFAULT \'0\',PRIMARY KEY (`id`));';
		$_db->setQuery($query);
		$_db->query();
		if ($_db->getErrorNum())
		{
			echo 'Error: ' . $_db->getErrorMsg();
			return;
		}

		foreach ($totals as $key => $value)
		{
			if ($key)
			{
				$query = "INSERT INTO $tmptablename VALUES($key, $value);";
				$_db->setQuery($query);
				$_db->query();
				if ($_db->getErrorNum())
				{
					echo 'Error: ' . $_db->getErrorMsg();
					return;
				}
			}
		}

		return $totals;
	}

}
