<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * Model for edit/create current element
 * @author Bananahanack
 */

class MaritinaModelMaritina extends JModelLegacy{
    /**
     * Сохранение данных в базу
     * @param $data
     *
     * @param $result
     *
     * @throws Exception
     * @since version 1.0
     */
    public function saveRequest( $data , $result )
    {
        $body = '<table class="table table-bordered table-striped table-hover">';
        $body .= '<tr><td>Port:</td><td>' . $data['d_port'] . '</td></tr>';
        $body .= '<tr><td>Container type:</td><td>' . $data['ft'] . '</td></tr>';
        $body .= '<tr><td>E-mail:</td><td>' . $data['email'] . '</td></tr>';
        $body .= '<tr><td>Rate Riga:</td><td>' . $result['rate_riga']  . '</td></tr>';
        $body .= '<tr><td>Rate Klaipeda:</td><td>' . $result['rate_klaipeda']. '</td></tr>';
        $body .= '<tr><td>Comment:</td><td>' . $data['message'] . '</td></tr>';
        $body .= '</table>';


        $table_refresh = $this->getTable('maritina_refresh');
        $table_refresh->getFields();
//        $archiveData1 = array(
//          'port' => 'China',
//          'ft20' => 20,
//          'ft40' => 40,
//          'time' => time()
//        );
//
//        $table_refresh->bind( $archiveData1);
//        $table_refresh->store();


        $table = $this->getTable( 'maritina_form' );

        $archiveData = array(
            'title' => $data['message'] ,
            'text' => $body
        );
        //Заносим данные в таблицу
        $table->bind( $archiveData );
        if ( $table->store() ) {
            return true;
        }
        return false;
    }

//    public function getTimeFromDb($currentTime){
//        $table_refresh = $this->getTable('maritina_refresh');
//        $timeFromDb = 0;
//
//
//        return $timeFromDb;
//    }

}




//class MaritinaModelMaritina extends JModelAdmin
//{
//	/**
//	 * Method of loading the current form
//	 * @param Array $data
//	 * @param Boolean $loadData
//	 * @return Object form data
//	 */
//	public function getForm( $data = array(), $loadData = true )
//	{
//		$form = $this->loadForm( '', 'maritina', array( 'control' => 'jform', 'load_data' => $loadData ) );
//		if ( empty( $form ) ) {
//			return false;
//		}
//		return $form;
//	}
//
//	/**
//	 * Method of loading table for current item
//	 * @param Sting $type (name table)
//	 * @param String $prefix (prefix table)
//	 * @param Array $config
//	 * @return Tablemaritina_form
//	 */
//	public function getTable( $type = 'maritina_form', $prefix = 'Table', $config = array() )
//	{
//		return JTable::getInstance( $type, $prefix, $config );
//	}
//
//	/**
//	 * Method of loading data to form
//	 * @return Object
//	 */
//	protected function loadFormData()
//	{
//		$data = JFactory::getApplication()->getUserState( 'com_maritina.edit.maritina.data', array() );
//		if ( empty( $data ) ) {
//			$data = $this->getItem();
//		}
//		return $data;
//	}
//
//	/**
//	 * save data
//	 * @param array $data
//	 * @return bool
//	 */
//	public function save( $data )
//	{
//		return parent::save( $data );
//	}
//
//}