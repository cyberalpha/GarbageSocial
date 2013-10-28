<div class="rb-items clearfix">
	<span class="rb-title"><?php echo 'Background Color'?></span>
	<div class="rb-item" id="select_color_<?php echo $key;?>">
		<input id="color_<?php echo $key;?>" class="rb-color" name="color_<?php echo $key;?>" type="text" size="13" value="<?php echo trim($ztTools->getParamsValue($prefix, 'color', $key));?>" style="background-color:<?php echo trim($ztTools->getParamsValue($prefix, 'color', $key));?>" />
	</div>
	<script language="javascript" type="text/javascript">
		window.addEvent("load", function(){
			new MooRainbow('select_color_<?php echo $key;?>', {
				id: 'rainbow_color_<?php echo $key;?>',
				imgPath: '<?php echo $ztTools->templateurl();?>/images/rainbow/',
				startColor: $('color_<?php echo $key;?>').value.hexToRgb(true),
				onChange: function(color) {
					$('color_<?php echo $key;?>').value = color.hex;
					$('color_<?php echo $key;?>').setStyle('background-color', color.hex);
					$('<?php echo $key;?>').setStyle('background-color', color.hex);
					Cookie.write('<?php echo $prefix.'_color_'.$key;?>', color.hex);
				},
				onComplete: function(color) {					
					$('color_<?php echo $key;?>').setStyle('background-color', color.hex);
					$('<?php echo $key;?>').setStyle('background-color', color.hex);
					Cookie.write('<?php echo $prefix.'_color_'.$key;?>', color.hex);
				}
			});
		});
	</script>
</div>