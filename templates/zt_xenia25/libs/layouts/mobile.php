<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>">
<head>
	<jdoc:include type="head" />
	<meta content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0;" name="viewport">	
	<link rel="stylesheet" href="<?php echo $ztTools->templateurl(); ?>css/default.css" type="text/css" />
	<?php
		if($ztTools->getParam('zt_fontfeature')) {
	?>	
		<link rel="stylesheet" href="<?php echo $ztTools->templateurl(); ?>css/fonts.css" type="text/css" />
	<?php	
		}	
	?>
	<link rel="stylesheet" href="<?php echo $ztTools->templateurl(); ?>css/modules.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $ztTools->templateurl(); ?>css/mobile.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $ztTools->templateurl(); ?>css/css3.php?url=<?php echo $ztTools->templateurl(); ?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo $ztTools->templateurl(); ?>css/typo.css" type="text/css" />
	<?php
		if($ztrtl == 'rtl') {
	?>	
		<link rel="stylesheet" href="<?php echo $ztTools->templateurl(); ?>css/mobile_rtl.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $ztTools->templateurl(); ?>css/typo_rtl.css" type="text/css" />
	
	<?php	
		}
	?>
	<script language="javascript" src="<?php echo $ztTools->templateurl(); ?>zt_menus/zt_drillmenu/jquery.min.js"></script>
	<script language="javascript" src="<?php echo $ztTools->templateurl(); ?>js/ladyoverlay.js"></script>
