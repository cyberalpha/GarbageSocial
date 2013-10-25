<?php defined("_JEXEC") or die("Restricted access");

jimport("joomla.application.component.view");

class ContentMapViewSmartLoader extends JView
{
	function display($tpl = null)
	{
		//		parent::display($tpl);

		// Load module || component || plugin parameters. Defaults to plugin
		$owner = JRequest::getVar("owner", "", "GET") or $owner = "plugin"; // getVar() default value doesn't work with ?owner=""

		$db = JFactory::getDbo();
		jimport("joomla.database.databasequery");
		$query = $db->getQuery(true);
		$this->$owner($query);
		$db->setQuery($query);

		// Load parameters from database
		$json = $db->loadResult();
		// Convert to JRegistry
		$params = new JRegistry($json);
		// $params = $params->toArray();

		// Import appropriate library
		jimport("contentmap.smartloader.smartloader") or die("smartloader library not found");
		// Type could be css, js or markers
		$type = JRequest::getVar("type", "", "GET");
		// Instantiate the loader
		$classname = $type . "SmartLoader";
		$loader = new $classname();
		$loader->Params = &$params;
		$loader->Show();
	}


	private function module(&$query)
	{
		$query->select('`params`');
		$query->from('`#__modules`');
		$query->where("`id` = " . intval(JRequest::getVar("id", 0, "GET")));
		$query->where("`module` = 'mod_contentmap'");
	}


	private function plugin(&$query)
	{
		$query->select("`params`");
		$query->from("`#__extensions`");
		$query->where("`element` = 'contentmap'");
		$query->where("`client_id` = 0");
		$query->where("`type` = 'plugin'");
	}


	private function component(&$query)
	{
	}


	private function article(&$query)
	{
		$query->select('`metadata`');
		$query->from('`#__content`');
		$query->where("`id` = " . intval(JRequest::getVar("id", 0, "GET")));
	}

}
