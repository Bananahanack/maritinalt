<?php
/** @var $this MaritinaViewMaritina */
defined( '_JEXEC' ) or die; // No direct access
?>
<div class="item-page">
	<h1></h1>

	<form action="<?php echo JRoute::_( 'index.php?view=Maritina' ) ?>" method="post" class="form-validate">

		<div class="control-group form-inline">
			<div class="control-label"><?php echo $this->form->getLabel( 'test' ); ?></div>
			<div class="controls"><?php echo $this->form->getInput( 'test' ); ?></div>
		</div>

		<input type="hidden" name="task" value="Maritina.save" />
		<input type="submit" value="Отправить" />
		<?php echo JHtml::_( 'form.token' ); ?>
	</form>
</div>