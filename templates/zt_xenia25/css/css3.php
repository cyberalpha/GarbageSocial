<?php 
/*------------------------------------------------------------------------
* ZT Template 1.5
* ------------------------------------------------------------------------
* Copyright (c) 2008-2011 ZooTemplate. All Rights Reserved.
* @license - Copyrighted Commercial Software
* Author: ZooTemplate
* Websites:  http://www.zootemplate.com
-------------------------------------------------------------------------*/
header('Content-type: text/css; charset: UTF-8');
header('Cache-Control: must-revalidate');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
$url = $_REQUEST['url'];
?>

#zt-userwrap4-inner,
div.userBlock{
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	position: relative;
    behavior: url(<?php echo $url; ?>css/css3.htc);	
	-moz-box-shadow: 0 0 2px 0px #ccc;
	-webkit-box-shadow: 0 0 2px 0px #ccc;
	box-shadow: 0 0 2px 0px #ccc;
}

.button,
.button2{
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	position: relative;
    behavior: url(<?php echo $url; ?>css/css3.htc);	
}