<?php

/**
 * @package     Prieco.Modules
 * @subpackage  mod_sobipsearch - Search in Selected Section
 * 
 * @author      Prieco S.A. <support@extly.com>
 * @copyright   Copyright (C) 2010 - 2012 Prieco, S.A. All rights reserved.
 * @license     http://http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL 
 * @link        http://www.prieco.com http://www.extly.com http://support.extly.com 
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

$output = '<div class="SPSearchField' . $moduleclass_sfx . '">
	<input type="text" id="' . $inputid . $moduleid . '" 
		class="SPSearchBox inputbox' . $moduleclass_sfx . '" 
		value="' . $text . '" 
		name="sp_search_for" 
		maxlength="' . $maxlength . '" 
		alt="' . $button_text . '" 
		size="' . $width . '" 
		onblur="if(this.value==\'\') this.value=\'' . $text . '\';" onfocus="if(this.value==\'' . $text . '\') this.value=\'\';" /></div>';

$output .= $select;

?>
<form action="index.php" method="post" id="spSearchForm">
    <div class="SPSearch<?php echo $moduleclass_sfx; ?> search<?php 
		echo $moduleclass_sfx; ?>">
		<?php

		if ($button)
		{
			$button = '<input type="submit" value="' . $button_text . '" class="button' . $moduleclass_sfx . '" onclick="this.form.searchword.focus();"/>';
		}

		switch ($button_pos)
		{
			case 'top' :
				$button = $button . '<br />';
				$output = $button . $output;
				break;

			case 'bottom' :
				$button = '<br />' . $button;
				$output = $output . $button;
				break;

			case 'right' :
				$output = $output . $button;
				break;

			case 'left' :
			default :
				$output = $button . $output;
				break;
		};

		echo $output;
		?>
    </div>

	<?php
	/*
	  <input type="hidden" value="132049152613.79" name="ssid" id="SP_ssid">
	  <input type="hidden" value="1" name="2a84c4a273ee0267c82c023776ea692d" id="SP_2a84c4a273ee0267c82c023776ea692d">
	  <input type="hidden" value="40" name="sid" id="SP_sid">
	 */
	?>
    <input type="hidden" value="search.search" name="task" id="SP_task" />
    <input type="hidden" value="com_sobipro" name="option" id="SP_option" />
    <input type="hidden" value="<?php echo $mitemid; ?>" name="Itemid" id="SP_Itemid" />

</form>
