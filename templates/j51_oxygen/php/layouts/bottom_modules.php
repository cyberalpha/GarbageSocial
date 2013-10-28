<?php

?>

<div id="bottom_modules" class="block_holder">

<?php if($this->params->get('bottom1_auto') != '1') : ?>
<?php if ($this->countModules('bottom-1a') || $this->countModules('bottom-1b') || $this->countModules('bottom-1c') || $this->countModules('bottom-1d') || $this->countModules('bottom-1e') || $this->countModules('bottom-1f')) { ?>
		<div id="wrapper_bottom-1" class="block_holder_margin">
		<?php if ($this->countModules('bottom-1a')) { ?> 
		<div class="bottom-1" style="width:<?php echo $bottom1_width ?>;"><div class="module_margin"><jdoc:include type="modules" name="bottom-1a"  style="mod_standard"/></div></div><?php } ?>
		<?php if ($this->countModules('bottom-1b')) { ?>
		<div class="bottom-1" style="width:<?php echo $bottom1_width ?>;"><div class="module_margin"><jdoc:include type="modules" name="bottom-1b"  style="mod_standard"/></div></div><?php } ?>
		<?php if ($this->countModules('bottom-1c')) { ?>
		<div class="bottom-1" style="width:<?php echo $bottom1_width ?>;"><div class="module_margin"><jdoc:include type="modules" name="bottom-1c"  style="mod_standard"/></div></div><?php } ?>
		<?php if ($this->countModules('bottom-1d')) { ?>
		<div class="bottom-1" style="width:<?php echo $bottom1_width ?>;"><div class="module_margin"><jdoc:include type="modules" name="bottom-1d"  style="mod_standard"/></div></div><?php } ?>
		<?php if ($this->countModules('bottom-1e')) { ?>
		<div class="bottom-1" style="width:<?php echo $bottom1_width ?>;"><div class="module_margin"><jdoc:include type="modules" name="bottom-1e"  style="mod_standard"/></div></div><?php } ?>
		<?php if ($this->countModules('bottom-1f')) { ?>
		<div class="bottom-1" style="width:<?php echo $bottom1_width ?>;"><div class="module_margin"><jdoc:include type="modules" name="bottom-1f"  style="mod_standard"/></div></div><?php } ?>
	<div class="clear"></div>
    </div>		
    <?php }?>
					
<?php else : ?>

<?php if ($this->countModules('bottom-1a') || $this->countModules('bottom-1b') || $this->countModules('bottom-1c') || $this->countModules('bottom-1d') || $this->countModules('bottom-1e') || $this->countModules('bottom-1f')) { ?>
    <div id="wrapper_bottom-1" class="block_holder_margin">
        <?php if ($this->countModules('bottom-1a')) { ?> 
        <div class="bottom-1" style="width:<?php echo $bottom_1a_manual ?>%;"><div class="module_margin"><jdoc:include type="modules" name="bottom-1a"  style="mod_standard"/></div></div><?php } ?>
        <?php if ($this->countModules('bottom-1b')) { ?>
        <div class="bottom-1" style="width:<?php echo $bottom_1b_manual ?>%;"><div class="module_margin"><jdoc:include type="modules" name="bottom-1b"  style="mod_standard"/></div></div><?php } ?>
        <?php if ($this->countModules('bottom-1c')) { ?>
        <div class="bottom-1" style="width:<?php echo $bottom_1c_manual ?>%;"><div class="module_margin"><jdoc:include type="modules" name="bottom-1c"  style="mod_standard"/></div></div><?php } ?>
        <?php if ($this->countModules('bottom-1d')) { ?>
        <div class="bottom-1" style="width:<?php echo $bottom_1d_manual ?>%;"><div class="module_margin"><jdoc:include type="modules" name="bottom-1d"  style="mod_standard"/></div></div><?php } ?>
        <?php if ($this->countModules('bottom-1e')) { ?>
        <div class="bottom-1" style="width:<?php echo $bottom_1e_manual ?>%;"><div class="module_margin"><jdoc:include type="modules" name="bottom-1e"  style="mod_standard"/></div></div><?php } ?>
        <?php if ($this->countModules('bottom-1f')) { ?>
        <div class="bottom-1" style="width:<?php echo $bottom_1f_manual ?>%;"><div class="module_margin"><jdoc:include type="modules" name="b0ttom-1f"  style="mod_standard"/></div></div><?php } ?>
        <div class="clear"></div>
    </div>
    <?php }?>
