<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
/**
* @title		Shape 5 Map it with google
* @version		2.0
* @package		Joomla
* @website		http://www.shape5.com
* @copyright	Copyright (C) 2009 Shape 5 LLC. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/


// no direct access

$text  = $params->get( 'text');
$sub1  = $params->get( 'zipp');
$naar =  $params->get( 'addresss');
$cols  = $params->get( 'cityy');
$rows  = $params->get( 'statee');
$s5mapitver  = $params->get( 's5mapitver');
$s5mapcontrol  = $params->get( 's5mapcontrol');
$s5miheight  = $params->get( 's5miheight');
$s5miwidth  = $params->get( 's5miwidth');
$zoomlev  = $params->get( 'zoomlev');
$LiveSiteUrl = JURI::root();
$getdirections  = $params->get( 'getdirections');


if ($text != "") { ?>
<span class="s5_map_pretext">
<?php echo "".$text.""; ?>
</span>
<?php }


?>
<?php if ($s5mapitver == "ver2") {  ?>		 
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script><script type="text/javascript">
//<![CDATA[
 var geocoder;
 var map;
 var address ="<?php echo $naar;?> <?php echo $cols;?> <?php echo $rows;?> <?php echo $sub1;?>";
 function JM_GMstartup() {
   geocoder = new google.maps.Geocoder();
   var latlng = new google.maps.LatLng(-34.397, 150.644);
   var myOptions = {
      zoom: <?php echo $zoomlev;?>,
     center: latlng,
  mapTypeControl: <?php if ($s5mapcontrol == "ena") {  ?>true,<?php }?> <?php if ($s5mapcontrol == "dis") {  ?>false,<?php }?>
mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
    navigationControl: true,
     mapTypeId: google.maps.MapTypeId.ROADMAP
   };
   
    map = new google.maps.Map(document.getElementById("s5_map_canvas"), myOptions);
    if (geocoder) {
      geocoder.geocode( { 'address': address}, function(results, status) {
       if (status == google.maps.GeocoderStatus.OK) {
         if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
map.setCenter(results[0].geometry.location);
            var infowindow = new google.maps.InfoWindow(
                { content: '<span class="s5_googlemapaddress" style="font-family:arial;font-size:11px;">'+address+' <br/><br/><a href="http://maps.google.com/maps?saddr=&daddr='+address+'" target ="_blank" style="padding:2px 5px 2px 5px;" class="button"><?php echo $getdirections;?></a></span>',
                  size: new google.maps.Size(150,50) }
				  );
				  
			var image = new google.maps.MarkerImage(' <?php echo $LiveSiteUrl;?>/modules/mod_S5MapIt/images/tack.png',
			  // This marker is 20 pixels wide by 32 pixels tall.
			  new google.maps.Size(48, 48),
			  // The origin for this image is 0,0.
			  new google.maps.Point(0,0),
			  // The anchor for this image is the base of the flagpole at 0,32.
			  new google.maps.Point(10, 40));
			  
			  
            var marker = new google.maps.Marker({
                position: results[0].geometry.location,
				icon: image,
                map: map, 
                title:address }); 
					
				google.maps.event.addListener(marker, 'click', function() { 
			
                infowindow.open(map,marker); 
			

				}); 
          } else { alert("No results found"); } 
        } else { alert("Geocode was not successful for the following reason: " + status);}  });   }  }       	    

	function jm_mapload() {JM_GMstartup();} 
	window.setTimeout(jm_mapload,100);
//]]>	
</script> 


<div id="s5_map_canvas" class="s5_mapdisplay" style="width:<?php echo $s5miwidth;?>px;height:<?php echo $s5miheight;?>px"></div>
<?php } ?>

<?php if ($s5mapitver == "ver1") {  ?>		 
<br /><br/>
<!-- Form -->
<div style="width:50%;">
<form name="form1" action="">

<div style="width:20%;">Address:
<input class="inputbox" type="text" name="saddr" /></div>

<div style="width:20%;">City:
<input class="inputbox" type="text" name="saddr2" /></div>

<div style="width:8%;">State:
<input class="inputbox" type="text" name="saddr22" /></div>

<div style="width:12%;">Zip:
<input class="inputbox" type="text" name="saddr222" /></div>

<br/>
<div style="width:20%;margin-top:5px;">
<input class="button" type="submit" value="Submit" name="checkit" onclick="javascript:GetDirections();return false;"/>
</div>
</form>
<br/>
<script type="text/javascript">	
<!-- 
		function GetDirections()
		{				
			var SourceAdress = 'saddr=';
			var DestinationAddress = 'daddr=' + '<?php echo $naar; ?>' + ', ' + '<?php echo $cols; ?>' + ', ' + '<?php echo $rows; ?>' + ' ' + '<?php echo $sub1; ?>'; //destination address pulled from admin
			var Url = '';

			//read out source adress from the input field
			SourceAdress += document.form1.saddr.value + ',' + document.form1.saddr2.value + ',' + document.form1.saddr22.value + ',' + document.form1.saddr222.value;	
			//form the url 
			Url = 'http://maps.google.com/maps?' + SourceAdress + '&' + DestinationAddress; // + ',output,html';	
			
				//you can use the line below to show the directions in a popup window, don;t forget to comment out the line above... 
			window.open(Url,'directions','width=1024,height=768,scrollbars=yes,toolbar=no,location=no, resizable=no'); 			
		}
//-->  
	</script>
</div>
<?php } ?>

