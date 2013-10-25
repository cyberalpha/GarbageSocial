<?php
/**
* googleMaps module
* This module allows you to display one or more google maps
* in a module position
* Make sure you have the googleMaps plugin installed
* Author: kksou
* Copyright (C) 2006-2008. kksou.com. All Rights Reserved
* Website: http://www.kksou.com/php-gtk2
* v1.5 April 16, 2009
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$moduleclass_sfx = $params->get('moduleclass_sfx');
$a = new stdClass;
#$dispatcher	=& JDispatcher::getInstance();
$dispatcher	= JDispatcher::getInstance();
JPluginHelper::importPlugin('content');
$a->text = $str;
#$a->params = array('is_mod'=>1);
$a->params = new stdClass;
$a->params->is_mod = 1;
#$results = $dispatcher->trigger('onPrepareContent', array (&$a, $a->params, 0));
#$results = $dispatcher->trigger('onPrepareContent', array ($a, $a->params, 0));
$results = $dispatcher->trigger('onContentPrepare', array ('mod.com_content.article', &$a, &$a->params, 0));
echo $a->text;
?>