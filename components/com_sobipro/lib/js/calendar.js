/**
 * @version: $Id: calendar.js 2448 2012-05-08 14:14:55Z Radek Suski $
 * @package: SobiPro Library
 * ===================================================
 * @author
 * Name: Sigrid Suski & Radek Suski, Sigsiu.NET GmbH
 * Email: sobi[at]sigsiu.net
 * Url: http://www.Sigsiu.NET
 * ===================================================
 * @copyright Copyright (C) 2006 - 2012 Sigsiu.NET GmbH (http://www.sigsiu.net). All rights reserved.
 * @license see http://www.gnu.org/licenses/lgpl.html GNU/LGPL Version 3.
 * You can use, redistribute this file and/or modify it under the terms of the GNU Lesser General Public License version 3
 * ===================================================
 * $Date: 2012-05-08 16:14:55 +0200 (Di, 08 Mai 2012) $
 * $Revision: 2448 $
 * $Author: Radek Suski $
 */
function spCalendar( id, options ) {
	jQuery( document ).ready(
		function () {
			jQuery.extend(
				options, {
					onClose:function () {
						time = jQuery( this ).datepicker( 'getDate' );
						jQuery( '#' + id ).val( new Date( time - ( new Date().getTimezoneOffset() * 60000 ) ).valueOf() );
					}
				}
			);
			jQuery.extend( options, spCalLang );
			if ( options.timeFormat == undefined ) {
				jQuery( '#' + id + '_selector' ).datepicker( options );
			}
			else {
				jQuery( '#' + id + '_selector' ).datetimepicker( options );
			}
			if ( options.selectedDate != 0 && options.selectedDate != '' ) {
				jQuery( '#' + id + '_selector' ).datetimepicker(
					'setDate', new Date( ( options.selectedDate + ( new Date().getTimezoneOffset() * 60 )  ) * 1000 ) );
			}
			else {
				jQuery( '#' + id + '_selector' ).val( '' );
			}
		}
	);
}
