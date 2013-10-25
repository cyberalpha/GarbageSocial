<?php
/**
 * @version: $Id: calendar.php 2348 2012-04-09 15:54:47Z Radek Suski $
 * @package: SobiPro Calendar Field Application
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
 * $Date: 2012-04-09 17:54:47 +0200 (Mo, 09 Apr 2012) $
 * $Revision: 2348 $
 * $Author: Radek Suski $
 */

defined( 'SOBIPRO' ) || exit( 'Restricted access' );
SPLoader::loadClass( 'opt.fields.inbox' );
/**
 * @author Radek Suski
 * @version 1.0
 * @created 25-Apr-2011 20:06:23
 */
class SPField_Calendar extends SPField_Inbox implements SPFieldInterface
{
    /**
     * @var string
     */
    protected $cssClass = '';
    /**
     * @var string
     */
    protected $searchMethod = 'general';
    /**
     * @var string
     */
    protected $jQUiTheme = 'smoothness.smoothness';
    /**
     * @var string
     */
    protected $inputForm = 'dd.mm.yy';
    /**
     * @var bool
     */
    protected $inputFormClock12 = false;
    /**
     * @var string
     */
    protected $outputForm = 'd.m.y G:i';
    /**
     * @var string
     */
    protected $outputFormCustom = '';
    /**
     * @var array
     */
    protected $timeOpt = array( 'hh', 'mm' );
    /**
     * @var int
     */
    protected $numMonths = 1;
    /**
     * @var int
     */
    protected $function = 0;
    /**
     * @var array
     */
    protected $_translations = array(
        'timeOnlyTitle', 'timeText', 'hourText', 'minuteText', 'secondText', 'currentText', 'closeText',
        'monthNames', 'monthNamesShort', 'dayNames', 'dayNamesShort', 'dayNamesMin', 'weekHeader', 'yearSuffix'
    );

    /**
     * Returns the parameter list
     * @return array
     */
    protected function getAttr()
    {
        $attr = get_class_vars( __CLASS__ );
        unset( $attr[ '_translations' ] );
        return array_keys( $attr );
    }

    public function __construct( &$field )
    {
        parent::__construct( $field );
        SPLang::load( 'SpApp.calendar' );
    }


    /**
     * Shows the field in the edit entry or add entry form
     * @param bool $return return or display directly
     * @return string
     */
    public function field( $return = false )
    {
        if ( !( $this->enabled ) ) {
            return false;
        }
        $this->jQUiTheme = Sobi::Cfg( 'jquery.ui_theme', 'smoothness.smoothness' );
        $this->createLangFile();
        SPFactory::header()->addJsFile( array( 'jquery', 'jquery-ui', 'timepicker', Sobi::Lang( false ) . '_calendar', 'calendar' ) );
        SPFactory::header()->addCssFile( array( 'timepicker', 'jquery-ui.' . $this->jQUiTheme ) );
        $selected = $this->getRaw();
        $fdata = Sobi::Reg( 'editcache' );
        if ( $fdata && is_array( $fdata ) ) {
            $selected = $selected / 1000;
        }
        $opt = array(
            'ampm' => ( int )$this->inputFormClock12,
            'dateFormat' => $this->inputForm,
            'numberOfMonths' => ( int )$this->numMonths,
            'hourMin' => 0,
            'hourMax' => 24,
            'selectedDate' => ( int )$selected
        );
        if ( count( $this->timeOpt ) ) {
            $opt[ 'timeFormat' ] = implode( ':', $this->timeOpt );
        }
        else {
            $opt[ 'showHour' ] = false;
            $opt[ 'showMinute' ] = false;
        }
        $opt = json_encode( $opt );
        SPFactory::header()->addJsCode( "spCalendar ( '{$this->nid}', {$opt} );" );
        $field = null;
        $class = $this->required ? $this->cssClass . ' required' : $this->cssClass;
        $params = array( 'id' => $this->nid . '_selector', 'size' => $this->width, 'class' => $class );
        if ( $this->width ) {
            $params[ 'style' ] = "width: {$this->width}px;";
        }
        $s = sprintf( '%0.0f', ( $selected * 1000 ) );
        $field = SPHtml_Input::text( $this->nid . '_selector', $s, $params );
        $field .= SPHtml_Input::text( $this->nid, $s, array( 'id' => $this->nid, 'readonly' => 'readonly', 'style' => 'display:none;' ) );
        if ( !$return ) {
            echo $field;
        }
        else {
            return $field;
        }
    }

