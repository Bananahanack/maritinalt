<?php

// No direct access
defined( '_JEXEC' ) or die;
//require_once (JPATH_ROOT.DS.'components'.DS.'com_maritina_rates'.DS.'gsheet'.DS.'input.php');
require_once(JPATH_LIBRARIES.DS.'gsheetlib'.DS.'google-api-client'.DS.'vendor'.DS.'autoload.php');




/**
 * Model for edit/create current element
 * @author Bananahanack
 */
class Maritina_RatesModelForm extends JModelAdmin
{
	/**
	 * Method of loading the current form
	 * @param Array $data
	 * @param Boolean $loadData
	 * @return Object form data
	 */
	public function getForm( $data = array(), $loadData = true )
	{
		$form = $this->loadForm( '', 'form', array( 'control' => 'jform', 'load_data' => $loadData ) );
		if ( empty( $form ) ) {
			return false;
		}
		return $form;
	}

	/**
	 * Method of loading table for current item
	 * @param Sting $type (name table)
	 * @param String $prefix (prefix table)
	 * @param Array $config
	 * @return Tablermaritina_rates
	 */
	public function getTable( $type = 'rmaritina_rates', $prefix = 'Table', $config = array() )
	{
		return JTable::getInstance( $type, $prefix, $config );
	}

	/**
	 * Method of loading data to form
	 * @return Object
	 */
	protected function loadFormData()
	{
		$data = JFactory::getApplication()->getUserState( 'com_maritina_rates.edit.form.data', array() );
		if ( empty( $data ) ) {
			$data = $this->getItem();
		}
		return $data;
	}

	/**
	 * save data
	 * @param array $data
	 * @return bool
	 */
	public function save( $data )
	{
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

        $params = JComponentHelper::getParams( 'com_maritina_rates' );
        $spreadsheetId = $params->get('spreadsheet_id_riga');
        $range_riga = $params->get('range_riga');
        $spreadsheet_id_klaipeda = $params->get('spreadsheet_id_klaipeda');
        $range_klaipeda = $params->get('range_klaipeda');
        $refresh_time = $params->get('refresh_time');
        $d_port = mb_strtolower(trim($data['d_port']));
        $ft = $data['ft'];

        $service = getClient();
//массив из таблицы
        $riga_20ft_40ft_list = getDataFromSheet($service, $spreadsheetId, $range_riga, $last_update = 0);
        $klaipeda_20ft_40ft_list = getDataFromSheet($service, $spreadsheetId, $range_klaipeda, $last_update = 0);
        $last_update = time();
//найденные ячейки
        $riga_search_result = searchNeeded($d_port, $ft, $riga_20ft_40ft_list);
        $klaipeda_search_result = searchNeeded($d_port, $ft, $klaipeda_20ft_40ft_list);

        $result = array(
            'd_port' => $d_port,
            'rate_riga' => $riga_search_result[$d_port],
            'rate_klaipeda' => $klaipeda_search_result[$d_port]
        );

        $body = '<table class="table table-bordered table-striped table-hover">';
        $body .= '<tr><td>Порт:</td><td>' . $result['d_port'] . '</td></tr>';
        $body .= '<tr><td>Container type:</td><td>' . $ft . '</td></tr>';
        $body .= '<tr><td>E-mail:</td><td>' . $data['email'] . '</td></tr>';
        $body .= '<tr><td>Rate Riga:</td><td>' . $result['rate_riga']  . '</td></tr>';
        $body .= '<tr><td>Rate Klaipeda:</td><td>' . $result['rate_klaipeda']. '</td></tr>';
        $body .= '<tr><td>Message:</td><td>' . $data['message'] . '</td></tr>';
        $body .= '</table>';

		$table = $this->getTable( 'rmaritina_rates' );

		$archiveData = array(
        'title' => 'Порт: ' . $data['d_port'],
        'text' => $body
    	);
        //Заносим данные в таблицу
    	$table->bind( $archiveData );
	    if ( $table->store() ) {
	    	return true;
	    }
	    return false;

		// return parent::save( $data );
	}

}