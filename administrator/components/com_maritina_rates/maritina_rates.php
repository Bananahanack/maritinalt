<?php
defined( '_JEXEC' ) or die; // No direct access
/**
 * Component maritina_rates
 * @author Bananahanack
 */
require_once JPATH_COMPONENT.'/helpers/maritina_rates.php';
$controller = JControllerLegacy::getInstance( 'maritina_rates' );
$controller->execute( JFactory::getApplication()->input->get( 'task' ) );
$controller->redirect();