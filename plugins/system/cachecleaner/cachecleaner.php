<?php
/**
 * Main Plugin File
 * Does all the magic!
 *
 * @package         Cache Cleaner
 * @version         3.1.2
 *
 * @author          Peter van Westen <peter@nonumber.nl>
 * @link            http://www.nonumber.nl
 * @copyright       Copyright © 2012 NoNumber All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

/**
 * Plugin that cleans cache
 */
class plgSystemCacheCleaner extends JPlugin
{
	function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);
	}

	function onAfterRoute()
	{
		jimport('joomla.filesystem.file');
		if (JFile::exists(JPATH_PLUGINS . '/system/nnframework/helpers/protect.php')) {
			require_once JPATH_PLUGINS . '/system/nnframework/helpers/protect.php';
			// return if page should be protected
			if (NNProtect::isProtectedPage('cachecleaner')) {
				return;
			}
		}

		// only in html
		if (JFactory::getDocument()->getType() != 'html') {
			return;
		}

		// load the admin language file
		$lang = JFactory::getLanguage();
		if ($lang->getTag() != 'en-GB') {
			// Loads English language file as fallback (for undefined stuff in other language file)
			$lang->load('plg_' . $this->_type . '_' . $this->_name, JPATH_ADMINISTRATOR, 'en-GB');
		}
		$lang->load('plg_' . $this->_type . '_' . $this->_name, JPATH_ADMINISTRATOR, null, 1);

		// return if NoNumber Framework plugin is not installed
		if (!JFile::exists(JPATH_PLUGINS . '/system/nnframework/nnframework.php')) {
			if (JFactory::getApplication()->isAdmin() && JFactory::getApplication()->input->get('option') != 'com_login') {
				$msg = JText::_('CC_NONUMBER_FRAMEWORK_NOT_INSTALLED');
				$msg .= ' ' . JText::sprintf('CC_EXTENSION_CAN_NOT_FUNCTION', JText::_('CACHE_CLEANER'));
				$mq = JFactory::getApplication()->getMessageQueue();
				foreach ($mq as $m) {
					if ($m['message'] == $msg) {
						$msg = '';
						break;
					}
				}
				if ($msg) {
					JFactory::getApplication()->enqueueMessage($msg, 'error');
				}
			}
			return;
		}

		// return if NoNumber Framework plugin is not enabled
		$nnep = JPluginHelper::getPlugin('system', 'nnframework');
		if (!isset($nnep->name)) {
			if (JFactory::getApplication()->isAdmin() && JFactory::getApplication()->input->get('option') != 'com_login') {
				$msg = JText::_('CC_NONUMBER_FRAMEWORK_NOT_ENABLED');
				$msg .= ' ' . JText::sprintf('CC_EXTENSION_MAY_NOT_FUNCTION', JText::_('CACHE_CLEANER'));
				$mq = JFactory::getApplication()->getMessageQueue();
				foreach ($mq as $m) {
					if ($m['message'] == $msg) {
						$msg = '';
						break;
					}
				}
				if ($msg) {
					JFactory::getApplication()->enqueueMessage($msg, 'notice');
				}
			}
			return;
		}

		// Load plugin parameters
		require_once JPATH_PLUGINS . '/system/nnframework/helpers/parameters.php';
		$parameters = NNParameters::getInstance();
		$params = $parameters->getPluginParams($this->_name, $this->_type, $this->params);

		$clean = 0;
		$show_msg = 0;

		if (!$clean) {
			$cleancache = JFactory::getApplication()->input->getString('cleancache');
			if ($cleancache != '') {
				if (JFactory::getApplication()->isSite() && $cleancache != $params->frontend_secret) {
					return;
				}
				$clean = 'clean';
				$show_msg = 1;
			}
		}

		if (!$clean) {
			$task = JFactory::getApplication()->input->get('task');
			if ($task) {
				$task = explode('.', $task, 2);
				$task = isset($task['1']) ? $task['1'] : $task['0'];
				if (strpos($task, 'save') === 0) {
					$task = 'save';
				}
				$tasks = array_diff(array_map('trim', explode(',', $params->auto_save_tasks)), array(''));
				if (!empty($tasks) && in_array($task, $tasks)) {
					if (JFactory::getApplication()->isAdmin() && $params->auto_save_admin) {
						$clean = 'save';
						$show_msg = $params->auto_save_admin_msg;
					} else if (JFactory::getApplication()->isSite() && $params->auto_save_front) {
						$clean = 'save';
						$show_msg = $params->auto_save_front_msg;
					}
				}
			}
		}


		if (!$clean) {
			return;
		}

		// Include the Helper
		require_once JPATH_PLUGINS . '/' . $this->_type . '/' . $this->_name . '/helper.php';
		$class = get_class($this) . 'Helper';
		$this->helper = new $class ($params, $clean, $show_msg, $params->show_size);
	}
}
