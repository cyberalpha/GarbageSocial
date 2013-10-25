<?php
/**
 * @version		$Id: default_button.php 15113 2010-02-28 14:34:26Z hackwar $
 * @package		Joomla.Administrator
 * @subpackage	mod_kc_admin_quickicons
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @copyright	Copyright (C) 2010 - 2011 Keashly.ca Consulting
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

?>
<div class="icon-wrapper">
	<div class="icon">
		<a href="<?php echo $button['link']; ?>">
			<!--<img src="<?php echo $button['path'] . $button['image']; ?>" alt="<?php echo $button['text']; ?>" /> -->
			<?php echo JHTML::_('image', $button['path'].$button['image'], NULL, NULL, false); ?>
			<span><?php echo $button['text']; ?></span></a>
	</div>
</div>
