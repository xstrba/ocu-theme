<?php

/**
 * Meta box generated with 'Meta box' plugin
 *
 * @param $meta_boxes
 * @return mixed
 */
function get_gallery_meta_box( $meta_boxes ) {
	$prefix = '';

	$meta_boxes[] = array(
		'id' => 'gallery_meta_box',
		'title' => esc_html__( 'Galéria', 'metabox-online-generator' ),
		'context' => 'advanced',
		'priority' => 'default',
        'autosave' => 'true',
        'post_types' => 'rudno-gallery',
		'fields' => array(
			array(
				'id' => $prefix . '_files',
				'type' => 'file_advanced',
				'name' => esc_html__( 'Galéria', 'metabox-online-generator' ),
				'mime_type' => 'image',
				'max_status' => 'true',
			),
		),
	);

	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'get_gallery_meta_box' );
