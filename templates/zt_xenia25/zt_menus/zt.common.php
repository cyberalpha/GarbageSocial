<?php
/**
* @version 1.5.x
* @package ZooTemplate Project
* @email webmaster@zootemplate.com
* @copyright(c) 2008 - 2011 http://www.ZooTemplate.com. All rights reserved.
*/
// No direct access 
defined('_JEXEC') or die();
/**
 * Class Menu Common
 *
 */
require_once(JPATH_BASE .DS.'libraries/joomla/html/parameter.php');

class MenuSystem
{
	var $_name 		= null;
	var $_template 	= null;
	var $_start 	= null;
	var $_end 		= null;
	var $_suffix 	= null;
	var $_active 	= null;
	var $_type 		= null;
	var $_cache 	= null;
	var $_nav 		= null;
	var $Itemid 	= null;
	var $fancy		= null;
	var $mega		= null;
	var $moo		= null;
	var $drill		= null;
	
	/**
	 * Enter description here...
	 *
	 * @param string $name
	 * @param string $menutype
	 * @param string $template_name
	 * @param string $suffix
	 * @return MenuSystem
	 */
	 
	function MenuSystem($name, $menutype, $template_name, $rtl, $fancy = 0, 
	$transition = 'Fx.Transitions.linear', $duration = '350', 
	$xdelay = 350, $xduration = 350, $xtransition = 'Fx.Transitions.linear')
	{
		global $Itemid;
		$Itemid				= JRequest::getVar('Itemid');
		$this->_name 		= $name;
		$this->_template 	= $template_name;
		$this->_suffix 		= "";
		$this->_type 		= $menutype;
		$this->Itemid 		= $Itemid;
		$document 			= JFactory::getDocument();
		$this->mega			= '<script>window.addEvent("domready", function(){var megas = $(document.body).getElements(\'div[class="menusub_mega"]\');megas.each(function(mega, i){var id = mega.getProperty("id").split("_");if(id[2] != null){var smart = "_" + id[1] + "_" + id[2];ZTMenu('.$xdelay.', 0, 0, smart, "megamenu_close", true, '.$xduration.', '.$xtransition.');}});});</script>';
		$this->moo			= '<script>window.addEvent("domready",function() {new MooMenu($("menusys_moo"), {transition: '.$xtransition.', duration: '.$xduration.'})});</script>';
		$this->drill		= '<script type="text/javascript">var mymenu=new drilldownmenu({menuid: "drillmenu1", base: "'.JURI::base().'", menuheight: "auto", breadcrumbid: "drillcrumb", persist: {enable: true, overrideselectedul: true}, base: "'.JURI::base().'templates/'.$this->_template.'/zt_menus/'.'"})</script>';
		
		if($this->_name == 'mega') {
			if(!class_exists('plgSystemPlg_ZTools')) {
				echo JText::_('Debe activar el plugin ZT Tools desde el Gestor de Plugins - Missing ZTTools plugin.');
				die();
			}
		}		
		
		$document->addStyleSheet(JURI::base().'templates/'.$this->_template.'/zt_menus/'.'zt_'.$this->_name.'menu/'.'zt.'.$this->_name.'menu.css');
		
		if($rtl == 'rtl') {
			$document->addScript(JURI::base().'templates/'.$this->_template.'/zt_menus/'.'zt_'.$this->_name.'menu/'.'zt.'.$this->_name.'menu.rtl.js');
		} else {
			$document->addScript(JURI::base().'templates/'.$this->_template.'/zt_menus/'.'zt_'.$this->_name.'menu/'.'zt.'.$this->_name.'menu.js');
		}
				
		if($fancy) {
			$document->addScript(JURI::base().'templates/'.$this->_template.'/zt_menus/zt_fancymenu/zt_fancymenu.js');
			$document->addStyleSheet(JURI::base().'templates/'.$this->_template.'/zt_menus/zt_fancymenu/zt_fancymenu.css');
			$this->fancy = '<script>window.addEvent("load", function(){new ZTFancy(document.getElement("ul", "fancymenu"), {transition: '.$transition.', duration: '.$duration.', onClick: function(ev, item){ev.stop();}});});</script>';
		}
		
		$this->genmenu();
	}
	
