<?php
defined( '_JEXEC' ) or die;

function modChrome_home( $module, &$params, &$attribs )
{
	if ( !empty ( $module->content ) ) : ?>
		<div class="moduletable<?php echo htmlspecialchars( $params->get( 'moduleclass_sfx' ) ); ?> border-10 relative">
			<?php if ( (bool)$module->showtitle ) : ?>
				<div class="<?php echo $params->get( 'header_class', '' ); ?>"><?php echo $module->title; ?></div>
			<?php endif; ?>
			<?php echo $module->content; ?>
		</div>
		<div class="clear height-30"></div>
	<?php endif;
}