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
        $body .= '<tr><td>Loading port:</td><td>' . $data['l_port'] . '</td></tr>';
        $body .= '<tr><td>Destination port:</td><td>' . $data['d_port'] . '</td></tr>';
        $body .= '<tr><td>Container type:</td><td>' . $data['ft'] . '</td></tr>';
        $body .= '<tr><td>E-mail:</td><td>' . $data['email'] . '</td></tr>';
        $body .= '<tr><td>Quote:</td><td>' . $result . '</td></tr>';
        $body .= '<tr><td>Comment:</td><td>' . $data['message'] . '</td></tr>';
        $body .= '</table>';

        $table = $this->getTable( 'maritina_form' );
        $archiveData = array(
            'title' => $data['email'] ,
            'text' => $body
        );

        //Заносим данные в таблицу
        $table->bind( $archiveData );
        if ( $table->store() ) {
            return true;
        }
        return false;
    }

//подтягиваем данные из БД
    public function getDataFromDb($columnString){
        $db = $this->getDbo();
        return $db->setQuery( 'SELECT ' . $columnString . ' FROM #__maritina_refresh')->loadResult();
    }

//truncate table
    public function truncateDb(){
        $db = $this->getDbo();
        if($db->setQuery( 'TRUNCATE TABLE #__maritina_refresh')->execute()){
            return true;
        }
        return false;
    }

//сохраняем данные, чтобы потом достать при запросе
    public function saveData( $currentTime, $riga_20ft_40ft_list, $klaipeda_20ft_40ft_list){
        try {
            $table = $this->getTable('maritina_refresh');
        } catch (Exception $e) {
            echo 'Can\'t found table "maritina_refresh" doesn\'t exist in DataBase', $e ->getMessage(), "\n";
        }
        $archiveData = array(
            'time' => $currentTime,
            'riga_data_list' => json_encode($riga_20ft_40ft_list),
            'klaipeda_data_list' => json_encode($klaipeda_20ft_40ft_list)
        );
        //Заносим данные в таблицу
        $table->bind( $archiveData );
        if ( $table->store() ) {
            return true;
        }
        return false;
    }
}
