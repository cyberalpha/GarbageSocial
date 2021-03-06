<?php
/**
 * @version: $Id: database.php 2302 2012-03-15 17:00:28Z Radek Suski $
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
 * $Date: 2012-03-15 18:00:28 +0100 (Thu, 15 Mar 2012) $
 * $Revision: 2302 $
 * $Author: Radek Suski $
 * File location: components/com_sobipro/lib/cms/joomla_common/base/database.php $
 */

defined( 'SOBIPRO' ) || exit( 'Restricted access' );

/**
 * @author Radek Suski
 * @version 1.0
 * @created 08-Jul-2008 9:43:25 AM
 */
class SPJoomlaDb
{
    /**
     * Joomla Database object
     *
     * @var JDatabaseMySQLi
     */
    private $db = null;
    /**
     * @var string
     */
    private $prefix = '#__';
    /**
     * @var int
     */
    private $count = 0;

    /**
     * @return SPDatabase
     */
    public function __construct()
    {
        $this->db = JFactory::getDBO();
    }

    /**
     * @return SPDb
     */
    public static function & getInstance()
    {
        static $db = null;
        if ( !$db || !( $db instanceof SPDb ) ) {
            $db = new SPDb();
        }
        return $db;
    }

    /**
     * Returns the error number
     *
     * @return int
     */
    public function getErrorNum()
    {
        return $this->db->getErrorNum();
    }

    /**
     * Returns the error message
     *
     * @return string
     */
    public function getErrorMsg()
    {
        return $this->db->getErrorMsg();
    }

    /**
     * Proxy pattern
     *
     * @param string $method
     * @param array $args
     */
    public function __call( $method, $args )
    {
        if ( $this->db && method_exists( $this->db, $method ) ) {
            $Args = array();
            // http://www.php.net/manual/en/function.call-user-func-array.php#91503
            foreach ( $args as $k => &$arg ) {
                $Args[ $k ] = &$arg;
            }
            return call_user_func_array( array( $this->db, $method ), $Args );
        }
        else {
            throw new SPException( SPLang::e( 'CALL_TO_UNDEFINED_CLASS_METHOD', get_class( $this->_type ), $method ) );
        }
    }

    /**
     * Returns a database escaped string
     *
     * @param string $text string to be escaped
     * @param bool $esc extra escaping
     * @return string
     */
    public function getEscaped( $text, $esc = false )
    {
        return $this->db->getEscaped( ( class_exists( 'SPLang' ) ? SPLang::clean( $text ) : $text ), $esc );
    }

    /**
     * Returns a database escaped string
     *
     * @param string $text string to be escaped
     * @param bool $esc extra escaping
     * @return string
     */
    public function escape( $text, $esc = false )
    {
        return $this->db->getEscaped( $text, $esc );
    }

    /**
     * Returns database null date format
     *
     * @return string Quoted null date string
     */
    public function getNullDate()
    {
        return $this->db->getNullDate();
    }

    /**
     * Sets the SQL query string for later execution.
     *
     * @param string $sql
     * @return void
     */
    public function setQuery( $sql )
    {
        $sql = str_replace( 'spdb', $this->prefix . 'sobipro', $sql );
        return $this->db->setQuery( $sql );
    }

    /* (non-PHPdoc)
      * @see Site/lib/base/SPDatabase#loadFile($file)
      */
    public function loadFile( $file )
    {
        $sql = SPFs::read( $file );
        $sql = explode( "\n", $sql );
        $log = array();
        if ( count( $sql ) ) {
            foreach ( $sql as $query ) {
                if ( strlen( $query ) ) {
                    $this->exec( str_replace( 'spdb', $this->prefix . 'sobipro', $query ) );
                    $log[ ] = $query;
                }
            }
        }
        return $log;
    }

    /**
     * Alias for select where $distinct is true
     *
     * @param string $toSelect
     * @param string $tables
     * @param string $where
     * @param int $limit
     * @param int $limitStart
     * @param string $groupBy - column to group by
     */
    public function dselect( $toSelect, $tables, $where = null, $order = null, $limit = 0, $limitStart = 0, $group = null )
    {
        return $this->select( $toSelect, $tables, $where, $order, $limit, $limitStart, true, $group );
    }

