<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * View for edit current element
 * @author Bananahanack
 */
class MaritinaViewArchive extends JViewLegacy
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
	 * @var $user JUser
	 */
	public $user;
	/**
	 * @var $tags stdClass[]
	 */
	public $state;
	/**
	 * @var $user JUser
	 */

	/**
	 * Method to display the current pattern
	 * @param String $tpl
	 */
	public function display( $tpl = null )
	{
		$this->form = $this->get( 'Form' );
		$this->item = $this->get( 'Item' );
		$this->user = JFactory::getUser();
		$this->state = $this->get( 'State' );
		if ( count( $errors = $this->get( 'Errors' ) ) ) {
			JError::raiseError( 500, implode( '\n', $errors ) );
			return false;
		}
		$this->loadHelper( 'maritina' );
		$this->canDo = maritinaHelper::getActions( 'archive' );
		$this->_setToolBar();
		parent::display( $tpl );
	}

	/**
	 * Method to display the toolbar
	 */
    protected function _setToolBar()
    {
        JFactory::getApplication()->input->set( 'hidemainmenu', true );
        JToolBarHelper::title( 'Viewing request' );
        JToolBarHelper::cancel( 'archive.cancel', 'JTOOLBAR_CLOSE' );
    }
}