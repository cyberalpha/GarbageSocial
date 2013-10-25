<?php
/**
* googleMaps.lib
* allows you to include one or more google maps
* right inside Joomla content item or article
* Author: kksou
* Copyright (C) 2006-2008. kksou.com. All Rights Reserved
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Website: http://www.kksou.com/php-gtk2
* v1.5 April 16, 2009
* v1.51 April 30, 2009 added support for mod_googleMaps
* v1.52 May 3, 2009 improved javascript
* v1.53 May 9, 2009 added support for kml files
* v1.54 May 10, 2009 added map control and map type
* v1.55 May 11, 2009 added support for hl and width=100%
* v1.56 May 14, 2009 support for IE; added marker=0
* v1.57 May 21, 2009 added GOverviewMapControl, GScaleControl, GoogleBar
* #map{ overflow:hidden } - prevent Google's copyright tet to flow out of a small map
* v1.58 May 26, 2009 added support for multiple controls
* v1.59 May 27, 2009 streamline entire code for use with googleDirections
added a geodecoder so that user can now specify address instead of latitude and longitude
* v1.5.10 May 28, 2009 commented $js_var. added support for googleDirection_tohere
* v1.5.11 Oct 11, 2009 W3C XHTML 1.0 Transitional
* v1.5.12 Oct 24, 2009 Bug fix: $add_p undefined
* v1.5.13 Feb 27, 2009 Bug fix: another two places of $add_p undefined
* v1.6 Feb 23, 2011 support for Joomla 1.6
* v1.7.14 Oct 8, 2011 added support for Joomla 1.7 and PHP 5.3.8
* v1.7.15 Nov 11, 2011 uses googleMaps API v3!
* v1.7.16 Dec 24, 2011 1) support for googleDirections multiple stopovers!
*                      2) If no label is specified, will use addr or latlng as marker
*                      3) improved function for displaying marker
*                      4) kml can now show marker too
*                      5) allow user to input addr as (37.4219720, -122.0841430)
* v1.7.17 Jan 03, 2012 now gives exact location when lat/lng is given
* v2.5.18 Jan 27, 2012 1) added support for Joomla 2.5
*                      2) add flag w3c=1 => w3c compliant
*                      3) support for IE7!
*                      4) allow googleMaps to display in tabs
*                      5) now allows address to include ' (apostrophe)
* v2.5.19 Mar 16, 2012 added support for zoom level for KML files
*/

class Plugin_googleMaps_base {

	function init_google_maps($row, $pluginParams, $is_mod) {

		$param_list = array('api_key', 'width', 'height', 'zoom');
		foreach($param_list as $var) {
			$this->$var = $pluginParams->$var;
		}

		#$regex = "/\{".$this->tag."\s*(.*?)\}/is";
		$regex = "/\{".$this->tag."\s+(.*?)\}/is";
		$contents = $row->text;
		if (preg_match_all( $regex, $contents, $matches, PREG_SET_ORDER )) {
			$count = count( $matches[0] );
			if ($count==0) return true;

			static $map_id = 0;
			$is_mod2 = '_plugin';
			$GET_var = "mod_{$this->tag}_id";
			if ($is_mod) {
					if (!isset($_GET[$GET_var]))
					$_GET[$GET_var] = 131;
				$is_mod2 = '_mod';
			}

			$js_var = '';
			$js = '';
			$js2 = '';
			$this->lang = '';
			$this->options_js = '';
			foreach($matches as $matches2) {
				if ($is_mod) {
					$map_id = $_GET[$GET_var]++;
				}
				#$var = $this->mod.'2'.$map_id;
				#$js_var .= "var {$var};";
				$js .= $this->process($row, $matches2, $map_id);

				if ($this->z_options!='') {
					$this->options_js .= "if (id==$map_id) map.setOptions({".$this->z_options."});\n";
				}

				#$js2 .= "$var.checkResize();\n";
				if (!$is_mod) ++$map_id;
			}

			$init_script = "<script type=\"text/javascript\">
<!--
$js_var
function load_{$this->mod}() {".$js.$js2."}
onload_{$this->mod}(load_{$this->mod});
//window.onunload = GUnload;
-->
</script>
";
			$row->text = preg_replace( $regex, '', $row->text );
			$codes = $this->js_lib();
			if(defined('_VALID_MOS')) {
				$codes .= "<style type=\"text/css\">\n<!--".$this->setup_css()."-->\n</style>";
			} else {
				JFactory::getDocument()->addStyleDeclaration($this->setup_css());
			}
			$codes .= $this->setup_gmap();
			$row->text = $codes.$row->text;
			$row->text .= $init_script;
		}

		return true;
	}

