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
class JFormFieldRainbow extends JFormField
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	protected $type = 'rainbow';

	function getInput()
	{
		$uri = str_replace(DS,"/",str_replace(JPATH_SITE, JURI::base(), dirname(__FILE__)));
		$uri = str_replace("/administrator/", "", $uri);
		$uri = str_replace("/element", "/element/assets/", $uri);
		
		if(!defined('ZT_RAINBOW'))
		{
			define('ZT_RAINBOW', 1);
			$document 	= &JFactory::getDocument();			
			
			$document->addStyleSheet($uri . 'css/rainbow.css');
			$document->addScript($uri . 'js/rainbow.js');
		}
		$tmp   = str_replace("[", "", $this->name);
		$tmp   = str_replace("]", "", $tmp);

		$html = '<div class="rb-item" id="frame_'.$tmp.'">';
		$html .= '<input id="'.$tmp.'" class="rb-color" name="'.$this->name.'" type="text" size="13" value="'.$this->value.'" style="background-color:'.$this->value.'" />
		</div>';
				
		$html .= '<script language="javascript" type="text/javascript">';
		$html .= 'window.addEvent("load", function(){			
			new MooRainbow("frame_'.$tmp.'", {
				id: "rainbow_'.$tmp.'",
				wheel: true,
				imgPath: "'.$uri.'images/",
				startColor: ("'.$this->value.'").hexToRgb(true),
				onChange: function(color) {
					$("'.$tmp.'").value = color.hex;
					$("'.$tmp.'").setStyle("background-color", color.hex);
				}
			});
		});';
		$html .= '</script>';
		
		return $html;
	}
} 
?>