    /**
     * Creates a "select" SQL query.
     *
     * @param string $toSelect - table rows to select
     * @param string $tables - from which table(s)
     * @param string $where - SQL select condition
     * @param int $limit - maximal number of rows
     * @param int $limitStart - start position
     * @param bool $distinct - clear??
     * @param string $groupBy - column to group by
     * @return SPDb
     */
    public function & select( $toSelect, $tables, $where = null, $order = null, $limit = 0, $limitStart = 0, $distinct = false, $groupBy = null )
    {
        $limits = null;
        $ordering = null;
        $where = $this->where( $where );
        $where = $where ? "WHERE {$where}" : null;
        $distinct = $distinct ? ' DISTINCT ' : null;
        $tables = is_array( $tables ) ? implode( ', ', $tables ) : $tables;
        $groupBy = $groupBy ? "GROUP BY {$groupBy}" : null;
        if ( $limit ) {
            $limits = "LIMIT {$limitStart}, {$limit}";
        }
        if ( is_array( $toSelect ) ) {
            $toSelect = implode( ',', $toSelect );
        }
        if ( $order ) {
            $n = false;
            if ( strstr( $order, '.num' ) ) {
                $order = str_replace( '.num', null, $order );
                $n = true;
            }
            if ( strstr( $order, ',' ) ) {
                $o = explode( ',', $order );
                $order = array();
                foreach ( $o as $p ) {
                    if ( strstr( $p, '.' ) ) {
                        $p = explode( '.', $p );
                        $order[ ] = $p[ 0 ] . ' ' . strtoupper( $p[ 1 ] );
                    }
                    else {
                        $order[ ] = $p;
                    }
                }
                $order = implode( ', ', $order );
            }
            elseif ( strstr( $order, '.' ) && ( stristr( $order, 'asc' ) || stristr( $order, 'desc' ) ) ) {
                $order = explode( '.', $order );
                $e = array_pop( $order );
                if ( $n ) {
                    $order = implode( '.', $order ) . '+0 ' . $e;
                }
                else {
                    $order = implode( '.', $order ) . ' ' . $e;
                }
            }
            else {
                if ( $n ) {
                    $order .= '+0';
                }
            }
            $ordering = "ORDER BY {$order}";
        }
        $this->setQuery( "SELECT {$distinct}{$toSelect} FROM {$tables} {$where} {$groupBy} {$ordering} {$limits}" );
        return $this;
    }

    /**
     * Creates a "delete" SQL query
     *
     * @param string $table - in which table
     * @param string $where - SQL delete condition
     * @param int $limit - maximal number of rows to delete
     */
    public function delete( $table, $where, $limit = 0 )
    {
        $where = $this->where( $where );
        $limit = $limit ? "LIMIT $limit" : null;
        try {
            $this->exec( "DELETE FROM {$table} WHERE {$where} {$limit}" );
        }
        catch ( JException $e ) {
        }
        if ( $this->db->getErrorNum() ) {
            throw new SPException( $this->db->stderr() );
        }
        return $this;
    }

    /**
     * Creates a "drop table" SQL query
     *
     * @param string $table - in which table
     * @param string $ifExists
     */
    public function drop( $table, $ifExists = true )
    {
        $ifExists = $ifExists ? 'IF EXISTS' : null;
        try {
            $this->exec( "DROP TABLE {$ifExists} {$table}" );
        }
        catch ( JException $e ) {
        }
        if ( $this->db->getErrorNum() ) {
            throw new SPException( $this->db->stderr() );
        }
        return $this;
    }

    /**
     * Creates a "truncate table" SQL query
     *
     * @param string $table - in which table
     */
    public function truncate( $table )
    {
        try {
            $this->exec( "TRUNCATE TABLE {$table}" );
        }
        catch ( JException $e ) {
        }
        if ( $this->db->getErrorNum() ) {
            throw new SPException( $this->db->stderr() );
        }
        return $this;
    }

