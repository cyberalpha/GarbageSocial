<?php 
	/*
	* GMapFP Component Google Map for Joomla! 2.5.x
	* Version 9.30
	* Creation date: Janvier 2013
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die('Restricted access'); 

$height_msg = '500px';
$width_msg = '400px';

//fonction pour execution des plugins dans la personnalisation
$dispatcher =& JDispatcher::getInstance(); 
JPluginHelper::importPlugin('content'); 

?>
<?php if ($this->params->get('show_page_title', 1)) : ?>
<div class="componentheading<?php echo $this->params->get('pageclass_sfx');?>">
	<?php echo $this->escape($this->params->get('page_title')); ?>
</div>
<?php endif; 
if ($this->params->get('gmapfp_filtre')==1) :
$itemid = JRequest::getVar('Itemid', 0, '', 'int');
$perso = JRequest::getVar('id_perso', 0, '', 'int');
?>
<form action="<?php echo JRoute::_('index.php?option=com_gmapfp&view=gmapfp&id_perso='.$perso.'&Itemid='.$itemid); ?>" method="post" name="adminForm">
    <table  class="gmapfpform">
        <tr>
            <td width="60%">
                <?php echo JText::_( 'GMAPFP_FILTER' ); ?>:
                <input type="text" size="20" name="search_gmapfp" id="search_gmapfp" value="<?php echo $this->lists['search_gmapfp'];?>" class="text" onchange="document.adminForm.submit();"/>
                <button onclick="this.form.submit();"><?php echo JText::_( 'GMAPFP_GO_FILTER' ); ?></button>
                <button onclick="
                	document.getElementById('search_gmapfp').value='';
                    <?php if (@$this->lists['ville']) {?>document.adminForm.filtreville.value='-- <?php echo JText::_( 'GMAPFP_VILLE_FILTRE' ) ?> --'; <?php };?>
                    <?php if (@$this->lists['departement']) {?>document.adminForm.filtredepartement.value='-- <?php echo JText::_( 'GMAPFP_DEPARTEMENT_FILTRE' ) ?> --'; <?php };?>
                    <?php if (@$this->lists['pays']) {?>document.adminForm.filtrepays.value='-- <?php echo JText::_( 'GMAPFP_PAYS_FILTRE' ) ?> --'; <?php };?>
                    <?php if (@$this->lists['categorie']) {?>document.adminForm.filtrecategorie.value='-- <?php echo JText::_( 'GMAPFP_CATEGORIE_FILTRE' ) ?> --'; <?php };?>
                    this.form.submit();
                "><?php echo JText::_( 'GMAPFP_RESET' ); ?>
                </button>
            </td>
            <td width="40%">
                <?php
                if (@$this->lists['ville']) {echo $this->lists['ville'].'<br />';};
                if (@$this->lists['departement']) {echo $this->lists['departement'].'<br />';};
                if (@$this->lists['pays']) {echo $this->lists['pays'].'<br />';};
                if (@$this->lists['categorie']) {echo $this->lists['categorie'].'<br />';};
                ?>
                <br />
            </td>
        </tr>
    </table>
</form>
<?php endif; ?>
<div style="overflow: auto;">
<?php if ((($this->params->get('type_affichage'))==0)||(($this->params->get('type_affichage'))==2)) : 
	echo $this->map;
endif;
?>
</div>
<?php 
if (isset($this->perso->intro_detail)) {
	$article = new stdClass();
	$article->text=@$this->perso->intro_detail; 
        $results = $dispatcher->trigger('onPrepareContent', array (& $article, & $this->params, 0)); 
	echo $article->text;
}
?>
<table class="blog<?php echo $this->params->get('pageclass_sfx');?> gmapfp" cellpadding="0" cellspacing="0">
<?php
 
if (($this->params->get('type_affichage')<>2)&&($this->params->get('nombre_articles'))) : ?>
        <tr>
            <td valign="top">
            <?php for ($i = $this->pagination->limitstart; $i < ($this->pagination->limitstart + $this->params->get('nombre_articles')); $i++) : 
                if ($i >= $this->total) : break; endif;
                $this->lieu = $this->lieux[$i];
				//affichage du détail d'un lieu
				$this->_layout='tmpl';
				echo JView::Display('article');
				$this->_layout='default';
            endfor;
?>
			</td>
		</tr>
<?php else : $i = $this->pagination->limitstart; endif; ?>
</table>

<?php if (($this->params->get('show_pagination') or $this->params->get('show_pagination_results'))&&(($this->params->get('type_affichage'))<>2)) : ?>
    <div class="pagination">
		<?php 
            if ($this->params->get('show_pagination_results'))
                echo '<p class="counter">'.$this->pagination->getPagesCounter().'</p>';
            if ($this->params->get('show_pagination'))
                echo $this->pagination->getPagesLinks(); ?>
        <br /><br />
    </div>
<?php endif; ?>
<?php
if (isset($this->perso->conclusion_detail)) {
	$article = new stdClass();
	$article->text=@$this->perso->conclusion_detail; 
	$results = $dispatcher->trigger('onPrepareContent', array (& $article, & $this->params, 0)); 
	echo $article->text;
}
?>
<div style="overflow: auto;">
<?php if (($this->params->get('type_affichage'))==1) : 
	echo $this->map;
endif;
?>
</div>

<?php if (($this->params->get('gmapfp_licence')) || (!COM_GMAPFP_PRO)): ?>
<div class="copyright" align="center">
	<br />
	<?php echo JText::_( 'GMapFP - <a href="http://gmapfp.org">gmapfp.org</a>' );?>
</div>
<?php endif; ?>
