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
class JFormFieldPattern extends JFormField
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	protected $type = 'Pattern';

	function getInput()
	{
		$uri = str_replace(DS,"/",str_replace( JPATH_SITE, JURI::base(), dirname(__FILE__)));
		$uri = str_replace("/administrator/", "", $uri);
				
		if(!defined('ZT_PATTERN'))
		{
			define('ZT_PATTERN', 1);
			$document 	= &JFactory::getDocument();			
			$db			= &JFactory::getDBO();
			$id			= JRequest::getInt('id');			
			
			$document->addStyleSheet($uri . '/assets/css/pattern.css');
			$document->addScript($uri . '/assets/js/pattern.js');
			
			$query = "SELECT template FROM #__template_styles WHERE `id` = $id";
			$db->setQuery($query);
			$template = $db->loadResult();
			
			$css = str_replace("/administrator", '', JURI::base()).'templates/'.$template.'/css/patterns.css';
			$document->addStyleSheet($css);
		}
		
		$name  = str_replace("[", "", $this->name);
		$name  = str_replace("]", "", $name);
		
		$html  = '<div style="float:left;">';
		$html .= '<div class="pattern-active '.$this->value.'" id="'.$name.'_select"></div>';
		$html .= '<div id="'.$name.'_popup" class="pattern-popup">';
		$options = (array)$this->getOptions();		
		foreach($options as $option)
		{
			$val   = $option->value;
			$html .= '<div class="lady_item '.$val.'"></div>';
		}
		$html .= '</div>';
		$html .= '</div>';
		$html .= '<input type="hidden" id="'.$name.'" name="'.$this->name.'" value="'.$this->value.'" />';
		$html .= '<script type="text/javascript" language="javascript">
					window.addEvent("load", function(){     
						new LadyPopup(\''.$name.'_select\', {
							id: \''.$name.'_popup\',
							position:\''.$name.'\'
						});
					});
					</script>';
		
		return $html;
	}
	
	
	protected function getOptions()
	{
		$options = array();

		foreach($this->element->children() as $option)
		{
			if($option->getName() != 'option')
			{
				continue;
			}

			$tmp = JHtml::_('select.option', (string) $option['value'], JText::alt(trim((string) $option), preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)), 'value', 'text', ((string) $option['disabled']=='true'));

			$tmp->class = (string) $option['class'];
			$tmp->onclick = (string) $option['onclick'];
			$options[] = $tmp;
		}
		reset($options);
		return $options;
	}
}