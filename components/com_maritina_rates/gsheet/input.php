<?php
require_once 'vendor/autoload.php';
// require_once __DIR__ . '/vendor/autoload.php';
//require_once(JPATH_LIBRARIES.DS.'gsheetlib'.DS.'google-api-client'.DS.'vendor'.DS.'autoload.php');

//Настраиваемые поля
/*
	$range //от крайней верхней левой ячейки до крайней нижней правой
	$refresh_time //частота обновления данных
	$spreadsheetId //ID таблицы
*/
$range_riga = 'Riga!A3:T18';
$range_klaipeda = 'Klaipeda!A3:T19';
$spreadsheetId = '1RrZDlTUxSYVwYSmN3pAeUk6UGDsbbH4z_-wvpb1e4IY';


//htmlspecialchars(сикурити)
$d_port = mb_strtolower(trim(htmlentities($_POST['d_port'])));
$ft = htmlentities($_POST['ft']);
$email = htmlentities($_POST['email']);
$comment = htmlentities($_POST['comment']);

$riga_20ft_40ft_list;
$klaipeda_20ft_40ft_list;

$service = getClient();

//массив из таблицы 
$riga_20ft_40ft_list = getDataFromSheet($service, $spreadsheetId, $range_riga, $last_update);
$klaipeda_20ft_40ft_list = getDataFromSheet($service, $spreadsheetId, $range_klaipeda, $last_update);
$last_update = time();
//найденные ячейки
$riga_search_result = searchNeeded($d_port, $ft, $riga_20ft_40ft_list);
$klaipeda_search_result = searchNeeded($d_port, $ft, $klaipeda_20ft_40ft_list);

$result = array(
	'd_port' => $d_port,
	'rate_riga' => $riga_search_result[$d_port],
	'rate_klaipeda' => $riga_search_result[$d_port]
);

    echo json_encode($result); 

// print_r($riga_search_result);
// br(2);
// print_r($klaipeda_search_result);

/*
	FUNCTIONS
*/
//поиск нужного значения
function searchNeeded($d_port_needed, $ft_needed, $dp_20ft_40ft_list){
	$result;
	$key = array_search($d_port_needed, array_column($dp_20ft_40ft_list, 'port'));
	if(false !== $key){
		$result = array($dp_20ft_40ft_list[$key]['port'] => $dp_20ft_40ft_list[$key][$ft_needed]); 
	}else{
		$result = "No data found.";
	}	
	return $result;
}

//вынимаем данные из таблицы
function getDataFromSheet($service, $spreadsheetId, $range, $time){
	$response = $service->spreadsheets_values->get($spreadsheetId, $range, ['valueRenderOption' => 'UNFORMATTED_VALUE']);
	$values = $response->getValues();
	$list;
	$i = 0;
	if (empty($values)) {
		    print "No data found.\n";
		}else{
			foreach ($values as $row) {	
				$list[$i] = array(
					'port' => mb_strtolower($row[0]),
					'20ft' => $row[18], 
					'40ft' => $row[19]);
				$i++;
			}

		}
	return $list;
}
//подключение к апи
function getClient(){
	//oAuth
	$googleAccountKeyFilePath = __DIR__ . '/credentialsGSheets.json';
	putenv( 'GOOGLE_APPLICATION_CREDENTIALS=' . $googleAccountKeyFilePath );

	$client = new Google_Client();
	$client->useApplicationDefaultCredentials();
	// $client->addScope( 'https://www.googleapis.com/auth/spreadsheets' );
	$client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
	$service = new Google_Service_Sheets( $client );
	return $service;
}
//перевод строки
function br($n){
	for ($i=0; $i < $n; $i++) { 
		echo "<br />";
	}
}




//шпаргалочка
/*
echo gettype($d_port);

echo sprintf($mask, $row[0], $row[18], $row[19])."<br />";
$mask = "%10s %-10s %s\n";

			foreach ($values as $key => $value) {
				//echo "$key ";
				foreach ($value as $key => $value) {
					//echo "$value<br />";
					$list[$i] = $value;
					$i++;	
				}

*/

/*$d_port;
$ft;
$email;
$comment;
if(isset($_POST['d_port']) && isset($_POST['email']))
{
	$d_port = htmlentities($_POST['d_port']);
	$ft = htmlentities($_POST['ft']);
	$email = htmlentities($_POST['email']);
	$comment = htmlentities($_POST['comment']);		
}
echo "$d_port <br> $ft <br> $email <br> $comment";

if (empty($values)) {
	// 	    print "No data found.\n";
	// 	}else{
	// 		foreach ($values as $row) {	
	// 			$list[$row[0]] = array($row[18]=>$row[19]);
	// 		}


	<?php
$ranges = [
    // Range names ...
];
$params = array(
    'ranges' => $ranges
);
$result = $service->spreadsheets_values->batchGet($spreadsheetId, $params);
printf("%d ranges retrieved.", count($result->getValueRanges()));
*/


?>


