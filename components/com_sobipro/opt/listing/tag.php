<?php
/**
 * @version: $Id: tag.php 1764 2011-08-03 15:44:04Z Radek Suski $
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
 * $Date: 2011-08-03 17:44:04 +0200 (Wed, 03 Aug 2011) $
 * $Revision: 1764 $
 * $Author: Radek Suski $
 */

defined( 'SOBIPRO' ) || exit( 'Restricted access' );
SPLoader::loadController( 'listing_interface' );
SPLoader::loadController( 'section' );
/**
 * @author Radek Suski
 * @version 1.0
 * @created 15-Apr-2011 20:06:23
 */
class SPTag extends SPSectionCtrl implements SPListing
{
	/**
	 * @var string
	 */
	protected $_defTask = 'list';
	/**
	 * @var string
	 */
	protected $_type = 'listing';
	/**
	 * @var string
	 */
	private $_field = null;
	/**
	 * @var string
	 */
	private $_tag = null;

	/**
	 */
	public function execute()
	{
		SPLang::load( 'SpApp.aggregation' );
		$this->_task = strlen( $this->_task ) ? $this->_task : $this->_defTask;
		$task = explode( '.', SPRequest::task( 'get' ) );
		if( isset( $task[ 3 ] ) && $task[ 3 ] == 'suggest' ) {
			$this->suggest( $task[ 2 ] );
		}
		else {
			$this->view();
		}
	}

	private function suggest( $fid )
	{
		$this->_tag = SPLang::clean( SPRequest::string( 'term' ) );
		$f = SPFactory::db()
			->select( '*', 'spdb_field', array( 'section' => Sobi::Section(), 'nid' => $fid ) )
			->loadObject();
		$suggest = SPFactory::db()
			->dselect( 'sValue', 'spdb_language', array( 'oType' => 'field_option', 'fid' => $f->fid, 'sValue' => "%{$this->_tag}%" ) )
			->loadResultArray();
		header( 'Content-type: application/json' );
		SPFactory::mainframe()->cleanBuffer();
		echo json_encode( $suggest );
		exit();
	}

	protected function view()
	{
		$task = str_replace( ':', '-', SPRequest::task( 'get' ) );
		$task = explode( '.', $task );
		$this->_tag = SPLang::clean( SPRequest::string( 'tag' ) );
		$f = SPFactory::db()
			->select( '*', 'spdb_field', array( 'section' => Sobi::Section(), 'nid' => urldecode( $task[ 2 ] ) ) )
			->loadObject();
		if( $f && isset( $f->fid ) ) {
			$this->_field = SPFactory::Model( 'field' );
			$this->_field->extend( $f );
		}
		else {
			Sobi::Error( $this->name(), SPLang::e( 'SITE_NOT_FOUND_MISSING_PARAMS' ), SPC::NOTICE, 404, __LINE__, __FILE__ );
			exit;
		}
		/* determine template package */
		$tplPckg = Sobi::Cfg( 'section.template', 'default' );
		Sobi::ReturnPoint();

		if( !( $this->_model ) ) {
			$this->setModel( 'section' );
			$this->_model->init( Sobi::Section() );
		}

		/* load template config */
		$this->template();
		$this->tplCfg( $tplPckg );

		/* get limits - if defined in template config - otherwise from the section config */
		$eLimit = $this->tKey( $this->template, 'entries_limit', Sobi::Cfg( 'list.entries_limit', 2 ) );
		$eInLine = $this->tKey( $this->template, 'entries_in_line', Sobi::Cfg( 'list.entries_in_line', 2 ) );

		/* get the site to display */
		$site = SPRequest::int( 'site', 1 );
		$eLimStart = ( ( $site - 1 ) * $eLimit );
		$eCount = count( $this->getEntries( 0, 0, true ) );
		$entries = $this->getEntries( $eLimit, $site );

		$pn = SPFactory::Instance(
			'helpers.pagenav_' . $this->tKey( $this->template, 'template_type', 'xslt' ),
			$eLimit, $eCount, $site,
			array( 'task' => 'list.tag.'.$this->_field->get( 'nid' ), 'tag' => $this->_tag,'sid' => SPRequest::sid() )
		);

		/* handle meta data */
		SPFactory::header()->objMeta( $this->_model );
		SPFactory::mainframe()->addToPathway(
			Sobi::Txt(
				'AFA_PATH_TITLE_FIELD',
				array(
					'tag' => $this->_tag,
					'field' => $this->_field->get( 'name' )
				)
			),
			Sobi::Url( 'current' )
		);
		SPFactory::mainframe()->setTitle(
			Sobi::Txt(
				'AFA_TITLE_FIELD',
				array(
					'tag' => $this->_tag,
					'section' => $this->_model->get( 'name' ),
					'field' => $this->_field->get( 'name' )
				)
			)
		);
		$template = SPLoader::translatePath( 'usr.templates.'.$tplPckg.'.'.$this->templateType.'.'.$this->template, 'front', true, 'xsl' );
		if( !( $template ) ) {
			SPFs::copy(
				SPLoader::translatePath( 'usr.templates.default.listing.tag', 'front', false, 'xsl' ),
				SPLoader::translatePath( 'usr.templates.'.$tplPckg.'.listing.tag', 'front', false, 'xsl' )
			);
		}
		SPRequest::set( 'tag', $this->_tag, 'get' );
		SPRequest::set( 'field', $this->_field->get( 'name' ), 'get' );

		/* get view class */
		$class = SPLoader::loadView( 'listing' );
		$view = new $class( $this->template );
		$view->assign( $eLimit, '$eLimit' );
		$view->assign( $eLimStart, '$eLimStart' );
		$view->assign( $eCount, '$eCount' );
		$view->assign( $eInLine, '$eInLine' );
		$view->assign( $this->_task, 'task' );
		$view->assign( $this->_model, 'section' );
		$view->assign( Sobi::Txt( 'AFA_PATH_TITLE_FIELD', array( 'tag' => $this->_tag, 'field' => $this->_field->get( 'name' ) ) ), 'listing_name' );
		$view->setConfig( $this->_tCfg, $this->template );
		$view->setTemplate( $tplPckg.'.'.$this->templateType.'.'.$this->template );
		$view->assign(  $pn->get(), 'navigation' );
		$view->assign( SPFactory::user()->getCurrent(), 'visitor' );
		$view->assign( $entries, 'entries' );
		Sobi::Trigger( 'TagListing', 'View', array( &$view ) );
		$view->display();
	}