    /**
     * Creates where condition from a given array
     *
     * @param array $where - array with values. array( 'id' => 5, 'published' => 1 ) OR array( 'id' => array( 5, 3, 4 ), 'published' => 1 )
     * @param string $andor - joind conditions through AND or OR
     * @return string
     */
    public function where( $where, $andor = 'AND' )
    {
        if ( is_array( $where ) ) {
            $w = array();
            foreach ( $where as $col => $val ) {
                $equal = '=';
                $not = false;
                // sort of workaround for incomaptibility between RC3 and RC4
                if ( $col == 'language' && !( count( $val ) ) ) {
                    $val = 'en-GB';
                }
                /* like:
                     * 	array( '!key' => 'value' )
                     * 	produces sql query with
                     * 	key NOT 'value'
                     */
                if ( strpos( $col, '!' ) !== false && strpos( $col, '!' ) == 0 ) {
                    $col = trim( str_replace( '!', null, $col ) );
                    $not = true;
                }
                /* current means get previous query */
                if ( ( string )$val == '@CURRENT' ) {
                    $n = $not ? 'NOT' : null;
                    $val = $this->db->getQuery();
                    $w[ ] = " ( {$col} {$n} IN ( {$val} ) ) ";
                }
                /* see SPDb#valid() */
                elseif ( $col == '@VALID' ) {
                    $col = '';
                    $w[ ] = $val;
                }
                elseif ( is_numeric( $col ) ) {
                    $w[ ] = $this->escape( $val );
                }
                /* like:
                     * 	array( 'key' => array( 'from' => 1, 'to' => 10 ) )
                     * 	produces sql query with
                     * 	key BETWEEN 1 AND 10
                     */
                elseif ( is_array( $val ) && ( isset( $val[ 'from' ] ) || isset( $val[ 'to' ] ) ) ) {
                    if ( ( isset( $val[ 'from' ] ) && isset( $val[ 'to' ] ) ) && $val[ 'from' ] != SPC::NO_VALUE && $val[ 'to' ] != SPC::NO_VALUE ) {
                        $val[ 'to' ] = $this->escape( $val[ 'to' ] );
                        $val[ 'from' ] = $this->escape( $val[ 'from' ] );
                        $w[ ] = " ( {$col} * 1.0 BETWEEN {$val[ 'from' ]} AND {$val[ 'to' ]} ) ";
                    }
                    elseif ( $val[ 'from' ] != SPC::NO_VALUE && $val[ 'to' ] == SPC::NO_VALUE ) {
                        $val[ 'from' ] = $this->escape( $val[ 'from' ] );
                        $w[ ] = " ( {$col} * 1.0 > {$val[ 'from' ]} ) ";
                    }
                    elseif ( $val[ 'from' ] == SPC::NO_VALUE && $val[ 'to' ] != SPC::NO_VALUE ) {
                        $val[ 'to' ] = $this->escape( $val[ 'to' ] );
                        $w[ ] = " ( {$col} * 1.0 < {$val[ 'to' ]} ) ";
                    }

                }
                /* like:
                     * 	array( 'key' => array( 1,2,3,4 ) )
                     * 	produces sql query with
                     * 	key IN ( 1,2,3,4 )
                     */
                elseif ( is_array( $val ) ) {
                    $v = array();
                    foreach ( $val as $i => $k ) {
                        if ( strlen( $k ) || $k == SPC::NO_VALUE ) {
                            $k = $k == SPC::NO_VALUE ? null : $k;
                            $k = $this->escape( $k );
                            $v[ ] = "'{$k}'";
                        }
                    }
                    $val = implode( ',', $v );
                    $n = $not ? 'NOT' : null;
                    $w[ ] = " ( {$col} {$n} IN ( {$val} ) ) ";
                }
                else {
                    /* changes the equal sign */
                    $n = $not ? '!' : null;
                    /* is lower */
                    if ( strpos( $col, '<' ) ) {
                        $equal = '<';
                        $col = trim( str_replace( '<', null, $col ) );
                    }
                    /* is greater */
                    elseif ( strpos( $col, '>' ) ) {
                        $equal = '>';
                        $col = trim( str_replace( '>', null, $col ) );
                    }
                    /* is like */
                    elseif ( strpos( $val, '%' ) !== false ) {
                        $equal = 'LIKE';
                    }
                    /* regular expressions handling
                          * array( 'key' => 'REGEXP:^search$' )
                          */
                    elseif ( strpos( $val, 'REGEXP:' ) !== false ) {
                        $equal = 'REGEXP';
                        $val = str_replace( 'REGEXP:', null, $val );
                    }
                    elseif ( strpos( $val, 'RLIKE:' ) !== false ) {
                        $equal = 'RLIKE';
                        $val = str_replace( 'RLIKE:', null, $val );
                    }
                    /* ^^ regular expressions handling ^^ */

                    /* SQL functions within the query
                          * array( 'created' => 'FUNCTION:NOW()' )
                          */
                    if ( strstr( $val, 'FUNCTION:' ) ) {
                        $val = str_replace( 'FUNCTION:', null, $val );
                    }
                    else {
                        $val = $this->escape( $val );
                        $val = "'{$val}'";
                    }
                    $w[ ] = " ( {$col} {$n}{$equal}{$val} ) ";
                }
            }
            $where = implode( " {$andor} ", $w );
        }
        return $where;
    }

