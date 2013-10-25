<?php
defined('_JEXEC') or die;
JHTML::_('behavior.tooltip');
echo '<div class="phoca-adminform">'
	.'<form action="index.php" method="post" name="adminForm">'
	.'<div style="float:right;margin:10px;">'
	. JHTML::_('image', 'administrator/components/com_phocamaps/assets/images/logo-phoca.png', 'Phoca.cz' )
	.'</div>'
	. JHTML::_('image', 'administrator/components/com_phocamaps/assets/images/logo.png', 'Phoca.cz')
	.'<h3>'.JText::_('COM_PHOCAMAPS_PHOCA_MAPS').' - '. JText::_('COM_PHOCAMAPS_INFORMATION').'</h3>';
	//.'<h3>'. JText::_('COM_phocamaps_INFORMATION').'</h3>';

echo '<h3>'.  JText::_('COM_PHOCAMAPS_HELP').'</h3>';

echo '<p>'
.'<a href="http://www.phoca.cz/phocamaps/" target="_blank">Phoca Maps Main Site</a><br />'
.'<a href="http://www.phoca.cz/documentation/" target="_blank">Phoca Maps User Manual</a><br />'
.'<a href="http://www.phoca.cz/forum/" target="_blank">Phoca Maps Forum</a><br />'
.'</p>';

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
<p>Maps are created by Google Maps™<br />
<p>Google™ is a trademark of <a href="http://www.google.com" target="_blank">Google Inc.</a><br />Google Maps™ is a trademark of <a href="http://www.google.com" target="_blank">Google Inc.</a></p>
<?php

echo '<input type="hidden" name="task" value="" />'
.'<input type="hidden" name="option" value="com_phocamaps" />'
.'<input type="hidden" name="controller" value="phocamapsinfo" />'
.'</form>';

echo '<p>&nbsp;</p>';

echo '<div style="border-top:1px solid #eee"></div>'
.'<div id="pg-update"><a href="http://www.phoca.cz/version/index.php?phocamaps='.  $this->tmpl['version'] .'" target="_blank">'.  JText::_('COM_PHOCAMAPS_CHECK_FOR_UPDATE') .'</a></div>';

echo '<div style="margin-top:30px;height:39px;background: url(\''.JURI::base(true).'/components/com_phocamaps/assets/images/line.png\') 100% 0 no-repeat;">&nbsp;</div>';


echo '</div>';