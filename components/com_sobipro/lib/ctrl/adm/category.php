<?php
/**
 * @version: $Id: category.php 2317 2012-03-27 10:19:39Z Radek Suski $
 * @package: SobiPro Library
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
 * $Date: 2012-03-27 12:19:39 +0200 (Tue, 27 Mar 2012) $
 * $Revision: 2317 $
 * $Author: Radek Suski $
 * File location: components/com_sobipro/lib/ctrl/adm/category.php $
 */

defined( 'SOBIPRO' ) || exit( 'Restricted access' );

SPLoader::loadController( 'controller' );
SPLoader::loadController( 'category' );

/**
 * @author Radek Suski
 * @version 1.0
 * @created 10-Jan-2009 4:39:25 PM
 */
class SPCategoryAdmCtrl extends SPCategoryCtrl
{
	/**
	 */
	public function execute()
	{
		/* parent class executes the plugins */
		$r = false;
		switch ( $this->_task ) {
			case 'edit':
			case 'add':
				SPLoader::loadClass( 'html.input' );
				$this->editForm();
				break;
			case 'view':
				Sobi::ReturnPoint();
				SPLoader::loadClass( 'html.input' );
				$this->view();
				break;
			case 'clone':
				$r = true;
				$this->_model = null;
				SPRequest::set( 'category_id', 0, 'post' );
				SPRequest::set( 'category_state', 0, 'post' );
				$this->save( false, true );
				break;
			case 'reorder':
				$r = true;
				$this->reorder();
				break;
			case 'up':
			case 'down':
				$r = true;
				$this->singleReorder( $this->_task == 'up' );
				break;
			case 'approve':
			case 'unapprove':
				$r = true;
				$this->approval( $this->_task == 'approve' );
				break;
			case 'hide':
			case 'publish':
				$r = true;
				$this->authorise( $this->_task );
				$this->_model->changeState( $this->_task == 'publish' );
				$state = ( int ) ( $this->_task == 'publish' );
				Sobi::Redirect( SPMainFrame::getBack(), Sobi::Txt( 'CAT.STATE_CHANGED' ) );
			default:
				/* case plugin didn't registered this task, it was an error */
				if( !parent::execute() ) {
					Sobi::Error( $this->name(), SPLang::e( 'SUCH_TASK_NOT_FOUND', SPRequest::task() ), SPC::NOTICE, 404, __LINE__, __FILE__ );
				}
				break;
		}
		return $r;
	}

	/**
	 */
	private function approval( $approve )
	{
		$sids = SPRequest::arr( 'c_sid', array() );
		if( !count( $sids ) ) {
			$sids = array( $this->_model->get( 'id' ) );
		}
		foreach ( $sids as $sid ) {
			try {
				SPFactory::db()->update( 'spdb_object', array( 'approved' => $approve ? 1 : 0 ), array( 'id' => $sid, 'oType' => 'category'  ) );
			}
			catch ( SPException $x ) {
				Sobi::Error( $this->name(), SPLang::e( 'DB_REPORTS_ERR', $x->getMessage() ), SPC::WARNING, 0, __LINE__, __FILE__ );
			}
		}
		Sobi::Redirect( Sobi::GetUserState( 'back_url', Sobi::Url() ), $approve ? 'Category has been approved' : 'Category has been un-approved' );
	}

	/**
	 */
	private function reorder()
	{
		/* @var SPdb $db */
		$db	=& SPFactory::db();
		/* get the requested ordering */
		$sids = SPRequest::arr( 'cp_sid', array() );
		/* re-order it to the valid ordering */
		$order = array();
		asort( $sids );

        $cLimStart = SPRequest::int( 'cLimStart', 0 );
        $cLimit = Sobi::GetUserState( 'adm.categories.limit', 'climit', Sobi::Cfg( 'adm_list.cats_limit', 15 ) );
        $LimStart = $cLimStart ? ( ( $cLimStart - 1 ) * $cLimit ) : $cLimStart;
		if( count( $sids ) ) {
			$c = 0;
			foreach ( $sids as $sid => $pos ) {
				$order[ ++$c ] = $sid;
			}
		}
		$c = 0;
		foreach ( $order as $sid ) {
			try {
				$db->update( 'spdb_relations', array( 'position' => ++$LimStart ), array( 'id' => $sid, 'oType' => 'category'  ) );
			}
			catch ( SPException $x ) {
				Sobi::Error( $this->name(), SPLang::e( 'DB_REPORTS_ERR', $x->getMessage() ), SPC::WARNING, 0, __LINE__, __FILE__ );
			}
		}
		Sobi::Redirect( Sobi::GetUserState( 'back_url', Sobi::Url() ), 'Categories are re-ordered now' );
	}

