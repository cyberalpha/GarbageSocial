<?php 
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.0.beat1
	* Creation date: Mai 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die('Restricted access'); 
JHTML::_( 'behavior .modal' );
$config =& JComponentHelper::getParams('com_gmapfp');

?>
<div class="contentpane<?php echo $config->get( 'pageclass_sfx' ); ?>">
<?php
echo $this->map;
?>
</div>