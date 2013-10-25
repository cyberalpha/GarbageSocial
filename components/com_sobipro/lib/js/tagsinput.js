/**
 * Based on: jQuery Tags Input Plugin 1.2

 * Copyright (c) 2010 XOXCO, Inc
 * Documentation for this plugin lives here:
 * http://xoxco.com/clickable/jquery-tags-input
 * ===================================================
 * Modified for the SobiPro tag field and use jQueryUI autocomplete
 * Renamed to avoid conficts
 * ===================================================
 * @version: $Id: tagsinput.js 1392 2011-05-23 09:08:02Z Radek Suski $
 * @package: SobiPro Aggregation Field Application
 * ===================================================
 * @author
 * Name: Sigrid Suski & Radek Suski, Sigsiu.NET GmbH
 * Email: sobi[at]sigsiu.net
 * Url: http://www.Sigsiu.NET
 * ===================================================
 * @copyright Copyright (C) 2006 - 2011 Sigsiu.NET GmbH (http://www.sigsiu.net). All rights reserved.
 * @license see http://www.opensource.org/licenses/mit-license.php
 * You can use, redistribute this file and/or modify it under the terms of the MIT license
 * ===================================================
 * $Date: 2011-05-23 11:08:02 +0200 (Mon, 23 May 2011) $
 * $Revision: 1392 $
 * $Author: Radek Suski $
 */
jQuery.noConflict();
( function( jQuery ) {
	var delimiter = new Array();
	jQuery.fn.SPaddTag = function( value, options ) {
		this.each( function() { 
			id = jQuery( this ).attr( 'id' );
			fid = jQuery( '#' + id + '_tag' );
			var tagslist = jQuery( this ).val().split( delimiter[ id ] );			
			if ( tagslist[0] == '' ) { 
				tagslist = new Array();
			}
			value = jQuery.trim( value );
			if ( value != '' && value.length <= options.maxLength ) { 
				jQuery( '<span class="SPtag">' + value + '&nbsp;&nbsp;<a href="#" title="Remove tag" onclick="return jQuery(\'#' + id + '\').SPremoveTag(\'' + escape( value ) + '\');">x</a></span>' ).insertBefore( '#' + id + '_addTag' );
				tagslist.push( value );
				fid.val( '' );
				if( tagslist.length >= options.limit ) {
					fid.blur();
					fid.hide();
				}
				else {
					if ( options.focus ) {
						fid.focus();
					} 
					else {		
						fid.blur();
					}
					fid.show();
				}
			}
			else {
				if( value.length > options.maxLength ) {
					alert(  options.limMsg );
					return false;
				}
			}			
			jQuery.fn.SPAtagsInput.updateTagsField( this, tagslist );
			return true;
		} );		
		return true;
	};
	jQuery.fn.SPremoveTag = function( value ) { 			
			this.each( function() { 
				id = jQuery( this ).attr( 'id' );
				var old = jQuery(this).val().split(delimiter[id]);
				jQuery( '#' + id + '_tagsinput .SPtag' ).remove();
				str = '';
				for (i=0; i< old.length; i++) { 
					if (escape(old[i])!=value) { 
						str = str + delimiter[id] +old[i];
					}
				}
				jQuery.fn.SPAtagsInput.importTags(this,str);
			});
			return false;
	};
	jQuery.fn.SPAtagsInput = function(options) { 
		var settings = jQuery.extend( { 'delimiter':',', 'focus': true, 'hide':true }, options );
		this.each(function() { 
			if ( settings.hide ) { 
				jQuery(this).hide();
			}
			id = jQuery(this).attr('id');
			data = jQuery.extend(
					{
						pid:id,
						real_input: '#'+id,
						holder: '#'+id+'_tagsinput',
						input_wrapper: '#'+id+'_addTag',
						fake_input: '#'+id+'_tag'
					}, 
					settings
			);
			delimiter[ id ] = data.delimiter;
			jQuery('<div id="'+id+'_tagsinput" class="SPtagsinput"><div id="'+id+'_addTag"><input id="'+id+'_tag" value="" default="'+settings.defaultText+'" /></div><div class="SPtags_clear"></div></div>').insertAfter(this);			
			jQuery(data.holder).css('width',settings.width);
			jQuery(data.holder).css('height',settings.height);
			if (jQuery(data.real_input).val()!='') { 
				jQuery.fn.SPAtagsInput.importTags(jQuery(data.real_input),jQuery(data.real_input).val());
				jQuery(data.fake_input).val( settings.defaultText );
			} 
			else {
				jQuery(data.fake_input).val(jQuery(data.fake_input).attr('default'));
				jQuery(data.fake_input).css('color','#666666');				
			}
			jQuery(data.holder).bind('click',data,function(event) {
				jQuery(event.data.fake_input).val( '' );
				jQuery(event.data.fake_input).focus();
			});
			// if user types a comma, create a new tag
			jQuery(data.fake_input).bind( 'keypress',data,function(event) { 
				if (event.which==event.data.delimiter.charCodeAt(0) || event.which==13) { 
					jQuery(event.data.real_input).SPaddTag( jQuery( event.data.fake_input ).val(), data );
					return false;
				}
			});
			jQuery(data.fake_input).bind('focus',data,function(event) {
				if ( jQuery(event.data.fake_input).val() == jQuery(event.data.fake_input).attr('default')) { 
					jQuery(event.data.fake_input).val('');
				}
				jQuery(event.data.fake_input).css('color','#000000');		
			});
			jQuery( data.fake_input ).bind( 'blur',data, function( event ) {
				jQuery(event.data.fake_input).val( settings.defaultText );
			} );
			new SPAggrComplete().set( jQuery( data.fake_input ), id );
			jQuery( data.fake_input ).bind( 'autocompleteselect', data, function( event, ui ) {
				event.preventDefault();
				if( jQuery( event.data.real_input ).SPaddTag( ui.item.value, data ) ) {
					jQuery( event.data.fake_input ).val( '' );
					jQuery(event.data.fake_input).val( settings.defaultText );
				}
				jQuery( event.data.fake_input ).val( '' );
			} );
			jQuery(data.fake_input).blur();
		});
		return this;
	};
	jQuery.fn.SPAtagsInput.updateTagsField = function(obj,tagslist) { 
		
			id = jQuery(obj).attr('id');
			jQuery(obj).val(tagslist.join(delimiter[id]));
	};
	jQuery.fn.SPAtagsInput.importTags = function( obj, val ) {
		jQuery( obj ).val( '' );
		id = jQuery( obj ).attr( 'id' );
		var tags = val.split( delimiter [ id ] );
		for ( i = 0; i < tags.length; i++ ) { 
			jQuery( obj ).SPaddTag( tags[i], data );
		}
	};
			
})(jQuery);

var cache = {};
var lastXhr;

function SPAggrComplete()
{
	this.set = function( fid, id ) {
		fid.autocomplete( {
			minLength: 3,
			source: function( request, response ) {
				var term = request.term;
				if ( term in cache ) {
					 response( cache[ term ] );
					 return;
				}
				lastXhr = jQuery.ajax( {
					 url: SobiProUrl.replace( '%task%', 'list.tag.' + id + '.suggest' ),
					 data: {
						 term: request.term,
						 sid: SobiProSection,
						 tmpl: "component",
						 format: "raw"
					 },
					 success: function( data ) {
						 cache[ term ] = data;
						 response( data );
					 }
				} );
			}
		} );
	};
	return this;
}