	/**
	 */
	protected function view()
	{
		$config	=& SPFactory::config();
		$user =& SPFactory::user();
		/* @var SPdb $db */
		$db	=& SPFactory::db();

		/* get the lists ordering and limits */
		$eLimit 	= $user->getUserState( 'adm.entries.limit', 'elimit', $config->key( 'adm_list.entries_limit', 25 ) );
		$cLimit 	= $user->getUserState( 'adm.categories.limit', 'climit', $config->key( 'adm_list.cats_limit', 15 ) );
		$eLimStart 	= SPRequest::int( 'eLimStart', 0 );
		$cLimStart 	= SPRequest::int( 'cLimStart', 0 );

		/* get child categories and entries */
		$e = $this->_model->getChilds();
		$c = $this->_model->getChilds( 'category' );

		$cCount	= count( $c );
		$eCount	= count( $e );
		$entries = array();
		$categories = array();
		SPLoader::loadClass( 'models.dbobject' );

		/* if there are categories in the root */
		if( count( $c ) ) {
			try {
				$LimStart = $cLimStart ? ( ( $cLimStart - 1 ) * $cLimit ) : $cLimStart ;
				$Limit = $cLimit > 0 ? $cLimit : 0;
				$cOrder = $this->parseOrdering( 'categories', 'corder', 'order.asc', $Limit, $LimStart, $c );
				$db->select( '*', 'spdb_object', array( 'id' => $c, 'oType' => 'category' ), $cOrder, $Limit, $LimStart );
				$results = $db->loadResultArray();
			}
			catch ( SPException $x ) {
				Sobi::Error( $this->name(), SPLang::e( 'DB_REPORTS_ERR', $x->getMessage() ), SPC::WARNING, 0, __LINE__, __FILE__ );
			}
			foreach ( $results as $i => $category ) {
				$categories[ $i ] = SPFactory::Category( $category );// new $cClass();
				//$categories[ $i ]->extend( $category );
			}
		}

		/* if there are entries in the root */
		if( count( $e ) ) {
			try {
				$LimStart = $eLimStart ? ( ( $eLimStart - 1 ) * $eLimit ) : $eLimStart;
				$Limit = $eLimit > 0 ? $eLimit : 0;
				$eOrder = $this->parseOrdering( 'entries', 'eorder', 'order.asc', $Limit, $LimStart, $e );
				$db->select( '*', 'spdb_object', array( 'id' => $e, 'oType' => 'entry' ), $eOrder, $Limit, $LimStart );
				$results = $db->loadResultArray();
			}
			catch ( SPException $x ) {
				Sobi::Error( $this->name(), SPLang::e( 'DB_REPORTS_ERR', $x->getMessage() ), SPC::WARNING, 0, __LINE__, __FILE__ );
			}
			foreach ( $results as $i => $entry ) {
				$entries[ $i ] = $entry;//new $eClass();
				//$entries[ $i ]->extend( $entry );
			}
		}
		$entriesName = SPFactory::config()->nameField()->get( 'name' );
		$entriesField = SPFactory::config()->nameField()->get( 'nid' );

		/* create menu */
		SPLoader::loadClass( 'helpers.adm.menu' );
		$menu = new SPAdmSiteMenu( 'section.'.$this->_task, SPRequest::sid() );
		/* load the menu definition */
		$cfg = SPLoader::loadIniFile( 'etc.adm.section_menu');
		Sobi::Trigger( 'Create', 'AdmMenu', array( &$cfg ) );
		if( count( $cfg ) ) {
			foreach ( $cfg as $section => $keys ) {
				$menu->addSection( $section, $keys );
			}
		}
		/* create new SigsiuTree */
		$tree = SPLoader::loadClass( 'mlo.tree' );
		$tree = new $tree( Sobi::GetUserState( 'categories.order', 'corder', 'position.asc' ) );
		/* set link */
		$tree->setHref( Sobi::Url( array( 'sid' => '{sid}' ) ) );
		$tree->setId( 'menuTree' );
		/* set the task to expand the tree */
		$tree->setTask( 'category.expand' );
		$tree->init( Sobi::Reg( 'current_section' ), SPRequest::sid() );
		/* add the tree into the menu */
		$menu->addCustom( 'AMN.ENT_CAT', $tree->getTree() );

		/* get view class */
		$class 	= SPLoader::loadView( 'category', true );
		$view 	= new $class();
		$view->assign( $eLimit, '$eLimit' );
		$view->assign( $cLimit, '$cLimit' );
		$view->assign( $eLimStart, '$eLimStart' );
		$view->assign( $cLimStart, '$cLimStart' );
		$view->assign( $cCount, '$cCount' );
		$view->assign( $eCount, '$eCount' );
		$view->assign( $this->_task, 'task' );
		$view->assign( $this->_model, 'category' );
		$view->loadConfig( 'category.list' );
		$view->setTemplate( 'category.list' );
		$view->assign( $categories, 'categories' );
		$view->assign( $entries, 'entries' );
		$view->assign( $this->customCols(), 'fields' );
		$view->assign( $entriesName, 'entries_name' );
		$view->assign( $entriesField, 'entries_field' );
		$view->assign( $menu, 'menu' );
		$view->addHidden( Sobi::Section(), 'pid' );
		Sobi::Trigger( 'Category', 'View', array( &$view ) );
		$view->display();
	}

