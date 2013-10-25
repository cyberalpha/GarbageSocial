<?php
/**
 * @version: $Id: helper.php 1759 2011-08-02 14:54:17Z Radek Suski $
 * @package: SobiPro Entries Module Application
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
 * $Date: 2011-08-02 16:54:17 +0200 (Di, 02 Aug 2011) $
 * $Revision: 1759 $
 * $Author: Radek Suski $
 */
defined( '_JEXEC' ) || die( 'Direct Access to this location is not allowed.' );
SPLoader::loadController( 'section' );

/**
 * @author Radek Suski
 * @version 1.0
 * @created 04-Apr-2011 10:13:08
 */
class SPEntriesMod extends SPSectionCtrl
{
	public static function ListEntries( $params )
	{
		static $instance = null;
		if( !( $instance ) ) {
			$instance = new self();
		}
		$instance->display( $params );
	}

	public function display( $params )
	{
		$template = SOBI_PATH.'/usr/templates/front/modules/entries/'.$params->get( 'tplFile' );
		if( $params->get( 'tplFile' ) && file_exists( $template ) ) {
			$css = $params->get( 'cssFiles' );
			$css = explode( "\n", $css );
			$document =& JFactory::getDocument();
			$send = false;
			if( count( $css ) ) {
				foreach ( $css as $file ) {
					if( trim( $file ) ) {
						$file = explode( '.', trim( $file ) );
						array_pop( $file );
						$file = implode( '.', $file );
						SPFactory::header()->addCssFile( "root.{$file}", false, null, true );
					}
					$head = SPFactory::header()->getData( 'cssFiles' );
					if( count( $head ) ) {
						foreach ( $head as $html ) {
							$document->addCustomTag( $html );
						}
						$send = true;
					}
				}
			}
			$jsFiles = $params->get( 'jsFiles' );
			$jsFiles = explode( "\n", $jsFiles );
			if( count( $jsFiles ) ) {
				foreach ( $jsFiles as $file ) {
					if( trim( $file ) ) {
						$file = explode( '.', trim( $file ) );
						array_pop( $file );
						$file = implode( '.', $file );
						SPFactory::header()->addJsFile( "root.{$file}", false, null, true );
					}
					$head = SPFactory::header()->getData( 'jsFiles' );
					if( count( $head ) ) {
						$document =& JFactory::getDocument();
						foreach ( $head as $html ) {
							$document->addCustomTag( $html );
						}
						$send = true;
					}
				}
				if( $send ) {
					SPFactory::header()->reset();
				}
			}
			$entries = $this->entries( $params );

			$view = new SPEntriesModView();
			$view->assign( $this->_model, 'section' );
			$view->setTemplate( 'front/modules/entries/'.preg_replace( '/\.xsl$/', null, $params->get( 'tplFile' ) ) );
			$view->assign( SPFactory::user()->getCurrent(), 'visitor' );
			$view->assign( $entries, 'entries' );
			$view->assign( $params->get( 'xmlDeb' ), 'debug' );
			$view->display();
		}
		else {
			Sobi::Error( 'EntriesMod', SPLang::e( 'Template file %s is missing', str_replace( SOBI_ROOT . DS, null, $template ) ), SPC::WARNING, 0 );
		}
	}