    private function createLangFile()
    {
        SPLang::load( 'SpApp.calendar' );
        $c = "spCalLang = {";
        foreach ( $this->_translations as $value ) {
            $v = Sobi::Txt( 'JS_CFA_' . strtoupper( $value ) );
            if ( !( strstr( $v, ']' ) ) ) {
                $v = "'{$v}'";
            }
            $c .= "\n\t'{$value}': " . $v;
            if ( $value != $this->translate[ count( $this->translate ) - 1 ] ) {
                $c .= ',';
            }
        }
        $c .= "\n};";
        $check = md5( $c );
        if ( !( SPLoader::JsFile( Sobi::Lang( false ) . '_calendar', false, true, false ) ) || !stripos( SPFs::read( SPLoader::JsFile( Sobi::Lang( false ) . '_calendar', false, false, false ) ), $check ) ) {
            $c = $c . "\n//{$check}";
            SPFs::write( SPLoader::JsFile( Sobi::Lang( false ) . '_calendar', false, false, false ), $c );
        }
    }

    /**
     * Gets the data for a field, verify it and pre-save it.
     * @param SPEntry $entry
     * @param string $request
     * @return void
     */
    public function submit( &$entry, $tsid = null, $request = 'POST' )
    {
        $save = array();
        if ( $this->verify( $entry, $request ) ) {
            $save = SPRequest::search( $this->nid, $request );
        }
        return $save;
    }

    /**
     * @param SPEntry $entry
     * @param string $request
     * @return bool
     */
    private function verify( $entry, $request )
    {
        $data = SPRequest::raw( $this->nid, null, $request );
        $dexs = strlen( $data );
        /* check if it was required */
        if ( $this->required && !( $dexs ) ) {
            throw new SPException( SPLang::e( 'FIELD_REQUIRED_ERR', $this->name ) );
        }
        $data = preg_replace( '/[^0-9\-]/', null, $data );
        if ( !( $data ) ) {
            if ( $this->required ) {
                throw new SPException( SPLang::e( 'FIELD_CAL_INVALID_DATA', $this->name ) . $data );
            }
            else {
                return null;
            }
        }
        else {
            $data = $data / 1000;
        }
        /* check if there was an adminField */
        if ( $this->adminField && $dexs ) {
            if ( !( Sobi:: Can( 'entry.adm_fields.edit' ) ) ) {
                throw new SPException( SPLang::e( 'FIELD_NOT_AUTH', $this->name ) );
            }
        }
        /* check if it was free */
        if ( !( $this->isFree ) && $this->fee && $dexs ) {
            SPFactory::payment()->add( $this->fee, $this->name, $entry->get( 'id' ), $this->fid );
        }
        /* check if it was editLimit */
        if ( $this->editLimit == 0 && !( Sobi::Can( 'entry.adm_fields.edit' ) ) && $dexs ) {
            throw new SPException( SPLang::e( 'FIELD_NOT_AUTH_EXP', $this->name ) );
        }
        /* check if it was editable */
        if ( !( $this->editable ) && !( Sobi::Can( 'entry.adm_fields.edit' ) ) && $dexs && $entry->get( 'version' ) > 1 ) {
            throw new SPException( SPLang::e( 'FIELD_NOT_AUTH_NOT_ED', $this->name ) );
        }
        if ( !( $dexs ) ) {
            $data = null;
        }
        $this->setData( $data );
        return $data;
    }

    /**
     * Gets the data for a field and save it in the database
     * @param SPEntry $entry
     * @return bool
     */
    public function saveData( &$entry, $request = 'POST' )
    {
        if ( !( $this->enabled ) ) {
            return false;
        }
        $data = $this->verify( $entry, $request );
        $time = SPRequest::now();
        $IP = SPRequest::ip( 'REMOTE_ADDR', 0, 'SERVER' );
        $uid = Sobi::My( 'id' );

        /* if we are here, we can save these data */
        /* @var SPdb $db */
        $db =& SPFactory::db();

        /* collect the needed params */
        $params = array();
        $params[ 'publishUp' ] = $entry->get( 'publishUp' );
        $params[ 'publishDown' ] = $entry->get( 'publishDown' );
        $params[ 'fid' ] = $this->fid;
        $params[ 'sid' ] = $entry->get( 'id' );
        $params[ 'section' ] = Sobi::Reg( 'current_section' );
        $params[ 'lang' ] = Sobi::Lang();
        $params[ 'enabled' ] = ( int )$entry->get( 'state' );
        $params[ 'baseData' ] = strip_tags( $db->escape( $data ) );
        $params[ 'approved' ] = ( int )$entry->get( 'approved' );
        $params[ 'confirmed' ] = ( int )$entry->get( 'confirmed' );
        /* if it is the first version, it is new entry */
        if ( $entry->get( 'version' ) == 1 ) {
            $params[ 'createdTime' ] = $time;
            $params[ 'createdBy' ] = $uid;
            $params[ 'createdIP' ] = $IP;
        }
        $params[ 'updatedTime' ] = $time;
        $params[ 'updatedBy' ] = $uid;
        $params[ 'updatedIP' ] = $IP;
        $params[ 'copy' ] = ( int )!( $entry->get( 'approved' ) );

        /* save it */
        try {
            $db->insertUpdate( 'spdb_field_data', $params );
        }
        catch ( SPException $x ) {
            Sobi::Error( __CLASS__, SPLang::e( 'CANNOT_SAVE_DATA', $x->getMessage() ), SPC::WARNING, 0, __LINE__, __FILE__ );
        }
        if ( $this->function ) {
            $db->update( 'spdb_object', array( $this->function => gmdate( 'Y-m-d H:i:s', $data ) ), array( 'id' => $entry->get( 'id' ) ) );
        }
    }