</head>
<body id="bd" class="fs<?php echo $ztTools->getParam('zt_font'); ?> <?php echo $ztTools->getParam('zt_display'); ?> <?php echo $ztTools->getParam('zt_display_style'); ?> <?php echo $ztrtl; ?>">
<a name="top"></a>
	
	<div id="shadowbox_container">
		<?php if($this->countModules('msearch')) : ?>
		<div id="zt-search" >
			<div id="zt-search-inner">
				<a id="btn-search_close" href="#">close</a>
				<jdoc:include type="modules" name="msearch" style="ztmobile" />
			</div>
		</div>
		<?php endif?>
		
		<?php if($this->countModules('mlogin')) : ?>
		<div id="zt-sign">
			<div id="zt-sign-inner">
				<a id="btn-login_close" href="#">close</a>
				<jdoc:include type="modules" name="mlogin" style="ztmobile" />
			</div>	
		</div>
		<?php endif?>
		
	</div>
	
	<div id="zt-wrapper">
		<div id="zt-header">
			<div class="zt-wrapper">
				<div id="zt-header-inner">
					<div id="zt-header-inner2">
						<h1 id="zt-logo"><a class="png" href="<?php echo $ztTools->baseurl() ; ?>" title="<?php echo $ztTools->sitename() ; ?>"><span><?php echo $ztTools->sitename() ; ?></span></a></h1>
						<div id="zt-toolbar-btn">
							<?php if($this->countModules('msearch')) : ?>
							<a href="#" id="btn-search"></a>
							<?php endif ?>	
							<?php if($this->countModules('mlogin')) : ?>
							<a href="#" id="btn-login"></a>
							<?php endif ?>	
							<a href="?ismobile=0" id="btn-mobile"></a>
							<a href="?ismobile=1" id="btn-destop"></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div id="zt-userwrap1" class="clearfix">
			<div class="zt-wrapper">
				<div id="zt-userwrap1-inner">

					<div id="zt-breadcrumbs">
						<span class="home-item">You are here:</span><div id="drillcrumb"></div>
					</div>

					<div id="zt-userwrap1-inner2">
						<div id="zt-userwrap1-inner3">
							<div id="drillmenu1" class="drillmenu">
								<?php $menu->show(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php
		$spotlight = array ('muser1','muser2');
		$consl = $ztTools->calSpotlight($spotlight,$ztTools->isOP()?100:100,'%');
		if( $consl) :
		?>
		<!--#Begin User 2-->
		<div id="zt-userwrap2" class="clearfix">
			<div class="zt-wrapper">
				<div id="zt-userwrap2-inner">
					
					<?php if($this->countModules('muser1')) : ?>
					<div id="zt-muser1" class="zt-user zt-box<?php echo $consl['muser1']['class']; ?>" style="width: <?php echo $consl['muser1']['width']; ?>;">
						<div class="zt-box-inside">
							<jdoc:include type="modules" name="muser1" style="ztmobile" />
						</div>
					</div>
					<?php endif; ?>
					
					<?php if($this->countModules('muser2')) : ?>
					<div id="zt-muser2" class="zt-user zt-box<?php echo $consl['muser2']['class']; ?>" style="width: <?php echo $consl['muser2']['width']; ?>;">
						<div class="zt-box-inside">
							<jdoc:include type="modules" name="muser2" style="ztmobile" />
						</div>
					</div>
					<?php endif; ?>
					
				</div>
			</div>
		</div>
		<!--#end User 1-->
		<?php  endif; ?>

		<div id="zt-mainbody" class="clearfix">
			<div id="zt-mainbody-inner">				
				<div id="zt-content">
					<jdoc:include type="message" />
					<jdoc:include type="component" />
					<?php if($this->countModules('lastproduct')) : ?>
						<div id="zt-lastproduct">
							<jdoc:include type="modules" name="lastproduct" style="ztxhtml" />
						</div>
					<?php endif; ?>
					<?php if($this->countModules('mnews')) : ?>
					<div id="zt-mnews"  class="clearfix">
						<div class="zt-box-inside">
							<jdoc:include type="modules" name="mnews" style="ztmobile" />
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<?php
		$spotlight = array ('muser3','muser4');
		$consl = $ztTools->calSpotlight($spotlight,$ztTools->isOP()?100:100,'%');
		if( $consl) :
		?>
		<!--#Begin User 3-->
		<div id="zt-userwrap3" class="clearfix">
			<div class="zt-wrapper">
				<div id="zt-userwrap3-inner">
					
					<?php if($this->countModules('muser3')) : ?>
					<div id="zt-muser3" class="zt-user zt-box<?php echo $consl['muser3']['class']; ?>" style="width: <?php echo $consl['muser3']['width']; ?>;">
						<div class="zt-box-inside">
							<jdoc:include type="modules" name="muser3" style="ztmobile" />
						</div>
					</div>
					<?php endif; ?>
					
					<?php if($this->countModules('muser4')) : ?>
					<div id="zt-muser4" class="zt-user zt-box<?php echo $consl['muser4']['class']; ?>" style="width: <?php echo $consl['muser4']['width']; ?>;">
						<div class="zt-box-inside">
							<jdoc:include type="modules" name="muser4" style="ztmobile" />
						</div>
					</div>
					<?php endif; ?>
					
				</div>
			</div>
		</div>
		<!--#end User 1-->
		<?php  endif; ?>

		<div id="zt-footer" class="clearfix">
			<div class="zt-wrapper">
				<div id="zt-footer-inner">
					<div id="zt-footer-inner2">
						<div id="zt-footer-right">	
							<?php if($ztTools->getParam('zt_footer')) : ?>
							<?php echo $ztTools->getParam('zt_footer_text'); ?>
							<?php else : ?>
							Copyright &copy; 2008 - 2011 <a href="http://www.zootemplate.com" title="Joomla Templates">Joomla Templates</a> by <a href="http://www.zootemplate.com" title="ZooTemplate">ZooTemplate.Com</a>. All rights reserved.
							<?php endif; ?>
						</div>
						<div id="pannel-top"><a href="#top">Top</a></div>
					</div>
				</div>
			</div>
		</div>
	
		<script type="text/javascript" language="javascript">
			window.addEvent("load", function(){     
				new LadyOverlay('btn-search', {
					id: 'zt-search'
				});
				new LadyOverlay('btn-login', {
					id: 'zt-sign'
				});
			});
		</script>
	</div>
</body>
</html>