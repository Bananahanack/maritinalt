<?php
/** @var $this MaritinaViewMaritina */
defined( '_JEXEC' ) or die; // No direct access
?>
<div class="item-page">
	<h1>
    </h1>

<!--	<form action="--><?php //echo JRoute::_( 'index.php?view=Maritina' ) ?><!--" method="post" class="form-validate">-->

    <form action="" method="post" id="formRates">

<!--        <div>-->
<!--            <label for="d_port">Discharge port</label>-->
<!--            <input type="text" name="form[d_port]" id="d_port" value="" required="required">-->
<!---->
<!--        </div>-->

        <?php
        if ($this->items !== 0) {
            ?>
            <select name="form[d_port]" id="d_port" style="width: 25%">
                <?php foreach ($this->items as $item) { ?>
                    <option><?php echo $item; ?></option>
                <?php } ?>
            </select>
            <?php
        } else {
            echo 'Sorry! No data found...';
        }
        ?>

        <div >
            <div>
                <select name="form[ft]" id="ft" style="width: 25%">
                    <option value="20ft" selected>20ft</option>
                    <option value="40ft">40ft</option>
                </select>
            </div>
        </div>

        <div>
            <label for="email">E-mail</label>
            <input type="email" name="form[email]" id="email" value="" required="required">
        </div>

        <div>
        </div>

        <div>
            <label for="message">Comment</label>
            <textarea name="form[message]" id="message"></textarea>
        </div>

        <input type="hidden" name="option" value="com_maritina">
        <input type="hidden" name="task" value="maritina.send">

        <button type="submit" id="btn">Get Rates</button>

        <?php echo JHtml::_( 'form.token' ); ?>
	</form>
    <div id="get_rates_form_result"></div>



</div>
<script>

    // jQuery(document).ready(function($) {
    //     $('#d_port').autocomplete({
    //         source: function () {
    //             var form = $(this);
    //             // организуем кроссдоменный запрос
    //             $.ajax({
    //                 // type: 'POST',
    //                 // cache: false,
    //                 dataType: 'json',
    //                 url: 'index.php?format=raw&option=com_maritina&task=autoComplete',
    //                 url: form.attr('action'),
    //                 data:form.serializeArray(),
    //                 // параметры запроса, передаваемые на сервер (последний - подстрока для поиска):
    //                 // data: {
    //                 //     name_startsWith: request.term
    //                 // },
    //                 // обработка успешного выполнения запроса
    //                 success: function (response) {
    //                     // приведем полученные данные к необходимому формату и передадим в предоставленную функцию response
    //
    //                     alert(response.message);
    //                     form.find('button[type="submit"]').show();
    //                     }
    //             });
    //         },
    //         // minLength: 2
    //     });
    // });
//refresh button //

    jQuery(document).ready(function ($) {
        $('#formRates').submit(function (e) {
            e.preventDefault();
            var form = $(this);
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
                                '<th>Port of Dispatch</th>' +
                                // '<th>Destination port</th>' +
                                '<th>Selling rates</th>' +
                            ' </tr>' +
                            '<tr> ' +
                                '<th>RIGA</th>' +
                                // '<th>'+response.d_port+'</th>' +
                                '<th>'+response.rate_riga+'</th>' +
                            ' </tr>' +
                            '<tr> ' +
                                '<th>KLAIPEDA</th>' +
                                // '<th>'+response.d_port+'</th>' +
                                '<th>'+response.rate_klaipeda+'</th>' +
                            ' </tr>' +
                        '</table>'
                    );
                }
            });
        });
    });
</script>


<!--    jQuery(document).ready(function() {

        var flowers = ["Астра", "Нарцисс", "Роза", "Пион", "Примула",
            "Подснежник", "Мак", "Первоцвет", "Петуния", "Фиалка"];

        $('#d_port').autocomplete({
            source: flowers
        })
    });
    -->