<?php
/**
 * @version		$Id: edit.php 20250 2011-01-10 14:27:02Z chdemko $
 * @package		Joomla.Site
 * @subpackage	com_weblinks
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<?php
if (version_compare(JVERSION, '3.0', 'ge'))
{
 include('edit_j30.php');
 //$model = JModelLegacy::getInstance('Article', 'ContentModel', array('ignore_request' => true));
}
else if (version_compare(JVERSION, '2.5', 'ge'))
{
 include('edit_j25.php');
}