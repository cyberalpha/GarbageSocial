<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.29
	* Creation date: Janvier 2013
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die();
jimport('joomla.application.component.model');

class GMapFPsModelGMapFP extends JModel
{
	private $_catid = null;
	private $_result = null;
	private $_result2 = null;
	
	function __construct() 
    { 
        parent::__construct(); 
		$app = JFactory::getApplication('site');
		if ($app->getName()=='site') {
			$params = $app->getParams();
		} else {
			$params =& JComponentHelper::getParams('com_gmapfp'); 
		}

        $this->_layout = JRequest::getVar('layout', '', '', 'str'); 
        $this->_id = JRequest::getVar('id', 0, '', 'int'); 

        $this->_catid = $params->get('catid', 0);
        $this->_total   = null; 
        $this->_result  = null; 
        $this->_result2 = null; 
        $this->_result_personnalisation = null; 
		$this->_num_marqueurs = 0;

		JHTML::_( 'behavior .mootools' );
    }

	function define_gmapfp() 
	{
		$mainframe	= &JFactory::getApplication(); 
        $params		= clone($mainframe->getParams('com_gmapfp'));
		$doc		= &JFactory::getDocument();
        $lang		= JFactory::getLanguage(); 
        $tag_lang=$lang->getTag();
		if (($tag_lang!='en-AU') AND ($tag_lang!='en-GB') AND ($tag_lang!='pt-BR') AND ($tag_lang!='pt-PT') AND ($tag_lang!='zh-CN') AND ($tag_lang!='zh-TW'))
			{$tag_lang=(substr($lang->getTag(),0,2)); };
        
        //Insertion des entêtes GMapFP si non déjà fait.
        if (!defined( '_JOS_GMAPFP_CSS' ))
        {
            /** verifi que la fonction n'est défini qu'une faois */
            define( '_JOS_GMAPFP_CSS', 1 );
    
            $doc->addCustomTag( '<link rel="stylesheet" href="'.JURI::base().'components/com_gmapfp/views/gmapfp/gmapfp.css" type="text/css" />'); 
            $doc->addCustomTag( '<link rel="stylesheet" href="'.JURI::base().'components/com_gmapfp/views/gmapfp/gmapfp2.css" type="text/css" />'); 
        }
        
        if (!defined( '_JOS_GMAPFP_LIGHTBOX' ))
        {
            /** verifi que la fonction n'est défini qu'une faois */
            define( '_JOS_GMAPFP_LIGHTBOX', 1 );    
            
            $doc->addCustomTag( '<link rel="stylesheet" type="text/css" href="'.JURI::base().'components/com_gmapfp/floatbox/floatbox.css" />');
            $doc->addCustomTag( '<script type="text/javascript" src="'.JURI::base().'components/com_gmapfp/floatbox/floatbox.js"></script>');
        }
        
        if (!defined( '_JOS_GMAPFP_APIV3' ))
        {
            /** verifi que la fonction n'est défini qu'une faois */
            define( '_JOS_GMAPFP_APIV3', 1 );
			//&region=GB //pour ameliorer la zone de recherche d'une adresse
			$librarie = array();
			if ($params->get('gmapfp_auto_complete', 1)) 	$librarie[] = 'places';
			if ($params->get('gmapfp_plus_info', 1) or $params->get('gmapfp_enable_pano_photos', 1)) 		$librarie[] = 'panoramio';
			$libraries= "";
			if (count($librarie) > 0) {
				$libraries = '&libraries=';
				$libraries .= implode(',', $librarie);
			}
			$http = strstr(JUri::base(), '://', true);
            $doc->addCustomTag( '<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />');
            $doc->addCustomTag( '<script type="text/javascript" src="'.$http.'://maps.googleapis.com/maps/api/js?sensor=true&language='.$tag_lang.$libraries.'"></script>');
            $doc->addCustomTag( '<script type="text/javascript" src="'.JURI::base().'components/com_gmapfp/libraries/map.js"></script>');

        }
    }

	function enfants_catid($id)
	{
		$app = JFactory::getApplication();
		$params = $app->getParams();

		$ids[] = $id;
		if ($params->get('recursive', 1)) {
			//renvoie tous les enfants de $id trié par parent et ordre alphabétique
			$count_ids = count($ids);
			
			for ($i = 0; $i < $count_ids; $i++) {
				$ids = array_merge(array_slice($ids, 0, $i+1), $this->_enfant($ids[$i]), array_slice($ids, $i+1));
				$count_ids = count($ids);
			}
		}

		return $ids;
	}

