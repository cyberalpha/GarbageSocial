<?php defined('JPATH_PLATFORM') or die();
/*
This file is part of "Content Map Joomla Extension".
Author: Open Source solutions http://www.opensourcesolutions.es

You can redistribute and/or modify it under the terms of the GNU
General Public License as published by the Free Software Foundation,
either version 2 of the License, or (at your option) any later version.

GNU/GPL license gives you the freedom:
* to use this software for both commercial and non-commercial purposes
* to share, copy, distribute and install this software and charge for it if you wish.

Under the following conditions:
* You must attribute the work to the original author

This software is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this software.  If not, see http://www.gnu.org/licenses/gpl-2.0.html.

@copyright Copyright (C) 2012 Open Source Solutions S.L.U. All rights reserved.
*/

jimport('joomla.html.html');
jimport('joomla.form.formfield');

class JFormFieldWizard extends JFormField
{
	protected $type = 'Wizard';

	protected function getInput()
	{
		return '';
	}

	protected function getLabel()
	{
		$name = basename(realpath(dirname(__FILE__) . DS . '..' . DS . '..'));

		$direction = intval(JFactory::getLanguage()->get('rtl', 0));
		$left  = $direction ? "right" : "left";
		$right = $direction ? "left" : "right";

		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select("COUNT(*)");
		$query->from("#__content");
		//$query->where("metadata REGEXP '\"xreference\":\"[+-]?([0-9]+)(\.[0-9]+)?,( +)?[+-]?([0-9]+)(\.[0-9]+)?\"'");
		$query->where("metadata REGEXP '\"xreference\":\"[+-]?[0-9]{1,2}([.][0-9]{1,})?[ ]{0,},[ ]{0,}[+-]?[0-9]{1,3}([.][0-9]{1,})?\"'");
		$db->setQuery($query);

		$counter = $db->loadResult();

		if ((bool)$counter)
		{
			return "";
		}

		echo '<div class="clr"></div>';
		$image = '';
		$icon	= (string)$this->element['icon'];
		if (!empty($icon))
		{
			$image .= '<img style="margin:0; float:' . $left . ';" src="' . JURI::base(true) . '/../media/' . $name . '/images/' . $icon . '">';
		}

		$style = 'background:#f4f4f4; border:1px solid silver; padding:5px; margin:5px 0;';

		return '<div style="' . $style . '">' .
		$image .
		'<span style="padding-' . $left . ':5px; line-height:16px;">' .
		JText::_($this->element['text']) .
		' <a href="' . $this->element['url'] . '" target="_blank">' .
		JText::_(strtoupper($name) . '_DOCUMENTATION') .
		'</a>' .
		'</span>' .
		'</div>';

	}
}
