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
	
$ordering = ($this->lists['order'] == 'a.ordering');
JHTML::_('behavior.tooltip');

?>
<form action="index.php?option=com_gmapfp&controller=gmapfp&task=view" method="post" name="adminForm">
	<table  class="adminform">
		<tr>
			<td width="100%">
				<?php echo JText::_( 'JSEARCH_FILTER_LABEL' ); ?>
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'JSEARCH_FILTER_SUBMIT' ); ?></button>
				<button onclick="document.getElementById('search').value='';
                        this.form.getElementById('filtreville').value='-- <?php echo JText::_( 'GMAPFP_VILLE_FILTRE' ) ?> --'; 
                        this.form.getElementById('filtredepartement').value='-- <?php echo JText::_( 'GMAPFP_DEPARTEMENT_FILTRE' ) ?> --';
                        this.form.getElementById('filtrecategorie').value=0;
		                this.form.submit();"><?php echo JText::_( 'JSEARCH_FILTER_CLEAR' ); ?></button>
			</td>
			<td nowrap="nowrap">
				<?php
				echo $this->lists['ville'];
				echo $this->lists['departement'];
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
				<?php echo JText::_( 'JGRID_HEADING_ROW_NUMBER' ); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>
			<th  width="30%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'GMAPFP_NOM', 'nom', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th width="5%" align="center">
				<?php echo JHTML::_('grid.sort',   'JPUBLISHED', 'published', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th  width="10%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'JCATEGORY', 'title', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th width="8%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',  'JGRID_HEADING_ORDERING', 'a.ordering', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				<?php if ($ordering) echo JHTML::_('grid.order',  $this->items ); ?>
			</th>
			<th  width="20%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'GMAPFP_VILLE', 'ville', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th  width="15%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'GMAPFP_DEPARTEMENT', 'departement', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th  width="15%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'GMAPFP_PAYS', 'pay', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th  width="10%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'JAUTHOR', 'auteur', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
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
		
		$published	= JHTML::_('grid.published', $row, $i );
		$checked 	= JHTML::_('grid.id',   $i, $row->id );
		$link 		= JRoute::_( 'index.php?option=com_gmapfp&controller=gmapfp&task=edit&cid[]='. $row->id );

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
			<td align="center">
				<?php echo $published;?>
			</td>
			<td>
				<?php echo $row->title; ?>
			</td>
			<td class="order">
				<span><?php echo $this->pageNav->orderUpIcon( $i, true,'orderup', 'Move Up', $ordering ); ?></span>
				<span><?php echo $this->pageNav->orderDownIcon( $i, $n, true, 'orderdown', 'Move Down', $ordering ); ?></span>
				<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
				<input type="text" name="order[]" size="5" value="<?php echo $row->ordering;?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
			</td>
			<td>
				<?php echo $row->ville; ?>
			</td>
			<td>
				<?php echo $row->departement; ?>
			</td>
			<td>
				<?php echo $row->pay; ?>
			</td>
			<td>
				<a href="mailto:<?php echo $row->auteur_mail; ?>"><?php echo $row->auteur; ?></a>
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
	<?php 
	$langue		=substr((@$lang->getTag()),0,2);
	if ($langue!='fr') $langue = 'en';
	echo '<h1 style="color:red;">'.JText::_( 'GMAPFP_DISCOVER_PRO_VERSION' ).' : '.'</h1>'; ?>
    <a href="http://pro.gmapfp.org/<?php echo $langue; ?>" target="_new"><?php echo '<h1 style="color:red; text-decoration: underline;">'.JText::_( 'GMapFP Pro' ).'</h1>'; ?></a>
	<br />
	<?php echo JText::_( 'GMAPFP_COPYRIGHT' );?>
</div>
</div>
<input type="hidden" name="option" value="com_gmapfp" />
<input type="hidden" name="task" value="view" />
<input type="hidden" name="controller" value="gmapfp" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
