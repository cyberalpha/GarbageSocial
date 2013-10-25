<?php

defined('_JEXEC') or die('Restricted access');
define('PHPEXT', '.php');
define('JSONEXT', '.json');

$post = $_POST;

function array2Json($array) {return json_encode($array);}
function json2Array($json) {return json_decode($json, 1);}
function buildArray($style, $data) {return array($style => $data);}

function handleSaveFile($array = false, $style = false, $clear = false) {
  $dir = dirname(dirname(dirname(__FILE__)));
  $post_data = array();
  if(is_array($array)) foreach($array as $k => $v) {
    if(!isset($post_data[$v['name']])) {
      $post_data[$v['name']] = $v['value'];
    } else {
      $current = array($post_data[$v['name']], $v['value']);
      $current = implode(',', $current);
      $post_data[$v['name']] = $current;
    }
  }
  $file = $dir . '/vertex' . JSONEXT;
  $jsonData = array('vertexFramework' => array());
  $currentValues = array();
  $check = '';
  if (file_exists($file)) {
    $check = file_get_contents($file);
    $file_data = json2Array($check);
    foreach($file_data['vertexFramework'] as $key => $data){
      if($key != $style) {
        $jsonData['vertexFramework'][$key] = $data;
      }
    }
  }
  $i = 0;
  if(!isset($jsonData['vertexFramework'][$style])) $jsonData['vertexFramework'][$style] = array();
  foreach($post_data as $key => $value){
    $jsonData['vertexFramework'][$style][$key] = $value;
    $i++;
  }
  $clear_array = array('vertexFramework' => array());
  if($clear) {
    foreach($file_data['vertexFramework'] as $key => $data){
      if($key != $clear) {
        $clear_array['vertexFramework'][$key] = $data;
        //$jsonData['vertexFramework'][$key] = $data;
      }
    }
    $jsonData = $clear_array;
  }
  if($array != false && isset($jsonData['vertexFramework'][$style])) {
    $data = array2Json($jsonData);
    $file = fopen($file, 'w');
    fwrite($file, $data);
    fclose($file);
    $res = true;
    $msg = 'Your settings were saved';
  } else {
    $res = false;
    $msg = 'There was an error while saving your configuration';
  }
  $msg = array('message' => $msg, 'result' => $res/*, 'data' => $jsonData['vertexFramework'][$style]*/);
  return $msg;
}

function runCron(){
  $dir = dirname(dirname(dirname(__FILE__)));
  $file = $dir.'/vertex' . JSONEXT;
  $jsonData = array('vertexFramework' => array());
  $currentValues = array();
  $check = '';
  $cronned = 0;
  if(file_exists($file)) {
    $check = file_get_contents($file);
    $file_data = json2Array($check);
    foreach($file_data['vertexFramework'] as $key => $data){
      $db = JFactory::getDBO();
      $query = "SELECT * FROM #__template_styles WHERE title = '$key';";
      $db->setQuery($query);
      $result = $db->loadAssocList();
      foreach($result as $k => $style) {
        if(isset($style['title'])) {
          $jsonData['vertexFramework'][$key] = $data;
        } else {
          $cronned++;
        }
      }
    }
    $data = array2Json($jsonData);
    $file = fopen($file, 'w');
    fwrite($file, $data);
    fclose($file);
  }
  $msg = array('cron' => false);
  if($cronned) {
    $msg = array('cron' => "$cronned items have been cleaned up");
  }
  return $msg;
}

ob_clean();
ob_start();
$cron = runCron();
$save = handleSaveFile($post['vertex'], $post['style_name'], (isset($post['clear']) ? $post['clear'] : false));

$msg = array_merge($cron, $save);

print array2Json($msg);

?>