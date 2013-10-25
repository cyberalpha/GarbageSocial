<?php
// No direct access
defined('_JEXEC') or die;
jimport('joomla.application.component.view');
require_once(JPATH_COMPONENT.DS.'models'.DS.'favicon.php');
class FaviconViewFavicons extends JView
 {
    public $mediapath;
    public $iconpath;
    public $favicons;
    public $iconmodel;
    public $model;
    public $plugin = false;
    public $default;
    public $assignments;
    public function display($tpl = null) {
        JHtml::_('behavior.modal');
        $this->mediapath = 'media'.DS.'com_favicon'.DS;
        $this->iconpath = JPATH_ROOT.DS.$this->mediapath.'icons';
        $this->favicons = JFolder::folders($this->iconpath);
        $this->iconmodel = new FaviconModelFavicon;
        $this->model = $this->getModel();
        $this->getPluginInfo();
        $this->addToolbar();
        parent::display($tpl);
    }
    protected function addToolbar()
    {
        JToolBarHelper::title(JText::_('COM_FAVICON').' - '.JText::_('COM_FAVICON_FAVICONS'), 'favicon');
        JToolBarHelper::custom('favicon.create', 'new.png', 'new_f2.png', 'COM_FAVICON_CREATE', false);
    }
    protected function getPluginInfo() {
        $plugin = $this->model->plugin;
        if(!is_null($plugin)) {
            $this->plugin = $plugin->extension_id;
            $params = json_decode($plugin->params);
            if(is_object($params)) {
                if(property_exists($params,'default') && strlen($params->default)) {
                    $this->default = $params->default;
                }
                if(property_exists($params,'assignments') && count($params->assignments)) {
                    $this->assignments = $params->assignments;
                }
            }
        }
        return;
    }
}