<?php
/**
 * @version: $Id: profile.php 2194 2012-01-31 09:14:44Z Radek Suski $
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
 * $Date: 2012-01-31 10:14:44 +0100 (Di, 31 Jan 2012) $
 * $Revision: 2194 $
 * $Author: Radek Suski $
 */

defined( 'SOBIPRO' ) || exit( 'Restricted access' );
SPLoader::loadController( 'controller' );
/**
 * @author Radek Suski
 * @version 1.0
 * @created 06-Sep-2011 12:43:13
 */
class SPProfile extends SPController
{
    /**
     * @var string
     */
    protected $_defTask = 'check';

    /**
     */
    public function execute()
    {
        SPLang::load( 'SpApp.profile' );
        $this->_task = strlen( $this->_task ) ? $this->_task : $this->_defTask;
        if ( method_exists( $this, $this->_task ) ) {
            $task = $this->_task;
            $this->$task();
        }
    }

    private function check()
    {
        foreach ( $_GET as $k => $v ) {
            $_POST[ $k ] = $v;
        }
        if ( !( SPFactory::mainframe()->checkToken() ) ) {
            Sobi::Error( $this->name(), SPLang::e( 'UNAUTHORIZED_ACCESS_TASK', SPRequest::task() ), SPC::ERROR, 403, __LINE__, __FILE__ );
        }
        $field = SPRequest::cmd( 'field' );
        if ( in_array( $field, array( 'email', 'username' ) ) ) {
            $uname = trim( SPRequest::string( 'value' ) );
            $uid = SPRequest::int( 'uid', 0 );
            SPFactory::mainframe()->cleanBuffer();
            $r = SPFactory::db()->select( 'count(*)', '#__users', array( $field => $uname, '!id' => $uid ) )->loadResult();
            $msg = '';
            if ( $r > 0 ) {
                $msg = Sobi::Txt( 'AFP_' . strtoupper( $field ) . '_EXIST' );
            }
            header( 'Content-type: application/json' );
            echo json_encode( array( 'id' => $field, 'result' => $r, 'name' => $uname, 'message' => $msg ) );
        }
        else {
            Sobi::Error( 'SPProfile', SPLang::e( 'UNAUTHORIZED_ACCESS' ), SPC::NOTICE, 403, __LINE__, __FILE__ );
        }
        exit;
    }

    private function authors()
    {
        $term = SPRequest::string( 'term', null );
        $section = SPRequest::int( 'target' );
        $fid = SPFactory::db()
                ->select( 'fid', 'spdb_field', array( 'fieldType' => 'profile', 'section' => $section ) )
                ->loadResult();
        // the right profile field in the members section
        $field = SPFactory::Model( 'field' )
                ->init( $fid );

        $unameField = $field->get( 'unameField' );
        $nameField = $field->get( 'nameField' );
        $data = SPFactory::db()
                ->select( array( 'sid', 'baseData' ), 'spdb_field_data', array( 'fid' => array( $unameField, $nameField ), 'section' => $section, 'baseData' => "%{$term}%" ) )
                ->loadAssocList();
        $response = array();
        $unique = array();
        if ( count( $data ) ) {
            $response[ ] = array( 'name' => Sobi::Txt( 'AFP_OVERRIDE_AUTHOR_NO_AUTHOR' ), 'id' => 0 );
            foreach ( $data as $user ) {
                if ( !( isset( $unique[ $user[ 'sid' ] ] ) ) ) {
                    $response[ ] = array( 'name' => $user[ 'baseData' ], 'id' => $user[ 'sid' ] );
                    $unique[ $user[ 'sid' ] ] = true;
                }
            }

        }
        SPFactory::mainframe()->cleanBuffer();
        header( 'Content-type: application/json' );
        echo json_encode( $response );
        exit;
    }
}

?>
