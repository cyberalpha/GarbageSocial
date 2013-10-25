<?php
/**
* @version 1.3.0
* @package RSform!Pro 1.3.0
* @copyright (C) 2007-2010 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

/**
 * RSForm! Pro system plugin
 */
class plgSystemRSFPMailChimp extends JPlugin
{
	/**
	 * Constructor
	 *
	 * For php4 compatibility we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @access	protected
	 * @param	object	$subject The object to observe
	 * @param 	array   $config  An array that holds the plugin configuration
	 * @since	1.0
	 */
	function plgSystemRSFPMailChimp(&$subject, $config)
	{
		parent::__construct($subject, $config);
	}
	
	function canRun()
	{
		if (class_exists('RSFormProHelper')) return true;
		
		$helper = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rsform'.DS.'helpers'.DS.'rsform.php';
		if (file_exists($helper))
		{
			require_once($helper);
			RSFormProHelper::readConfig();
			return true;
		}
		
		return false;
	}
	
	function rsfp_onFormSave($form)
	{
		$post = JRequest::get('post', JREQUEST_ALLOWRAW);
		$post['form_id'] = $post['formId'];
		
		$row = JTable::getInstance('RSForm_MailChimp', 'Table');
		if (!$row)
			return;
		if (!$row->bind($post))
		{
			JError::raiseWarning(500, $row->getError());
			return false;
		}
		
		$row->mc_merge_vars = serialize($post['merge_vars']);
		$row->mc_interest_groups = serialize($post['interest_groups']);
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT form_id FROM #__rsform_mailchimp WHERE form_id='".(int) $post['form_id']."'");
		if (!$db->loadResult())
		{
			$db->setQuery("INSERT INTO #__rsform_mailchimp SET form_id='".(int) $post['form_id']."'");
			$db->query();
		}
		
		if ($row->store())
		{
			return true;
		}
		else
		{
			JError::raiseWarning(500, $row->getError());
			return false;
		}
	}
	