	function hasChild($lvl)
	{
		$pid = $this->fatherId($lvl);
		if(!$pid) return false;
		if(@$this->_nav[$pid]) return true;
		else return false;
	}
	
	function _showMenuDetail($row, $level = 0)
	{
		$_temp 			= null;
		$title 			= "title=\"$row->title\""; 
		$menu_params 	= new JParameter($row->params);

		if($menu_params->get('menu_image') && $menu_params->get('menu_image') != -1)
		{
			$str = '<img src="'.JURI::base(true).'/'.$menu_params->get('menu_image').'" alt="'.$row->title.'" /><span class="menusys_name">'.$row->title.'</span>';
		}
		else
		{
			$str = '<span class="menusys_name">'.$row->title.'</span>';
		}
		
		$Class 	= $this->activeClass($row, $level);
		$id		='id="menusys'.$row->id.'"';            
		
		if(@$row->url != null)
		{
			if($row->browserNav == 0)
			{
				$menuItem = '<a href="'.$row->url.'" '.$Class.' '.$id.' '.$title.'>'.$str.'</a>';
			}
			elseif($row->browserNav == 1)
			{
				$menuItem = '<a target="_blank" href="'.$row->url.'" '.$Class.' '.$id.' '.$title.'>'.$str.'</a>';
			}
			elseif($row->browserNav == 2)
			{
				$url 		= str_replace('index.php', 'index2.php', $tmp->url);   
				$atts 		= 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=500,height=350';
				$menuItem 	= '<a href="'.$url.'" onclick="window.open("'.$url.'",\'targetWindow\',\''.$atts.'\'); return false;" '.$Class.' '.$id.' '.$title.'>'.$str.'</a>';
			}
		}
		else
		{
			$menuItem = '<a '.$id.' '.$title.'>'.$str.'</a>';
		}
		echo $menuItem;
	}
	
	function show($per=0, $start=0, $end = 14)
	{
		$this->_per = $per;
		$this->_start = $start;
		$this->_end   = $end;
		echo "<div class=\"menusys_".$this->_name.$this->_suffix."\">";
		
		if($this->_start == 0)
		{
			switch($this->_name)
			{
				case "mega":
					$this->showMegaMenu($this->_per, 1, 0);
					$this->endMenu($this->mega);
					$this->endMenu($this->fancy);
				break;
				case "drill":
					$this->showDrillMenu(1, 0);
					$this->endMenu($this->drill);
				break;
				default:
					$this->showMenu(1, 0);
					$this->endMenu($this->moo);
					$this->endMenu($this->fancy);
				break;
			}
		}
		else
		{
			$parID = $this->fatherId($this->_start);
			
			switch($this->_name)
			{
				case "mega":
					$this->showMegaMenu($this->_per, $parID, $this->_start);
					$this->endMenu($this->mega);
					$this->endMenu($this->fancy);
				break;
				case "drill":
					$this->showDrillMenu($parID, $this->_start);
					$this->endMenu($this->drill);
				break;
				default:
					$this->showMenu($parID, $this->_start);
					$this->endMenu($this->moo);
					$this->endMenu($this->fancy);
				break;
			}
		}
		
		echo "</div>";
	}
	
	function showMenu($pid, $level)
	{
		if(@$this->_nav[$pid])
		{		
			if($level == 0)
				$this->beginUl(NULL, "menusys_".$this->_name);
			elseif($level == 1 &&($this->_name == 'submoo' || $this->_name == 'split'))
				$this->beginUl(NULL, "menusub_".$this->_name);
			else
				$this->beginUl();
				
			$i = 0;
			foreach($this->_nav[$pid] as $menu)
			{
				if(@$this->_nav[$menu->id]) $abc = " hasChild";
				else $abc = "";
				
				$class  =($this->isActive($menu)) ? " active" : "";
				$id		=(@$this->_nav[$menu->id]) ? "menu-".$menu->id : '';
				
				if($i == 0) $this->beginLi("first-item".$abc.$class, $id);
				elseif($i == count($this->_nav[$pid]) - 1) $this->beginLi("last-item".$abc, $id);
				else $this->beginLi($abc, $id);
				
				$this->_showMenuDetail($menu, $level);
				
				if(($level < $this->_end) &&(@$this->_nav[$menu->id]))
				{
					$this->showMenu($menu->id, $level+1);
				}
				$i++;
				$this->endLi();
			}
			$this->endUl();
		}
	}
	
