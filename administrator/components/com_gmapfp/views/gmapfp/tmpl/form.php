<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.13
	* Creation date: Mars 2012
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die('Restricted access');

$editor = &JFactory::getEditor();
$config = &JComponentHelper::getParams('com_gmapfp'); 
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');

$_lat = $this->config->get('gmapfp_centre_lat');
$_lng = $this->config->get('gmapfp_centre_lng');
$_zoom = $this->config->get('gmapfp_zoom');
if (empty($_lat)) {$_lat = 47.927385663;};
if (empty($_lng)) {$_lng = 2.1437072753;};
if (empty($_zoom)) {$_zoom = 10;};

?>
<link rel="stylesheet" href="components/com_gmapfp/views/general.css" type="text/css" /> 

<script type="text/javascript">
	Joomla.submitbutton = function(task) {
		if (task == 'cancel') {
			submitform(task);		
			return;
		}

		<?php
			echo $editor->save( 'text_message' )."\n";
			echo $editor->save( 'text_horaires_prix' )."\n";
		?>
		if (document.formvalidator.isValid(document.id('item-form'))) {
			submitform(task);
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
			return false;
		}
	}
</script>

<script language="javascript" type="text/javascript">
    var geocoder;
    var map;
    var marker1;

    function init() {
		UpdateAddress();
		geocoder = new google.maps.Geocoder();
        
		var lat, lng, zoom_carte;
        if(document.adminForm.glat.value!=0) lat = document.adminForm.glat.value;
        else lat = <?php echo $_lat?>;
        if(document.adminForm.glng.value!=0) lng = document.adminForm.glng.value;
        else lng = <?php echo $_lng?>;
        if(document.adminForm.gzoom.value!=0) zoom_carte = parseInt(document.adminForm.gzoom.value);
        else zoom_carte = <?php echo $_zoom?>;

		var latlng = new google.maps.LatLng(lat, lng);
		var myOptions = {
		  zoom: zoom_carte,
		  center: latlng,
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		};

		map = new google.maps.Map(document.getElementById("map"), myOptions);

	  google.maps.event.addListener(map, "bounds_changed", function() {
		   document.adminForm.gzoom.value = map.getZoom();
	  });

      // Create a draggable marker which will later on be binded to a
      marker1 = new google.maps.Marker({
          map: map,
          position: new google.maps.LatLng(lat, lng),
          draggable: true,
          title: 'Drag me!'
      });
	  google.maps.event.addListener(marker1, "drag", function() {
		document.adminForm.glat.value = marker1.getPosition().lat();
		document.adminForm.glng.value = marker1.getPosition().lng();
	  });
    }

    // Register an event listener to fire when the page finishes loading.
    google.maps.event.addDomListener(window, 'load', init);
 
  
    function showAddress() {
		var address = document.adminForm.localisation.value;
		if (geocoder) {
			geocoder.geocode( { 'address' : address}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
				  map.setCenter(results[0].geometry.location);
				  marker1.setPosition(results[0].geometry.location); 
					document.adminForm.glat.value = results[0].geometry.location.lat();
					document.adminForm.glng.value = results[0].geometry.location.lng();
				} else {
				  alert(address + " not found for the following reason: " + status);
				}
			})
		}
    }

    function getCoordinate() {
		var lat, lng;
        if(document.adminForm.glat.value!=0) lat = document.adminForm.glat.value;
        else lat = <?php echo $_lat?>;
        if(document.adminForm.glng.value!=0) lng = document.adminForm.glng.value;
        else lng = <?php echo $_lng?>;
        if(document.adminForm.gzoom.value!=0) zoom_carte = parseInt(document.adminForm.gzoom.value);
        else zoom = <?php echo $_zoom?>;

		var latlng = new google.maps.LatLng(lat, lng);
		map.setZoom(zoom_carte);
		map.setCenter(latlng);
		marker1.setPosition(latlng); 
    }
	
	function changeDisplayImage(chemin) {
		if (document.adminForm.img.value !='') {
			document.adminForm.imagelib.src=chemin + document.adminForm.img.value;
		} else {
			document.adminForm.imagelib.src=chemin+'blank.png';
		}
	}

	function changeDisplayIcon(chemin) {
		if (document.adminForm.icon.value !='') {
			document.adminForm.imageicon.src='templates/bluestork/images/header/' + document.adminForm.icon.value;
		} else {
			document.adminForm.imageicon.src='<?php echo JURI::root().$this->config->get('gmapfp_chemin_img')?>'+'blank.png';
		}
	}

    function addphoto(file, indice){
        var optX = new Option(file, file);
        var selX = document.forms[0].elements['img'];
        var lenghX = selX.length;
        selX.options[lenghX] = optX;
                selX.options[lenghX].selected = true;
    }

	function jSelectArticle(id, title, object) {
		document.getElementById(object + '_id').value = id;
		document.getElementById(object + '_name').value = title;
		document.getElementById('sbox-window').close();
	}

	function UpdateAddress(){
 		document.adminForm.localisation.value = document.adminForm.adresse.value + " " + document.adminForm.adresse2.value + " " + document.adminForm.codepostal.value + " " + document.adminForm.ville.value + " " + document.adminForm.departement.value + ", " + document.adminForm.pay.value;	
	}

	function IsReal(id){
		MonNombre=document.getElementById(id).value;
		if(isNaN(MonNombre))
		{
			alert("\"" + MonNombre + "\" <?php echo JText::_( 'GMAPFP_PAS_NOMBRE' ); ?>");
			return false;
		}	
		return true;
	}

	function jSelectArticle(id, title, catid, object) {
		document.getElementById('id_id').value = id;
		document.getElementById('id_name').value = title;
		SqueezeBox.close();
	}

