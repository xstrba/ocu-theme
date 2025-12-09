<?php
/**
 * register custom document post type
 */
function rudno_work_post_type()
{
    register_post_type('rudno-work',
        array(
            'labels' => array(
                'name'                  => 'Práca starostu',
                'singular_name'         => 'Práca starostu',
                'menu_name'             => 'Práca starostu',
                'name_admin_bar'        => 'Práca starostu',
                'add_new'               => 'Pridať prácu starostu',
                'add_new_item'          => 'Pridať prácu starostu',
                'new_item'              => 'Pridať prácu starostu',
                'edit_item'             => 'Upraviť prácu starostu',
                'view_item'             => 'Zobraziť prácu starostu',
                'all_items'             => 'Všetky práce starostu',
                'search_items'          => 'Hľadať prácu starostu',
            ),
            'menu_icon'   => 'dashicons-hammer',
            'menu_position' => 41,
            'supports' => array('title', 'editor'),
            'public'      => true,
            'has_archive' => 'prace-starostu',
            'publicly_queryable'  => false
        )
    );
}
add_action('init', 'rudno_work_post_type');

include('meta/work/work-meta.php');
