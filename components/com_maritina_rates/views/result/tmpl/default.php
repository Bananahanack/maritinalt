<?php
/** @var $this Maritina_RatesViewResult */
defined( '_JEXEC' ) or die; // No direct access
?>
<div class="item-page">
	<h1>инфа из конфига</h1>
 	<?php
 	//получение инфы из конфига
    $params = JComponentHelper::getParams( 'com_maritina_rates' );
    $spreadsheet_id_riga = $params->get('spreadsheet_id_riga');
    $range_riga = $params->get('range_riga');
    $spreadsheet_id_klaipeda = $params->get('spreadsheet_id_klaipeda');
    $range_klaipeda = $params->get('range_klaipeda');
    $refresh_time = $params->get('refresh_time');

    echo $spreadsheet_id_riga .    ' <br>';
    echo $range_riga .    ' <br>';
    echo $spreadsheet_id_klaipeda .    ' <br>';
    echo $range_klaipeda .    ' <br>';
    echo $refresh_time;
   
    ?> 
</div>
