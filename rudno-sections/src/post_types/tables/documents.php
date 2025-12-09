<?php
/**
 * Table in administration section is modified here
 */

function edit_document_columns( $columns ): array
{

	return array(
		'cb' => '<input type="checkbox" />',
        'title' => 'Názov',
        'src' => 'Súbor',
		'type' => 'Typ',
        'author' => 'Autor',
		'date' => __( 'Date' )
	);
}
add_filter( 'manage_edit-rudno-dokumenty_columns', 'edit_document_columns' );

function manage_documents_columns( $column, $post_id ): void
{
	global $post;

	switch( $column ) {
		case 'src' :

			$src = $post->_file ? wp_get_attachment_url($post->_file) : null;

			if ( !empty( $src ) ) {
                echo "<a href='". $src ."'>";
                echo explode('/uploads/', $src)[1];
                echo "</a>";
			} else {
                echo __( 'Unknown' );
            }
			break;
		case 'type' :
            $terms = get_the_terms($post_id, 'document-type');

            if ($terms) {
                echo $terms[0]->name;
            }

			break;
		default :
			break;
	}
}
add_action( 'manage_rudno-dokumenty_posts_custom_column', 'manage_documents_columns', 10, 2 );

function document_sortable_columns( $columns ) {

	$columns['subject'] = 'subject';

	return $columns;
}
add_filter( 'manage_edit-rudno-dokumenty_sortable_columns', 'document_sortable_columns' );

function sort_documents( $vars ) {

	/* Check if we're viewing the 'movie' post type. */
	if ( isset( $vars['post_type'] ) && 'rudno-dokumenty' === $vars['post_type'] ) {

		/* Check if 'orderby' is set to 'subject'. */
		if ( isset( $vars['orderby'] ) && 'subject' === $vars['orderby'] ) {

			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => '_spost_meta_author',
					'orderby' => 'meta_value'
				)
			);
		}
	}

	return $vars;
}

function edit_document_load(): void
{
	add_filter( 'request', 'sort_documents' );
}
add_action( 'load-edit.php', 'edit_document_load' );