	public function getEntries( $eLimit, $site, $ids = false )
	{
		$eClass = SPLoader::loadModel( 'entry' );
		$db =& SPFactory::db();
		$entries = array();
		$table = $db->join(
			array(
				array( 'table' => 'spdb_field', 'as' => 'fdef', 'key' => 'fid' ),
				array( 'table' => 'spdb_field_option_selected', 'as' => 'fdata', 'key' => 'fid' ),
				array( 'table' => 'spdb_object', 'as' => 'spo', 'key' => array( 'fdata.sid','spo.id' ) ),
				array( 'table' => 'spdb_relations', 'as' => 'sprl', 'key' => array( 'fdata.sid','sprl.id' )  ),
			)
		);
		$oPrefix = 'spo.';
		$conditions[ 'spo.oType' ] = 'entry';
		$conditions[ 'fdef.fid' ] = $this->_field->get( 'fid' );
		$conditions[ 'fdata.optValue' ] = $this->_tag;
		$eLimStart = ( ( $site - 1 ) * $eLimit );
		$eOrder = null;
		if( Sobi::My( 'id' ) ) {
			$this->userPermissionsQuery( $conditions, $oPrefix );
		}
		else {
			$conditions = array_merge( $conditions, array( $oPrefix.'state' => '1', $oPrefix.'approved' => '1', '@VALID' => $db->valid( $oPrefix.'validUntil', $oPrefix.'validSince' ) ) );
		}
		$conditions[ 'sprl.copy' ] = '0';
		try {
			$db->select( $oPrefix.'id', $table, $conditions, $eOrder, $eLimit, $eLimStart, true );
			$results = $db->loadResultArray();
		}
		catch ( SPException $x ) {
			Sobi::Error( 'TagListing', SPLang::e( 'DB_REPORTS_ERR', $x->getMessage() ), SPC::WARNING, 0, __LINE__, __FILE__ );
		}

		if( $ids ) {
			return $results;
		}
		if( count( $results ) ) {
			$memLimit = ( int ) ini_get( 'memory_limit' ) * 1048576;
			foreach ( $results as $i => $sid ) {
				// it needs too much memory moving the object creation to the view
				//$entries[ $i ] = SPFactory::Entry( $sid );
				$entries[ $i ] = $sid;

			}
		}
		return $entries;
	}

	public function entries( $field = null )
	{}

	public function setParams( $request ) {}

	/**
	 * @param string $task
	 */
	public function setTask( $task )
	{
		$this->_task = strlen( $task ) ? $task : $this->_defTask;
		$helpTask = $this->_type.'.'.$this->_task;
		Sobi::Trigger( $this->name(), __FUNCTION__, array( &$this->_task ) );
		SPFactory::registry()->set( 'task', $helpTask );
	}
}
?>