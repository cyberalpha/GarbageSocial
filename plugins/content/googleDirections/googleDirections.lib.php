<?php
/**
* googleDirections.lib
* allows you to include one or more google maps directions
* right inside Joomla content item or article
* Author: kksou
* Copyright (C) 2006-2010. kksou.com. All Rights Reserved
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Website: http://www.kksou.com/php-gtk2
* v1.5 May 11, 2009
* v1.51 May 12, 2009 bug fix
* v1.52 May 14, 2009 support for IE
* v1.53 May 21, 2009 bug fix: table heading when $dir_on_right=1
* v1.54 May 25, 2009 support for geographical coordinates (i.e. longitude and latitude)
* Now also supports multilines
* v1.55 May 27, 2009 uses googleMaps for map display
* v1.56 May 28, 2009 added new parameters - header_map, header_directions, map_on_right
* v1.57 May 30, 2009 added support for googleDirections_tohome
* v1.58 Oct 01, 2009 added new parameter - hide_direction_text
* v1.68 Oct 20, 2011 support for Joomla 1.6/1.7 and PHP 5.3.8
* v1.79 Nov 11, 2011 uses googleMaps API v3!
* v1.7.10 Dec 23, 2011 1) support for multiple stopovers!
*                      2) support for vertical alignment
*                      3) added 3 more tags: stopover, vertical and map_full_width
*                      4) added unit: metric / imperial
* v1.7.11 Jan 03, 2012 now gives exact location when lat/lng is given
* v1.7.12 Feb 01, 2012 1) added support for Joomla 2.5
*                      2) add flag w3c=1 => w3c compliant
*                      3) support for IE7!
*                      4) allow googleMaps to display in tabs
*                      5) now allows address to include ' (apostrophe)
*/

class Plugin_googleDirections_base extends Plugin_googleMaps_base {

	function process_params(&$row, $matches, $map_id) {

		$this->googledirections_ver = '010710';  // version 1.7.10

		$this->from = '';
		$this->to = '';
		$this->stopover = '';
		$this->mode = 'DRIVING';
		$this->dir_on_right = 0;
		#$this->map_on_right = 0;
		$this->hide_direction_text = 0;
		$this->addoverview = 0;
		$this->z_options = '';
		$this->unit = '';

		$this->dir_width = $this->params->dir_width;
		$this->header_map = $this->params->header_map;
		$this->header_dir = $this->params->header_dir;
		$this->map_on_right = $this->params->map_on_right;
		$this->vertical = 0;
		$this->map_full_width = 0;

		if (preg_match('/width=(\d+)/', $matches[1], $matches2)) $this->width = $matches2[1];
		if (preg_match('/dir_width=(\d+%?)/', $matches[1], $matches2)) $this->dir_width = $matches2[1];
		if (preg_match('/mode=([^\s]+)/', $matches[1], $matches2)) $this->mode = $matches2[1];

		if (preg_match('/from="([^"]+)"/', $this->fix_str2($matches[1]), $matches2)) $this->from = $this->fix_str2($matches2[1]);
		if (preg_match('/to="([^"]+)"/', $this->fix_str2($matches[1]), $matches2)) $this->to = $this->fix_str2($matches2[1]);
		#$from = str_replace('~', '@', $from);
		#$to = str_replace('~', '@', $to);
		$this->from = $this->fix_str3($this->from);
		$this->to = $this->fix_str3($this->to);

		if (preg_match('/use_own_css=(\d+)/', $matches[1], $matches2)) $this->use_own_css = $matches2[1];
		if (preg_match('/css=([^\s]+)/', $matches[1], $matches2)) $this->css = $matches2[1];
		if (preg_match('/dir_on_right=(\d+)/', $matches[1], $matches2)) $this->dir_on_right = $matches2[1];
		if (preg_match('/map_on_right=(\d+)/', $matches[1], $matches2)) $this->map_on_right = $matches2[1];
		if (preg_match('/hide_direction_text=(\d+)/', $matches[1], $matches2)) $this->hide_direction_text = $matches2[1];

		if (preg_match('/addoverview=(\d+)/', $matches[1], $matches2)) $this->addoverview = $matches2[1];
		$this->mode = strtoupper($this->mode);

		# added 2011.12.24
		if (preg_match('/options="([^"]+)"/', $this->fix_str2($matches[1]), $matches2)) {
			$this->z_options = $this->fix_str2($matches2[1]);
			$this->z_options = $this->fix_str2($this->z_options);
		}

		if (preg_match('/stopover="([^"]+)"/', $this->fix_str2($matches[1]), $matches2)) $this->stopover = $this->fix_str2($matches2[1]);
		$this->stopover = $this->fix_str3($this->stopover);

		if (preg_match('/vertical=(\d+)/', $matches[1], $matches2)) $this->vertical = $matches2[1];
		if (preg_match('/map_full_width=(\d+)/', $matches[1], $matches2)) $this->map_full_width = $matches2[1];
		if (preg_match('/unit=(metric|imperial)/i', $matches[1], $matches2)) $this->unit = strtoupper($matches2[1]);

		if ($this->vertical && preg_match('/width=(\d+%)/', $matches[1], $matches2)) $this->width = $matches2[1];
		#if (preg_match('/(\d+%)/', $this->width, $matches3)) $this->width = $matches2[1];

		$this->process_additional_param($row, $matches, $map_id);
	}

