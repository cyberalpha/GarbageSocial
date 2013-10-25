<?php
/**
 * @version: $Id: vgeomod.php 2146 2012-01-13 09:37:43Z Sigrid Suski $
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
 * $Date: 2012-01-13 10:37:43 +0100 (Fr, 13 Jan 2012) $
 * $Revision: 2146 $
 * $Author: Sigrid Suski $
 */

defined( 'SOBIPRO' ) || exit( 'Restricted access' );
SPLoader::loadView( 'section' );
/**
 * @author Radek Suski
 * @version 1.0
 * @created 06-Sep-2011 12:43:13
 */

class SPGeoModView extends SPSectionView implements SPView
{
	public function parseEntry( $sid )
	{
		return $this->entry( $sid, false, true );
	}

    public function display()
   	{
   		$data = array();
   		$visitor = $this->get( 'visitor' );
   		$data[ 'visitor' ] = $this->visitorArray( $visitor );
        $data[ 'entry' ] = $this->parseEntry( $this->get( 'sid' ) );
   		$this->_attr = $data;
   		$parser = SPFactory::Instance( 'mlo.template_xslt' );
   		$parser->setData( $this->_attr );
   		$parser->setType( 'SPGeoMod' );
   		$parser->setTemplate( $this->_template );
   		$parser->setProxy( $this );
   		return $parser->display( 'html' );
   	}
}
