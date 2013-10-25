<?php
/**
 * @version		$Id: vinaora_param.php 2012-03-18 vinaora $
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

class modVinaoraCu3er3DSlideshowParam
{

	/*
	 * Get a Parameter in a Parameters String which are separated with a specify symbol (default: vertical bar '|').
	 * Example: Parameters = "value1 | value2 | value3". Return "value2" if positon = 2
	 */
	public static function getParam($param, $position=1, $separator='|'){

		$position = intval($position);

		// Not found the separator in string
		if( strpos($param, $separator) === false ){
			if ( $position == 1 ) return $param;
		}
		// Found the separator in string
		else{
			$param = ($separator = "\n") ? str_replace(array("\r\n","\r"), "\n", $param) : $param;
			$items = explode($separator, $param);
			if ( ($position > 0) && ($position < count($items)+1) ) return $items[$position-1];
		}

		return '';
	}

	/*
	 * Valid Link Target
	 * Return: _blank, _parent, _self, _top
	 */
	public static function validTarget($target, $default='_blank'){
		$target = strtolower( trim($target) );

		// Add '_' symbol to the beginning of string if not exist
		$target = "_" . ltrim($target, "_");

		$valid = array ('_blank', '_parent', '_self', '_top');
		$target = in_array($target, $valid) ? $target : $default;

		return $target;
	}

	/*
	 * Valid Color
	 */
	public static function validColor($color, $default="ffffff", $prefix=""){
		$color = strtolower ( trim($color) );

		if (!strlen($color)) return $prefix.$default;
		
		// Remove '0x' or '#' at the beginning of string if exist
		$color = preg_replace('/^(0x|\#)/', '', $color);

		$color = substr($color, 0, 6);

		$patern = '/^([a-f0-9]{6})$/';
		$color = (preg_match($patern, $color)) ? $color : $default;

		return $prefix.$color;
	}

	/*
	 * Get Random Color
	 */
	public static function rand_color() {
		return substr('00000' . dechex(mt_rand(0, 0xffffff)), -6);
	}

	/*
	 * Valid Transparency (From 0-100)
	 */
	public static function validTransparency($t){
		$t = intval($t);
		$t = min($t, 100);
		$t = max($t, 0);

		return $t;
	}

	/*
	 * 
	 */
	public static function getRelatetivePath($url){
	
		$url = trim($url);
		$url = str_replace("\\", "/", $url);

		// Remove the scheme of the url
		// $url = preg_replace('/(https?\:\/\/)?(?i)([a-z0-9]([a-z0-9\-\.]+)?[a-z0-9])(\:[0-9]+)?\//', '', $url);
		$found = strpos($url, ":");
		$url = ($found !== false) ? substr($url, strlen($found)-strlen($url)) : $url;
		
		// Remove [port]// in the path if exists
		$url = preg_replace('/^([0-9]+)?\/\//', '', $url);
		$url = ltrim($url, "/");

		$path	= JPATH_BASE.DS.$url;
		$path	= JPath::clean($path, DS);

		$url	= JPath::clean($url, "/");

		if (is_file($path)){
			return self::getPath($url, true);
		}

		return "/".$url;
	}

	/*
	 * Get the Base Path
	 */
	public static function getBasePath($relative = true){
		// Use JURI::base() for Full URL
		$path = JURI::base($relative);

		// Add slash symbol "/" at the end of path
		$path = rtrim($path, "/") . "/";

		return $path;
	}

	/*
	 * Get the Path
	 */
	public static function getPath($path, $relative = true){
		$path = JURI::base($relative)."/".$path;
		$path = JPath::clean($path, "/");
		return $path;
	}

}
