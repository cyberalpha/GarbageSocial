<?php defined('_JEXEC') or die('Restricted access');

abstract class GoogleMapMarkers
{
	public $Contents;

	abstract protected function Load();

	public function __construct()
	{
		$this->Load();
	}


	public function asArray()
	{
		return $this->Contents;
	}


	public function asJSON()
	{
		return json_encode($this->Contents);
	}


	public function Count()
	{
		return count($this->Contents);
	}


	public function __toString()
	{
		// Prepare some useful headers
		header("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		// must not be cached by the client browser or any proxy
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('content-type: application/json');

		return
			"var data_" . $_GET["owner"] . "_" . $_GET["id"] . "={\n" .
			'"places":' . $this->asJSON() . "\n}";
	}
}
