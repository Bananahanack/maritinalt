<?php
// No direct access
defined( '_JEXEC' ) or die;

/**
 * View for  current element
 * @author Bananahanack
 */
class MaritinaViewMaritina extends JViewLegacy
{
	/**
	 * @var $form JForm
	 */
	public $form;
	/**
	 * @var $item stdClass
	 */
	public $item;
	/**
	 * @var $state JObject
	 */
	public $state;

	/**
	 * Method of display current template
	 * @param type $tpl
	 */
	public function display( $tpl = null )
	{
		$this->item = $this->get( 'Item' );
		$this->form = $this->get( 'Form' );
		$this->state = $this->get( 'State' );
		maritinaSiteHelper::setDocument( 'view title');
		parent::display( $tpl );
	}

}