<?php
/**
 * @version: $Id: geomap.php 1798 2011-08-09 09:55:59Z Radek Suski $
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
 * $Date: 2011-08-09 11:55:59 +0200 (Di, 09 Aug 2011) $
 * $Revision: 1798 $
 * $Author: Radek Suski $
 */
defined( 'SOBIPRO' ) || exit( 'Restricted access' );
SPLoader::loadClass( 'opt.fields.inbox' );
/**
 * @author Radek Suski
 * @version 1.0
 * @created 28-Nov-2009 20:06:23
 */
class SPField_GeoMap extends SPField_Inbox implements SPFieldInterface
{
	/**
	 * @var int
	 */
	protected $width =  400;
	/**
	 * @var int
	 */
	protected $height =  200;
	/**
	 * @var int
	 */
	protected $formWidth = 500;
	/**
	 * @var int
	 */
	protected $formHeight = 300;
	/**
	 * @var array
	 */
	protected $addrFields = '';
	/**
	 * @var int
	 */
	protected $bubble = 0;
	/**
	 * @var int
	 */
	protected $defView = 'ROADMAP';
	/**
	 * @var int
	 */
	protected $defFormfView = 1;
	/**
	 * @var array
	 */
	protected $mapViews = array( 'ROADMAP', 'SATELLITE', 'HYBRID', 'TERRAIN' );
	/**
	 * @var array
	 */
	protected $formMapViews = array( 'ROADMAP', 'SATELLITE', 'HYBRID' );
	/**
	 * @var int
	 */
	protected $defFormView = 'ROADMAP';
	/**
	 * @var int
	 */
	protected $zoomLevel = 10;
	/**
	 * @var int
	 */
	protected $formZoomLevel = 10;
	/**
	 * @var int
	 */
	protected $zoomCtrl = 1;
	/**
	 * @var int
	 */
	protected $mapCtrl = 1;
	/**
	 * @var int
	 */
	protected $overviewCtrl = 1;
	/**
	 * @var int
	 */
	protected $scaleCtrl = 1;
	/**
	 * @var int
	 */
	protected $determineLocation = 1;
	/**
	 * @var string
	 */
	protected $defRegion = '';
	/**
	 * @var string
	 */
	protected $startPoint = '';
	/**
	 * @var string
	 */
	private $_data = array();
	/**
	 * @var array
	 */
	private $_possibleMapOpt = array( 'panControl', 'zoomControl', 'mapTypeControl', 'scaleControl', 'streetViewControl', 'overviewMapControl' );
	/**
	 * @var array
	 */
	protected $mapOpt = array(  'zoomControl', 'mapTypeControl' );
	/**
	 * @var array
	 */
	protected $mapFormOpt = array(  'zoomControl', 'mapTypeControl' );


	/**
	 * Returns the parameter list
	 * @return array
	 */
	protected function getAttr()
	{
		$attr = get_class_vars( __CLASS__ );
		unset( $attr[ '_attr' ] );
		unset( $attr[ '_possibleMapOpt' ] );
		unset( $attr[ '_selected' ] );
		if( isset( $attr[ 'dType' ] ) ) {
			unset( $attr[ 'dType' ] );
		}
		return array_keys( $attr );
	}

