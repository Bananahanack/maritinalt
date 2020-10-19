<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * Model to see the current entries
 * @author Aleks.Denezh
 */
class MaritinaModelAjax extends JModelLegacy
{

	/**
	 * Вывод JSON данных
	 * @param $message
	 * @param bool $result
	 * @param array $custom
	 */
	private function printJson( $message, $result = false, $custom = array() )
	{
		$jsonData = array( 'result' => $result, 'message' => $message );
		foreach ( $custom as $key => $value ) {
			$jsonData[$key] = $value;
		}
		echo json_encode( $jsonData );
		exit;
	}
}