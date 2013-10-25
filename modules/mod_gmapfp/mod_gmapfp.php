<?php
    /*
    * Module GMapFP for Component Google Map for Joomla! 1.5.x
    * Version J17V1.0Pro
    * Creation date: Août 2011
    * Author: Fabrice4821 - www.gmapfp.org
    * Author email: webmaster@gmapfp.org
    * License GNU/GPL
    */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$tabclass_arr = array ('sectiontableentry2', 'sectiontableentry1');

$menu   = &JSite::getMenu();
$items  = $menu->getItems('link', 'index.php?option=com_gmapfp&view=article');
$itemid = isset($items[0]) ? '&Itemid='.$items[0]->id : '';

$nbre_article = $params->get( 'gmapfp_nbre_article', 5 );

switch ($params->get( 'gmapfp_action' )){
case '1':
    $gmapfps   = modGMapFPHelper::getGMapFPLast($nbre_article);
    break;
case '2':
    $gmapfps   = modGMapFPHelper::getGMapFPSQL($nbre_article, $params->get( 'gmapfp_sql' ));
    break;
default:
    //$gmapfp   = modGMapFPHelper::getGMapFP($params->get( 'id', 0 ));
    $gmapfps   = modGMapFPHelper::getGMapFPRandom($nbre_article);
};

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

if ( $gmapfps && $gmapfps[0]->id ) {
    $layout = JModuleHelper::getLayoutPath('mod_gmapfp');
    $tabcnt = 0;

    require($layout);
}