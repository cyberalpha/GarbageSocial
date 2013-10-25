<?php
/**
 * @package   gantry
 * @subpackage core
 * @version   4.1.4 November 22, 2012
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2012 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */
/** @var $gantry Gantry */
		global $gantry;
?>
<div id="hack-panel">
	<?php
	$fields = $this->gantryForm->getFullFieldset('toolbar-panel');
	foreach($fields as $name => $field) {
		//$gantry->addDomReadyScript("Gantry.ToolBar.add('".$field->type."');");

		$status = JRequest::getVar('gantry-'.$gantry->templateName.'-adminpresets', 'hide', 'COOKIE');
		$style = ' style="display: none";';

		if ($status != 'hide'){
			$status = 'hide';
			$style = '';
		}

		echo "<div id=\"contextual-".$field->type."-wrap\" class=\"contextual-custom-wrap\"".$style.">\n";
		echo "		<div class=\"metabox-prefs\">\n";

		echo $field->input;

		echo "		</div>\n";
		echo "</div>\n";
	}
	?>
</div>

