<?php
    /*
    * Plugin Search GMapFP for Component Google Map for Joomla! 1.7.x
    * Version J17V1.1
    * Creation date: Février 2012
    * Author: Fabrice4821 - www.gmapfp.org
    * Author email: webmaster@gmapfp.org
    * License GNU/GPL
    */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

require_once JPATH_SITE.'/components/com_gmapfp/router.php';

/**
 * Content Search plugin
 *
 * @package		Joomla.Plugin
 * @subpackage	Search.content
 * @since		1.6
 */
class plgSearchGMapFP extends JPlugin
{
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	/**
	 * @return array An array of search areas
	 */
	function onContentSearchAreas()
	{
		static $areas = array(
			'gmapfps' => 'GMAPFP_LIEUX'
			);
			return $areas;
	}

	/**
	 * Content Search method
	 * The sql must return the following fields that are used in a common display
	 * routine: href, title, section, created, text, browsernav
	 * @param string Target search string
	 * @param string mathcing option, exact|any|all
	 * @param string ordering option, newest|oldest|popular|alpha|category
	 * @param mixed An array if the search it to be restricted to areas, null if search all
	 */
	function onContentSearch($text, $phrase='', $ordering='', $areas=null)
	{
        $db     = JFactory::getDBO();
        $now    = $this->get('requestTime');
        $nullDate = $db->getNullDate();
	
		$app	= JFactory::getApplication();
		$tag = JFactory::getLanguage()->getTag();

		if (is_array($areas)) {
			if (!array_intersect($areas, array_keys($this->onContentSearchAreas()))) {
				return array();
			}
		}
	
		// load plugin params info
		$limit = $this->params->def('search_limit',	50);
	
		$text = trim( $text );
		if ($text == '') {
			return array();
		}
	
		$section = JText::_( 'GMapFP' );

		switch ( $ordering ) {
			case 'alpha':
				$order = 'a.nom ASC';
				break;
	
			case 'category':
				$order = 'b.title ASC, a.nom ASC';
				break;
	
			case 'popular':
			case 'newest':
			case 'oldest':
			default:
				$order = 'a.nom DESC';
		}

		$wheres = array();
		switch ($phrase) {
			case 'exact':
				$text		= $db->Quote( '%'.$db->getEscaped( $text, true ).'%', false );
				$wheres2 	= array();
					$wheres2[] 	= 'a.nom LIKE '.$text;
					$wheres2[] 	= 'a.intro LIKE '.$text;
					$wheres2[] 	= 'a.message LIKE '.$text;
					$wheres2[] 	= 'a.adresse LIKE '.$text;
					$wheres2[] 	= 'a.adresse2 LIKE '.$text;
					$wheres2[] 	= 'a.ville LIKE '.$text;
					$wheres2[] 	= 'a.departement LIKE '.$text;
					$wheres2[] 	= 'a.pay LIKE '.$text;
					$wheres2[] 	= 'a.horaires_prix LIKE '.$text;
					$wheres2[] 	= 'a.tel LIKE '.$text;
					$wheres2[] 	= 'a.tel2 LIKE '.$text;
					$wheres2[] 	= 'a.fax LIKE '.$text;
					$wheres2[] 	= 'b.title LIKE '.$text;
				$where 		= '(' . implode( ') OR (', $wheres2 ) . ')';
				break;
	
			case 'all':
			case 'any':
			default:
				$words = explode( ' ', $text );
				$wheres = array();
				foreach ($words as $word) {
					$word		= $db->Quote( '%'.$db->getEscaped( $word, true ).'%', false );
					$wheres2 	= array();
					$wheres2[] 	= 'a.nom LIKE '.$word;
					$wheres2[] 	= 'a.intro LIKE '.$word;
					$wheres2[] 	= 'a.message LIKE '.$word;
					$wheres2[] 	= 'a.adresse LIKE '.$word;
					$wheres2[] 	= 'a.adresse2 LIKE '.$word;
					$wheres2[] 	= 'a.ville LIKE '.$word;
					$wheres2[] 	= 'a.departement LIKE '.$word;
					$wheres2[] 	= 'a.pay LIKE '.$word;
					$wheres2[] 	= 'a.horaires_prix LIKE '.$word;
					$wheres2[] 	= 'a.tel LIKE '.$word;
					$wheres2[] 	= 'a.tel2 LIKE '.$word;
					$wheres2[] 	= 'a.fax LIKE '.$word;
					$wheres2[] 	= 'b.title LIKE '.$word;
					$wheres[] 	= implode( ' OR ', $wheres2 );
				}
				$where = '(' . implode( ($phrase == 'all' ? ') AND (' : ') OR ('), $wheres ) . ')';
				break;
		}
	
	
		// Filter by access level.
		//if ($access = $this->getState('filter.access')) {
			$user	= JFactory::getUser();
			$groups	= implode(',', $user->getAuthorisedViewLevels());
			$wheresPro[] ='(a.access IN ('.$groups.') or (a.access = ""))';
			$wheres[] ='(b.access IN ('.$groups.') or (b.access = ""))';
		//}

		// Filter by language
		if ($app->isSite() && $app->getLanguageFilter()) {
			$wheresPro[] ='a.language in (' . $db->Quote($tag) . ',' . $db->Quote('*') . ')';
			$wheres[] ='b.language in (' . $db->Quote($tag) . ',' . $db->Quote('*') . ')';
		}

        $wheresPro[] = '( a.publish_up = \'\' OR a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' )';
        $wheresPro[] = '( a.publish_down = \'\' OR a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )';
        $wheres[] = 'a.published = 1';
        $wheres[] = 'b.published = 1';

		$text   = $db->Quote( '%'.$db->getEscaped( $text, true ).'%', false );

        $query = "SHOW COLUMNS FROM `#__gmapfp` LIKE 'access'";
        $db->setQuery( $query );
        $result = $db->loadObject();
        if ($result) {
			$wheres = array_merge($wheres, $wheresPro); 
			$query  = 'SELECT CONCAT_WS(" : ",a.ville,a.nom) AS title, a.created AS created,'
			. ' a.intro AS text,'
			. ' b.title AS section,'
			. ' a.id AS id,'
			. ' "2" AS browsernav'
			. ' FROM #__gmapfp AS a'
			. ' INNER JOIN #__categories AS b ON b.id = a.catid'
			. ' WHERE ' . implode( "\n  AND ", $wheres )
			. ' AND ( '.$where.' )'
			. ' GROUP BY a.id'
			. ' ORDER BY '. $order
			;
		} else {
			$query  = 'SELECT CONCAT_WS(" : ",a.ville,a.nom) AS title, 0 AS created,'
			. ' a.intro AS text,'
			. ' b.title AS section,'
			. ' a.id AS id,'
			. ' "2" AS browsernav'
			. ' FROM #__gmapfp AS a'
			. ' INNER JOIN #__categories AS b ON b.id = a.catid'
			. ' WHERE ' . implode( "\n  AND ", $wheres )
			. ' AND ( '.$where.' )'
			. ' GROUP BY a.id'
			. ' ORDER BY '. $order
			;
		}
		$db->setQuery( $query, 0, $limit );
		$rows = $db->loadObjectList();
	
		foreach($rows as $key => $row) {
			$rows[$key]->href = 'index.php?option=com_gmapfp&view=gmapfp&layout=article&id='.$row->id;
		}
	
		return $rows;
	}
}
