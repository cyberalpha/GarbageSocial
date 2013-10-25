<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.filesystem.folder' );

function com_install() {

	$document			= JFactory::getDocument();
	$document->addStyleSheet(JURI::base(true).'/components/com_phocamaps/assets/phocamaps.css');
	
	$lang = JFactory::getLanguage();
	$lang->load('com_phocamaps.sys');
	$lang->load('com_phocamaps');
	
	$styleInstall = 
	'background: 		url(\''.JURI::base(true).'/components/com_phocamaps/assets/images/btn.png\') repeat-x, url(\''.JURI::base(true).'/components/com_phocamaps/assets/images/bg-install.png\') 10px center no-repeat;
	display: 			inline-block; 
	padding:			15px 30px 15px 50px;
	font-size: 			23px;   
	text-decoration: 	none;
	box-shadow: 		0 1px 2px rgba(0,0,0,0.6);
	-moz-box-shadow: 	0 1px 2px rgba(0,0,0,0.6);
	-webkit-box-shadow: 0 1px 2px rgba(0,0,0,0.6);
	border-radius: 			5px;
	-moz-border-radius: 	5px; 
	-webkit-border-radius: 	5px;
	border-bottom: 		1px solid rgba(0,0,0,0.25);
	position: 			relative;
	cursor: 			pointer;
	text-shadow: 		0 -1px 1px rgba(0,0,0,0.25);
	font-weight: 		bold;
	color: 				#fff;
	background-color: 	#6699cc;';
	
	$styleUpgrade = 
	'background: 		url(\''.JURI::base(true).'/components/com_phocamaps/assets/images/btn.png\') repeat-x, url(\''.JURI::base(true).'/components/com_phocamaps/assets/images/bg-upgrade.png\') 10px center no-repeat;
	display: 			inline-block; 
	padding:			15px 30px 15px 50px;
	font-size: 			23px; 
	text-decoration: 	none;
	box-shadow: 		0 1px 2px rgba(0,0,0,0.6);
	-moz-box-shadow: 	0 1px 2px rgba(0,0,0,0.6);
	-webkit-box-shadow: 0 1px 2px rgba(0,0,0,0.6);
	border-radius: 			5px;
	-moz-border-radius: 	5px; 
	-webkit-border-radius: 	5px;
	border-bottom: 		1px solid rgba(0,0,0,0.25);
	position: 			relative;
	cursor: 			pointer;
	text-shadow: 		0 -1px 1px rgba(0,0,0,0.25);
	font-weight: 		bold;
	color: 				#fff;
	background-color: 	#6699cc;';
	
	$folder[0][0]	=	'phocamapskml' . DS ;
	$folder[0][1]	= 	JPATH_ROOT . DS .  $folder[0][0];
	
	$message = '';
	$error	 = array();
	foreach ($folder as $key => $value)
	{
		if (!JFolder::exists( $value[1]))
		{
			if (JFolder::create( $value[1], 0755 ))
			{

			//	@JFile::write($value[1].DS.".htaccess", "deny from all");
				$data = "<html>\n<body bgcolor=\"#FFFFFF\">\n</body>\n</html>";
				JFile::write($value[1].DS."index.html", $data);
				$message .= '<p><b><span style="color:#009933">Folder</span> ' . $value[0] 
						   .' <span style="color:#009933">created!</span></b></p>';
				$error[] = 0;
			}	 
			else
			{
				$message .= '<p><b><span style="color:#CC0033">Folder</span> ' . $value[0]
						   .' <span style="color:#CC0033">creation failed!</span></b> Please create it manually.</p>';
				$error[] = 1;
			}
		}
		else//Folder exist
		{
			$message .= '<p><b><span style="color:#009933">Folder</span> ' . $value[0] 
						   .' <span style="color:#009933">exists!</span></b></p>';
			$error[] = 0;
		}
	}

	
	
	$message .= '<p>&nbsp;</p><p>Please select if you want to Install or Upgrade Phoca Maps component.</p>'
	.'<p><strong>New Install</strong></p>
<p>If this is a <strong>new installation</strong> of the component, please click <strong>Install</strong> to complete installation. If this is not a new install clicking the <strong>Install</strong> button will remove all component data currently stored in the database (if there have been created some data by previous version of the component).</p>
<p><strong>Upgrade</strong></p>
<p>If this is an <strong>upgrade</strong> of the component, please click <strong>Upgrade</strong> to complete installation. Your existing data will <strong>not</strong> be removed.</p>';
	
	$message .='<p>Maps are created by Google Maps™<br />You need <b>not</b> to sign up for the Google Maps API key because maps are created by API version 3.</p>';
	

	?>
	<div style="padding:15px;background:#fff;color: #777;font-size:105%;">
	
		<a style="text-decoration:none" href="http://www.phoca.cz/" target="_blank"><?php
			echo  JHTML::_('image', 'administrator/components/com_phocamaps/assets/images/logo.png', 'Phoca.cz');
		?></a>
		<div style="position:relative;float:right;">
			<?php echo  JHTML::_('image', 'administrator/components/com_phocamaps/assets/images/logo-phoca.png', 'Phoca.cz');?>
		</div>
		<p>&nbsp;</p>
		<?php echo $message; ?>
		<div style="clear:both">&nbsp;</div>
		<div style="text-align:center"><center><table border="0" cellpadding="20" cellspacing="20">
			<tr>
				
				<td align="center" valign="middle">
					<div id="pg-install"><a style="<?php echo $styleInstall; ?>" href="index.php?option=com_phocamaps&amp;task=phocamapsinstall.install"><?php echo JText::_('COM_PHOCAMAPS_INSTALL'); ?></a></div>
				</td>
				
				<td align="center" valign="middle">
					<div id="pg-upgrade"><a style="<?php echo $styleUpgrade; ?>" href="index.php?option=com_phocamaps&amp;task=phocamapsinstall.upgrade"><?php echo JText::_('COM_PHOCAMAPS_UPGRADE'); ?></a></div>
				</td>
			</tr>
		</table></center></div>
		
		<p>&nbsp;</p><p>&nbsp;</p>
		<p style="color: #c0c0c0;">
		<a href="http://www.phoca.cz/phocamaps/" target="_blank">Phoca Maps Main Site</a><br />
		<a href="http://www.phoca.cz/documentation/" target="_blank">Phoca Maps User Manual</a><br />
		<a href="http://www.phoca.cz/forum/" target="_blank">Phoca Maps Forum</a><br />
		<a href="http://www.phoca.cz/" target="_blank">Phoca.cz</a>
		</p>
		
		<p>Google™ is a trademark of <a href="http://www.google.com" target="_blank">Google Inc.</a><br />Google Maps™ is a trademark of <a href="http://www.google.com" target="_blank">Google Inc.</a></p>
		
		<div style="margin-top:30px;height:39px;background: url('<?php echo JURI::base(true); ?>/components/com_phocamaps/assets/images/line.png') 100% 0 no-repeat;">&nbsp;</div>
		</div>		
<?php	
}
?>