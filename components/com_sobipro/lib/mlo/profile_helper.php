<?php
/**
 * @version: $Id: profile_helper.php 2194 2012-01-31 09:14:44Z Radek Suski $
 * @package: SobiPro Profile Field Application
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
 * $Date: 2012-01-31 10:14:44 +0100 (Di, 31 Jan 2012) $
 * $Revision: 2194 $
 * $Author: Radek Suski $
 */

defined( 'SOBIPRO' ) || exit( 'Restricted access' );
SPLoader::loadClass( 'opt.fields.inbox' );
/**
 * @author Radek Suski
 * @version 1.0
 * @created 06-Sep-2011 12:43:13
 */
final class SPProfile
{
    public static function Entries( &$attr, $associated, $sections = null )
    {
        // Mon, Oct 10, 2011 - if no section selected - do not add anything
        if ( !( count( $sections ) ) ) {
            return true;
        }
        $sid = $attr[ 'entry' ][ '_attributes' ][ 'id' ];
        $entry = SPFactory::Entry( $sid );
        $author = $entry->get( 'owner' );
        $relations = array();
        $entries = array();
        $struct = array();
        // field is associated with a user - we are searching for authors
        if ( $associated ) {
            $en = SPFactory::db()
                    ->select( 'id', 'spdb_object', array( 'owner' => $author, 'oType' => 'entry', 'state' => 1 ) )
                    ->loadResultArray();

        }
        // field is not associated with a user (fake profile) - we are searching for sid in the "options" db field
        else {
            $fids = SPFactory::db()
                    ->select( 'fid', 'spdb_field', array( 'fieldType' => 'profile', 'section' => $sections ) )
                    ->loadResultArray();
            if ( count( $fids ) ) {
                $en = SPFactory::db()
                        ->select( 'sid', 'spdb_field_data', array( 'options' => $sid, 'fid' => $fids ) )
                        ->loadResultArray();
            }
        }
        if ( count( $en ) ) {
            foreach ( $en as $eid ) {
                // skip the current entry
                if ( $eid == $sid ) {
                    continue;
                }
                $relations[ $eid ] = SPFactory::config()->getParentPath( $eid, false );
                // if no section defined or this entry is in the defined section
                // Mon, Oct 10, 2011 - if no section selected - do not add anything
                if ( /* !( count( $sections ) ) || */
                    in_array( $relations[ $eid ][ 0 ], $sections )
                ) {
                    $entries[ ] = $eid;
                }
            }
        }
        $data = SPFactory::view( 'profile' )->parseEntries( $entries );
        if ( count( $data ) ) {
            foreach ( $data as $id => $entry ) {
                if ( !( isset( $struct[ $relations[ $id ][ 0 ] ] ) ) ) {
                    $sname = SPLang::translateObject( $relations[ $id ][ 0 ], 'name' );
                    $struct[ $relations[ $id ][ 0 ] ] = array(
                        '_complex' => 1,
                        '_attributes' => array(
                            'name' => $sname[ $relations[ $id ][ 0 ] ][ 'value' ],
                            'id' => $relations[ $id ][ 0 ]
                        ),
                        '_data' => array()
                    );
                }
                $struct[ $relations[ $id ][ 0 ] ][ '_data' ][ 'entries' ][ ] = $entry;
            }
        }
        $attr[ 'entry' ][ '_data' ][ 'contributions' ] = array( '_complex' => 1, '_data' => array( 'sections' => $struct ) );
    }
}

?>
