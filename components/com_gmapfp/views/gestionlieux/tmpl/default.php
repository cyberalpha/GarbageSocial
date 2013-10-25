<?php 
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.12
	* Creation date: Mars 2012
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die('Restricted access'); 
	
$ordering 	= ($this->lists['order'] == 'a.ordering');
//$app 		= JFactory::getApplication();
//$cur_template = $app->getTemplate();

?>
<div style="height:70px">
<div class="toolbar" id="toolbar"> 
    <table class="toolbar"><tr> 
        <td> 
            <button name="publish" class="button" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('<?php echo JText::_( 'GMAPFP_CHOISIR_DANS_LISTE' ).' '.JText::_( 'JPUBLISHED' ); ?>');}else{  submitbutton('publish')}">
                <span class="icon-32-publish" title="<?php echo JText::_( 'JPUBLISHED' ); ?>"> 
                </span> 
                <?php echo '&nbsp;'.JText::_( 'JPUBLISHED' ).'&nbsp;'; ?>
            </button>
        </td> 
        <td> 
            <button name="unpublish" class="button" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('<?php echo JText::_( 'GMAPFP_CHOISIR_DANS_LISTE' ).' '.JText::_( 'JUNPUBLISHED' ); ?>');}else{  submitbutton('unpublish')}">
                <span class="icon-32-unpublish" title="<?php echo JText::_( 'JUNPUBLISHED' ); ?>"> 
                </span> 
                <?php echo '&nbsp;'.JText::_( 'JUNPUBLISHED' ).'&nbsp;'; ?>
            </button>
        </td> 
        <td> 
            <button name="copy" class="button" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('<?php echo JText::_( 'GMAPFP_CHOISIR_DANS_LISTE' ).' '.JText::_( 'GMAPFP_COPIER' ); ?>');}else{  submitbutton('copy')}">
                <span class="icon-32-copy" title="<?php echo JText::_( 'GMAPFP_COPIER' ); ?>"> 
                </span> 
                <?php echo '&nbsp;'.JText::_( 'GMAPFP_COPIER' ).'&nbsp;'; ?>
            </button>
        </td> 
        <td> 
            <button name="delete" class="button" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('<?php echo JText::_( 'GMAPFP_CHOISIR_DANS_LISTE' ).' '.JText::_( 'JACTION_DELETE' ); ?>');}else{  submitbutton('remove')}">
                <span class="icon-32-delete" title="<?php echo JText::_( 'JACTION_DELETE' ); ?>"> 
                </span> 
                <?php echo '&nbsp;'.JText::_( 'JACTION_DELETE' ).'&nbsp;'; ?>
            </button>
        </td> 
        <td> 
            <button name="edit" class="button" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('<?php echo JText::_( 'GMAPFP_CHOISIR_DANS_LISTE' ).' '.JText::_( 'JACTION_EDIT' ); ?>');}else{  submitbutton('edit')}">
                <span class="icon-32-edit" title="<?php echo JText::_( 'JACTION_EDIT' ); ?>"> 
                </span> 
                <?php echo '&nbsp;'.JText::_( 'JACTION_EDIT' ).'&nbsp;'; ?>
            </button>
        </td> 
        <td> 
            <button name="add" class="button" onclick="javascript: submitbutton('add')">
                <span class="icon-32-new" title="<?php echo JText::_( 'GMAPFP_NEW' ); ?>"> 
                </span> 
                <?php echo '&nbsp;'.JText::_( 'GMAPFP_NEW' ).'&nbsp;'; ?>
            </button>
        </td> 
    </tr></table> 
</div>
</div>
<form action=<?php echo JRoute::_('index.php?option=com_gmapfp&view=gestionlieux&controller=gestionlieux&task=view') ?> method="post" name="adminForm">
	<table  class="adminform">
		<tr>
			<td nowrap="nowrap">
				<?php echo JText::_( 'GMAPFP_FILTER' ); ?>:
				<input type="text" name="search" id="search_gmapfp" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();" class="button"><?php echo '&nbsp;'.JText::_( 'GMAPFP_GO_FILTER' ).'&nbsp;'; ?></button>
				<button onclick="document.getElementById('search_gmapfp').value='';
                        this.form.getElementById('filtreville').value='-- <?php echo JText::_( 'GMAPFP_VILLE_FILTRE' ) ?> --';
                        this.form.getElementById('filtredepartement').value='-- <?php echo JText::_( 'GMAPFP_DEPARTEMENT_FILTRE' ) ?> --';
                        this.form.getElementById('filtrecategorie').value='-- <?php echo JText::_( 'GMAPFP_CATEGORIE_FILTRE' ) ?> --';
		                this.form.submit();" class="button"><?php echo '&nbsp;'.JText::_( 'GMAPFP_RESET' ).'&nbsp;'; ?></button>
			</td>
			<td>
				<?php
				echo $this->lists['departement'];
				echo $this->lists['ville'];
				echo $this->lists['categorie'];
				?>
			</td>
		</tr>
	</table>
<div id="editcell">
	<table class="adminlist">
	<thead>
		<tr>
			<th width="20">
				<?php echo JText::_( 'JGLOBAL_DISPLAY_NUM' ); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>
			<th  width="30%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'GMAPFP_NOM', 'nom', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th  width="30%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'GMAPFP_VILLE', 'ville', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th  width="20%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'GMAPFP_DEPARTEMENT', 'departement', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th width="8%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',  'JFIELD_ORDERING_LABEL', 'a.ordering', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				<?php if ($ordering) echo JHTML::_('grid.order',  $this->items ); ?>
			</th>
			<th  width="20%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'JCATEGORY', 'title', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th width="5%" align="center">
				<?php echo JHTML::_('grid.sort',   'JPUBLISHED', 'published', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th width="1%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'JGRID_HEADING_ID', 'id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
		</tr>
	</thead>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];
		
		$published	= $this->published($row, $i);
		$checked 	= JHTML::_('grid.id',   $i, $row->id );
		$link 		= JRoute::_( 'index.php?option=com_gmapfp&view=editlieux&layout=edit_form&controller=editlieux&task=edit&cid='. $row->id.':'.$row->alias );

		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $this->pageNav->getRowOffset( $i ); ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td>
				<a href="<?php echo $link; ?>"><?php echo $row->nom; ?></a>
			</td>
			<td>
				<?php echo $row->ville; ?>
			</td>
			<td>
				<?php echo $row->departement; ?>
			</td>
			<td class="order">
				<span><?php echo $this->pageNav->orderUpIcon( $i, true,'orderup', 'Move Up', $ordering ); ?></span>
				<span><?php echo $this->pageNav->orderDownIcon( $i, $n, true, 'orderdown', 'Move Down', $ordering ); ?></span>
				<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
				<input type="text" name="order[]" size="5" value="<?php echo $row->ordering;?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
			</td>
			<td>
				<?php echo $row->title; ?>
			</td>
						</td>
			<td align="center">
				<?php echo $published;?>
			</td>
			<td align="center">
				<?php echo $row->id; ?>
			</td>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
        <tfoot>
            <tr>
                <td colspan="15">
                    <?php echo $this->pageNav->getListFooter(); ?>
                </td>
            </tr>
        </tfoot>
    </table>
    <div class="copyright" align="center">
        <br />
	<?php echo JText::_( 'GMapFP - <a href="http://gmapfp.org">gmapfp.org</a>' );?>
    </div>
</div>
<input type="hidden" name="option" value="com_gmapfp" />
<input type="hidden" name="task" value="view" />
<input type="hidden" name="controller" value="gestionlieux" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
