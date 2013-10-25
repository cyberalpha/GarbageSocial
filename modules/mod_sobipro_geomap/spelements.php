<?php
/**
 * @version: $Id: spelements.php 2152 2012-01-13 15:20:17Z Radek Suski $
 * @package: SobiPro SP-GeoMap Module Application
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
 * $Date: 2012-01-13 16:20:17 +0100 (Fr, 13 Jan 2012) $
 * $Revision: 2152 $
 * $Author: Radek Suski $
 */
defined( '_JEXEC' ) or die();
defined( 'DS' ) || define( 'DS', DIRECTORY_SEPARATOR );
define( 'SOBI_ROOT', JPATH_ROOT );
define( 'SOBI_PATH', SOBI_ROOT . DS . 'components' . DS . 'com_sobipro' );

class JElementSPElements extends JElement
{
    public static function getInstance()
    {
        static $instance = null;
        if ( !( $instance instanceof self ) ) {
            $instance = new self();
        }
        return $instance;
    }

    public function __construct()
    {
        static $loaded = false;
        if ( $loaded ) {
            return true;
        }
        require_once ( SOBI_PATH . '/lib/sobi.php' );
        Sobi::Init( SOBI_ROOT, JFactory::getConfig()->getValue( 'config.language' ) );
        SPLoader::loadClass( 'mlo.input' );
        SPFactory::config()->set( 'live_site', JURI::root() );
        $head = SPFactory::header();
        /* load admin html files */
        $head->addJsFile( 'sobipro' );
        $head->addJsFile( 'adm.sobipro' );
        JHTML::_( 'behavior.modal' );
        $ccurl = Sobi::Url( array( 'task' => 'category.chooser', 'out' => 'html', 'treetpl' => 'rchooser' ), true );
        //$ccmsg = Sobi::Txt( 'JS_SELECT_CATEGORY' );
        $cemsg = Sobi::Txt( 'JS_PLEASE_SELECT_SECTION_FIRST' );

        $head->addJsCode( '
			window.addEvent( "domready", function() {
					var semaphor = 0;
					var spApply = $$( "#toolbar-apply a" )[ 0 ];
					var spSave = $$( "#toolbar-save a" )[ 0 ];
					spApplyFn = spApply.onclick;
					spApply.onclick = null;
					spSaveFn = spSave.onclick;
					spSave.onclick = null;
					try {
						var spSaveNew = $$( "#toolbar-save-new a" )[ 0 ];
						spSaveNewFn = spSaveNew.onclick;
						spSaveNew.onclick = null;
						spSaveNew.addEvent( "click", function() {
							if( SPValidate() ) {
								spSaveNewFn();
							}
						} );
					} catch( e ) {}

					function SPValidate()
					{
						if( $( "sid" ).value == 0 || $( "sid" ).value == "" ) {
							alert( "' . Sobi::Txt( 'JS_YOU_HAVE_TO_AT_LEAST_SELECT_A_SECTION' ) . '" );
							return false;
						}
						else {
							return true;
						}
					}
					spApply.addEvent( "click", function() {
						if( SPValidate() ) {
							spApplyFn();
						}
					} );
					spSave.addEvent( "click", function() {
						if( SPValidate() ) {
							spSaveFn();
						}
					} );
					$( "spsection" ).addEvent( "change", function( event ) {
						sid = $( "spsection" ).options[ $( "spsection" ).selectedIndex ].value;
						$( "sid" ).value = sid;
						semaphor = 0;
					} );
					if( $( "sp_category" ) != null ) {
						$( "sp_category" ).addEvent( "click", function( ev ) {
							if( semaphor == 1 ) {
								return false;
							}
							semaphor = 1;
							new Event( ev ).stop();
							if( $( "sid" ).value == 0 ) {
								alert( "' . $cemsg . '" );
								semaphor = 0;
								return false;
							}
							else {
							url = "' . $ccurl . '&sid=" + $( "sid" ).value
				try {
					SqueezeBox.open( $( "sp_category" ), { handler: "iframe", size: { x: 700, y: 500 }, url: url });
				}
				catch( x ) {
					SqueezeBox.fromElement( $( "sp_category" ), { url: url, handler: "iframe", size: { x: 700, y: 500 } } );
				}
							}
						} );
					}
				} );
				function SP_close()
				{
					$( "sbox-btn-close" ).fireEvent( "click" );
					semaphor = 0;
				}
		' )
        ->addCssCode(
        	'.paramlist_value span { display: block; }'
        );
        $head->send();
        parent::__construct();
        $loaded = true;
    }

    private function ordering( $selected = null )
    {
        $fData = array(
            null => Sobi::Txt( 'FD.SEARCH_SELECT_LABEL' ),
//			'position.asc' => Sobi::Txt( 'SEC.CFG.ENTRY_ORDER_BY_POSITION_ASCENDING' ),
//			'position.desc' => Sobi::Txt( 'SEC.CFG.ENTRY_ORDER_BY_POSITION_DESCENDING' ),
            'counter.asc' => Sobi::Txt( 'SEC.CFG.ENTRY_ORDER_BY_POPULARITY_ASCENDING' ),
            'counter.desc' => Sobi::Txt( 'SEC.CFG.ENTRY_ORDER_BY_POPULARITY_DESCENDING' ),
            'createdTime.asc' => Sobi::Txt( 'SEC.CFG.ENTRY_ORDER_BY_CREATION_DATE_ASC' ),
            'createdTime.desc' => Sobi::Txt( 'SEC.CFG.ENTRY_ORDER_BY_CREATION_DATE_DESC' ),
            'updatedTime.asc' => Sobi::Txt( 'SEC.CFG.ENTRY_ORDER_BY_UPDATE_DATE_ASC' ),
            'updatedTime.desc' => Sobi::Txt( 'SEC.CFG.ENTRY_ORDER_BY_UPDATE_DATE_DESC' ),
            'validUntil.asc' => Sobi::Txt( 'SEC.CFG.ENTRY_ORDER_BY_EXPIRATION_DATE_ASC' ),
            'validUntil.desc' => Sobi::Txt( 'SEC.CFG.ENTRY_ORDER_BY_EXPIRATION_DATE_DESC' ),
            'RAND()' => JText::_( 'SOBI_MOD_RANDOM' ),
        );
        return SPHtml_Input::select( 'params[spOrder]', $fData, $selected );
    }

    public function fetchTooltip( $label )
    {
        switch ( $label ) {
            case 'SOBI_SELECT_SECTION':
                return JText::_( 'SOBI_SELECT_SECTION' );
            case 'sid':
                return JText::_( 'SOBI_SELECTED_SECTION' );
            case 'spOrder':
                return JText::_( 'SOBI_ORDER_BY' );
            case 'tplFile':
                return JText::_( 'SOBI_TPL_FILE' );
            case 'availableViews':
                return JText::_( 'SOBI_GMAP_MOD_AVAILABLE_VIEWS' );
            case 'mapOptions':
                return JText::_( 'SOBI_GMAP_MOD_MAP_OPTIONS' );
        }
    }

    private function tplFile( $selected = null )
    {
        if (
            !( file_exists( SOBI_PATH . '/usr/templates/front/modules/geomap/' ) ) ||
            ( count( scandir( SOBI_PATH . '/usr/templates/front/modules/geomap/' ) ) < 3 )
            || filemtime( SOBI_PATH . '/lib/ctrl/geomod.php' ) < 1326467930
        ) {
            $this->install();
        }
        $files = scandir( SOBI_PATH . '/usr/templates/front/modules/geomap/' );
        $tpls = array();
        if ( count( $files ) ) {
            foreach ( $files as $file ) {
                $stack = explode( '.', $file );
                if ( array_pop( $stack ) == 'xsl' ) {
                    $tpls[ $file ] = $file;
                }
            }
        }
        return SPHtml_Input::select( 'params[tplFile]', $tpls, $selected );
    }

    private function install()
    {
        SPFs::mkDir( SOBI_PATH . '/usr/templates/front/modules/geomap/' );
        SPFs::copy( dirname( __FILE__ ).'/install/default.xsl', SOBI_PATH . '/usr/templates/front/modules/geomap/default.xsl' );
        SPFs::copy( dirname( __FILE__ ).'/install/geomod.js', SOBI_PATH . '/lib/js/geomod.js' );
        SPFs::copy( dirname( __FILE__ ).'/install/geomod.js', SOBI_PATH . '/lib/js/geomod_uncompressed.js' );
        SPFs::copy( dirname( __FILE__ ).'/install/markerclusterer.js', SOBI_PATH . '/lib/js/markerclusterer.js' );
        SPFs::copy( dirname( __FILE__ ).'/install/markerclusterer.js', SOBI_PATH . '/lib/js/markerclusterer_uncompressed.js' );
        SPFs::copy( dirname( __FILE__ ).'/install/geomod.php', SOBI_PATH . '/lib/ctrl/geomod.php' );
        SPFs::copy( dirname( __FILE__ ).'/install/vgeomod.php', SOBI_PATH . '/lib/views/geomod.php' );
        SPFs::copy( dirname( __FILE__ ).'/install/ajax-loader.gif', SOBI_ROOT . '/media/sobipro/progress/ajax-loader.gif' );
    }

    private function settings()
    {
        static $settings = null;
        if ( !( $settings ) ) {
            $mid = JRequest::getVar( 'cid', JRequest::getVar( 'id', array() ) );
            if ( is_array( $mid ) ) {
                $mid = $mid[ 0 ];
            }
            $params = SPFactory::db()
                    ->select( 'params', '#__modules', array( 'id' => $mid ) )
                    ->loadResult();
            $settings = new JParameter( $params );
        }
        return $settings;
    }

    private function checkboxes( $name, $selected )
    {
    	switch ( $name ) {
    		case 'availableViews':
    			$values = array(
    				'roadmap' => JText::_( 'SOBI_GMAP_MOD_AVAILABLE_VIEWS_ROADMAP' ),
    				'satellite' => JText::_( 'SOBI_GMAP_MOD_AVAILABLE_VIEWS_SATELLITE' )
    			);
    		break;
    		case 'mapOptions':
    			$values = array(
    				'panControl' => JText::_( 'SOBI_GMAP_MOD_MAP_OPTIONS_PAN_CONTROL' ),
    				'mapTypeControl' => JText::_( 'SOBI_GMAP_MOD_MAP_OPTIONS_MAP_TYPE_CONTROL' ),
    				'streetViewControl' => JText::_( 'SOBI_GMAP_MOD_MAP_OPTIONS_STREET_VIEW_CONTROL' ),
    				'zoomControl' => JText::_( 'SOBI_GMAP_MOD_MAP_OPTIONS_ZOOM_CONTROL' ),
    				'scaleControl' => JText::_( 'SOBI_GMAP_MOD_MAP_OPTIONS_SCALE_CONTROL' ),
    				'overviewMapControl' => JText::_( 'SOBI_GMAP_MOD_MAP_OPTIONS_OVERVIEW_MAP_CONTROL' ),
    			);
    			break;
    	}
    	return SPHtml_Input::checkBoxGroup( 'params['.$name.']', $values, $name, $selected );
    }

    public function fetchElement( $name, &$label )
    {
        if ( $name == 'sid' ) {
            $params = array( 'id' => 'sid', 'size' => 5, 'class' => 'text_area', 'style' => 'text-align: center;', 'readonly' => 'readonly' );
            return SPHtml_Input::text( 'params[sid]', $this->settings()->get( 'sid' ), $params );
        }
        if ( $name == 'tplFile' ) {
            return $this->tplFile( $this->settings()->get( 'tplFile' ) );
        }
        if ( $name == 'availableViews' || $name == 'mapOptions' ) {
            return $this->checkboxes( $name, $this->settings()->get( $name ) );
        }

        $sections = array();
        $sout = array();
        try {
            $sections = SPFactory::db()
                    ->select( '*', 'spdb_object', array( 'oType' => 'section' ), 'id' )
                    ->loadObjectList();
        }
        catch ( SPException $x ) {
            trigger_error( 'sobipro|admin_panel|cannot_get_section_list|500|' . $x->getMessage(), SPC::WARNING );
        }
        if ( count( $sections ) ) {
            SPLoader::loadClass( 'models.datamodel' );
            SPLoader::loadClass( 'models.dbobject' );
            SPLoader::loadModel( 'section' );
            $sout[ ] = Sobi::Txt( 'SELECT_SECTION' );
            foreach ( $sections as $section ) {
                if ( Sobi::Can( 'section', 'access', 'valid', $section->id ) ) {
                    $s = new SPSection();
                    $s->extend( $section );
                    $sout[ $s->get( 'id' ) ] = $s->get( 'name' );
                }
            }
        }
        $params = array( 'id' => 'spsection', 'class' => 'text_area required' );
        $field = SPHtml_Input::select( 'params[sid]', $sout, $this->settings()->get( 'sid' ), false, $params );
        return "<div style=\"margin-top: 2px;\">{$field}</div>";
    }

    // not implemented yet
    private function getCat( $name )
    {
        return SPHtml_Input::button( 'sp_category', Sobi::Txt( 'SELECT_CATEGORY' ), array( 'id' => 'sp_category', 'class' => 'inputbox', 'style' => 'border: 1px solid silver;' ) );
    }
}
?>
