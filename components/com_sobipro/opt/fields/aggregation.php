<?php
/**
 * @version: $Id: aggregation.php 1800 2011-08-09 09:59:04Z Radek Suski $
 * @package: SobiPro Aggregation Field Application
 * ===================================================
 * @author
 * Name: Sigrid Suski & Radek Suski, Sigsiu.NET GmbH
 * Email: sobi[at]sigsiu.net
 * Url: http://www.Sigsiu.NET
 * ===================================================
 * @copyright Copyright (C) 2006 - 2011 Sigsiu.NET GmbH (http://www.sigsiu.net). All rights reserved.
 * @license see http://www.gnu.org/licenses/gpl.html GNU/GPL Version 3.
 * You can use, redistribute this file and/or modify it under the terms of the GNU General Public License version 3
 * ===================================================
 * $Date: 2011-08-09 11:59:04 +0200 (Tue, 09 Aug 2011) $
 * $Revision: 1800 $
 * $Author: Radek Suski $
 */

defined( 'SOBIPRO' ) || exit( 'Restricted access' );
SPLoader::loadClass( 'opt.fields.chbxgroup' );
/**
 * @author Radek Suski
 * @version 1.0
 * @created 25-Apr-2011 20:06:23
 */
class SPField_Aggregation extends SPField_ChbxGr implements SPFieldInterface
{
	/**
	 * @var string
	 */
	protected $cssClass = '';
	/**
	 * @var int
	 */
	protected $width = 400;
	/**
	 * @var int
	 */
	protected $height = 100;
	/**
	 * @var int
	 */
	protected $numberOfTags = 10;
	/**
	 * @var int
	 */
	protected $maxLength = 50;
	/**
	 * @var int
	 */
	protected $ssize = 1;
	/**
	 * @var int
	 */
	protected $swidth = 350;
	/**
	 * @var string
	 */
	protected $searchMethod = 'general';
	/**
	 * @var string
	 */
	protected $jQUiTheme = 'smoothness.smoothness';
	/**
	 * @var string
	 */
	protected $atText = '';
	/**
	 * @var string
	 */
	protected $defSel = '';
	/**
	 * @var string
	 */
	protected $sepSign = ', ';

	/**
	 * Returns the parameter list
	 * @return array
	 */
	protected function getAttr()
	{
		$attr = get_class_vars( __CLASS__ );
		unset( $attr[ '_attr' ] );
		unset( $attr[ '_selected' ] );
		return array_keys( $attr );
	}

	public function __construct ( &$field )
	{
		parent::__construct ($field);

		SPLang::load( 'SpApp.aggregation' );
		if (strlen($this->atText) == 0)
			$this->atText = Sobi::Txt( 'AFA_ADD_NEW');
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
		$this->jQUiTheme = Sobi::Cfg( 'jquery.ui_theme', 'smoothness.smoothness' );
		SPFactory::header()->addJsFile( 'jquery' );
		SPFactory::header()->addJsFile( 'jquery-ui' );
		SPFactory::header()->addJsFile( 'tagsinput' );
		SPFactory::header()->addCssFile( 'tagsinput' );
		SPFactory::header()->addCssFile( 'jquery-ui.'.$this->jQUiTheme );
		$opt = array(
			'height' => "{$this->height}px",
			'width' => "{$this->width}px",
			'unique' => true,
			'defaultText' => $this->atText,
			'limMsg' => Sobi::Txt( 'AFA_LIMIT_MSG', $this->maxLength ),
			'limit' => $this->numberOfTags,
			'maxLength' => $this->maxLength
		);
		$opt = json_encode( $opt );
		SPFactory::header()->addJsCode( "jQuery( document ).ready( function() { jQuery( '#{$this->nid}' ).SPAtagsInput( {$opt} ); } );" );
		$field = null;
		$class =  $this->required ? $this->cssClass.' required' : $this->cssClass;
		$params = array( 'id' => $this->nid, 'size' => $this->width, 'class' => $class );
		$selected = $this->getRaw();
		$selected = ( !( is_string( $selected ) ) && is_array( $selected ) ) ? implode( ',', $selected ) : $this->defSel;
		if( $this->width ) {
			$params[ 'style' ] = "width: {$this->width}px;";
		}
		$field = SPHtml_Input::text( $this->nid, $selected, $params );
		if( !$return ) {
			echo $field;
		}
		else {
			return $field;
		}
	}

