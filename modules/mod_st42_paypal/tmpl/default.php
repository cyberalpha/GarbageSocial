<?php
/**
* @version		1.0
* @author		Kohl Patrick(Studio 42)
* @authorUrl	http://www.st42.fr
* @package		Joomla!
* $subpackage	Studio 42 PayPal Donation module
* @copyright	Copyright (C) 2012 Studio 42. All rights reserved.
* @license		GNU General Public License version 2 or later; see http://www.gnu.org/licenses/gpl-2.0.html
* Plz contact author to redistribute it. 
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
//OsJoomla configuration
	$document =& JFactory::getDocument();
	$style = '.st42-paypal li .st42-paypal-label,.st42-paypal li input,.st42-paypal li select{
				margin: 1%; padding: 0; width: 46%; float: left; display: block; }
			.st42-paypal li.paypal-btn {text-align: center;display: block ;width: 100%;clear: both}
			.st42-paypal li.paypal-btn input{ display: inline;float: none;width:auto}
			.st42-paypal li .st42-paypal-label{text-align:right;}';
	$document->addStyleDeclaration( $style );

?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
<ul class="<?php echo $moduleclass_sfx; ?>">
<?php if ($header_text != "") { ?>
	<li>
		<?php echo $header_text?>
	</li>
<?php } 
if ($show_currency) { ?>
		<li>
			<span class="st42-paypal-label"><?php echo jText::_('MOD_ST42_PAYPAL_MOD_CURRENCY') .'</span> '. $currency_list ?>
		</li><?php
} else { ?> 
	<input type="hidden" name="currency_code" value="<?php echo $currency ?>"/><?php
} 

if ($show_amount=="2") { ?>
	<li>
		<?php 
		if ($show_currency) { ?>
		<span class="st42-paypal-label">
			<?php echo jText::_('MOD_ST42_PAYPAL_MOD_AMOUNT') ; ?>
		</span>
		<?php } ?>
		<input type="text" name="amount" value="<?php echo $amount ?>" size="10"/>
		<?php if (!$show_currency) { ?>
		<span >
			<?php echo '('.jtext::_('MOD_ST42_PAYPAL_CUR_'.$currency ).') ' ; ?>
		</span>
		<?php } ?>
	</li>
	
<?php } 
else {
	if ($show_amount=="1") { ?>
		<li class="paypal-btn">
			<span><?php echo $amount. ' ('.jtext::_('MOD_ST42_PAYPAL_CUR_'.$currency ).') ' ; ?></span>
		</li>
	<?php  }
	echo '<input type="hidden" name="amount" value="'.$amount.'"/>'; 
} ?>

	<li class="paypal-btn">
		<input class="paypal-btn" type="image" src="http://www.paypal.com/<?php echo $btn ?>" border="0" name="submit" alt="Paypal donate">
	
	</li>

<?php if ($footer_text) { ?>
	<li>
		<?php echo $footer_text?>
	</li>
<?php } ?>
	<?php if ($display_link) { ?>
	<li>
		<small style="float: right;font-size: 8px;">
			by <a href="http://www.st42.fr">Studio 42</a>
		</small>
	</li>
	<?php } ?>	

</ul>
<div style="clear: both;display: block;heigh:0px"></div>


<input type="hidden" name="cmd" value="_donations" />
<input type="hidden" name="business" value="<?php echo $business; ?>" />
<input type="hidden" name="item_name" value="<?php echo $item_name; ?>" />
<input type="hidden" name="no_shipping" value="1" />
<input type="hidden" name="return" value="<?php echo $return; ?>" />
<input type="hidden" name="cancel_return" value="<?php echo $cancel_url ?>" />
<input type="hidden" name="tax" value="0" />
<input type="hidden" name="lc" value="<?php echo $country; ?>" />
<input type="hidden" name="bn" value="PP-DonationsBF" />
</form>