	/**
	 * @return array
	 */
	private function entries( $params )
	{
		if( $params->get( 'fieldOrder' ) ) {
			$eOrder = $params->get( 'fieldOrder' );
		}
		else {
			$eOrder = $params->get( 'spOrder' );
		}
		$entriesRecursive = true;
		/* var SPDb $db */
		$db =& SPFactory::db();
		$entries = array();
		$eDir = 'asc';
		$oPrefix = null;
		$conditions = array();

		/* get the ordering and the direction */
		if( strstr( $eOrder, '.' ) ) {
			$eOrder = explode( '.', $eOrder );
			$eDir = $eOrder[ 1 ];
			$eOrder = $eOrder[ 0 ];
		}
		$pid = $params->get( 'sid' );
		$this->setModel( 'section' );
		$this->_model->init( $pid );
		if( $entriesRecursive ) {
			$pids = $this->_model->getChilds( 'category', true );
			if( is_array( $pids ) ) {
				$pids = array_keys( $pids );
			}
			$conditions[ 'sprl.pid' ] = $pids;
		}
		else {
			$conditions[ 'sprl.pid' ] = $pid;
		}
		if( $pid == -1 ) {
			unset( $conditions[ 'sprl.pid' ] );
		}

		/* sort by field */
		if( strstr( $eOrder, 'field_' ) ) {
			static $fields = array();
			$specificMethod = false;
			$field = isset( $fields[ $pid ] ) ? $fields[ $pid ] : null;
			if( !$field ) {
				try {
					$db->select( 'fieldType', 'spdb_field', array( 'nid' => $eOrder ) );
					$fType = $db->loadResult();
				}
				catch ( SPException $x ) {
					Sobi::Error( $this->name(), SPLang::e( 'CANNOT_DETERMINE_FIELD_TYPE', $x->getMessage() ), SPC::WARNING, 0, __LINE__, __FILE__ );
				}
				if( $fType ) {
					$field = SPLoader::loadClass( 'opt.fields.'.$fType );
				}
				$fields[ $pid ] = $field;
			}
			if( $field && method_exists( $field, 'sortBy' ) ) {
				$table = null;
				$oPrefix = null;
				$specificMethod = call_user_func_array( array( $field, 'sortBy' ), array( &$table, &$conditions, &$oPrefix, &$eOrder, &$eDir ) );
			}
			if( !$specificMethod ) {
				$table = $db->join(
					array(
						array( 'table' => 'spdb_field', 'as' => 'fdef', 'key' => 'fid' ),
						array( 'table' => 'spdb_field_data', 'as' => 'fdata', 'key' => 'fid' ),
						array( 'table' => 'spdb_object', 'as' => 'spo', 'key' => array( 'fdata.sid','spo.id' ) ),
						array( 'table' => 'spdb_relations', 'as' => 'sprl', 'key' => array( 'fdata.sid','sprl.id' )  ),
					)
				);
				$oPrefix = 'spo.';
				$conditions[ 'spo.oType' ] = 'entry';
				$conditions[ 'fdef.nid' ] = $eOrder;
				$eOrder = 'baseData.'.$eDir;
			}
		}
		else {
			$table = $db->join( array(
				array( 'table' => 'spdb_relations', 'as' => 'sprl', 'key' => 'id' ),
				array( 'table' => 'spdb_object', 'as' => 'spo', 'key' => 'id' )
			) );
			$conditions[ 'spo.oType' ] = 'entry';
			$eOrder = $eOrder.'.'.$eDir;
			$oPrefix = 'spo.';
		}

		/* check user permissions for the visibility */
		if( Sobi::My( 'id' ) ) {
			$this->userPermissionsQuery( $conditions, $oPrefix );
		}
		else {
			$conditions = array_merge( $conditions, array( $oPrefix.'state' => '1', '@VALID' => $db->valid( $oPrefix.'validUntil', $oPrefix.'validSince' ) ) );
		}
		$conditions[ 'sprl.copy' ] = '0';
		try {
			$db->select( $oPrefix.'id', $table, $conditions, $eOrder, $params->get( 'entriesLimit' ), 0, true );
			$results = $db->loadResultArray();
		}
		catch ( SPException $x ) {
			Sobi::Error( $this->name(), SPLang::e( 'DB_REPORTS_ERR', $x->getMessage() ), SPC::WARNING, 0, __LINE__, __FILE__ );
		}
		if( count( $results ) ) {
			foreach ( $results as $i => $sid ) {
				$entries[ $i ] = $sid;
			}
		}
		return $entries;
	}
}
?>