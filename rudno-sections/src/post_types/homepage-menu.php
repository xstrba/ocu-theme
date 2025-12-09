<?php
/**
 * register custom document post type
 */
function rudno_hp_menu_post_type()
{
    register_post_type('rudno-hp-menu',
        array(
            'labels' => array(
                'name'                  => 'Úvodný rozcestník',
                'singular_name'         => 'Úvodný rozcestník',
                'menu_name'             => 'Úvodný rozcestník',
                'name_admin_bar'        => 'Úvodný rozcestník',
                'add_new'               => 'Pridať položku',
                'add_new_item'          => 'Pridať položku',
                'new_item'              => 'Nová položka',
                'edit_item'             => 'Upraviť položku',
                'view_item'             => 'Zobraziť položku',
                'all_items'             => 'Všetky položky',
                'search_items'          => 'Hľadaj položky',
            ),
            'menu_icon'   => 'dashicons-networking',
            'menu_position' => 21,
            'supports' => array('title', 'excerpt'),
            'public'      => true,
            'has_archive' => false,
            'publicly_queryable'  => false,
            'exclude_from_search' => true
        )
    );
}
add_action('init', 'rudno_hp_menu_post_type');

include('meta/hp-menu/hp-menu-meta.php');
// include('tables/form.php');
