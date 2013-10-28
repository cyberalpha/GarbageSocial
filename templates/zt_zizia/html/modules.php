<?php
/**
 * @version		$Id: modules.php 10381 2008-06-01 03:35:53Z pasamio $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/*
 * Module chrome that allows for rounded corners by wrapping in nested div tags
 */
function modChrome_ztrounded($module, &$params, &$attribs)
{
	/*	
$titles = JString::strpos($module->title, ' ');
	$title = ($titles !== false) ? JString::substr($module->title, 0, $titles).'<span>'.JString::substr($module->title, $titles).'</span>' : $module->title;
	*/
?>
		<div class="module<?php echo $params->get('moduleclass_sfx'); ?>">
			<div class="zt-tc">
				<div class="zt-tl"></div>
				<div class="zt-tr"></div>
			</div>
			<div class="zt-c">
				<div class="zt-c-inset"	>
					<?php if ($module->showtitle != 0) : ?>
						<h3 class="png"><?php echo $module->title; ?></h3>
					<?php endif; ?>
					<?php echo $module->content; ?>
					<br class="clearfix"/>
				</div>
			</div>
			<div class="zt-bc clearfix">
				<div class="zt-bl"></div>
				<div class="zt-br"></div>
			</div>		
		</div>
<?php
}

function modChrome_ztxhtml($module, &$params, &$attribs)
{
	/*$titles = JString::strpos($module->title, ' ');
	$title = ($titles !== false) ? JString::substr($module->title, 0, $titles).'<span>'.JString::substr($module->title, $titles).'</span>' : $module->title;
	*/
	if (!empty ($module->content)) : ?>
		<div class="moduletable<?php echo $params->get('moduleclass_sfx'); ?>">
			<div class="ztmodule">
				<?php if ($module->showtitle != 0) : ?>
					<h3 class="moduletitle"><span><?php echo $module->title; ?></span></h3>
				<?php endif; ?>
				<div class="modulecontent">
					<?php echo $module->content; ?>
				</div>
			</div>
		</div>
	<?php endif;
}

function modChrome_ztxhtml2($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<div class="moduletable<?php echo $params->get('moduleclass_sfx'); ?>">
			<div class="ztmodule">
				<?php if ($module->showtitle != 0) : ?>
					<h3 class="title"><span><?php echo $module->title; ?></span></h3>
				<?php endif; ?>
				<div class="modulecontent">
					<?php echo $module->content; ?>
				</div>
			</div>
		</div>
	<?php endif;
}
function modChrome_ztmobile($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<div class="moduletable<?php echo $params->get('moduleclass_sfx'); ?>">
			
				<?php if ($module->showtitle != 0) : ?>
					<h3 class="mtitle"><span><?php echo $module->title; ?></span></h3>
				<?php endif; ?>
				<div class="modulecontent">
					<?php echo $module->content; ?>
				</div>
			
		</div>
	<?php endif;
}