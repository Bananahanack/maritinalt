<?php
defined( '_JEXEC' ) or die; // No direct access
/**
 * Component maritina
 * @author Bananahanack
 */
require_once JPATH_COMPONENT.'/helpers/maritina.php';
$controller = JControllerLegacy::getInstance( 'maritina' );
$controller->execute( JFactory::getApplication()->input->get( 'task' ) );
$controller->redirect();