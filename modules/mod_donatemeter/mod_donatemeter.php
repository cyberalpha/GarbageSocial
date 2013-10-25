<?php
/*------------------------------------------------------------------------
# mod_donatemeter - donation meter
# ------------------------------------------------------------------------
# author    laotracking individual enterprise, laoapps.com07.
# copyright Copyright (C) 2010 laoapps.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.laoapps.com
# Technical Support:  touya.ra@gmail.com
-------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once( dirname(__FILE__).DS.'helper.php' );
//PAYPAL API
$sandboxmode = $params->get('sandboxmode');
$paypalapiuser = $params->get('paypalapiuser');
$paypalapipassword = $params->get('paypalapipassword');
$paypalapisignature = $params->get('paypalapisignature');

$meterinterface=$params->get('meterinterface');

$ourgoal=$params->get('ourgoal');;
$wehave=$params->get('wehave');;
$weneed=$params->get('weneed');;

$pic='modules/mod_donatemeter/smile-pig2.gif';
if($meterinterface==1)
	$pic='modules/mod_donatemeter/normal-meter.gif';

if($sandboxmode==0)
$sandboxmode='live';
else
$sandboxmode='beta-sandbox';

$customhtml=$params->get('customhtml');

//BASIC 
$current1 = $params->get('current1');
$currency1 = $params->get('currency1');
$goal1 = $params->get('goal1');
$height1 = $params->get('height1');
$width1 = $params->get('width1');

$httpParsedResponseAr = PPHttpPost('GetBalance', $nvpStr,$sandboxmode,$paypalapiuser,$paypalapipassword,$paypalapisignature);
//echo "balance:".(real)urldecode($httpParsedResponseAr['L_AMT0']);
if($httpParsedResponseAr['L_AMT0']!='')
{
	$current1+=	(real) urldecode($httpParsedResponseAr['L_AMT0']);
}
$percent = ($current1 / $goal1);
$percentvalue=$percent*$height1;
$meterhieght=$height1-$percentvalue;
$percent=$percent*100;
//$percent2=
$rounded_number = round($percent);
// Percentage2Color
$color = percent2Color($goal1-$current1,$brightness = 255,$goal1); 


?>
<p><?php echo $ourgoal.$currency1. $goal1?></p>
<p><?php echo $wehave.$currency1.$current1?>[<?php echo $percent?>%]</p>
<p><?php echo $weneed.$currency1; echo  $goal1-$current1?></p>
<div class="class_mod_donate_meter_meter" style="width:<?php echo $width1?>px; height:<?php echo $height1?>px;  vertical-align:bottom; ">
  <div  style="background-color:#<?php echo $color;?>; width:<?php echo $width1?>px; height:<?php echo $height1?>px; float:left; position:absolute; z-index:1;">
  	<div  style="background-color:white; width:<?php echo $width1?>px; height:<?php echo $meterhieght?>px; float:left; position:absolute; z-index:0">
    <?php
    if($pic!="")
	{
	?>
    <img  src="<?php echo $pic;?>" width="<?php echo $width1?>px"; height="<?php echo $height1?>px" />
    <?php
	}
	else
	{
	 ?>
  		<img src="smile-pig2.gif" width="<?php echo $width1?>px"; height="<?php echo $height1?>px" />
		<?php
	}
		 ?>
  	</div>
  </div>
</div>
<p><?php echo $customhtml?></p>
<p class="class_mod_donate_meter_author"><a href="mailto:touya.ra@gmail.com">By touya.ra@gmail.com</a></p>
<style>
.class_mod_donate_meter_meter
{
	margin-left:5px;
	}
.class_mod_donate_meter_author
{
	font-size:8px;
	}
.class_mod_donate_meter_author:hover
{
font-size:10px;
	}
</style>