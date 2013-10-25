<?php
/**
 * @version: $Id: profile.php 1922 2011-10-06 18:18:38Z Sigrid Suski $
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
 * $Date: 2011-10-06 20:18:38 +0200 (Do, 06 Okt 2011) $
 * $Revision: 1922 $
 * $Author: Sigrid Suski $
 */

defined( 'SOBIPRO' ) || exit( 'Restricted access' );
SPLoader::loadController( 'profile' );
/**
 * @author Radek Suski
 * @version 1.0
 */
class SPAdmProfile extends SPProfile {}
