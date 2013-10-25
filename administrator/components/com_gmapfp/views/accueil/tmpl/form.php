<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.26
	* Creation date: Décembre 2012
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die('Restricted access');
JHTML::_( 'behavior .modal' );

$mainframe = &JFactory::getApplication(); 
$lang		=& JFactory::getLanguage();
$template	= $mainframe->getTemplate();

$langue		=substr((@$lang->getTag()),0,2);
if ($langue!='fr') $langue = 'en';

$user	= & JFactory::getUser();
?>

<table class="admintable">
    <tr>
        <td width="55%" valign="top" colspan="2">
            <div id="cpanel">
                <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
                    <div class="icon">
                        <a class="modal" href="index.php?option=com_config&view=component&component=com_gmapfp&path=&tmpl=component" rel="{handler: 'iframe', size: {x: 875, y: 550}, onClose: function() {}}">
                            <?php echo JHTML::_('image.site',  'icon-48-config.png', '/templates/'. $template .'/images/header/'); ?>
                            <span><?php echo JText::_('GMAPFP_PARAMETRES'); ?></span>
                        </a>
                    </div>
                </div>
                <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
                    <div class="icon">
                        <a href="index.php?option=com_gmapfp&controller=gmapfp&task=view">
                            <?php echo JHTML::_('image.site',  'icon-48-language.png', '/templates/'. $template .'/images/header/'); ?>
                            <span><?php echo JText::_('GMAPFP_LIEUX'); ?></span>
                        </a>
                    </div>
                </div>
                <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
                    <div class="icon">
                        <a href="index.php?option=com_gmapfp&controller=marqueurs&task=view">
                            <?php echo JHTML::_('image.site',  'icon-48-banner.png', '/templates/'. $template .'/images/header/'); ?>
                            <span><?php echo JText::_('GMAPFP_MARQUEURS'); ?></span>
                        </a>
                    </div>
                </div>
                <?php /*
                <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
                    <div class="icon">
                        <a href="index.php?option=com_gmapfp&controller=photos&task=view">
                            <?php echo JHTML::_('image.site',  'icon-48-media.png', '/templates/'. $template .'/images/header/', NULL, NULL, $text ); ?>
                            <span><?php echo JText::_('GMAPFP_PHOTOS'); ?></span>
                        </a>
                    </div>
                </div>*/ ?>
                <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
                    <div class="icon">
                        <a href="index.php?option=com_categories&extension=com_gmapfp">
                            <?php echo JHTML::_('image.site',  'icon-48-category.png', '/templates/'. $template .'/images/header/'); ?>
                            <span><?php echo JText::_('JCATEGORIES'); ?></span>
                        </a>
                    </div>
                </div>
                <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
                    <div class="icon">
                        <a href="index.php?option=com_gmapfp&controller=personnalisations&task=view">
                            <?php echo JHTML::_('image.site',  'icon-48-article.png', '/templates/'. $template .'/images/header/'); ?>
                            <span><?php echo JText::_('GMAPFP_PERSONNALISATION'); ?></span>
                        </a>
                    </div>
                </div>
                <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
                    <div class="icon">
                        <a href="index.php?option=com_gmapfp&controller=css&task=view">
                            <?php echo JHTML::_('image.site',  'icon-48-themes.png', '/templates/'. $template .'/images/header/'); ?>
                            <span>CSS</span>
                        </a>
                    </div>
                </div>
                <div>
                	<p>
					<script type="text/javascript">
                        <!--
						google_ad_client = "pub-0014544965086912";
						/* 728x90, date de création 03/07/10 */
						google_ad_slot = "3604075384";
						google_ad_width = 108;
						google_ad_height = 97;                        //-->
                    </script>
                    <script type="text/javascript"
                        src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
                    </script>
                    </p>
                </div>
			</div>
    	</td>
		<td width="45%" valign="top">
		<div style="width: 100%">
		<?php
			$tabs	= $this->get('publishedTabs');
			$onglet		=&JPane::getInstance('sliders');
			echo $onglet->startPane("content-pane");
	
			foreach ($tabs as $tab) {
				$title = JText::_($tab->title);
				echo $onglet->startPanel( $title, 'gmapfpcpanel-panel-'.$tab->name );
				$contenu = 'infos_' .$tab->name;
				echo $this->$contenu();
				echo $onglet->endPanel();
			}
	
			echo $onglet->endPane();

		 ?>
		</div>
		</td>
	</tr>
	<tr>
    	<td>
        	<table class="admintable">
            	<tr>
                    <td class="key">
                        <?php echo JText::_( 'Forum' );?>
                    </td>
                    <td>
                        <a href="http://www.gmapfp.org/<?php echo $langue; ?>/forum" target="_new">www.gmapfp.org/<?php echo $langue; ?>/forum</a>
                    </td>
                </tr>
                <tr>
                    <td class="key">
                        <?php echo JText::_( 'GMAPFP_DOCUMENTATION' );?>
                    </td>
                    <td>
                        <a href="http://www.gmapfp.org/<?php if ($langue=="fr") {echo "fr/telechargement/2---Documentation";} else {echo "en/download/2---Documentation/";}; ?>/documentation" target="_new">www.gmapfp.org/<?php if ($langue=="fr") {echo "fr/telechargement/2---Documentation";} else {echo "en/download/2---Documentation/";}; ?></a>
                    </td>
                </tr>
            	<tr>
                    <td class="key">
                    	<?php echo '<h1 style="color:red;">'.JText::_( 'GMAPFP_DISCOVER_PRO_VERSION' ).' : '.'</h1>'; ?>
                    </td>
                    <td>
                        <a href="http://pro.gmapfp.org/<?php echo $langue; ?>" target="_new"><?php echo '<h1 style="color:red; text-decoration: underline;">'.JText::_( 'GMapFP Pro' ).'</h1>'; ?></a>
                    </td>
                </tr>
            </table>
    	</td>
   </tr>
</table>
<div class="copyright" align="center">
	<br />
	<?php echo JText::_( 'GMAPFP_COPYRIGHT' );?>
</div>
<div class="clr"></div>

