<?php
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.2
	* Creation date: Août 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

class JFormFieldModal_Article extends JFormField
{
	protected $type = 'Modal_Article';

	protected function getInput()
	{
		JHtml::_('behavior.modal', 'a.modal');

		$script = array();
		$script[] = '	function jSelectArticle(id, nom, object) {';
		$script[] = '		document.getElementById(object + \'_id\').value = id;';
		$script[] = '		document.getElementById(object + \'_name\').value = nom;';
		$script[] = '		SqueezeBox.close();';
		$script[] = '	}';

		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));

		$html	= array();
		$link 	= 'index.php?option=com_gmapfp&amp;controller=element&amp;task=element&amp;tmpl=component&amp;object='.$this->id;

		$db	= JFactory::getDBO();
		$db->setQuery(
			'SELECT nom' .
			' FROM #__gmapfp' .
			' WHERE id = '.(int) $this->value
		);
		$title = $db->loadResult();

		if ($error = $db->getErrorMsg()) {
			JError::raiseWarning(500, $error);
		}

		if (empty($title)) {
			$title = JText::_('JERROR_NO_ITEMS_SELECTED');
		}
		$title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');

		$html[] = '<div class="fltlft">';
		$html[] = '  <input type="text" id="'.$this->id.'_name" value="'.$title.'" disabled="disabled" size="35" />';
		$html[] = '</div>';

		$html[] = '<div class="button2-left">';
		$html[] = '  <div class="blank">';
		$html[] = '	<a class="modal" title="'.JText::_('GMAPFP_SELECT_ARTICLE').'"  href="'.$link.'" rel="{handler: \'iframe\', size: {x: 800, y: 450}}">'.JText::_('JSELECT').'</a>';
		$html[] = '  </div>';
		$html[] = '</div>';

		if (0 == (int)$this->value) {
			$value = '';
		} else {
			$value = (int)$this->value;
		}

		$class = '';
		if ($this->required) {
			$class = ' class="required modal-value"';
		}

		$html[] = '<input type="hidden" id="'.$this->id.'_id"'.$class.' name="'.$this->name.'" value="'.$value.'" />';

		return implode("\n", $html);
	}
}