	/**
	 * Gets the data for a field, verify it and pre-save it.
	 * @param SPEntry $entry
	 * @param string $request
	 * @return void
	 */
	public function submit( &$entry, $tsid = null, $request = 'POST' )
	{
		$save = array();
		if( $this->verify( $entry, $request ) ) {
			$save = SPRequest::search( $this->nid, $request );
		}
		return $save;
	}

	/**
	 * @param SPEntry $entry
	 * @param string $request
	 * @return bool
	 */
	private function verify( $entry, $request )
	{
		$data = SPRequest::raw( $this->nid, null, $request );
		$dexs = strlen( $data );
		/* check if it was required */
		if( $this->required && !( $dexs ) ) {
			throw new SPException( SPLang::e( 'FIELD_REQUIRED_ERR', $this->name ) );
		}
		/* check if there was a filter */
		if( $this->filter && $dexs ) {
			$registry =& SPFactory::registry();
			$registry->loadDBSection( 'fields_filter' );
			$filters = $registry->get( 'fields_filter' );
			$filter = isset( $filters[ $this->filter ] ) ? $filters[ $this->filter ] : null;
			if( !( count( $filter ) ) ) {
				throw new SPException( SPLang::e( 'FIELD_FILTER_ERR', $this->filter ) );
			}
			else {
				$tags = explode( ',', $data );
				foreach ( $tags as $tag ) {
					if( !( preg_match( base64_decode( $filter[ 'params' ] ), $tag ) ) ) {
						throw new SPException( str_replace( '$field', $this->name, SPLang::e( $filter[ 'description' ] ) ) );
					}
				}
			}
		}
		/* check if there was an adminField */
		if( $this->adminField && $dexs ) {
			if( !( Sobi:: Can( 'entry.adm_fields.edit' ) ) ) {
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
		if( !( $dexs ) ) {
			$data = null;
		}
		return $data;
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
		$data = $this->verify( $entry, $request );
		$time = SPRequest::now();
		$IP = SPRequest::ip( 'REMOTE_ADDR', 0, 'SERVER' );
		$uid = Sobi::My( 'id' );

		/* if we are here, we can save these data */
		/* @var SPdb $db */
		$db =& SPFactory::db();

		/* collect the needed params */
		$params = array();
		$params[ 'publishUp' ] = $entry->get( 'publishUp' );
		$params[ 'publishDown' ] = $entry->get( 'publishDown' );
		$params[ 'fid' ] = $this->fid;
		$params[ 'sid' ] = $entry->get( 'id' );
		$params[ 'section' ] = Sobi::Reg( 'current_section' );
		$params[ 'lang' ] = Sobi::Lang();
		$params[ 'enabled' ] = ( int ) $entry->get( 'state' );
		$params[ 'params' ] = null;
		$params[ 'options' ] = null;
		$params[ 'baseData' ] = strip_tags( $db->escape( $data ) );
		$params[ 'approved' ] = ( int ) $entry->get( 'approved' );
		$params[ 'confirmed' ] = ( int ) $entry->get( 'confirmed' );
		/* if it is the first version, it is new entry */
		if( $entry->get( 'version' ) == 1 ) {
			$params[ 'createdTime' ] = $time;
			$params[ 'createdBy' ] = $uid;
			$params[ 'createdIP' ] = $IP;
		}
		$params[ 'updatedTime' ] = $time;
		$params[ 'updatedBy' ] = $uid;
		$params[ 'updatedIP' ] = $IP;
		$params[ 'copy' ] = ( int ) !( $entry->get( 'approved' ) );
		if( Sobi::My( 'id' ) == $entry->get( 'owner' ) ) {
			--$this->editLimit;
		}
		$params[ 'editLimit' ] = $this->editLimit;

		/* save it */
		try {
			$db->insertUpdate( 'spdb_field_data', $params );
		}
		catch ( SPException $x ) {
			Sobi::Error( __CLASS__, SPLang::e( 'CANNOT_SAVE_DATA', $x->getMessage() ), SPC::WARNING, 0, __LINE__, __FILE__ );
		}
		/* @todo: when tags are removed/deleted - check if these are used by others and optionaly delete */
		$tags = explode( ',', $data );
		if( count( $tags ) ) {
			$options = array();
			$labels = array();
			$selected = array();
			foreach ( $tags as $tag ) {
				if( !strlen( $tag ) ) {
					continue;
				}
				$options[] = array( 'fid' => $this->id, 'optValue' => $tag, 'optPos'  => 0, 'optParent' => 0 );
				$labels[] = array( 'sKey' => $tag, 'sValue' => $tag, 'language' => Sobi::Lang(), 'oType' => 'field_option', 'fid' => $this->id );
				$selected[] = array( 'fid' => $this->fid, 'sid' => $entry->get( 'id' ), 'optValue' => $tag,'copy' => $params[ 'copy' ], 'params' => null );
				if( Sobi::Lang() != Sobi::DefLang() ) {
					$labels[] = array( 'sKey' => $tag, 'sValue' => $tag, 'language' => Sobi::DefLang(), 'oType' => 'field_option', 'fid' => $this->id );
				}
			}
			/* delete old selected values */
			try {
				$db->delete( 'spdb_field_option_selected', array( 'fid' => $this->fid, 'sid' => $entry->get( 'id' ), 'copy' => $params[ 'copy' ] ) );
			}
			catch ( SPException $x ) {
				Sobi::Error( __CLASS__, SPLang::e( 'CANNOT_DELETE_PREVIOUS_DATA', $x->getMessage() ), SPC::WARNING, 0, __LINE__, __FILE__ );
			}

			if( count( $options ) ) {
				try {
					$db->insertArray( 'spdb_field_option', $options, true );
					$db->insertArray( 'spdb_language', $labels, true );
					$db->insertArray( 'spdb_field_option_selected', $selected, true );
				}
				catch ( SPException $x ) {
					Sobi::Error( $this->name(), SPLang::e( 'CANNOT_STORE_FIELD_OPTIONS_DB_ERR', $x->getMessage() ), SPC::ERROR, 500, __LINE__, __FILE__ );
				}
			}
		}
		elseif ( $entry->get( 'version' ) > 1 ) {
			if( !( $entry->get( 'approved' ) ) ) {
				try {
					$db->update( 'spdb_field_option_selected', array( 'copy' => 1 ), array( 'fid' => $this->fid, 'sid' => $entry->get( 'id' ) ) );
				}
				catch ( SPException $x ) {
					Sobi::Error( __CLASS__, SPLang::e( 'CANNOT_UPDATE_PREVIOUS_DATA', $x->getMessage() ), SPC::WARNING, 0, __LINE__, __FILE__ );
				}
			}
			else {
				/* delete old selected values */
				try {
					$db->delete( 'spdb_field_option_selected', array( 'fid' => $this->fid, 'sid' => $entry->get( 'id' ) ) );
				}
				catch ( SPException $x ) {
					Sobi::Error( __CLASS__, SPLang::e( 'CANNOT_DELETE_PREVIOUS_DATA', $x->getMessage() ), SPC::WARNING, 0, __LINE__, __FILE__ );
				}
			}
		}
	}

	/**
	 * @return array
	 */
	public function struct()
	{
		$data = parent::struct();
		$tags = $this->getRaw();
		$struct = array();
		$this->cssClass = ( strlen( $this->cssClass ) ? $this->cssClass : 'spFieldsData' );
		if( count( $tags ) && is_array( $tags ) && !( is_string( $tags ) ) ) {
			$ss = array( '_complex' => 1, '_data' => $this->sepSign, '_attributes' => array( 'class' => $this->cssClass ) );
			$c = count( $tags );
			foreach ( $tags as $tag => $label ) {
				$c--;
				if( !( strlen( $tag ) && strlen( $label ) ) ) {
					continue;
				}
				$tag = array(
					'_complex' => 1,
					'_data' => $tag,
					'_attributes' => array( 'href' => Sobi::Url( array( 'task' => 'list.tag.'.$this->nid, 'tag' => urlencode( $tag ), 'sid' => Sobi::Section() ) ), 'class' => $this->cssClass )
				);
				if( $c ) {
					$struct[] = array( 'a' => $tag, 'span' => $ss );
				}
				else {
					$struct[] = array( 'a' => $tag );
				}
			}
		}
		if( count( $struct ) ) {
			return array(
				'_complex' => 1,
				'_data' => array( 'span' => array( '_complex' => 1, '_data' => $struct, '_attributes' => array( /* 'id' => $this->nid, */ 'class' => $this->cssClass.' '.$this->nid ) ) ),
				'_attributes' => array( 'lang' => $this->lang, ),
			);
		}
	}
}