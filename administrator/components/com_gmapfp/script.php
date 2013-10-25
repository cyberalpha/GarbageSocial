<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.4
	* Creation date: Septembre 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die('Restricted access');
 
class com_GMapFPInstallerScript
{
        private $_version_num = "9.30";

		/**
         * method to install the component
         * @return void
         */
        function install($parent) 
        {
			$path = JPATH_SITE;
            @mkdir(JPATH_ROOT."/images/gmapfp/");
		
				//Installation du fichier CSS
				$filesource = $path .DS.'components'.DS.'com_gmapfp'.DS.'views'.DS.'gmapfp'.DS.'gmapfp3.css';
				$filedest = $path .DS.'components'.DS.'com_gmapfp'.DS.'views'.DS.'gmapfp'.DS.'gmapfp.css';
				JFile::copy($filesource, $filedest,null);
				
				$db =& JFactory::getDBO();

				/*mise à jour des données marqueurs*/
				$query = "INSERT INTO `#__gmapfp_marqueurs` VALUES 
		('', 'marqueur', 'http://www.google.com/mapfiles/marker.png',1),
		('', 'marqueur home', 'http://chart.apis.google.com/chart?chst=d_map_xpin_icon&chld=pin_star|home|FFFF00|FF0000',1),
		('', 'marqueur flag', 'http://chart.apis.google.com/chart?chst=d_map_xpin_icon&chld=pin_star|flag|FFFF00|FF0000',1),
		('', 'marqueur info', 'http://chart.apis.google.com/chart?chst=d_map_xpin_icon&chld=pin_star|info|FFFF00|FF0000',1),
		('', 'marqueur bar', 'http://chart.apis.google.com/chart?chst=d_map_xpin_icon&chld=pin_star|bar|FFFF00|FF0000',1),
		('', 'marqueur cafe', 'http://chart.apis.google.com/chart?chst=d_map_xpin_icon&chld=pin_star|cafe|FFFF00|FF0000',1),
		('', 'marqueur perso', 'http://chart.apis.google.com/chart?chst=d_map_spin&chld=1.2|0|FF0000|10|_|foo|bar',1),
		('', 'marqueurA', 'http://www.google.com/mapfiles/markerA.png',1),
		('', 'marqueurB', 'http://www.google.com/mapfiles/markerB.png',1),
		('', 'marqueurC', 'http://www.google.com/mapfiles/markerC.png',1),
		('', 'marqueurD', 'http://www.google.com/mapfiles/markerD.png',1),
		('', 'marqueurE', 'http://www.google.com/mapfiles/markerE.png',1),
		('', 'marqueurF', 'http://www.google.com/mapfiles/markerF.png',1),
		('', 'marqueurG', 'http://www.google.com/mapfiles/markerG.png',1),
		('', 'marqueurH', 'http://www.google.com/mapfiles/markerH.png',1),
		('', 'marqueurI', 'http://www.google.com/mapfiles/markerI.png',1),
		('', 'marqueurJ', 'http://www.google.com/mapfiles/markerJ.png',1),
		('', 'marqueurK', 'http://www.google.com/mapfiles/markerK.png',1),
		('', 'marqueurL', 'http://www.google.com/mapfiles/markerL.png',1),
		('', 'marqueurM', 'http://www.google.com/mapfiles/markerM.png',1),
		('', 'marqueurN', 'http://www.google.com/mapfiles/markerN.png',1),
		('', 'marqueurO', 'http://www.google.com/mapfiles/markerO.png',1),
		('', 'marqueurP', 'http://www.google.com/mapfiles/markerP.png',1),
		('', 'marqueurQ', 'http://www.google.com/mapfiles/markerQ.png',1),
		('', 'marqueurR', 'http://www.google.com/mapfiles/markerR.png',1),
		('', 'marqueurS', 'http://www.google.com/mapfiles/markerS.png',1),
		('', 'marqueurT', 'http://www.google.com/mapfiles/markerT.png',1),
		('', 'marqueurU', 'http://www.google.com/mapfiles/markerU.png',1),
		('', 'marqueurV', 'http://www.google.com/mapfiles/markerV.png',1),
		('', 'marqueurW', 'http://www.google.com/mapfiles/markerW.png',1),
		('', 'marqueurX', 'http://www.google.com/mapfiles/markerX.png',1),
		('', 'marqueurY', 'http://www.google.com/mapfiles/markerY.png',1),
		('', 'marqueurZ', 'http://www.google.com/mapfiles/markerZ.png',1),
		('', 'marqueurBleu', 'http://maps.gstatic.com/intl/fr_ALL/mapfiles/ms/micons/blue-dot.png',1),
		('', 'marqueurVert', 'http://maps.gstatic.com/intl/fr_ALL/mapfiles/ms/micons/green-dot.png',1),
		('', 'marqueurOrange', 'http://maps.gstatic.com/intl/fr_ALL/mapfiles/ms/micons/orange-dot.png',1),
		('', 'marqueurJaune', 'http://maps.gstatic.com/intl/fr_ALL/mapfiles/ms/micons/yellow-dot.png',1),
		('', 'marqueurViolet', 'http://maps.gstatic.com/intl/fr_ALL/mapfiles/ms/micons/purple-dot.png',1),
		('', 'marqueurRose','http://maps.gstatic.com/intl/fr_ALL/mapfiles/ms/micons/pink-dot.png',1),
		('', 'purple', 'http://labs.google.com/ridefinder/images/mm_20_purple.png',1),
		('', 'yellow', 'http://labs.google.com/ridefinder/images/mm_20_yellow.png',1),
		('', 'blue', 'http://labs.google.com/ridefinder/images/mm_20_blue.png',1),
		('', 'white', 'http://labs.google.com/ridefinder/images/mm_20_white.png',1),
		('', 'green', 'http://labs.google.com/ridefinder/images/mm_20_green.png',1),
		('', 'red', 'http://labs.google.com/ridefinder/images/mm_20_red.png',1),
		('', 'black', 'http://labs.google.com/ridefinder/images/mm_20_black.png',1),
		('', 'orange', 'http://labs.google.com/ridefinder/images/mm_20_orange.png',1),
		('', 'gray', 'http://labs.google.com/ridefinder/images/mm_20_gray.png',1),
		('', 'brown', 'http://labs.google.com/ridefinder/images/mm_20_brown.png',1);";
				$db->setQuery($query);
				$db->query();
				if ($db->getErrorNum()) {
					exit($db->stderr());
				}

			// Enable mod_
			$db->setQuery("UPDATE #__modules SET published = 1, position = 'icon' WHERE ".
				"module = 'mod_quickicon_gmapfp' ");
			$db->query();
	
	
			$this->affiche_bienvenue(1);

			// $parent is the class calling this method
			//$parent->getParent()->setRedirectURL('index.php?option=com_gmapfp');
        }
 
