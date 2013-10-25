/**
 * @version: $Id: calendar_search.js 2346 2012-04-09 15:22:39Z Radek Suski $
 * @package: SobiPro Library
 * ===================================================
 * @author
 * Name: Sigrid Suski & Radek Suski, Sigsiu.NET GmbH
 * Email: sobi[at]sigsiu.net
 * Url: http://www.Sigsiu.NET
 * ===================================================
 * @copyright Copyright (C) 2006 - 2011 Sigsiu.NET GmbH (http://www.sigsiu.net). All rights reserved.
 * @license see http://www.gnu.org/licenses/lgpl.html GNU/LGPL Version 3.
 * You can use, redistribute this file and/or modify it under the terms of the GNU Lesser General Public License version 3
 * ===================================================
 * $Date: 2012-04-09 17:22:39 +0200 (Mo, 09 Apr 2012) $
 * $Revision: 2346 $
 * $Author: Radek Suski $
 */
/*
 *  it's a workaround - there is some incompatibility between MT and jQ
 *  even in noConfict mode
 */
var FxSlideHandler;
try {
	FxSlideHandler = Fx.Slide;
	Fx.Slide = null;
} catch ( e ) {
}
;


function spCalendar( id, options, from, to ) {
	jQuery( document ).ready(
		function () {
			jQuery.extend(
				options, {
					onClose:function () {
						time = jQuery( this ).datepicker( 'getDate' );
						jQuery( '#' + this.id.replace( '_selector', '' ) ).val( new Date( time ).valueOf() );
					}
				}
			);
			jQuery.extend( options, spCalLang );
			jQuery( '#' + id + '_from_selector' ).datetimepicker( options );
			if ( from != 0 && to != '' ) {
				jQuery( '#' + id + '_from_selector' ).datetimepicker( 'setDate', new Date( from ) );
			}
			else {
				jQuery( '#' + id + '_from_selector' ).val( '' );
			}
			jQuery( '#' + id + '_to_selector' ).datetimepicker( options );
			if ( to != 0 && to != '' ) {
				jQuery( '#' + id + '_to_selector' ).datetimepicker( 'setDate', new Date( to ) );
			}
			else {
				jQuery( '#' + id + '_to_selector' ).val( '' );
			}
		}
	);
}
