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

//Init 
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx','st42-paypal'));
$item_name 	= $params->get( 'item_name', 'Donate' );
$currency 	= $params->def( 'currency', 'USD' );
$show_currency 	= $params->def( 'show_currency', 0 );
$amount		= $params->def( 'amount', 10 );
$show_amount		= $params->def( 'show_amount', 0 );
$country	= $params->def( 'country', 'US' );
$cancel_url_id = $params->def( 'cancel_url_id', 0 );
$return_url_id = $params->def( 'return_url_id', 0 );
$current_url = http_build_query(JRequest::get( 'get' ));
$display_link = $params->def( 'display_link', 0 );

// returning URLS
if ($return_url_id) {
	$return = jRoute::_(JURI::root().'index.php?option=com_content&view=article&id='.$return_url_id);
} else $return = jRoute::_(JURI::root().$current_url);

if ($cancel_url_id) {
	$cancel_url = jRoute::_(JURI::root().'index.php?option=com_content&view=article&id='.$cancel_url_id);
} else $cancel_url = jRoute::_(JURI::root().$current_url);

$business	= $params->def( 'business', '' );
$header_text= $params->def( 'header_text', '' );
$footer_text= $params->def( 'footer_text', '' );

// make the button (de_DE/DE,en_AU,nl_NL/BE,zh_XC,es_XC,es_ES/ES ...)
$lang = JFactory::getLanguage();
if ($lang->hasKey('MOD_ST42_PAYPAL_MOD_BTN_LOCALE')) {
	$btn_country = jText::_('MOD_ST42_PAYPAL_MOD_BTN_LOCALE');
} else $btn_country = 'en_US'; 

$btn_cc			= $params->def( 'btn_cc', '' );
if ($btn_cc) $btn_size = 'LG';
else $btn_size	= $params->def( 'btn_size', 'LG' );
$btn = $btn_country.'/i/btn/btn_donate'.$btn_cc.'_'.$btn_size.'.gif' ;

// make currency  list :
if ($show_currency) {
	$code3 = array('AUD','BRL','CAD','CZK','DKK','EUR','HKD','HUF','ILS','JPY','MYR','MXN','NOK','NZD','PHP','PLN','GBP','SGD','SEK','CHF','TWD','THB','TRY','USD');
	$currencies =  array();
	foreach ($code3 as $elem ) $currencies[] = array('value'=>$elem , 'text'=>jtext::_('MOD_ST42_PAYPAL_CUR_'.$elem ) );
	$currency_list = JHTML::_('select.genericlist', $currencies, 'currency_code', 'class="inputbox"', 'value', 'text', $currency);
}
require(JModuleHelper::getLayoutPath('mod_st42_paypal'));