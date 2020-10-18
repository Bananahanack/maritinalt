<?php
defined( '_JEXEC' ) or die; // No direct access

function Maritina_RatesBuildRoute( &$query )
{
	$segments = array();
	if ( isset( $query['view'] ) ) {
		$segments[] = $query['view'];
		unset( $query['view'] );
	}
	if ( isset( $query['task'] ) ) {
		$segments[] = $query['task'];
		unset( $query['task'] );
	}
	if ( isset( $query['id'] ) ) {
		$segments[] = $query['id'];
		unset( $query['id'] );
	}
	if ( isset( $query['limitstart'] ) ) {
		unset( $query['limitstart'] );
	}
	return $segments;
}

function Maritina_RatesParseRoute( $segments )
{
	$vars = array();
	$count = count( $segments );
	$menu = JMenu::getInstance( 'site' )->getActive();
	$view = isset( $menu->query['view'] ) ? $menu->query['view'] : '';

	/**
	 *Примеры роутинга с удаленным $segments[] = $query['view']; в  BuildRoute
	 * Пример 1 - запуска задачи activate в контроллере по умолчанию, вид ссылки site.ru/menu-name/activate
	 * if ( isset( $segments[0] ) && $segments[0] === 'activate' ) {
		$vars['task'] = 'activate';
		return $vars;
	}
	 * Пример 2 - запуска задачи getFile в контроллере по умолчанию и передача id, вид ссылки site.ru/menu-name/getFile/1
	if ( isset( $segments[0] ) && $segments[0] === 'getFile' ) {
		$vars['task'] = 'getFile';
		$vars['id'] = $segments[1];
		return $vars;
	}
	 * Пример 3 - если текущий пункт меню связан с видом  category и количество сегментов строки = 1 то выводим вид article
	 * в поле id будет id записи
	 * Например ссылка site.ru/menu-name/ откроет вид category (при условии что menu-name это пункт меню связанный с видом category)
	 * site.ru/menu-name/1-page-alias.html - откроет вид article в который будет передано в качестве id строка 1-page-alias
	if ( $view === 'category' && $count == 1 ) {
		$vars['view'] = 'article';
		$vars['id'] = $segments[0];
		return $vars;
	}*/

	if ( $count == 1 ) {
		$vars['view'] = $segments[0];
	}
	if ( $count == 2 ) {
		$vars['view'] = $segments[0];
		if ( strpos( $segments[1], ':' ) !== false || is_numeric( $segments[1] ) ) {
			$vars['id'] = $segments[1];
		} else {
			$vars['task'] = $segments[1];
		}
	}
	if ( $count == 3 ) {
		$vars['view'] = $segments[0];
		$vars['task'] = $segments[1];
		$vars['id'] = $segments[2];
	}
	return $vars;
}