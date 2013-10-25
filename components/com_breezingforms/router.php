<?php
/**
 * @package     BreezingForms
 * @author      Markus Bopp
 * @link        http://www.crosstec.de
 * @license     GNU/GPL
 */
jimport('joomla.version');

function BreezingformsBuildRoute(&$query) {

    $segments = array();

    foreach($query As $key => $value){
        if( !in_array($key, array('option', 'Itemid', 'view')) ){
            $segments[] = $key;
            $segments[] = $value;
        }
    }
    
    return $segments;
}

function BreezingformsParseRoute($segments) {
    
    $vars = array();
    $key = '';
    $last_key = '';
    $value = '';
    $seglength = count($segments);
    for($i = 0; $i < $seglength; $i++){
        if($i % 2 == 0){
            $vars[$segments[$i]] = '';
            $last_key = $segments[$i];
        }else{
            $vars[$last_key] = $segments[$i];
        }
    }
    if(isset($vars['view'])){
        unset($vars['view']);
    }
    return $vars;
}
