<?php
/**
 * register custom document post type
 */
function rudno_events_post_type()
{
    register_post_type('rudno-events',
        array(
            'labels' => array(
                'name'                  => __('Kalendár akcií', 'rudno-theme'),
                'singular_name'         => 'Akcia',
                'menu_name'             => 'Akcie',
                'name_admin_bar'        => 'Akcie',
                'add_new'               => 'Pridať akciu',
                'add_new_item'          => 'Pridať akciu',
                'new_item'              => 'Nová akcia',
                'edit_item'             => 'Upraviť akciu',
                'view_item'             => 'Zobraziť akciu',
                'all_items'             => 'Všetky akcie',
                'search_items'          => 'Hľadaj akcie',
            ),
            'menu_icon'   => 'dashicons-buddicons-groups',
            'menu_position' => 32,
            'supports' => array('title', 'editor', 'thumbnail'),
            'public'      => true,
            'has_archive' => 'kalendar-akcii',
            'rewrite' => array('slug' => 'kalendar-akcii', 'with_front' => false)
        )
    );
}
add_action('init', 'rudno_events_post_type');

include('meta/events/event-meta.php');
// include('tables/form.php');
