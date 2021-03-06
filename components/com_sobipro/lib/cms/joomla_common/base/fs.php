<?php
/**
 * @version: $Id: fs.php 2302 2012-03-15 17:00:28Z Radek Suski $
 * @package: SobiPro Bridge
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
 * $Date: 2012-03-15 18:00:28 +0100 (Thu, 15 Mar 2012) $
 * $Revision: 2302 $
 * $Author: Radek Suski $
 * File location: components/com_sobipro/lib/cms/joomla_common/base/fs.php $
 */

defined( 'SOBIPRO' ) || exit( 'Restricted access' );

jimport( 'joomla.filesystem.file' );

/**
 * Interface to Joomla! files system
 * @author Radek Suski
 * @version 1.0
 * @created 10-Jan-2009 5:02:55 PM
 * @todo !!!! verify - Joomla changed this class
 */
abstract class SPJoomlaFs
{
    /**
     *     *
     * @param string $file
     * @return bool
     */
    public static function exists( $file )
    {
        return file_exists( $file );
    }

    /**
     *     *
     * @param string $file
     * @return bool
     */
    public static function clean( $file, $safe = false )
    {
        $file = str_replace( DS, '/', $file );
        $file = preg_replace( '|([^:])(//)+([^/]*)|', '\1/\3', $file );
        $file = str_replace( '__BCKSL__', '\\', preg_replace( '|([^:])(\\\\)+([^\\\])|', "$1__BCKSL__$3", $file ) );
        $file = str_replace( '\\', '/', $file );
        if ( $safe ) {
            $file = Jfile::makeSafe( $file );
        }
        if ( !( strstr( $file, ':' ) ) ) {
            while ( strstr( $file, '//' ) ) {
                $file = str_replace( '//', '/', $file );
            }
        }
        return $file;
    }

    /**
     *     *
     * @param string $file
     * @return bool
     */
    public static function getExt( $file )
    {
        $ext = explode( ".", $file );
        return $ext[ count( $ext ) - 1 ];
    }

    /**
     *     *
     * @param string $file
     * @return bool
     */
    public static function getFileName( $file )
    {
        $ext = explode( DS, $file );
        return $ext[ count( $ext ) - 1 ];
    }

    /**
     *     *
     * @param string $source
     * @param string $destination
     * @return bool
     */
    public static function copy( $source, $destination )
    {
        $destination = Sobi::FixPath( str_replace( '\\', '/', $destination ) );
        $path = explode( '/', str_replace( array( SOBI_ROOT, str_replace( '\\', '/', SOBI_ROOT ) ), null, $destination ) );
        $part = SOBI_ROOT;
        $i = count( $path );
        // yeah I know ... shame on me :(
        while ( !( @$path[ $i ] ) ) {
            unset( $path[ $i-- ] );
        }
        array_pop( $path );
        if ( !( is_string( $path ) ) && count( $path ) ) {
            foreach ( $path as $dir ) {
                $part .= "/{$dir}";
                if ( $dir && !( file_exists( $part ) ) ) {
                    self::mkdir( $part );
                }
            }
        }
        if ( !( is_dir( $source ) ) ) {
            return Jfile::copy( self::clean( $source ), self::clean( $destination ) );
        }
        else {
            return Jfolder::copy( self::clean( $source ), self::clean( $destination ) );
        }
    }

    /**
     *     *
     * @param string $file
     * @return bool
     */
    public static function delete( $file )
    {
        if ( is_dir( $file ) ) {
            return Jfolder::delete( $file );
        }
        else {
            return Jfile::delete( $file );
        }
    }

    /**
     *     *
     * @param string $source
     * @param string $destination
     * @return bool
     */
    public static function move( $source, $destination )
    {
        return Jfile::move( $source, $destination );
    }

    /**
     *     *
     * @param string $file
     * @return bool
     */
    public static function read( $file )
    {
        return file_get_contents( $file );
    }

    public static function fixPath( $path )
    {
        return str_replace( DS . DS, DS, str_replace( DS . DS, DS, str_replace( '\\', '/', $path ) ) );
    }

    /**
     *     *
     * @param string $file
     * @param string $buffer
     * @return bool
     */
    public static function write( $file, &$buffer )
    {
        $return = Jfile::write( $file, $buffer );
        if ( $return === false ) {
            throw new SPException( SPLang::e( 'CANNOT_WRITE_TO_FILE_AT', $file ) );
            return false;
        }
        else {
            return $return;
        }
    }

    /**
     * @param string $name
     * @param string $dest
     * @return bool
     */
    public static function upload( $name, $dest )
    {
        return Jfile::upload( $name, $dest );
    }

    /**
     * @param string $path
     * @param string $hex
     * @return bool
     */
    public static function chmod( $path, $hex )
    {
        return Jfile::chmod( $path, $hex );
    }

    /**
     * @param string $path
     * @return bool
     */
    public static function mkdir( $path, $mode = 0755 )
    {
        return JFolder::create( $path, $mode );
    }

    /**
     *     *
     * @param string $path
     * @return bool
     */
    public static function rmdir( $path )
    {
        return JFolder::delete( $path );
    }

    /**
     *     *
     * @param string $path
     * @return bool
     */
    public static function readable( $path )
    {
        return Jfile::isReadable( $path );
    }

    /**
     *     *
     * @param string $path
     * @return bool
     */
    public static function writable( $path )
    {
        return Jfile::isWritable( $path );
    }

    /**
     *     *
     * @param string $path
     * @return bool
     */
    public static function owner( $path )
    {
        return fileowner( $path );
    }

    /**
     *     *
     * @param string $source
     * @param string $destination
     * @return bool
     */
    public static function rename( $source, $destination )
    {
        return self::move( $source, $destination );
    }
}
