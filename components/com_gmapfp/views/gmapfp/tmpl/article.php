<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.0.beat1
	* Creation date: Mai 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die('Restricted access'); 

$mainframe = &JFactory::getApplication(); 

$height_msg = '500px';
$width_msg = '400px';

$config =& JComponentHelper::getParams('com_gmapfp');
$document   =& JFactory::getDocument();

foreach ($this->lieux as $lieu) { 

// insertion du lien canonique pour éviter l'indexation par les robbots des lien comporant le "tmpl=component"
    $link =JRoute::_('index.php?option=com_gmapfp&view=gmapfp&layout=article&id='.$lieu->slug, false);
    $document->addCustomTag( '<link rel="canonical" href="'.$link.'" />');


    if ($lieu->metadesc) {
        $this->document->setDescription( $lieu->metadesc );
    }
    if ($lieu->metakey) {
        $this->document->setMetadata('keywords', $lieu->metakey);
    }
    if ($mainframe->getCfg('MetaTitle') == '1') {
        $this->document->setTitle(@$lieu->ville.' : '.$lieu->nom.' ('.$lieu->title.')');
    }
?>
    <div id="enregistrement">
    	<?php
        	$this->lieu = $lieu;
			//affichage du détail d'un lieu
			$this->_layout='tmpl';
			echo JView::Display('article');
			$this->_layout='default';
		?>
        <div class="gmapfp_message">
            <table>
                <tr>
                    <td>
                    <?php
                    if ($config->get('gmapfp_afficher_intro_italique')==1) { ?>
                        <span><em><?php echo $lieu->intro; ?></em><?php echo $lieu->message; ?></span><?php ;
                    } else { ?>
                        <span><?php echo $lieu->intro; echo $lieu->message; ?></span><?php ;
                    }?>
                     <br />
                     <br />
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <?php
    //insertion de JComments
      $jcomments =  JPATH_SITE.'/components/com_jcomments/jcomments.php';
      if ((file_exists($jcomments))and($this->params->get('gmapfp_jcomments'))) {
        require_once($jcomments);
        echo '<div style="clear: both;">';
        echo JComments::showComments($lieu->id, 'com_gmapfp', $lieu->nom);
        echo '</div>';
      }
}; ?>
