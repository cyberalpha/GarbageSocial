<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.27
	* Creation date: Décmebre 2012
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die('Restricted access'); 

$height_msg = '400px';
$width_msg = '600px';

$itemid = JRequest::getVar('Itemid', 0, '', 'int');
$layout = JRequest::getVar('layout', '', '', 'str');

$row=$this->lieu;

?>
<table class="blog<?php echo $this->params->get('pageclass_sfx');?>" cellpadding="0" cellspacing="0">
    <tr>
        <td valign="top">
            <table class="gmapfp_detail">
                <tr>
                    <td class="gmapfp_largeur_titre"><h2><?php echo $row->nom; ?></h2></td>
                    <?php
						//si affichage d'un article ou d'une catégorie d'article, n'affiche pas le nom de la catégorie
						if (($layout!='article')&&($layout!='categorie')) {
							echo '<td><h4>('.$row->title.')</h4></td><br>';
						};
                    ?>
                </tr>
            </table>
            <table class="gmapfp_detail">
                <tr>
                    <td class="gmapfp_taille1">
                        <?php
                            $image=JURI::base().$this->params->get('gmapfp_chemin_img').$row->img;
                            $clock=JURI::base().'components/com_gmapfp/images/clock_32.png';
                            $globe=JURI::base().'components/com_gmapfp/images/globe_32.png';
                            $printer=JURI::base().'components/com_gmapfp/images/printer.png';
                            $msg=JURI::base().'components/com_gmapfp/images/xfmail.png';
                            $loupe=JURI::base().'components/com_gmapfp/images/recherche.png';
                            if ($row->img!=null) { ?> <a class="lightboxgmafp" href='<?php echo $image; ?>' ><img src=<?php echo $image; ?> height="<?php echo $this->params->get('gmapfp_hauteur_img')?>"/><img src=<?php echo $loupe; ?> height="18px"/></a> <?php }; ?>
                    </td>
                    <td class="gmapfp_taille2">
                        <?php
                        if ($row->adresse!=null) {echo JText::_('GMAPFP_ADRESSE').'<span>'.$row->adresse.'</span><br />';};
                        if ($row->adresse2!=null) {echo JText::_('GMAPFP_ADRESSE').'<span>'.$row->adresse2.'</span><br />';};
                        if ($row->codepostal!=null) {echo JText::_('GMAPFP_CODEPOSTAL').'<span>'.$row->codepostal.'</span><br />';};
                        if ($row->ville!=null) {echo JText::_('GMAPFP_VILLE').'<span>'.$row->ville.'</span><br />';};
                        if ($row->departement!=null) {echo JText::_('GMAPFP_DEPARTEMENT').'<span>'.$row->departement.'</span><br />';};
                        if ($row->pay!=null) {echo JText::_('GMAPFP_PAYS').'<span>'.$row->pay.'</span><br />';};
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($row->tel!=null) {echo JText::_('GMAPFP_TEL').'<span>'.$row->tel.'</span><br />';};
                        if ($row->tel2!=null) {echo JText::_('GMAPFP_TEL').'<span>'.$row->tel2.'</span><br />';};
                        if ($row->fax!=null) {echo JText::_('GMAPFP_FAX').'<span>'.$row->fax.'</span><br />';};
                        if (($row->email!=null)and($this->params->get('gmapfp_msg')==0)) {echo JText::_('GMAPFP_EMAIL').'<span>'.@JHTML::_('email.cloak',$row->email).'</span><br />';};
                        if ($row->web!=null) {
                            if (substr($row->web,0,5)!="http:") {$lien_web = "http://".$row->web;} else {$lien_web = $row->web;};
                            echo JText::_('GMAPFP_SITE_WEB').'<span><a href='.$lien_web.' target="_blank" > '.$row->web.' </a></span> <br />';
                        };
                        if (($row->horaires_prix!=null)&&($this->params->get('gmapfp_afficher_horaires_prix')==1)) {
                            $link =JRoute::_('index.php?option=com_gmapfp&view=gmapfp&tmpl=component&layout=horaires_item&id='.$row->id.'&Itemid='.JRequest::getVar('Itemid', 0, '', 'int'));
                            echo ' <a class="lightboxgmafp" rev="width:550 height:400 disableScroll:true" href="'.$link.'"  title="'.JText::_('GMAPFP_HORAIRES_PRIX').'"><img src='.$clock.' /></a>&nbsp;&nbsp;&nbsp; ';
                        };
                        $width_carte=$this->params->get('gmapfp_width')+17;
                        $link = JRoute::_('index.php?option=com_gmapfp&view=gmapfp&tmpl=component&layout=item_carte&flag=1&id='.$row->id.'&Itemid='.JRequest::getVar('Itemid', 0, '', 'int'));
                        if ($this->params->get('gmapfp_itineraire')==1) {
                            $height_carte=$this->params->get('gmapfp_height')+150;
							if (strpos($this->params->get('gmapfp_width'),'%')){
								$width_carte=600;
							}else{
								$width_carte=$this->params->get('gmapfp_width')+20;
							}
							$scroll='scrolling:auto';
                        }else{
                            $height_carte=$this->params->get('gmapfp_height')+0;
							if (strpos($this->params->get('gmapfp_width'),'%')){
								$width_carte=600;
							}else{
								$width_carte=$this->params->get('gmapfp_width');
							}
							$scroll='scrolling:no';
                        };
                        echo '<a class="lightboxgmafp" rev="width:'.$width_carte.' height:'.$height_carte.' '.$scroll.' controlsPos:br" href="'.$link.'"  title="'.JText::_('GMAPFP_CARTE').'"><img src='.$globe.' /></a>&nbsp;&nbsp;&nbsp;';
                        $link =JRoute::_('index.php?option=com_gmapfp&view=gmapfp&tmpl=component&layout=print_article&flag=1&id='.$row->id.'&Itemid='.JRequest::getVar('Itemid', 0, '', 'int'));
                        echo '<a href="'.$link.'" class="lightboxgmafp" rev="showPrint:true width:'.$width_carte.' height:92% disableScroll:true controlsPos:br" title="'.JText::_('GMAPFP_IMPRIMER').'"><img src='.$printer.' /></a>&nbsp;&nbsp;&nbsp;';
                        if (($row->email!=null)and($this->params->get('gmapfp_msg')==1)) {
                            $link =JRoute::_('index.php?option=com_gmapfp&view=gmapfp&tmpl=component&layout=item_msg&flag=1&id='.$row->id.'&Itemid='.JRequest::getVar('Itemid', 0, '', 'int'));
                            echo '<a href="'.$link.'" class="lightboxgmafp" rev="width:'.$width_msg.' height:'.$height_msg.' scrolling:no controlsPos:br" title="'.JText::_('GMAPFP_DISPLAY_MSG').'"><img src='.$msg.' width="48px"/></a>&nbsp;&nbsp;&nbsp;';
                        };
                        $link4=substr($row->link,0,4);
                        $link5=substr($row->link,0,5);
                        $link9=substr($row->link,0,9);
                        $link10=substr($row->link,0,10);
                        $linkok=0;
                        if ((!empty($row->icon))||(!$row->icon='')) {
                            if (($row->article_slug>=1)&&($row->link)) {
								require_once JPATH_SITE . '/components/com_content/helpers/route.php';
								$linkmap=JRoute::_(ContentHelperRoute::getArticleRoute($row->article_slug, $row->article_id.':'.$row->article_alias, 0));
								$linkmap .= '?&tmpl=component';
                                $linkok=1;
                            };
                            if (($link5=="http:")||($link4=="www.")||($link9=="index.php")) {
                                $linkmap=$row->link;
                                if ($link4=="www.") {$linkmap="http://".$linkmap;};
                                if ($link10=="index.php?") {$linkmap=JURI::base().$linkmap."&tmpl=component";};
                                $linkok=1;
                            };
                            $icon=JURI::base().'administrator/templates/bluestork/images/header/'.$row->icon;
                        };
                        if (($linkok)&&($row->icon<>'')) {
                            echo '<a href="'.$linkmap.'" class="lightboxgmafp" rev="width:80% height:80% disableScroll:true controlsPos:br" title="'.$row->icon_label.'"><img src='.$icon.' /></a>&nbsp;&nbsp;&nbsp;';
                        };

						if ($layout!='article') :
                        // insertion de l'icon JComments
                        $jcomments =  JPATH_SITE.'/components/com_jcomments/jcomments.php';
                        if ((file_exists($jcomments))and($this->params->get('gmapfp_jcomments'))) {
                            $icon_jcomment=JURI::base().'administrator/components/com_jcomments/assets/icon-48-jcomments.png';
                            $link =JRoute::_('index.php?option=com_gmapfp&view=gmapfp&tmpl=component&layout=jcomment_item&id='.$row->id.'&Itemid='.JRequest::getVar('Itemid', 0, '', 'int'));
                            echo '<a class="lightboxgmafp" rev="width:600 height:600 disableScroll:true" href="'.$link.'"  title="'.JText::_('GMAPFP_JCOMMENT').'"><img src='.$icon_jcomment.' /></a>';
                            require_once($jcomments);
                            echo JComments::getCommentsCount($row->id, 'com_gmapfp');
                        }
                        ?>
                    </td>
                </tr>
            </table>
            <table class="gmapfp_article">
                <tr>
                    <td>
                        <?php
                        if ($row->intro!=null) {echo JText::_('GMAPFP_MESSAGE').'<span>'.$row->intro.'</span>';};
                        if ($row->message!=null) {
                            $link =JRoute::_('index.php?option=com_gmapfp&view=gmapfp&layout=article&flag=1&id='.$row->id.'&Itemid='.JRequest::getVar('Itemid', 0, '', 'int'));
                            $link_component =JRoute::_('index.php?option=com_gmapfp&view=gmapfp&tmpl=component&layout=article&flag=1&id='.$row->id.'&Itemid='.JRequest::getVar('Itemid', 0, '', 'int'));
	switch ($this->params->get('target'))
	{
		case 1:
			// open in parent avec navigation
			$cible = '<a href="'.$link.'" target="_parent">'.JText::_('GMAPFP_LIRE_SUITE').'</a>';
			break;
		case 2:
			// open in nouvelle fenêtre avec barre de navigation
			$cible = '<a href="'.$link.'" target="_blank">'.JText::_('GMAPFP_LIRE_SUITE').'</a>';
			break;
		case 3:
			// open in a popup window
			$cible = '<a href=\'javascript:void(window.open("'.$link.'", "'.$row->alias.'", "toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes");)\'>'.JText::_('GMAPFP_LIRE_SUITE').'</a>';
			$cible = '<a href="javascript:void(0);" onclick="window.open(\''.$link.'\', \''.$row->alias.'\', \'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes\')">'.JText::_('GMAPFP_LIRE_SUITE').'</a>';
			//$cible = '<a href="javascript:void(0);" onclick="alert(\'toto\')">'.JText::_('GMAPFP_LIRE_SUITE').'</a>';
			break;
		default:
			// open in lightbox
			$cible ='<a class="lightboxgmafp" rev="width:650 height:500 disableScroll:true controlsPos:br" href="'.$link_component.'">'.JText::_('GMAPFP_LIRE_SUITE').'</a>';
			break;
	}
                            echo '<br />';
                            echo '<p class="readmore">'.$cible.'</p>';
                        }; ?>
                        <br />
                        <br />
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>