<?php
/**
 * register custom document post type
 */
function rudno_seating_post_type()
{
    register_post_type('rudno-seating',
        array(
            'labels' => array(
                'name'                  => 'Zastupiteľstvo',
                'singular_name'         => 'Zastupiteľstvo',
                'menu_name'             => 'Zastupiteľstvo',
                'name_admin_bar'        => 'Zastupiteľstvo',
                'add_new'               => 'Pridať zasadnutie',
                'add_new_item'          => 'Pridať zasadnutie',
                'new_item'              => 'Pridať zasadnutie',
                'edit_item'             => 'Upraviť zasadnutie',
                'view_item'             => 'Zobraziť zasadnutie',
                'all_items'             => 'Všetky zasadnutia',
                'search_items'          => 'Hľadať zasdnutie',
            ),
            'menu_icon'   => 'dashicons-thumbs-up',
            'menu_position' => 40,
            'supports' => array('title'),
            'public'      => true,
            'has_archive' => false,
            'publicly_queryable'  => false
        )
    );
}
add_action('init', 'rudno_seating_post_type');

include('meta/seating/seating-meta.php');


/**
 * Add lnks to create documents
 */
function admin_seating_links()
{
    global $submenu;

    $term = get_term_by('slug', 'zapisnice-zo-zastupitelstiev', 'document-type');

    $submenu['edit.php?post_type=rudno-seating'][] = [
        $term->name,
        'edit_posts',
        "/wp-admin/edit.php?document-type=$term->slug&post_type=rudno-dokumenty"
    ];

    $submenu['edit.php?post_type=rudno-seating'][] = [
        'Pridať ' . $term->name,
        'edit_posts',
        "post-new.php?post_type=rudno-dokumenty&document_type=$term->term_id"
    ];
}

add_action('admin_menu', 'admin_seating_links');
