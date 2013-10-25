<?php
	/*
	* GMapFP Plugin Google Map for Joomla! 1.6.x
	* Version 4.0.8
	* Creation date: Février 2012
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*
	* Version php >= 5.1.0
	*/
	
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');
	
	require_once( JPATH_SITE.DS.'components'.DS.'com_gmapfp'.DS.'models'.DS.'gmapfp.php' );
	
	class plgContentGMapFP extends JPlugin
	{
		function plgContentGMapFP(&$subject)
		{
			parent::__construct($subject);
			$this->variables = array();
		}
		
		public function onContentPrepare($context, &$article, &$params, $limitstart)
		{
			$app = JFactory::getApplication('site');
			if ($app->isSite() and preg_match_all('/{gmapfp(.*?)}/', $article->text, $matches)) {
				$cnt = 1;
				
				$model = new GMapFPsModelGMapFP();
				if (is_file(JPATH_SITE.'/components/com_gmapfp/constantes.php'))
					include JPATH_SITE.'/components/com_gmapfp/constantes.php';
				else
					include JPATH_PLUGINS.'/content/gmapfp/constantes.php';
						
				foreach($matches[0] as $matche) {
				
					preg_match('/hmap="[[:digit:]]*"/', $matche, $Hmap);
					preg_match('/lmap="[[:digit:]]*"/', $matche, $Lmap);
					preg_match('/zmap="[[:digit:]]*"/', $matche, $Zmap);
					preg_match('/itin="[[:digit:]]*"/', $matche, $Itin);
					preg_match('/bar_psm="[[:digit:]]*"/', $matche, $bar_PSM);
					preg_match('/bar_z_nav="[[:digit:]]*"/', $matche, $bar_z_nav);
					preg_match('/ech="[[:digit:]]*"/', $matche, $Ech);
					preg_match('/click_over="[[:digit:]]*"/', $matche, $click_over);
					preg_match('/zzoom="[[:digit:]]*"/', $matche, $ZZoom);
					preg_match('/mzoom="[[:digit:]]*"/', $matche, $MZoom);
					preg_match('/map_phy="[[:digit:]]*"/', $matche, $map_phy);
					preg_match('/map_nor="[[:digit:]]*"/', $matche, $map_nor);
					preg_match('/map_sat="[[:digit:]]*"/', $matche, $map_sat);
					preg_match('/map_hyb="[[:digit:]]*"/', $matche, $map_hyb);
					preg_match('/map_choix="[[:digit:]]*"/', $matche, $map_choix);
					preg_match('/map_earth="[[:digit:]]*"/', $matche, $map_earth);
					preg_match('/map_centre_lng="[0-9.-]*"/', $matche, $map_centre_lng);
					preg_match('/map_centre_lat="[0-9.-]*"/', $matche, $map_centre_lat);
					preg_match('/kml_file="(.*?)"/', $matche, $kml_file);
					preg_match('/more="[[:digit:]]*"/', $matche, $More);
					preg_match('/map_centre_id="[0-9.]*"/', $matche, $map_centre_id);
					preg_match('/where="(.*?)"/', $matche, $where);

					$Hmap=str_replace('hmap=','',$Hmap);
					$Lmap=str_replace('lmap=','',$Lmap);
					$Zmap=str_replace('zmap=','',$Zmap);
					$Itin=str_replace('itin=','',$Itin);
					$bar_PSM=str_replace('bar_psm=','',$bar_PSM);
					$bar_z_nav=str_replace('bar_z_nav=','',$bar_z_nav);
					$Ech=str_replace('ech=','',$Ech);
					$click_over=str_replace('click_over=','',$click_over);
					$ZZoom=str_replace('zzoom=','',$ZZoom);
					$MZoom=str_replace('mzoom=','',$MZoom);
					$map_phy=str_replace('map_phy=','',$map_phy);
					$map_nor=str_replace('map_nor=','',$map_nor);
					$map_sat=str_replace('map_sat=','',$map_sat);
					$map_hyb=str_replace('map_hyb=','',$map_hyb);
					$map_choix=str_replace('map_choix=','',$map_choix);
					$kml_file=str_replace('kml_file=','',$kml_file);
					$map_earth=str_replace('map_earth=','',$map_earth);
					$map_centre_lng=str_replace('map_centre_lng=','',$map_centre_lng);
					$map_centre_lat=str_replace('map_centre_lat=','',$map_centre_lat);
					$More=str_replace('more=','',$More);
					$map_centre_id=str_replace('map_centre_id=','',$map_centre_id);
					$where=str_replace('where=','',$where);
				
					$Hmap=str_replace('"','',$Hmap);
					$Lmap=str_replace('"','',$Lmap);
					$Zmap=str_replace('"','',$Zmap);
					$Itin=str_replace('"','',$Itin);
					$bar_PSM=str_replace('"','',$bar_PSM);
					$bar_z_nav=str_replace('"','',$bar_z_nav);
					$Ech=str_replace('"','',$Ech);
					$click_over=str_replace('"','',$click_over);
					$MZoom=str_replace('"','',$MZoom);
					$ZZoom=str_replace('"','',$ZZoom);
					$map_phy=str_replace('"','',$map_phy);
					$map_nor=str_replace('"','',$map_nor);
					$map_sat=str_replace('"','',$map_sat);
					$map_hyb=str_replace('"','',$map_hyb);
					$map_choix=str_replace('"','',$map_choix);
					$kml_file=str_replace('"','',$kml_file);
					$kml_file=str_replace('&amp;','&',$kml_file);
					$map_earth=str_replace('"','',$map_earth);
					$map_centre_lng=str_replace('"','',$map_centre_lng);
					$map_centre_lat=str_replace('"','',$map_centre_lat);
					$More=str_replace('"','',$More);
					$map_centre_id=str_replace('"','',$map_centre_id);
					$where=str_replace('"','',$where);
				
					if ((preg_match_all('/\bid\b="[[:digit:]]*"/', $matche, $ids))or(preg_match_all('/catid="[[:digit:]]*"/', $matche, $catids))) 
					{

						if (preg_match_all('/\bid\b="[[:digit:]]*"/', $matche, $ids)) {
							foreach($ids as $id)
							{
							$id = str_replace('id=','',$id);
							$id = str_replace('"','',$id);
							};
						}else{
							$id = 0;
						};

						if (preg_match_all('/catid="[[:digit:]]*"/', $matche, $catids)) {
							foreach($catids as $catid)
							{
							$catid = str_replace('catid=','',$catid);
							$catid = str_replace('"','',$catid);
							};
						}else{
							$catid = 0;
						};
					
						if (empty ($Hmap[0])) {$Hmap[0]='';};
						if (empty ($Lmap[0])) {$Lmap[0]='';};
						if (empty ($Zmap[0])) {$Zmap[0]='';};
						if (empty ($Itin[0])) {$Itin[0]='';};
						if (empty ($bar_PSM[0])) {$bar_PSM[0]='';};
						if (empty ($bar_z_nav[0])) {$bar_z_nav[0]='';};
						if (empty ($Ech[0])) {$Ech[0]='';};
						if (empty ($click_over[0])) {$click_over[0]='';};
						if (empty ($MZoom[0])) {$MZoom[0]='';};
						if (empty ($ZZoom[0])) {$ZZoom[0]='';};
						if (empty ($map_phy[0])) {$map_phy[0]='';};
						if (empty ($map_nor[0])) {$map_nor[0]='';};
						if (empty ($map_sat[0])) {$map_sat[0]='';};
						if (empty ($map_hyb[0])) {$map_hyb[0]='';};
						if (empty ($map_choix[0])) {$map_choix[0]='';};
						if (empty ($kml_file[0])) {$kml_file[0]='';};
						if (empty ($map_earth[0])) {$map_earth[0]='';};
						if (empty ($map_centre_lng[0])) {$map_centre_lng[0]='';};
						if (empty ($map_centre_lat[0])) {$map_centre_lat[0]='';};
						if (empty ($More[0])) {$More[0]='';};
						if (empty ($map_centre_id[0])) {$map_centre_id[0]='';};
						if (empty ($where[0])) {$where[0]='';};
					
					$map = $model->getViewPlugin($id, $article->id.'_'.$cnt, $Hmap[0], $Lmap[0], $Zmap[0], $Itin[0], $bar_PSM[0], $bar_z_nav[0], $Ech[0], $click_over[0], $MZoom[0], $ZZoom[0], $map_phy[0], $map_nor[0], $map_sat[0], $map_hyb[0], $map_choix[0], $kml_file[0], $map_earth[0], $map_centre_lng[0], $map_centre_lat[0], $catid, $More[0],$map_centre_id[0],$where[0]);
	
					$article->introtext=str_replace($matche, $map, $article->introtext);
					if (property_exists($article, 'fulltext'))
					$article->fulltext=str_replace($matche, $map, $article->fulltext);
					if (property_exists($article, 'text'))
					$article->text=str_replace($matche, $map, $article->text);

					$cnt++;
					};
				}
			}		
			return true;	
		}
	
	}
?>