</script>

<form action="index.php" method="post" name="adminForm" id="item-form" class="gmapfp form-validate">
<div>
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'GMAPFP_DETAILS' ); ?></legend>
	<table class="admintable">
		<tr>
			<td width="110" class="key">
				<label for="title">
					<?php echo JText::_( 'GMAPFP_NOM' ); ?>:<span class="star">&nbsp;*</span>
				</label>
			</td>
			<td>
				<input class="inputbox required" type="text" name="nom" id="nom" size="60" value="<?php echo str_replace('"', '&quot;',$this->gmapfp->nom); ?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="alias">
					<?php echo JText::_( 'Alias' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="alias" id="alias" size="32" maxlength="250" value="<?php echo $this->gmapfp->alias;?>" />
			</td>
		</tr>
		<tr>
			<td width="110" class="key">
				<label>
					<?php echo JText::_( 'JCATEGORY' ); ?>:<span class="star">&nbsp;*</span>
                </label>
			</td>
			<td>
				<?php
					echo $this->lists['catid'];
				?>
			</td>
			</tr>
		<tr>
			<td width="110" class="key">
				<label for="alias">
					<?php echo JText::_( 'GMAPFP_ADRESSE' ); ?> 1:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="adresse" id="adresse" onchange="UpdateAddress();" size="60" value="<?php echo str_replace('"', '&quot;',$this->gmapfp->adresse); ?>" />
			</td>
		</tr>
		<tr>
			<td width="110" class="key">
				<label for="alias">
					<?php echo JText::_( 'GMAPFP_ADRESSE' ); ?> 2:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="adresse2" id="adresse2" onchange="UpdateAddress();" size="60" value="<?php echo str_replace('"', '&quot;',$this->gmapfp->adresse2); ?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<label for="lag">
					<?php echo JText::_( 'GMAPFP_CODEPOSTAL' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="codepostal" id="codepostal" onchange="UpdateAddress();" size="60" value="<?php echo str_replace('"', '&quot;',$this->gmapfp->codepostal); ?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<label for="lag">
					<?php echo JText::_( 'GMAPFP_VILLE' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="ville" id="ville" onchange="UpdateAddress();" size="60" value="<?php echo str_replace('"', '&quot;',$this->gmapfp->ville); ?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<label for="lag">
					<?php echo JText::_( 'GMAPFP_DEPARTEMENT' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="departement" id="departement" onchange="UpdateAddress();" size="60" value="<?php echo str_replace('"', '&quot;',$this->gmapfp->departement); ?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<label for="lag">
					<?php echo JText::_( 'GMAPFP_PAYS' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="pay" id="pay" onchange="UpdateAddress();" size="60" value="<?php echo str_replace('"', '&quot;',$this->gmapfp->pay); ?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<label for="lag">
					<?php echo JText::_( 'GMAPFP_TEL' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="tel" id="tel" size="60" value="<?php echo str_replace('"', '&quot;',$this->gmapfp->tel); ?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<label for="lag">
					<?php echo JText::_( 'GMAPFP_TEL2' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="tel2" id="tel2" size="60" value="<?php echo str_replace('"', '&quot;',$this->gmapfp->tel2); ?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<label for="lag">
					<?php echo JText::_( 'GMAPFP_FAX' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="fax" id="fax" size="60" value="<?php echo str_replace('"', '&quot;',$this->gmapfp->fax); ?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<label for="lag">
					<?php echo JText::_( 'GMAPFP_EMAIL' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="email" id="email" size="60" value="<?php echo str_replace('"', '&quot;',$this->gmapfp->email); ?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<label for="lag">
					<?php echo JText::_( 'GMAPFP_SITE_WEB' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="web" id="web" size="60" value="<?php echo str_replace('"', '&quot;',$this->gmapfp->web); ?>" />
			</td>
		</tr>
        <tr>
            <td width="110" class="key">
            	<label for="title">       
            		<?php echo JText::_('GMAPFP_MAJ_ADRESSE'); ?>:
            	</label>
            </td>
            <td valign="top">
            	<input type="text" style="width:70%" name="localisation" value="" /><input type="button" onclick="showAddress();" value="<?php echo JText::_('GMAPFP_CHERCHER'); ?>" />
            </td>
		</tr>
        <tr>
            <td width="110" class="key">
            	<label for="title">
                	<?php echo JText::_('GMAPFP_LAT'); ?> - <?php echo JText::_('GMAPFP_LON'); ?> - Zoom:
              	</label>
            </td>
            <td valign="top">
                <input class="inputbox validate-numeric" onblur="IsReal('glat');" type="text" name="glat" id="glat" size="20" value="<?php echo $this->gmapfp->glat ?>" />
                <input class="inputbox validate-numeric" onblur="IsReal('glng');" type="text" name="glng" id="glng" size="20" value="<?php echo $this->gmapfp->glng ?>" />
                <input class="inputbox validate-numeric" onblur="IsReal('gzoom');" type="text" name="gzoom" id="gzoom" size="2" value="<?php echo $this->gmapfp->gzoom ?>" />
                <input type="button" onclick="getCoordinate();" value="<?php echo JText::_('GMAPFP_CHERCHER_COORDONNEES'); ?>" />
            </td>
    	</tr>
        <tr>
            <td width="100" align="right" class="key">
              	<label for="title">
              		<?php echo JText::_('GMAPFP_CARTE'); ?>:
              	</label>
            </td>
            <td>
            	<div id="map" style="width: 600px; height: 500px; overflow:hidden;"></div>
            </td>
        </tr>
        <tr>
            <td width="30%" class="key">
              	<label for="title">
              		<?php echo JText::_('GMAPFP_IMAGE'); ?>:
              	</label>
            </td>
            <td valign="center"">
            	<div id="gmapfp_image" style="overflow:auto;">
            	<?php 
                    $directory		= JURI::root().$this->config->get('gmapfp_chemin_img');
					$javascript		= 'onchange="changeDisplayImage('."'".$directory."'".');"';

					if ((stristr($this->gmapfp->img,'bmp'))||(stristr($this->gmapfp->img,'gif'))||(stristr($this->gmapfp->img,'jpg'))||(stristr($this->gmapfp->img,'jpeg'))||(stristr($this->gmapfp->img,'png'))) {
						?>
						<img src="<?php echo $directory.$this->gmapfp->img; ?>" name="imagelib"/>
						<?php
					} else {
						?>
						<img src="<?php echo $directory; ?>/blank.png" name="imagelib"/>
						<?php
					}
                    echo '</div>';
					echo '<div>';
					echo $chemin	= $this->config->get('gmapfp_chemin_img');
					echo $lists		= JHTML::_('list.images', 'img', $this->gmapfp->img, $javascript, $chemin, "bmp|gif|jpg|jpeg|png"  );
				?>
            		<br /><a style="cursor:pointer; font-size: 150%" onclick="popupWindow('index.php?option=com_gmapfp&controller=gmapfp&tmpl=component&task=edit_upload','win1',420,120,'no');" class="toolbar"><span class="icon-32-upload" style="height:32px; width:32px; display:block; clear: both;">&nbsp;</span> <?php echo JText::_('GMAPFP_UPLOAD') ?></a></div>
            </td>
     	</tr>
		<tr>
			<td class="key">
				<label for="title">
					<?php echo JText::_( 'GMAPFP_ALBUM' ); ?>:
				</label>
			</td>
			<td>
				<?php if ($this->gmapfp->album == '1') { $checked = 'checked="checked"'; }else{ $checked = ''; }; ?>
				<input class="inputbox" type="checkbox" name="album" id="album" value="1" <?php echo $checked ?> />
			</td>
		</tr>
    	<tr>
            <td width="110" class="key">
            	<label for="title">
            	<?php echo JText::_( 'GMAPFP_MESSAGE' ); ?>:
            	</label>
            </td>
        	<td valign="top" class="inputbox">
            	<?php
				echo $editor->display( 'text_message', htmlspecialchars($this->gmapfp->text, ENT_COMPAT, 'UTF-8'), '100%', '300', '75', '20', true, 'text_message');
				?>
        	</td>
		</tr>
    	<tr>
            <td width="110" class="key">
            	<label for="title">
            	<?php echo JText::_( 'GMAPFP_HORAIRES_PRIX' ); ?>:
            	</label>
            </td>
        	<td valign="top" class="inputbox">
            	<?php
				echo $editor->display( 'text_horaires_prix', htmlspecialchars($this->gmapfp->horaires_prix, ENT_COMPAT, 'UTF-8'), '100%', '200', '75', '20', false,'text_horaires_prix');
				?>
        	</td>
		</tr>
		<tr>
			<td width="100" class="key">
				<label for="marker"><?php echo JText::_( 'GMAPFP_MARKER' ); ?>:</label>
			</td>
			<td>
				<table>
					<tr>
					<?php 
						$cnt = 0;
						foreach($this->marqueurs as $marqueur) {
							$checked = '';
							if (($this->gmapfp->marqueur == $marqueur->url) || (empty($this->gmapfp->marqueur) && $marqueur->id == '1')) { $checked = 'checked="checked"'; }
							echo '<td width="40" align="center" valign="top" style="border:1px solid #eeeeee"><img src="'.$marqueur->url.'" title="'.$marqueur->nom.'" /><br /><input type="radio" name="marqueur" id="marqueur" value="'.$marqueur->url.'" '.$checked.' /></td>';
							if ($cnt < 15) {
								$cnt++;
							} else {
								echo '</tr><tr>';
								$cnt = 0;
							}
						}
					?>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td width="120" class="key">
				<?php echo JText::_( 'JPUBLISHED' ); ?>:
			</td>
			<td >
				<?php echo JHTML::_( 'select.booleanlist',  'published', 'class="inputbox"', $this->gmapfp->published ); ?>
			</td>
		</tr>
		<tr>
			<td valign="top" align="right" class="key">
				<label for="ordering">
					<?php echo JText::_( 'Ordering' ); ?>:
				</label>
			</td>
			<td>
				<?php echo $this->lists['ordering']; ?>
			</td>
		</tr>
		<tr>
			<td width="110" class="key">
				<label for="alias">
					<?php echo JText::_( 'JFIELD_META_DESCRIPTION_LABEL' ); ?>:
				</label>
			</td>
			<td>
				<textarea class="inputbox" name="metadesc" id="metadesc" cols="70" rows="4"><?php echo $this->gmapfp->metadesc; ?></textarea>
			</td>
		</tr>
		<tr>
			<td width="110" class="key">
				<label for="alias">
					<?php echo JText::_( 'JFIELD_META_KEYWORDS_LABEL' ); ?>:
				</label>
			</td>
			<td>
				<textarea class="inputbox" name="metakey" id="metakey" cols="70" rows="4"><?php echo $this->gmapfp->metakey; ?></textarea>
			</td>
		</tr>
		<tr>
			<td width="120" class="key">&nbsp;
				
			</td>
			<td style="text-align:left" class="key">
				<?php echo JText::_( 'GMAPFP_EXTERNE' ); ?>:
			</td>
		</tr>
		<tr>
			<td class="key">
				<label for="lag">
					<?php echo JText::_( 'GMAPFP_LINK' ); ?>:
				</label>
			</td>
			<td>
            	<div style="float: left;">
				<input class="inputbox" type="text" name="text_link" id="id_name" size="60" value="<?php echo str_replace('"', '&quot;',$this->gmapfp->link); ?>" />
                </div>
                <div class="button2-left">
                	<div class="blank">
                    	<a class="modal-button" title="<?php echo JText::_( 'GMAPFP_SELECT_ARTICLE' ); ?>"  href="index.php?option=com_content&amp;view=articles&amp;layout=modal&amp;tmpl=component" rel="{handler: 'iframe', size: {x: 770, y: 400}}"><?php echo JText::_( 'GMAPFP_SELECT_ARTICLE' ); ?></a>
                    </div>
                </div>
                <input type="hidden" id="id_id" name="article_id" value="<?php echo $this->gmapfp->article_id; ?>" />                
			</td>
		</tr>
        <tr>
            <td width="30%" class="key">
              	<label>
              		<?php echo JText::_('GMAPFP_ICON'); ?>:
              	</label>
            </td>
            <td valign="center"">
            	<?php 
					$path_icon = "administrator/templates/bluestork/images/header/";
					$javascript		= 'onchange="changeDisplayIcon('."'".$path_icon."'".');"';
					echo "<div>".$path_icon."</div>";
					echo $lists		= JHTML::_('list.images', 'icon', $this->gmapfp->icon, $javascript, $path_icon, "bmp|gif|jpg|jpeg|png"  );
					if ((stristr($this->gmapfp->icon,'bmp'))||(stristr($this->gmapfp->icon,'gif'))||(stristr($this->gmapfp->icon,'jpg'))||(stristr($this->gmapfp->icon,'jpeg'))||(stristr($this->gmapfp->icon,'png'))) {
						?>
						<img src="<?php echo JURI::root().$path_icon.$this->gmapfp->icon; ?>" name="imageicon" style="height:32px"/>
						<?php
					} else {
						?>
						<img src="<?php echo $directory; ?>blank.png" name="imageicon" style="height:32px"/>
						<?php
					}
				?>
            </td>
     	</tr>
		<tr>
			<td class="key">
				<label>
					<?php echo JText::_( 'GMAPFP_ICON_LABEL' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="icon_label" id="icon_label" size="60" value="<?php echo str_replace('"', '&quot;',$this->gmapfp->icon_label); ?>" />
			</td>
		</tr>
	</table>
	</fieldset>
</div>
<div class="clr"></div>
<div class="clr"></div>

<input type="hidden" name="userid" value="<?php echo $this->gmapfp->userid; ?>" />
<input type="hidden" name="option" value="com_gmapfp" />
<input type="hidden" name="id" value="<?php echo $this->gmapfp->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="gmapfp" />
</form>
<div class="copyright" align="center">
	<br />
	<?php echo JText::_( 'GMAPFP_COPYRIGHT' );?>
</div>