	function activeClass($menu_item, $level)
	{
		return(in_array($menu_item->id, $this->_active)) ? " class=' active'" : " class=' item'";
	}
	
	//~~ This function will found the father ID of and item marked by level in array of active items ~~~~~~~
	function fatherId($lvl)
	{
		if(!$lvl) return 0;
		//echo "<pre>";print_r($this->_active);exit;
		if(count($this->_active) < $lvl) return 0;
		$parID = count($this->_active) - $lvl;
		return $this->_active[$parID];
	}
	
	/**
	 * Generate the menu
	 *
	 * @return mixed
	 */
	 
	function genmenu()
	{
		$nav          = @JMenu::getInstance();
		$my           = JFactory::getUser();
		$nav          = array();		 
		$this->_cache = array();
		
		if(@strtolower(get_class($menu)) == 'jexception')
		{
			$nav 		= @JMenu::getInstance('site');
		}
		$menus 	= &JSite::getMenu();
		$rows 	= $menus->getItems('menutype', $this->_type);
		$_tmp 	= array();
		
		if(count($rows))
		{
		   foreach($rows as $key => $value)
		   {
				if($value->access <= $my->get('gid', 1))
				{
					$par 		= $value->parent_id;
					$list_menu 	= @($nav[$par]) ? $nav[$par] : array();
					
					if($value->type == 'separator')
					{
						$value->_index 	= count($list_menu);
						$list_menu[] 	= $value;
						$nav[$par] 		= $list_menu;
						
						$this->_cache[$value->id] 	= $value;
						$_tmp[$value->id] 			= $key;
						
						continue;
					}
					elseif($value->type == 'url')
					{
						if((strpos($value->link, 'index.php?') !== false) &&(strpos($value->link, 'Itemid=') === false))
						{
							$value->url = $value->link.'&amp;Itemid='.$value->id;
						}
						else
						{
							$value->url = $value->link;
						}						
					}
					elseif($value->type == 'url')
					{
						$value->url = 'index.php?Itemid='.$value->params->get('aliasoptions');
					}
					else
					{
						$router = JSite::getRouter();
						if($router->getMode() == JROUTER_MODE_SEF)
						{
							//~~ No JRoute now ~~~
							$value->url = 'index.php?Itemid='.$value->id;
						}
						else
						{
							//~~ No JRoute now ~~~
							$value->url = $value->link.'&amp;Itemid='.$value->id;   
						}
					}
										
					if(strcasecmp(substr($value->url, 0, 4), 'http') &&(strpos($value->url, 'index.php?') !== false))
					{
						$value->url = JRoute::_($value->url, true, $value->params->get('secure'));
					}
					else
					{
						$value->url = JRoute::_($value->url);
					}
					
					$value->_index 	= count($list_menu);
					$list_menu[] 	= $value;
					$nav[$par] 		= $list_menu;
				}
				$this->_cache[$value->id] = $value;
				$_tmp[$value->id] = $key;
			}
		}
		
		$this->_nav = $nav;
		//~~ Find out what submenus this item has ~~~~~~~~~~~
		$active 	= array($this->Itemid);
		$max 		= 14;
		//~~ We dont need more than 14 levels of menu, do we? ~~~
		$id 		= $this->Itemid;
		
		while($max)
		{
			if(isset($_tmp[$id]))
			{
				$tmp = $_tmp[$id];
				if(isset($rows[$tmp]) && $rows[$tmp]->parent_id > 1)
				{
					$id = $rows[$tmp]->parent_id;
					$active[] = $id;
				}
				else
				{
					break;
				}
			}
			$max--;
		}
		$this->_active = $active;
	}
	
	/**
		Package: Mega Menu Function
		Created: December 04, 2010
	*/
	