	function _getQuery()
    {
        $db     = JFactory::getDBO();
        
		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 
		$Itemid    = JRequest::getInt('Itemid'); 
        $params	   = clone($mainframe->getParams('com_gmapfp'));
        $tri       = $params->get('orderby_pri');

 		$user_where = $params->get('gmapfp_filtre_sql');
		if (!empty($user_where))
			$wheres[] = @$params->get('gmapfp_filtre_sql');

       switch ($tri) {
        case 'alpha' :
            $order = "\n ORDER BY a.nom";
            break;
        case 'ralpha' :
            $order = "\n ORDER BY a.nom DESC";
            break;
        case 'ville' :
            $order = "\n ORDER BY a.ville, a.nom";
            break;
        case 'rville' :
            $order = "\n ORDER BY a.ville DESC, a.nom DESC";
            break;
        case 'pays' :
            $order = "\n ORDER BY a.pay, a.ville, a.nom";
            break;
        case 'rpays' :
            $order = "\n ORDER BY a.pay DESC, a.ville DESC, a.nom DESC";
            break;
        default :
            $order = "\n ORDER BY a.ordering";
            break;
        }

        $select = 'a.*, b.title, b.description as cat_description, c.catid as article_id, '.
				' (SELECT d.alias FROM #__categories AS d WHERE d.id=c.catid) as article_alias , '.
				' (SELECT d.id FROM #__categories AS d WHERE d.id=c.catid) as article_id , '.
				' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(\':\', a.id, a.alias) ELSE a.id END as slug, '.
				' CASE WHEN CHAR_LENGTH(b.alias) THEN CONCAT_WS(\':\', b.id, b.alias) ELSE b.id END as catslug, '.
				' CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(\':\', c.id, c.alias) ELSE c.id END as article_slug ';
        $from   = '#__gmapfp AS a';
		$joins[] = 'INNER JOIN #__categories AS b on a.catid = b.id';
		$joins[] = 'LEFT OUTER JOIN #__content AS c on a.article_id = c.id';

        $wheres[] = 'a.published = 1';
		
		// Filter by access level.
		$user	= JFactory::getUser();
		$groups	= implode(',', $user->getAuthorisedViewLevels());
		$wheres[] ='(b.access IN ('.$groups.') or (b.access = ""))';

		if ($this->_catid) {
        	$_catids = $this->enfants_catid($this->_catid);
            foreach ($_catids as $_catid)
            {
                $wheresOr[] = 'a.catid = '.$_catid.'';
            }
            $wheres[] = '('.implode( "\n OR ", $wheresOr).')';
        };

        if (!empty($this->_id)) {
            $wheres[] = 'a.id = '.$this->_id.'';
        };
		
		if ($params->get('gmapfp_filtre')==1) {

			//detection de la présence de JoomFish
			$file = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'joomfish.php';
			if(!file_exists($file)) {
			//Recherche directe dans la base de donnée. Pas possible avec JoomFish car traduction faite a la restitution des données dans la base.
				$search_gmapfp = $mainframe->getUserStateFromRequest( $option.$Itemid.'search_gmapfp', 'search_gmapfp', '',    'string' );
				$search_gmapfp = JString::strtolower($search_gmapfp);
				if ($search_gmapfp) {
					$wheres[] = '(LOWER( nom ) LIKE '.$db->Quote( '%'.$db->getEscaped( $search_gmapfp, true ).'%', false ).
					' OR LOWER( intro ) LIKE '.$db->Quote( '%'.$db->getEscaped( $search_gmapfp, true ).'%', false ).
					' OR LOWER( message ) LIKE '.$db->Quote( '%'.$db->getEscaped( $search_gmapfp, true ).'%', false ).
					' OR LOWER( adresse ) LIKE '.$db->Quote( '%'.$db->getEscaped( $search_gmapfp, true ).'%', false ).
					' OR LOWER( adresse2 ) LIKE '.$db->Quote( '%'.$db->getEscaped( $search_gmapfp, true ).'%', false ).
					' OR LOWER( ville ) LIKE '.$db->Quote( '%'.$db->getEscaped( $search_gmapfp, true ).'%', false ).
					' OR LOWER( departement ) LIKE '.$db->Quote( '%'.$db->getEscaped( $search_gmapfp, true ).'%', false ).
					' OR LOWER( pay ) LIKE '.$db->Quote( '%'.$db->getEscaped( $search_gmapfp, true ).'%', false ).
					' OR LOWER( email ) LIKE '.$db->Quote( '%'.$db->getEscaped( $search_gmapfp, true ).'%', false ).
					' OR LOWER( web ) LIKE '.$db->Quote( '%'.$db->getEscaped( $search_gmapfp, true ).'%', false ).
					') ';
				}
			};
	
			$filtreville = $mainframe->getUserStateFromRequest( $option.$Itemid.'filtreville', 'filtreville', '-- '.JText::_( 'GMAPFP_VILLE_FILTRE' ).' --', 'string' );
			$filtredepartement = $mainframe->getUserStateFromRequest( $option.$Itemid.'filtredepartement', 'filtredepartement', '-- '.JText::_( 'GMAPFP_DEPARTEMENT_FILTRE' ).' --', 'string' );
			$filtrepays = $mainframe->getUserStateFromRequest( $option.$Itemid.'filtrepays', 'filtrepays', '-- '.JText::_( 'GMAPFP_PAYS_FILTRE' ).' --', 'string' );
			$filtrecategorie = $mainframe->getUserStateFromRequest( $option.$Itemid.'filtrecategorie', 'filtrecategorie', '-- '.JText::_( 'GMAPFP_CATEGORIE_FILTRE' ).' --', 'string' );

			if ($filtreville{0}<>'-') {
				$wheres[] = 'ville = \''.addslashes($this->_getVilleByID($filtreville)).'\'';
			}
			if ($filtredepartement{0}<>'-') {
				$wheres[] = 'departement = \''.addslashes($this->_getDepartementByID($filtredepartement)).'\'';
			}
			if ($filtrepays{0}<>'-') {
				$wheres[] = 'pay = \''.addslashes($this->_getPaysByID($filtrepays)).'\'';
			}	
			if ($filtrecategorie{0}<>'-') {
				$wheres[] = 'b.id = \''.$filtrecategorie.'\'';
			}
		};

        $query = "SELECT " . $select .
                "\n FROM " . $from .
				"\n " . implode ( ' ', $joins ) .
                "\n WHERE " . implode( "\n  AND ", $wheres ).
                $order;
//die(print_r($query));
        return $query;
    }

