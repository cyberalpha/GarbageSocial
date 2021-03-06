<?php 
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.12
	* Creation date: Mars 2012
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die('Restricted access'); ?>

<link rel="stylesheet" href="components/com_gmapfp/views/general.css" type="text/css" /> 
<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		// do field validation
		if (form.nom.value == "") {
			alert( "<?php echo JText::_( 'GMAPFP_NOM_NON_VIDE', true ); ?>" );
		} else {
			submitform( pressbutton );
		}
	}
</script>

<form action="index.php" method="post" name="adminForm" id="adminForm" class="gmapfp">
<div>
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'GMAPFP_DETAILS' ); ?></legend>
	<table class="admintable">
		<tr>
			<td width="110" class="key">
				<label for="title">
					<?php echo JText::_( 'GMAPFP_NOM' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="nom" id="nom" size="60" value="<?php echo $this->marqueurs->nom; ?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<label for="lag">
					<?php echo JText::_( 'GMAPFP_URL' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="url" id="url" size="60" value="<?php echo $this->marqueurs->url; ?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<label for="lag">
					<?php echo JText::_( 'GMAPFP_APERCU' ); ?>:
				</label>
			</td>
			<td>
				<img src="<?php echo $this->marqueurs->url; ?>" title="<?php echo $this->marqueurs->nom; ?>" /> 				<?php echo JText::_( 'GMAPFP_ACTUALISER' ); ?>
			</td>

		</tr>
		<tr>
			<td width="120" class="key">
				<?php echo JText::_( 'JPUBLISHED' ); ?>:
			</td>
			<td>
				<?php echo JHTML::_( 'select.booleanlist',  'published', 'class="inputbox"', $this->marqueurs->published ); ?>
			</td>
		</tr>
	</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_gmapfp" />
<input type="hidden" name="id" value="<?php echo $this->marqueurs->id; ?>" />
<input type="hidden" name="task" value="edit" />
<input type="hidden" name="controller" value="marqueurs" />
</form>
<div class="copyright" align="center">
	<br />
	<?php echo JText::_( 'GMAPFP_COPYRIGHT' );?>
</div>
