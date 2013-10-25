<?php
/**
 * @version: $Id: profile.php 1941 2011-10-17 15:39:31Z Radek Suski $
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
 * $Date: 2011-10-17 17:39:31 +0200 (Mo, 17 Okt 2011) $
 * $Revision: 1941 $
 * $Author: Radek Suski $
 */
defined( 'SOBIPRO' ) || exit( 'Restricted access' );
$row++;
?>
<div class="col width-70" style="float: left;">
	<fieldset class="adminform" style="border: 1px dashed silver;">
		<legend>
			<?php $this->txt( 'AFP_VIEW_LEGEND' ); ?>
		</legend>
		<table class="admintable" style="width:100%">
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'AFP_IS_IN_OUT' ); ?>
				</td>
				<td>
					<?php $this->field( 'select', 'field.isOutputOnly', array( 0 => Sobi::Txt( 'AFP_IS_IN' ), 1 => Sobi::Txt( 'AFP_IS_OUT' ) ), 'value:field.isOutputOnly', false, array( 'id' => 'field.isOutputOnly', 'size' => 1, 'maxlength' => 1, 'class' => 'inputbox', 'style' => 'text-align: center' ) ); ?>
				</td>
			</tr>
		</table>
		<fieldset class="adminform" style="border: 1px dashed silver;">
			<legend>
				<?php $this->txt( 'AFP_VIEW_LEGEND_INPUT' ); ?>
			</legend>
			<table class="admintable" style="width:100%">
				<tr class="row<?php echo ++$row%2; ?>">
					<td class="key">
						<?php $this->txt( 'AFP_UNAME_FIELD' ); ?>
					</td>
					<td>
						<?php $this->field( 'select', 'field.unameField', 'value:unameFields', 'value:field.unameField', false, array( 'id' => 'unameField', 'size' => 1, 'class' => 'inputbox' ) ); ?>
					</td>
				</tr>
				<tr class="row<?php echo ++$row%2; ?>">
					<td class="key">
						<?php $this->txt( 'AFP_NAME_FIELD' ); ?>
					</td>
					<td>
						<?php $this->field( 'select', 'field.nameField', 'value:unameFields', 'value:field.nameField', false, array( 'id' => 'nameField', 'size' => 1, 'class' => 'inputbox' ) ); ?>
					</td>
				</tr>
				<tr class="row<?php echo ++$row%2; ?>">
					<td class="key">
						<?php $this->txt( 'AFP_EMAIL_FIELD' ); ?>
					</td>
					<td>
						<?php $this->field( 'select', 'field.emailField', 'value:emailFields', 'value:field.emailField', false, array( 'id' => 'emailField', 'size' => 1, 'class' => 'inputbox' ) ); ?>
					</td>
				</tr>
				<?php if( SOBI_CMS != 'joomla15' ) { ?>
					<tr class="row<?php echo ++$row%2; ?>">
						<td class="key">
							<?php $this->txt( 'AFP_USGRP' ); ?>
						</td>
						<td>
							<?php $this->field( 'select', 'field.userGroup', 'value:userGroups', 'value:field.userGroup', true, array( 'id' => 'userGroup', 'size' => 10, 'class' => 'inputbox', 'style' => 'width: 200px;' ), false  ); ?>
						</td>
					</tr>
				<?php } ?>
				<tr class="row<?php echo ++$row%2; ?>">
					<td class="key">
						<?php $this->txt( 'AFP_AUTO_APP' ); ?>
					</td>
					<td>
						<?php $this->field( 'states', 'field.autoApp', 'value:field.autoApp', 'autoApp', 'yes_no', 'class=inputbox' ); ?>
					</td>
				</tr>
				<tr class="row<?php echo ++$row%2; ?>">
					<td class="key">
						<?php $this->txt( 'AFP_MIN_PASS' ); ?>
					</td>
					<td>
						<?php $this->field( 'select', 'field.minPass', array( 0 => 0, 5 => 5, 6 => 6, 8 => 8, 10 => 10, 15 => 15 ), 'value:field.minPass', false, array( 'id' => 'field.minPass', 'size' => 1, 'maxlength' => 1, 'class' => 'inputbox', 'style' => 'text-align: center' ) ); ?>
					</td>
				</tr>
				<tr class="row<?php echo ++$row%2; ?>">
					<td class="key">
						<?php $this->txt( 'AFP_SHOW_ENTRIES_FROM' ); ?>
					</td>
					<td>
						<?php $this->field( 'select', 'field.outSections', 'value:targetSection', 'value:field.outSections', true, array( 'id' => 'targetSection', 'size' => 10, 'class' => 'inputbox' ) ); ?>	</fieldset>
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset class="adminform" style="border: 1px dashed silver;">
			<legend>
				<?php $this->txt( 'AFP_VIEW_LEGEND_OUTPUT' ); ?>
			</legend>
			<table class="admintable" style="width:100%">
				<tr class="row<?php echo ++$row%2; ?>">
					<td class="key">
						<?php $this->txt( 'AFP_PROFILES_SECTION' ); ?>
					</td>
					<td>
						<?php $this->field( 'select', 'field.targetSection', 'value:targetSection', 'value:field.targetSection', false, array( 'id' => 'targetSection', 'size' => 1, 'class' => 'inputbox' ) ); ?>
					</td>
				</tr>
				<tr class="row<?php echo ++$row%2; ?>">
					<td class="key">
						<?php $this->txt( 'AFP_PASS_VCARD_DATA' ); ?>
					</td>
					<td>
						<?php $this->field( 'states', 'field.passFullData', 'value:field.passFullData', 'passFullData', 'yes_no', 'class=inputbox' ); ?>
					</td>
				</tr>
			</table>
		</fieldset>
	</fieldset>
</div>