	// @todo duplicates the same method in section ctrl - need to merge it
	public function customCols()
	{
		/* get fields for header */
		$fields = array();
		try {
			$fieldsData = SPFactory::db()
				->select( '*', 'spdb_field', array( '!admList' => 0, 'section' => Sobi::Reg( 'current_section' ) ), 'admList' )
				->loadObjectList();
		}
		catch ( SPException $x ) {
			Sobi::Error( $this->name(), SPLang::e( 'DB_REPORTS_ERR', $x->getMessage() ), SPC::WARNING, 0, __LINE__, __FILE__ );
		}
		if( count( $fieldsData ) ) {
			$fModel = SPLoader::loadModel( 'field', true );
			foreach ( $fieldsData as $field ) {
				$fit = new $fModel();
				/* @var SPField $fit */
				$fit->extend( $field );
				$fields[] = $fit;
			}
		}
		return $fields;
	}

	/**
	 */
	private function editForm()
	{
		/* if adding new */
		if( !$this->_model || $this->_task == 'add' ) {
			$this->setModel( SPLoader::loadModel( 'category' ) );
		}
		$this->_model->formatDatesToEdit();
		$id = $this->_model->get( 'id' );
		if( !$id ) {
			$this->_model->set( 'state', 1 );
		}
		if ( $this->_model->isCheckedOut() ) {
			SPMainFrame::msg( Sobi::Txt( 'CAT.IS_CHECKED_OUT' ), SPC::ERROR_MSG );
		}
		else {
			$this->_model->checkOut();
		}
		$class = SPLoader::loadView( 'category', true );
		$view = new $class();
		$view->assign( $this->_model, 'category' );
		$view->assign( $this->_task, 'task' );
		$view->assign( SPFactory::CmsHelper()->userSelect( 'category.owner', ( $this->_model->get( 'owner' ) ? $this->_model->get( 'owner' ) : ( $this->_model->get( 'id' ) ? 0 : Sobi::My( 'id' ) ) ), true ), 'owner' );
		$view->assign( $id, 'cid' );
		$view->assign( SPFactory::registry()->get( 'current_section' ), 'sid' );
		$view->loadConfig( 'category.edit' );
		$view->setTemplate( 'category.edit' );
		$view->addHidden( Sobi::Section(), 'pid' );
		Sobi::Trigger( 'Category', 'EditView', array( &$view ) );
		$view->display();
	}