    /* Arguments and or or
      * (non-PHPdoc)
      * @see Site/lib/base/SPDatabase#argsOr($val)
      */
    public function argsOr( $val )
    {
        $cond = array();
        foreach ( $val as $i => $k ) {
            $cond[ ] .= $i . ' = ' . $k;
        }
        $cond = implode( ' OR ', $cond );
        return '( ' . $cond . ' )';
    }

    /**
     * Creates a "update" SQL query
     *
     * @param string $table - table to update
     * @param array $set  - two-dimensional array with table row name to update => new value
     * @param string $where  - SQL update condition
     */
    public function update( $table, $set, $where, $limit = 0 )
    {
        $change = array();
        $where = $this->where( $where );
        foreach ( $set as $var => $state ) {
            if ( is_array( $state ) || is_object( $state ) ) {
                $state = SPConfig::serialize( $state );
            }
            $var = $this->getEscaped( $var );
            $state = $this->getEscaped( $state );
            if ( strstr( $state, 'FUNCTION:' ) ) {
                $state = str_replace( 'FUNCTION:', null, $state );
            }
            elseif ( strlen( $state ) == 2 && $state == '++' ) {
                $state = "{$var} + 1";
            }
            else {
                $state = "'{$state}'";
            }
            $change[ ] = "{$var} = {$state}";
        }
        $change = implode( ',', $change );
        $l = $limit ? " LIMIT {$limit} " : null;
        $this->exec( "UPDATE {$table} SET {$change} WHERE {$where}{$l}" );
    }

    /**
     * Creates a "replace" SQL query
     *
     * @param string $table - table name
     * @param array $values - two-dimensional array with table row name => value
     */
    public function replace( $table, $values )
    {
        $v = array();
        foreach ( $values as $var => $val ) {
            if ( is_array( $val ) || is_object( $val ) ) {
                $val = SPConfig::serialize( $val );
            }
            $val = $this->getEscaped( $val );
            if ( strstr( $val, 'FUNCTION:' ) ) {
                $v[ ] = str_replace( 'FUNCTION:', null, $val );
            }
            else {
                $v[ ] = "'{$val}'";
            }
        }
        $v = implode( ',', $v );
        try {
            $this->exec( "REPLACE INTO {$table} VALUES ({$v})" );
        }
        catch ( JException $e ) {
        }
        if ( $this->db->getErrorNum() ) {
            throw new SPException( $this->db->stderr() );
        }
    }

    /**
     * Creates a "insert" SQL query
     *
     * @param string $table - table name
     * @param array $values - two-dimensional array with table row name => value
     * @param bool $ignore - adds "IGNORE" after "INSERT" command
     * @param bool $normalize - if the $values is a two-dimm, array and it's not complete - fit to the columns
     */
    public function insert( $table, $values, $ignore = false, $normalize = false )
    {
        $ignore = $ignore ? 'IGNORE ' : null;
        $v = array();
        if ( $normalize ) {
            $this->normalize( $table, $values );
        }
        foreach ( $values as $var => $val ) {
            if ( is_array( $val ) || is_object( $val ) ) {
                $val = SPConfig::serialize( $val );
            }
            $val = $this->getEscaped( $val );
            if ( strstr( $val, 'FUNCTION:' ) ) {
                $v[ ] = str_replace( 'FUNCTION:', null, $val );
            }
            else {
                $v[ ] = "'{$val}'";
            }
        }
        $v = implode( ',', $v );
        try {
            $this->exec( "INSERT {$ignore} INTO {$table} VALUES ({$v})" );
        }
        catch ( JException $e ) {
        }
        if ( $this->db->getErrorNum() ) {
            throw new SPException( $this->db->stderr() );
        }
        return $this;
    }

