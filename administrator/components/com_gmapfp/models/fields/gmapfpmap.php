<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.29
	* Creation date: Janvier 2013
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die();

class JFormFieldGMapFPMap extends JFormField
{
	public $type = 'GMapFPMap';

	protected function getInput()
	{
        $lang = JFactory::getLanguage(); 
        $tag_lang=(substr($lang->getTag(),0,2)); 
		
		$http = strstr(JUri::base(), '://', true);
		
return '
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<script src="'.$http.'://maps.googleapis.com/maps/api/js?sensor=true&language='.$tag_lang.'" type="text/javascript"></script>
		<script src="'.$http.'://www.google.com/jsapi" type="text/javascript"></script><noscript>JavaScript must be enabled in order for you to use Google Maps. However, it seems JavaScript is either disabled or not supported by your browser. To view Google Maps, enable JavaScript by changing your browser options, and then try again.</noscript>
		<fieldset style="height: 300px; width: 650px; overflow:hidden; " class="radio"><div id="map" style="height: 300px; width: 100%; overflow:hidden;"></div></fieldset>

		<script language="javascript" type="text/javascript">//<![CDATA[
			var map;
			var marker1;
		
			function init() {
				var lat, lng, zoom_carte;
				lat = document.adminForm.jform_gmapfp_centre_lat.value;
				lng = document.adminForm.jform_gmapfp_centre_lng.value;
				zoom_carte = parseInt(document.adminForm.jform_gmapfp_zoom.value);
		
				var latlng = new google.maps.LatLng(lat, lng);
				var myOptions = {
				  zoom: zoom_carte,
				  center: latlng,
				  mapTypeId: google.maps.MapTypeId.ROADMAP
				};
		
				map = new google.maps.Map(document.getElementById("map"), myOptions);
		
			  google.maps.event.addListener(map, "bounds_changed", function() {
				   document.adminForm.paramsgmapfp_zoom.value = map.getZoom();
			  });
			  // Create a draggable marker which will later on be binded to a
			  marker1 = new google.maps.Marker({
				  map: map,
				  position: new google.maps.LatLng(lat, lng),
				  draggable: true,
				  title: "Drag me!"
			  });
			  google.maps.event.addListener(marker1, "drag", function() {
				document.adminForm.jform_gmapfp_centre_lat.value = marker1.getPosition().lat();
				document.adminForm.jform_gmapfp_centre_lng.value = marker1.getPosition().lng();
			  });
			}
		
			// Register an event listener to fire when the page finishes loading.
			//google.maps.event.addDomListener(window, "load", init);
			google.setOnLoadCallback(initialize);

			var tstGMapFP = document.getElementById("map");
			var tstIntGMapFP;
			
			function CheckGMapFP() {
				if (tstGMapFP) {
					if (tstGMapFP.offsetWidth != tstGMapFP.getAttribute("oldValue")) {
						tstGMapFP.setAttribute("oldValue",tstGMapFP.offsetWidth);
						init();
					}
				}
			}
			
			function initialize() {
			   tstGMapFP.setAttribute("oldValue",0);
			   tstIntGMapFP = setInterval("CheckGMapFP()",500);
			}
		 
		//]]></script>
';

	}
}

?>