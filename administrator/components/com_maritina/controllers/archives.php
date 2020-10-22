<?php

// No direct access
defined( '_JEXEC' ) or die;
require_once(JPATH_LIBRARIES.DS.'gsheetlib'.DS.'google-api-client'.DS.'vendor'.DS.'autoload.php');
/**
 * Controller for list current element
 * @author Aleks.Denezh
 */
class MaritinaControllerArchives extends JControllerAdmin
{

	/**
	 * Class constructor
	 * @param array $config
	 */
	function __construct( $config = array() )
	{
		parent::__construct( $config );
	}

	/**
	 * Method to get current model
	 * @param String $name (model name)
	 * @param String $prefix (model prefox)
	 * @param Array $config
	 * @return model for current element
	 */
	public function getModel( $name = 'Archive', $prefix = 'MaritinaModel', $config = array( 'ignore_request' => true ) )
	{
		return parent::getModel( $name, $prefix, $config );
	}

	/**
	 * Method to save the submitted ordering values for records via AJAX.
	 * @return    void
	 */
	public function saveOrderAjax()
	{
		$pks = $this->input->post->get( 'cid', array(), 'array' );
		$order = $this->input->post->get( 'order', array(), 'array' );

		// Sanitize the input
		JArrayHelper::toInteger( $pks );
		JArrayHelper::toInteger( $order );

		// Get the model
		$model = $this->getModel();

		// Save the ordering
		$return = $model->saveorder( $pks, $order );

		if ( $return ) {
			echo '1';
		}

		// Close the application
		JFactory::getApplication()->close();
	}

//-------------------------------------------------------------------------
    /*
                    FUNCTIONS
    */
    public function update(){
        //получение данных из конфига
        $params = JComponentHelper::getParams( 'com_maritina' );
        $spreadsheetId_riga = $params->get('spreadsheet_id_riga');
        $range_riga = $params->get('range_riga');
        $spreadsheetid_klaipeda = $params->get('spreadsheet_id_klaipeda');
        $range_klaipeda = $params->get('range_klaipeda');
        $currentTime = time();

        $service = self::getClient();
        //массив всех данных из гшита
        $riga_20ft_40ft_list = self::getDataFromSheet($service, $spreadsheetId_riga, $range_riga);
        $klaipeda_20ft_40ft_list = self::getDataFromSheet($service, $spreadsheetid_klaipeda, $range_klaipeda);
        $this->getModel()->truncateDb();
        $this->getModel()->saveData($currentTime, $riga_20ft_40ft_list, $klaipeda_20ft_40ft_list);



//	    return true;
    }

    //вынимаем данные из таблицы
    public function getDataFromSheet($service, $spreadsheetId, $range){
        $response = $service->spreadsheets_values->get($spreadsheetId, $range, ['valueRenderOption' => 'UNFORMATTED_VALUE']);
        $values = $response->getValues();
        $list = null;
        $i = 0;
        if (empty($values)) {
            print "No data found.\n";
        }else{
            foreach ($values as $row) {
                if( trim($row[0]) === '' || (trim($row[count($row) - 2]) === '' && trim($row[[count($row) - 1]]) === '')){
                    continue;
                }
                $list[$i] = array(
                    'port' => mb_strtoupper($row[0]),
                    '20ft' => $row[count($row) - 2],
                    '40ft' => $row[count($row) - 1]);
                $i++;

            }
        }
        return $list;
    }

    //подключение к шит апи
    public function getClient(){
        //oAuth
        $googleAccountKeyFilePath = __DIR__ . '/credentialsGSheets.json';
        putenv( 'GOOGLE_APPLICATION_CREDENTIALS=' . $googleAccountKeyFilePath );

        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
        $service = new Google_Service_Sheets( $client );
        return $service;
        //
    }
    //-------------------------------------------------------------------------
}