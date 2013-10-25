<?php
/**
 * @version: $Id: qrcode.php 1855 2011-08-30 07:55:52Z Sigrid Suski $
 * @package: SobiPro QR-Code Field Application
 * ===================================================
 * @author
 * Name: Sigrid Suski & Radek Suski, Sigsiu.NET GmbH
 * Email: sobi[at]sigsiu.net
 * Url: http://www.Sigsiu.NET
 * ===================================================
 * @copyright Copyright (C) 2006 - 2011 Sigsiu.NET GmbH (http://www.sigsiu.net). All rights reserved.
 * @license see http://www.gnu.org/licenses/gpl.html GNU/GPL Version 3.
 * You can use, redistribute this file and/or modify it under the terms of the GNU General Public License version 3
 * 'QR Code' is registered trademark of DENSO WAVE INCORPORATED.
 * ===================================================
 * $Date: 2011-08-30 09:55:52 +0200 (Di, 30 Aug 2011) $
 * $Revision: 1855 $
 * $Author: Sigrid Suski $
 */

defined( 'SOBIPRO' ) || exit( 'Restricted access' );
SPLoader::loadClass( 'opt.fields.qrcode' );
/**
 * @author Radek Suski
 * @version 1.0
 * @created 25-Apr-2011 20:06:23
 */
class SPField_AdmQRCode extends SPField_QRCode implements SPFieldInterface
{
	public function save( &$attr )
	{
		$myAttr = $this->getAttr();
		$properties = array();
		if( count( $myAttr ) ) {
			foreach ( $myAttr as $property ) {
				$properties[ $property ] = isset( $attr[ $property ] ) ? ( $attr[ $property ] ) : null;
			}
		}
		$attr[ 'params' ] = $properties;
		$this->deleteCodes();
	}
}