<?php
/**
 * @version: $Id: spform.php 2058 2011-12-14 10:06:53Z Sigrid Suski $
 * @package: SobiPro SP-GeoMap Module Application
 * ===================================================
 * @author
 * Name: Sigrid Suski & Radek Suski, Sigsiu.NET GmbH
 * Email: sobi[at]sigsiu.net
 * Url: http://www.Sigsiu.NET
 * ===================================================
 * @copyright Copyright (C) 2006 - 2011 Sigsiu.NET GmbH (http://www.sigsiu.net). All rights reserved.
 * @license see http://www.gnu.org/licenses/gpl.html GNU/GPL Version 3.
 * You can use, redistribute this file and/or modify it under the terms of the GNU General Public License version 3
 * ===================================================
 * $Date: 2011-12-14 11:06:53 +0100 (Mi, 14 Dez 2011) $
 * $Revision: 2058 $
 * $Author: Sigrid Suski $
 */

defined('_JEXEC') or die();
JLoader::import( 'joomla.html.parameter.element' );
require_once dirname(__FILE__).'/spelements.php';

class JFormFieldSPForm extends JElementSPElements
{
	public $id;
	public $hidden;
	public $input;

	public function setForm( $options )
	{
		return true;
	}

	public function setup( &$element, &$value, $grp = null )
	{
		$this->fieldname = ( string ) $element[ 'name' ];
		$this->name = ( string ) $element[ 'name' ];
		$this->id = ( string ) $element[ 'name' ];
		$this->element = $element;
		$this->label = '<label for="'.$this->id.'">'.$this->fetchTooltip( $this->name ).'</label>';
		$input = $this->fetchElement( ( string ) $element[ 'name' ], $label );
		$this->input = str_replace( 'params[', 'jform[params][', $input );
		$this->translateLabel = false;
		$this->translateDescription = false;
		return true;
	}
}
?>
