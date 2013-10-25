/**
 * @version: $Id: geomap.js 1832 2011-08-16 08:53:59Z Radek Suski $
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
 * $Date: 2011-08-16 10:53:59 +0200 (Di, 16 Aug 2011) $
 * $Revision: 1832 $
 * $Author: Radek Suski $
 */
jQuery.noConflict();
if ( typeof SPGeoMapsReg == 'undefined' ) {
	var SPGeoMapsReg = {};
}
function SPGeoEditMapInit( Opt, pid )
{
	jQuery( document ).ready( function() { 
		var watcher = new SPGeoWatch( Opt ); 
		if( pid ) {
			var id = Opt.Id;
			try {
				jQuery( '#' + pid ).bind( 'click', function() {
					if( this.checked ) {
						jQuery( '#' + id ).fadeTo( 'slow', 1 );
						GeoFields( id, true );
					}
					else {
						jQuery( '#' + id ).fadeTo( 'slow', 0.1 );
						GeoFields( id, false );
					}
				} );
				// initial dimm
				if( jQuery( '#' + pid ).val() != undefined && !( jQuery( '#' + pid ).checked ) ) {
					jQuery( '#' + id ).fadeTo( 'slow', 0.1 );
				}
				GeoFields( id, false );
				function GeoFields( id, state ) {
					// for some reason the compressor changes strings like '_lat' to '_1' 
					SP_id( id +'_'+'latitude' ).enabled = state;
					SP_id( id +'_'+'longitude' ).enabled = state;	
					watcher.GetCoordinates();
				};
			} catch( e ) {}
		}
	} );
}

function SPShowGeoMap( Opt )
{
	SobiPro.onReady( function () {
		this.Map;
		this.Position = new google.maps.LatLng( parseFloat( Opt.Marker.Lat ), parseFloat( Opt.Marker.Long ) );
		this.Marker;
		this.Bubble;
		var views = [];
		var canvas = SP_id( Opt.Id );
		for( i = 0; i < Opt.Views.length; i++ ) {
			views[ i ] = google.maps.MapTypeId[ Opt.Views[ i ] ];
		}
		var options = {
			zoom: parseFloat( Opt.Zoom ),
			mapTypeId: google.maps.MapTypeId[ Opt.MapTypeId ]
		};
		for( var i in Opt.MapOpt ) {
			options[ i ] = Opt.MapOpt[ i ];
		}
		if( views.length > 0 ) {
			options[ 'mapTypeControlOptions' ] = { mapTypeIds: views };
		}
		this.Map = new google.maps.Map( canvas, options );	
		this.Map.setCenter( this.Position );
		this.Marker = new google.maps.Marker( { position: this.Position, map: this.Map, animation: google.maps.Animation.DROP } );
		SPGeoMapsReg[ Opt.Id ] = this;
		// @todo
//		if( Opt.Marker.Bubble ) {
//			this.Bubble = new google.maps.InfoWindow( {
//			  
//			} );
//			if( Opt.Marker.Bubble == 1 ) {
//				this.Bubble.open(this.Map, this.Marker );
//			}
//			w = this;
//			google.maps.event.addListener( this.Marker, 'click', function() {
//				w.Bubble.open( w.Map, w.Marker );
//			} );		
//		}
	} );
}

