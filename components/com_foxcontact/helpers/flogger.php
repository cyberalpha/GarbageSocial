<?php defined('_JEXEC') or die('Restricted access');
/*
This file is part of "Fox Joomla Extensions".

You can redistribute it and/or modify it under the terms of the GNU General Public License
GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html

Author: Demis Palma
Documentation at http://www.fox.ra.it/forum/2-documentation.html
*/

class FLogger
   {
   protected $Handle = NULL;
   protected $Prefix = "";
   
   public function __construct($prefix = NULL, $suffix = NULL)
      {
		$this->open($suffix);		
		if ($prefix) $this->Prefix = "[" . $prefix . "] ";
      }

      
   function __destruct()
      {
      if ($this->Handle) fclose($this->Handle);
      }
      
      
   public function Write($buffer)
      {
      if (!$this->Handle) return false;
		// Go to the end of file if another instance has write something else
		fseek($this->Handle, 0, SEEK_END);
      $now = JFactory::getDate();
      return fwrite($this->Handle, $now->toFormat() . " " . $this->Prefix . $buffer . PHP_EOL);
      }

	protected function open($suffix = NULL)
		{
		// Can't use global $app here, because file-uploader.php doesn'd belong to the main thread
		$application = JFactory::getApplication();
		if (!$suffix) $suffix = md5($application->getCfg("secret"));
		$this->Handle = @fopen($application->getCfg("log_path") . DS . substr(basename(realpath(dirname(__FILE__) . DS . '..')), 4) . "-" . $suffix . ".txt", 'a+');
		}       
   }
   
   
class FDebugLogger extends FLogger
	{
	public function __construct($prefix = NULL)
		{
		$jsession = JFactory::getSession();
		$debug = $jsession->get("debug");                
		if ($debug) $this->open("debug");
		$this->Prefix = "[" . $prefix . "] ";
		}
	}

?>
