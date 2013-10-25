<?php
/**
 * JComments plugin for standart gmapfp objects support
 *
 * @version 8.4pro
 * @package JComments
 * @author Fabrice4821 (www.gmapfp.org)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_gmapfp extends JCommentsPlugin
{
    var $component = 'com_gmapfp';
    var $tableName = '#__gmapfp';
	var $keyField = 'id';
	var $titleField = 'nom';
	var $ownerField = 'userid';

	function getTitles($ids)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT nom, id FROM #__gmapfp WHERE id IN (' . implode(',', $ids) . ')' );
		return $db->loadObjectList('id');
	}

	function getObjectTitle($id)
	{
		$db = & JCommentsFactory::getDBO();
		// we need select primary key for JoomFish support
		$db->setQuery( 'SELECT nom, id FROM #__gmapfp WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		if (JCOMMENTS_JVERSION == '1.5') {
			require_once(JPATH_ROOT.DS.'components'.DS.'com_gmapfp'.DS.'helpers'.DS.'route.php');
			
			$query = 'SELECT a.id, a.catid, a.access,' .
					' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
					' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug'.
					' FROM #__gmapfp AS a' .
					' LEFT JOIN #__categories AS cc ON cc.id = a.catid' .
					' WHERE a.id = ' . intval($id);

			$db = & JCommentsFactory::getDBO();
			$db->setQuery( $query );
			$row = $db->loadObject();

			$user =& JFactory::getUser();

			$link = "";
			if (isset($row))
				if ($row->access <= $user->get('aid', 0)) {
					$link = JRoute::_(GMapFPHelperRoute::getArticleRoute($row->slug, $row->catslug));
				} else {
					$link = JRoute::_("index.php?option=com_user&task=register");
				}
		} else {
			$mainframe = &JFactory::getApplication(); 
			$Itemid    = JRequest::getInt('Itemid'); 
			
			$compatibilityMode = $mainframe->getCfg('itemid_compat');
			
			if ( $compatibilityMode == null ) {
				// Joomla 1.0.12 or below
				if ( $Itemid && $Itemid != 99999999 ) {
					$_Itemid = $Itemid;
				} else {
					$_Itemid = $mainframe->getItemid( $id );
				}
			} else if ( (int) $compatibilityMode > 0 && (int) $compatibilityMode <= 11) {
				// Joomla 1.0.13 or higher and Joomla 1.0.11 compatibility
				$_Itemid = $mainframe->getItemid( $id, 0, 0  );
			} else {
				// Joomla 1.0.13 or higher and new Itemid algorithm
				$_Itemid = $Itemid;
			}

			$link = JoomlaTuneRoute::_('index.php?option=com_gmapfp&amp;task=view&amp;id='. $id .'&amp;Itemid='. $_Itemid);
		}
		return $link;
	}

	function getObjectOwner($id)
	{
		$db = & JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT userid, id FROM #__gmapfp WHERE id = ' . $id );
		$userid = $db->loadResult();
		
		return $userid;
	}

	function getCategories($filter = '')
	{
		$db = & JCommentsFactory::getDBO();

		$query = "SELECT c.id AS `value`, CONCAT_WS( ' / ', s.title, c.title) AS `text`"
			. "\n FROM #__sections AS s"
			. "\n INNER JOIN #__categories AS c ON c.section = s.id"
			. (($filter != '') ? "\n WHERE c.id IN ( ".$filter." )" : '')
			. "\n ORDER BY s.name,c.name"
			;
		$db->setQuery( $query );
		$rows = $db->loadObjectList();

		return $rows;
	}
}
?>