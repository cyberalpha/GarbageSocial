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

foreach ($this->lieux as $lieu) { ?>
	<h2>
	<?php echo JText::_('GMAPFP_HORAIRES_PRIX'); ?>
    </h2>
	<?php echo $lieu->horaires_prix;
};?>
