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
    <div class="row-fluid">
        <!-- Begin Content -->
        <div class="form-horizontal">
            <p>Sended: <?php echo JHtml::_( 'date', $this->item->created, 'd.m.Y H:i' ); ?></p>
            <?php echo $this->item->text; ?>
        </div>
    </div>
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="return" value="<?php echo $input->getCmd( 'return' ); ?>" />
    <?php echo JHtml::_( 'form.token' ); ?>
</form>