<?php
// No direct access
defined( '_JEXEC' ) or die;
require_once(JPATH_LIBRARIES.DS.'gsheetlib'.DS.'google-api-client'.DS.'vendor'.DS.'autoload.php');


/**
 * Controller
 * @author Bananahanack
 */

class MaritinaControllerMaritina extends JControllerLegacy{
    /**
     * Метод получение модели единичной записи
     * Method to get current model
     * @param String $name имя модели
     * @param String $prefix прафикс модлели
     * @param array $config
     * @return PayModelPay
     * @since version 1.0
     */
    public function getModel( $name = 'Maritina', $prefix = 'MaritinaModel', $config = [ 'ignore_request' => true ] )
    {
        return parent::getModel( $name, $prefix, $config );
    }

    /**
     * Вывод JSON данных
     * @param $message
     * @param bool $result
     * @param array $custom
     * @since version 1.0
     */
    private function printJson( $message, $result = false, $custom = [ ] )
    {
        $jsonData = array( 'result' => $result, 'message' => $message );
        foreach ( $custom as $key => $value ) {
            $jsonData[$key] = $value;
        }
        echo json_encode( $jsonData );
        exit;
    }
    /**
     * Отправка данных
     * @since version
     */
    public function send()
    {
        if ( !JSession::checkToken() ) exit; //Проверка токена
        $form = $this->input->get( 'form', [ ], 'array' ); //получаем данные формы
        if ( trim( $form['d_port'] ) === '' ) $this->printJson( 'Input the port name!' ); //проверка имени
        if ( !filter_var( $form['email'], FILTER_VALIDATE_EMAIL ) ) $this->printJson( 'Invalid E-mail!' );//проверка E-mail
        //-------------------------------------------------------------------------
        /*
                работа с гшит
        */
        //получение данных из конфига
        $params = JComponentHelper::getParams( 'com_maritina' );
        $spreadsheetId = $params->get('spreadsheet_id_riga');
        $range_riga = $params->get('range_riga');
        $spreadsheet_id_klaipeda = $params->get('spreadsheet_id_klaipeda');
        $range_klaipeda = $params->get('range_klaipeda');
        $refresh_time = $params->get('refresh_time');
        $currentTime = time();

        $d_port = mb_strtolower(trim($form['d_port']));
        $ft = $form['ft'];

        $service = self::getClient();

        //массив всех данных из гшита
        $riga_20ft_40ft_list = self::getDataFromSheet($service, $spreadsheetId, $range_riga, $last_update = 0);
        $klaipeda_20ft_40ft_list = self::getDataFromSheet($service, $spreadsheetId, $range_klaipeda, $last_update = 0);

        //найденные ячейки
        $riga_search_result = self::searchNeeded($d_port, $ft, $riga_20ft_40ft_list);
        $klaipeda_search_result = self::searchNeeded($d_port, $ft, $klaipeda_20ft_40ft_list);

        $result = array(
            'd_port' => $d_port,
            'rate_riga' => $riga_search_result[$d_port],
            'rate_klaipeda' => $klaipeda_search_result[$d_port]
        );

        //-------------------------------------------------------------------------
        if ( $this->getModel()->saveRequest( $form ) ) { //дергаем в модели метод saveRequest, и если вернулось true то выполняем какие то действия и выводим сообщение
//            echo new JResponseJson($result);
            echo json_encode($result);
            exit;
//            $this->printJson( 'Request completed!', true );

//            echo json_encode($result);
            //$this->printJson()
        }
        $this->printJson( 'Request Error!' );//если не удалось сохранить
    }
    //-------------------------------------------------------------------------
    /*
                    FUNCTIONS
    */
//поиск нужного значения
    static function searchNeeded($d_port_needed, $ft_needed, $dp_20ft_40ft_list){
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
    static function getDataFromSheet($service, $spreadsheetId, $range, $time){
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
//подключение к шит апи
    static function getClient(){
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
    //-------------------------------------------------------------------------


}


//class MaritinaControllerMaritina extends JControllerForm
//{
//
//	/**
//	 * Class constructor
//	 * @param array $config
//	 */
//	function __construct( $config = array() )
//	{
//		$this->view_list = 'maritina';
//		parent::__construct( $config );
//	}
//
//	/**
//	 * @return bool
//	 */
//	public function allowSave()
//	{
//		return true;
//	}
//
//}