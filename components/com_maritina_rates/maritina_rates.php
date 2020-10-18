<?php
defined( '_JEXEC' ) or die; // No direct access
/**
 * Component maritina_rates
 * @author Bananahanack
 */
require_once JPATH_COMPONENT.'/helpers/maritina_rates.php';

JLog::addLogger(
    array('text_file' => 'com_maritina_rates.log.php'),
    JLog::ALL,
    array('com_maritina_rates')
);
//в этой строке создается экземпляр// контроллера по умолчанию. Этот контроллера лежит
// в той же папке что и файл blog.php и имя файла controller.php
$controller = JControllerLegacy::getInstance( 'maritina_rates' );
//в этой строке мы указываем контроллеру по умолчанию выполнить
//задачу (task) которая передана через переменную task в адресной строке
$controller->execute( JFactory::getApplication()->input->get( 'task' ) );
$controller->redirect();