    /**
     * Fits a two dimmensional array to the necessary columns of the given table
     * @param string $table - table name
     * @param array $values
     */
    public function normalize( $table, &$values )
    {
        $cols = $this->getColumns( $table );
        /* sort the properties in the same order */
        foreach ( $cols as $col ) {
            $values[ $col ] = isset( $values[ $col ] ) ? $values[ $col ] : '';
        }
    }

    /**
     * Creates a "insert" SQL query with multiple values
     *
     * @param string $table - table name
     * @param array $values - one-dimensional array with two-dimensional array with table row name => value
     * @param bool $update - update existing row if cannot insert it because of duplicate primary key
     * @param bool $ignore - adds "IGNORE" after "INSERT" command
     */
    public function insertArray( $table, $values, $update = false, $ignore = false )
    {
        $ignore = $ignore ? 'IGNORE ' : null;
        $rows = array();
        foreach ( $values as $arr ) {
            $v = array();
            $vars = array();
            $k = array();
            foreach ( $arr as $var => $val ) {
                if ( is_array( $val ) || is_object( $val ) ) {
                    $val = SPConfig::serialize( $val );
                }
                $vars[ ] = "{$var} = VALUES( {$var} )";
                $k[ ] = $var;
                $val = $this->getEscaped( $val );
                if ( strstr( $val, 'FUNCTION:' ) ) {
                    $v[ ] = str_replace( 'FUNCTION:', null, $val );
                }
                else {
                    $v[ ] = "'{$val}'";
                }
            }
            $rows[ ] = implode( ',', $v );
        }
        $vars = implode( ', ', $vars );
        $rows = implode( " ), \n ( ", $rows );
        $k = implode( '`,`', $k );
        $update = $update ? "ON DUPLICATE KEY UPDATE {$vars}" : null;
        try {
            $this->exec( "INSERT {$ignore} INTO {$table} ( `{$k}` ) VALUES ({$rows}) {$update}" );
        }
        catch ( JException $e ) {
        }
        if ( $this->db->getErrorNum() ) {
            throw new SPException( $this->db->stderr() );
        }
        return $this;
    }

    /**
     * Creates a "insert" SQL query with update if cannot insert it because of duplicate primary key
     *
     * @param string $table - table name
     * @param array $values - two-dimensional array with table row name => value
     */
    public function insertUpdate( $table, $values )
    {
        $v = array();
        $c = array();
        $k = array();
        foreach ( $values as $var => $val ) {
            if ( is_array( $val ) || is_object( $val ) ) {
                $val = SPConfig::serialize( $val );
            }
            $val = $this->getEscaped( $val );
            if ( strstr( $val, 'FUNCTION:' ) ) {
                $v[ ] = str_replace( 'FUNCTION:', null, $val );
            }
            else {
                $v[ ] = "'{$val}'";
            }
            $c[ ] = "{$var} = '{$val}'";
            $k[ ] = "`{$var}`";

        }
        $v = implode( ',', $v );
        $c = implode( ',', $c );
        $k = implode( ',', $k );
        try {
            $this->exec( "INSERT INTO {$table} ({$k}) VALUES ({$v}) ON DUPLICATE KEY UPDATE {$c}" );
        }
        catch ( JException $e ) {
        }
        if ( $this->db->getErrorNum() ) {
            throw new SPException( $this->db->stderr() );
        }
        return $this;
    }

    /**
     * Returns current query
     *
     * @return string
     */
    public function getQuery()
    {

        return str_replace( $this->prefix, $this->db->getPrefix(), $this->db->getQuery() );
    }

