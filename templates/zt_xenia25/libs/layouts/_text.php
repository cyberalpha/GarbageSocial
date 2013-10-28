<div class="rb-items clearfix">
	<span class="rb-title"><?php echo 'Text Color'?></span>
	<div class="rb-item" id="select_text_<?php echo $key;?>">
		<input id="text_<?php echo $key;?>" class="rb-color" name="text_<?php echo $key;?>" type="text" size="13" value="<?php echo trim($ztTools->getParamsValue($prefix, 'text', $key));?>" style="background-color:<?php echo trim($ztTools->getParamsValue($prefix, 'text', $key));?>" />
	</div>
	<script language="javascript" type="text/javascript">
		window.addEvent("load", function(){
			new MooRainbow('select_text_<?php echo $key;?>', {
				id: 'rainbow_text_<?php echo $key;?>',
				imgPath: '<?php echo $ztTools->templateurl();?>/images/rainbow/',
				startColor: $('text_<?php echo $key;?>').value.hexToRgb(true),
				onChange: function(color) {
					$('text_<?php echo $key;?>').value = color.hex;
					$('text_<?php echo $key;?>').setStyle('background-color', color.hex);
					$('<?php echo $key;?>').setStyle('color', color.hex);
					Cookie.write('<?php echo $prefix.'_text_'.$key;?>', color.hex);
				},
				onComplete: function(color) {
					$('text_<?php echo $key;?>').setStyle('background-color', color.hex);
					$('<?php echo $key;?> a').setStyle('color', color.hex);
					Cookie.write('<?php echo $prefix.'_text_'.$key;?>', color.hex);
				}
			});
		});
	</script>
</div>
