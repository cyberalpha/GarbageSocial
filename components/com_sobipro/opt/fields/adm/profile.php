<?php
/**
 * @version: $Id: profile.php 1942 2011-10-17 15:51:30Z Radek Suski $
 * @package: SobiPro Profile Field Application
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
 * $Date: 2011-10-17 17:51:30 +0200 (Mo, 17 Okt 2011) $
 * $Revision: 1942 $
 * $Author: Radek Suski $
 */

defined( 'SOBIPRO' ) || exit( 'Restricted access' );
SPLoader::loadClass( 'opt.fields.profile' );
/**
 * @author Radek Suski
 * @version 1.0
 * @created 06-Sep-2011 12:43:13
 */
class SPField_AdmProfile extends SPField_Profile implements SPFieldInterface
{
	public function onFieldEdit( &$view )
	{
		$check = SPFactory::db()
			->select( 'fid', 'spdb_field', array( 'fieldType' => 'profile', 'section' => Sobi::Section(), '!fid' => $this->fid ) )
			->loadResultArray();
		if( count( $check ) ) {
			SPFactory::db()->delete( 'spdb_field', array( 'fieldType' => 'profile', 'section' => Sobi::Section(), 'fid' => $this->fid ) );
			Sobi::Redirect( Sobi::Back(), Sobi::Txt( 'AFP_NO_MULTI_FIELD_ALLOWED' ), SPC::ERROR_MSG );
		}
		$config = SPFactory::Controller( 'config', true );
		$fields = $config->getNameFields();
		$get = SPFactory::Controller( 'acl', true )->userGroups();
		$fData = array();
		if( count( $fields ) ) {
			foreach ( $fields as $fid => $field ) {
				$fData[ $fid ] = $field->get( 'name' );
			}
		}
		$view->assign( $fData, 'unameFields' );
		$entry = SPFactory::Model( 'entry' );
		$entry->loadFields( Sobi::Section() );
		$fields = $entry->getFields();
		$feData = $fData;
		if( count( $fields ) ) {
			foreach ( $fields as $fid => $field ) {
				if( $field->get( 'type' ) == 'email' ) {
					$feData[ $field->get( 'fid' ) ] = $field->get( 'name' );
				}
			}
		}
		$view->assign( $feData, 'emailFields' );
		$groups = array();
		foreach ( $get as $group ) {
			$groups[ $group[ 'value' ] ] = $group[ 'text' ];
		}
		$view->assign( $groups, 'userGroups' );

		$s = array();
		try {
			$sections = SPFactory::db()
				->select( 'id', 'spdb_object', array( 'oType' => 'section', '!id' => Sobi::Section() ) )
				->loadResultArray();
		}
		catch ( SPException $x ) {
			Sobi::Error( $this->name(), SPLang::e( 'DB_REPORTS_ERR', $x->getMessage() ), SPC::WARNING, 500, __LINE__, __FILE__ );
		}
		if( count( $sections ) ) {
			$sections = SPLang::translateObject( $sections, array( 'name' ) );
			foreach ( $sections as $data ) {
				$s[ $data[ 'id' ] ] = $data[ 'value' ];
			}
		}
		$view->assign( $s, 'targetSection' );
		if( !( SPLoader::path( 'usr.templates.'.Sobi::Cfg( 'section.template' ).'.common.profile', 'front', true, 'xsl' ) ) ) {
			if( !( SPFs::copy( SPLoader::path( 'usr.templates.default.common.profile', 'front', true, 'xsl' ), SPLoader::path( 'usr.templates.'.Sobi::Cfg( 'section.template' ).'.common.profile', 'front', false, 'xsl' ) ) ) ) {
				Sobi::Error( 'SPField_Profile', 'Cannot copy template to the current template directory', SPC::WARNING, 0, __LINE__, __FILE__ );
			}
		}
	}
}