	function _getQuery_orderA()
    {
        $db     = JFactory::getDBO();
        
		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 
		$Itemid    = JRequest::getInt('Itemid'); 
        $params = clone($mainframe->getParams('com_gmapfp'));

        $order = "\n ORDER BY a.nom";

        $select = 'a.*, b.title, b.description as cat_description';
        $from   = '#__gmapfp AS a, #__categories AS b';

		$user_where = $params->get('gmapfp_filtre_sql');
		if (!empty($user_where))
			$wheres[] = @$params->get('gmapfp_filtre_sql');

        $wheres[] = 'a.published = 1';
        $wheres[] = 'a.catid = b.id';
		
		if ($this->_catid) {
        	$_catids = $this->enfants_catid($this->_catid);
            foreach ($_catids as $_catid)
            {
                $wheresOr[] = 'a.catid = '.$_catid.'';
            }
            $wheres[] = '('.implode( "\n OR ", $wheresOr).')';
        };

        if (!empty($this->_id)) {
            $wheres[] = 'a.id = '.$this->_id.'';
        };

		if ($params->get('gmapfp_filtre')==1) {

			//detection de la présence de JoomFish
			$file = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'joomfish.php';
			if(!file_exists($file)) {
			//Recherche directe dans la base de donnée. Pas possible avec JoomFish car traduction faite a la restitution des données dans la base.
				$search_gmapfp = $mainframe->getUserStateFromRequest( $option.$Itemid.'search_gmapfp', 'search_gmapfp', '',    'string' );
				$search_gmapfp = JString::strtolower($search_gmapfp);
				if ($search_gmapfp) {
					$wheres[] = 'LOWER( nom ) LIKE '.$db->Quote( '%'.$db->getEscaped( $search_gmapfp, true ).'%', false ).
					' OR LOWER( intro ) LIKE '.$db->Quote( '%'.$db->getEscaped( $search_gmapfp, true ).'%', false ).
					' OR LOWER( message ) LIKE '.$db->Quote( '%'.$db->getEscaped( $search_gmapfp, true ).'%', false ).
					' OR LOWER( adresse ) LIKE '.$db->Quote( '%'.$db->getEscaped( $search_gmapfp, true ).'%', false ).
					' OR LOWER( adresse2 ) LIKE '.$db->Quote( '%'.$db->getEscaped( $search_gmapfp, true ).'%', false ).
					' OR LOWER( ville ) LIKE '.$db->Quote( '%'.$db->getEscaped( $search_gmapfp, true ).'%', false ).
					' OR LOWER( departement ) LIKE '.$db->Quote( '%'.$db->getEscaped( $search_gmapfp, true ).'%', false ).
					' OR LOWER( pay ) LIKE '.$db->Quote( '%'.$db->getEscaped( $search_gmapfp, true ).'%', false ).
					' OR LOWER( email ) LIKE '.$db->Quote( '%'.$db->getEscaped( $search_gmapfp, true ).'%', false ).
					' OR LOWER( web ) LIKE '.$db->Quote( '%'.$db->getEscaped( $search_gmapfp, true ).'%', false );
				}
			};
	
	
			$filtreville = $mainframe->getUserStateFromRequest( $option.$Itemid.'filtreville', 'filtreville', '-- '.JText::_( 'GMAPFP_VILLE_FILTRE' ).' --', 'string' );
			$filtredepartement = $mainframe->getUserStateFromRequest( $option.$Itemid.'filtredepartement', 'filtredepartement', '-- '.JText::_( 'GMAPFP_DEPARTEMENT_FILTRE' ).' --', 'string' );
			$filtrepays = $mainframe->getUserStateFromRequest( $option.$Itemid.'filtrepays', 'filtrepays', '-- '.JText::_( 'GMAPFP_PAYS_FILTRE' ).' --', 'string' );
			$filtrecategorie = $mainframe->getUserStateFromRequest( $option.$Itemid.'filtrecategorie', 'filtrecategorie', '-- '.JText::_( 'GMAPFP_CATEGORIE_FILTRE' ).' --', 'string' );
	
			if ($filtreville{0}<>'-') {
				$wheres[] = 'ville = \''.addslashes($this->_getVilleByID($filtreville)).'\'';
			}
			if ($filtredepartement{0}<>'-') {
				$wheres[] = 'departement = \''.addslashes($this->_getDepartementByID($filtredepartement)).'\'';
			}
			if ($filtrepays{0}<>'-') {
				$wheres[] = 'pay = \''.addslashes($this->_getPaysByID($filtrepays)).'\'';
			}	
			if ($filtrecategorie{0}<>'-') {
				$wheres[] = 'b.id = \''.$filtrecategorie.'\'';
			}
		};

        $query = "SELECT " . $select .
                "\n FROM " . $from .
                "\n WHERE " . implode( "\n  AND ", $wheres ).
                $order;
        return $query;
    }

