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
class JFormFieldExlFiles extends JFormField
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	protected $type 	= 'ExlFiles';
	protected $_options = array();
	protected $_type;

	function getInput()
	{		
		$options = array();
		
		if(strpos($this->name, "css") === false) $this->_type = "js";
		else $this->_type = "css";
		
		$str = '<br clear="all"/>
				<table width="100%" height="100px">
					<tr>
						<td width="143px" align="center" valign="top">[ <a href="" onclick="reload'.$this->_type.'(); return false;">Reload list</a> ]</td>
						<td>
							<div id="list-'.$this->_type.'" style="height:100px;">
								<table>
									<tr>
										<td>Loading '.$this->_type.' files...</td>
										<td><img src="'.JURI::root().'plugins/system/plg_ztools/plg_ztools/4backend/menu/element/assets/images/loading.gif"/></td>
									</tr>
								</table>
							</div>	
						</td>
					</tr>
				</table>				
				<script language="javascript">
				window.addEvent("domready",function(){					
					var url = "'.JURI::root().'plugins/system/plg_ztools/plg_ztools/4backend/menu/element/getdata.php?type='.$this->_type.'&path='.str_replace(DS, "/", JPATH_ROOT).'&name='.$this->name.'&value='.implode(",", (array)$this->value).'";
					
					var myRequest = new Request({url: url, method: "GET", 
						onSuccess: function(responseText, responseXML){$("list-'.$this->_type.'").set("html", responseText);}
					}).send();
				});
				
				function reload'.$this->_type.'(){
					$("list-'.$this->_type.'").set("html", "<table><tr><td>Loading '.$this->_type.' files...</td><td><img src=\"'.JURI::root().'plugins/system/plg_ztools/plg_ztools/4backend/menu/element/assets/images/loading.gif\"/></td></tr></table>");
					var url = "'.JURI::root().'plugins/system/plg_ztools/plg_ztools/4backend/menu/element/getdata.php?type='.$this->_type.'&path='.str_replace(DS, "/", JPATH_ROOT).'&name='.$this->name.'&value='.implode(",", (array)$this->value).'&reload=true";
					
					var myRequest = new Request({url: url, method: "GET", 
						onSuccess: function(responseText, responseXML){$("list-'.$this->_type.'").set("html", responseText);}
					}).send();
				}
				</script>';
		return $str;
	}
}