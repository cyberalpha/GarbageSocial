<?php

defined('_JEXEC') or die;

/*
modChrome_basico = sólo muestra el contenido del módulo en un div con clase contenedormodulo
 */

function modChrome_banner($module, &$params, &$attribs){
	echo $module->content;
}


function modChrome_basico($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<div class="contenedormodulo">
			<?php echo $module->content; ?>
		</div>
	<?php endif;
}

function modChrome_we_empresa($module, &$params, &$attribs){
	if (!empty ($module->content)) : ?>
		<div class="moduletable<?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
		<?php if ($module->showtitle != 0) : ?>
			<div class="titulomodulo">
				<h3><?php echo $module->title; ?></h3>
			</div>

		<?php endif; ?>			
			<div class="contenidomodulo">
			<?php echo $module->content; ?>
			</div>
		</div>
	<?php endif;
}


function modChrome_we_empresa_fondocolor($module, &$params, &$attribs){
	if (!empty ($module->content)) : ?>
		<div class="moduletable<?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
		<?php if ($module->showtitle != 0) : ?>
			<div class="titulomodulo">
				<?php if (trim($params->get('moduleclass_sfx'))==''): ?>
				<h3><?php echo $module->title; ?></h3>
				<?php else: ?>
				<img src="<?php echo JURI::base() ?>templates/we_empresa1_j25/images/ico_modulos/<?php echo trim($params->get('moduleclass_sfx'))?>" />
				<h3><?php echo $module->title; ?></h3>
				<?php endif; ?>
				
			</div>
		<?php endif; ?>			
			<div class="contenidomodulo">
			<?php echo $module->content; ?>
			</div>
		</div>
	<?php endif;
}


/*
function modChrome_bottommodule($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<?php if ($module->showtitle) : ?>
			<h6><?php echo $module->title; ?></h6>
		<?php endif; ?>
		<?php echo $module->content; ?>
	<?php endif;
}
function modChrome_sidebar($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<?php if ($module->showtitle) : ?>
			<h3><?php echo $module->title; ?></h3>
		<?php endif; ?>
		<?php echo $module->content; ?>
	<?php endif;
}
*/

?>