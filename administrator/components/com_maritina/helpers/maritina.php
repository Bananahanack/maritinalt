<?php

defined( '_JEXEC' ) or die;

/**
 * Class MaritinaHelper
 */
class MaritinaHelper
{
	/**
	 * Добавление подменю
	 * @param String $vName
	 */
	static function addSubmenu( $vName )
	{
		JHtmlSidebar::addEntry(
			JText::_( 'ARCHIVE_SUBMENU' ),
			'index.php?option=com_maritina&view=archives',
			$vName == 'archives' );
	}

	/**
	 * Получаем доступные действия для текущего пользователя
	 * @return JObject
	 */
	public static function getActions()
	{
		$user = JFactory::getUser();
		$result = new JObject;
		$assetName = 'com_maritina';
		$actions = JAccess::getActions( $assetName );
		foreach ( $actions as $action ) {
			$result->set( $action->name, $user->authorise( $action->name, $assetName ) );
		}
		return $result;
	}
}