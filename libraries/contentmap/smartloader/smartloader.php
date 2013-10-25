<?php defined('_JEXEC') or die('Restricted access');
/*
This file is part of "Content Map Joomla Extension".
Author: Open Source solutions http://www.opensourcesolutions.es

You can redistribute and/or modify it under the terms of the GNU
General Public License as published by the Free Software Foundation,
either version 2 of the License, or (at your option) any later version.

GNU/GPL license gives you the freedom:
* to use this software for both commercial and non-commercial purposes
* to share, copy, distribute and install this software and charge for it if you wish.

Under the following conditions:
* You must attribute the work to the original author

This software is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this software.  If not, see http://www.gnu.org/licenses/gpl-2.0.html.

@copyright Copyright (C) 2012 Open Source Solutions S.L.U. All rights reserved.
*/

jimport('joomla.log.log');

abstract class SmartLoader
{
	abstract protected function type();
	abstract protected function http_headers();
	abstract protected function content_header();
	abstract protected function content_footer();


	public function Show()
	{
		$this->headers();
		$this->http_headers();
		$this->content_header();
		$this->load();
		$this->content_footer();

		//die();
		JFactory::getApplication()->close();
	}


	private function headers()
	{
		// Prepare some useful headers
		header("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		// must not be cached by the client browser or any proxy
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
	}


	protected function load()
	{
		// Complete the script name with its path
		$filename = JRequest::getVar("filename", "", "GET");
		// Only admit lowercase a-z, underscore and minus. Forbid numbers, symbols, slashes and other stuff.
		// For your security, *don't* touch the following regular expression.
		preg_match('/^[a-z_-]+$/', $filename) or $filename = "invalid";
		$local_name = realpath(dirname(__FILE__) . "/../" . $this->type() . "/" . $filename . ".php");

		require $local_name;
	}

}


class jsSmartLoader extends SmartLoader
{
	protected function type()
	{
		return "js";
	}

	protected function http_headers()
	{
		header('content-type: application/javascript');
	}

	protected function content_header()
	{
		echo "//<![CDATA[\n";
	}

	protected function content_footer()
	{
		echo "\n//]]>";
	}

}


class cssSmartLoader extends SmartLoader
{
	protected function type()
	{
		return "css";
	}

	protected function http_headers()
	{
		header('content-type: text/css');
	}

	protected function content_header()
	{
		echo "/* css generator begin */\n";
	}

	protected function content_footer()
	{
		echo "\n/* css generator end */";
	}
}


class jsonSmartLoader extends SmartLoader
{
	protected function type()
	{
		return "json";
	}

	protected function http_headers()
	{
		header('content-type: application/json');
	}

	protected function content_header()
	{
		echo "var data_" . JRequest::getVar("owner", "", "GET") . "_" . JRequest::getVar("id", 0, "GET") . "={\n";
	}

	protected function content_footer()
	{
		echo "\n}";
	}
}

