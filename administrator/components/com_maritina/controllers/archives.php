<?php

// No direct access
defined( '_JEXEC' ) or die;
require_once(JPATH_LIBRARIES.DIRECTORY_SEPARATOR.'gsheetlib'.DIRECTORY_SEPARATOR.'google-api-client'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php');
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

        if(!$this->getModel()->truncateDb()){
            echo 'Can\'t trunkate table "#__maritina_refresh". The output data in Maritina form can be wrong!!! ';
        }elseif ($this->getModel()->saveData($currentTime, $riga_20ft_40ft_list, $klaipeda_20ft_40ft_list)){
            $this->setRedirect(JRoute::_('index.php?option=com_maritina&view=archives', false));
        }else{
            echo 'Somthing wrong with DataBase!!!(table doesn\'t exist etc.)';
            echo var_dump($riga_20ft_40ft_list);
            echo var_dump($klaipeda_20ft_40ft_list);
        }
    }

//вынимаем данные из таблицы
    public function getDataFromSheet($service, $spreadsheetId, $range){
        $response = $service->spreadsheets_values->get($spreadsheetId, $range, ['valueRenderOption' => 'UNFORMATTED_VALUE']);
        $values = $response->getValues();
        $valuesList = NULL;
        $cellNumber = 0;
        $i = 0;

        foreach ($values as $row){
            if($cellNumber < count($row)){
                $cellNumber = count($row);
            }
        }

        if (empty($values)) {
            throw new \http\Exception\RuntimeException("NO DATA IN GOOGLE SPREADSHEET FILE");
        }else{
            foreach ($values as $row) {
                if( $cellNumber > count($row) || ($row[0] === '') ){
                    continue;
                }
                $valuesList[$i] = array(
                    'port' => trim(mb_strtoupper($row[0])),
                    '20ft' => trim($row[count($row) - 4]) . ' ' . trim($row[count($row) - 3]) . ' ' . trim($row[count($row) - 1]),
                    '40ft' => trim($row[count($row) - 4]) . ' ' . trim($row[count($row) - 2]) . ' ' . trim($row[count($row) - 1])
//                    'terms' => trim($row[count($row) - 1])
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