<?php endif; ?>
				

<?php if($this->params->get('bottom2_auto') != '1') : ?>
<?php if ($this->countModules('bottom-2a') || $this->countModules('bottom-2b') || $this->countModules('bottom-2c') || $this->countModules('bottom-2d') || $this->countModules('bottom-2e') || $this->countModules('bottom-2f')) { ?>
		<div id="wrapper_bottom-2" class="block_holder_margin">
		<?php if ($this->countModules('bottom-2a')) { ?> 
		<div class="bottom-2" style="width:<?php echo $bottom2_width ?>;"><div class="module_margin"><jdoc:include type="modules" name="bottom-2a"  style="mod_standard"/></div></div><?php } ?>
		<?php if ($this->countModules('bottom-2b')) { ?>
		<div class="bottom-2" style="width:<?php echo $bottom2_width ?>;"><div class="module_margin"><jdoc:include type="modules" name="bottom-2b"  style="mod_standard"/></div></div><?php } ?>
		<?php if ($this->countModules('bottom-2c')) { ?>
		<div class="bottom-2" style="width:<?php echo $bottom2_width ?>;"><div class="module_margin"><jdoc:include type="modules" name="bottom-2c"  style="mod_standard"/></div></div><?php } ?>
		<?php if ($this->countModules('bottom-2d')) { ?>
		<div class="bottom-2" style="width:<?php echo $bottom2_width ?>;"><div class="module_margin"><jdoc:include type="modules" name="bottom-2d"  style="mod_standard"/></div></div><?php } ?>
		<?php if ($this->countModules('bottom-2e')) { ?>
		<div class="bottom-2" style="width:<?php echo $bottom2_width ?>;"><div class="module_margin"><jdoc:include type="modules" name="bottom-2e"  style="mod_standard"/></div></div><?php } ?>
		<?php if ($this->countModules('bottom-2f')) { ?>
		<div class="bottom-2" style="width:<?php echo $bottom2_width ?>;"><div class="module_margin"><jdoc:include type="modules" name="bottom-2f"  style="mod_standard"/></div></div><?php } ?>
	<div class="clear"></div>
    </div>					
    <?php }?>
					
<?php else : ?>

<?php if ($this->countModules('bottom-2a') || $this->countModules('bottom-2b') || $this->countModules('bottom-2c') || $this->countModules('bottom-2d') || $this->countModules('bottom-2e') || $this->countModules('bottom-2f')) { ?>
    <div id="wrapper_top-2" class="block_holder_margin">
        <?php if ($this->countModules('bottom-2a')) { ?> 
        <div class="bottom-2" style="width:<?php echo $bottom_2a_manual ?>%;"><div class="module_margin"><jdoc:include type="modules" name="bottom-2a"  style="mod_standard"/></div></div><?php } ?>
        <?php if ($this->countModules('bottom-2b')) { ?>
        <div class="bottom-2" style="width:<?php echo $bottom_2b_manual ?>%;"><div class="module_margin"><jdoc:include type="modules" name="bottom-2b"  style="mod_standard"/></div></div><?php } ?>
        <?php if ($this->countModules('bottom-2c')) { ?>
        <div class="bottom-2" style="width:<?php echo $bottom_2c_manual ?>%;"><div class="module_margin"><jdoc:include type="modules" name="bottom-2c"  style="mod_standard"/></div></div><?php } ?>
        <?php if ($this->countModules('bottom-2d')) { ?>
        <div class="bottom-2" style="width:<?php echo $bottom_2d_manual ?>%;"><div class="module_margin"><jdoc:include type="modules" name="bottom-2d"  style="mod_standard"/></div></div><?php } ?>
        <?php if ($this->countModules('bottom-2e')) { ?>
        <div class="bottom-2" style="width:<?php echo $bottom_2e_manual ?>%;"><div class="module_margin"><jdoc:include type="modules" name="bottom-2e"  style="mod_standard"/></div></div><?php } ?>
        <?php if ($this->countModules('bottom-2f')) { ?>
        <div class="bottom-2" style="width:<?php echo $bottom_2f_manual ?>%;"><div class="module_margin"><jdoc:include type="modules" name="bottom-2f"  style="mod_standard"/></div></div><?php } ?>
        <div class="clear"></div>
     </div>
    <?php }?>
<?php endif; ?>
</div>

