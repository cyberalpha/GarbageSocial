<?php
/**
 * @version: $Id: geomap.php 1768 2011-08-03 20:22:35Z Radek Suski $
 * @package: SobiPro Template
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
 * $Date: 2011-08-03 22:22:35 +0200 (Mi, 03 Aug 2011) $
 * $Revision: 1768 $
 * $Author: Radek Suski $
 */
defined( 'SOBIPRO' ) || exit( 'Restricted access' );
SPFactory::header()->addCssCode( '
	div.spMapOpt span {
		display: block;
		float: left;
		min-width: 150px;
		padding: 4px;
	}
	div.spMapOpt {
		width: 350px;
	}
	'
);
SPLang::load( 'SpApp.geomap' );
?>
<div class="col width-70" style="float: left;">
	<fieldset class="adminform" style="border: 1px dashed silver;">
		<legend>
			<?php $this->txt( 'GMFA_VIEW_LEGEND' ); ?>
		</legend>
		<table class="admintable">
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'GMFA_MAP_WH' ); ?></td>
				<td>
					<?php $this->field( 'text', 'field.width', 'value:field.width', 'id=field_width, size=20, maxlength=50, class=inputbox, style=text-align:center;' ); ?>
					&nbsp;px.&nbsp;
					<?php $this->field( 'text', 'field.height', 'value:field.height', 'id=field_height, size=20, maxlength=50, class=inputbox, style=text-align:center;' ); ?>
					&nbsp;px.&nbsp;
				</td>
			</tr>
			<!--
			<tr class="row<?php //echo ++$row%2; ?>">
				<td class="key">
					<?php //$this->txt( 'Bubble' ); ?>
				</td>
				<td>
					<?php //$this->field( 'select', 'field.bubble',
						//'0=translate:[Disable], 1=translate:[Enable and Open], 2=translate:[Enable but open after click]',
						//'value:field.bubble', false, array( 'id' => 'bubble', 'size' => 1, 'class' => 'inputbox' )
					//); ?>
				</td>
			</tr>
			 -->
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'GMFA_ZOOM_LEVEL' ); ?>
				</td>
				<td>
					<?php $this->field( 'text', 'field.zoomLevel', 'value:field.zoomLevel', array( 'id' => 'field_zoomLevel', 'size' => 5, 'class' => 'inputbox' ) ); ?>
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'GMFA_AVAILABLE_VIEWS' ); ?>
				</td>
				<td>
					<?php $this->field( 'select', 'field.mapViews',
						'ROADMAP=translate:[GMFA_VIEWS_ROADMAP], SATELLITE=translate:[GMFA_VIEWS_SATELLITE]',
						'value:field.mapViews', true, array( 'id' => 'mapViews', 'class' => 'inputbox', 'style' => 'width: 200px;' )
					); ?>
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'GMFA_DEFAULT_VIEW' ); ?>
				</td>
				<td>
					<?php $this->field( 'select', 'field.defView',
						'ROADMAP=translate:[GMFA_VIEWS_ROADMAP], SATELLITE=translate:[GMFA_VIEWS_SATELLITE], HYBRID=translate:[GMFA_VIEWS_HYBRID], TERRAIN=translate:[GMFA_VIEWS_TERRAIN]',
						'value:field.defView', false, array( 'id' => 'defView', 'size' => 1, 'class' => 'inputbox', 'style' => 'width: 200px;' )
					); ?>
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'GMFA_MAP_OPTIONS' ); ?>
				</td>
				<td>
					<div class="spMapOpt">
						<?php
							$this->field(
								'checkBoxGroup',
								'field.mapOpt',
								array(
									'panControl' => Sobi::Txt( 'GMFA_PAN_CONTROL' ),
									'zoomControl' => Sobi::Txt( 'GMFA_ZOOM_CONTROL' ),
									'mapTypeControl' => Sobi::Txt( 'GMFA_MAP_TYPE_CONTROL' ),
									'scaleControl' => Sobi::Txt( 'GMFA_SCALE_CONTROL' ),
									'streetViewControl' => Sobi::Txt( 'GMFA_STREET_VIEW_CONTROL' ),
									'overviewMapControl' => Sobi::Txt( 'GMFA_OVERVIEW_MAP_CONTROL' ),
								),
								'field.mapOpt',
								'value:field.mapOpt',
								array( 'class' => 'inputbox' ),
								false
							);
						?>
					</div>
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'GMFA_ADD_META' ); ?>
				</td>
				<td>
					<?php $this->field( 'states', 'field.addToMetaKeys', 'value:field.addToMetaKeys', 'addToMetaKeys', 'yes_no', 'class=inputbox' ); ?>
				</td>
			</tr>
		</table>
	</fieldset>

	<fieldset class="adminform" style="border: 1px dashed silver;">
		<legend>
			<?php $this->txt( 'GMFA_EDIT_LEGEND' ); ?>
		</legend>
		<table class="admintable">
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'GMFA_MAP_WH' ); ?></td>
				<td>
					<?php $this->field( 'text', 'field.formWidth', 'value:field.formWidth', 'id=field_fwidth, size=20, maxlength=50, class=inputbox, style=text-align:center;' ); ?>
					&nbsp;px.&nbsp;
					<?php $this->field( 'text', 'field.formHeight', 'value:field.formHeight', 'id=field_fheight, size=20, maxlength=50, class=inputbox, style=text-align:center;' ); ?>
					&nbsp;px.&nbsp;
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'GMFA_DETERMINE_LOCATION' ); ?>
				</td>
				<td>
					<?php $this->field( 'states', 'field.determineLocation', 'value:field.determineLocation', 'determineLocation', 'yes_no', 'class=inputbox' ); ?>
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'GMFA_START_POINT_COORDINATES' ); ?>
				</td>
				<td>
					<?php $this->field( 'text', 'field.startPoint', 'value:field.startPoint', array( 'id' => 'field_startPoint', 'size' => 50, 'class' => 'inputbox' ) ); ?>
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'GMFA_ZOOM_LEVEL' ); ?>
				</td>
				<td>
					<?php $this->field( 'text', 'field.formZoomLevel', 'value:field.formZoomLevel', array( 'id' => 'field_formZoomLevel', 'size' => 5, 'class' => 'inputbox' ) ); ?>
				</td>
			</tr>
			<!--
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php //$this->txt( 'Default Region Code' ); ?>
				</td>
				<td>
					<?php //$this->field( 'text', 'field.defRegion', 'value:field.defRegion', array( 'id' => 'field_defRegion', 'size' => 10, 'class' => 'inputbox' ) ); ?>
				</td>
			</tr>
			-->
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'GMFA_AVAILABLE_VIEWS' ); ?>
				</td>
				<td>
					<?php $this->field( 'select', 'field.formMapViews',
						'ROADMAP=translate:[GMFA_VIEWS_ROADMAP], SATELLITE=translate:[GMFA_VIEWS_SATELLITE]',
						'value:field.formMapViews', true, array( 'id' => 'formMapViews', 'class' => 'inputbox', 'style' => 'width: 200px;' )
					); ?>
				</td>
			</tr>

			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'GMFA_DEFAULT_VIEW' ); ?>
				</td>
				<td>
					<?php $this->field( 'select', 'field.defFormView',
						'ROADMAP=translate:[GMFA_VIEWS_ROADMAP], SATELLITE=translate:[GMFA_VIEWS_SATELLITE], HYBRID=translate:[GMFA_VIEWS_HYBRID]',
						'value:field.defFormView', false, array( 'id' => 'defFormView', 'size' => 1, 'class' => 'inputbox', 'style' => 'width: 200px;' )
					); ?>
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'GMFA_MAP_OPTIONS' ); ?>
				</td>
				<td>
					<div class="spMapOpt">
						<?php
							$this->field(
								'checkBoxGroup',
								'field.mapFormOpt',
								array(
									'panControl' => Sobi::Txt( 'GMFA_PAN_CONTROL' ),
									'zoomControl' => Sobi::Txt( 'GMFA_ZOOM_CONTROL' ),
									'mapTypeControl' => Sobi::Txt( 'GMFA_MAP_TYPE_CONTROL' ),
									'scaleControl' => Sobi::Txt( 'GMFA_SCALE_CONTROL' ),
									'streetViewControl' => Sobi::Txt( 'GMFA_STREET_VIEW_CONTROL' ),
									'overviewMapControl' => Sobi::Txt( 'GMFA_OVERVIEW_MAP_CONTROL' ),
								),
								'field.mapFormOpt',
								'value:field.mapFormOpt',
								array( 'class' => 'inputbox' ),
								false
							);
						?>
					</div>
				</td>
			</tr>
			<tr class="row<?php echo ++$row%2; ?>">
				<td class="key">
					<?php $this->txt( 'GMFA_ADDRESS_FIELDS' ); ?>
				</td>
				<td>
					<?php $this->field( 'textarea', 'field.addrFields', 'value:field.addrFields', false, 500, 30 ); ?>
				</td>
			</tr>
		</table>
	</fieldset>
</div>