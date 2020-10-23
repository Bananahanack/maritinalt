<?php
/** @var $this MaritinaViewMaritina */
defined( '_JEXEC' ) or die; // No direct access
?>
<div class="item-page">
	<h1></h1>
<!--	<form action="--><?php //echo JRoute::_( 'index.php?view=Maritina' ) ?><!--" method="post" class="form-validate">-->

    <form action="" method="post" id="formRates" class="ui-form">

        <label for="form[l_port]" style="color: white">Loading port: </label>
        <span class="custom-dropdown">
            <select name="form[l_port]" id="l_port" onchange="loadDPort(this)">
                    <option></option>
                    <option value="RIGA">RIGA</option>
                    <option value="KLAIPEDA">KLAIPEDA</option>
            </select>
        </span>

        <br></br>

        <label for="form[d_port]" style="color: white">Destination port: </label>
        <span class="custom-dropdown">
            <select name="form[d_port]" id="d_port" disabled="disabled">
                    <option>Select loading port</option>
            </select>
        </span>

        <section class="dark">
            <p style="color: white">Container Size:</p>
            <label id="l1">
                <input type="radio" name="form[ft]" id="ft1" value="20ft" checked>
                <span class="design"></span>
                <span class="text">20ft</span>
            </label>
        </section>
        <section class="dark">
            <label id="l2">
                <input type="radio" name="form[ft]" id="ft2" value="40ft">
                <span class="design"></span>
                <span class="text">40ft</span>
            </label>
        </section>

        <div id="dive">
            <label for="email" style="color: white">Email:</label>
            <input type="text" name="form[email]" id="email" value="" required="required" style="border-radius: 11px;">
        </div>

        <div>
            <label for="message" style="color: white">Comment</label>
            <textarea cols="1" rows="2"  name="form[message]" id="message" style="width: 85%; background: rgba(255,255,255,1);color: black;resize: horizontal;border-radius: 11px;"></textarea>
        </div>

        <input type="hidden" name="option" value="com_maritina">
        <input type="hidden" name="task" value="maritina.send">
        <button type="submit" id="btn">Get Rate</button>
        <?php echo JHtml::_( 'form.token' ); ?>
        <br><br>
        <div id="get_rates_form_result"></div>

	</form>

</div>

<script>
    function loadDPort(select) {
        var dPortSelect = $('select[name="form[d_port]"]');
        dPortSelect.attr('disabled', 'disabled'); // делаем список не активным

        $.getJSON('index.php?option=com_maritina&task=maritina.getDportData',
            {action: 'getDestinationPort', l_port: select.value},
            function(lPortList){
                dPortSelect.html(''); // очищаем список

                // заполняем список пришедшими данными
                $.each(lPortList, function(i){
                    dPortSelect.append(
                        '<option value="' + this + '">' + this + '</option>'
                    );
                });
                dPortSelect.removeAttr('disabled'); // делаем список активным
            });
    }

    jQuery(document).ready(function ($) {
        $('#formRates').submit(function (e) {
            e.preventDefault();
            var form = $(this);
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
                        '<p style="color: black">' + response + '</p>'
                        // '<table>' +
                        // '<tr> ' +
                        // '<th style="background: #8b98b0">' + response + '</th>' +
                        // ' </tr>' +
                        // '</table>'
                    );
                }
            });
        });
    });

</script>
