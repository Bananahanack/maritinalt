jQuery( document ).ready(function() {
    $("#btn").click(
		function(){
			sendAjaxForm('get_rates_form_result', 'get_rates_form', '../../gsheet/input.php');
			return false; 
		}
	);
});
 
function sendAjaxForm(get_rates_form_result, get_rates_form, url) {
    $.ajax({
        url:     url, //url страницы (action_get_rates_form.php)
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: $("#"+get_rates_form).serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
        	result = $.parseJSON(response);
        	$('#get_rates_form_result').html(
                '<br><br>'+
                'Port: '+result.d_port
                +'<br>Rate from Riga: '+result.rate_riga
                +'<br>Rate from Klaipeda: '+result.rate_klaipeda
                );
    	},
    	error: function(response) { // Данные не отправлены
            $('#get_rates_form_result').html('Ошибка. Данные не отправлены.');
    	}
 	});
}