        /**
         * method to uninstall the component
         * @return void
         */
        function uninstall($parent) 
        {
				$db =& JFactory::getDBO();
				$query = 'DELETE FROM #__menu
				WHERE menutype = "menu" and path LIKE "gmapfp%"
				';
				$db->setQuery($query);
				$db->query();
				if ($db->getErrorNum()) {
					exit($db->stderr());
				}
                // $parent is the class calling this method
                echo '<p>' . JText::_('COM_GMAPFP_UNINSTALL_TEXT') . '</p>';
        }
 
        /**
         * method to update the component
         *
         * @return void
         */
        function update($parent) 
        {
			/***********************************************************************/
			/* Suppression des fichier xml supplémentaire des versions précédentes */
			/***********************************************************************/
			$path = JPATH_SITE.DS.'components'.DS.'com_gmapfp'.DS.'views'.DS;
	
			$file = $path.'gmapfp'.DS.'tmpl'.DS.'categorie.xml';
			if (JFile::exists($file)) JFile::delete($file);
	
			$file = $path.'gmapfplist'.DS.'tmpl'.DS.'categorie.xml';
			if (JFile::exists($file)) JFile::delete($file);
			
                // $parent is the class calling this method
			$this->affiche_bienvenue(0);
        }
 
		function affiche_bienvenue($install) {
			if ($install == 1) {
				echo "<h1>GMapFP Installation</h1>";
			}else{
				echo "<h1>GMapFP Mise &agrave; jour</h1>";
			};
			?>
			<p>Bienvenue sur GMapFP v<?php echo $this->_version_num?> !<br/>
			Avant de commencer, je vous invite, si ce n'est pas d&eacute;j&agrave; fait, &agrave; d&eacute;couvrir toutes les possibilit&eacute;s de se composant et de son ou ses plugins sur son <a target="_blank" href="http://gmapfp.org/fr">Site officiel</a>.<br />
			Vous pourrez y <a target="_blank" href="http://gmapfp.org/fr/telechargement">t&eacute;l&eacute;charger</a> les mise &agrave; jours et consulter le <a target="_blank" href="http://gmapfp.org/fr/forum"> forum</a>.</p>
			<p>Bonne continuation avec GMapFP</p>
			<br />
			<br />
			<br />
			<?php
			if ($install == 1) {
				echo "<h1>GMapFP Installation</h1>";
			}else{
				echo "<h1>GMapFP Upgrade</h1>";
			};
			?>
			<p>Welcome on v<?php echo $this->_version_num?> GMapFP !<br/>
			Before starting, I invite you, if this isn't already made, to discovery all the possibilities of this component and thisd plugin on its <a target="_blank" href="http://www.gmapfp.org/en">Official Site</a>.<br />
			You will be able there to <a target="_blank" href="http://gmapfp.org/en/download">download</a> the update and consult the <a target="_blank" href="http://gmapfp.org/en/forum"> forum</a>.</p>
			<p>Good continuation with GMapFP</p>
			<?php
        }
        /**
         * method to run after an install/update/uninstall method
         *
         * @return void
         */
        function postflight($type, $parent)
        {
			// $parent is the class calling this method
			// $type is the type of change (install, update or discover_install)
			if ($type == 'install') {
				$path = JPATH_SITE;
				@mkdir(JPATH_ROOT."/images/contactmap/");
		
				$db =& JFactory::getDBO();
				/*mise à jour des paramètres par défaut*/
				$query = 'UPDATE #__extensions SET params=\'{
		"gmapfp_key":"ABQIAAAAcEZn1vHlVvva7WO7a3CUehQjCtINlCvJ7COPeUiQv_3BHZVK7BRb25ZmrvvziTKWf4cHMkU168y2Zg",
		"gmapfp_height":"500",
		"gmapfp_width":"100%",
		"gmapfp_auto":"1",
		"gmapfp_centre_lng":"2.1391367912",
		"gmapfp_centre_lat":"47.927644470",
		"gmapfp_auto_zoom":"0",
		"gmapfp_zoom":"2",
		"gmapfp_zoom":"10",
		"gmapfp_itineraire":"1",
		"gmapfp_filtre":"1",
		"gmapfp_msg":"1",
		"gmapfp_typecontrol":"1",
		"gmapfp_normal":"1",
		"gmapfp_satellite":"1",
		"gmapfp_hybrid":"1",
		"gmapfp_physic":"1",
		"gmapfp_earth":"1",
		"gmapfp_choix_affichage_carte":"1",
		"gmapfp_mapcontrol":"1",
		"gmapfp_scalecontrol":"1",
		"gmapfp_mousewheel":"1",
		"gmapfp_zzoom":"1",
		"gmapfp_eventcontrol":"1",
		"gmapfp_plus_detail":"1",
		"target":"0",
		"gmapfp_hauteur_lightbox":"400",
		"gmapfp_largeur_lightbox":"700",
		"gmapfp_plus_info":"1",
		"gmapfp_url_wiki":"org.wikipedia.fr",
		"gmapfp_afficher_horaires_prix":"1",
		"gmapfp_afficher_intro_italique":"1",
		"gmapfp_chemin_img":"\/images\/gmapfp\/",
		"gmapfp_hauteur_img":"100",
		"gmapfp_width_bulle_GMapFP":"400",
		"gmapfp_taille_bulle_cesure":"200",
		"gmapfp_geoXML":"",
		"gmapfp_news":"1",
		"gmapfp_licence":"1"}\' WHERE name=\'com_gmapfp\'';
				$db->setQuery($query);
				$db->query();
				if ($db->getErrorNum()) {
					exit($db->stderr());
				}
	
			}
			
			//@mail('webmaster@gmapfp.org','GMapFP v'.$this->_version_num.' '.$type,$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'],'From:webmaster@gmapfp.org');
			//echo '<p>' . JText::_('COM_GMAPFP_POSTFLIGHT_' . $type . '_TEXT') . '</p>';
        }
}