<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * View to display a list of items
 * @author Bananahanack
 */
class MaritinaViewArchives extends JViewLegacy
{
	/**
	 * @var $items stdClass[]
	 */
	public $items;
	/**
	 * @var $pagination JPagination
	 */
	public $pagination;
	/**
	 * @var $state JObject
	 */
	public $state;
	/**
	 * @var $user JUser
	 */
	public $user;
	/**
	 * @var $authors stdClass[]
	 */
	public $authors;

	/**
	 * Method to display the current pattern
	 * @param type $tpl
	 */
	public function display( $tpl = null )
	{
		$this->items = $this->get( 'Items' );
		$this->pagination = $this->get( 'Pagination' );
		$this->state = $this->get( 'State' );
		$this->user = JFactory::getUser();
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');
		$this->loadHelper( 'maritina' );
		if ( $this->getLayout() !== 'modal' ) {
			$this->addToolbar();
			maritinaHelper::addSubmenu( 'archives' );
			$this->sidebar = JHtmlSidebar::render();
		}
		parent::display( $tpl );
	}

	/**
	 * Method to display the toolbar
	 */
	protected function addToolbar()
	{
		JToolBarHelper::title( JText::_( 'COM_MARITINA' ) );
		$canDo = maritinaHelper::getActions( 'archive' );

        if ( $canDo->get( 'core.delete' ) ) {
            JToolBarHelper::deleteList( 'DELETE_QUERY_STRING', 'archives.delete', 'JTOOLBAR_DELETE' );
            JToolBarHelper::divider();
        }

        if ( $canDo->get( 'core.admin' ) ) {
            JToolBarHelper::preferences( 'com_maritina' );
            JToolBarHelper::divider();
        }
	}


	protected function getSortFields()
	{
		return array(
			'ordering' => JText::_( 'JGRID_HEADING_ORDERING' ),
			'title' => JText::_( 'JGLOBAL_TITLE' ),
			'created' => JText::_( 'JDATE' ),
			'id' => JText::_( 'JGRID_HEADING_ID' )
		);
	}
}