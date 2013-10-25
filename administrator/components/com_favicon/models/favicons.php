<?php
/**
 * @copyright	Copyright (C) 2010 Michael Richey. All rights reserved.
 * @license		GNU General Public License version 3; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.model');
jimport('joomla.filesystem.file');

class FaviconModelFavicons extends JModel {
    public $plugin;
    public function __construct($config = array()) {
        $this->plugin = self::getPluginInfo();
        parent::__construct($config);
    }

    public function getPluginInfo() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('extension_id,params')->from('#__extensions')->where('name = "plg_system_favicon"')->where('enabled = 1');
        $db->setQuery($query);
        return $db->loadObject();
    }

    public function setPluginInfo($id,$params=array()) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update('#__extensions')->set("params = '".json_encode((object)$params)."'")->where('extension_id = '.$id);
        $db->setQuery($query);
        return $db->query();
    }
    public function setdefault($id) {
        $plugin = $this->getPluginInfo();
        $params = json_decode($plugin->params, true);
        if(!is_array($params)) $params=array();
        $params = $this->setDefaultParam($params,$id);
        if (isset($params['assignments']) && isset($params['assignments'][$id])) {
            $params = $this->removeAssignmentParams($params,$id);
        }
        return $this->setPluginInfo($plugin->extension_id, $params);
    }
    public function setDefaultParam($params,$id) {
        $params['default']=$id;
        return $params;
    }
    public function removeAssignmentParams($params,$id) {
        if(array_key_exists($id,$params['assignments'])) unset($params['assignments'][$id]);
        return $params;
    }
    public function deleteIcon($id){
        $plugin = $this->getPluginInfo();
        $params = json_decode($plugin->params, true);
        $params = $this->removeAssignmentParams($params, $id);
        if($params['default']==$id) unset($params['default']);
        $this->setPluginInfo($plugin->extension_id, $params);
        $path = JPATH_ROOT.DS.'media'.DS.'com_favicon'.DS.'icons'.DS.$id;
        if(JFolder::exists($path)) {
            return (JFolder::delete($path));
        } else {
            return false;
        }
    }
}