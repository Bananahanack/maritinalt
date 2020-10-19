<?php
/** @var $this MaritinaViewArchive */
defined( '_JEXEC' ) or die;// No direct access
JHtml::_('bootstrap.tooltip');
JHtml::_( 'behavior.formvalidation' );
JHtml::_( 'behavior.keepalive' );
JHtml::_( 'formbehavior.chosen', 'select' );
$input = JFactory::getApplication()->input;
?>
<script type="text/javascript">
	Joomla.submitbutton = function (task) {
		if (task == 'archive.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
		<?php echo $this->form->getField( 'text' )->save(); ?>
			Joomla.submitform(task, document.getElementById('item-form'));
		} else {
			alert('<?php echo $this->escape( JText::_( 'JGLOBAL_VALIDATION_FORM_FAILED' ) ); ?>');
		}
	}
</script>
<form action="<?php echo JRoute::_( 'index.php?option=com_maritina&id=' . $this->form->getValue( 'id' ) ); ?>" method="post" name="adminForm" id="item-form" class="form-validate" enctype="multipart/form-data">
	
	<?php echo JLayoutHelper::render( 'joomla.edit.title_alias', $this ); ?>

	<div class="form-horizontal">
		<?php echo JHtml::_( 'bootstrap.startTabSet', 'myTab', array( 'active' => 'general' ) ); ?>

		<?php echo JHtml::_( 'bootstrap.addTab', 'myTab', 'general', JText::_( 'JGLOBAL_EDIT_ITEM', true ) ); ?>
		<div class="row-fluid">
			<div class="span9">
				<fieldset class="adminform">
					<?php echo $this->form->getInput( 'text' ); ?>
				</fieldset>
			</div>
			<div class="span3">
				<?php echo JLayoutHelper::render( 'joomla.edit.global', $this ); ?>
				<div class="form-vertical"></div>
			</div>
		</div>
		<?php echo JHtml::_( 'bootstrap.endTab' ); ?>

		<?php echo JHtml::_( 'bootstrap.addTab', 'myTab', 'publishing', JText::_( 'JGLOBAL_FIELDSET_PUBLISHING', true ) ); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel( 'id' ); ?></div>
					<div class="controls"><?php echo $this->form->getInput( 'id' ); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel( 'created_by' ); ?></div>
					<div class="controls"><?php echo $this->form->getInput( 'created_by' ); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel( 'created' ); ?></div>
					<div class="controls"><?php echo $this->form->getInput( 'created' ); ?></div>
				</div>
			</div>
		</div>
		<?php echo JHtml::_( 'bootstrap.endTab' ); ?>

		<?php echo JHtml::_( 'bootstrap.addTab', 'myTab', 'metadata', JText::_( 'JGLOBAL_FIELDSET_METADATA_OPTIONS', true ) ); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel( 'metakey' ); ?></div>
					<div class="controls"><?php echo $this->form->getInput( 'metakey' ); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel( 'metadesc' ); ?></div>
					<div class="controls"><?php echo $this->form->getInput( 'metadesc' ); ?></div>
				</div>
			</div>
		</div>
		<?php echo JHtml::_( 'bootstrap.endTab' ); ?>

		<?php if ( $this->canDo->get( 'core.admin' ) ): ?>
			<?php echo JHtml::_( 'bootstrap.addTab', 'myTab', 'permissions', JText::_( 'JCONFIG_PERMISSIONS_LABEL', true ) ); ?>
			<?php echo $this->form->getInput( 'rules' ); ?>
			<?php echo JHtml::_( 'bootstrap.endTab' ); ?>
		<?php endif ?>

		<?php echo JHtml::_( 'bootstrap.endTabSet' ); ?>
	</div>

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="return" value="<?php echo $input->getCmd( 'return' ); ?>" />
	<?php echo JHtml::_( 'form.token' ); ?>
</form>