	function process(&$row, $matches, $map_id) {
		$this->process_controls($row, $matches, $map_id);
		$this->process_params($row, $matches, $map_id);
		$js = $this->output_map($row, $matches, $map_id);
		return $js;
	}

	function process_controls(&$row, $matches, $map_id) {
		$this->lat = 0;
		$this->long = 0;
		$description = '';
		$this->startzoom = $this->zoom;
		$this->description = '';
		#$this->width = $this->width;
		#$this->height = $this->height;
		$this->control = '';
		$this->maptype = '';
		$this->kml = '';
		$this->marker = 1;
		$this->addscale = 0;
		$this->addoverview = 1;
		$this->streetview = 1;
		$this->addr = '';
		$this->add_p = 0;
		$this->w3c = 1;
		$this->z_options = '';

		if (preg_match('/lat=([\+\-]?[0-9\.]+)/', $matches[1], $matches2)) $this->lat = $matches2[1];
		if (preg_match('/long=([\+\-]?[0-9\.]+)/', $matches[1], $matches2)) $this->long = $matches2[1];
		if (preg_match('/zoom=(\d+)/', $matches[1], $matches2)) $this->startzoom = $matches2[1];
		if (preg_match('/width=(\d+%?)/', $matches[1], $matches2)) $this->width = $matches2[1];
		if (preg_match('/height=(\d+)/', $matches[1], $matches2)) $this->height = $matches2[1];

		# added on 090510
		if (preg_match('/options=([^\s]+)/', $matches[1], $matches2)) $this->z_options = $matches2[1];
		if (preg_match('/control=([^\s]+)/', $matches[1], $matches2)) $this->control = $matches2[1];
		if (preg_match('/maptype=([^\s]+)/', $matches[1], $matches2)) $this->maptype = $matches2[1];
		if (preg_match('/lang=([^\s]+)/', $matches[1], $matches2)) $this->lang = $matches2[1];
		if (preg_match('/marker=([^\s]+)/', $matches[1], $matches2)) $this->marker = $matches2[1];
		if (preg_match('/addoverview=(\d+)/', $matches[1], $matches2)) $this->addoverview = $matches2[1];
		if (preg_match('/addscale=(\d+)/', $matches[1], $matches2)) $this->addscale = $matches2[1];
		if (preg_match('/addgoogle=(\d+)/', $matches[1], $matches2)) $this->addgoogle = $matches2[1];

		if (preg_match('/w3c=(\d+%?)/', $matches[1], $matches2)) {
			$this->w3c = $matches2[1];
		} else if (preg_match('/add_p=(\d+%?)/', $matches[1], $matches2)) {
			$this->add_p = $matches2[1];
			$this->w3c = $this->add_p;
		}
		if (preg_match('/streetview=(\d+)/', $matches[1], $matches2)) $this->streetview = $matches2[1];

		if (preg_match('/options="([^"]+)"/', $this->fix_str2($matches[1]), $matches2)) {
			$this->z_options = $this->fix_str2($matches2[1]);
			$this->z_options = $this->fix_str2($this->z_options);
		}

		$this->maptype = strtoupper($this->maptype);
		if ($this->maptype=='G_SATELLITE_MAP') $this->maptype = 'SATELLITE';
		if ($this->maptype=='G_HYBRID_MAP') $this->maptype = 'HYBRID';
		if ($this->maptype=='G_NORMAL_MAP') $this->maptype = 'ROADMAP';

		# added on 090509
		if (preg_match('/kml=([^\s]+)/', $matches[1], $matches2)) $this->kml = $matches2[1];

		if (preg_match('/description="([^"]+)"/', $this->fix_str2($matches[1]), $matches2)) $description = $this->fix_str2($matches2[1]);
		if (preg_match('/label="([^"]+)"/', $this->fix_str2($matches[1]), $matches2)) $description = $this->fix_str2($matches2[1]);
		$description = $this->fix_str2($description);
		$description = str_replace('~', '<br />', $description);
		#$description = str_replace('~', '&lt;br /&gt;', $description);
		$description = str_replace("'", '\\'."'", $description);
		$description = str_replace("\r\n", "\n", $description);
		$description = str_replace("\n", '<br />', $description);
		$this->description = $description;

		# added on 090528
		if (preg_match('/addr="([^"]+)"/', $this->fix_str2($matches[1]), $matches2)) $this->addr = $this->fix_str2($matches2[1]);
		$this->addr = str_replace("'", "\\"."'", $this->addr);

		if ($this->startzoom<1 || $this->startzoom>18) $this->startzoom = 15;
		if ($this->height<10 || $this->height>4096) $this->height = 480;

	}

