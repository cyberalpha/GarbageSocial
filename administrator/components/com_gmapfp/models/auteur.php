<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.0.beat1
	* Creation date: Mai 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );


class GMapFPsModelAuteur extends JModel
{

	function __construct()
	{
		parent::__construct();

		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 
		$controller = JRequest::getWord('controller');

	}

	function getCid()
	{
		$cid = JRequest::getVar('cid',  0, '', 'array');
		$where 		= ( count( $cid ) ? ' WHERE id='. implode( ' OR id=', $cid ) : '' );

		//die(print_r($where));
		$query = 'SELECT id, nom, userid'
			. ' FROM #__gmapfp'
			. $where
			. ' ORDER BY nom';
		return $this->_getList( $query );
	}
	
	/**
	 * Method to store a record
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function store()
	{
		$data = JRequest::get( 'post' );
		$id = explode(',',@$data[cid]);
		$id = implode (' OR id =',$id);
        $db = JFactory::getDBO();
		$query = ' UPDATE #__gmapfp'
			. ' SET userid='.@$data[users][0]
			. ' WHERE id ='.$id;
         $db->setQuery($query);
		 $db->query();

		return true;
	}

	function getListeUsers()
	{
		$query = 'SELECT id, name'
			. ' FROM #__users'
			. ' WHERE block = 0'
			. ' ORDER BY name';
		return $this->_getList( $query );
	}
}
