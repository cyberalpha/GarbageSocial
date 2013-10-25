<?php
/**
* BreezingForms - A Joomla Forms Application
* @version 1.7.3
* @package BreezingForms
* @copyright (C) 2008-2011 by Markus Bopp
* @license Released under the terms of the GNU General Public License
**/
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

function com_install(){

    if(!version_compare(PHP_VERSION, '5.1.2', '>=')){
 
	echo '<b style="color:red">WARNING: YOU ARE RUNNING PHP VERSION "'.PHP_VERSION.'". BREEZINGFORMS WON\'T WORK WITH THIS VERSION. PLEASE UPGRADE TO AT LEAST PHP 5.1.2, SORRY BUT YOU BETTER UNINSTALL THIS COMPONENT NOW!</b>';
    }
    
}