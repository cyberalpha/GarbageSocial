<?php
/**
* @version 1.7.x
* @package ZooTemplate Project
* @email webmaster@zootemplate.com
* @copyright (c) 2008 - 2011 http://www.ZooTemplate.com. All rights reserved.
*/

$groups = array('bd'=>'Body', 'zt-header'=>'Header', 'zt-footer'=>'Footer');

$value  = array();

$prefix = "zizia";

//Body Group
$value['bd']['color'] = $ztTools->getParamsValue($prefix, 'color', 'bd');
$value['bd']['text'] = $ztTools->getParamsValue($prefix, 'text', 'bd');
$value['bd']['link']  = $ztTools->getParamsValue($prefix, 'link', 'bd');
$value['bd']['image'] = array($ztTools->getParamsValue($prefix, 'image', 'bd'), array('pattern1', 'pattern2', 'pattern3', 'pattern4', 'pattern5', 'pattern6', 'pattern7', 'pattern8', 'pattern9', 'pattern10'));

$value['zt-header']['color'] = $ztTools->getParamsValue($prefix, 'color', 'zt-header');
$value['zt-header']['image'] = array($ztTools->getParamsValue($prefix, 'image', 'zt-header'), array('pattern1', 'pattern2', 'pattern3', 'pattern4', 'pattern5', 'pattern6', 'pattern7', 'pattern8', 'pattern9', 'pattern10'));

$value['zt-footer']['color'] = $ztTools->getParamsValue($prefix, 'color', 'zt-footer');
$value['zt-footer']['text'] = $ztTools->getParamsValue($prefix, 'text', 'zt-footer');
$value['zt-footer']['link']  = $ztTools->getParamsValue($prefix, 'link', 'zt-footer');
$value['zt-footer']['image'] = array($ztTools->getParamsValue($prefix, 'image', 'zt-footer'), array('pattern1', 'pattern2', 'pattern3', 'pattern4', 'pattern5', 'pattern6', 'pattern7', 'pattern8', 'pattern9', 'pattern10'));

?>
<style type="text/css">
	#bd {
		color:<?php echo $ztTools->getParamsValue($prefix, 'text', 'bd'); ?>;
		background-color: <?php echo $ztTools->getParamsValue($prefix, 'color', 'bd'); ?>;
	}
	#bd a {
		color: <?php echo $ztTools->getParamsValue($prefix, 'link', 'bd'); ?>;
	}
	#zt-header {
		background-color: <?php echo $ztTools->getParamsValue($prefix, 'color', 'zt-header'); ?>;
	}
	#zt-footer {
		color:<?php echo $ztTools->getParamsValue($prefix, 'text', 'zt-footer'); ?>;
		background-color: <?php echo $ztTools->getParamsValue($prefix, 'color', 'zt-footer'); ?>;
	}
	#zt-footer a {
		color: <?php echo $ztTools->getParamsValue($prefix, 'link', 'zt-footer'); ?>;
	}
</style>