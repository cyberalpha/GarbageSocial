<?php
/**
 * @version: $Id: category.php 2281 2012-03-07 17:14:00Z Radek Suski $
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
 * $Date: 2012-03-07 18:14:00 +0100 (Wed, 07 Mar 2012) $
 * $Revision: 2281 $
 * $Author: Radek Suski $
 * File location: components/com_sobipro/lib/models/category.php $
 */

defined( 'SOBIPRO' ) || exit( 'Restricted access' );
SPLoader::loadModel( 'datamodel' );
SPLoader::loadModel( 'dbobject' );
/**
 * @author Radek Suski
 * @version 1.0
 * @created 10-Jan-2009 5:10:32 PM
 */
class SPCategory extends SPDBObject implements SPDataModel
{
	/**
	 * @var string
	 */
	protected $description = null;
	/**
	 * @var string
	 */
	protected $icon = null;
	/**
	 * @var int
	 */
	protected $showIcon = 2;
	/**
	 * @var string
	 */
	protected $introtext = null;
	/**
	 * @var int
	 */
	protected $showIntrotext = 2;
	/**
	 * @var int
	 */
	protected $parseDesc = 2;
	/**
	 * @var int
	 */
	protected $position = 0;
	/**
	 * @var int
	 */
	protected $section = 0;
	/**
	 * @var string
	 */
	protected $oType = 'category';
	/**
	 * @var int
	 */
	protected $parent = 0;
	/**
	 * @var array
	 */
	private static $types = array (
		'description' => 'html',
		'icon' => 'string',
		'showIcon' => 'int',
		'introtext' => 'string',
		'showIntrotext' => 'int',
		'parseDesc' => 'int',
		'position' => 'int'
	);
	/**
	 * @var array
	 */
	private static $translatable = array( 'description', 'introtext' );
	/**
	 */
	protected $_dbTable = 'spdb_category';

	/**
	 */
	public function save()
	{
		/* initial org settings */
		/* @var SPdb $db */
		$db	=& SPFactory::db();
		/* check nid */
		$c = 1;
		while ( $c ) {
			/* category name id in section has to be unique */
			try {
				$cond = array( 'oType' => 'category', 'nid' => $this->nid, 'parent' => $this->parent );
				if( $this->id ) {
					$cond[ '!id' ] = $this->id;
				}
				$db->select( 'COUNT( nid )', 'spdb_object', $cond );
				$c = $db->loadResult();
				if( $c > 0 ) {
					$this->nid = $this->nid.'_'.rand( 0, 1000 );
				}
			}
			catch ( SPException $x ) {
				Sobi::Error( $this->name(), SPLang::e( 'CANNOT_SAVE_CATEGORY_DB_ERR', $x->getMessage() ), SPC::ERROR, 500, __LINE__, __FILE__ );
			}
		}

		$db->transaction();
		parent::save();
		$properties = get_class_vars( __CLASS__ );

		/* get database colums and their ordering */
		$cols	= $db->getColumns( $this->_dbTable );
		$values = array();

		/* and sort the properties in the same order */
		foreach ( $cols as $col ) {
			$values[ $col ] = key_exists( $col, $properties ) ? $this->$col : '';
		}
		Sobi::Trigger( $this->name(), ucfirst( __FUNCTION__ ), array( &$values ) );
 		/* try to save */
		try {
			$db->insertUpdate( $this->_dbTable, $values );
		}
		catch ( SPException $x ) {
			$db->rollback();
			Sobi::Error( $this->name(), SPLang::e( 'CANNOT_SAVE_CATEGORY_DB_ERR', $x->getMessage() ), SPC::ERROR, 500, __LINE__, __FILE__ );
		}

		/* insert relation */
		try {
			$db->delete( 'spdb_relations', array( 'id' => $this->id, 'oType' => 'category' ) );
			if( !$this->position ) {
				$db->select( 'MAX( position ) + 1', 'spdb_relations', array( 'pid' => $this->parent, 'oType' => 'category' ) );
				$this->position = ( int ) $db->loadResult();
				if( !$this->position ) {
					$this->position = 1;
				}
			}
			$db->insertUpdate( 'spdb_relations', array( 'id' => $this->id, 'pid' => $this->parent, 'oType' => 'category', 'position' => $this->position, 'validSince' => $this->validSince, 'validUntil' => $this->validUntil ) );
		}
		catch ( SPException $x ) {
			$db->rollback();
			Sobi::Error( $this->name(), SPLang::e( 'CANNOT_SAVE_CATEGORY_DB_ERR', $x->getMessage() ), SPC::ERROR, 500, __LINE__, __FILE__ );
		}

		/* if there was no errors, commit the database changes */
		$db->commit();

		SPFactory::cache()
                ->purgeSectionVars()
		        ->deleteObj( 'category', $this->id )
                ->deleteObj( 'category', $this->parent );
		/* trigger plugins */
		Sobi::Trigger( 'afterSave', $this->name(), array( &$this ) );
	}

	/**
	 */
	public function loadTable()
	{
		parent::loadTable();
		/* @var SPdb $db */
		$db =& SPFactory::db();
		try {
			$db->select( array( 'position', 'pid' ), 'spdb_relations', array( 'id' => $this->id ) );
			$r = $db->loadObject();
			Sobi::Trigger( $this->name(), ucfirst( __FUNCTION__ ), array( &$r ) );
			$this->position = $r->position;
			$this->parent = $r->pid;
		}
		catch ( SPException $x ) {
			Sobi::Error( $this->name(), SPLang::e( 'DB_REPORTS_ERR', $x->getMessage() ), SPC::WARNING, 0, __LINE__, __FILE__ );
		}
		if( SPRequest::task() != 'category.edit'  ) {
			if( $this->parseDesc == SPC::GLOBAL_SETTING ) {
				$this->parseDesc = Sobi::Cfg( 'category.parse_desc', true );
			}
			if( $this->parseDesc ) {
				Sobi::Trigger( 'Parse', 'Content', array( &$this->description ) );
			}
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see Site/lib/models/SPDBObject#delete()
	 * @param bool $childs - update child entries parent
	 */
	public function delete( $childs = true )
	{
		parent::delete();
		SPFactory::cache()->cleanSection();
		SPFactory::cache()->deleteObj( 'category', $this->id );
		try {
			/* get all child cats and delete these too */
			$childs = $this->getChilds( 'category', true );
			if( count( $childs ) ) {
				foreach ( $childs as $child ) {
					$cat = new self();
					$cat->init( $child );
					$cat->delete( false );
				}
			}
			$childs[ $this->id ] = $this->id;
			SPFactory::db()->delete( 'spdb_category', array( 'id' => $this->id ) );
			if( $childs ) {
				SPFactory::db()->update( 'spdb_object', array( 'parent' => Sobi::Section() ), array( 'parent' => $childs ) );
			}
		}
		catch ( SPException $x ) {
			Sobi::Error( $this->name(), SPLang::e( 'ANNOT_DELETE_CATEGORY_DB_ERR', $x->getMessage() ), SPC::WARNING, 0, __LINE__, __FILE__ );
		}
	}
	/**
	 * @return array
	 */
	protected function types()
	{
		return self::$types;
	}

	/**
	 * @return array
	 */
	protected function translatable()
	{
		return self::$translatable;
	}
}
?>
