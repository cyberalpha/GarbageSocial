<?php
/**
 * @package		Joomla.Site
 * @subpackage	TTw mod_automailing
 * @copyright	Copyright (C) 2011 - 2012 TTwebs All rights reserved.
 * @license		GNU General Public License version 2 or later
 */

// no direct access
defined('_JEXEC') or die;
?>

<div id="ttw_latlon" class="moduletable <?php echo $params->get( 'moduleclass_sfx' ) ?>">
	<?php if ($params->get( 'latlon_pre' )) { ?>
		<div id="ttw_latlon_pretext"><?php echo $params->get( 'latlon_pre');?></div>
	<?php } ?>
	
	<div id="map_canvas" style="height:<?php echo $params->get( 'latlon_height');?>; width:<?php echo $params->get( 'latlon_width');?>;"></div><br>
	<p>
	<span id="latitudeError"></span><label for="latitude" class="prompt"><?php echo $params->get( 'latlon_lat_lab');?></label><input type="text" id="latitude" name="latitude" style="width:150px;" maxlength="50"></p><p>
	<span id="longitudeError"></span><label for="longitude" class="prompt"><?php echo $params->get( 'latlon_lon_lab');?></label><input type="text" id="longitude" name="longitude" style="width:150px;" maxlength="50"></p><p>
	<span id="zoomError"></span><label for="zoom" class="prompt"></label><input type="hidden" id="zoom" name="zoom" style="width:25px;" maxlength="50"></p>


	<?php if ($params->get( 'latlon_post' )) { ?>
		<div id="ttw_latlon_posttext"><?php echo $params->get( 'latlon_post');?></div>
	<?php } ?>
</div>