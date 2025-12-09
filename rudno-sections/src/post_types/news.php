<?php
/**
 * register custom document post type
 */
function rudno_news_post_type()
{
    register_post_type('rudno-news',
        array(
            'labels' => array(
                'name'                  => __('Novinky', 'rudno-theme'),
                'singular_name'         => 'Novinka',
                'menu_name'             => 'Novinky',
                'name_admin_bar'        => 'Novinky',
                'add_new'               => 'Pridať novinku',
                'add_new_item'          => 'Pridať novinku',
                'new_item'              => 'Nová novinka',
                'edit_item'             => 'Upraviť novinku',
                'view_item'             => 'Zobraziť novinku',
                'all_items'             => 'Všetky novinky',
                'search_items'          => 'Hľadaj novinky',
            ),
            'menu_icon'   => 'dashicons-text',
            'menu_position' => 31,
            'supports' => array('title', 'editor', 'thumbnail'),
            'public'      => true,
            'has_archive' => 'novinky',
            'rewrite' => array('slug' => 'novinky', 'with_front' => false)
        )
    );
}
add_action('init', 'rudno_news_post_type');
/**
 * @param $query
 */
function my_cptui_change_posts_per_page( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
       return;
    }

    if ( is_post_type_archive( 'rudno-news' ) ) {
       $query->set( 'posts_per_page', 10 );
    }
}
add_filter( 'pre_get_posts', 'my_cptui_change_posts_per_page' );