	function gdir_code() {
		$js = "\n<script type=\"text/javascript\">
<!--
function format_{$this->mod}_from(from, centerLatitude, centerLongitude) {
	if (from!='') {
	    return from;
	} else {
		return new google.maps.LatLng(centerLatitude, centerLongitude);
	}
}

function format_{$this->mod}_from2(from, centerLatitude, centerLongitude) {
	if (from!='') {
		var latlng_RegExp = /(-?\d+\.\d+)\s*,\s*(-?\d+\.\d+)/;
		if (latlng_RegExp.test(from)) {
			var str = from.match(latlng_RegExp);
			return new google.maps.LatLng(str[1], str[2]);
		} else {
	    	return from;
		}
	} else {
		return new google.maps.LatLng(centerLatitude, centerLongitude);
	}
}

function display_{$this->mod}(id, centerLatitude, centerLongitude, startZoom, kml, from, to, mode, control, maptype, show_marker, addoverview, addscale, addgoogle, streetview, stopover, unit) {
	var latlng_RegExp = /(-?\d+\.\d+)\s*,\s*(-?\d+\.\d+)/;
	if (latlng_RegExp.test(from)) {
		var str = from.match(latlng_RegExp);
		display_{$this->mod}_gmap_and_gdir(id, str[1], str[2], startZoom, kml, from, to, mode, control, maptype, show_marker, addoverview, addscale, addgoogle, streetview, stopover, unit)
	} else {
		var geocoder = new google.maps.Geocoder();
	    geocoder.geocode( { 'address': format_{$this->mod}_from(from, centerLatitude, centerLongitude)}, function(results, status) {
	    if (status == google.maps.GeocoderStatus.OK) {
	    	display_{$this->mod}_gmap_and_gdir(id, results[0].geometry.location.lat(), results[0].geometry.location.lng(), startZoom, kml, from, to, mode, control, maptype, show_marker, addoverview, addscale, addgoogle, streetview, stopover, unit);
	      } else {
	        alert('Google cannot decode your address: '+addr);
	        return;
	      }
   		});
   	}
}

function display_{$this->mod}_gmap_and_gdir(id, lat, lng, startZoom, kml, from, to, mode, control, maptype, show_marker, addoverview, addscale, addgoogle, streetview, stopover, unit) {
	show_marker = 0;
	var map = display_{$this->mod}_gmap(id, lat, lng, startZoom, from, kml, control, maptype, show_marker, addoverview, addscale, addgoogle, streetview);
	var directionsDisplay = new google.maps.DirectionsRenderer();
	directionsDisplay.setMap(map);
	{$this->mod}_calcRoute(id, directionsDisplay, lat, lng, from, to, mode, stopover, unit);
}

function {$this->mod}_calcWaypts(waypoints) {
	var waypts = [];
	if (waypoints!='') {
	    var waypts_str_array = waypoints.split(';');
    	for (i = 0; i < waypts_str_array.length; i++) {
    		var myRegExp = /\(nostop\)/;
    		var str = waypts_str_array[i];
    		var matchPos1 = str.search(myRegExp);
    		if(matchPos1 != -1) {
    			var str2 = str.replace(myRegExp, '');
    			//waypts.push({location:str2, stopover:false});
    			waypts.push({location:format_{$this->mod}_from2(str2, 0, 0), stopover:false});
    		} else {
     	    	//waypts.push({location:waypts_str_array[i], stopover:true});
     	    	waypts.push({location:format_{$this->mod}_from2(waypts_str_array[i], 0, 0), stopover:true});
     	    }
    	}
	}
    return waypts;
}

function {$this->mod}_calcRoute(id, directionsDisplay, centerLatitude, centerLongitude, from, to, mode, stopover, unit) {
	var waypts = {$this->mod}_calcWaypts(stopover);

	if (unit=='METRIC') {unit2 = 0;}
	else if (unit=='IMPERIAL') { unit2 = 1; }

	var request;
	if (unit=='') {
	    request = {
		    origin: format_{$this->mod}_from2(from, centerLatitude, centerLongitude),
		    destination: format_{$this->mod}_from2(to, centerLatitude, centerLongitude),
		    waypoints: waypts,
		    //optimizeWaypoints: true,
		    travelMode: google.maps.TravelMode[mode]
		};
	} else {
	    request = {
		    origin: format_{$this->mod}_from2(from, centerLatitude, centerLongitude),
		    destination: format_{$this->mod}_from2(to, centerLatitude, centerLongitude),
		    waypoints: waypts,
		    //optimizeWaypoints: true,
		    travelMode: google.maps.TravelMode[mode],
		    unitSystem: unit2
		};
	}

    var directionsService = new google.maps.DirectionsService();
    var directionsPanel = document.getElementById(\"{$this->mod}_gdir\"+id);
  	directionsDisplay.setPanel(directionsPanel);
    directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        }
    });

