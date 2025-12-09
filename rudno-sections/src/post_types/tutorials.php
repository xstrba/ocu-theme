<?php
/**
 * register custom document post type
 */
function rudno_tutorials_post_type()
{
    register_post_type('rudno-tutorials',
        array(
            'labels' => array(
                'name'                  => 'Potrebujem vybaviť',
                'singular_name'         => 'Potrebujem vybaviť',
                'menu_name'             => 'Potrebujem vybaviť',
                'name_admin_bar'        => 'Potrebujem vybaviť',
                'add_new'               => 'Pridať návod',
                'add_new_item'          => 'Pridať návod',
                'new_item'              => 'Nový návod',
                'edit_item'             => 'Upraviť návod',
                'view_item'             => 'Zobraziť návod',
                'all_items'             => 'Všetky návody',
                'search_items'          => 'Hľadaj návody',
            ),
            'menu_icon'   => 'dashicons-editor-ol',
            'menu_position' => 34,
            'supports' => array('title', 'editor'),
            'public'      => true,
            'show_in_rest' => true,
            'has_archive' => 'potrebujem-vybavit',
            'rewrite' => array('slug' => 'potrebujem-vybavit/%tutorial-category%', 'with_front' => false),
            'taxonomies' => array('tutorial-category')
        )
    );
}
add_action('init', 'rudno_tutorials_post_type');

include('meta/tutorials/tutorials-meta.php');
include('taxonomies/tutorials.php');

/**
 * Replace tutorial category in permalink
 */
function tutorial_category_permalink($permalink, $post_id, $leavename) {
    if (strpos($permalink, '%tutorial-category%') !== FALSE) {
        // Get post
        $post = get_post($post_id);
        if ($post && 'rudno-tutorials' === $post->post_type) {
            // Get taxonomy terms
            $terms = wp_get_object_terms($post->ID, 'tutorial-category');
            if (!is_wp_error($terms) && !empty($terms) && is_object($terms[0])) $taxonomy_slug = $terms[0]->slug;
            else $taxonomy_slug = 'nezaradene';

            $permalink = str_replace('%tutorial-category%', $taxonomy_slug, $permalink);
        }
    }

    return $permalink;
}
add_filter('post_type_link', 'tutorial_category_permalink', 10, 3);
