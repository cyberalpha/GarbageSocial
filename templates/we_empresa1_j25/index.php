<?php
/**
 * @version		$Id: index.php 21720 2011-07-01 08:31:15Z chdemko $
 * @package		Joomla.Site
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.framework', true);

//obtenemos los parámetros
$logo	= $this->params->get('logo');
$titulo = $this->params->get('titulo');
$color  = $this->params->get('colorletra');
$fondobanner = $this->params->get('fondobanner');
$fondonegro  = $this->params->get('fondonegro');
$fondo="negro";

if (!$fondonegro){$fondo = $color;}

$app 	= JFactory::getApplication();

$browser = $_SERVER['HTTP_USER_AGENT'];
$browser = substr("$browser", 25, 8);

//funciones varias

function clasegrid($total,$central=false){
	$clase="";
	switch ($central){
		case true:
				switch($total){
					case 0:$clase="grid_12";break;
					case 1:$clase="grid_9";break;
					case 2:$clase="grid_6";break;
				}
				break;	
		case false:
				switch ($total){
					case 1:$clase="grid_12";break;
					case 2:$clase="grid_6";break;
					case 3:$clase="grid_4";break;
					case 4:$clase="grid_3";break;
					}
				break;	
	}
	return $clase;
}
			

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
	<head>

		<jdoc:include type="head" />

		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/960_12_col.css" type="text/css" />		
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/posiciones.css" type="text/css" />
		
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/estilos/<?php echo $color; ?>.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/estilos/fondo/<?php echo $fondo; ?>.css" type="text/css" />
		<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/template.js" ></script>
		
		<?php if($this->direction == 'rtl') : ?>
			<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/960_12_col_rtl.css" type="text/css" />
			<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template_rtl.css" type="text/css" />			
		<?php endif; ?>
	
		<!--[if lt IE 9]>
			<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/ie.css" type="text/css" />
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<link href='http://fonts.googleapis.com/css?family=Play' rel='stylesheet' type='text/css'>
		
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/template.js"></script>
	</head>
	
	<body>
		<?php
		if ($browser == "MSIE 6.0"):?>
   			<div id="noie6"><?php echo JText::_('TPL_WE_EMPRESA1_J25_MSGIE6',true); ?></div>
		<?php endif;?>
		<div id="contenedor-total">

		<?php if ($this->countModules('banner-0')): ?>		
		<section id="banner-0" style="background:<?php echo $fondobanner ?>">
			<jdoc:include type="modules" name="banner-0" style="banner" />
		</section>
		<?php endif; ?>
						
		<div class="contenedor posheader">
			
			<header class="container_12">
					<div  class="grid_4">
					<h1 id="logo">
					<a href="<?php echo JURI::base(); ?>">
						<?php if ($logo != null ): ?>
							<img src="<?php echo $this->baseurl ?>/<?php echo htmlspecialchars($logo); ?>" alt="<?php echo htmlspecialchars($titulo);?>" />
						<?php else: ?>
							<?php echo htmlspecialchars($titulo);?>
						<?php endif; ?>					
					</a>
					</h1>
					</div>

					<div class="grid_8">
						<div id="position-0">
								<jdoc:include type="modules" name="position-0" style="basico" />
								<?php if ($this->params->get('mostrarredes')): ?>
								<!--para las redes-->
									<div id="redes">
										<ul>
											<?php if (trim($this->params->get('facebook'))!=""): ?>
												<li><a id="facebook" href="#" title="facebook" target="_blank"></a></li>
											<?php endif; ?>
											<?php if (trim($this->params->get('twitter'))!=""): ?>
												<li><a id="twitter" href="#" title="twitter" target="_blank"></a></li>
											<?php endif; ?>
											<?php if (trim($this->params->get('youtube'))!=""): ?>
												<li><a id="youtube" href="#" title="youtube" target="_blank"></a></li>
											<?php endif; ?>
											<?php if (trim($this->params->get('rss'))!=""): ?>
												<li><a id="rss" href="#" title="rss" target="_blank"></a></li>
											<?php endif; ?>																				
										</ul>
										
									</div>
								<!-- -->							
								<?php endif; ?>
						</div>
						<nav id="position-1">
							<jdoc:include type="modules" name="position-1" style="basico" />
						</nav>
					</div>
					<div class="clear"></div>
				
			</header>
		</div>
		
		<div class="contenedor breadcrumbs_search">
			<section class="container_12">
				<div id="breadcrumbs" class="grid_9">
					<jdoc:include type="modules" name="breadcrumbs" style="basico" />
				</div>
				<div id="search" class="grid_3">
					<jdoc:include type="modules" name="search" style="basico" />
				</div>
				<div class="clear"></div>
		</section>
		</div>


		<?php if ($this->countModules('slider')): ?>
		<section id="slider">
			<jdoc:include type="modules" name="slider" style="basico" />
		</section>
		<?php endif; ?>

		<?php if ($this->countModules('banner-1')): ?>		
		<section id="banner-1">
			<jdoc:include type="modules" name="banner-1" style="banner" />
		</section>
		<?php endif; ?>
				
		<?php 
			$pos2=(int)(bool)$this->countModules('position-2');
			$pos3=(int)(bool)$this->countModules('position-3');
			$pos4=(int)(bool)$this->countModules('position-4');
			$pos5=(int)(bool)$this->countModules('position-5');
			$total = $pos2 + $pos3 + $pos4 + $pos5;
			$clase = clasegrid($total);
		?>
		
		<?php if ($total>0): ?>
			<section id="positions_2-5" class="container_12">
						
				<?php if ($pos2): ?>
					<div id="position-2" class="<?php echo $clase ?>"><jdoc:include type="modules" name="position-2" style="we_empresa" /></div>
				<?php endif; ?>
				<?php if ($pos3): ?>
					<div id="position-3" class="<?php echo $clase ?>"><jdoc:include type="modules" name="position-3" style="we_empresa" /></div>
				<?php endif; ?>
				<?php if ($pos4): ?>
					<div id="position-4" class="<?php echo $clase ?>"><jdoc:include type="modules" name="position-4" style="we_empresa" /></div>
				<?php endif; ?>
				<?php if ($pos5): ?>
					<div id="position-5" class="<?php echo $clase ?>"><jdoc:include type="modules" name="position-5" style="we_empresa" /></div>
				<?php endif; ?>
				
				<div class="clear"></div>
			</section>

		<?php endif;?>
				
				
		<?php
			$posleft=(int)(bool)$this->countModules('left');
			$posright=(int)(bool)$this->countModules('right');
			$total = $posleft + $posright;
			$clase = clasegrid($total,true);
		?>		
		<section id="central" class="container_12">
		
			<?php if ($posleft): ?>
			<aside id="left" class="grid_3"><jdoc:include type="modules" name="left" style="we_empresa" /></aside>
			<?php endif; ?>
			
			<section id="central_content" class="<?php echo $clase; ?>">
				
				<?php if($this->countModules('position-6')): ?>
				<div id="position-6"><jdoc:include type="modules" name="position-6" style="we_empresa" /></div>
				<?php endif; ?>
				
				<div id="main">
					<jdoc:include type="message" />
					<jdoc:include type="component" />
				</div>
				
				<?php if($this->countModules('position-7')): ?>
				<div id="position-7"><jdoc:include type="modules" name="position-7" style="we_empresa" /></div>
				<?php endif; ?>
				
			</section>
			
			<?php if ($posright): ?>
			<aside id="right" class="grid_3"><jdoc:include type="modules" name="right" style="we_empresa" /></aside>
			<?php endif; ?>
			
		</section>
		
		<?php 
			$pos8=(int)(bool)$this->countModules('position-8');
			$pos9=(int)(bool)$this->countModules('position-9');
			$pos10=(int)(bool)$this->countModules('position-10');
			$pos11=(int)(bool)$this->countModules('position-11');
			$total = $pos8 + $pos9 + $pos10 + $pos11;
			$clase = clasegrid($total);
		?>
		<?php if ($total>0): ?>
		<div class="contenedor pos8-11">
		<section id="positions_8-11" class="container_12">
			<?php if ($pos8): ?>
			<div id="position-8" class="<?php echo $clase ?>"><jdoc:include type="modules" name="position-8" style="we_empresa_fondocolor" /></div>
			<?php endif; ?>
			<?php if ($pos9): ?>
			<div id="position-9" class="<?php echo $clase ?>"><jdoc:include type="modules" name="position-9" style="we_empresa_fondocolor" /></div>
			<?php endif; ?>
			<?php if ($pos10): ?>
			<div id="position-10" class="<?php echo $clase ?>"><jdoc:include type="modules" name="position-10" style="we_empresa_fondocolor" /></div>
			<?php endif; ?>
			<?php if ($pos11): ?>
			<div id="position-11" class="<?php echo $clase ?>"><jdoc:include type="modules" name="position-11" style="we_empresa_fondocolor" /></div>
			<?php endif; ?>			
		</section>
		</div>
		<?php endif; ?>
		
		<div class="contenedor">
		<footer class="container_12">
			
			<?php if ($this->countModules('footer-nav')): ?>
			<div id="footer-nav" class="grid_12">
				<jdoc:include type="modules" name="footer-nav" style="basico" />
			</div>
			<?php endif; ?>
			
			<?php if ($this->countModules('footer')): ?>
			<div id="footer" class="grid_12">
				<jdoc:include type="modules" name="footer" style="basico" />
			</div>		
			<?php endif; ?>
			
		</footer>
		</div>


	</div>		
	</body>
</html>