    //format2_gdir(map, id, streetview);

}
-->
</script>
";
		return $js;
	}
}

class Plugin_googleDirections extends Plugin_googleDirections_base {

	function Plugin_googleDirections( &$row, $pluginParams, $is_mod=0 ) {
		$this->mod = 'gdir';
		$this->tag = 'googleDir';
		$this->css = 'googleDirections.css';
		$this->addoverview = '';
		$this->addgoogle = '';
		$this->params = $pluginParams;

		$this->init_google_maps($row, $pluginParams, $is_mod);
	}

	function process_additional_param(&$row, $matches, $map_id) {
	}

	function output_map(&$row, $matches, $map_id) {
		if ($this->width<10 || $this->width>4096) $this->width = 400;
		if ($this->dir_width<10 || $this->dir_width>4096) $this->dir_width = 275;

		if (preg_match('/%/', $this->width)) $width2 = $this->width;
		else $width2 =  $this->width.'px';

		if (preg_match('/%/', $this->dir_width)) $dir_width2 = $this->dir_width;
		else $dir_width2 =  $this->dir_width.'px';

		#$this->vertical = 1;
		#$this->map_full_width = 1;
		$output = '';
		if ($this->vertical) {
			if ($this->add_p || $this->w3c) $output .= "</p>";
			$width3 = $width2;
			if ($this->map_full_width==1) $width3 = '100%';
			$output .= "    <div class=\"gdir_body\" id=\"{$this->mod}_gmap{$map_id}\" style=\"width: {$width3}; height: {$this->height}px\"></div>";
			$output .= "<div style=\"width: {$width3};\"><p align=\"right\" style=\"padding:0 0 0 0;margin:0 0 0 0\"><a href=\"http://www.kksou.com/php-gtk2/Joomla-Gadgets/googleDirections-plugin.php\" style=\"color:#aaa;text-decoration: none;font-family:Tahoma, Arial, Helvetica, sans-serif;font-size:7pt;font-weight: normal;\">Powered by JoomlaGadgets</a></p></div>\n";

			$dir_div = "    <div id=\"{$this->mod}_gdir{$map_id}\" style=\"width: {$dir_width2}\"></div>\n";
			if (!$this->hide_direction_text) $output .= $dir_div;
			if ($this->add_p || $this->w3c) $output .= "<p>";

		} else {

			if ($this->add_p || $this->w3c) $output .= "</p>";
			$output .= "\n<table class=\"googleDirections\">\n";
			if ($this->dir_on_right || !$this->map_on_right) {
				if (!$this->hide_direction_text) $output .= "<tr><th>$this->header_map</th><th>$this->header_dir</th></tr>\n";
			} else {
				if (!$this->hide_direction_text) $output .= "<tr><th>$this->header_dir</th><th>$this->header_map</th></tr>\n";
			}

			$dir_div = "    <td valign=\"top\"><div id=\"{$this->mod}_gdir{$map_id}\" style=\"width: {$dir_width2}\"></div></td>\n";

			$output .= "<tr>\n";
			if (!$this->hide_direction_text) if (!($this->dir_on_right || !$this->map_on_right)) $output .= $dir_div;
			#$output .= "    <td valign=\"top\"><div class=\"gdir_body\" id=\"gmap{$map_id}\" style=\"width: {$width2}; height: {$height}px\"></div></td>\n";
			$output .= "    <td valign=\"top\"><div class=\"gdir_body\" id=\"{$this->mod}_gmap{$map_id}\" style=\"width: {$width2}; height: {$this->height}px\"></div>";

			$output .= "<div style=\"width: {$width2};\"><p align=\"right\" style=\"padding:0 0 0 0;margin:0 0 0 0\"><a href=\"http://www.kksou.com/php-gtk2/Joomla-Gadgets/googleDirections-plugin.php\" style=\"color:#aaa;text-decoration: none;font-family:Tahoma, Arial, Helvetica, sans-serif;font-size:7pt;font-weight: normal;\">Powered by JoomlaGadgets</a></p></div>\n";
			$output .= "</td>\n";
			if (!$this->hide_direction_text) if ($this->dir_on_right || !$this->map_on_right) $output .= $dir_div;
			$output .= "</tr>";
			$output .= "</table>\n";
			if ($this->add_p || $this->w3c) $output .= "<p>";
		}

		$row->text = str_replace($matches[0], $output, $row->text);

		$js = "init_{$this->mod}('$map_id', $this->lat, $this->long, $this->startzoom, '$this->kml', '$this->from', '$this->to', '$this->mode', '$this->control', '$this->maptype', '$this->marker', '$this->addoverview', '$this->addscale', '$this->addgoogle', '$this->streetview', '$this->stopover', '$this->unit');\n";

		return $js;
	}

