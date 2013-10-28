<div class="rb-items clearfix">
	<span class="rb-title"><?php echo 'Background Image'?></span>
	<div class="pattern-select">
		<div id="select_image_<?php echo $key;?>" class="pattern-active <?php echo $ztTools->getParamsValue($prefix, 'image', $key);?>"></div>
	</div>
</div>
<div class="clearfix">	
	<div id="popup_image_<?php echo $key;?>" class="pattern-popup">
		<?php for($i = 0; $i < count($v[1]); $i++) { ?>
		<div class="lady_item <?php echo $v[1][$i];?>"></div>
		<?php }?>
	</div>
	<script type="text/javascript" language="javascript">
		window.addEvent("load", function(){     
			new LadyPopup('select_image_<?php echo $key;?>', {
				id: 'popup_image_<?php echo $key;?>',
				position: '<?php echo $key;?>',
				prefix: '<?php echo $prefix;?>'
			});
		});
	</script>
</div>