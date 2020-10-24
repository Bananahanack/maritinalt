<?php
function pagination_list_render( $list )
{
	$html = '<ul class="pagination no-marker center">';
	//$html .= '<li class="pagination-prev">' . $list['previous']['data'] . '</li>';
	foreach ( $list['pages'] as $page ) {
		$html .= '<li class="pagination-item inline">' . $page['data'] . '</li>';
	}
	//$html .= '<li class="pagination-next">' . $list['next']['data'] . '</li>';
	$html .= '</ul>';
	return $html;
}

function pagination_item_active( JPaginationObject $item )
{
	$title = '';
	if ( !is_numeric( $item->text ) ) {
		$title = ' class="hasTooltip" title="' . $item->text . '"';
	}
	return '<a' . $title . ' href="' . $item->link . '" class="white center size24 block no-decoration radius-5">' . $item->text . '</a>';
}

function pagination_item_inactive( JPaginationObject $item )
{
	return '<span class="white center size24 block no-decoration radius-5">' . $item->text . '</span>';
}