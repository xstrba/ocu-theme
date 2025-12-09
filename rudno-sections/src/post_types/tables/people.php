<?php
/**
 * Table in administration section is modified here
 */

function edit_people_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => 'Meno',
		'position' => 'Pozícia',
		'date' => __( 'Date' )
	);

	return $columns;
}
add_filter( 'manage_edit-rudno-people_columns', 'edit_people_columns' );

function manage_people_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {
		case 'position':
			echo $post->_position;
			break;
		default :
			break;
	}
}
add_action( 'manage_rudno-people_posts_custom_column', 'manage_people_columns', 10, 2 );

function people_sortable_columns( $columns ) {
	$columns['position'] = 'position';

	return $columns;
}
add_filter( 'manage_edit-rudno-people_sortable_columns', 'people_sortable_columns' );

function sort_people( $vars ) {

	/* Check if we're viewing the 'movie' post type. */
	if ( isset( $vars['post_type'] ) && 'rudno-people' == $vars['post_type'] ) {

		/* Check if 'orderby' is set to 'subject'. */
		if ( isset( $vars['orderby'] ) && 'subject' == $vars['orderby'] ) {

			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => '_name',
					'orderby' => 'meta_value'
				)
			);
		}
	}

	return $vars;
}

function edit_people_load() {
	add_filter( 'request', 'sort_people' );
}

add_action( 'load-edit.php', 'edit_people_load' );
