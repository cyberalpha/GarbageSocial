<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.11
	* Creation date: Mars 2012
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

class GMapFPHelper
{

	public static function addSubmenu($vName = 'accueil')
	{
		JSubMenuHelper::addEntry(
			JText::_('GMAPFP_ACCUEIL'),
			'index.php?option=com_gmapfp&controller=accueil&task=view',
			$vName == 'accueil'
		);

		JSubMenuHelper::addEntry(
			JText::_('GMAPFP_LIEUX'),
			'index.php?option=com_gmapfp&controller=gmapfp&task=view',
			$vName == 'gmapfp'
		);

		JSubMenuHelper::addEntry(
			JText::_('GMAPFP_MARQUEURS'),
			'index.php?option=com_gmapfp&controller=marqueurs&task=view',
			$vName == 'marqueurs'
		);

		JSubMenuHelper::addEntry(
			JText::_('JCATEGORIES'),
			'index.php?option=com_categories&extension=com_gmapfp',
			$vName == 'categories'
		);
		if ($vName=='categories') {
			JToolBarHelper::title(
				JText::sprintf('COM_CATEGORIES_CATEGORIES_TITLE',JText::_('COM_GMAPFP')),
				'gmapfp-categories');
		}

		JSubMenuHelper::addEntry(
			JText::_('GMAPFP_PERSONNALISATION'),
			'index.php?option=com_gmapfp&controller=personnalisations&task=view',
			$vName == 'personnalisations'
		);

		JSubMenuHelper::addEntry(
			JText::_('CSS'),
			'index.php?option=com_gmapfp&controller=css&task=view',
			$vName == 'css'
		);
	}

	public static function getActions($categoryId = 0)
	{
		die(print_r('administrator\components\com_gmapfp\helpers\gmapfps.php getActions'));
		$user	= JFactory::getUser();
		$result	= new JObject;

		if (empty($categoryId)) {
			$assetName = 'com_gmapfp';
		} else {
			$assetName = 'com_gmapfp.category.'.(int) $categoryId;
		}

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}
}
