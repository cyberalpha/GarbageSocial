<?php
/**
 * @package		 Ultimate Google AdSense Module By Internet Partner
 * @subpackage	 Advertisement
 * @copyright    Copyright (C) 2011 Internet Partner Agency <office@internetpartner.info>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

	defined( '_JEXEC' ) or die( 'Restricted access' );
	
	$adCSS = $params->get('adCSS');
	$moduleClassSfx = $params->get('moduleClassSfx');	
	$title = $params->get('title');
	if( $title ) { $title = "\t\t<p>&nbsp;".$title."</p>"; }
	$publisherId = $params->get('publisherId');
	$slotId     = $params->get('slot');
	$adType  	= $params->get('type');  
	$unitName  	= $params->get('name'); 
	$adFormat   = $params->get('adFormat');
	$format     = explode("-", $adFormat);
	$width      = explode("x", $format[0]);
	$height     = explode("_", $width[1]);	

	$code = null;

	$ips = explode(",", $params->get('blockedIPs') );
	foreach($ips as &$ip) { $ip = trim($ip); }
	if( in_array($_SERVER["REMOTE_ADDR"], $ips ) ) { 
		echo '<div style="clear:both;">' . $params->get('altMessage') . '</div>'; 
	}
	else if( JRequest::getWord( "view" ) == "article" and $params->get('disableOnArticle') == 'yes') { 
		
	}
	else {		
		$code = $title.'
		<!-- Ultimate Google AdSense by WebSoft http://websoftserbia.com -->		
		<script type="text/javascript"><!--
			google_ad_client = "' . $publisherId . '";
			/* "' . $unitName . '" */
			google_ad_slot = "' . $slotId . '";
			google_ad_width = "' . $width[0] . '";
			google_ad_height = "' . $height[0] . '";
			//-->
		</script>
		<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>';
		if ( $adCSS ) { 
			$code = "\n\t<div style=\"" . $adCSS . "\">\r\n". $code ."\n\t</div>\n";
		}
		if ( $moduleClassSfx ) { 
			$code = "\n<div style=\"menu" . $moduleClassSfx . "\">\r\n". $code ."\n</div>\n";
		}		
		echo $code; 
	}
	