	function showMegaMenu($per, $pid, $level)
	{
		if(@$this->_nav[$pid])
		{
			$this->beginUl( NULL, "menusys_".$this->_name);
			$i = 0;
			foreach($this->_nav[$pid] as $menu) 
			{
				$params	= $menu->params;
				$aclass	= $this->getMegaMenuParam($params, "mega_class", '');
				$cols	= $this->getMegaMenuParam($params, "mega_cols", 1);
				
				if(@$this->_nav[$menu->id]){$class = "hasChild"; $id = "menu-".$menu->id;}
				else {$class = ""; $id = "";}
					
				if($i == 0) $class = "first-item $class";
				elseif($i == count($this->_nav[$pid]) - 1) $class = "last-item $class";
				else $class = $class;
				
				$class .=($this->isActive($menu)) ? " active" : "";
				$class .=($aclass != '') ? $aclass : "";

				if($per && $per<count($this->_nav[$pid])) {
					if($i==0)
						$this->beginDiv("menusys-left", NULL, NULL);
					elseif($i==$per)
						$this->beginDiv("menusys-right", NULL, NULL);
				}
				
				$this->beginLi($class, $id);
					$this->genMegaTypeNormal($menu, $level);
					if(@$this->_nav[$menu->id])
					{
						$this->beginDiv("menusub_mega", "menu-".$menu->id."_menusub_sub0");
							$this->showSubMegaMenu($menu, $menu->id, $level+1, $cols);
						$this->endDiv();
					}
				$this->endLi();

				if($per && $per<count($this->_nav[$pid])) {
					if($i==($per-1))
						$this->endDiv();
					elseif($i==(count($this->_nav[$pid])-1))
						$this->endDiv();
				}

				$i++;
			}
			$this->endUl();
		}
	}
	
