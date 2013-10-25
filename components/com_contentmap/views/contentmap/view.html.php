<?php defined("_JEXEC") or die("Restricted access");

jimport("joomla.application.component.view");

class ContentMapViewContentMap extends JView
{
	function display($tpl = null)
	{
		$this->msg = "ContentMap component is still under development";
		parent::display($tpl);
	}
}