	function process_params(&$row, $matches, $map_id) {
	}

	function fix_str2($str) {
		#$str = str_replace('<br>', "\n", $str);
		#$str = str_replace('<br />', "\n", $str);
		#$str = str_replace('<p>', "\n", $str);
		#$str = str_replace('</p>', "\n", $str);
		$str = str_replace('&#39;', "'", $str);
		$str = str_replace('&quot;', '"', $str);
		$str = str_replace('&lt;', '<', $str);
		$str = str_replace('&gt;', '>', $str);
		$str = str_replace('&amp;', '&', $str);
		$str = str_replace('&nbsp;', ' ', $str);
		return $str;
	}

	function fix_str3($str) {
		$str = str_replace('~', '@', $str);
		$str = str_replace('<br>', " ", $str);
		$str = str_replace('<br />', " ", $str);
		$str = str_replace('<p>', " ", $str);
		$str = str_replace('</p>', " ", $str);
		$str = str_replace('&nbsp;', ' ', $str);
		$str = str_replace("\n", " ", $str);
		$str = str_replace("\r", "", $str);
		return $str;
	}

	function js_lib() {
		$js = "\n<script type=\"text/javascript\">
<!--
function onload_{$this->mod}(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {window.onload = func;} else {
    window.onload = function() {if (oldonload){oldonload();}func();}
  }
}

function display_{$this->mod}_gmap(id, centerLatitude, centerLongitude, startZoom, description, kml, control, maptype, show_marker, addoverview, addscale, addgoogle, streetview) {
    var latlng = new google.maps.LatLng(centerLatitude, centerLongitude);
    if (startZoom==0 || startZoom=='') startZoom=10;
    var mapdiv = document.getElementById(\"{$this->mod}_gmap\"+id);
    var myOptions = {
      zoom: startZoom,
      center: latlng
    };
    var map = new google.maps.Map(mapdiv, myOptions);
    if (kml!='') {
    	var myKMLOptions = {
		  //suppressInfoWindows: true,
          map: map,
          preserveViewport: true
		};
    	var georssLayer = new google.maps.KmlLayer(kml, myKMLOptions);
  		georssLayer.setMap(map);
    }
    format_{$this->mod}(map, control, maptype, show_marker, addoverview, addscale, addgoogle);
    format2_{$this->mod}(map, id, streetview);

    if (show_marker) show_gmap_marker(map, latlng, centerLatitude, centerLongitude, description);
    return map;
}

function format_{$this->mod}(map, control, maptype, show_marker, addoverview, addscale, addgoogle) {
	if (addscale==1) map.setOptions({scaleControl: true});
	//if (addoverview=='1') {map.setOptions({overviewMapControl: true, overviewMapControlOptions:{opened: true}});} else {map.setOptions({overviewMapControl: false});}
	if (addoverview==1) map.setOptions({overviewMapControl: true, overviewMapControlOptions:{opened: true}});
	//map.setOptions({google.maps.MapTypeId: ROADMAP});
	if (maptype=='SATELLITE') {map.setOptions({MapTypeId: google.maps.MapTypeId.SATELLITE});}
	else if (maptype=='TERRAIN') {map.setOptions({MapTypeId: google.maps.MapTypeId.TERRAIN});}
	else if (maptype=='HYBRID') {map.setOptions({MapTypeId: google.maps.MapTypeId.HYBRID});}
	else {map.setOptions({MapTypeId: google.maps.MapTypeId.ROADMAP});}
}

function format2_{$this->mod}(map, id, streetview) {
	if (streetview==1) {map.setOptions({streetViewControl: true});}
	else {map.setOptions({streetViewControl: false});}
	$this->options_js
}

function show_gmap_marker(map, latlng, centerLatitude, centerLongitude, description) {
    var desc = description;
    if (desc=='') desc = '('+centerLatitude+', '+centerLongitude+')';
    var title_desc = desc.replace(/<br \/>/g, ' ');
    title_desc = title_desc.replace(/~/g, '');
    var marker = new google.maps.Marker({
        position:latlng,
        map:map,
        title:title_desc
    });
    var infowindow = new google.maps.InfoWindow({content:desc.replace(/~/g, '<br />')});
    google.maps.event.addListener(marker, 'click', function() {infowindow.open(map, marker);});
}

-->
</script>
";
		return $js;
	}

	function setup_css() {
		$output = '';
		return $output;
	}

	function gmap_code() {
		$js = "\n<script type=\"text/javascript\">
<!--
function init_{$this->mod}_gmap(id, addr, centerLatitude, centerLongitude, startZoom, description, kml, control, maptype, show_marker, addoverview, addscale, addgoogle, streetview) {
    var map;
	if (addr!='') {
		var addr2 = addr.replace(/~/g, '');
		var latlng_RegExp = /(-?\d+\.\d+)\s*,\s*(-?\d+\.\d+)/;
		if (latlng_RegExp.test(addr2)) {
			var str = addr2.match(latlng_RegExp);
    		map = display_{$this->mod}_gmap(id, str[1], str[2], startZoom, description, kml, control, maptype, show_marker, addoverview, addscale, addgoogle, streetview);
		} else {
			var geocoder = new google.maps.Geocoder();
			geocoder.geocode( { 'address': addr2}, function(results, status) {
		      if (status == google.maps.GeocoderStatus.OK) {
		        if (description=='') description = addr;
		      	map = display_{$this->mod}_gmap(id, results[0].geometry.location.lat(), results[0].geometry.location.lng(), startZoom, description, kml, control, maptype, show_marker, addoverview, addscale, addgoogle, streetview);
		      } else {
		        alert('Google cannot decode your address: '+addr);
		      }
	   		});
	   	}
    } else {
    	map = display_{$this->mod}_gmap(id, centerLatitude, centerLongitude, startZoom, description, kml, control, maptype, show_marker, addoverview, addscale, addgoogle, streetview);
    }
}

-->
</script>
";

		return $js;
	}

}

class Plugin_googleMaps extends Plugin_googleMaps_base {