	/**
	 * @param string $subject
	 * @param string $col
	 * @param string $def
	 * @param int $lim
	 * @param int $lStart
	 * @return string
	 */
	protected function parseOrdering( $subject, $col, $def, &$lim, &$lStart, &$sids )
	{
		$ord = SPFactory::user()->getUserState( $subject.'.order', $col, $def );
		$ord = str_replace( array( 'e_s', 'c_s' ), null, $ord );
		if( strstr( $ord, '.' ) ) {
			$ord = explode( '.', $ord );
			$dir = $ord[ 1 ];
			$ord = $ord[ 0 ];
		}
		if( $ord == 'order' ) {
			$subject = $subject == 'categories' ? 'category' : 'entry';
			/* @var SPdb $db */
			$db	=& SPFactory::db();
			$db->select( 'id', 'spdb_relations', array( 'oType' => $subject, 'pid' => $this->_model->get( 'id' ) ), 'position.'.$dir, $lim, $lStart );
			$fields = $db->loadResultArray();
			if( count( $fields ) ) {
				$sids = $fields;
				$fields = implode( ',', $fields );
				$ord = "field( id, {$fields} )";
				$lStart = 0;
				$lim = 0;
			}
			else {
				$ord = 'id.'.$dir;
			}
		}
		elseif( $ord == 'name' ) {
			$subject = $subject == 'categories' ? 'category' : 'entry';
			/* @var SPdb $db */
			$db	=& SPFactory::db();
			$db->select( 'id', 'spdb_language', array( 'oType' => $subject, 'sKey' => 'name', 'language' => Sobi::Lang() ), 'sValue.'.$dir );
			$fields = $db->loadResultArray();
			if( !count( $fields ) && Sobi::Lang() != Sobi::DefLang() ) {
				$db->select( 'id', 'spdb_language', array( 'oType' => $subject, 'sKey' => 'name', 'language' => Sobi::DefLang() ), 'sValue.'.$dir );
				$fields = $db->loadResultArray();
			}
			if( count( $fields ) ) {
				$fields = implode( ',', $fields );
				$ord = "field( id, {$fields} )";
			}
			else {
				$ord = 'id.'.$dir;
			}
		}
		elseif( $ord == 'state' ) {
			$ord = $ord.'.'.$dir.', validSince.'.$dir.', validUntil.'.$dir;
		}
		elseif( strstr( $ord, 'field_' ) ) {
			$db	=& SPFactory::db();
			static $field = null;
			if( !$field ) {
				try {
					$db->select( 'fieldType', 'spdb_field', array( 'nid' => $ord, 'section' => Sobi::Section() ) );
					$fType = $db->loadResult();
				}
				catch ( SPException $x ) {
					Sobi::Error( $this->name(), SPLang::e( 'CANNOT_DETERMINE_FIELD_TYPE', $x->getMessage() ), SPC::WARNING, 0, __LINE__, __FILE__ );
				}
				if( $fType ) {
					$field = SPLoader::loadClass( 'opt.fields.'.$fType );
				}
			}
			/* *
			 * @TODO The whole sort by custom field method in admin panel has to be re-implemented -
			 * We could use the same field 'sortBy' method for backend and frontend.
			 * The current method could be very inefficient !!!
			 */
			if( $field && method_exists( $field, 'sortByAdm' ) ) {
				$fields = call_user_func_array( array( $field, 'sortByAdm' ) );
			}
			else {
				$join = array(
					array( 'table' => 'spdb_field', 'as' => 'def', 'key' => 'fid' ),
					array( 'table' => 'spdb_field_data', 'as' => 'fdata', 'key' => 'fid' )
				);
				$db->select( 'sid', $db->join( $join ), array( 'def.nid' => $ord, 'lang' => Sobi::Lang() ), 'baseData.'.$dir );
				$fields = $db->loadResultArray();
			}
			if( count( $fields ) ) {
				$fields = implode( ',', $fields );
				$ord = "field( id, {$fields} )";
			}
			else {
				$ord = 'id.'.$dir;
			}
		}
		else {
			$ord = $ord.'.'.$dir;
		}
		return $ord;
	}

//	/**
//	 * Show category chooser
//	 *
//	 */
//	protected function chooser( $menu = false )
//	{
//		$out = SPRequest::cmd( 'out', null );
//		$exp = SPRequest::int( 'expand', 0 );
//		$multi = SPRequest::int( 'multiple', 0 );
//
//		/* load the SigsiuTree class */
//		$tree = SPLoader::loadClass( 'mlo.tree' );
//
//		/* create new instance */
//		$tree = new $tree();
//
//		/* set link */
//		if( $menu ) {
//			$tree->setId( 'menuTree' );
//			$link = Sobi::Url( array( 'sid' => '{sid}') );
//		}
//		else {
//			$link = "javascript:SP_selectCat( '{sid}' )";
//		}
//		$tree->setHref( $link );
//
//		/* set the task to expand the tree */
//		$tree->setTask( 'category.chooser' );
//
//		/* disable the category which is currently edited - category cannot be within it self */
//		if( !$multi ) {
//			$tree->disable( SPRequest::sid() );
//			$tree->setPid( SPRequest::sid() );
//		}
//		else {
//			$tree->disable( Sobi::Reg( 'current_section' ) );
//		}
//
//		/* case we extending existing tree */
//		if( $out == 'xml' && $exp ) {
//			$pid = SPRequest::int( 'pid', 0 );
//			$pid = $pid ? $pid : SPRequest::sid();
//			$tree->setPid( $pid );
//			$tree->disable( $pid );
//			$tree->extend( $exp );
//		}
//
//		/* otherwise we are creating new tree */
//		else {
//			/* init the tree for the current section */
//			$tree->init( Sobi::Reg( 'current_section' ) );
//			/* load model */
//			if( !$this->_model ) {
//				$this->setModel( SPLoader::loadModel( 'category' ) );
//			}
//			/* create new view */
//			$class  = SPLoader::loadView( 'category', true );
//			$view   = new $class();
//			/* assign the task and the tree */
//			$view->assign( $this->_task, 'task' );
//			$view->assign( $tree, 'tree' );
//			$view->assign( $this->_model, 'category' );
//			/* select template to show */
//			if( $multi ) {
//				$view->setTemplate( 'category.mchooser' );
//			}
//			else {
//				$view->setTemplate( 'category.chooser' );
//			}
//			$view->display();
//		}
//	}

