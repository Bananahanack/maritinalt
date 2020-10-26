<?php
// No direct access
defined( '_JEXEC' ) or die;
require_once(JPATH_LIBRARIES.DIRECTORY_SEPARATOR.'gsheetlib'.DIRECTORY_SEPARATOR.'google-api-client'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php');


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
     * Данные
     * @since version
     */
    public function getRiga(){
        $jinput = JFactory::getApplication()->input;
        $action = $jinput->get('action');
        $lPort = $jinput->get('l_port');

        $itemsRiga = self::getPortsList('riga_data_list');

        $items = array(
            'RIGA' => $itemsRiga,
        );

        if($action == 'getDestinationPort'){
            if(isset($lPort) && $lPort != ''){
                echo json_encode($items[$lPort]);
            }else{
                echo json_encode(array('Select loading port'));
            }
            exit;
        }
    }

    public function getKlaipeda(){
        $jinput = JFactory::getApplication()->input;
        $action = $jinput->get('action');
        $lPort = $jinput->get('l_port');

        $itemsKlaipeda = self::getPortsList('klaipeda_data_list');

        $items = array(
            'KLAIPEDA' => $itemsKlaipeda
        );

        if($action == 'getDestinationPort'){
            if(isset($lPort) && $lPort != ''){
                echo json_encode($items[$lPort]);
            }else{
                echo json_encode(array('Select loading port'));
            }
            exit;
        }
    }

    /**
     * Данные в дропдаунах
     * @since version
     */
    public function getDportData(){
        $jinput = JFactory::getApplication()->input;
        $action = $jinput->get('action');
        $lPort = $jinput->get('l_port');

        $itemsRiga = self::getPortsList('riga_data_list');
        $itemsKlaipeda = self::getPortsList('klaipeda_data_list');

        $items = array(
            'RIGA' => $itemsRiga,
            'KLAIPEDA' => $itemsKlaipeda
        );

        if($action == 'getDestinationPort'){
            if(isset($lPort) && $lPort != ''){
                echo json_encode($items[$lPort]);
            }else{
                echo json_encode(array('Select loading port'));
            }
            exit;
        }
    }

    /**
     * Обработка запроса Get Rates
     * @since version
     */
    public function send(){
        if ( !JSession::checkToken() ) exit; //Проверка токена

        $form = $this->input->get( 'form', [ ], 'array' ); //получаем данные формы
        if ( !filter_var( $form['email'], FILTER_VALIDATE_EMAIL ) ) $this->printJson( 'Invalid E-mail!' );//проверка E-mail

        $l_port = mb_strtoupper(trim($form['l_port']));
        $d_port = mb_strtoupper(trim($form['d_port']));
        $ft = $form['ft'];

        $this->refresh();

        $riga_20ft_40ft_list = json_decode($this->getModel()->getDataFromDb('riga_data_list'), true);
        $klaipeda_20ft_40ft_list = json_decode($this->getModel()->getDataFromDb('klaipeda_data_list'), true);

        $result = NULL;
        //найденные ячейки
        if($l_port == 'RIGA'){
            $result = self::searchNeeded($d_port, $ft, $riga_20ft_40ft_list);
        }elseif ($l_port == 'KLAIPEDA'){
            $result =  self::searchNeeded($d_port, $ft, $klaipeda_20ft_40ft_list);
        }

        //-------------------------------------------------------------------------
        if ( $this->getModel()->saveRequest( $form, $result ) ) { //дергаем в модели метод saveRequest, и если вернулось true то выполняем какие то действия и выводим сообщение
            echo json_encode($result);
            exit;
//            $this->printJson( 'Request completed!', true );
        }

        $this->printJson( 'Request Error!' );//если не удалось сохранить
        exit;
    }
    //-------------------------------------------------------------------------
    /*
                    FUNCTIONS
    */
    public function getPortsList($dbColumnName){
        $portList = json_decode($this->getModel()->getDataFromDb($dbColumnName), true);
        return array_column($portList, 'port');
    }

    //получения данных из гшит либо из бд по таймеру
    public function refresh(){
        //получение данных из конфига
        $params = JComponentHelper::getParams( 'com_maritina' );
        $spreadsheetId_riga = $params->get('spreadsheet_id_riga');
        $range_riga = $params->get('range_riga');
        $spreadsheetid_klaipeda = $params->get('spreadsheet_id_klaipeda');
        $range_klaipeda = $params->get('range_klaipeda');
        $refreshTime = (int)$params->get('refresh_time');

        $currentTime = time();

        $dbTime = intval($this->getModel()->getDataFromDb('time'));
        if($dbTime === null || (($currentTime - $dbTime) > $refreshTime && $refreshTime !== 0)){
            $service = self::getClient();

            //массив всех данных из гшита
            $riga_20ft_40ft_list = self::getDataFromSheet($service, $spreadsheetId_riga, $range_riga);
            $klaipeda_20ft_40ft_list = self::getDataFromSheet($service, $spreadsheetid_klaipeda, $range_klaipeda);

            $this->getModel()->truncateDb();
            $this->getModel()->saveData($currentTime, $riga_20ft_40ft_list, $klaipeda_20ft_40ft_list);
        }
    }

//поиск нужного значения
    public function searchNeeded($d_port_needed, $ft_needed, $dp_list){
        $result = null;
        $key = array_search($d_port_needed, array_column($dp_list, 'port'));
        if(false !== $key){
//            $result = array($dp_list[$key]['port'] => $dp_list[$key][$ft_needed]);
              $result = $dp_list[$key][$ft_needed];
        }else{
            $result = "No data found.";
        }
        return $result;
    }

//вынимаем данные из таблицы
    public function getDataFromSheet($service, $spreadsheetId, $range){
        $response = $service->spreadsheets_values->get($spreadsheetId, $range, ['valueRenderOption' => 'UNFORMATTED_VALUE']);
        $values = $response->getValues();
        $valuesList = null;
        $cellNumber = 0;
        $i = 0;

        foreach ( $values as $row ){
            if($cellNumber < count($row)){
                $cellNumber = count($row);
            }
        }

        if (empty($values)) {
            throw new \http\Exception\RuntimeException("NO DATA IN GOOGLE SPREADSHEET FILE");
        }else{
            foreach ($values as $row) {
                if( $cellNumber > count($row) || ($row[0] === '')){
                    continue;
                }
                $valuesList[$i] = array(
                    'port' => trim(mb_strtoupper($row[0])),
                    '20ft' => trim($row[count($row) - 2]),
                    '40ft' => trim($row[count($row) - 1])
                );
                $i++;
            }
        }
        return $valuesList;
    }
//подключение к шит апи
    public function getClient(){
        //oAuth
        $googleAccountKeyFilePath = JPATH_LIBRARIES.DIRECTORY_SEPARATOR.'gsheetlib'.DIRECTORY_SEPARATOR. 'credentialsGSheets.json';
        putenv( 'GOOGLE_APPLICATION_CREDENTIALS=' . $googleAccountKeyFilePath );

        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
        $service = new Google_Service_Sheets( $client );
        return $service;
    }
    //-------------------------------------------------------------------------
}