function SPGeoWatch( Opt )
{
	this.Fields = [];
	this.Map; 
	this.Address = {};
	this.Opt = Opt;
	this.Trigger;
	this.Address;
	this.Marker;
	this.MarkerLock = false;
	this.Turnout;
	// register field's events
	this.FieldEvent = function( field )
	{
		var watcher = this;
		field.bind( 'blur', function() {
			watcher.GetCoordinates();
		} );		
	};
	
	this.GetCoordinates = function()
	{
		change = false;
		// if these data has been changed - replace it in the array and eventually get new coordinates
		for( var i = 0; i < this.Fields.length; i++ ) {
			id = this.Fields[ i ].attr( 'id' );
			field = jQuery( '#' +  id );
			// if value has been changed
			if( this.Address[ id ] != field.attr( 'value' ) ) {				
				this.Address[ id ] = field.attr( 'value' );
				change = true;
			}
		}
		// if changed
		if( change )  {
			// if the marker was adjusted manually before - ask the user first
			if( this.MarkerLock ) {
				change = confirm( this.Opt.ChngMsg );
			}
			if( change ) {
				var string = new Array();
				c = 0;
				for( var i in this.Address ) {
					string[ ++c ] = this.Address[ i ];
				}
				var geocoder = new google.maps.Geocoder();
				var watcher = this;
			    geocoder.geocode( { 'address': string.join( '+' )  }, function( results, status ) {
			        if ( status == google.maps.GeocoderStatus.OK ) {	
			        	// reset lock
			        	watcher.MarkerLock = false;
			        	// set coordinates
			        	watcher.SetCoordinates( results[ 0 ].geometry.location );
			        } 
			    } );				
			}
		}
	};
	
	this.SetCoordinates = function( data, init )
	{		
		var newLocation = new google.maps.LatLng( data.lat(), data.lng() );
		this.Map.setCenter( newLocation );
		if( !( init ) ) {
			this.Map.setZoom( 16 );
			this.AdjustCoordinates( data.lat(), data.lng() );
		}
		// if marker has been already created
		try {
			this.Marker.setPosition( newLocation );
		} catch( e ) {
			// otherwise create new marker
			this.Marker = new google.maps.Marker( {
				position: newLocation, 
				map: this.Map,
				animation: google.maps.Animation.DROP,
				draggable:true
			} );
		}
		// insert into current scope
		var watcher = this;
		google.maps.event.addListener( this.Marker, 'dragend', function ( ev ) { 
			watcher.AdjustCoordinates( this.getPosition().lat(), this.getPosition().lng() );
			watcher.MarkerLock = true;
		} );
	};
	this.AdjustCoordinates = function( latitude, longitude )
	{
		SP_id( this.Opt.Id+'_'+'latitude' ).value = latitude;
		SP_id( this.Opt.Id+'_'+'longitude' ).value = longitude;		
	};	
	this.GeoInit = function() 
	{
		var initialLocation;
		// turnout coordinates - in case we cannot (or want) to get the browser geo data
		this.Turnout = new google.maps.LatLng( ( this.Opt.StartPoint.Lat ), ( this.Opt.StartPoint.Long ) );
		// the map container
		var canvas = SP_id( Opt.Id+'_'+'canvas' );	
		var views = [];
		var w = this;
		// register selcted views
		for( i = 0; i < this.Opt.Views.length; i++ ) {
			views[ i ] = google.maps.MapTypeId[ this.Opt.Views[ i ] ];
		}
		var options = {
			zoom: parseFloat( this.Opt.Zoom ),
			mapTypeId: google.maps.MapTypeId[ this.Opt.MapTypeId ]
		};
		for( var i in this.Opt.MapOpt ) {
			options[ i ] = this.Opt.MapOpt[ i ];
		}
		if( views.length > 0 ) {
			options[ 'mapTypeControlOptions' ] = { mapTypeIds: views };
		}
		this.Map = new google.maps.Map( canvas, options );
		// if marker has been set, we don't need to search for coordinates
		if( this.Opt.Sensor == 0 || this.Opt.StartPoint.Marker ) {
			this.NoInit( true ); 
		}
		else {
			// Try W3C Geolocation (Preferred)
			if ( navigator.geolocation ) {
				navigator.geolocation.getCurrentPosition( function( position ) {
					initialLocation = new google.maps.LatLng( position.coords.latitude, position.coords.longitude );
					try {
						w.Map.setCenter( initialLocation );
						w.SetCoordinates( initialLocation, true );
					} catch( e ) {}
				}, function() { w.NoInit(); } );
			}
			// Try Google Gears Geolocation
			else if ( this.Opt.Sensor && google.gears ) {
				var geo = google.gears.factory.create( 'beta.geolocation' );
				geo.getCurrentPosition( function( position ) {
					initialLocation = new google.maps.LatLng( position.latitude,position.longitude );
					try {
						w.Map.setCenter( initialLocation );
						w.SetCoordinates( initialLocation, true );
					} catch( e ) {}
				}, function() { w.NoInit();	} );
				// Browser doesn't support Geolocation
			} 
			else {
				if( !( google.gears ) ) {
					alert( 'Your browser doesn\'t support GeoLocation. Please visit: http://gears.google.com/ ');
				}
				this.NoInit();
			}  
		}
	};
	this.NoInit = function() 
	{
		this.Map.setCenter( this.Turnout );
	};
	this.GeoInit();	
	// travel address fields and store these as DOM objects
	for( var i = 0; i < Opt.Fields.length; i++ ) {
		try {
			this.Fields[ i ] = jQuery( '#' +  Opt.Fields[ i ] ) ;
		} catch( e ) {}
	}	
	// last field is the trigger
	this.Trigger = Opt.Fields[ Opt.Fields.length - 1 ];
	// travel again and add events
	for( var i = 0; i < this.Fields.length; i++ ) {
		this.FieldEvent( this.Fields[ i ] );		
	}	
	if( this.Opt.StartPoint.Marker ) {
		this.SetCoordinates( new google.maps.LatLng( this.Opt.StartPoint.Lat, this.Opt.StartPoint.Long ) );
	}
}