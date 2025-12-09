<?php
/**
 * register custom document post type
 */
function rudno_main_news_post_type()
{
    register_post_type('rudno-warnings',
        array(
            'labels' => array(
                'name'                  => 'Dôležité novinky',
                'singular_name'         => 'Dôležitá novinka',
                'menu_name'             => 'Dôležité novinky',
                'name_admin_bar'        => 'Dôležité novinky',
                'add_new'               => 'Pridať novinku',
                'add_new_item'          => 'Pridať novinku',
                'new_item'              => 'Nová novinka',
                'edit_item'             => 'Upraviť novinku',
                'view_item'             => 'Zobraziť novinku',
                'all_items'             => 'Všetky novinky',
                'search_items'          => 'Hľadaj novinky',
            ),
            'exclude_from_search' => true,
            'menu_icon'   => 'dashicons-warning',
            'menu_position' => 30,
            'supports' => array('title'),
            'public'      => true,
            'has_archive' => false,
            'publicly_queryable'  => false
        )
    );
}
add_action('init', 'rudno_main_news_post_type');

include('meta/main-news/main-news-meta.php');
// include('tables/form.php');