	/**
	 * @param bool $up
	 */
	private function singleReorder( $up )
	{
		/* @var SPdb $db */
		$db =& SPFactory::db();
		$eq = $up ? '<' : '>';
		$dir = $up ? 'position.desc' : 'position.asc';
		$current = $this->_model->get( 'position' ) ;
		try {
			$db->select( 'position, id', 'spdb_relations', array( 'position'.$eq => $current, 'oType' => $this->_model->type(), 'pid' => SPRequest::int( 'pid' ) ), $dir, 1 );
			$interchange = $db->loadAssocList();
			if( $interchange && count( $interchange ) ) {
				$db->update( 'spdb_relations', array( 'position' => $interchange[ 0 ][ 'position' ] ), array( 'oType' => $this->_model->type(), 'pid' => SPRequest::int( 'pid' ), 'id' => $this->_model->get( 'id' ) ), 1 );
				$db->update( 'spdb_relations', array( 'position' => $current ), array( 'oType' => $this->_model->type(), 'pid' => SPRequest::int( 'pid' ), 'id' => $interchange[ 0 ][ 'id' ] ), 1 );
			}
			else {
				$current = $up ? $current-- : $current++;
				$db->update( 'spdb_relations', array( 'position' => $current ), array( 'oType' => $this->_model->type(), 'pid' => SPRequest::int( 'pid' ), 'id' => $this->_model->get( 'id' ) ), 1 );
			}
		}
		catch ( SPException $x ) {
			Sobi::Error( $this->name(), SPLang::e( 'DB_REPORTS_ERR', $x->getMessage() ), SPC::WARNING, 0, __LINE__, __FILE__ );
		}
		Sobi::Redirect( Sobi::GetUserState( 'back_url', Sobi::Url() ), 'Category Position Changed' );
	}
}
