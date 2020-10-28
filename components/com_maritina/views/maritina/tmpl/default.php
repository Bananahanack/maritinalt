<?php
/** @var $this MaritinaViewMaritina */
defined( '_JEXEC' ) or die; // No direct access
?>

<div class="contact" id = "cont_form">
    <form action="" method="post" id="formRates" class="ui-form">

        <div class="form-row">
            <label for="form[l_port]">Loading port:</label>
            <span class="custom-dropdown">
                <select name="form[l_port]" id="l_port" onchange="loadDPort(this)" required="required" >
                        <option value="">Please Select</option>
                        <option value="RIGA">RIGA</option>
                        <option value="KLAIPEDA">KLAIPEDA</option>
                </select>
            </span>
        </div>

        <div class="form-row">
            <label for="form[d_port]">Destination port:</label>
            <span class="custom-dropdown">
                <select name="form[d_port]" id="d_port" disabled="disabled">
                        <option>Select loading port</option>
                </select>
            </span>
        </div>

        <div class="form-row" id="rad" >
            <label>Container Size:</label>
            <section class="dark">
                <label id="l1">
                    <input type="radio" name="form[ft]" id="ft1" value="20ft" checked>
                    <span class="design"></span>
                    <span class="text">20ft</span>
                </label>
                <label id="l2">
                    <input type="radio" name="form[ft]" id="ft2" value="40ft">
                    <span class="design"></span>
                    <span class="text">40ft</span>
                </label>
            </section>
        </div>

        <div class="form-row">
<!--                <span class="error" id="error" aria-live="polite"> </span>-->
                <label class="error" id="error">Invalid E-mail!</label>
                <input type="email" name="form[email]" id="email" value="" autocomplete="off" placeholder="Email" required="required">
        </div>

        <div class="form-row">
            <textarea placeholder="Message..." rows="4"  name="form[message]" id="message"></textarea>
        </div>

            <input type="hidden" name="option" value="com_maritina">
            <input type="hidden" name="task" value="maritina.send">
            <input type="submit" id="btn" value="GET QUOTE">
            <?php echo JHtml::_( 'form.token' ); ?>

	</form>
</div>

    <div  class="contact" id="get_rates_form_result"/>

<script>

    window.onload = function (){
        $.getJSON('index.php?option=com_maritina&task=maritina.getRiga',
            {action: 'getDestinationPort', l_port: 'RIGA'},
            function (response){
                localStorage.removeItem('RIGA');
                localStorage.setItem('RIGA', JSON.stringify(response));
            });
        $.getJSON('index.php?option=com_maritina&task=maritina.getKlaipeda',
            {action: 'getDestinationPort', l_port: 'KLAIPEDA'},
            function (response){
                localStorage.removeItem('KLAIPEDA');
                localStorage.setItem('KLAIPEDA', JSON.stringify(response));
            });
    }

    function loadDPort(select) {
        var dPortSelect = $('select[name="form[d_port]"]');
        dPortSelect.html(
            '<option value="">' + 'Select loading port' + '</option>'
         ); // очищаем список
        dPortSelect.attr('disabled', 'disabled'); // делаем список неактивным
        const riga ='RIGA';
        const klaipeda = 'KLAIPEDA';

        if(select.value === riga){
            dPortSelect.html(''); // очищаем список
            const dPortList =  JSON.parse(localStorage.getItem(riga));
            $.each(dPortList, function (i) {
                dPortSelect.append(
                    '<option value="' + dPortList[i] + '">' + this + '</option>'
                );
            });
            dPortSelect.removeAttr('disabled'); // делаем список активным
        }else if(select.value === klaipeda){
            dPortSelect.html(''); // очищаем список
            const dPortList =  JSON.parse(localStorage.getItem(klaipeda));
            $.each(dPortList, function (i) {
                dPortSelect.append(
                    '<option value="' + dPortList[i] + '">' + this + '</option>'
                );
            });
            dPortSelect.removeAttr('disabled'); // делаем список активным
        }
    }

    jQuery(document).ready(function ($) {
        $('#formRates').submit(function (e) {
            e.preventDefault();
            function validateEmail(email) {
                const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            }
            let error = $('#error');
            let emailAttr = $('#email');
            let email = emailAttr.val();
            if(validateEmail(email)){
                // error.text('');
                //костыль
                emailAttr.css('border', 'none');
                error.css('color', 'rgba(255,255,255,0)');
                error.css('background-color', 'rgba(255,255,255,0)');
                var form = $(this);
                $.ajax({
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    url: form.attr('action'),
                    data: form.serializeArray(),
                    success: function (response) {
                        if(response.result){
                            $('#get_rates_form_result').html(
                                '<h3 class="h3">'
                                + 'Your quote: '+ response.message +
                                '</h3>'
                            );
                            console.log(response.message);
                        }else if(response.message === 'Invalid E-mail!'){
                            emailAttr.css('border', '1px solid red');
                            error.css('color', 'rgba(255,255,255,1)');
                            error.css('background-color', '#900');
                        }else{
                            $('#get_rates_form_result').html(
                                '<h3 class="h3">'
                                + response.message +
                                '</h3>'
                            );
                        }
                    }
                });

            }else{
                emailAttr.css('border', '1px solid red');
                // error.text('Invalid E-mail!');
                //костыль
                error.css('color', 'rgba(255,255,255,1)');
                error.css('background-color', '#900');
            }
        });
    });

</script>