    /**
     * Returns queries counter
     *
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Execute the query
     *
     * @return mixed database resource or <var>false</var>.
     */
    public function query()
    {
        $this->count++;
        return $this->db->query();
    }

    /**
     * Loads the first field of the first row returned by the query.
     *
     * @return string
     */
    public function loadResult()
    {
        try {
            $r = $this->db->loadResult();
            $this->count++;
        } catch ( JException $e ) {
        }

        if ( $this->db->getErrorNum() ) {
            throw new SPException( $this->db->stderr() );
        }
        else {
            return $r;
        }
    }

    /**
     * Load an array of single field results into an array
     *
     * @return array
     */
    public function loadResultArray()
    {
        try {
            $r = $this->db->loadResultArray();
            $this->count++;
        } catch ( JException $e ) {
        }

        if ( $this->db->getErrorNum() ) {
            throw new SPException( $this->db->stderr() );
        }
        else {
            return $r;
        }
    }

    /**
     * Load a assoc list of database rows
     *
     * @param string $key field name of a primary key
     * @return array If <var>key</var> is empty as sequential list of returned records.
     */
    public function loadAssocList( $key = null )
    {
        try {
            $r = $this->db->loadAssocList( $key );
            $this->count++;
        } catch ( JException $e ) {
        }

        if ( $this->db->getErrorNum() ) {
            throw new SPException( $this->db->stderr() );
        }
        else {
            return $r;
        }
    }

    /**
     * Loads the first row of a query into an object
     *
     * @return stdObject
     */
    public function loadObject()
    {
        try {
            $r = $this->db->loadObject();
            $this->count++;
        } catch ( JException $e ) {
        }

        if ( $this->db->getErrorNum() ) {
            throw new SPException( $this->db->stderr() );
        }
        else {
            return $r;
        }
    }

    /**
     * Load a list of database objects
     *
     * @param string $key
     * @return array If <var>key</var> is empty as sequential list of returned records.
     */
    public function loadObjectList( $key = null )
    {
        try {
            $r = $this->db->loadObjectList( $key );
            $this->count++;
        } catch ( JException $e ) {
        }

        if ( $this->db->getErrorNum() ) {
            throw new SPException( $this->db->stderr() );
        }
        else {
            return $r;
        }
    }

    /**
     * Load the first row of the query.
     *
     * @return array
     */
    public function loadRow()
    {
        try {
            $r = $this->db->loadRow();
            $this->count++;
        }
        catch ( JException $e ) {
        }

        if ( $this->db->getErrorNum() ) {
            throw new SPException( $this->db->stderr() );
        }
        else {
            return $r;
        }
    }

    /**
     * Load a list of database rows (numeric column indexing)
     *
     * @param string $key field name of a primary key
     * @return array If <var>key</var> is empty as sequential list of returned records.
     */
    public function loadRowList( $key = null )
    {
        try {
            $r = $this->db->loadRowList( $key );
            $this->count++;
        }
        catch ( JException $e ) {
        }

        if ( $this->db->getErrorNum() ) {
            throw new SPException( $this->db->stderr() );
        }
        else {
            return $r;
        }
    }

    /**
     * Returns an error statement
     *
     * @return string
     */
    public function stderr()
    {
        return $this->db->stderr();
    }

    /**
     * Returns the ID generated from the previous insert operation
     *
     * @return int
     */
    public function insertid()
    {
        return $this->db->insertid();
    }

    /**
     * executing query (update/insert etc)
     *
     * @param string $query - query to execute
     * @return mixed
     */
    public function exec( $query )
    {
        $this->setQuery( $query );
        try {
            $r = $this->query();
        }
        catch ( JException $e ) {
        }
        if ( $this->db->getErrorNum() ) {
            throw new SPException( $this->db->stderr() );
        }
        else {
            return $r;
        }
    }

    /**
     * Returns all rows of given table
     * @param string $table
     * @return array
     */
    public function getColumns( $table )
    {
        static $cache = array();
        if ( !( isset( $cache[ $table ] ) ) ) {
            $this->setQuery( "SHOW COLUMNS FROM {$table}" );
            try {
                $cache[ $table ] = $this->loadResultArray();
            }
            catch ( JException $e ) {
            }
            if ( $this->db->getErrorNum() ) {
                throw new SPException( $this->db->stderr() );
            }
        }
        return $cache[ $table ];
    }

