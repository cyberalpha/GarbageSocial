<?php
    /*
    * Module GMapFP for Component Google Map for Joomla! 1.5.x
    * Version J17V1.2Pro
    * Creation date: Novembre 2012
    * Author: Fabrice4821 - www.gmapfp.org
    * Author email: webmaster@gmapfp.org
    * License GNU/GPL
    */

// no direct access
defined('_JEXEC') or die('Restricted access'); 

//Insertion des entêtes GMapFP si non déjà fait.
if (!defined( '_JOS_GMAPFP_CSS' ))
{
    /** verifi que la fonction n'est défini qu'une faois */
    define( '_JOS_GMAPFP_CSS', 1 );
    
	JHtml::_('stylesheet', JURI::base().'components/com_gmapfp/views/gmapfp/gmapfp.css', array(), true);
	JHtml::_('stylesheet', JURI::base().'components/com_gmapfp/views/gmapfp/gmapfp2.css', array(), true);
}

if (!defined( '_JOS_GMAPFP_LIGHTBOX' ))
{
    /** verifi que la fonction n'est défini qu'une faois */
    define( '_JOS_GMAPFP_LIGHTBOX', 1 );
            
	JHtml::_('stylesheet', JURI::base().'components/com_gmapfp/floatbox/floatbox.css', array(), true);
	JHtml::_('script', JURI::base().'components/com_gmapfp/floatbox/floatbox.js', array(), true);
}
?>
<table width="95%" border="0" cellspacing="0" cellpadding="1" align="center" class="gmapfp<?php echo $moduleclass_sfx; ?>">
<?php foreach($gmapfps as $gmapfp) {?>
    <tr>
        <td>
            <a  class='lightboxgmafp' rev="width:650 height:500 disableScroll:true controlsPos:br" href="<?php echo JRoute::_('index.php?option=com_gmapfp&view=gmapfp&tmpl=component&layout=article&id='.$gmapfp->id) ?>" title="<?php echo JText::_('gmapfp_more_infos') ?>">
                <?php
					if ($gmapfp->img!=null) {echo '<img style="float:left;" src='.JURI::base().'images/gmapfp/'.$gmapfp->img.' height="50px"/>';};
					echo '<label> &nbsp; '.$gmapfp->nom.'</label>'; 
                ?>
            </a>
        </td>
    </tr>
<?php } ?>
</table>
