<?php
/**
 * register custom document post type
 */
function rudno_custom_post_type()
{
    register_post_type('rudno-dokumenty',
        array(
            'labels' => array(
                'name'                  => 'Verejné Dokumenty',
                'singular_name'         => 'Dokument',
                'menu_name'             => 'Dokumenty',
                'name_admin_bar'        => 'Dokumenty',
                'add_new'               => 'Vytvoriť nový dokument',
                'add_new_item'          => 'Pridať dokument',
                'new_item'              => 'Nový dokument',
                'edit_item'             => 'Uprav dokument',
                'view_item'             => 'Zobraz dokument',
                'all_items'             => 'Všetky dokumenty',
                'search_items'          => 'Hľadaj v dokumentoch',
            ),
            'menu_icon'   => 'dashicons-media-text',
            'menu_position' => 35,
            'public'      => true,
            'has_archive' => 'dokumenty',
            'supports' => array(
                'title'
            ),
            'rewrite' => array('slug' => 'dokumenty/%document-type%/%year%', 'with_front' => true),
            'taxonomies' => array('document-type')
        )
    );
}
add_action('init', 'rudno_custom_post_type');

include('meta/documents/content-meta.php');
include('tables/documents.php');
include('taxonomies/documents.php');


/**
 * Add lnks to create documents
 */
function admin_documents_links()
{
    global $submenu;

    $terms = get_terms([
        'taxonomy' => 'document-type',
        'hide_empty' => false
    ]);

    foreach ($terms as $term) {
        $key = $term->term_id;

        $submenu['edit.php?post_type=rudno-dokumenty'][] = [
            'Pridať ' . $term->name,
            'edit_posts',
            "post-new.php?post_type=rudno-dokumenty&document_type=$key"
        ];
    }
}

add_action('admin_menu', 'admin_documents_links');

/**
 * Replace document type in permalink
 */
function document_type_permalink($permalink, $post_id, $leavename)
{
    if (strpos($permalink, '%document-type%') !== FALSE) {
        // Get post
        $post = get_post($post_id);
        if ($post && 'rudno-dokumenty' === $post->post_type) {
            // Get taxonomy terms
            $terms = wp_get_object_terms($post->ID, 'document-type');
            if (!is_wp_error($terms) && !empty($terms) && is_object($terms[0])) $taxonomy_slug = $terms[0]->slug;
            else $taxonomy_slug = 'nezaradene';

            $permalink = str_replace('%document-type%', $taxonomy_slug, $permalink);

            if (strpos($permalink, '%year%') !== FALSE) {
                $permalink = str_replace('%year%', date('Y', \strtotime($post->_date)), $permalink);
            }
        }
    }

    return $permalink;
}
add_filter('post_type_link', 'document_type_permalink', 10, 3);


function rudno_sections_documents_date_meta_query($wp_query)
{
    if ($wp_query->is_main_query() && $wp_query->is_tax() && isset($wp_query->query['document-type'])) {
        rudno_sections_documents_set_document_type_query($wp_query);
    }

    if ($wp_query->is_main_query() && $wp_query->get('post_type') === 'rudno-dokumenty') {
        rudno_sections_documents_set_single_query($wp_query);
    }
}

function rudno_sections_documents_set_single_query($wp_query)
{
    if ($year = $wp_query->get('year')) {
        if(!$meta_query = $wp_query->get('meta_query')) {
            $meta_query = [];
        }

        $meta_query[] = [
            'key' => '_date',
            'value' => "$year-",
            'compare' => 'LIKE',
        ];

        // $wp_query->meta_query = $meta_query;
        $wp_query->set('meta_query', $meta_query);
        $wp_query->set('year', '');
    }
}

function rudno_sections_documents_set_document_type_query($wp_query)
{
    $wp_query->is_date = false;
    $wp_query->is_year = false;
}

add_action( 'pre_get_posts', 'rudno_sections_documents_date_meta_query' );
