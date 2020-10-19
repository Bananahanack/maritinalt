<?php
/** @var $this MaritinaViewMaritina */
defined( '_JEXEC' ) or die; // No direct access
?>
<div class="item-page">
	<h1></h1>

<!--	<form action="--><?php //echo JRoute::_( 'index.php?view=Maritina' ) ?><!--" method="post" class="form-validate">-->

    <form action="" method="post" id="formRates" class="ui-form">

        <div class="form-row">
            <input type="text" name="form[d_port]" id="d_port" value="" required="required">
            <label for="d_port">Discharge port</label>
        </div>

        <div class="form-row">
            <div class="dropdown">
                <select name="form[ft]" id="ft" class="dropdown-select">
                    <option value="20ft" selected>20ft</option>
                    <option value="40ft">40ft</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <input type="email" name="form[email]" id="email" value="" required="required">
            <label for="email">E-mail</label>
        </div>

        <div class="form-row">
        </div>

        <div class="form-row">
            <textarea name="form[message]" id="message"></textarea>
            <label for="message">Comment</label>
        </div>

<!--        <input type="hidden" name="option" value="com_maritina">-->
<!--		<input type="hidden" name="task" value="Maritina.save" />-->
<!--		<input type="submit" value="Get rates" />-->

        <input type="hidden" name="option" value="com_maritina">
        <input type="hidden" name="task" value="maritina.send">
        <button type="submit">Get Rates</button>

<div id="get_rates_form_result"></div>

        <?php echo JHtml::_( 'form.token' ); ?>
	</form>
</div>
<script>
    jQuery(document).ready(function ($) {
        $('#formRates').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            form.find('button[type="submit"]').hide();
            $.ajax({
                type: 'POST',
                cache: false,
                dataType: 'json',
                url: form.attr('action'),
                data: form.serializeArray(),
                success: function (response) {
                    // if (response.result) {
                        //выполняем какие до дейстивя если нужно при успешной отправке формы

                    // }
                    $('#get_rates_form_result').html(
                        '<br><br>'+
                        'Port: '+response.d_port
                        +'<br>Rate from Riga: '+response.rate_riga
                        +'<br>Rate from Klaipeda: '+response.rate_klaipeda
                    );

                    // alert(response.d_port);
                    // form.find('button[type="submit"]').show();
                }
            });
        });
    });
</script>