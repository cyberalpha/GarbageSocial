<div class="rb-items clearfix">
	<span class="rb-title"><?php echo 'Link Color'?></span>
	<div class="rb-item" id="select_link_<?php echo $key;?>">
		<input id="link_<?php echo $key;?>" class="rb-color" name="link_<?php echo $key;?>" type="text" size="13" value="<?php echo trim($ztTools->getParamsValue($prefix, 'link', $key));?>" style="background-color:<?php echo trim($ztTools->getParamsValue($prefix, 'link', $key));?>" />
	</div>
	<script language="javascript" type="text/javascript">
		window.addEvent("load", function(){
			new MooRainbow('select_link_<?php echo $key;?>', {
				id: 'rainbow_link_<?php echo $key;?>',
				imgPath: '<?php echo $ztTools->templateurl();?>/images/rainbow/',
				startColor: $('link_<?php echo $key;?>').value.hexToRgb(true),
				onChange: function(color) {
					$('link_<?php echo $key;?>').value = color.hex;								
					$('link_<?php echo $key;?>').setStyle('background-color', color.hex);
					$$('#<?php echo $key;?> a').setStyle('color', color.hex);
					Cookie.write('<?php echo $prefix.'_link_'.$key;?>', color.hex);
				},
				onComplete: function(color) {								
					$('link_<?php echo $key;?>').setStyle('background-color', color.hex);
					$$('#<?php echo $key;?> a').setStyle('color', color.hex);
					Cookie.write('<?php echo $prefix.'_link_'.$key;?>', color.hex);
				}
			});
		});
	</script>
</div>