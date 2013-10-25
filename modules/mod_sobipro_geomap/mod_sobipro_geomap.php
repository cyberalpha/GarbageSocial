<?php
/**
 * @version: $Id: mod_sobipro_geomap.php 2162 2012-01-17 16:27:04Z Radek Suski $
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
 * $Date: 2012-01-17 17:27:04 +0100 (Di, 17 Jan 2012) $
 * $Revision: 2162 $
 * $Author: Radek Suski $
 */
defined( '_JEXEC' ) || die( 'Direct Access to this location is not allowed.' );

$proceed = true;
$ignore = $params->get( 'ignoredParams', null );
if ( strlen( $ignore ) ) {
    $ignore = explode( "\n", $ignore );
    if ( count( $ignore ) ) {
        foreach ( $ignore as $row ) {
            $row = explode( '=', $row );
            if ( isset( $row[ 1 ] ) && JRequest::getVar( trim( $row[ 0 ] ) ) == trim( $row[ 1 ] ) ) {
                $proceed = false;
                break;
            }
        }
    }
}
if ( $proceed ) {
    $spMid = $module->module . '_' . $module->id;
    static $_possibleMapOpt = array( 'panControl', 'zoomControl', 'mapTypeControl', 'scaleControl', 'streetViewControl', 'overviewMapControl' );
    $settings = array(
        'mapWidth' => 200,
        'mapHeight' => 200,
        'zoomLevel' => 2,
        'availableViews' => '',
        'defaultView' => '',
        'mapOptions' => '',
        'iid' => $module->id,
        'sid' => '',
        'startLatitude' => 0,
        'startLongitude' => 0,
        'task' => JRequest::getCmd( 'task' ),
        'pid' => JRequest::getInt( 'sid' )
    );
    foreach ( $settings as $setting => $value ) {
        $settings[ $setting ] = $params->get( $setting, $value );
    }
    $mapOpt = array();
    foreach( $_possibleMapOpt as $opt ) {
        $mapOpt[ $opt ] = in_array( $opt, $settings[ 'mapOptions' ] );
    }
    $settings[ 'mapOptions' ] = $mapOpt;
    $settings = json_encode( $settings );
    JFactory::getDocument()->addScript( 'http://maps.google.com/maps/api/js?sensor=false' );
    JFactory::getDocument()->addScript( 'components/com_sobipro/lib/js/jquery.js' );
    JFactory::getDocument()->addScript( 'components/com_sobipro/lib/js/markerclusterer.js' );
    JFactory::getDocument()->addScript( 'components/com_sobipro/lib/js/geomod.js' );
    JFactory::getDocument()->addScriptDeclaration( "SPGeoMapModInit( '{$spMid}', {$settings} );" );
    $suffix = $params->get( 'moduleclass_sfx' );
    ?>
    <div id="<?php echo $spMid; ?>" class="SpGeoMapMod<?php echo $suffix; ?>">
        <div id="<?php echo $spMid; ?>Inner" class="SpGeoMapModInner<?php echo $suffix; ?>"></div>
    </div>
<?php } ?>
