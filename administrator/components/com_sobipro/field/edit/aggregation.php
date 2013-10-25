<?php
/**
 * @version: $Id: aggregation.php 1374 2011-05-19 13:18:11Z Sigrid Suski $
 * @package: SobiPro Aggregation Field Application
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
 * $Date: 2011-05-19 15:18:11 +0200 (Thu, 19 May 2011) $
 * $Revision: 1374 $
 * $Author: Sigrid Suski $
 */

defined( 'SOBIPRO' ) || exit( 'Restricted access' );
?>
<div class="col width-70" style="float: left;">
	<fieldset class="adminform" style="border: 1px dashed silver;">
		<legend>
			<?php $this->txt( 'AFA_VIEW_LEGEND' ); ?>
		</legend>
		<table class="admintable">
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'AFA_LABEL_FOR_TAG' ); ?>
				</td>
				<td>
					<?php $this->field( 'text', 'field.atText', 'value:field.atText', 'id=field_atText, size=50, maxlength=150, class=inputbox' ); ?>
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'AFA_SEP_SIGN' ); ?>
				</td>
				<td>
					<?php $this->field( 'text', 'field.sepSign', 'value:field.sepSign', 'id=field_sepSign, size=5, maxlength=10, class=inputbox, style=text-align:center;' ); ?>
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'FM.FILTER' ); ?>
				</td>
				<td>
					<?php $this->field( 'select', 'field.filter', 'value:filters', 'value:field.filter', false, 'id=filter, size=1, class=inputbox' ); ?>
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'FM.FIELD_WIDTH' ); ?>
				</td>
				<td>
					<?php $this->field( 'text', 'field.width', 'value:field.width', 'id=field_width, size=5, maxlength=10, class=inputbox, style=text-align:center;' ); ?>&nbsp;px.
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'FM.FIELD_HEIGHT' ); ?>
				</td>
				<td>
					<?php $this->field( 'text', 'field.height', 'value:field.height', 'id=field_height, size=5, maxlength=10, class=inputbox, style=text-align:center;' ); ?>&nbsp;px.
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'FM.MAX_LENGTH' ); ?>
				</td>
				<td>
					<?php $this->field( 'text', 'field.maxLength', 'value:field.maxLength', 'id=field_max_length, size=5, maxlength=10, class=inputbox, style=text-align:center;' ); ?>
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'AFA_MAX_TAGS' ); ?>
				</td>
				<td>
					<?php $this->field( 'text', 'field.numberOfTags', 'value:field.numberOfTags', 'id=field_numberOfTags, size=5, maxlength=10, class=inputbox, style=text-align:center;' ); ?>
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<label for="field.defSel">
						<?php $this->txt( 'AFA_DEF_VALS' ); ?>
					</label>
				</td>
				<td>
					<?php $this->field( 'textarea', 'field.defSel', 'value:field.defSel', false, 550, 30, 'id=field.defSel' ); ?>
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'FM.ADD_META_KEYS' ); ?>
				</td>
				<td>
					<?php $this->field( 'states', 'field.addToMetaKeys', 'value:field.addToMetaKeys', 'addToMetaKeys', 'yes_no', 'class=inputbox' ); ?>
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'FM.ADD_META_DESC' ); ?>
				</td>
				<td>
					<?php $this->field( 'states', 'field.addToMetaDesc', 'value:field.addToMetaDesc', 'addToMetaDesc', 'yes_no', 'class=inputbox' ); ?>
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'FM.IS_SEARCHABLE' ); ?>
				</td>
				<td>
					<?php $this->field( 'states', 'field.inSearch', 'value:field.inSearch', 'inSearch', 'yes_no', 'class=inputbox' ); ?>
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'FM.SEARCH_METHOD' ); ?>
				</td>
				<td>
					<?php $this->field( 'select', 'field.searchMethod', array( 'general' => 'translate:[FM.GENERAL_SEARCH_OPT]' ), 'value:field.searchMethod', false, 'id=searchMethod, size=1, class=inputbox' ); ?>
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'FM.SEARCH_PRIORITY' ); ?>
				</td>
				<td>
					<?php $this->field( 'select', 'field.priority', array( 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10  ), 'value:field.priority', false, 'id=priority, size=1, class=inputbox spCfgNumberSelectList' ); ?>
				</td>
			</tr>
		</table>
	</fieldset>
</div>