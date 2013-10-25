<?php
/*
 * @package		Joomla.Framework
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */
jimport('joomla.application.component.controller');

$l['cp']	= 'COM_PHOCAMAPS_CONTROL_PANEL';
$l['mp']	= 'COM_PHOCAMAPS_MAPS';
$l['mr']	= 'COM_PHOCAMAPS_MARKERS';
$l['mi']	= 'COM_PHOCAMAPS_ICONS';
$l['in']	= 'COM_PHOCAMAPS_INFO';

// Submenu view
$view	= JRequest::getVar( 'view', '', '', 'string', JREQUEST_ALLOWRAW );

if ($view == '' || $view == 'phocamapscp') {
	JSubMenuHelper::addEntry(JText::_($l['cp']), 'index.php?option=com_phocamaps');
	JSubMenuHelper::addEntry(JText::_($l['mp']), 'index.php?option=com_phocamaps&view=phocamapsmaps');
	JSubMenuHelper::addEntry(JText::_($l['mr']), 'index.php?option=com_phocamaps&view=phocamapsmarkers' );
	JSubMenuHelper::addEntry(JText::_($l['mi']), 'index.php?option=com_phocamaps&view=phocamapsicons' );
	JSubMenuHelper::addEntry(JText::_($l['in']), 'index.php?option=com_phocamaps&view=phocamapsinfo' );
}

if ($view == 'phocamapsmaps') {
	JSubMenuHelper::addEntry(JText::_($l['cp']), 'index.php?option=com_phocamaps');
	JSubMenuHelper::addEntry(JText::_($l['mp']), 'index.php?option=com_phocamaps&view=phocamapsmaps', true);
	JSubMenuHelper::addEntry(JText::_($l['mr']), 'index.php?option=com_phocamaps&view=phocamapsmarkers' );
	JSubMenuHelper::addEntry(JText::_($l['mi']), 'index.php?option=com_phocamaps&view=phocamapsicons' );
	JSubMenuHelper::addEntry(JText::_($l['in']), 'index.php?option=com_phocamaps&view=phocamapsinfo' );
}

if ($view == 'phocamapsmarkers') {
	JSubMenuHelper::addEntry(JText::_($l['cp']), 'index.php?option=com_phocamaps');
	JSubMenuHelper::addEntry(JText::_($l['mp']), 'index.php?option=com_phocamaps&view=phocamapsmaps');
	JSubMenuHelper::addEntry(JText::_($l['mr']), 'index.php?option=com_phocamaps&view=phocamapsmarkers', true );
	JSubMenuHelper::addEntry(JText::_($l['mi']), 'index.php?option=com_phocamaps&view=phocamapsicons' );
	JSubMenuHelper::addEntry(JText::_($l['in']), 'index.php?option=com_phocamaps&view=phocamapsinfo' );
}

if ($view == 'phocamapsicons') {
	JSubMenuHelper::addEntry(JText::_($l['cp']), 'index.php?option=com_phocamaps');
	JSubMenuHelper::addEntry(JText::_($l['mp']), 'index.php?option=com_phocamaps&view=phocamapsmaps');
	JSubMenuHelper::addEntry(JText::_($l['mr']), 'index.php?option=com_phocamaps&view=phocamapsmarkers' );
	JSubMenuHelper::addEntry(JText::_($l['mi']), 'index.php?option=com_phocamaps&view=phocamapsicons', true);
	JSubMenuHelper::addEntry(JText::_($l['in']), 'index.php?option=com_phocamaps&view=phocamapsinfo' );
}


if ($view == 'phocamapsinfo') {
	JSubMenuHelper::addEntry(JText::_($l['cp']), 'index.php?option=com_phocamaps');
	JSubMenuHelper::addEntry(JText::_($l['mp']), 'index.php?option=com_phocamaps&view=phocamapsmaps');
	JSubMenuHelper::addEntry(JText::_($l['mr']), 'index.php?option=com_phocamaps&view=phocamapsmarkers' );
	JSubMenuHelper::addEntry(JText::_($l['mi']), 'index.php?option=com_phocamaps&view=phocamapsicons' );
	JSubMenuHelper::addEntry(JText::_($l['in']), 'index.php?option=com_phocamaps&view=phocamapsinfo', true );
}


class phocaMapsCpController extends JController
{
	function display() {
		parent::display();
	}
}
?>