	function setup_css() {
		$css_file = dirname(__FILE__).'/'.$this->css;
		$css = file_get_contents($css_file);

		/*$output = "
<style type=\"text/css\">
<!--
$css
-->
</style>
";*/
		#return $output;
		return $css;
	}

	function setup_gmap() {
		$output = "\n\n<!-- \nPowered by Joomla Gadgets from kksou.com
http://www.kksou.com/php-gtk2/Joomla-Gadgets/googleDirections-plugin.php
-->\n\n";

		$lang = '';
		if ($this->lang!='') $lang = "&amp;hl=".$this->lang;
		#$output .= "\n<script src=\"http://maps.google.com/maps?file=api&amp;v=2&amp;key=$this->api_key".$lang."\" type=\"text/javascript\"></script>";
		$output .= "\n"."<script type=\"text/javascript\" src=\"http://maps.googleapis.com/maps/api/js?sensor=false&amp;language=".$this->lang.'"></script>';

		$output .= $this->gdir_code();

		$output .= "\n<script type=\"text/javascript\">
<!--
function init_{$this->mod}(id, centerLatitude, centerLongitude, startZoom, kml, from, to, mode, control, maptype, show_marker, addoverview, addscale, addgoogle, streetview, stopover, unit) {
    display_{$this->mod}(id, centerLatitude, centerLongitude, startZoom, kml, from, to, mode, control, maptype, show_marker, addoverview, addscale, addgoogle, streetview, stopover, unit);
}
-->
</script>
";

		return $output;
	}
}

?>
