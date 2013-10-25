<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.15
	* Creation date: Avril 2012
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.formvalidation');

$Itemid    = JRequest::getInt('Itemid');

$editor = &JFactory::getEditor();

$image = '&nbsp;&nbsp;&nbsp;<img src="components/com_gmapfp/images/switch_f2.png" height="16px" title="'.JText::_( 'GMAPFP_OBLIGATOIRE' ).'" >';

$_lat = $this->params->get('gmapfp_centre_lat');
$_lng = $this->params->get('gmapfp_centre_lng');
$_zoom = $this->params->get('gmapfp_zoom');
if (empty($_lat)) {$_lat = 47.927385663;};
if (empty($_lng)) {$_lng = 2.1437072753;};
if (empty($_zoom)) {$_zoom = 10;};

?>
<script language="javascript" type="text/javascript">

	function validateForm( frm ) {
		<?php 
		if (!GMAPFP_ANDROID){
				echo $editor->save( 'text_message' )."\n";
				echo $editor->save( 'text_horaires_prix' )."\n";
		}?>
		var valid = document.formvalidator.isValid(frm);
		if (valid == false) {
			var msg = '<?php echo JText::_( 'GMAPFP_NON_OK' ); ?>';
			alert(msg);
			document.adminForm.upform.disabled=false;
			return false;
		} else {
			//submitform("submit");
			frm.task.value = "submit";
			frm.submit();
			return true;
		}
	}
	
    var geocoder;
    var map;
    var marker1;

    function init() {
		//redimensionne la lageur des editeurs
		if (window.addEventListener){
		 window.addEventListener("resize",resize,false);}  
		else if (window.attachEvent){
		 window.attachEvent("onresize",resize);
		}
		resize();
		
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

	function resize(){
		//Ajustement des fenêtres d'éditeur		   
		var maDivForm = document.getElementById("gmapfp_submit");
		var maDivTitre = document.getElementById("gmapfp_titres");
		var maTaille = ''+(maDivForm.offsetWidth-maDivTitre.offsetWidth-30)+'px';
		var maDivEdit1 = document.getElementById("Edit1");
		maDivEdit1.style.width = maTaille;
		var maDivEdit2 = document.getElementById("Edit2");
		maDivEdit2.style.width = maTaille;
		var maDivImage = document.getElementById("gmapfp_image");
		maDivImage.style.width = maTaille;
		<?php if (($this->params->get('gmapfp_submit_mess'))&&(!GMAPFP_ANDROID)){?>
		var maDivTextMessage = document.getElementById("text_message");
		maDivTextMessage.className = maDivTextMessage.className + " required";
		<?php }?>
		<?php if (($this->params->get('gmapfp_submit_prix'))&&(!GMAPFP_ANDROID)){?>
		var maDivTextHoraire = document.getElementById("text_horaires_prix");
		maDivTextHoraire.className = maDivTextHoraire.className + " required";
		<?php }?>

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
			document.adminForm.imagelib.src='images/blank.png';
		}
	}

    function addphoto(file){
        var optX = new Option(file, file);
        var selX = document.adminForm.elements['img'];
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

</script>

<p>
<?php echo $this->params->get('intro'); ?>
</p>

<form action="index.php?option=com_gmapfp&view=editlieux&layout=soumission&controller=editlieux&task=soumission&Itemid=<?php echo $Itemid; ?>" method="post" name="adminForm" onsubmit="document.adminForm.upform.disabled=true;return validateForm(this);">
<div id="gmapfp_submit">
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'GMAPFP_DETAILS' ); ?></legend>
	<table class="admintable">
		<tr>
			<td width="20%" id="gmapfp_titres" class="key">
				<label for="nom">
					<?php 
                        if (@$this->custom[6]->nom) {
                            echo $this->custom[6]->nom.$image;
                        }else{
                            echo JText::_( 'GMAPFP_NOM' ).$image;
                        }
                    ?>
				</label>
			</td>
			<td>
				<input class="inputbox required" type="text" name="nom" id="nom" size="60" maxlength="200" value="<?php echo str_replace('"', '&quot;',$this->items->nom); ?>" />
			</td>
		</tr>
		<?php if($this->params->get('choix_categorie')) { ?>
		<tr>
			<td width="20%" class="key">
				<label for="catid">
					<?php 
                    echo JText::_( 'JCATEGORY' ).$image;;
                    ?>
                </label>
			</td>
			<td>
				<?php
					echo $this->lists['catid'];
				?>
			</td>
		</tr>
		<?php }else{ 
			if (!$this->params->get('catid')) {
				echo '<script language="javascript" type="text/javascript">
					alert("'.JText::_( 'GMAPFP_CAT_DANS_MENU' ).'")
					</script>';
			}else{
				echo '<input type="hidden" name="catid" value="'.$this->params->get('catid').'" />';
				//$this->items->catid=$this->params->get('catid');
			};
		}; ?>
		<tr <?php if (@$this->params->get('choix_adr1')){echo 'style="display: none; visibility: hidden;"';}?>>
			<td width="20%" class="key">
				<label for="adresse">
					<?php echo JText::_( 'GMAPFP_ADRESSE' ); ?> 1
					<?php if ($this->params->get('gmapfp_submit_adr1')){echo $image;} ?>
				</label>
			</td>
			<td>
				<input class="inputbox <?php if ($this->params->get('gmapfp_submit_adr1')){echo 'required';} ?>" type="text" name="adresse" id="adresse" onchange="UpdateAddress();" size="60" maxlength="200" value="<?php echo str_replace('"', '&quot;',$this->items->adresse); ?>" />
			</td>
		</tr>
		<tr <?php if (@$this->params->get('choix_adr2')){echo 'style="display: none; visibility: hidden;"';}?>>
			<td width="20%" class="key">
				<label for="adresse2">
					<?php echo JText::_( 'GMAPFP_ADRESSE' ); ?> 2
					<?php if ($this->params->get('gmapfp_submit_adr2')){echo $image;} ?>
				</label>
			</td>
			<td>
				<input class="inputbox <?php if ($this->params->get('gmapfp_submit_adr2')){echo 'required';} ?>" type="text" name="adresse2" id="adresse2" onchange="UpdateAddress();" size="60" maxlength="200" value="<?php echo str_replace('"', '&quot;',$this->items->adresse2); ?>" />
			</td>
		</tr>
		<tr <?php if (@$this->params->get('choix_cp')){echo 'style="display: none; visibility: hidden;"';}?>>
			<td class="key">
				<label for="codepostal">
					<?php echo JText::_( 'GMAPFP_CODEPOSTAL' );
					if ($this->params->get('gmapfp_submit_cp')){echo $image;} ?>
				</label>
			</td>
			<td>
				<input class="inputbox <?php if ($this->params->get('gmapfp_submit_cp')){echo 'required';} ?>" type="text" name="codepostal" id="codepostal" onchange="UpdateAddress();" size="60" maxlength="80" value="<?php echo str_replace('"', '&quot;',$this->items->codepostal); ?>" />
			</td>
		</tr>
		<tr <?php if (@$this->params->get('choix_ville')){echo 'style="display: none; visibility: hidden;"';}?>>
			<td class="key">
				<label for="ville">
					<?php echo JText::_( 'GMAPFP_VILLE' );
					if ($this->params->get('gmapfp_submit_ville')){echo $image;} ?>
				</label>
			</td>
			<td>
				<input class="inputbox <?php if ($this->params->get('gmapfp_submit_ville')){echo 'required';} ?>" type="text" name="ville" id="ville" onchange="UpdateAddress();" size="60" maxlength="200" value="<?php echo str_replace('"', '&quot;',$this->items->ville); ?>" />
			</td>
		</tr>
		<tr <?php if (@$this->params->get('choix_dep')){echo 'style="display: none; visibility: hidden;"';}?>>
			<td class="key">
				<label for="departement">
					<?php echo JText::_( 'GMAPFP_DEPARTEMENT' );
					if ($this->params->get('gmapfp_submit_departement')){echo $image;} ?>
				</label>
			</td>
			<td>
				<input class="inputbox <?php if ($this->params->get('gmapfp_submit_departement')){echo 'required';} ?>" type="text" name="departement" id="departement" maxlength="200" onchange="UpdateAddress();" size="60" value="<?php echo str_replace('"', '&quot;',$this->items->departement); ?>" />
			</td>
		</tr>
		<tr <?php if (@$this->params->get('choix_pays')){echo 'style="display: none; visibility: hidden;"';}?>>
			<td class="key">
				<label for="pay">
					<?php echo JText::_( 'GMAPFP_PAYS' );
					if ($this->params->get('gmapfp_submit_pays')){echo $image;} ?>
				</label>
			</td>
			<td>
				<input class="inputbox <?php if ($this->params->get('gmapfp_submit_pays')){echo 'required';} ?>" type="text" name="pay" id="pay" onchange="UpdateAddress();" size="60" maxlength="200" value="<?php echo str_replace('"', '&quot;',$this->items->pay); ?>" />
			</td>
		</tr>
		<tr <?php if (@$this->params->get('choix_tel1')){echo 'style="display: none; visibility: hidden;"';}?>>
			<td class="key">
				<label for="tel">
					<?php 
                        echo JText::_( 'GMAPFP_TEL' );
						if ($this->params->get('gmapfp_submit_phone1')){echo $image;} 
					?>
				</label>
			</td>
			<td>
				<input class="inputbox <?php if ($this->params->get('gmapfp_submit_phone1')){echo 'required';} ?>" type="text" name="tel" id="tel" size="60" maxlength="30" value="<?php echo str_replace('"', '&quot;',$this->items->tel); ?>" />
			</td>
		</tr>
		<tr <?php if (@$this->params->get('choix_tel2')){echo 'style="display: none; visibility: hidden;"';}?>>
			<td class="key">
				<label for="tel2">
					<?php 
                        echo JText::_( 'GMAPFP_TEL2' );
                    ?>
					<?php if ($this->params->get('gmapfp_submit_phone2')){echo $image;} ?>
				</label>
			</td>
			<td>
				<input class="inputbox <?php if ($this->params->get('gmapfp_submit_phone2')){echo 'required';} ?>" type="text" name="tel2" id="tel2" size="60" maxlength="30" value="<?php echo str_replace('"', '&quot;',$this->items->tel2); ?>" />
			</td>
		</tr>
		<tr <?php if (@$this->params->get('choix_fax')){echo 'style="display: none; visibility: hidden;"';}?>>
			<td class="key">
				<label for="fax">
					<?php 
                        echo JText::_( 'GMAPFP_FAX' );
                    ?>
					<?php if ($this->params->get('gmapfp_submit_fax')){echo $image;} ?>
				</label>
			</td>
			<td>
				<input class="inputbox <?php if ($this->params->get('gmapfp_submit_fax')){echo 'required';} ?>" type="text" name="fax" id="fax" size="60" maxlength="20" value="<?php echo str_replace('"', '&quot;',$this->items->fax); ?>" />
			</td>
		</tr>
		<tr <?php if (@$this->params->get('choix_email')){echo 'style="display: none; visibility: hidden;"';}?>>
			<td class="key">
				<label for="email">
					<?php echo JText::_( 'GMAPFP_EMAIL' );
					if ($this->params->get('gmapfp_submit_email')){echo $image;} ?>
				</label>
			</td>
			<td>
				<input class="inputbox <?php if ($this->params->get('gmapfp_submit_email')){echo 'required validate-email';} ?>" type="text" name="email" id="email" size="60" maxlength="100" value="<?php echo str_replace('"', '&quot;',$this->items->email); ?>" />
			</td>
		</tr>
		<tr <?php if (@$this->params->get('choix_web')){echo 'style="display: none; visibility: hidden;"';}?>>
			<td class="key">
				<label for="web">
					<?php echo JText::_( 'GMAPFP_SITE_WEB' );
					if ($this->params->get('gmapfp_submit_web')){echo $image;} ?>
				</label>
			</td>
			<td>
				<input class="inputbox <?php if ($this->params->get('gmapfp_submit_web')){echo 'required';} ?>" type="text" name="web" id="web" size="60" maxlength="200" value="<?php echo str_replace('"', '&quot;',$this->items->web); ?>" />
			</td>
		</tr>
        <tr>
            <td width="20%" class="key">
            	<label for="localisation">       
            		<?php echo JText::_('GMAPFP_MAJ_ADRESSE'); ?>
            	</label>
            </td>
            <td valign="top">
            	<input type="text" style="width:90%" name="localisation" value="" /><input type="button" class="button" onclick="showAddress();" value="<?php echo JText::_('GMAPFP_RECHERCHER'); ?>" />
            </td>
		</tr>
        <tr <?php if (@$this->params->get('choix_lat_lng')){echo 'style="display: none; visibility: hidden;"';}?>>
            <td width="20%" class="key">
            	<label for="glng">
                	<?php echo JText::_('GMAPFP_LAT'); ?> - <?php echo JText::_('GMAPFP_LON'); ?> - Zoom:
					<?php if ($this->params->get('gmapfp_submit_lat_lng')){echo $image;} ?>
              	</label>
            </td>
            <td valign="top">
                <input class="inputbox <?php if ($this->params->get('gmapfp_submit_lat_lng')){echo 'required';} ?>" type="text" name="glat" id="glat" size="12" maxlength="12" value="<?php echo $this->items->glat ?>" />
                <input class="inputbox <?php if ($this->params->get('gmapfp_submit_lat_lng')){echo 'required';} ?>" type="text" name="glng" id="glng" size="12" maxlength="12" value="<?php echo $this->items->glng ?>" />
                <input class="inputbox" type="text" name="gzoom" id="gzoom" size="2" maxlength="2" value="<?php echo $this->items->gzoom ?>" />
                <input type="button" class="button" onclick="getCoordinate();" value="<?php echo JText::_('GMAPFP_CHERCHER_COORDONNEES'); ?>" />
            </td>
    	</tr>
        <tr>
            <td width="20%" align="right" class="key">
              	<label>
              		<?php echo JText::_('GMAPFP_CARTE'); ?>
              	</label>
            </td>
            <td>
            	<div id="map" style="width:100%; height:<?php echo $this->params->get('gmapfp_height');?>px; overflow:hidden;"></div>
            </td>
        </tr>
        <tr>
            <td width="20%" class="key">
              	<label for="imagelib">
              		<?php echo JText::_('GMAPFP_IMAGE');?>
              	</label>
            </td>
            <td valign="center">           	
            	<div id="gmapfp_image" style="overflow:auto;">
            	<?php 
                    $directory		= JURI::base().$this->params->get('gmapfp_chemin_img');
					$javascript		= 'onchange="changeDisplayImage('."'".$directory."'".');"';

					if ((stristr($this->items->img,'bmp'))||(stristr($this->items->img,'gif'))||(stristr($this->items->img,'jpg'))||(stristr($this->items->img,'jpeg'))||(stristr($this->items->img,'png'))) {
						?>
                            <img src="<?php echo $directory.$this->items->img; ?>" name="imagelib" />
                            &nbsp;<br /><br />
						<?php
					} else {
						?>
						<img src="components/com_gmapfp/images/blank.png" name="imagelib" />
                        &nbsp;<br /><br />
						<?php
					}
					$chemin	= $this->params->get('gmapfp_chemin_img');
                    echo'</div>';
					echo $lists		= JHTML::_('list.images', 'img', $this->items->img, $javascript, $chemin, "bmp|gif|jpg|jpeg|png"  );
				?>
		<?php if($this->params->get('choix_upload_image')) { ?>
            		<br /><a style="cursor:pointer; font-size: 150%" onclick="popupWindow('index.php?option=com_gmapfp&controller=editlieux&tmpl=component&task=edit_upload','win1',420,120,'no');" class="toolbar"><img src="components/com_gmapfp/images/upload_f2.png" align="absmiddle" height="32" width="32" border="0" /> <?php echo JText::_('GMAPFP_UPLOAD') ?></a>
 		<?php }; ?>
        	</td>
     	</tr>
    	<tr <?php if (@$this->params->get('choix_message')){echo 'style="display: none; visibility: hidden;"';}?>>
            <td width="20%" class="key">
            	<label for="text_message">
					<?php 
                        if (@$this->custom[10]->nom) {
                            echo $this->custom[10]->nom;
                        }else{
                            echo JText::_( 'GMAPFP_MESSAGE' );
                        }
                    ?>
					<?php if ($this->params->get('gmapfp_submit_mess')){echo $image;} ?>
            	</label>
            </td>
        	<td>
            	<div id="Edit1" style="overflow:auto;">
                    <?php
					if (GMAPFP_ANDROID) {
						if ($this->params->get('gmapfp_submit_mess')){$class = 'required';}else{$class = '';}
						echo '<textarea class="inputbox '.$class.'" rows="6" cols="" style="width:95%;" id="text_message" name="text_message">'.$this->items->text.'</textarea>';
					}else{
                    	echo $editor->display( 'text_message', $this->items->text, '95%', '300', '75', '20', false);
					}
                    ?>
                </div>
        	</td>
		</tr>
    	<tr <?php if (@$this->params->get('choix_horaire')){echo 'style="display: none; visibility: hidden;"';}?>>
            <td width="20%" class="key">
            	<label for="text_horaires_prix">
					<?php 
                        if (@$this->custom[11]->nom) {
                            echo $this->custom[11]->nom;
                        }else{
                            echo JText::_( 'GMAPFP_HORAIRES_PRIX' );
                        }
                    ?>
					<?php if ($this->params->get('gmapfp_submit_prix')){echo $image;} ?>
            	</label>
            </td>
        	<td>
            	<div id="Edit2" style="overflow:auto;">
					<?php
					if (GMAPFP_ANDROID) {
						if ($this->params->get('gmapfp_submit_prix')){$class = 'required';}else{$class = '';}
						echo '<textarea class="inputbox '.$class.'" rows="6" cols="" style="width:95%;" id="text_horaires_prix" name="text_horaires_prix">'.$this->items->horaires_prix.'</textarea>';
					}else{
                    	echo $editor->display( 'text_horaires_prix', $this->items->horaires_prix, '95%', '200', '75', '20', false);
					}
                    ?>
                </div>
        	</td>
		</tr>
		<?php if($this->params->get('choix_marqueur')) { ?>
		<tr>
			<td width="20%" class="key">
				<label for="marker"><?php echo JText::_( 'GMAPFP_MARKER' ); ?></label>
			</td>
			<td>
				<table>
					<tr>
					<?php 
						$cnt = 0;
							foreach($this->marqueurs as $marqueur) {
								$checked = '';
								if (($this->items->marqueur == $marqueur->url) || (empty($this->items->marqueur) && $marqueur->id == '1')) { $checked = 'checked="checked"'; }
								echo '<td width="40" align="center" valign="top" style="border:1px solid #eeeeee"><img src="'.$marqueur->url.'" title="'.$marqueur->nom.'" /><br /><input type="radio" name="marqueur" id="marqueur" value="'.$marqueur->url.'" '.$checked.' /></td>';
								if ($cnt < 7) {
									$cnt++;
								} else {
									echo '</tr><tr>';
									$cnt = 0;
								}
							}
						unset($marqueur);
					?>
					</tr>
				</table>
			</td>
		</tr>
		<?php }else{ 
			if ($this->params->get('marqueur_def')) {?>
		<tr>
			<td width="20%" class="key">
				<label for="marker"><?php echo JText::_( 'GMAPFP_MARKER' ); ?></label>
			</td>
			<td>
				<table>
					<tr>
					<?php 
						$this->items->marqueur = $this->params->get('marqueur_def');
						echo '<td width="40" align="center" valign="top" style="border:1px solid #eeeeee"><img src="'.$this->items->marqueur.'" /><br /><input type="radio" name="marqueur" id="marqueur" value="'.$this->items->marqueur.'" checked="checked" /></td>';
					?>
					</tr>
				</table>
			</td>
		</tr>
		<?php };}; ?>
		<?php if($this->params->get('choix_signed')) { ?>
		<tr>
			<td width="20%" class="key">
				<?php echo JText::_( 'GMAPFP_SIGNED' ); ?>
			</td>
			<td>
            	<table>
                	<tr>
					<?php
                        echo '<td width="33%" align="center" valign="bottom">'.JText::_( 'GMAPFP_AFFICHAGE_GLOBAL').'<br /><input type="radio" name="show_author" id="show_author" value="" checked="checked" /></td>';
                        echo '<td width="33%" align="center" valign="bottom">'.JText::_( 'YES').'<br /><input type="radio" name="show_author" id="show_author" value="1" /></td>';
                        echo '<td width="33%" align="center" valign="bottom">'.JText::_( 'NO').'<br /><input type="radio" name="show_author" id="show_author" value="0" /></td>';
                     ?>
                 	</tr>
                 </table>
			</td>
		</tr>
		<?php }; ?>
		<tr <?php if (@$this->params->get('choix_meta')){echo 'style="display: none; visibility: hidden;"';}?>>
			<td width="20%" class="key">&nbsp;
				
			</td>
			<td style="text-align:left" class="key">
				<?php echo JText::_( 'GMAPFP_MOTEUR' ); ?>
			</td>
		</tr>
		<tr <?php if (@$this->params->get('choix_meta')){echo 'style="display: none; visibility: hidden;"';}?>>
			<td width="20%" class="key">
				<label for="metadesc">
					<?php echo JText::_( 'JFIELD_META_DESCRIPTION_LABEL' ); ?>
				</label>
			</td>
			<td>
				<textarea class="inputbox" name="metadesc" id="metadesc" cols="" rows="4" style="width:95%;"><?php echo $this->items->metadesc; ?></textarea>
			</td>
		</tr>
		<tr <?php if (@$this->params->get('choix_meta')){echo 'style="display: none; visibility: hidden;"';}?>>
			<td width="20%" class="key">
				<label for="metakey">
					<?php echo JText::_( 'JFIELD_META_KEYWORDS_LABEL' ); ?>
				</label>
			</td>
			<td>
				<textarea class="inputbox" name="metakey" id="metakey" cols="" rows="4" style="width:95%;"><?php echo $this->items->metakey; ?></textarea>
			</td>
		</tr>
	</table>
	</fieldset>
</div>
<div> 
	<fieldset>
        <div class="icon-32-back" style="float:right; width:32px; height:32px;"></div>
        <div class="next" style="float:right;">
            <button name="upform" class="button validate" type="submit"><?php echo JText::_('GMAPFP_SOUMETTRE'); ?></button>
        </div>
        <div class="icon-32-forward" style="float:right; width:256px; height:32px;"></div>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_gmapfp" />
<input type="hidden" name="view" value="editlieux" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="layout" value="soumission" />
<input type="hidden" name="itemid" value="<?php echo $Itemid; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
<div class="copyright" align="center">
	<br />
	<?php echo JText::_( 'GMapFP - <a href="http://gmapfp.org">gmapfp.org</a>' );?>
</div>
