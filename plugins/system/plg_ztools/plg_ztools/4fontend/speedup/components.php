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
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

/**
 * Radio List Element
 *
 * @since      Class available since Release 1.2.0
 */
class JFormFieldComponents extends JFormField
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	protected $type 	= 'Components';
	protected $_options = array();
	protected $_type;

	function getInput()
	{		
		$path 		= JPATH_ROOT.DS.'components';		
		$rows 		= $this->loadAllFolder($path);
		$groupHTML  = array();
		
		if(count($rows))
		for($i = 0; $i < count($rows); $i++)
		{
			$id 	= $rows[$i]['id'];
			$parent = $rows[$i]['parent'];
			$dname	= $rows[$i]['name'];
			$view	= $rows[$i]['fullname'].DS.'views';
			
			if(!$parent)
			{								
				$groupHTML[] = JHTML::_('select.option', $dname, $dname);
				
				if(is_dir($view))
				{
					$views = $this->loadAllFolder($view);
					if(count($views))
					{
						for($k = 0; $k < count($views); $k++)
						{
							$parent = $views[$k]['parent'];
							$dname	= $views[$k]['name'];
							if(!$parent)
							{								
								$groupHTML[] = JHTML::_('select.option', $rows[$i]['name'].'.'.$dname, "|---- " . $dname);
							}
						}
					}
				}
			}
		}
		
		$lists = JHTML::_('select.genericlist', $groupHTML, "{$this->name}[]", ' multiple="multiple"  size="10" ', 'value', 'text', $this->value);
		return $lists;
	}
	
	function loadAllFolder($path)
	{
		$folders = JFolder::listFolderTree($path, '');
		return $folders;
	}
}
?>