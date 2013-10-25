<?php

/**
 * @package     Prieco.Modules
 * @subpackage  mod_sobipsearch - Search in Selected Section
 * 
 * @author      Prieco S.A. <support@extly.com>
 * @copyright   Copyright (C) 2010 - 2012 Prieco, S.A. All rights reserved.
 * @license     http://http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL 
 * @link        http://www.prieco.com http://www.extly.com http://support.extly.com 
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * ModSobipSearchHelper Helper class.
 *
 * @package     Prieco.Modules
 * @subpackage  mod_sobipsearch
 * @since       1.0
 */
class ModSobipSearchHelper
{

	/**
	 * getSearchSectionSelect
	 *
	 * @param   mixed  $moduleclass_sfx  the params
	 * @param   mixed  $listofsections   the params
	 * @param   mixed  &$html            the params
	 * 
	 * @return  a result
	 *
	 * @since   1.0
	 */
	public function getSearchSectionSelect($moduleclass_sfx = null, $listofsections = null, &$html = null)
	{
		// Multimode
		$isMultimode = self::getMultimode();
		$lang = JFactory::getLanguage();
		$current_lang = $lang->getTag();

		$db = & JFactory::getDBO();

		if ($listofsections)
		{
			$sections = " AND s.id IN ($listofsections)";
		}
		else
		{
			$sections = null;
		}

		if ($isMultimode)
		{
			$query = "SELECT s." . $db->nameQuote('id') . ", IF(l.sValue IS NULL, s.name, l.sValue) AS name " .
				' FROM ' . $db->nameQuote('#__sobipro_object') . ' AS s ' .
				' LEFT OUTER JOIN #__sobipro_language l ON l.sKey = ' . $db->Quote('name') . ' AND l.id = s.id AND l.language = ' . $db->Quote($current_lang) .
				" WHERE s.parent=0 AND s.state=1 {$sections} ORDER BY s.id;";
		}
		else
		{
			$query = "SELECT s." . $db->nameQuote('id') . ", s." . $db->nameQuote('name') . "
				FROM " . $db->nameQuote('#__sobipro_object') . " AS s
				WHERE s.parent=0 AND s.state=1 {$sections} ORDER BY s.id;";
		}
		$db->setQuery($query);
		$results = $db->loadObjectList();

		$counter = count($results);
		if ($counter == 1)
		{
			$id = $results[0]->id;
			$output = '<div class="SPSearchSections' . $moduleclass_sfx . '">
				<input name="sid" 
					id="SP_sid" 
					type="hidden" 
					class="SPSearchSelect' . $moduleclass_sfx . '" value="' . $id . '"></div>';
		}
		else
		{
			$output = '<div class="SPSearchSections' . $moduleclass_sfx . '"><select name="sid" id="SP_sid" class="SPSearchSelect' . $moduleclass_sfx . '">';
			foreach ($results as $result)
			{
				$output = $output . '<option value="' . $result->id . '">' . htmlentities($result->name) . '</option>';
			}
			$output = $output . '</select></div>';
		}

		$html = $output;
		return $counter;
	}

	/**
	 * _cleanListOfNumerics
	 *
	 * @param   mixed  $listOfNumerics  the params
	 * 
	 * @return  a result
	 *
	 * @since   1.0
	 */
	public function _cleanListOfNumerics($listOfNumerics)
	{
		return preg_replace('/[^,0-9]/', '', $listOfNumerics);
	}

	/**
	 * getMultimode
	 * 
	 * @param   mixed  $debug  the params
	 *
	 * @return  the value
	 *
	 * @since   1.0
	 */
	public function getMultimode($debug = 0)
	{
		$db = & JFactory::getDBO();

		$query = 'SELECT ' . $db->nameQuote('sValue') . ' FROM ' . $db->nameQuote('#__sobipro_config')
				. ' WHERE ' . $db->nameQuote('cSection') . ' = ' . $db->Quote('lang') .
					' AND ' . $db->nameQuote('sKey') . ' = ' . $db->Quote('multimode') .
					' AND ' . $db->nameQuote('section') . '=0';
		$db->setQuery($query);

		if ($debug)
		{
			echo 'multimode: ' . $query . '</br>';
		}

		$multimode = $db->loadResult();

		return $multimode;
	}

}
