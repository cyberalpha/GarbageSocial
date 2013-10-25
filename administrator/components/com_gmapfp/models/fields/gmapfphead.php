<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.0.beat1
	* Creation date: Mai 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die();

class JFormFieldGMapFPHead extends JFormField
{

	public $type = 'GMapFPHead';

	protected function getInput()
	{
		if ($this->element['default']) {
			return '<li><label style="background: #CCE6FF; color: #0069CC; padding:5px; width: 100%"><strong>' . JText::_($this->element['default']) . '</strong></label></li>';
		} else {
			return '<li />';
		}
	}

}

?>