	function rsfp_bk_onAfterShowFormEditTabs()
	{
		$formId = JRequest::getInt('formId');
		
		$lang =& JFactory::getLanguage();
		$lang->load('plg_system_rsfpmailchimp');
		
		$row = JTable::getInstance('RSForm_MailChimp', 'Table');
		if (!$row)
			return;
		$row->load($formId);
		$row->mc_merge_vars = @unserialize($row->mc_merge_vars);
		if ($row->mc_merge_vars === false)
			$row->mc_merge_vars = array();
			
		$row->mc_interest_groups = @unserialize($row->mc_interest_groups);
		if ($row->mc_interest_groups === false)
			$row->mc_interest_groups = array();
		
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rsform'.DS.'helpers'.DS.'mcapi.php');
		$mailchimp = new RSFP_MCAPI();
		
		jimport('joomla.html.pane');
		$tabs =& JPane::getInstance('Tabs', array(), true);
		
		// Fields
		$fields_array = $this->_getFields($formId);
		$fields = array();
		foreach ($fields_array as $field)
			$fields[] = JHTML::_('select.option', $field, $field);
		
		// Action
		$mailchimp_action = array(
			JHTML::_('select.option', 1, JText::_('RSFP_MAILCHIMP_ACTION_SUBSCRIBE')),
			JHTML::_('select.option', 0, JText::_('RSFP_MAILCHIMP_ACTION_UNSUBSCRIBE')),
			JHTML::_('select.option', 2, JText::_('RSFP_MAILCHIMP_LET_USER_DECIDE'))
		);
		$lists['mc_action'] = JHTML::_('select.genericlist', $mailchimp_action, 'mc_action', 'onchange="rsfp_changeMcAction(this);"', 'value', 'text', $row->mc_action);
		
		// Action Field
		$lists['mc_action_field'] = JHTML::_('select.genericlist', $fields, 'mc_action_field', $row->mc_action != 2 ? 'disabled="disabled"' : '', 'value', 'text', $row->mc_action_field);
		
		// Email Type
		$mailchimp_email_type = array(
			JHTML::_('select.option', 'html', JText::_('RSFP_MAILCHIMP_HTML')),
			JHTML::_('select.option', 'text', JText::_('RSFP_MAILCHIMP_TEXT')),
			JHTML::_('select.option', 'mobile', JText::_('RSFP_MAILCHIMP_MOBILE')),
			JHTML::_('select.option', 'user', JText::_('RSFP_MAILCHIMP_LET_USER_DECIDE'))
		);
		$lists['mc_email_type'] = JHTML::_('select.genericlist', $mailchimp_email_type, 'mc_email_type', 'onchange="rsfp_changeMcEmailType(this);"', 'value', 'text', $row->mc_email_type);
		
		// Email Type Field
		$lists['mc_email_type_field'] = JHTML::_('select.genericlist', $fields, 'mc_email_type_field', $row->mc_email_type != 'user' ? 'disabled="disabled"' : '', 'value', 'text', $row->mc_email_type_field);
		
		// MailChimp Lists
		$results = $mailchimp->lists();
		$mailchimp_lists = array(
			JHTML::_('select.option', '', JText::_('RSFP_PLEASE_SELECT_LIST'))
		);
		if ($mailchimp->errorCode)
		{
			if (RSFormProHelper::getConfig('mailchimp.key'))
				JError::raiseWarning(500, '(MailChimp) '.$mailchimp->errorMessage);
		}
		else
			foreach ($results['data'] as $result)
				$mailchimp_lists[] = JHTML::_('select.option', $result['id'], $result['name']);
		$lists['mc_list_id'] = JHTML::_('select.genericlist', $mailchimp_lists, 'mc_list_id', 'onchange="rsfp_changeMcList(this);"', 'value', 'text', $row->mc_list_id);
		
		// Merge Vars
		$merge_vars = JText::_('RSFP_PLEASE_SELECT_LIST');
		if ($row->mc_list_id)
		{
			$results = $mailchimp->listMergeVars($row->mc_list_id);
			if ($mailchimp->errorCode)
			{
				if (RSFormProHelper::getConfig('mailchimp.key'))
					JError::raiseWarning(500, '(MailChimp) '.$mailchimp->errorMessage);
			}
			else
				$merge_vars = $results;
		}
		
		$lists['fields'] = array();
		if (is_array($merge_vars))
			foreach ($merge_vars as $i => $merge_var)
				$lists['fields'][$merge_var['tag']] = JHTML::_('select.genericlist', $fields, 'merge_vars['.$merge_var['tag'].']', null, 'value', 'text', isset($row->mc_merge_vars[$merge_var['tag']]) ? $row->mc_merge_vars[$merge_var['tag']] : null);
		
		// Interest Groups
		$interest_groups = JText::_('RSFP_PLEASE_SELECT_LIST');
		if ($row->mc_list_id)
		{
			$results = $mailchimp->listInterestGroupings($row->mc_list_id);
			if ($mailchimp->errorCode)
			{
				if (RSFormProHelper::getConfig('mailchimp.key'))
					JError::raiseWarning(500, '(MailChimp) '.$mailchimp->errorMessage);
			}
			else
				$interest_groups = $results;
		}
		
		$lists['fields_groups'] = array();
		if (is_array($interest_groups))
			foreach ($interest_groups as $i => $interest_group)
			{
				$lists['fields_groups'][$interest_group['id']] = JHTML::_('select.genericlist', $fields, 'interest_groups['.$interest_group['name'].']', null, 'value', 'text', isset($row->mc_interest_groups[$interest_group['name']]) ? $row->mc_interest_groups[$interest_group['name']] : null);
				foreach ($interest_group['groups'] as $group)
					$lists['field_groups_desc'][$interest_group['id']][] = $group['name'];
				
				$lists['field_groups_desc'][$interest_group['id']] = implode(', ', $lists['field_groups_desc'][$interest_group['id']]);
			}
		
		$lists['mc_double_optin'] = JHTML::_('select.booleanlist','mc_double_optin','class="inputbox"',$row->mc_double_optin);
		$lists['mc_update_existing'] = JHTML::_('select.booleanlist','mc_update_existing','class="inputbox"',$row->mc_update_existing);
		$lists['mc_replace_interests'] = JHTML::_('select.booleanlist','mc_replace_interests','class="inputbox"',$row->mc_replace_interests);
		$lists['mc_send_welcome'] = JHTML::_('select.booleanlist','mc_send_welcome','class="inputbox"',$row->mc_send_welcome);
		
		$lists['mc_delete_member'] = JHTML::_('select.booleanlist','mc_delete_member','class="inputbox"',$row->mc_delete_member);
		$lists['mc_send_goodbye'] = JHTML::_('select.booleanlist','mc_send_goodbye','class="inputbox"',$row->mc_send_goodbye);
		$lists['mc_send_notify'] = JHTML::_('select.booleanlist','mc_send_notify','class="inputbox"',$row->mc_send_notify);
		
		$lists['published'] = JHTML::_('select.booleanlist','mc_published','class="inputbox"',$row->mc_published);
		
		echo '<div id="mailchimpdiv">';
			include(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rsform'.DS.'helpers'.DS.'mailchimp.php');
		echo '</div>';
	}
	
	function rsfp_bk_onAfterShowFormEditTabsTab()
	{
		$lang =& JFactory::getLanguage();
		$lang->load('plg_system_rsfpmailchimp');
		
		echo '<li><a href="javascript: void(0);" id="mailchimp"><span>'.JText::_('RSFP_MAILCHIMP_INTEGRATION').'</span></a></li>';
	}
	
	function rsfp_f_onAfterFormProcess($args)
	{
		$db = JFactory::getDBO();
		
		$formId = (int) $args['formId'];
		$SubmissionId = (int) $args['SubmissionId'];
		
		$db->setQuery("SELECT * FROM #__rsform_mailchimp WHERE `form_id`='".$formId."' AND `mc_published`='1'");
		if ($row = $db->loadObject())
		{
			if (!$row->mc_list_id) return;
			
			require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rsform'.DS.'helpers'.DS.'mcapi.php');
			$mailchimp = new RSFP_MCAPI();
			
			list($replace, $with) = RSFormProHelper::getReplacements($SubmissionId);
			
			$row->mc_merge_vars = @unserialize($row->mc_merge_vars);
			if ($row->mc_merge_vars === false)
				$row->mc_merge_vars = array();
			
			if (!isset($row->mc_merge_vars['EMAIL']))
				return;
			
			$row->mc_interest_groups = @unserialize($row->mc_interest_groups);
			if ($row->mc_interest_groups === false)
				$row->mc_interest_groups = array();
			
			$form = JRequest::getVar('form');
			
			$email_address = @$form[$row->mc_merge_vars['EMAIL']];
			
			$merge_vars = array();		
			if (!empty($row->mc_merge_vars))
			foreach ($row->mc_merge_vars as $tag => $field)
			{
				if ($tag == 'EMAIL' || $field == '- IGNORE -') continue;
				
				if (!isset($form[$field]))
					$form[$field] = '';
				
				if (is_array($form[$field]))
				{
					array_walk($form[$field], array('plgSystemRSFPMailChimp', '_escapeCommas'));
					$form[$field] = implode(',', $form[$field]);
				}
				
				$merge_vars[$tag] = $form[$field];
			}
			
			// Interest Groups
			$merge_vars['INTERESTS'] = '';
			
			$interests = array();
			if (!empty($row->mc_interest_groups))
			foreach ($row->mc_interest_groups as $group => $field)
			{
				if ($field == '- IGNORE -') continue;
				if (!isset($form[$field]))  continue;
				
				if (is_array($form[$field]))
				{
					array_walk($form[$field], array('plgSystemRSFPMailChimp', '_escapeCommas'));
					$interests = array_merge($interests, $form[$field]);
				}
				else
				{
					plgSystemRSFPMailChimp::_escapeCommas($form[$field]);
					$interests[] = $form[$field];
				}
			}
			$merge_vars['INTERESTS'] = implode(',', $interests);
			
			// Email Type
			$email_type = $row->mc_email_type;
			$valid = array('html', 'text', 'mobile');
			if ($row->mc_email_type == 'user')
				$email_type = isset($form[$row->mc_email_type_field]) && in_array(strtolower(trim($form[$row->mc_email_type_field])), $valid) ? $form[$row->mc_email_type_field] : 'html';
			
			$double_optin = $row->mc_double_optin;
			$update_existing = $row->mc_update_existing;
			$replace_interests = $row->mc_replace_interests;
			$send_welcome = $row->mc_send_welcome;
			
			$delete_member = $row->mc_delete_member;
			$send_goodbye = $row->mc_send_goodbye;
			$send_notify = $row->mc_send_notify;
			
			$list_id = $row->mc_list_id;
			
			// Subscribe action - Subscribe, Unsubscribe or Let the user choose
			$subscribe = 'ignore';
			if ($row->mc_action == 1)
				$subscribe = 'subscribe';
			elseif ($row->mc_action == 0)
				$subscribe = 'unsubscribe';
			elseif ($row->mc_action == 2 && isset($form[$row->mc_action_field]))
			{
				if (is_array($form[$row->mc_action_field]))
					foreach ($form[$row->mc_action_field] as $i => $value)
					{
						$value = strtolower(trim($value));
						if ($value == 'subscribe')
						{
							$subscribe = 'subscribe';
							break;
						}
						elseif ($value == 'unsubscribe')
						{
							$subscribe = 'unsubscribe';
							break;
						}
					}
				else
				{
					$form[$row->mc_action_field] = strtolower(trim($form[$row->mc_action_field]));
					if ($form[$row->mc_action_field] == 'subscribe')
						$subscribe = 'subscribe';
					elseif ($form[$row->mc_action_field] == 'unsubscribe')
						$subscribe = 'unsubscribe';
				}
			}
			
			if ($subscribe == 'subscribe')
				$mailchimp->listSubscribe($list_id, $email_address, $merge_vars, $email_type, $double_optin, $update_existing, $replace_interests, $send_welcome);
			elseif ($subscribe == 'unsubscribe')
				$mailchimp->listUnsubscribe($list_id, $email_address, $delete_member, $send_goodbye, $send_notify);
			
			if ($mailchimp->errorCode)
				JError::raiseWarning(500, '(MailChimp) '.$mailchimp->errorMessage);
		}
	}
	
	function rsfp_bk_onAfterShowConfigurationTabs()
	{
		if (!$this->canRun()) return;
		
		$lang =& JFactory::getLanguage();
		$lang->load('plg_system_rsfpmailchimp');
		
		jimport('joomla.html.pane');
		$tabs =& JPane::getInstance('Tabs', array(), true);
		
		echo $tabs->startPanel(JText::_('MailChimp'), 'form-mailchimp');
			$this->mailChimpConfigurationScreen();
		echo $tabs->endPanel();
	}
	
	function mailChimpConfigurationScreen()
	{
		if (!$this->canRun()) return;		
		
		$lang =& JFactory::getLanguage();
		$lang->load('plg_system_rsfpmailchimp');
		
		$lists['mailchimpsecure'] = JHTML::_('select.booleanlist', 'rsformConfig[mailchimp.secure]', null, RSFormProHelper::getConfig('mailchimp.secure'));
		?>
		<div id="page-recaptcha">
			<table class="admintable">
				<tr>
					<td width="200" style="width: 200px;" align="right" class="key"><label for="mailchimpkey"><span class="hasTip" title="<?php echo JText::_('RSFP_MAILCHIMP_API_KEY_DESC'); ?>"><?php echo JText::_( 'RSFP_MAILCHIMP_API_KEY' ); ?></span></label></td>
					<td><input type="text" name="rsformConfig[mailchimp.key]" id="mailchimpkey" value="<?php echo RSFormProHelper::htmlEscape(RSFormProHelper::getConfig('mailchimp.key')); ?>" size="100" maxlength="100"></td>
				</tr>
				<tr>
					<td width="200" style="width: 200px;" align="right" class="key"><label for="mailchimpsecure"><span class="hasTip" title="<?php echo JText::_('RSFP_MAILCHIMP_SECURE_DESC'); ?>"><?php echo JText::_( 'RSFP_MAILCHIMP_SECURE' ); ?></span></label></td>
					<td><?php echo $lists['mailchimpsecure']; ?></td>
				</tr>
			</table>
		</div>
		<?php
	}
	
	function _getFields($formId)
	{		
		$db = JFactory::getDBO();
		
		$db->setQuery("SELECT p.PropertyValue FROM #__rsform_components c LEFT JOIN #__rsform_properties p ON (c.ComponentId=p.ComponentId) WHERE c.FormId='".(int) $formId."' AND p.PropertyName='NAME' ORDER BY c.Order");
		$fields = $db->loadResultArray();
		
		array_unshift($fields, '- IGNORE -');
		
		return $fields;
	}
	
	function _escapeCommas(&$item)
	{
		$item = str_replace(',', '\,', $item);
	}
	
	function rsfp_bk_onSwitchTasks()
	{
		$plugin_task = JRequest::getVar('plugin_task');
		switch ($plugin_task)
		{
			case 'get_merge_vars':
				require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rsform'.DS.'helpers'.DS.'mcapi.php');
				$mailchimp = new RSFP_MCAPI();
				$results = $mailchimp->listMergeVars(JRequest::getVar('list_id'));
				if (is_array($results))
					foreach ($results as $i => $result)
					{
						echo $result['tag']."\n";
						echo $result['name'];
						
						if ($i < count($results) - 1)
							echo "\n";
					}
				jexit();
			break;
			
			case 'get_interest_groups':
				require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rsform'.DS.'helpers'.DS.'mcapi.php');
				$mailchimp = new RSFP_MCAPI();
				$results = $mailchimp->listInterestGroupings(JRequest::getVar('list_id'));
				if (is_array($results))
					foreach ($results as $i => $result)
					{
						$groups = array();
						echo $result['name']."\n";
						foreach ($result['groups'] as $group)
							$groups[] = $group['name'];
						echo implode(', ', $groups);
						
						if ($i < count($results) - 1)
							echo "\n";
					}
				jexit();
			break;
		}
	}
}