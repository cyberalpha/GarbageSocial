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
?>

<script language="javascript" type="text/javascript">
   function control() {
    var form = document.adminForm;
    // do field validation
    if (form.image1.value == ""){
     alert( "<?php echo JText::_('GMAPFP_UPLOAD_ERREUR'); ?>" );
    } else {
     return true;
    }
    return false;

   }
  </script> 
    <style>
.upload {font-family: Geneva, Arial, Helvetica, sans-serif;font-weight: bold;font-size: 12px;color: #3D5EA0;margin: 5px 0;text-align: left;}
.inputbox {font-size: 11px;}
    </style>
    <form action='index.php?option=comgmapfp&controller=editlieux&tmpl=component&task=upload_image' method='post' id='adminForm' name='adminForm' enctype='multipart/form-data' onsubmit='return control();'>
    <table width='100%' border='0' cellpadding='4' cellspacing='2' class='adminForm'>
    <div class="upload"><?php echo JText::_('GMAPFP_TELECHARGER_IMAGE') ;?>
    <tr align='left' valign='middle'>
    <td class='upload' align='left' valign='top'>
    <input type='hidden' name='option' value='com_gmapfp' />
    <input class='inputbox' type='file' name='image1' /><br />
    <input type='hidden' name='no_html' value='no_html' />
    <input class='upload' type='submit' value='<?php echo JText::_('GMAPFP_BP_UPLOAD') ;?>' />
    </td></tr></form></table></div>
    </table></table>

