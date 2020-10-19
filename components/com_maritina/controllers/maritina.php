<?php
// No direct access
defined( '_JEXEC' ) or die;

/**
 * Controller
 * @author Bananahanack
 */
class MaritinaControllerMaritina extends JControllerForm
{

	/**
	 * Class constructor
	 * @param array $config
	 */
	function __construct( $config = array() )
	{
		$this->view_list = 'Maritina';
		parent::__construct( $config );
	}

	/**
	 * @return bool
	 */
	public function allowSave()
	{
		return true;
	}
	
}