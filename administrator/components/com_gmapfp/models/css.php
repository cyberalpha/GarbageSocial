<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.0.beat1
	* Creation date: Mai 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class GMapFPsModelCss extends JModel
{

	/**
	 * Method to store configuration
	 * @return boolean value
	 */
	 
	function store()
	{	

		$file 			= JPATH_COMPONENT_SITE.DS.'views/gmapfp'.DS.'gmapfp.css';
		$csscontent	 	= JRequest::getVar('csscontent', '', 'post', 'string', JREQUEST_ALLOWRAW);

		if( $fp = @fopen( $file, 'w' )) {
			fputs( $fp, stripslashes( $csscontent ) );
			fclose( $fp );
			return true;
		}else{
			return false;
		}

	}


}
?>