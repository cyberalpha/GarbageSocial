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
$formats = SPLoader::loadIniFile( 'etc.date_formats' );
SPLang::load( 'SpApp.calendar' );
?>
<div class="col width-70" style="float: left;">
	<fieldset class="adminform" style="border: 1px dashed silver;">
		<legend>
			<?php $this->txt( 'CFA_VIEW_LEGEND' ); ?>
		</legend>
		<table class="admintable">
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'CFA_INPUT_FORMAT' ); ?>
				</td>
				<td>
					<?php
						$dateForm = array();
						foreach ( $formats[ 'input' ] as $k => $v ) {
							$dateForm[ $k ] = $k.' => '.date( $v, 1764594000 );
						}
						unset( $formats[ 'input' ] );
						$this->field( 'select', 'field.inputForm', $dateForm, 'value:field.inputForm', false, array( 'id' => 'inputForm', 'size' => 1, 'class' => 'inputbox' ) );
					?>
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'CFA_INPUT_FORMAT_CLOCK_12' ); ?>
				</td>
				<td>
					<?php $this->field( 'states', 'field.inputFormClock12', 'value:field.inputFormClock12', 'inputFormClock12', 'yes_no', 'class=inputbox' ); ?>
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'CFA_TIME_OPT' ); ?>
				</td>
				<td>
					<?php $this->field( 'checkBoxGroup', 'field.timeOpt', array( 'hh' => Sobi::Txt( 'CFA_TIME_OPT_HOURS' ), 'mm' => Sobi::Txt( 'CFA_TIME_OPT_MINUTES' ), 'ss' => Sobi::Txt( 'CFA_TIME_OPT_SECONDS' ) ), 'field.timeOpt', 'value:field.timeOpt', array( 'class' => 'inputbox' ), false ); ?>
				</td>
			</tr>

			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'CFA_NUM_MONTHS' ); ?>
				</td>
				<td>
					<?php $this->field( 'select', 'field.numMonths', array( 1 => 1, 2 => 2, 3 => 3, 4 => 4), 'value:field.numMonths', false, array( 'id' => 'field.numMonths', 'size' => 1, 'maxlength' => 1, 'class' => 'inputbox', 'style' => 'text-align: center' ) ); ?>
				</td>
			</tr>

			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'CFA_OUTPUT_FORMAT' ); ?>
				</td>
				<td>
					<?php
						$dateForm = array();
						foreach ( $formats as $section => $values ) {
							$section = Sobi::Txt( $section );
							$dateForm[ $section ] = array();
							foreach ( $values as $k => $v ) {
								$dateForm[ $section ][ $k ] = $v.' => '.date( $k, 1764594000 );
							}
						}
						$dateForm[ 'custom' ] = Sobi::Txt( 'CFA_OUTPUT_FORMAT_CUSTOM' );
						$this->field( 'select', 'field.outputForm', $dateForm, 'value:field.outputForm', false, array( 'id' => 'outputForm', 'size' => 1, 'class' => 'inputbox' ) );
					?>
				</td>
			</tr>

			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'CFA_OUTPUT_FORMAT_CUSTOM' ); ?>
				</td>
				<td>
					<?php $this->field( 'text', 'field.outputFormCustom', 'value:field.outputFormCustom', array( 'id' => 'field.outputFormCustom', 'size' => 50, 'maxlength' => 150, 'class' => 'inputbox' ) ); ?>
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
					<?php $this->txt( 'FM.SEARCH_PRIORITY' ); ?>
				</td>
				<td>
					<?php $this->field( 'select', 'field.priority', array( 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10  ), 'value:field.priority', false, 'id=priority, size=1, class=inputbox spCfgNumberSelectList' ); ?>
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'CFA_FUNCTION' ); ?>
				</td>
				<td>
					<?php $this->field( 'select', 'field.function', array( 0 => 'translate:[CFA_FUNCTION_NONE]', 'validSince' => 'translate:[CFA_FUNCTION_PUP]', 'validUntil' => 'translate:[CFA_FUNCTION_PDOWN]' ), 'value:field.function', false, array( 'id' => 'field.function', 'size' => 1, ) ); ?>
				</td>
			</tr>
		</table>
	</fieldset>
</div>