	function showSubMegaMenu($row, $pid, $level, $cols)
	{
		$params	= $row->params;
		$swidth = $this->getMegaMenuParam($params, "mega_colw", '');
		$colxw	= $this->getMegaMenuParam($params, "mega_colxw", '');
		$colw 	= array();
		$width  = $this->getMegaMenuParam($params, "mega_width", '');
		$style	=($width != '') ? "width:$width" : "";
		
		if($colxw != '')
		{
			$colx  = explode("\n", $colxw);
			for($i = 0; $i < count($colx); $i++)
			{
				$col 	= explode("=", $colx[$i]);
				$colw[] = $col[1];
			}
		}
			
		
		$subs	= $this->_nav[$pid];
		$total	= count($subs);
		
		$count	= floor($total/$cols);
		$bal	= $total - $count*$cols;
		$m		= 0;

		$isgroup = $this->getMegaMenuParam($params, "mega_group", 0);

		
		if(!$isgroup) {
			if(strpos($width,'px'))
				//$width_wrap = "width:".((str_replace('px','',$width))+34)."px";
				//not add +34
				$width_wrap = "width:".((str_replace('px','',$width)))."px";
			else
				//$width_wrap = "width:".($width+34)."px";
				//not add +34
				$width_wrap = "width:".($width)."px";
		} else {
			if(strpos($width,'px'))
				$width_wrap = "width:".$width;
			else
				$width_wrap = "width:".$width."px";
		}
		
		$this->beginDiv("submenu-wrap", NULL, $width_wrap);

		$isgroup = $this->getMegaMenuParam($params, "mega_group", 0);

		if(!$isgroup) {
			$this->beginDiv("subarrowtop", NULL, NULL);
			$this->endDiv();
			$this->beginDiv("subwraptop", NULL, NULL);
				$this->beginDiv("subwraptop-left", NULL, NULL);
				$this->endDiv();
				$this->beginDiv("subwraptop-right", NULL, NULL);
				$this->endDiv();
			$this->endDiv();

			$this->beginDiv("subwrapcenter-left", NULL, NULL);
			$this->beginDiv("subwrapcenter-right", NULL, NULL);
			$this->beginDiv("subwrapcenter", NULL, "width:".$width);
		}

		for($i = 1; $i <= $cols; $i++)
		{
			$width	=(count($colw) == $cols) ? "width:".$colw[$i-1] :(($swidth !='') ? "width:".$swidth : NULL);			
			$params	= $subs[$m]->params;
			$group	= $this->getMegaMenuParam($params, "mega_group", 0);
			
			if($group)
			{
				for($g = 0; $g < $count; $g++)
				{
					$this->beginDiv("megacol column$i", NULL, $width);
						$this->_showMegaMenuDetail($subs[$m], $level);
						//Show sub level
						$spid	= $subs[$m]->id;
						if(@$this->_nav[$spid])
						{
							$level	= $level + 1;
							$scols	= $this->getMegaMenuParam($subs[$m]->params, "mega_cols", 1);
							$this->showSubMegaMenu($subs[$m], $spid, $level, $scols);
						}
					$this->endDiv();
					$m ++;
				}
			}
			else
			{
				$this->beginDiv("megacol column$i", NULL, $width);
					$this->beginUl("mega-ul ul");
						for($k = 0; $k < $count; $k++)
						{						
							if($k == 0)
								$class	= "mega-li li first-item";
							elseif($k ==($count - 1))
								$class	= "mega-li li last-item";
							else
								$class	= "mega-li li";
							
							$spid	= $subs[$m]->id;
							if(@$this->_nav[$spid]){ $id = "menu-$spid"; $class .= " hasChild"; }
							else{$id = "";}
								
							$this->beginLi($class, $id);
								$this->_showMegaMenuDetail($subs[$m], $level);
								//Show sub level
								if(@$this->_nav[$spid])
								{
									$level	= $level + 1;
									$scols	= $this->getMegaMenuParam($subs[$m]->params, "mega_cols", 1);
									
									$this->beginDiv("menusub_mega", "menu-".$subs[$m]->id."_menusub_sub$level");
										$this->showSubMegaMenu($subs[$m], $spid, $level, $scols);
									$this->endDiv();
								}
							$this->endLi();
							//Balance
							if($m == 0 && $bal !=0)
							for($b = 0; $b < $bal; $b++)
							{
								$m ++;
								$this->beginLi("mega-li li");
									$this->_showMegaMenuDetail($subs[$m], $level);
									//Show sub level
									$spid	= $subs[$m]->id;
									if(@$this->_nav[$spid])
									{
										$level	= $level + 1;
										$scols	= $this->getMegaMenuParam($subs[$m]->params, "mega_cols", 1);
										$this->showSubMegaMenu($subs[$m], $spid, $level, $scols);
									}
								$this->endLi();
							}
							$m ++;
						}
					$this->endUl();
				$this->endDiv();
			}
		}

		if(!$isgroup) {
			$this->endDiv();
			$this->endDiv();
			$this->endDiv();

			$this->beginDiv("subwrapbottom", NULL, NULL);
				$this->beginDiv("subwrapbottom-left", NULL, NULL);
				$this->endDiv();
				$this->beginDiv("subwrapbottom-right", NULL, NULL);
				$this->endDiv();
			$this->endDiv();
		}

		$this->endDiv();
	}
	
	function isActive($row)
	{
		$active	= $this->_active;
		$mid	= $row->id;
		
		return(in_array($mid, $active)) ? true : false;
	}
	
	function getMegaMenuParam($params, $key, $default = 0)
	{
		$params = new JParameter($params);
		$type	= $params->def($key, $default);
		return $type;
	}
	