    /**
     * rolls back the current transaction, canceling its changes
     *
     * @return bool
     */
    public function rollback()
    {
        return $this->exec( 'ROLLBACK;' ) !== false ? true : false;
    }

    /**
     * begin a new transaction
     *
     * @return bool
     */
    public function transaction()
    {
        return $this->exec( 'START TRANSACTION;' ) !== false ? true : false;
    }

    /**
     * ommits the current transaction, making its changes permanent
     *
     * @return bool
     */
    public function commit()
    {
        return $this->exec( 'COMMIT;' ) !== false ? true : false;
    }

    /**
     * Returns current datetime in database acceptable format
     * @return string
     */
    public function now()
    {
        return gmdate( SPFactory::config()->key( 'date.db_format', 'Y-m-d H:i:s' ) );
    }

    /**
     * Creates yntax for joins two tables
     *
     * @param array $params - two cells array with table name <var>table</var>, alias name <var>as</var> and common key <var>key</var>
     * @param string $through - join direction (left/right)
     * @return string
     */
    public function join( $params, $through = 'left' )
    {
        $through = strtoupper( $through );
        $join = null;
        if ( count( $params ) > 2 ) {
            $joins = array();
            $c = 0;
            foreach ( $params as $table ) {
                if ( isset( $table[ 'table' ] ) ) {
                    $join = "\n {$table[ 'table' ]} AS {$table[ 'as' ]} ";
                    if ( $c > 0 ) {
                        if ( isset( $table[ 'key' ] ) ) {
                            if ( is_array( $table[ 'key' ] ) ) {
                                $join .= " ON {$table[ 'key' ][ 0 ]} =  {$table[ 'key' ][ 1 ]} ";
                            }
                            else {
                                $join .= " ON {$params[0][ 'as' ]}.{$table[ 'key' ]} =  {$table[ 'as' ]}.{$table[ 'key' ]} ";
                            }
                        }
                    }
                    $joins[ ] = $join;
                }
                $c++;
            }
            $join = implode( " {$through} JOIN ", $joins );
        }
        else {
            if (
                ( isset( $params[ 0 ][ 'table' ] ) && isset( $params[ 0 ][ 'as' ] ) && isset( $params[ 0 ][ 'key' ] ) ) &&
                ( isset( $params[ 1 ][ 'table' ] ) && isset( $params[ 1 ][ 'as' ] ) && isset( $params[ 1 ][ 'key' ] ) )
            ) {
                $join = " {$params[0][ 'table' ]} AS {$params[0][ 'as' ]} {$through} JOIN {$params[1][ 'table' ]} AS {$params[1][ 'as' ]} ON {$params[0][ 'as' ]}.{$params[0][ 'key' ]} =  {$params[1][ 'as' ]}.{$params[1][ 'key' ]}";
            }
        }
        return $join;
    }

    /**
     * Creates syntax to check the expiration date, state, and start publishing date off an row
     * @param string $until - row name where the expiration date is stored
     * @param string $since - row name where the start date is stored
     * @param string $pub - row name where the state is stored (e.g. 'published')
     * @return string
     */
    public function valid( $until, $since = null, $pub = null )
    {
        $now = $this->now();
        $null = $this->getNullDate();
        $pub = $pub ? " AND {$pub} = 1 " : null;
        $stamp = gmdate( SPFactory::config()->key( 'date.db_format', 'Y-m-d H:i:s' ), 0 );
        if ( $since ) {
            //			$since = "AND ( {$since} < '{$now}' OR {$since} IN( '{$null}', '{$stamp}' ) ) ";
            $since = "AND ( {$since} < NOW() OR {$since} IN( '{$null}', '{$stamp}' ) ) ";
        }
        //		return " ( ( {$until} > '{$now}' OR {$until} IN ( '{$null}', '{$stamp}' ) ) {$since} {$pub} ) ";
        return "( ( {$until} > NOW() OR {$until} IN ( '{$null}', '{$stamp}' ) ) {$since} {$pub} ) ";
    }
}
