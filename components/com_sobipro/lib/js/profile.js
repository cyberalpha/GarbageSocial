/**
 * @version: $Id: profile.js 2655 2012-08-08 17:23:10Z Radek Suski $
 * @package: SobiPro Profile Field Application
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
 * $Date: 2012-08-08 19:23:10 +0200 (Mi, 08 Aug 2012) $
 * $Revision: 2655 $
 * $Author: Radek Suski $
 */

function SPProfileBlock( state )
{
	if ( state != undefined ) {
		this.state = state;
	}
	else {
		return this.state;
	}
}

function SPProfile( settings )
{
	token = '';

	jQuery( '#spEntryForm' ).bind( 'submit', function ()
	{
		jQuery( '#' + settings.email ).trigger( 'blur' );
		jQuery( '#' + settings.name ).trigger( 'blur' );
		jQuery( '#' + settings.pass + '_repeat' ).trigger( 'blur' );
	} );


	if ( jQuery( '#' + settings.pass + '_skip_yes' ) ) {
		jQuery( '#' + settings.pass + '_skip_yes' ).bind( 'click', function ()
		{
			SPProfileBlock( jQuery( this ).is( ':checked' ) );
		} );
	}
	parent = this;
	var request = { 'field':'email', 'sid':SobiProSection, 'uid':SpProUid };
	if ( token == '' ) {
		fields = jQuery( 'input:hidden' );
		for ( i = 0; i < fields.length; i++ ) {
			if ( fields[ i ].id.length > 30 ) {
				token = fields[ i ].name;
			}
			request[ token ] = 1;
		}
	}
	jQuery( '#' + settings.email ).bind( 'blur', function ()
	{
		if ( parent.semaphor ) {
			return null;
		}
		jQuery.ajax( {
			url:settings.url,
			data:jQuery.extend( request, { 'field':'email', 'value':jQuery( this ).val() } ),
			success:function ( data )
			{
				if ( data.result > 0 ) {
					parent.Message( data.message );
				}
			}
		} );
	} );
	jQuery( '#' + settings.name ).bind( 'blur', function ()
	{
		if ( SPProfileBlock() ) {
			return null;
		}
		jQuery.ajax( {
			url:settings.url,
			data:jQuery.extend( request, { 'field':'username', 'value':jQuery( this ).val() } ),
			success:function ( data )
			{
				if ( data.result > 0 ) {
					parent.Message( data.message );
				}
			}
		} );
	} );
	jQuery( '#' + settings.pass + '_repeat' ).bind( 'blur', function ()
	{
		if ( SPProfileBlock() ) {
			return null;
		}
		if ( jQuery( this ).val() != jQuery( '#' + settings.pass ).val() ) {
			parent.Message( settings.nm_msg );
		}
	} );
	jQuery( '#' + settings.pass ).bind( 'blur', function ()
	{
		if ( SPProfileBlock() ) {
			return null;
		}
		if ( settings.length > jQuery( this ).val().length ) {
			parent.Message( settings.ts_msg );
		}
	} );

	this.Message = function ( message )
	{
		SPProfileBlock( true );
		try {
			jQuery( "#" + settings.pass + '_msg' )
				.html( '<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .7em;"></span>' + message )
				.dialog( { modal:true } );
		}
		catch ( e ) {
			alert( message );
		}
		SPProfileBlock( false );
	};
}
