<?php
/**
 * @version: $Id: qrcode.php 1874 2011-09-08 10:11:07Z Radek Suski $
 * @package: SobiPro QR-Code Field Application
 * ===================================================
 * @author
 * Name: Sigrid Suski & Radek Suski, Sigsiu.NET GmbH
 * Email: sobi[at]sigsiu.net
 * Url: http://www.Sigsiu.NET
 * ===================================================
 * @copyright Copyright (C) 2006 - 2011 Sigsiu.NET GmbH (http://www.sigsiu.net). All rights reserved.
 * @license see http://www.gnu.org/licenses/gpl.html GNU/GPL Version 3.
 * You can use, redistribute this file and/or modify it under the terms of the GNU General Public License version 3
 * 'QR Code' is registered trademark of DENSO WAVE INCORPORATED.
 * ===================================================
 * $Date: 2011-09-08 12:11:07 +0200 (Do, 08 Sep 2011) $
 * $Revision: 1874 $
 * $Author: Radek Suski $
 */

defined( 'SOBIPRO' ) || exit( 'Restricted access' );
SPLoader::loadClass( 'opt.fields.inbox' );
/**
 * @author Radek Suski
 * @version 1.0
 * @created 25-Apr-2011 20:06:23
 */
class SPField_QRCode extends SPFieldType implements SPFieldInterface
{
	/**
	 * @var string
	 */
	protected $cssClass = '';
	/**
	 * @var string
	 */
	protected $qrData = '{entry.url}';
	/**
	 * @var string
	 */
	protected $ecc = 'H';
	/**
	 * @var int
	 */
	protected $pointSize = 2;
	/**
	 * @var string
	 */
	protected $savePath = 'images/sobipro/qrcodes/';

	/**
	 * Returns the parameter list
	 * @return array
	 */
	protected function getAttr()
	{
		$attr = get_class_vars( __CLASS__ );
		unset( $attr[ 'savePath' ] );
		return array_keys( $attr );
	}

	public function __construct ( &$field )
	{
		parent::__construct ( $field );
		SPLang::load( 'SpApp.qrcode' );
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
		$field = Sobi::Txt( 'QFA_FORM_NO_ACTION' );
		if( !$return ) {
			echo $field;
		}
		else {
			return $field;
		}
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
		$time = SPRequest::now();
		$IP = SPRequest::ip( 'REMOTE_ADDR', 0, 'SERVER' );
		$uid = Sobi::My( 'id' );

		$data = get_object_vars( $this );
		$data[ 'name' ] = $entry->get( 'nid' );
		$data[ 'id' ] = $entry->get( 'id' );

		$this->deleteCodes( $entry->get( 'id' ) );

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
		$params[ 'baseData' ] = strip_tags( $db->escape( SPConfig::serialize( $data ) ) );
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

	}

	protected function deleteCodes( $sid = 0 )
	{
		if( $sid ) {
			$dir = SPLoader::dirPath( $this->savePath.$this->nid.'.'.$sid, 'root', true );
			if( $dir ) {
				$files = scandir( $dir );
				if( count( $files ) ) {
					foreach ( $files as $file ) {
						if( $file != '.' && $file != '..' && is_file( Sobi::FixPath( $dir.'/'.$file ) ) ) {
							SPFs::delete( Sobi::FixPath( $dir.DS.$file ) );
						}
					}
				}
			}
		}
		else {
			$dir = SPLoader::dirPath( $this->savePath.$this->nid, 'root', true );
			SPConfig::debOut();
			$dirs = scandir( $dir );
			if( count( $dirs ) ) {
				foreach ( $dirs as $eid ) {
					$this->deleteCodes( $eid );
				}
			}
		}
	}

	private function createImage( $entry, $filepath )
	{
		$entry->url = Sobi::Url(
			array(
				'title' => $entry->get( 'name' ),
				'pid' => $entry->get( 'primary' ),
				'sid' => $entry->get( 'id' )
			), false, true, true
		);
		$parser = array(
			'entry' => $entry,
			'user' => SPFactory::user(),
			'author' => SPFactory::Instance( 'cms.base.user', $entry->get( 'owner' ) )
		);
		$text = SPLang::replacePlaceHolders( $this->qrData, $parser );
		$text = SPLang::clean( $text );
		$dir = dirname( $filepath );
		if( !( SPFs::exists( $dir ) ) ) {
			SPFs::mkdir( $dir );
		}
	    define( 'QR_CACHE_DIR', SPLoader::dirPath( 'tmp.img.qrcode', 'front', false ) );
	    define( 'QR_LOG_DIR', QR_CACHE_DIR );
		if( !( SPFs::exists( QR_CACHE_DIR ) ) ) {
			SPFs::mkdir( QR_CACHE_DIR );
		}
	    include_once( SPLoader::translatePath( 'lib.services.qrcode.qr' ) );
		QRcode::png( $text, $filepath, $this->ecc, $this->pointSize, 2 );
	}

	/**
	 * @return bool
	 */
	public function searchString( $data, $section ) { return true; }
	public function searchData( $request, $section ) { return true; }
	public function submit( &$entry, $tsid = null, $request = 'POST' ) { return true; }
	public function searchForm( $return = false ) { return true; }

	/**
	 * @return array
	 */
	public function struct()
	{
		$data = SPConfig::unserialize( $this->getRaw() );
		if( is_array( $data ) ) {
			$fname = strtolower( "{$this->nid}/{$data[ 'id' ]}/{$data[ 'name' ]}_{$this->ecc}_{$this->pointSize}_{$this->fid}" );
			$path = SPLoader::translatePath( $this->savePath.$fname, 'root', false, 'png' );
			if( !( SPFs::exists( $path ) ) ) {
				$this->createImage( SPFactory::Entry( $data[ 'id' ] ), $path );
			}
			if( ( SPFs::exists( $path ) ) ) {
				$data = array(
					'_complex' => 1,
					'_data' => null,
					'_attributes' => array(
						'class' => $this->cssClass,
						'src' => Sobi::Cfg( 'live_site' ).$this->savePath.$fname.'.png',
						'alt' => $data[ 'name' ]
				 	)
				);
				return array(
					'_complex' => 1,
					'_data' => array( 'img' => $data ),
					'_attributes' => array(
						'class' => $this->cssClass
				 	)
				);
			}
		}
	}
}