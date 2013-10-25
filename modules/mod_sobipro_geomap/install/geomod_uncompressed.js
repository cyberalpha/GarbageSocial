/**
 * @version: $Id: geomod_uncompressed.js 2146 2012-01-13 09:37:43Z Sigrid Suski $
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
 * $Date: 2012-01-13 10:37:43 +0100 (Fr, 13 Jan 2012) $
 * $Revision: 2146 $
 * $Author: Sigrid Suski $
 */

if ( typeof SPGeoMapsModReg == 'undefined' ) {
    var SPGeoMapsModReg = {};
}
function SPGeoMapModInit( id, options ) {
    jQuery( document ).ready( function () {
        SPGeoMapsModReg[ id ] = new SPGeoMapMod( id ).init( options );
    } );
}
function SPGeoMapMod( id ) {
    this.Options;
    this.Map;
    this.Position;
    this.Markers = [];
    this.cid = id + 'Inner';
    this.Container = jQuery( '#' + id );
    this.Canvas = jQuery( '#' + this.cid );
    this.InfoWindow;

    this.init = function ( options ) {
        this.Options = options;
        this.Container
            .css( 'width', options.mapWidth )
            .css( 'height', options.mapHeight )
            .css( 'background-color', 'black' )
            .css( 'background', 'url(media/sobipro/progress/ajax-loader.gif) center center no-repeat' )
            .fadeTo( 'slow', 0.2 );
        this.getEntries();
        return this;
    };
    this.getEntries = function () {
        var handler = this;
        jQuery.ajax( {
            url:'index.php',
            type:'POST',
            dataType:'json',
            data:{
                'option':'com_sobipro',
                'task':'geomod.load',
                'sid':this.Options.sid,
                'format':'raw',
                'section': this.Options.pid,
                'ctask': this.Options.task
            },
            success:function ( response ) {
                handler.InitMap( response );
            }
        } );
    };
    this.InitMap = function ( response ) {
        this.Position = new google.maps.LatLng( parseFloat( this.Options.startLatitude ), parseFloat( this.Options.startLongitude ) );
        var views = [];
        for ( i = 0; i < this.Options.availableViews.length; i++ ) {
            views[ i ] = google.maps.MapTypeId[ String( this.Options.availableViews[ i ] ).toUpperCase() ];
        }
        var options = {
            zoom:parseFloat( this.Options.zoomLevel ),
            mapTypeId:google.maps.MapTypeId[ String( this.Options.defaultView ).toLocaleUpperCase() ]
        };
        for ( var i in this.Options.mapOptions ) {
            options[ i ] = this.Options.mapOptions[ i ];
        }
        if ( views.length > 0 ) {
            options[ 'mapTypeControlOptions' ] = { mapTypeIds:views };
        }
        this.Canvas
            .css( 'width', this.Options.mapWidth )
            .css( 'height', this.Options.mapHeight );
        this.Map = new google.maps.Map( document.getElementById( this.cid ), options );
        this.Map.setCenter( this.Position );
        var handler = this;
        for ( var i = 0; i < response.entries.length; i++ ) {
            var latLng = new google.maps.LatLng( parseFloat( response.entries[ i ].latitude ), parseFloat( response.entries[ i ].longitude ) );
            var marker = new google.maps.Marker( { 'position':latLng } );
            marker.sid = response.entries[ i ].sid;
            google.maps.event.addListener( marker, 'click', function () {
                handler.OpenInfo( this );
            } );
            this.Markers.push( marker );
        }
        var markerCluster = new MarkerClusterer( this.Map, this.Markers );
        this.Container.fadeTo( 'slow', 1 ).css( 'background', 'none' );
        if( response.msg.length ) {
            alert( response.msg );
        }
    };
    this.OpenInfo = function ( marker ) {
        var handler = this;
        try {
            this.InfoWindow.close();
        } catch ( e ) {}
        this.InfoWindow = new google.maps.InfoWindow();
        this.InfoWindow.setContent( '<img src="media/sobipro/progress/ajax-loader.gif"/>' );
        this.InfoWindow.open( this.Map, marker );
        jQuery.ajax( {
            url:'index.php',
            type:'POST',
            dataType:'json',
            data:{
                'option':'com_sobipro',
                'task':'geomod.info',
                'sid': marker.sid,
                'format':'raw',
                'iid': handler.Options.iid
            },
            success:function ( response ) {
                handler.InfoWindow.setContent( response.html );
            }
        } );
    };
}