	function verif_catid($id)
	{
		/*jimport( 'joomla.application.categories' );
		$categories = JCategories::getInstance('Gmapfp', '');
		$item_categories = $categories->get($id);*/
		
		//renvoie tous les enfants de $id trié par parent et ordre alphabétique
		$ids[] = $id;
		$count_ids = count($ids);
		
		for ($i = 0; $i < $count_ids; $i++) {
			$ids = array_merge(array_slice($ids, 0, $i+1), $this->_enfant($ids[$i]), array_slice($ids, $i+1));
			$count_ids = count($ids);
		}

		return $ids;
	}

	function _enfant($id)
	{
		$db	= JFactory::getDBO();
		$query = "SELECT id" .
				"\n FROM #__categories" .
				"\n WHERE parent_id = ".$id .
				"\n AND published = true" .
				"\n ORDER BY title";
    	$db->setQuery( $query );
		$result = $db->loadResultArray();
		return $result;
	}
	
	function getPersonnalisation()
	{
		$mainframe = &JFactory::getApplication(); 
		$db	= JFactory::getDBO();
        $params = clone($mainframe->getParams('com_gmapfp'));
		$perso  = $params->get('id_perso', 0);

		$query = "SELECT *" .
				"\n FROM #__gmapfp_personnalisation" .
				"\n WHERE id = ".$perso;

		if (empty($this->_result_personnalisation))
		{
			$db->setQuery( $query );
			$this->_result_personnalisation = $db->loadObject();
		}
		return @$this->_result_personnalisation;
	}
	