	/**
	 * Shows the field in the edit entry or add entry form
	 * @param bool $return return or display directly
	 * @return string
	 */
	public function field( $return = false )
	{
		if( !( $this->enabled ) ) {
			return false;
		}
		SPLang::load( 'SpApp.geomap' );
		SPFactory::header()->addJsFile( 'jquery' );
		SPFactory::header()->addJsFile( 'geomap' );
		SPFactory::header()->addJsUrl( 'http://maps.google.com/maps/api/js?sensor='.( $this->determineLocation ? 'true' : 'false' ) );
		if( $this->determineLocation ) {
			SPFactory::header()->addJsUrl( 'http://code.google.com/apis/gears/gears_init.js' );
		}
		$data = $this->getData( true );
		$lat = null;
		$lng = null;
		if( isset( $data[ 'latitude' ] ) && isset( $data[ 'longitude' ] ) ) {
			$lat = $data[ 'latitude' ];
			$lng = $data[ 'longitude' ];
			$sp = array( 'Lat' => $lat, 'Long' => $lng, 'Marker' => true );
		}
		else {
			$sp = explode( ',', $this->startPoint );
			if( count( $sp ) > 1 ) {
				$sp = array( 'Lat' => trim( $sp[ 0 ] ), 'Long' => trim( $sp[ 1 ] ), 'Marker' => false );
			}
			else {
				$sp = array( 'Lat' => 0, 'Long' => 0, 'Marker' => false );
			}
		}
		$options = array();
		if( !( is_array( $this->mapFormOpt ) ) ) {
			$this->mapFormOpt = array();
		}
		foreach ( $this->_possibleMapOpt as $opt ) {
			$options[ 'MapOpt' ][ $opt ] = in_array( $opt, $this->mapFormOpt );
		}
		$options[ 'Id' ] = $this->nid;
		$options[ 'MapTypeId' ] = $this->defFormView;
		$options[ 'Views' ] = $this->formMapViews;
		$options[ 'StartPoint' ] = $sp;
		$options[ 'Sensor' ] = $this->determineLocation;
		$options[ 'Zoom' ] = $this->formZoomLevel;
		$options[ 'Fields' ] = explode( ',', $this->addrFields );
		foreach ( $options[ 'Fields' ] as $i => $field ) {
			$options[ 'Fields' ][ $i ] = trim( $field );
		}
		$options[ 'ChngMsg' ] = Sobi::Txt( 'GMFA_JS_REWRITE_ADJ_CONFIRM' );
		$options = json_encode( $options );
		if( $this->isFree || !( $this->fee ) ) {
			SPFactory::header()->addJsCode( "SPGeoEditMapInit( {$options}, false );" );
		}
		else {
			SPFactory::header()->addJsCode( "SPGeoEditMapInit( {$options}, '{$this->nid}Payment' );" );
		}
		$class = $this->required ? $this->cssClass.' required' : $this->cssClass;
		$field = null;
		$field .= "\n<div style=\"width:{$this->formWidth}px; height:{$this->formHeight}px;\" id=\"{$this->nid}_canvas\" class=\"{$class}\">\n";
		$field .= "</div>\n";
		$field .= '<span class="SPGeoLabel">'.Sobi::Txt( 'GMFA_FORM_LATITUDE' ).'</span>';
		$field .= SPHtml_Input::text( $this->nid.'_latitude', $lat, array( 'id' => $this->nid.'_latitude', 'class' => $class ) );
		$field .= '<span class="SPGeoLabel">'.Sobi::Txt( 'GMFA_FORM_LONGITUDE' ).'</span>';
		$field .= SPHtml_Input::text( $this->nid.'_longitude', $lng, array( 'id' => $this->nid.'_longitude', 'class' => $class ) );
		$field = "\n<div id=\"{$this->nid}\">\n{$field}\n</div>\n";
		if( !$return ) {
			echo $field;
		}
		else {
			return $field;
		}
	}

	private function getData( $copy = false )
	{
		$data = array();
		if( count( $this->_data ) ) {
			foreach ( $this->_data as $entry ) {
				$data[ $entry->copy ] = get_object_vars( $entry );
			}
		}
		if( $copy && isset( $data[ 1 ] ) ) {
			return $data[ 1 ];
		}
		return isset( $data[ 0 ] ) ? $data[ 0 ] : array();
	}

	/**
	 * Get field specific values if these are in an other table
	 * @param $sid - id of the entry
	 * @param $fullData - the database row form the spdb_field_data table
	 * @param $rawData - raw data of the field content
	 * @param $fData - full formated data of the field content
	 * @return void
	 */
	public function loadData( $sid )
	{
		$this->_data = SPFactory::db()->select( '*', 'spdb_field_geo', array( 'fid' => $this->fid, 'sid' => $sid ), 'copy' )->loadObjectList();
	}

	/**
	 * Gets the data for a field, verify it and pre-save it.
	 * @param SPEntry $entry
	 * @param string $request
	 * @return void
	 */
	public function submit( &$entry, $tsid = null, $request = 'POST' )
	{
		SPLang::load( 'SpApp.geomap' );
		if( count( $this->verify( $entry, $request ) ) ) {
			return SPRequest::search( $this->nid, $request );
		}
		else {
			return array();
		}
	}

