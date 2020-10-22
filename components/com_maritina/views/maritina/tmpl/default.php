<?php
/** @var $this MaritinaViewMaritina */
defined( '_JEXEC' ) or die; // No direct access
?>
<div class="item-page">
	<h1>
    </h1>

<!--	<form action="--><?php //echo JRoute::_( 'index.php?view=Maritina' ) ?><!--" method="post" class="form-validate">-->

    <form action="" method="post" id="formRates" class="ui-form">

<!--        <div>-->
<!--            <label for="d_port">Discharge port</label>-->
<!--            <input type="text" name="form[d_port]" id="d_port" value="" required="required">-->
<!---->
<!--        </div>-->
        <label for="l_port" style="color: white">Loading port: </label>
        <span class="custom-dropdown">
            <select name="form[l_port]" id="l_port"">
                    <option>RIGA</option>
                    <option>KLAIPEDA</option>
            </select>
        </span>

        <br></br>

        <?php
        if ($this->items !== 0) {
            ?>
            <label for="d_port" style="color: white">Discharge port: </label>
        <span class="custom-dropdown">
            <select name="form[d_port]" id="d_port"">
                <?php foreach ($this->items as $item) { ?>
                    <option><?php echo $item; ?></option>
                <?php } ?>
            </select>
        </span>
            <?php
        } else {
            echo 'Sorry! No data found...';
        }
        ?>

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
        <button type="submit" id="btn">Get Rates</button>

        <?php echo JHtml::_( 'form.token' ); ?>
        <br><br>
        <div id="get_rates_form_result"></div>

	</form>

</div>

<script>
    jQuery(document).ready(function ($) {
        $('#formRates').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            // var email = $("#email").val();

            //form.find('button[type="submit"]').hide();
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
                        '<table>' +
                            '<tr> ' +
                                '<th style="background: #8b98b0" style="border-radius: 10px;">Port of Dispatch</th>' +
                                '<th style="background: #8b98b0">Destination port</th>' +
                                '<th style="background: #8b98b0">Selling rates</th>' +
                            ' </tr>' +
                            '<tr> ' +
                                '<th style="background: #cfdbdb"><label style="color: #808080">RIGA</label></th>' +
                                '<th style="background: #cfdbdb"><label style="color: #808080">'+response.d_port+'</label></th>' +
                                '<th style="background: #cfdbdb"><label style="color: #808080">'+response.rate_riga+'</label></th>' +
                            ' </tr>' +
                            '<tr> ' +
                                '<th style="background: #cfdbdb"><label style="color: #808080">KLAIPEDA</th>' +
                                '<th style="background: #cfdbdb"><label style="color: #808080">'+response.d_port+'</label></th>' +
                                '<th style="background: #cfdbdb"><label style="color: #808080">'+response.rate_klaipeda+'</label></th>' +
                            ' </tr>' +
                        '</table>'
                    );
                }
            });
        });
    });
</script>

<!--        <div >-->
<!--            <div>-->
<!--                <select name="form[ft]" id="ft" style="width: 25%">-->
<!--                    <option value="20ft" selected>20ft</option>-->
<!--                    <option value="40ft">40ft</option>-->
<!--                </select>-->
<!--            </div>-->