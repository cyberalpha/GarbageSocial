<?php defined('_JEXEC') or die('Restricted access');?>

<form action="index.php" method="post" name="adminForm">
<div class="adminform">
<div class="cpanel-left">
			<div id="cpanel">
	<?php
	$component	= 'com_phocamaps';
	$link 		= 'index.php?option=com_phocamaps&view=phocamapsmaps';
	echo PhocaMapsRender::quickIconButton( $component, $link, 'icon-48-map.png', JText::_( 'COM_PHOCAMAPS_MAPS' ) );
	
	$link = 'index.php?option=com_phocamaps&view=phocamapsmarkers';
	echo PhocaMapsRender::quickIconButton( $component, $link, 'icon-48-marker.png', JText::_( 'COM_PHOCAMAPS_MARKERS' ) );
	$link = 'index.php?option=com_phocamaps&view=phocamapsicons';
	echo PhocaMapsRender::quickIconButton( $component, $link, 'icon-48-icon.png', JText::_( 'COM_PHOCAMAPS_ICONS' ) );
	
	$link = 'index.php?option=com_phocamaps&view=phocamapsinfo';
	echo PhocaMapsRender::quickIconButton( $component, $link, 'icon-48-info.png', JText::_( 'COM_PHOCAMAPS_INFO' ) );
	?>

				<div style="clear:both">&nbsp;</div>
				<p>&nbsp;</p>
				<div style="text-align:center;padding:0;margin:0;border:0">
					<iframe style="padding:0;margin:0;border:0" src="http://www.phoca.cz/adv/phocamaps" noresize="noresize" frameborder="0" border="0" cellspacing="0" scrolling="no" width="500" marginwidth="0" marginheight="0" height="125">
					<a href="http://www.phoca.cz/adv/phocamaps" target="_blank">Phoca Maps</a>
					</iframe> 
				</div>
			</div>
		</div>
		
		<div class="cpanel-right">
			<div style="border:1px solid #ccc;background:#fff;margin:15px;padding:15px">
			<div style="float:right;margin:10px;">
				<?php
					echo JHTML::_('image', 'administrator/components/com_phocamaps/assets/images/logo-phoca.png', 'Phoca.cz' )
				?>
			</div>
			
			<?php
			echo '<h3>'.  JText::_('COM_PHOCAMAPS_VERSION').'</h3>'
			.'<p>'.  $this->tmpl['version'] .'</p>';

			echo '<h3>'.  JText::_('COM_PHOCAMAPS_COPYRIGHT').'</h3>'
			.'<p>© 2007 - '.  date("Y"). ' Jan Pavelka</p>'
			.'<p><a href="http://www.phoca.cz/" target="_blank">www.phoca.cz</a></p>';

			echo '<h3>'.  JText::_('COM_PHOCAMAPS_LICENSE').'</h3>'
			.'<p><a href="http://www.gnu.org/licenses/gpl-2.0.html" target="_blank">GPLv2</a></p>';
			
			
			echo '<h3>'.  JText::_('COM_PHOCAMAPS_TRANSLATION').': '. JText::_('COM_PHOCAMAPS_TRANSLATION_LANGUAGE_TAG').'</h3>'
			.'<p>© 2007 - '.  date("Y"). ' '. JText::_('COM_PHOCAMAPS_TRANSLATER'). '</p>'
			.'<p>'.JText::_('COM_PHOCAMAPS_TRANSLATION_SUPPORT_URL').'</p>';
			?>
			<p>&nbsp;</p>
			
			<p>Maps are created by Google Maps™<br />
			<p>Google™ is a trademark of <a href="http://www.google.com" target="_blank">Google Inc.</a><br />Google Maps™ is a trademark of <a href="http://www.google.com" target="_blank">Google Inc.</a></p>
			
			
			<?php
			echo '<div style="border-top:1px solid #c2c2c2"></div>'
.'<div id="pg-update"><a href="http://www.phoca.cz/version/index.php?phocamaps='.  $this->tmpl['version'] .'" target="_blank">'.  JText::_('COM_PHOCAMAPS_CHECK_FOR_UPDATE') .'</a></div>';
			?>
			
			
			</div>
		</div>
	</div>

<input type="hidden" name="option" value="com_phocampas" />
<input type="hidden" name="view" value="phocamapscp" />
<input type="hidden" name="<?php echo JUtility::getToken(); ?>" value="1" />
</form>