	/**
	 * Returns meta keys
	 */
	public function metaKeys()
	{
		$data = $this->getData( false );
		if( isset( $data[ 'latitude' ] ) && isset( $data[ 'longitude' ] ) ) {
			SPFactory::header()->add( "<meta name=\"ICBM\" content=\"{$data[ 'latitude' ]}, {$data[ 'longitude' ]}\" />" );
			SPFactory::header()->add( "<meta name=\"geo.position\" content=\"{$data[ 'latitude' ]};{$data[ 'longitude' ]}\" />" );
		}
		return null;
	}

	/**
	 * @param SPEntry $entry
	 * @param string $request
	 * @return bool
	 */
	private function verify( $entry, $request )
	{
		$save = array();
		$save[ 'latitude' ] = floatval( SPRequest::raw( $this->nid.'_latitude', null, $request ) );
		$save[ 'longitude' ] = floatval( SPRequest::raw( $this->nid.'_longitude', null, $request ) );
		$dexs = ( $save[ 'latitude' ] && $save[ 'longitude' ] ) ? true : false;
		/* check if it was required */
		if( $this->required && !( $dexs ) ) {
			throw new SPException( SPLang::e( 'FIELD_REQUIRED_ERR', $this->name ) );
		}
		/* check if there was an adminField */
		if( $this->adminField && $dexs ) {
			if( !( Sobi:: Can( 'adm_fields.edit' ) ) ) {
				throw new SPException( SPLang::e( 'FIELD_NOT_AUTH', $this->name ) );
			}
		}
		/* check if it was free */
		if( !( $this->isFree ) && $this->fee && $dexs ) {
			SPFactory::payment()->add( $this->fee, $this->name, $entry->get( 'id' ), $this->fid );
		}
		/* check if it was editLimit */
		if( $this->editLimit == 0 && !( Sobi::Can( 'entry.adm_fields.edit' ) ) && $dexs ) {
			throw new SPException( SPLang::e( 'FIELD_NOT_AUTH_EXP', $this->name ) );
		}
		/* check if it was editable */
		if( !( $this->editable ) && !( Sobi::Can( 'entry.adm_fields.edit' ) ) && $dexs && $entry->get( 'version' ) > 1 ) {
			throw new SPException( SPLang::e( 'FIELD_NOT_AUTH_NOT_ED', $this->name ) );
		}
		return $save;
	}

	/**
	 * Gets the data for a field and save it in the database
	 * @param SPEntry $entry
	 * @return bool
	 */
	public function saveData( &$entry, $request = 'POST' )
	{
		if( !( $this->enabled ) ) {
			return false;
		}
		/* @var SPdb $db */
		$db =& SPFactory::db();
		$data = $this->verify( $entry, $request );
		$time = SPRequest::now();
		$IP = SPRequest::ip( 'REMOTE_ADDR', 0, 'SERVER' );
		$uid = Sobi::My( 'id' );

		$params = array();
		/* collect the needed params */
		$params[ 'publishUp' ] = $entry->get( 'publishUp' );
		$params[ 'publishDown' ] = $entry->get( 'publishDown' );
		$params[ 'fid' ] = $data[ 'fid' ] = $this->fid;
		$params[ 'sid' ] = $data[ 'sid' ]= $entry->get( 'id' );
		$params[ 'section' ] = $data[ 'section' ] = Sobi::Reg( 'current_section' );
		$params[ 'lang' ] = Sobi::Lang();
		$params[ 'enabled' ] = $entry->get( 'state' );
		$params[ 'params' ] = null;
		$params[ 'options' ] = null;
		$params[ 'baseData' ] = null;
		$params[ 'approved' ] = $entry->get( 'approved' );
		$params[ 'confirmed' ] = $entry->get( 'confirmed' );
		/* if it is the first version, it is new entry */
		if( $entry->get( 'version' ) == 1 ) {
			$params[ 'createdTime' ] = $time;
			$params[ 'createdBy' ] = $uid;
			$params[ 'createdIP' ] = $IP;
		}
		$params[ 'updatedTime' ] = $time;
		$params[ 'updatedBy' ] = $uid;
		$params[ 'updatedIP' ] = $IP;
		$params[ 'copy' ] = $data[ 'copy' ] = !( $entry->get( 'approved' ) );
		if( Sobi::My( 'id' ) == $entry->get( 'owner' ) ) {
			--$this->editLimit;
		}
		$params[ 'editLimit' ] = $this->editLimit;

		/* save it */
		try {
			$params[ 'baseData' ] = SPConfig::serialize( array( 'latitude' => $data[ 'latitude' ], 'longitude' => $data[ 'longitude' ] ) );
			$db->insertUpdate( 'spdb_field_data', $params );
			$db->insertUpdate( 'spdb_field_geo', $data );
		}
		catch ( SPException $x ) {
			Sobi::Error( __CLASS__, SPLang::e( 'CANNOT_SAVE_DATA', $x->getMessage() ), SPC::WARNING, 0, __LINE__, __FILE__ );
		}
	}

