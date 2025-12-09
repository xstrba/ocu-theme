<?php
/**
 * register custom document post type
 */
function rudno_useful_links_post_type()
{
    register_post_type('rudno-useful-links',
        array(
            'labels' => array(
                'name'                  => 'Užitočné odkazy',
                'singular_name'         => 'Užitočné odkazy',
                'menu_name'             => 'Užitočné odkazy',
                'name_admin_bar'        => 'Užitočné odkazy',
                'add_new'               => 'Pridať položku',
                'add_new_item'          => 'Pridať položku',
                'new_item'              => 'Nová položka',
                'edit_item'             => 'Upraviť položku',
                'view_item'             => 'Zobraziť položku',
                'all_items'             => 'Všetky položky',
                'search_items'          => 'Hľadaj položky',
            ),
            'menu_icon'   => 'dashicons-admin-links',
            'menu_position' => 45,
            'supports' => array('title'),
            'public'      => true,
            'has_archive' => false,
            'publicly_queryable'  => false,
            'exclude_from_search' => true
        )
    );
}
add_action('init', 'rudno_useful_links_post_type');

include('meta/useful-links/useful-links-meta.php');
