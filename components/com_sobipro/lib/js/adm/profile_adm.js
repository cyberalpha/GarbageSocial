/**
 * @version: $Id: profile.js 1946 2011-10-18 17:13:33Z Radek Suski $
 * @package: SobiPro Profile Field Application
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
 * $Date: 2011-10-18 19:13:33 +0200 (Di, 18 Okt 2011) $
 * $Revision: 1946 $
 * $Author: Radek Suski $
 * File location: components/com_sobipro/lib/js/efilter.js $
 */

jQuery( document ).ready( function () {
    jQuery('.spProfileAutocomplete')
        .bind('click', function () {
            if (jQuery(this).val() == spProfileAutocomplete.input ) {
                jQuery(this).val('');
            }
        })
        .bind('blur', function () {
            if (jQuery(this).val() == '') {
                jQuery(this).val( spProfileAutocomplete.input );
            }
        })
        .autocomplete( {
            source:function ( request, response ) {
                jQuery.ajax({
                    url:SobiProUrl.replace( '%task%', 'profile.authors' ),
                    dataType:"json",
                    data:{ 'sid':SobiProSection, 'term':request.term, 'target': spProfileAutocomplete.section },
                    success:function( data ) {
                        response( jQuery.map( data, function ( item ) { return { label:item.name +' ( ' + item.id + ' ) ' , value:item.name, id: item.id } } ) );
                    }
                });
            },
            select:function( event, ui ) {
                jQuery( '#' + jQuery( this ).attr( 'id' ) + '_sid' ).val( ui.item ? ui.item.id : 0 );
            },
            minLength:2
        });
});