	public function approve( $sid )
	{
		$db =& SPFactory::db();
        try {
        	$db->select( 'COUNT( fid )', 'spdb_field_geo', array( 'sid' => $sid, 'copy' => '1', 'fid' => $this->fid ) );
        	$copy = $db->loadResult();
        	if( $copy ) {
        		$db->delete( 'spdb_field_geo', array( 'sid' => $sid, 'copy' => '0', 'fid' => $this->fid ) );
        		$db->update( 'spdb_field_geo', array( 'copy' => '0' ), array( 'sid' => $sid, 'copy' => '1', 'fid' => $this->fid ), 1 );
        	}
        } catch ( SPException $x ) {
        	Sobi::Error( $this->name(), SPLang::e( 'CANNOT_GET_FIELDS_DATA_DB_ERR', $x->getMessage() ), SPC::ERROR, 500, __LINE__, __FILE__ );
        }
        parent::approve( $sid );
	}

	/* (non-PHPdoc)
	 * @see Site/opt/fields/SPFieldType#deleteData($sid)
	 */
	public function deleteData( $sid )
	{
		SPFactory::db()->delete( 'spdb_field_geo', array( 'fid' => $this->fid, 'sid' => $sid ) );
	}

	public function delete()
	{
		SPFactory::db()->delete( 'spdb_field_geo', array( 'fid' => $this->fid ) );
	}

	/**
	 * @return array
	 */
	public function struct()
	{
		SPLang::load( 'SpApp.geomap' );
		$data = $this->getData( false );
		if( count( $data ) && isset( $data[ 'latitude' ] ) && isset( $data[ 'longitude' ] ) && ( $data[ 'latitude' ] + $data[ 'longitude' ] ) != 0 ) {
			SPFactory::header()->addJsFile( 'jquery' );
			SPFactory::header()->addJsFile( 'geomap' );
			SPFactory::header()->addJsUrl( 'http://maps.google.com/maps/api/js?sensor='.( $this->determineLocation ? 'true' : 'false' ) );
			$canvasId = "{$this->nid}_canvas_{$data[ 'sid' ]}";
			$options = array();
			if( !( is_array( $this->mapOpt ) ) ) {
				$this->mapOpt = array();
			}
			foreach ( $this->_possibleMapOpt as $opt ) {
				$options[ 'MapOpt' ][ $opt ] = in_array( $opt, $this->mapOpt );
			}
			$options[ 'Id' ] = $canvasId;
			$options[ 'MapTypeId' ] = $this->defView;
			$options[ 'Views' ] = $this->mapViews;
			$options[ 'Marker' ] = $sp = array( 'Lat' => $data[ 'latitude' ], 'Long' => $data[ 'longitude' ], 'Bubble' => $this->bubble, );
			$options[ 'Zoom' ] = $this->zoomLevel;
			$options = json_encode( $options );
			SPFactory::header()->addJsCode( "SPShowGeoMap( {$options} );" );
			return array (
				'_complex' => 1,
				'_data' => array( 'div' => 	array(
						'_complex' => 1,
						'_data' => ' ',
						'_attributes' => array( 'style' => "width:{$this->width}px; height:{$this->height}px;", 'id' =>  $canvasId )
					)
			 	),
			);
		}
	}
}