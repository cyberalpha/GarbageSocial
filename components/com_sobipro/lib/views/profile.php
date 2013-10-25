<?php
/**
 * @version: $Id: profile.php 2607 2012-07-12 18:02:01Z Radek Suski $
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
 * $Date: 2012-07-12 20:02:01 +0200 (Do, 12 Jul 2012) $
 * $Revision: 2607 $
 * $Author: Radek Suski $
 */

defined( 'SOBIPRO' ) || exit( 'Restricted access' );
SPLoader::loadView( 'section' );
/**
 * @author Radek Suski
 * @version 1.0
 * @created 06-Sep-2011 12:43:13
 */

class SPProfileView extends SPSectionView implements SPView
{
	public function parseEntry( $sid )
	{
        SPFactory::registry()->save();
        $entry = $this->entry( $sid, false, true );
        SPFactory::registry()->restore();
		return $entry;
	}

	public function parseEntries( $sids )
	{
		$entries = array();
		foreach ( $sids as $sid ) {
			$entries[ $sid ] = $this->parseEntry( $sid );
		}
		return $entries;
	}
}
