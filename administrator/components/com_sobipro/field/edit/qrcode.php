<?php
/**
 * @version: $Id: qrcode.php 1856 2011-08-30 10:06:29Z Sigrid Suski $
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
 * $Date: 2011-08-30 12:06:29 +0200 (Di, 30 Aug 2011) $
 * $Revision: 1856 $
 * $Author: Sigrid Suski $
 */
defined( 'SOBIPRO' ) || exit( 'Restricted access' );
?>
<div class="col width-70" style="float: left;">
	<fieldset class="adminform" style="border: 1px dashed silver;">
		<legend>
			<?php $this->txt( 'QFA_PARAMS' ); ?>
		</legend>
		<table class="admintable">
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'QFA_PARAMS_ECC' ); ?>
				</td>
				<td>
					<?php $this->field( 'select', 'field.ecc', array( 'L' => Sobi::Txt( 'QFA_ECC_L' ), 'M' => Sobi::Txt( 'QFA_ECC_M' ), 'Q' => Sobi::Txt( 'QFA_ECC_Q' ), 'H' => Sobi::Txt( 'QFA_ECC_H' )  ), 'value:field.ecc', false, array( 'id' => 'fEcc', 'size' => 1, 'class' => 'inputbox spCfgNumberSelectList' ) ); ?>
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'QFA_PARAMS_POINT_SIZE' ); ?>
				</td>
				<td>
					<?php $this->field( 'select', 'field.pointSize', array( 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10  ), 'value:field.pointSize', false, array( 'id' => 'pointSize', 'size' => 1, 'class' => 'inputbox spCfgNumberSelectList' ) ); ?>
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'QFA_PARAMS_DATA' ); ?>
				</td>
				<td>
					<?php $this->field( 'textarea', 'field.qrData', 'value:field.qrData', false, 550, 150, 'id=field.qrData' ); ?>
				</td>
			</tr>

			<tr class="row<?php echo ++$row%2; ?>">
				<td colspan="2">
					<?php $this->txt( 'QFA_PARAMS_COPYRIGHT' ); ?>
				</td>
			</tr>
		</table>
	</fieldset>
</div>