<?php
    /*
    * Module GMapFP for Component Google Map for Joomla! 1.5.x
    * Version J17V1.0Pro
    * Creation date: Août 2011
    * Author: Fabrice4821 - www.gmapfp.org
    * Author email: webmaster@gmapfp.org
    * License GNU/GPL
    */

// no direct access
defined('_JEXEC') or die('Restricted access');

class modGMapFPHelper
{
    function getGmapFPRandom($nbre_article)
    {
		$mainframe 	= &JFactory::getApplication(); 
        $db     	=& JFactory::getDBO();
        $now    	= $mainframe->get('requestTime');
        $nullDate 	= $db->getNullDate();
        $result 	= null;

        $wheres[] = ' published = 1 ';

        $query = 'SELECT *,'
            .' CASE WHEN CHAR_LENGTH(alias) THEN CONCAT_WS(\':\', id, alias) ELSE id END as slug '
            .' FROM #__gmapfp'
            .' WHERE ' . implode( "\n  AND ", $wheres )
            .' ORDER BY RAND()'
            .' LIMIT '.$nbre_article
            ;
        $db->setQuery($query);
        $result = $db->loadObjectList();
        if ($db->getErrorNum()) {
            JError::raiseWarning( 500, $db->stderr() );
        }

        return $result;
    }

    function getGmapFPLast($nbre_article)
    {
		$mainframe 	= &JFactory::getApplication(); 
        $db     	=& JFactory::getDBO();
        $now    	= $mainframe->get('requestTime');
        $nullDate 	= $db->getNullDate();
        $result 	= null;

        $wheres[] = ' published = 1 ';

        $query = 'SELECT *,'
            .' CASE WHEN CHAR_LENGTH(alias) THEN CONCAT_WS(\':\', id, alias) ELSE id END as slug '
            .' FROM #__gmapfp'
            .' WHERE ' . implode( "\n  AND ", $wheres )
			.' ORDER BY id DESC'
			.' LIMIT '.$nbre_article
            ;
        $db->setQuery($query);
        $result = $db->loadObjectList();
        if ($db->getErrorNum()) {
            JError::raiseWarning( 500, $db->stderr() );
        }

        return $result;
    }

    function getGmapFPSQL($nbre_article, $where)
    {
		$mainframe 	= &JFactory::getApplication(); 
        $db     	=& JFactory::getDBO();
        $now    	= $mainframe->get('requestTime');
        $nullDate 	= $db->getNullDate();
        $result 	= null;

        $wheres[] = ' published = 1 ';

        $query = 'SELECT *,'
            .' CASE WHEN CHAR_LENGTH(alias) THEN CONCAT_WS(\':\', id, alias) ELSE id END as slug '
            .' FROM #__gmapfp'
            .' WHERE ' . implode( "\n  AND ", $wheres );
        if ($where) $query .=' AND '.$where;
        $query .=' LIMIT '.$nbre_article;
		
        $db->setQuery($query);
        $result = $db->loadObjectList();
        if ($db->getErrorNum()) {
            JError::raiseWarning( 500, $db->stderr() );
        }

        return $result;
    }
}
?>
