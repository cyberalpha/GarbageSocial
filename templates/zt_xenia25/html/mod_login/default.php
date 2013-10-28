<?php
/**
 * @version		$Id: default.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Site
 * @subpackage	mod_login
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
?>
<?php if ($type == 'logout') : ?>
<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form">
<?php if ($params->get('greeting')) : ?>
	<div class="login-greeting">
	<?php if($params->get('name') == 0) : {
		echo JText::sprintf('MOD_LOGIN_HINAME', $user->get('name'));
	} else : {
		echo JText::sprintf('MOD_LOGIN_HINAME', $user->get('username'));
	} endif; ?>
	</div>
<?php endif; ?>
	<div class="logout-button">
		<input type="submit" name="Submit" class="button" value="<?php echo JText::_('JLOGOUT'); ?>" />
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.logout" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
<?php else : ?>
<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form" >
	<div class="zt-login-form">
		<div class="clearfix">
			<div class="zt-field field1">
				<input id="modlgn_username" type="text" name="username" class="inputbox" alt="username" size="18" value="<?php echo JText::_('Username') ?>" onblur="if(this.value=='') this.value='<?php echo JText::_('Username') ?>';" onfocus="if(this.value=='<?php echo JText::_('Username') ?>') this.value='';" />
				<input id="modlgn_passwd" type="password" name="password" class="inputbox" size="18" alt="password" value="<?php echo JText::_('Password') ?>" onblur="if(this.value=='') this.value='<?php echo JText::_('Password') ?>';" onfocus="if(this.value=='<?php echo JText::_('Password') ?>') this.value='';" />
			</div>
			<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
			<div class="zt-field field2">
				<input id="modlgn-remember" type="checkbox" name="remember" value="yes"/>
				<label for="modlgn-remember"><?php echo JText::_('MOD_LOGIN_REMEMBER_ME') ?></label>
			</div>
			<?php endif; ?>
			<div class="zt-field field3">
				<input type="submit" name="Submit" class="button signin" value="<?php echo JText::_('JLOGIN') ?>" />
			</div>
			<div class="zt-field field4">
				<ul>
					<li><a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>"><?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a></li>
					<li><a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>"><?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?></a></li>
					<?php
					$usersConfig = JComponentHelper::getParams('com_users');
					if ($usersConfig->get('allowUserRegistration')) : ?>
					<li><a class="signup" href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>"><?php echo JText::_('MOD_LOGIN_REGISTER'); ?></a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>
	<input type="hidden" name="option" value="com_users" />
	<input type="hidden" name="task" value="user.login" />
	<input type="hidden" name="return" value="<?php echo $return; ?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>
<?php endif; ?>