	function genMegaTypeNormal($row, $level = 0)
	{
		$str	= "";
		$params	= $row->params;
		
		$image	= $this->getMegaMenuParam($params, "menu_image", -1);
		$stitle	= $this->getMegaMenuParam($params, "mega_showtitle", 0);
		$desc	= $this->getMegaMenuParam($params, "mega_desc", '');
		$group	= $this->getMegaMenuParam($params, "mega_group", 0);
		$width	= $this->getMegaMenuParam($params, "mega_width", '');
		$colw	= $this->getMegaMenuParam($params, "mega_colw", '');
		$colxw	= $this->getMegaMenuParam($params, "mega_colxw", '');
		
		$name			= '<span class="menu-title">'.$row->title.'</span>';
		$description	=($desc != '') ? '<span class="menu-desc">'.$desc.'</span>' : "";
		$title			=($stitle) ? " title=\"$row->title\"" : "";
		
		if($image != -1)
		{
			$itembg 	= 'style="background-image:url('.JURI::base(true).'/'.$image.');"';
			$str	   	= "<span class=\"has-image\" $itembg>".$name.$description.'</span>';
		}
		else
		{
			$str		= "<span class=\"no-image\">".$name.$description.'</span>';
		}
		
		$Class 		= $this->activeClass($row, $level);
		$id			= 'id="menusys'.$row->id.'"';
		$add_class	= $this->getMegaMenuParam($params, "mega_class", '');
				
		if(@$row->url != null)
		{
			if($row->browserNav == 0)
			{
				$menuItem = '<a href="'.$row->url.'" '.$Class.' '.$id.' '.$title.'>'.$str.'</a>';
			}
			elseif($row->browserNav == 1)
			{
				$menuItem = '<a target="_blank" href="'.$row->url.'" '.$Class.' '.$id.' '.$title.'>'.$str.'</a>';
			}
			elseif($row->browserNav == 2)
			{
				$url 		= str_replace('index.php', 'index2.php', $tmp->url);   
				$atts 		= 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=500,height=350';
				$menuItem 	= '<a href="'.$url.'" onclick="window.open("'.$url.'",\'targetWindow\',\''.$atts.'\'); return false;" '.$Class.' '.$id.' '.$title.'>'.$str.'</a>';
			}
		}
		else
		{
			$menuItem = '<a '.$id.' '.$title.'>'.$str.'</a>';
		}
		
		if($group)
		{
			$menuItem = '<div class="mega-group'.$add_class.'">'.$menuItem.'</div>';
		}
		
		echo $menuItem;
	}			
	
	function getModule($id=0, $name='')
	{
		$Itemid = $this->Itemid;
		$app	= JFactory::getApplication();
		$user	= JFactory::getUser();
		$groups	= implode(',', $user->authorisedLevels());
		$db		= JFactory::getDbo();

		$query = $db->getQuery(true);
		$query->select('id, title, module, position, content, showtitle, params, mm.menuid');
		$query->from('#__modules AS m');
		$query->join('LEFT','#__modules_menu AS mm ON mm.moduleid = m.id');
		$query->where('m.published = 1');
		$query->where('m.id = '.$id);
		
		$date 	= JFactory::getDate();
		$now 	= $date->toMySQL();
		$nullDate = $db->getNullDate();
		$query->where('(m.publish_up = '.$db->Quote($nullDate).' OR m.publish_up <= '.$db->Quote($now).')');
		$query->where('(m.publish_down = '.$db->Quote($nullDate).' OR m.publish_down >= '.$db->Quote($now).')');

		$clientid =(int) $app->getClientId();

		if(!$user->authorise('core.admin',1))
		{
			$query->where('m.access IN('.$groups.')');
		}
		
		$query->where('m.client_id = '. $clientid);
		
		if(isset($Itemid))
		{
			$query->where('(mm.menuid = '.(int) $Itemid .' OR mm.menuid <= 0)');
		}
		$query->order('position, ordering');

		// Filter by language
		if($app->isSite() && $app->getLanguageFilter())
		{
			$query->where('m.language in(' . $db->Quote(JFactory::getLanguage()->getTag()) . ',' . $db->Quote('*') . ')');
		}

		// Set the query
		$db->setQuery($query);
		$cache 		= JFactory::getCache('com_modules', 'callback');
		$cacheid 	= md5(serialize(array($Itemid, $groups, $clientid, JFactory::getLanguage()->getTag(), $id)));

		$module = $cache->get(array($db, 'loadObject'), null, $cacheid, false);
		
		if(!$module) return null;
		
		$negId	= $Itemid ? -(int)$Itemid : false;
		// The module is excluded if there is an explicit prohibition, or if
		// the Itemid is missing or zero and the module is in exclude mode.
		$negHit	=($negId ===(int) $module->menuid) ||(!$negId &&(int)$module->menuid < 0);

		// Only accept modules without explicit exclusions.
		if(!$negHit)
		{
			//determine if this is a custom module
			$file				= $module->module;
			$custom				= substr($file, 0, 4) == 'mod_' ?  0 : 1;
			$module->user		= $custom;
			// Custom module name is given by the title field, otherwise strip off "com_"
			$module->name		= $custom ? $module->title : substr($file, 4);
			$module->style		= null;
			$module->position	= strtolower($module->position);
			$clean[$module->id]	= $module;
		}
		return $module;
	}
	
