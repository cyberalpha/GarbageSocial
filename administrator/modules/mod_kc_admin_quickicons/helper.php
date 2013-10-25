<?php
/**
 * @version		$Id: helper.php 16990 2010-05-12 13:31:53Z infograf768 $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @copyright	Copyright (C) 2010 - 2011 Keashly.ca Consulting
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

/**
 * @package		Joomla.Administrator
 * @subpackage	mod_kc_admin_quickicons
 */
abstract class KC_Admin_QuickIconHelper
{
	/**
	 * Stack to hold default buttons
	 */
	protected static $buttons = array();

	/**
	 * Helper method to generate a button in administrator panel
	 *
	 * @param	array	A named array with keys link, image, text, access and path
	 * @return	string	HTML for button
	 */
	public static function button($button)
	{
		if (!empty($button['access'])) {
			if (is_bool($button['access']) && $button['access'] == false) {
				return '';
			}
			if (!JFactory::getUser()->authorize($button['access'][0], $button['access'][1])) {
				return '';
			}
		}

		ob_start();
		require JModuleHelper::getLayoutPath('mod_kc_admin_quickicons', 'default_button');
		$html = ob_get_clean();
		return $html;
	}

	/**
	 * Helper method to return button list.
	 *
	 * This method returns the array by reference so it can be
	 * used to add custom buttons or remove default ones.
	 *
	 * @return	array	An array of buttons
	 */
	public static function &getButtons( $params )
	{
			$app = JFactory::getApplication();
			self::$buttons = array();

			// Only load the CSS if we are in the backend
			if ($app->isAdmin()) {
	
				// Get the Joomla root folder
				$root = JURI::root( true );
				$root = str_replace($root, DS, '');

				$document = & JFactory::getDocument();
				$css = $root . DS . 'administrator' . DS . 'modules' . DS . 'mod_kc_admin_quickicons' . DS . 'css' . DS . 'kc_admin_quickicons.css';
				$document->addStyleSheet($css, 'text/css', 'screen');

				// Set the number of modules
				$num_icons = 10;

				// get module's parameters

				for ( $i=1; $i <= $num_icons; $i++ ) {
					$param[$i]['label'] = $params->get("label$i", '');
					$param[$i]['link'] = $params->get("link$i", '');
					$param[$i]['icon'] = $params->get("icon$i", '');
					$param[$i]['custom'] = $params->get("custom$i", '0');
					$param[$i]['path'] = $params->get("path$i", '');
					$param[$i]['c_icon'] = $params->get("c_icon$i", '');
					// echo 'i= '.$i.' custom= '.$param[$i]['custom'].' path= '.$param[$i]['path'].' icon= '.$param[$i]['c_icon'].'<br />';
				}
						
				jimport ('joomla.filesystem.file'); // Import the file system routines

				$out_index = 0; // Set the output array index
				$template = JFactory::getApplication()->getTemplate();
															
				for ( $i=1; $i <= $num_icons; $i++ ) {
						// Check if this icon/link is being used
						if ($param[$i]['link'] != "" && $param[$i]['link'] != 'index.php?option=') {
							// See if there is a custom icon for this link
							if ($param[$i]['custom'] == "1") {
								// Make sure there is no trailing / on the path
								if ($param[$i]['path'] == DS) {
									$param[$i]['path'] = '';
								} else {
									// there is a path defined, so see if there is a trailing /
									if ( substr($param[$i]['path'], -1) == DS) {
										$param[$i]['path'] = substr($param[$i]['path'], 0, -1);
									}
								}
								// Yes, check if the custom icon file exists
								$file = JPATH_ADMINISTRATOR . DS . 'images' . DS . $param[$i]['path'] . DS . $param[$i]['c_icon'];
								if (!JFile::exists ($file)) {
									JError::raiseWarning ( 500, JText::_('KC_FILE_MISSING_ERROR') . $file );
									self::$buttons[$out_index]['image'] = 'icon-48-generic.png';
									self::$buttons[$out_index]['path'] = $root . 'administrator' . DS . 'templates' . DS . $template . DS . 'images' . DS . 'header' . DS;
								} else {
									if ($param[$i]['path'] == '') {
										self::$buttons[$out_index]['path'] = $root . 'administrator' . DS . 'images' . DS;
									} else {
										self::$buttons[$out_index]['path'] = $root . 'administrator' . DS . 'images' . DS . $param[$i]['path'] . DS;
									}
									self::$buttons[$out_index]['image'] = $param[$i]['c_icon'];
								}
							} else {
								// Not a custom icon, so use the icon the user choose
								self::$buttons[$out_index]['image'] = $param[$i]['icon'];
								// Default the path to the bluestork template icon path
								self::$buttons[$out_index]['path'] = $root . 'administrator' . DS . 'templates' . DS . $template . DS . 'images' . DS . 'header' . DS;
							}
							self::$buttons[$out_index]['text'] =  $param[$i]['label'];
							self::$buttons[$out_index]['link'] =  $param[$i]['link'];

							// We need to find the com_ part of the link string to put in the access array
							$startpos = stripos ($param[$i]['link'], 'option=com_');
							if ($startpos !== false ) {
								// found the string so continue to find the end of the component string
								$component = substr ($param[$i]['link'], $startpos + 7);
								// Need to check if there is something after the component name, so look for &
								$endpos = stripos ($component, '&');
								if ($endpos !== false) {
									// we found the &, so need to chop the component string down
									$component = substr ($component, 0, $endpos);
								}
								self::$buttons[$out_index]['access'][0] =  'core.manage';
								self::$buttons[$out_index]['access'][1] = $component;
							}

							$out_index++;
					}
				}

			}

		return self::$buttons;
	}
}