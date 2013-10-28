<?php
/*
# ------------------------------------------------------------------------
# ZTTools plugin for Joomla 2.5.0
# ------------------------------------------------------------------------
# Copyright(C) 2008-2012 www.zootemplate.com. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: ZooTemplate
# Websites: http://www.zootemplate.com
# ------------------------------------------------------------------------
*/


// Ensure this file is being included by a parent file
defined('_JEXEC') or die( 'Restricted access');

/**
 * Radio List Element
 *
 * @since      Class available since Release 1.2.0
 */
class JFormFieldModules extends JFormField
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	protected $type = 'Modules';

	function getInput()
	{
		if(!defined('ZT_PARAM_HELPER'))
		{
			define('ZT_PARAM_HELPER', 1);
			$uri = str_replace(DS,"/",str_replace( JPATH_SITE, JURI::base(), dirname(__FILE__)));
			$uri = str_replace("/administrator/", "", $uri);
			JHTML::_('behavior.mootools');
			JHTML::script($uri.'/assets/js/ztparamhelper.js');
			?>
			<script type="text/javascript">
				window.addEvent( "load", function(){
					var obj = null;
					var options = document.adminForm.elements['jform[params][mega_subcontent]'];
					for(var i=0; i<options.length; i++){
						options[i].addEvent("click", function(){
							updateFormMenu(this, true);
						});
						if(options[i].checked){
							obj = options[i];
						}
					}
					updateFormMenu(obj, false);
				});		
			</script>
	<?php	
		}
		$db 	=& JFactory::getDBO();
		$query 	= "SELECT e.extension_id, a.id, a.title, a.note, a.position, a.module, a.language,a.checked_out, a.checked_out_time, a.published, a.access, a.ordering, a.publish_up, a.publish_down,l.title AS language_title,uc.name AS editor,ag.title AS access_level,MIN(mm.menuid) AS pages,e.name AS name
					FROM `#__modules` AS a
					LEFT JOIN `#__languages` AS l ON l.lang_code = a.language
					LEFT JOIN #__users AS uc ON uc.id=a.checked_out
					LEFT JOIN #__viewlevels AS ag ON ag.id = a.access
					LEFT JOIN #__modules_menu AS mm ON mm.moduleid = a.id
					LEFT JOIN #__extensions AS e ON e.element = a.module
					WHERE(a.published IN(0, 1)) AND a.client_id = 0
					GROUP BY a.id";
		$db->setQuery($query);
		$groups = $db->loadObjectList();
		
		$groupHTML = array();	
		if($groups && count($groups))
		{
			foreach($groups as $v=>$t)
			{
				$groupHTML[] = JHTML::_('select.option', $t->id, $t->title);
			}
		}
		$lists = JHTML::_('select.genericlist', $groupHTML, "{$this->name}[]", ' multiple="multiple"  size="10" ', 'value', 'text', $this->value);
		return $lists;
	}
} 