	function genMegaTypeMod($row, $level = 0, $mid, $style = 'xhtml')
	{
		$document	= &JFactory::getDocument();
		$renderer	= $document->loadRenderer('module');
		$params		= array('style' => $style);
		$db			= JFactory::getDBO();				
		
		if(count($mid))
		for($i = 0; $i < count($mid); $i++)
		{
			$module	= $this->getModule($mid[$i]);
			$this->beginDiv("mega-module");
				echo $renderer->render($module, $params);
			$this->endDiv();
		}		
	}
	
	function genMegaTypePosition($row, $level = 0, $position, $style = 'xhtml')
	{
		$document	= &JFactory::getDocument();
		$renderer	= $document->loadRenderer('module');
		$params		= array('style' => $style);
		$contents 	= '';
		
		if(count($position))
		for($i = 0; $i < count($position); $i++)
		{
			$modules = JModuleHelper::getModules($position[$i]);
			if(count($modules))
			for($k = 0; $k < count($modules); $k++)
			{
				$this->beginDiv("mega-module");
					echo $renderer->render($modules[$k], $params);
				$this->endDiv();
			}
		}
	}
	
	
	function _showMegaMenuDetail($row, $level = 0)
	{
		$type	= $this->getMegaMenuParam($row->params, 'mega_subcontent', 0);
		
		switch($type)
		{
			case "mod":
				$module		= $this->getMegaMenuParam($row->params, 'mega_subcontent_mod_modules');
				$style		= $this->getMegaMenuParam($row->params, 'mega_module_style', 'xhtml');
				$this->genMegaTypeMod($row, $level, $module, $style);				
			break;
			case "pos":
				$position	= $this->getMegaMenuParam($row->params, 'mega_subcontent_pos_positions');
				$style		= $this->getMegaMenuParam($row->params, 'mega_module_style', 'xhtml');
				$this->genMegaTypePosition($row, $level, $position, $style);				
			break;
			default:
				$this->genMegaTypeNormal($row, $level);
			break;
		}
	}
	
	function showDrillMenu($pid, $level)
	{
		if(@$this->_nav[$pid])
		{
			$this->beginUl();
			
			$i = 0;
			foreach($this->_nav[$pid] as $menu)
			{
				$this->beginLi();
					if(count(@$this->_nav[$menu->id])) $this->echoText('<a href="#" title="Go To Submenu" class="next-link"><span class="next-title">'.$menu->title.'</span></a>');
					$this->_showMenuDetail($menu, $level);
					if($level < $this->_end) $this->showDrillMenu($menu->id, $level+1);
				$this->endLi();
				$i++;
			}
			$this->endUl();
		}
	}
	
	//Begin, End DIV
	function beginDiv($class = NULL, $id = NULL, $style = NULL)
	{
		$class 	=($class) ? ' class="'.$class.'"' : '';
		$id		=($id) ? ' id="'.$id.'"' : '';
		$style	=($style) ? ' style="'.$style.'"' : '';
		
		echo '<div'.$id.$class.$style.'>';
	}

	function endDiv()
	{
		echo "</div>";
	}
	
	//Begin, end UL
	function beginUl($class = NULL, $id = NULL, $style = NULL)
	{
		$class 	=($class) ? ' class="'.$class.'"' : '';
		$id		=($id) ? ' id="'.$id.'"' : '';
		$style	=($style) ? ' style="'.$style.'"' : '';
		
		echo '<ul'.$id.$class.$style.'>';
	}
	function endUl()
	{
		echo "</ul>";
	}
	
	//Begin, end LI
	function beginLi($class = NULL, $id = NULL, $style = NULL)
	{
		$class 	=($class) ? ' class="'.$class.'"' : '';
		$id		=($id) ? ' id="'.$id.'"' : '';
		$style	=($style) ? ' style="'.$style.'"' : '';
		
		echo '<li'.$id.$class.$style.'>';
	}
	function endLi()
	{
		echo "</li>";
	}
	
	//Function end menu
	function endMenu($text)
	{
		echo $text;
	}
	
	//Function echo TEXT
	function echoText($text)
	{
		echo $text;
	}
}
?>