	function getTotal()
	{
		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 
		$Itemid    = JRequest::getInt('Itemid'); 

		// Lets load the content if it doesn't already exist
		if (empty($this->_total))
		{
			$query = $this->_getQuery();

			//detection de la présence de JoomFish
			$file = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'joomfish.php';
			if(file_exists($file)) {
			//Recherche directe dans le resultat de la requete pour JoomFish car traduction faite a la restitution des données dans la base.
				$this->_total = $this->_getList( $query );
				$search_gmapfp = $mainframe->getUserStateFromRequest( $option.$Itemid.'search_gmapfp', 'search_gmapfp', '',    'string' );
				$search_gmapfp = JString::strtolower($search_gmapfp);
				if ($search_gmapfp) {
					$Resultat_filtre = 0;
					foreach ($this->_total as $result) {
						if ((!(strpos(JString::strtolower($result->nom),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->intro),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->message),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->adresse),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->adresse2),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->ville),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->departement),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->pay),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->email),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->web),$search_gmapfp)===false))) {
							$Resultat_filtre ++;
						}
					};
					$this->_total=$Resultat_filtre;
				}else{
					$this->_total = $this->_getListCount($query);
				};
			}else{
				$this->_total = $this->_getListCount($query);
			};
		}
		return $this->_total;
	}
	
	function _getQueryPlugin( $options )
	{
		$db			= JFactory::getDBO();

		foreach ($options as $option)
		{
			$wheresOr[]= 'a.id = \''.$option.'\'';
		}
		$wheres[]="(".implode( "\n OR ", $wheresOr ).")";

		$select = 'a.*, b.title, c.catid as article_id,'.
				' (SELECT d.alias FROM #__categories AS d WHERE d.id=c.catid) as article_alias , '.
				' (SELECT d.id FROM #__categories AS d WHERE d.id=c.catid) as article_id , '.
				' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(\':\', a.id, a.alias) ELSE a.id END as slug, '.
				' CASE WHEN CHAR_LENGTH(b.alias) THEN CONCAT_WS(\':\', b.id, b.alias) ELSE b.id END as catslug, '.
				' CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(\':\', c.id, c.alias) ELSE c.id END as article_slug ';
        $from   = '#__gmapfp AS a';
		$joins[] = 'INNER JOIN #__categories AS b on a.catid = b.id';
		$joins[] = 'LEFT OUTER JOIN #__content AS c on a.article_id = c.id';

		$wheres[] = 'a.published = 1';

		$user =& JFactory::getUser();
		$aid = $user->get('aid', 0);
		//$wheres[] = 'b.access <= '.(int) $aid;

		$query = "SELECT " . $select .
				"\n FROM " . $from .
				"\n " . implode ( ' ', $joins ) .
				"\n WHERE " . implode( "\n  AND ", $wheres );

		return $query;
	}
	
	function _getQueryPluginCatid( $options )
	{
		$db			= JFactory::getDBO();

		foreach ($options as $option)
		{
			$wheresOr[]= 'a.catid = \''.$option.'\'';
		}
		$wheres[]="(".implode( "\n OR ", $wheresOr ).")";

		$select = 'a.*, b.title, c.catid as article_id,'.
				' (SELECT d.alias FROM #__categories AS d WHERE d.id=c.catid) as article_alias , '.
				' (SELECT d.id FROM #__categories AS d WHERE d.id=c.catid) as article_id , '.
				' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(\':\', a.id, a.alias) ELSE a.id END as slug, '.
				' CASE WHEN CHAR_LENGTH(b.alias) THEN CONCAT_WS(\':\', b.id, b.alias) ELSE b.id END as catslug, '.
				' CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(\':\', c.id, c.alias) ELSE c.id END as article_slug ';
        $from   = '#__gmapfp AS a';
		$joins[] = 'INNER JOIN #__categories AS b on a.catid = b.id';
		$joins[] = 'LEFT OUTER JOIN #__content AS c on a.article_id = c.id';

		$wheres[] = 'a.published = 1';

		$user =& JFactory::getUser();
		$aid = $user->get('aid', 0);
		//$wheres[] = 'b.access <= '.(int) $aid;

		$query = "SELECT " . $select .
				"\n FROM " . $from .
				"\n " . implode ( ' ', $joins ) .
				"\n WHERE " . implode( "\n  AND ", $wheres );

		return $query;
	}
	
	function getGMapFPList( $options=array() )
	{
		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 
		$Itemid    = JRequest::getInt('Itemid'); 

		if (empty($this->_result2))
		{
			$query	= $this->_getQuery( $options );
			$this->_result2 = $this->_getList( $query );

			//detection de la présence de JoomFish
			$file = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'joomfish.php';
			if(file_exists($file)) {
			//Recherche directe dans le resultat de la requete pour JoomFish car traduction faite a la restitution des données dans la base.
				$search_gmapfp = $mainframe->getUserStateFromRequest( $option.$Itemid.'search_gmapfp', 'search_gmapfp', '',    'string' );
				$search_gmapfp = JString::strtolower($search_gmapfp);
				if ($search_gmapfp) {
					$Resultat_filtre = array();
					foreach ($this->_result2 as $result) {
						if ((!(strpos(JString::strtolower($result->nom),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->intro),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->message),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->adresse),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->adresse2),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->ville),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->departement),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->pay),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->email),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->web),$search_gmapfp)===false))) {
							$Resultat_filtre[] = $result;
						}
					};
					$this->_result2=$Resultat_filtre;
				}
			};
		}
		return @$this->_result2;
	}
	
	function getView()
	{
		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 
		$Itemid    = JRequest::getInt('Itemid'); 

		if (empty($this->_result)) {
			$query 	= $this->_getQuery();
			$this->_result = $this->_getList( $query );
			
			$query 	= $this->_getQuery_orderA();
			$this->_result_orderA = $this->_getList( $query );

			//detection de la présence de JoomFish
			$file = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomfish'.DS.'joomfish.php';
			if(file_exists($file)) {
			//Recherche directe dans le resultat de la requete pour JoomFish car traduction faite a la restitution des données dans la base.
				$search_gmapfp = $mainframe->getUserStateFromRequest( $option.$Itemid.'search_gmapfp', 'search_gmapfp', '',    'string' );
				$search_gmapfp = JString::strtolower($search_gmapfp);
				if ($search_gmapfp) {
					$Resultat_filtre = array();
					foreach ($this->_result as $result) {
						if ((!(strpos(JString::strtolower($result->nom),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->intro),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->message),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->adresse),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->adresse2),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->ville),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->departement),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->pay),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->email),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->web),$search_gmapfp)===false))) {
							$Resultat_filtre[] = $result;
						}
					};
					$this->_result=$Resultat_filtre;
					
					$Resultat_filtre_orderA = array();
					foreach ($this->_result_orderA as $result) {
						if ((!(strpos(JString::strtolower($result->nom),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->intro),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->message),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->adresse),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->adresse2),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->ville),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->departement),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->pay),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->email),$search_gmapfp)===false)or!(strpos(JString::strtolower($result->web),$search_gmapfp)===false))) {
							$Resultat_filtre_orderA[] = $result;
						}
					};
					$this->_result_orderA=$Resultat_filtre_orderA;
				}
			};
		};
		if ($this->_result) {
			$map	= $this->getCarte($this->_result, $this->_result_orderA, 0, 0, 0);
		}else{
			$map	= JText::_('GMAPFP_AUCUNE_INFO')."</br></br>";
		};
		return $map;
	}

	//Integration des données du plugin
	function getViewPlugin($ids, $num, $Hmap='0', $Lmap='0', $Zmap='0', $Itin='0', $bar_PSM='0', $bar_z_nav='0', $Ech='0', $click_over='0', $MZoom='0', $ZZoom='0', $map_phy='0', $map_nor='0', $map_sat='0', $map_hyb='0', $map_choix='0', $kml_file='0', $map_earth='0', $map_centre_lng='0', $map_centre_lat='0', $plugcatids, $More='0', $map_centre_id='0')
	{
		//rechercher du centrage d'un id
		if ($map_centre_id!=0) {
			$map_centre_ids[]=$map_centre_id;
			$query 	= $this->_getQueryPlugin($map_centre_ids);
			$result = $this->_getList( $query );
			$map_centre_lng = $result[0]->glng;
			$map_centre_lat = $result[0]->glat;
			if ($Zmap==0) {
				$Zmap = $result[0]->gzoom;
			};
		}

		//rechercher des lieux par id
		if ($ids!=0) {
			$query 	= $this->_getQueryPlugin($ids);
			$result = $this->_getList( $query );
			foreach($result as $lieu) {
				$rows[] = $lieu;
			};
		}

		//recherche des catégories des groupes de catégories
        if ($plugcatids!=0) {
			$catids = array();
			foreach ($plugcatids as $plugcatid) {
				$catids = array_merge($catids, $this->verif_catid($plugcatid));
			};
        }else{
			$catids=0;
		};

		//recherche des lieux par catégorie
		if ($catids!=0) {
			$query 	= $this->_getQueryPluginCatid($catids);
			$result = $this->_getList( $query );
			foreach($result as $lieu) {
				$rows[] = $lieu;
			};
		}
		
		//Isolation des id des lieux du plugin
		if (!(@$rows)) {
			$language =& JFactory::getLanguage();
			$language->load('com_gmapfp');
			JError::raiseWarning(0, JText::_('GMAPFP_MAUVAIS_ID_PLUGIN'));
			return(JText::_('GMAPFP_MAUVAIS_ID_PLUGIN'));
		}else{
			//tri par ordre alphabétique pour la liste itinèraire
			$rows_orderA = $rows;
			foreach ($rows_orderA as $row) {
				$rows_orderA_id[]=$row->id;
				$rows_orderA_nom[]=$row->nom;
			}
			$array_lowercase = array_map('strtolower', $rows_orderA_nom);
			array_multisort($array_lowercase, SORT_ASC,  $rows_orderA_id, SORT_ASC, $rows_orderA);
			//fin de la procédure de tri

		//appel de la carte
		$map	= $this->getCarte($rows, $rows_orderA, $map_centre_lat, $map_centre_lng, 1, $num, $Hmap, $Lmap, $Zmap, $Itin, $bar_PSM, $bar_z_nav, $Ech, $click_over, $MZoom, $ZZoom, $map_phy, $map_nor, $map_sat, $map_hyb, $map_choix, $kml_file, $map_earth, $More);
	return $map;
		};
	}
	
	function getCarte ($rows, $rows_orderA, $glat_plugin, $glng_plugin, $plugin, $num = '', $Hmap = '', $Lmap = '', $Zmap = '',  $Itin='0', $bar_PSM='0', $bar_z_nav='0', $Ech='0', $click_over='0', $MZoom='0', $ZZoom='0', $map_phy='0', $map_nor='0', $map_sat='0', $map_hyb='0', $map_choix='0', $kml_file='0', $map_earth='0', $More='0')
	{
		$doc		= &JFactory::getDocument();

		$loadmarqueur = '';
		$cnt = 1;
		foreach($rows as $row) {
			$loadmarqueur .=" markerImage".$num."[".$cnt."] = new Image(); ";
			$loadmarqueur .=" markerImage".$num."[".$cnt."].src = \"".$row->marqueur."\";\n ";
			$cnt++;
		}	
		
		$CustomHeadTag1=( '
		<script type="text/javascript"> 
			var markerImage'.$num.' = new Array();
			'.$loadmarqueur.'
		</script>
		');

		$doc->addCustomTag($CustomHeadTag1);
		
		$this->define_gmapfp();

		include 'components/com_gmapfp/libraries/map_v3.php';
		return $carte;
	}

    function getlistville()
    {
		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 
		$Itemid    = JRequest::getInt('Itemid'); 
		
		$filtredepartement = $mainframe->getUserStateFromRequest( $option.$Itemid.'filtredepartement', 'filtredepartement', '-- '.JText::_( 'GMAPFP_DEPARTEMENT_FILTRE' ).' --', 'string' );
		$filtrepays = $mainframe->getUserStateFromRequest( $option.$Itemid.'filtrepays', 'filtrepays', '-- '.JText::_( 'GMAPFP_PAYS_FILTRE' ).' --', 'string' );
		$filtrecategorie = $mainframe->getUserStateFromRequest( $option.$Itemid.'filtrecategorie', 'filtrecategorie', '-- '.JText::_( 'GMAPFP_CATEGORIE_FILTRE' ).' --', 'string' );
		if ($filtredepartement{0}<>'-') {
			$wheres[] = 'departement = \''.addslashes($this->_getDepartementByID($filtredepartement)).'\'';
		}
		if ($filtrepays{0}<>'-') {
			$wheres[] = 'pay = \''.addslashes($this->_getPaysByID($filtrepays)).'\'';
		}	
		if ($filtrecategorie{0}<>'-') {
			$wheres[] = 'b.id = \''.$filtrecategorie.'\'';
		}

        $params = clone($mainframe->getParams('com_gmapfp'));
		$user_where = $params->get('gmapfp_filtre_sql');
		if (!empty($user_where))
			$wheres[] = @$params->get('gmapfp_filtre_sql');

        $wheres[] = 'a.published = 1';
        $wheres[] = 'a.catid = b.id';

		if ($this->_catid) {
        	$_catids = $this->enfants_catid($this->_catid);
            foreach ($_catids as $_catid)
            {
                $wheresOr[] = 'a.catid = '.$_catid.'';
            }
            $wheres[] = '('.implode( " OR ", $wheresOr).')';
        };

        $query = 'SELECT a.ville, a.id' .
                ' FROM #__gmapfp AS a, #__categories AS b' .
                ' WHERE ' . implode( '  AND ', $wheres ).
                ' ORDER BY a.ville';
        $results = $this->_getList( $query );
		$tries=array();
		foreach ($results as $result) {
			$trie=array();
			$trie['id'] = $result->id;
			$trie['ville'] = $result->ville;
			$tries[]=$trie;
		};
        return $tries;
    }

    function getlistdepartement()
    {
		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 
		$Itemid    = JRequest::getInt('Itemid'); 
		
		$filtreville = $mainframe->getUserStateFromRequest( $option.$Itemid.'filtreville', 'filtreville', '-- '.JText::_( 'GMAPFP_VILLE_FILTRE' ).' --', 'string' );
		$filtrepays = $mainframe->getUserStateFromRequest( $option.$Itemid.'filtrepays', 'filtrepays', '-- '.JText::_( 'GMAPFP_PAYS_FILTRE' ).' --', 'string' );
		$filtrecategorie = $mainframe->getUserStateFromRequest( $option.$Itemid.'filtrecategorie', 'filtrecategorie', '-- '.JText::_( 'GMAPFP_CATEGORIE_FILTRE' ).' --', 'string' );
		if ($filtreville{0}<>'-') {
			$wheres[] = 'ville = \''.addslashes($this->_getVilleByID($filtreville)).'\'';
		}
		if ($filtrepays{0}<>'-') {
			$wheres[] = 'pay = \''.addslashes($this->_getPaysByID($filtrepays)).'\'';
		}	
		if ($filtrecategorie{0}<>'-') {
			$wheres[] = 'b.id = \''.$filtrecategorie.'\'';
		}

        $params = clone($mainframe->getParams('com_gmapfp'));
		$user_where = $params->get('gmapfp_filtre_sql');
		if (!empty($user_where))
			$wheres[] = @$params->get('gmapfp_filtre_sql');

        $wheres[] = 'a.published = 1';
        $wheres[] = 'a.catid = b.id';

		if ($this->_catid) {
        	$_catids = $this->enfants_catid($this->_catid);
            foreach ($_catids as $_catid)
            {
                $wheresOr[] = 'a.catid = '.$_catid.'';
            }
            $wheres[] = '('.implode( " OR ", $wheresOr).')';
        };

        $query = 'SELECT a.departement, a.id' .
                ' FROM #__gmapfp AS a, #__categories AS b' .
                ' WHERE ' . implode( '  AND ', $wheres ).
                ' ORDER BY a.departement';
        $results = $this->_getList( $query );
		$tries=array();
		foreach ($results as $result) {
			$trie=array();
			$trie['id'] = $result->id;
			$trie['departement'] = $result->departement;
			$tries[]=$trie;
		};
        return $tries;
    }

    function getlistpays()
    {
 		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 
		$Itemid    = JRequest::getInt('Itemid'); 
		
		$filtreville = $mainframe->getUserStateFromRequest( $option.$Itemid.'filtreville', 'filtreville', '-- '.JText::_( 'GMAPFP_VILLE_FILTRE' ).' --', 'string' );
		$filtredepartement = $mainframe->getUserStateFromRequest( $option.$Itemid.'filtredepartement', 'filtredepartement', '-- '.JText::_( 'GMAPFP_DEPARTEMENT_FILTRE' ).' --', 'string' );
		$filtrecategorie = $mainframe->getUserStateFromRequest( $option.$Itemid.'filtrecategorie', 'filtrecategorie', '-- '.JText::_( 'GMAPFP_CATEGORIE_FILTRE' ).' --', 'string' );
		if ($filtreville{0}<>'-') {
			$wheres[] = 'ville = \''.addslashes($this->_getVilleByID($filtreville)).'\'';
		}
		if ($filtredepartement{0}<>'-') {
			$wheres[] = 'departement = \''.addslashes($this->_getDepartementByID($filtredepartement)).'\'';
		}
		if ($filtrecategorie{0}<>'-') {
			$wheres[] = 'b.id = \''.$filtrecategorie.'\'';
		}

        $params = clone($mainframe->getParams('com_gmapfp'));
		$user_where = $params->get('gmapfp_filtre_sql');
		if (!empty($user_where))
			$wheres[] = @$params->get('gmapfp_filtre_sql');

        $wheres[] = 'a.published = 1';
        $wheres[] = 'a.catid = b.id';

		if ($this->_catid) {
        	$_catids = $this->enfants_catid($this->_catid);
            foreach ($_catids as $_catid)
            {
                $wheresOr[] = 'a.catid = '.$_catid.'';
            }
            $wheres[] = '('.implode( " OR ", $wheresOr).')';
        };

        $query = 'SELECT a.pay, a.id' .
                ' FROM #__gmapfp AS a, #__categories AS b' .
                ' WHERE ' . implode( '  AND ', $wheres ).
                ' ORDER BY a.pay';
        $results = $this->_getList( $query );
		$tries=array();
		foreach ($results as $result) {
			$trie=array();
			$trie['id'] = $result->id;
			$trie['pay'] = $result->pay;
			$tries[]=$trie;
		};
        return $tries;
    }

    function getlistcategorie()
    {
 		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 
		$Itemid    = JRequest::getInt('Itemid'); 
		
		$filtreville = $mainframe->getUserStateFromRequest( $option.$Itemid.'filtreville', 'filtreville', '-- '.JText::_( 'GMAPFP_VILLE_FILTRE' ).' --', 'string' );
		$filtredepartement = $mainframe->getUserStateFromRequest( $option.$Itemid.'filtredepartement', 'filtredepartement', '-- '.JText::_( 'GMAPFP_DEPARTEMENT_FILTRE' ).' --', 'string' );
		$filtrepays = $mainframe->getUserStateFromRequest( $option.$Itemid.'filtrepays', 'filtrepays', '-- '.JText::_( 'GMAPFP_PAYS_FILTRE' ).' --', 'string' );
		if ($filtreville{0}<>'-') {
			$wheres[] = 'ville = \''.addslashes($this->_getVilleByID($filtreville)).'\'';
		}
		if ($filtredepartement{0}<>'-') {
			$wheres[] = 'departement = \''.addslashes($this->_getDepartementByID($filtredepartement)).'\'';
		}
		if ($filtrepays{0}<>'-') {
			$wheres[] = 'pay = \''.addslashes($this->_getPaysByID($filtrepays)).'\'';
		}	

        $params = clone($mainframe->getParams('com_gmapfp'));
		$user_where = $params->get('gmapfp_filtre_sql');
		if (!empty($user_where))
			$wheres[] = @$params->get('gmapfp_filtre_sql');

        $wheres[] = 'a.published = 1';
        $wheres[] = 'a.catid = b.id';

		if ($this->_catid) {
        	$_catids = $this->enfants_catid($this->_catid);
            foreach ($_catids as $_catid)
            {
                $wheresOr[] = 'a.catid = '.$_catid.'';
            }
            $wheres[] = '('.implode( " OR ", $wheresOr).')';
        };

		$user =& JFactory::getUser();
		$aid = $user->get('aid', 0);
		//$wheres[] = 'b.access <= '.(int) $aid;

        $query = 'SELECT DISTINCT b.id, b.title' .
                ' FROM #__gmapfp AS a, #__categories AS b' .
                ' WHERE ' . implode( '  AND ', $wheres ).
                ' ORDER BY b.title';
        return $this->_getList( $query );
    }

    function _getGoogleAPIKey()
    {
		$GoogleAPIKey = "";
		$config =& JComponentHelper::getParams('com_gmapfp');
		if ($config->get('gmapfp_key')) {
			$GoogleAPIKey = $config->get('gmapfp_key');
		}else{
			$homepages = explode(";",$config->get('gmapfp_multi_url'));
			$keys = explode(";",$config->get('gmapfp_multi_key'));
            if ($config->get('gmapfp_URI_type', 0)) {
                $mypage = str_replace("www.","",JURI::base());
            }else{
                $mypage = str_replace("www.","",$_SERVER["SERVER_NAME"]);
            }
			$mypage = str_replace("http://","",$mypage);
			$mypage = str_replace("http:\\","",$mypage);
			if (strpos($mypage, "/")!== false) { $mypage = substr($mypage, 0, strpos($mypage, "/")); };
			if (strpos($mypage, "\\")!== false) { $mypage = substr($mypage, 0, strpos($mypage, "\\")); };

/*            $mainframe->addCustomHeadTag( '<meta name="domaine_JURI::base"              content="'.JURI::base().'" />');
            $mainframe->addCustomHeadTag( '<meta name="domaine_JURI::current"           content="'.JURI::current().'" />');
            $mainframe->addCustomHeadTag( '<meta name="domaine_$_SERVER["REQUEST_URI"]" content="'.$_SERVER["REQUEST_URI"].'" />');
            $mainframe->addCustomHeadTag( '<meta name="domaine_$_SERVER["SERVER_NAME"]" content="'.$_SERVER["SERVER_NAME"].'" />');
*/
			$i = 0;
			foreach ($homepages as $homepage){ 
				$uri = trim($homepage);
				$u =& JURI::getInstance( $uri );
				$page = str_replace("www.","",$u->getHost());
				$page = str_replace("http://","",$page);
				$page = str_replace("http:\\","",$page);
				if (strpos($page, "/")!== false) { $page = substr($page, 0, strpos($page, "/")); };
				if (strpos($page, "\\")!== false) { $page = substr($page, 0, strpos($page, "\\")); };
				
				if ($page==$mypage) {
					$GoogleAPIKey = $keys[$i];
					break;
				}
				$i++;
			}
		}
		return $GoogleAPIKey;
	}

//recherche de la ville correspondant à l'id (pour filtre suite Joom!Fish)
	function _getVilleByID($id)
	{
    	$db = JFactory::getDBO();
        $query = 'SELECT a.ville' .
                ' FROM #__gmapfp AS a' .
                ' WHERE id=' . $id;
    	$db->setQuery( $query );
		$result = $db->loadObject();
		return $result->ville;
	}

//recherche de la ville correspondant à l'id (pour filtre suite Joom!Fish)
	function _getDepartementByID($id)
	{
    	$db = JFactory::getDBO();
        $query = 'SELECT a.departement' .
                ' FROM #__gmapfp AS a' .
                ' WHERE id=' . $id;
    	$db->setQuery( $query );
		$result = $db->loadObject();
		return $result->departement;
	}

//recherche de la ville correspondant à l'id (pour filtre suite Joom!Fish)
	function _getPaysByID($id)
	{
    	$db = JFactory::getDBO();
        $query = 'SELECT a.pay' .
                ' FROM #__gmapfp AS a' .
                ' WHERE id=' . $id;
    	$db->setQuery( $query );
		$result = $db->loadObject();
		return $result->pay;
	}

}
?>
