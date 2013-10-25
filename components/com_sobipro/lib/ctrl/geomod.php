<?php
/**
 * @version: $Id: geomod.php 2152 2012-01-13 15:20:17Z Radek Suski $
 * @package: SobiPro SP-GeoMap Module Application
 * ===================================================
 * @author
 * Name: Sigrid Suski & Radek Suski, Sigsiu.NET GmbH
 * Email: sobi[at]sigsiu.net
 * Url: http://www.Sigsiu.NET
 * ===================================================
 * @copyright Copyright (C) 2006 - 2012 Sigsiu.NET GmbH (http://www.sigsiu.net). All rights reserved.
 * @license see http://www.gnu.org/licenses/gpl.html GNU/GPL Version 3.
 * You can use, redistribute this file and/or modify it under the terms of the GNU General Public License version 3
 * ===================================================
 * $Date: 2012-01-13 16:20:17 +0100 (Fr, 13 Jan 2012) $
 * $Revision: 2152 $
 * $Author: Radek Suski $
 */

defined( 'SOBIPRO' ) || exit( 'Restricted access' );
SPLoader::loadController( 'section' );
/**
 * @author Radek Suski
 * @version 1.0
 * @created 06-Sep-2011 12:43:13
 */
class SPGeoMap extends SPSectionCtrl
{
    /**
     * @var string
     */
    protected $_defTask = 'load';

    /**
     */
    public function execute()
    {
        $this->_task = strlen( $this->_task ) ? $this->_task : $this->_defTask;
        if ( method_exists( $this, $this->_task ) ) {
            $task = $this->_task;
            $this->$task();
        }
    }

    private function load()
    {
        $data = array( 'msg' => '', 'entries' => '' );
        $db = SPFactory::db();
        // when it's not the search results
        if ( !( SPRequest::cmd( 'ctask', null, 'post' ) == 'search.results' && SPRequest::int( 'section', null, 'post' ) == Sobi::Section() ) ) {
            $conditions = array( 'geo.section' => Sobi::Section() );
            $table = $db->join( array(
                array( 'table' => 'spdb_field_geo', 'as' => 'geo', 'key' => 'sid' ),
                array( 'table' => 'spdb_object', 'as' => 'spo', 'key' => 'id' )
            ) );
            if ( Sobi::My( 'id' ) ) {
                $this->userPermissionsQuery( $conditions, 'spo.' );
            }
            else {
                $conditions = array_merge( $conditions, array( 'spo.state' => '1', '@VALID' => $db->valid( 'spo.validUntil', 'spo.validSince' ) ) );
            }
            $data[ 'entries' ] = $db
                    ->select( array( 'geo.sid', 'geo.latitude', 'geo.longitude' ), $table, $conditions )
                    ->loadAssocList();
            $data[ 'count' ] = count( $data[ 'entries' ] );
        }
        else {
            $ssid = SPRequest::cmd( 'ssid', SPRequest::cmd( 'ssid', null, 'cookie' ) );
            $results = $db
                    ->select( array( 'entriesResults' ), 'spdb_search', array( 'ssid' => $ssid ) )
                    ->loadResult();
            if ( $results ) {
                $data[ 'entries' ] = $db
                        ->select( array( 'sid', 'latitude', 'longitude' ), 'spdb_field_geo', array( 'sid' => explode( ',', $results ) ) )
                        ->loadAssocList();
            }
            else {
                $data[ 'entries' ] = array();
            }
            $data[ 'count' ] = count( $data[ 'entries' ] );
        }
        SPFactory::mainframe()->cleanBuffer();
        //        sleep(1);
        echo json_encode( $data );
        exit;
    }

    private function info()
    {
        $sid = SPRequest::sid( 'post' );
        $settings = SPFactory::db()
                ->select( 'params', '#__modules', array( 'id' => SPRequest::int( 'iid', 0, 'post' ) ) )
                ->loadResult();
        $params = new JRegistry;
        // Joomla! 1.6+
        if ( method_exists( $params, 'loadString' ) ) {
            $params->loadString( $settings );
            $template = 'front/modules/geomap/' . preg_replace( '/\.xsl$/', null, $params->get( 'tplFile' ) );
        }
        // Joomla! 1.5
        else {
            $params->loadINI( $settings );
            $template = 'front/modules/geomap/' . preg_replace( '/\.xsl$/', null, $params->getValue( 'tplFile' ) );
        }
        $view = SPFactory::View( 'geomod' );
        $view->assign( $sid, 'sid' );
        $view->assign( SPFactory::user()->getCurrent(), 'visitor' );
        $view->setTemplate( $template );
        $data = array( 'html' => $view->display() );
        //        sleep(1);
        SPFactory::mainframe()->cleanBuffer();
        echo json_encode( $data );
        exit;
    }
}
