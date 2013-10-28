<?php
/*
# ------------------------------------------------------------------------
# ZTTools plugin for Joomla 2.5.0
# ------------------------------------------------------------------------
# Copyright(C) 2008-2012 www.zootemplate.com. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: ZooTemplate
# Websites: http://www.zootemplate.com
# ------------------------------------------------------------------------
*/


// Ensure this file is being included by a parent file
defined('_JEXEC') or die( 'Restricted access');

/**
 * Radio List Element
 *
 * @since      Class available since Release 1.2.0
 */
class JFormFieldResColor extends JFormField
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	protected $type = 'ResColor';

	function getInput()
	{
		$string = '<script language="javascript" type="text/javascript">
				   function ResColor(val) {
				   		if(confirm("Are you sure ?!") == true)
						{
							val.each(function(item, index) {								
								var key = item.split(":")[0];
								var val = item.split(":")[1];
								
								$("jformparams" + key).value = val;
							});
							submitbutton("style.apply");
						}
				   }
				   </script>';
		$string .= '<input type="button" value="Reset Default" name="Reset Default" class="button" onclick="javascript: ResColor('.$this->value.');" />';
				
		return $string;
	}
}