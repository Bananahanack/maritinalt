<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * @author Bananahanack
 */
class Maritina_RatesModelArchives extends JModelList
{

	/**
	 * Конструктор класса
	 * @param Array $config
	 */
	public function __construct( $config = array() )
	{
		if ( empty( $config['filter_fields'] ) ) {
			$config['filter_fields'] = array( 'title', 'state', 'ordering', 'created_by', 'created', 'id', 'author_id' );
		}
		parent::__construct( $config );
	}

	/**
	 * @param String $ordering
	 * @param String $direction
	 */
	protected function populateState( $ordering = null, $direction = null )
	{
		if ( $layout = JFactory::getApplication()->input->get( 'layout' ) ) {
			$this->context .= '.' . $layout;
		}
		$search = $this->getUserStateFromRequest( $this->context . '.filter.search', 'filter_search' );
		$this->setState( 'filter.search', $search );
		$published = $this->getUserStateFromRequest( $this->context . '.filter.published', 'filter_published', '' );
		$this->setState( 'filter.published', $published );
		$authorId = $this->getUserStateFromRequest( $this->context . '.filter.author_id', 'filter_author_id' );
		$this->setState( 'filter.author_id', $authorId );
		parent::populateState( 'id', 'desc' );
	}

	/**
	 * @param string $id
	 * @return string
	 */
	protected function getStoreId( $id = '' )
	{
		$id .= ':' . $this->getState( 'filter.search' );
		$id .= ':' . $this->getState( 'filter.published' );
		$id .= ':' . $this->getState( 'filter.author_id' );
		return parent::getStoreId( $id );
	}

	/**
	 * Составление запроса для получения списка записей
	 * @return JDatabaseQuery
	 */
	protected function getListQuery()
	{
		$query = $this->getDbo()->getQuery( true );
		$query->select( 't1.id, t1.title, t1.alias, t1.published as state, t1.created, t1.ordering, t1.hits' );
		$query->select( 'u.username as created_by, u.id as author_id' );
		$query->join( 'LEFT', '#__users AS u ON u.id = t1.created_by' );
		$query->from( '#__rmaritina_rates as t1' );
		$published = $this->getState( 'filter.published' );
		if ( is_numeric( $published ) ) {
			$query->where( 't1.published=' . (int)$published );
		}
		$authorId = $this->getState( 'filter.author_id' );
		if ( is_numeric( $authorId ) ) {
			$query->where( 'u.id=' . $authorId );
		}
		$search = $this->getState( 'filter.search' );
		if ( !empty( $search ) ) {
			$search = $this->getDbo()->Quote( '%' . $this->getDbo()->escape( $search, true ) . '%' );
			$query->where( '(t1.title LIKE ' . $search . ' OR t1.alias LIKE ' . $search . ')' );
		}
		$orderCol = $this->state->get( 'list.ordering' );
		$orderDirn = $this->state->get( 'list.direction' );
		$query->order( $this->getDbo()->escape( $orderCol . ' ' . $orderDirn ) );
		return $query;
	}

	/**
	 * Авторы записей
	 * @return    JDatabaseQuery
	 */
	public function getAuthors()
	{
		$query = $this->getDbo()->getQuery( true );
		$query->select( 'u.id AS value, u.name AS text' );
		$query->from( '#__users AS u' );
		$query->join( 'INNER', '#__rmaritina_rates AS c ON c.created_by = u.id' );
		$query->group( 'u.id, u.name' );
		$query->order( 'u.name' );
		return $this->getDbo()->setQuery( $query )->loadObjectList();
	}
}