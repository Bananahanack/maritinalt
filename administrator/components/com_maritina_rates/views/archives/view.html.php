<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * View to display a list of items
 * @author Bananahanack
 */
class Maritina_RatesViewArchives extends JViewLegacy
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
		$this->authors = $this->get( 'Authors' );
		$this->user = JFactory::getUser();
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');
		$this->loadHelper( 'maritina_rates' );
		if ( $this->getLayout() !== 'modal' ) {
			$this->addToolbar();
			maritina_ratesHelper::addSubmenu( 'archives' );
			$this->sidebar = JHtmlSidebar::render();
		}
		parent::display( $tpl );
	}

	/**
	 * Method to display the toolbar
	 */
	protected function addToolbar()
	{
		JToolBarHelper::title( JText::_( 'COM_MARITINA_RATES' ) );
		$canDo = maritina_ratesHelper::getActions( 'archive' );

		if ( $canDo->get( 'core.create' ) || ( count( $this->user->getAuthorisedCategories( 'com_maritina_rates', 'core.create' ) ) ) > 0 ) {
			JToolBarHelper::addNew( 'archive.add' );
		}

		if ( ( $canDo->get( 'core.edit' ) ) || ( $canDo->get( 'core.edit.own' ) ) ) {
			JToolBarHelper::editList( 'archive.edit' );
		}

		if ( $canDo->get( 'core.edit.state' ) ) {
			JToolBarHelper::divider();
			JToolBarHelper::publish( 'archives.publish', 'JTOOLBAR_PUBLISH', true );
			JToolBarHelper::unpublish( 'archives.unpublish', 'JTOOLBAR_UNPUBLISH', true );
			JToolBarHelper::divider();

			if ( $canDo->get( 'core.delete' ) ) {
				JToolBarHelper::deleteList( 'DELETE_QUERY_STRING', 'archives.delete', 'JTOOLBAR_DELETE' );
				JToolBarHelper::divider();
			}

			if ( $canDo->get( 'core.admin' ) ) {
				JToolBarHelper::preferences( 'com_maritina_rates' );
				JToolBarHelper::divider();
			}
		}
	}

	protected function getSortFields()
	{
		return array(
			'ordering' => JText::_( 'JGRID_HEADING_ORDERING' ),
			'published' => JText::_( 'JSTATUS' ),
			'title' => JText::_( 'JGLOBAL_TITLE' ),
			'created_by' => JText::_( 'JAUTHOR' ),
			'created' => JText::_( 'JDATE' ),
			'id' => JText::_( 'JGRID_HEADING_ID' )
		);
	}
}