	function Plugin_googleMaps( &$row, $pluginParams, $is_mod=0 ) {
		$this->mod = 'gmap';
		$this->tag = 'googleMaps';
		$this->addoverview = 1;
		$this->addgoogle = 1;
		$this->init_google_maps($row, $pluginParams, $is_mod);
	}

	function output_map(&$row, $matches, $map_id) {
		if (preg_match('/(\d+)%/', $this->width, $matches3)) {
			if ($matches3[1]<1 || $matches3[1]>100) $this->width = '100%';
		} elseif ($this->width<10 || $this->width>4096) $this->width = 640;
		#if ($lat!='' && $long!='')
		if (preg_match('/%/', $this->width)) $width2 = $this->width;
		else $width2 =  $this->width.'px';

		#print "w3c($map_id) = $this->w3c<br />";
		$output = '';
		if ($this->w3c) $output .= '</p>';
		$output .= "\n<div id=\"{$this->mod}_gmap{$map_id}\" style=\"width: {$width2}; height: {$this->height}px;\"></div>\n";
		$output .= "<div style=\"width: {$width2};\"><p align=\"right\" style=\"padding:0 0 0 0;margin:0 0 0 0\"><a href=\"http://www.kksou.com/php-gtk2/Joomla-Gadgets/googleMaps-plugin.php\" style=\"color:#aaa;text-decoration: none;font-family:Tahoma, Arial, Helvetica, sans-serif;font-size:7pt;font-weight: normal;\">Powered by JoomlaGadgets</a></p></div>\n";
		if ($this->w3c) $output .= '<p>';
		$row->text = str_replace($matches[0], $output, $row->text);

		$js = "init_{$this->mod}_gmap('$map_id', '$this->addr', $this->lat, $this->long, $this->startzoom, '$this->description', '$this->kml', '$this->control', '$this->maptype', $this->marker, '$this->addoverview', '$this->addscale', '$this->addgoogle', '$this->streetview');\n";

		return $js;
	}

	function setup_gmap() {
		$output = "\n\n<!-- \nPowered by Joomla Gadgets from kksou.com
http://www.kksou.com/php-gtk2/Joomla-Gadgets/googleMaps-plugin.php
-->\n\n";

		$lang = '';
		if ($this->lang!='') $lang = "&amp;hl=".$this->lang;
		#$output .= "\n<script src=\"http://maps.google.com/maps?file=api&amp;v=2&amp;key=$this->api_key".$lang."\" type=\"text/javascript\"></script>";
		$output .= "\n"."<script type=\"text/javascript\" src=\"http://maps.googleapis.com/maps/api/js?sensor=false&amp;language=".$this->lang.'"></script>';

		$output .= $this->gmap_code();
		return $output;
	}

}

?>
