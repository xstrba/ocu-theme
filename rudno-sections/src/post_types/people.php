<?php
/**
 * register custom document post type
 */

function rudno_people_post_type()
{
    register_post_type('rudno-people',
        array(
            'labels' => array(
                'name'                  => 'Osoby',
                'singular_name'         => 'Osoba',
                'menu_name'             => 'Ľudia',
                'name_admin_bar'        => 'Ľudia',
                'add_new'               => 'Vytvoriť osobu',
                'add_new_item'          => 'Pridať osobu',
                'new_item'              => 'Nová osoba',
                'edit_item'             => 'Uprav osobu',
                'view_item'             => 'Zobraz osobu',
                'all_items'             => 'Všetky osoby',
                'search_items'          => 'Hľadaj ľudí',
            ),
            'menu_icon'   => 'dashicons-groups',
            'menu_position' => 42,
            'supports' => array('thumbnail'),
            'public' => true,
            'show_in_nav_menus' => true,
            'has_archive' => false,
            'taxonomies' => array('people_position', 'people_comission'),
            'rewrite' => array('slug' => 'ludia', 'with_front' => true),
        )
    );
}
add_action('init', 'rudno_people_post_type');

include('meta/people/people-meta.php');
include('tables/people.php');
include('taxonomies/people.php');