    /**
     * Shows the field in the search form
     * @param bool $return return or display directly
     * @return string
     */
    public function searchForm( $return = false )
    {
        $this->createLangFile();
        $this->jQUiTheme = Sobi::Cfg( 'jquery.ui_theme', 'smoothness.smoothness' );
        SPFactory::header()->addJsFile( array( 'jquery', 'jquery-ui', 'timepicker', Sobi::Lang( false ) . '_calendar', 'calendar_search' ) );
        SPFactory::header()->addCssFile( array( 'timepicker', 'jquery-ui.' . $this->jQUiTheme ) );
        $opt = array(
            'ampm' => ( int )$this->inputFormClock12,
            'dateFormat' => $this->inputForm,
            'numberOfMonths' => ( int )$this->numMonths,
            'hourMin' => 0,
            'hourMax' => 24,
        );
        if ( count( $this->timeOpt ) ) {
            $opt[ 'timeFormat' ] = implode( ':', $this->timeOpt );
        }
        $opt = json_encode( $opt );
        $sf = isset( $this->_selected[ 'from' ] ) ? $this->_selected[ 'from' ] : 0;
        $st = isset( $this->_selected[ 'to' ] ) ? $this->_selected[ 'to' ] : 0;
        SPFactory::header()->addJsCode( "spCalendar( '{$this->nid}', {$opt}, {$sf}, {$st} );" );
        $field = null;
        if ( $this->width ) {
            $params[ 'style' ] = "width: {$this->width}px;";
        }
        $from = SPHtml_Input::text( $this->nid . '_from_selector', null, array( 'id' => $this->nid . '_from_selector', 'size' => $this->width, 'class' => $this->cssClass ) );
        $from .= SPHtml_Input::text( $this->nid . '[from]', $sf, array( 'id' => $this->nid . '_from', 'readonly' => 'readonly', 'style' => 'display:none;' ) );
        $to = SPHtml_Input::text( $this->nid . '_to_selector', null, array( 'id' => $this->nid . '_to_selector', 'size' => $this->width, 'class' => $this->cssClass ) );
        $to .= SPHtml_Input::text( $this->nid . '[to]', $st, array( 'id' => $this->nid . '_to', 'readonly' => 'readonly', 'style' => 'display:none;' ) );
        return '<div class="SPSearchSelectRangeFrom">
					<span>' . Sobi::Txt( 'SH.RANGE_FROM' ) . '</span>
					' . $from . ' ' . $this->suffix . '
				</div>
				<div class="SPSearchSelectRangeTo">
					<span>' . Sobi::Txt( 'SH.RANGE_TO' ) . '</span>
					' . $to . ' ' . $this->suffix . '
				</div>';
    }

    protected function searchForRange( &$request, $section )
    {
        $request[ 'from' ] = $request[ 'from' ] / 1000;
        if ( $request[ 'from' ] == 0 ) {
            $request[ 'from' ] = SPC::NO_VALUE;
        }
        $request[ 'to' ] = $request[ 'to' ] / 1000;
        if ( $request[ 'to' ] == 0 ) {
            $request[ 'to' ] = SPC::NO_VALUE;
        }
        return parent::searchForRange( $request, $section );
    }

    /**
     * @return array
     */
    public function struct()
    {
        $data = $this->getRaw();
        $format = $this->outputForm == 'custom' ? $this->outputFormCustom : $this->outputForm;
        if ( strlen( $data ) ) {
            $this->cssClass = strlen( $this->cssClass ) ? $this->cssClass : 'spFieldsData';
            $this->cssClass = $this->cssClass . ' ' . $this->nid;
            $this->cleanCss();
            $attributes = array(
                'lang' => Sobi::Lang( false ),
                'class' => $this->cssClass,
                'timestamp' => $data
            );
            return array(
                '_complex' => 1,
                '_data' => Sobi::Cfg( 'calendar.gmt_date', true ) ? gmdate( $format, $data ) : date( $format, $data ),
                '_attributes' => $attributes
            );
        }
    }
}
