<?php
/**
 * @version		$Id: lastedit.php 2012-03-01 vinaora $
 * @package		Vinaora Cu3er 3D Slideshow
 * @subpackage	mod_vinaora_cu3er_3d_slideshow
 * @copyright	Copyright (C) 2010 - 2012 VINAORA. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @website		http://vinaora.com
 * @twitter		http://twitter.com/vinaora
 * @facebook	http://facebook.com/vinaora
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.form.formfield');

class JFormFieldLastEdit extends JFormField {

	protected $type = 'LastEdit';

	public function getInput() {
		$config = &JFactory::getConfig();
		$offset	= $config->getValue('config.offset');

		$now = &JFactory::getDate();
		$now->setOffset($offset);

		$value	= $now->toFormat('%Y%m%d-%H%M%S');

		return '<input id="'.$this->id.'" name="'.$this->name.'" value="'.$value.'" type="hidden" />';
	}

	public function getLabel(){
	}
}
