<?php
/** @var $this Maritina_RatesViewForm */
defined( '_JEXEC' ) or die; // No direct access
?>
<div>
    <h1></h1>

    <form action="<?php echo JRoute::_( 'index.php?view=Form' ) ?>" method="post" id="get_rates_form">
        <div>
            <div ><?php echo $this->form->getLabel( 'd_port' ); ?></div>
            <div ><?php echo $this->form->getInput( 'd_port' ); ?></div>
        </div>

        <div >
            <div ><?php echo $this->form->getLabel( 'ft' ); ?></div>
            <div ><?php echo $this->form->getInput( 'ft' ); ?></div>
        </div>

        <div >
            <div ><?php echo $this->form->getLabel( 'email' ); ?></div>
            <div ><?php echo $this->form->getInput( 'email' ); ?></div>
        </div>
        <div >
            <div ><?php echo $this->form->getLabel( 'message' ); ?></div>
            <div ><?php echo $this->form->getInput( 'message' ); ?></div>
        </div>

        <input type="hidden" name="task" value="Form.save" />
        <input type="submit" value="Get rates" />
<!--        <input type="submit" id="btn" value="Get rates" />-->
        <?php echo JHtml::_( 'form.token' ); ?>
<!--        --><?php //echo JHtml::_('jquery.framework', false);?>

    </form>

<!--    <div id="get_rates_form_result"></div>-->
</div>
<!--<div class="item-page">-->
<!--	<h1></h1>-->
<!---->
<!--	<form action="--><?php //echo JRoute::_( 'index.php?view=Form' ) ?><!--" method="post" class="form-validate">-->
<!---->
<!--		<div class="control-group form-inline">-->
<!--			<div class="control-label">--><?php //echo $this->form->getLabel( 'd_port' ); ?><!--</div>-->
<!--			<div class="controls">--><?php //echo $this->form->getInput( 'd_port' ); ?><!--</div>-->
<!--		</div>-->
<!---->
<!--		<div class="control-group form-inline">-->
<!--			<div class="control-label">--><?php //echo $this->form->getLabel( 'ft' ); ?><!--</div>-->
<!--			<div class="controls">--><?php //echo $this->form->getInput( 'ft' ); ?><!--</div>-->
<!--		</div>-->
<!---->
<!--		<div class="control-group form-inline">-->
<!--			<div class="control-label">--><?php //echo $this->form->getLabel( 'email' ); ?><!--</div>-->
<!--			<div class="controls">--><?php //echo $this->form->getInput( 'email' ); ?><!--</div>-->
<!--		</div>-->
<!--		<div class="control-group form-inline">-->
<!--			<div class="control-label">--><?php //echo $this->form->getLabel( 'message' ); ?><!--</div>-->
<!--			<div class="controls">--><?php //echo $this->form->getInput( 'message' ); ?><!--</div>-->
<!--		</div>-->
<!---->
<!--		<input type="hidden" name="task" value="Form.save" />-->
<!--		<input type="submit" value="Get rates" />-->
<!--		--><?php //echo JHtml::_( 'form.token' ); ?>
<!--	</form>-->
<!--</div>-->