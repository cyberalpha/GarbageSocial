<?php

?>

<div id ="slideshow" class="block_holder">

		<?php if ($this->countModules( 'showcase' )) : ?>
				<div id="showcase">
					<div id="showcase_padding">
						<jdoc:include type="modules" name="showcase" style="none" />
<!-- 						<div id="showcase_base"></div> -->
					</div>
				</div>
		<?php endif; ?>

<div class="clear"></div>
</div>