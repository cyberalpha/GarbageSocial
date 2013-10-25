<?php
/**
 * @version: $Id: calendar.php 1932 2011-10-10 17:16:02Z Radek Suski $
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
 * $Date: 2011-10-10 19:16:02 +0200 (Mo, 10 Okt 2011) $
 * $Revision: 1932 $
 * $Author: Radek Suski $
 */

defined( 'SOBIPRO' ) || exit( 'Restricted access' );
SPLoader::loadClass( 'opt.fields.calendar' );
/**
 * @author Radek Suski
 * @version 1.0
 * @created 25-Apr-2011 20:06:23
 */
class SPField_AdmCalendar extends SPField_Calendar implements SPFieldInterface
{
	public function onFieldEdit( &$view )
	{
		if( !( strstr( Sobi::Cfg( 'field_types_for_ordering' ), 'calendar' ) ) ) {
			SPFactory::config()->saveCfg( 'field_types_for_ordering', Sobi::Cfg( 'field_types_for_ordering', 'inbox, select' ).', calendar' );
		}
	}
}