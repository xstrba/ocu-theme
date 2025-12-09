<?php
/**
 * register custom document post type
 */
function rudno_gallery_post_type()
{
    register_post_type('rudno-gallery',
        array(
            'labels' => array(
                'name'                  => __('Fotogalérie', 'rudno-theme'),
                'singular_name'         => 'Fotogaléria',
                'menu_name'             => 'Fotogalérie',
                'name_admin_bar'        => 'Fotogalérie',
                'add_new'               => 'Pridať fotogalériu',
                'add_new_item'          => 'Pridať fotogalériu',
                'new_item'              => 'Pridať fotogalériu',
                'edit_item'             => 'Upraviť fotogalériu',
                'view_item'             => 'Zobraziť fotogalériu',
                'all_items'             => 'Všetky fotogalérie',
                'search_items'          => 'Hľadať fotogalériu',
            ),
            'menu_icon'   => 'dashicons-images-alt2',
            'menu_position' => 33,
            'supports' => array('title'),
            'public'      => true,
            'has_archive' => 'fotogalerie',
            'rewrite' => array('slug' => 'fotogalerie', 'with_front' => false)
        )
    );
}
add_action('init', 'rudno_gallery_post_type');

include('meta/gallery/gallery-meta.php');
