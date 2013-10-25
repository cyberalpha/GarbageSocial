 /**
 * @version: $Id: profile_settings.js 1915 2011-10-04 11:22:45Z Radek Suski $
 * @package: SobiPro Profile Field Application
 * ===================================================
 * @author
 * Name: Sigrid Suski & Radek Suski, Sigsiu.NET GmbH
 * Email: sobi[at]sigsiu.net
 * Url: http://www.Sigsiu.NET
 * ===================================================
 * @copyright Copyright (C) 2006 - 2011 Sigsiu.NET GmbH (http://www.sigsiu.net). All rights reserved.
 * @license see http://www.gnu.org/licenses/lgpl.html GNU/LGPL Version 3.
 * You can use, redistribute this file and/or modify it under the terms of the GNU Lesser General Public License version 3
 * ===================================================
 * $Date: 2011-10-04 13:22:45 +0200 (Di, 04 Okt 2011) $
 * $Revision: 1915 $
 * $Author: Radek Suski $
 */
 // Created at __CREATED__ by Sobi Pro Component
 
jQuery( document ).ready( function() {
	SPProfile( {
		'url' : '__REQUEST_URL__',
		'email': '__FIELD_EMAIL__',
		'name': '__FIELD_UNAME__',
		'length': __PASS_LENGTH__,
		'pass': '__PASS__',
		'nm_msg': '__NM_MSG__',
		'ts_msg': '__TS_MSG__'
	} );
} );