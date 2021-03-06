<?php 
	/*
	* GMapFP Component Google Map for Joomla! 1.6.x
	* Version 9.3
	* Creation date: Ao�t 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die('Restricted access'); 
?>

<form action="index.php?option=com_gmapfp&controller=marqueurs&task=view" method="post" name="adminForm" class="gmapfp">
<div id="editcell">
	<table class="adminlist">
	<thead>
		<tr>
		<tr>
			<th width="5">
				<?php echo JText::_( 'JGRID_HEADING_ROW_NUMBER' ); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->marqueurs ); ?>);" />
			</th>
			<th  width="200" class="title">
				<?php echo JHTML::_('grid.sort',   'GMAPFP_NOM', 'nom', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th  class="title">
				<?php echo JText::_('GMAPFP_APERCU'); ?>
			</th>
			<th width="5%" align="center">
				<?php echo JHTML::_('grid.sort',   'JPUBLISHED', 'published', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
		</tr>			
	</thead>
		<?php
		$k = 0;
		for ($i=0, $n=count( $this->marqueurs ); $i < $n; $i++)
		{
			$row = &$this->marqueurs[$i];
			
			$published		= JHTML::_('grid.published', $row, $i );
			$checked = JHTML::_('grid.id',   $i, $row->id );
			$link = JRoute::_( 'index.php?option=com_gmapfp&controller=marqueurs&task=edit&cid[]='. $row->id );
	
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
					<img src="<?php echo $row->url; ?>" title="<?php echo $row->nom; ?>" />
				</td>
			<td align="center">
				<?php echo $published;?>
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
	</div>

	<input type="hidden" name="option" value="com_gmapfp" />
	<input type="hidden" name="controller" value="marqueurs" />
	<input type="hidden" name="task" value="view" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</form>
<div class="copyright" align="center">
	<br />
	<?php echo JText::_( 'GMAPFP_COPYRIGHT' );?>
</div>
