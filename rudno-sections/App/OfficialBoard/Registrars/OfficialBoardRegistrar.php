<?php

declare(strict_types=1);

namespace Plugin\OfficialBoard\Registrars;

use Plugin\Common\Application;
use WP_Query;

final class OfficialBoardRegistrar
{
    public const string POST_TYPE = 'ocu-official-board';

    /**
     * @param \Plugin\Common\Application $app
     */
    public function register(Application $app): void
    {
        $app->registerPostType(self::POST_TYPE, [
            'labels' => [
                'name'                  => __('Úradná tabuľa', 'ocu-theme'),
                'singular_name'         => __('Úradná tabuľa', 'ocu-theme'),
                'menu_name'             => __('Úradná tabuľa', 'ocu-theme'),
                'name_admin_bar'        => __('Úradná tabuľa', 'ocu-theme'),
                'add_new'               => __('Vytvoriť nový dokument', 'ocu-theme'),
                'add_new_item'          => __('Pridať dokument', 'ocu-theme'),
                'new_item'              => __('Nový dokument', 'ocu-theme'),
                'edit_item'             => __('Uprav dokument', 'ocu-theme'),
                'view_item'             => __('Zobraz dokument', 'ocu-theme'),
                'all_items'             => __('Všetky dokumenty', 'ocu-theme'),
                'search_items'          => __('Hľadaj v dokumentoch', 'ocu-theme'),
            ],
            'menu_icon'   => 'dashicons-media-text',
            'menu_position' => 36,
            'public'      => true,
            'has_archive' => __('uradna-tabula', 'ocu-theme'),
            'rewrite' => ['slug' => __('uradna-tabula/%document-type%/dokument', 'ocu-theme'), 'with_front' => true],
            'taxonomies' => [OfficialBoardTaxonomyRegistrar::TAXONOMY],
            'supports' => [
                'title',
                'excerpt'
            ],
        ]);

        $app->registerPostTypeLinkFilter(static function (string $permalink, mixed $postId): string
        {
            if (str_contains($permalink, '%document-type%')) {
                // Get post
                $post = get_post($postId);
                if ($post && self::POST_TYPE === $post->post_type) {
                    // Get taxonomy terms
                    $terms = wp_get_object_terms($post->ID, OfficialBoardTaxonomyRegistrar::TAXONOMY);

                    if (!empty($terms) && !is_wp_error($terms) && is_object($terms[0])) {
                        $taxonomy_slug = $terms[0]->slug;
                    } else {
                        $taxonomy_slug = 'nezaradene';
                    }

                    $permalink = str_replace('%document-type%', $taxonomy_slug, $permalink);
                }
            }

            return $permalink;
        });

        $app->registerPreGetPostsCb(static function (WP_Query $query): void {
            if ($query->get('post_type') !== OfficialBoardRegistrar::POST_TYPE) {
                return;
            }

            // disable search template and meta resolving on web when searching on archive
            if (! is_admin() && $query->is_archive() && $query->is_main_query() && $query->is_search()) {
                $query->is_search = false;
            }

            if (
                is_admin() &&
                $query->get('orderby') === 'date_publish'
            ) {
                $query->set('meta_key', '_date_publish');
                $query->set('orderby', 'meta_value');
                $query->set('meta_type', 'DATETIME');
            }

            if (
                is_admin() &&
                $query->get('orderby') === 'date_unpublish'
            ) {
                $query->set('meta_key', '_date_unpublish');
                $query->set('orderby', 'meta_value');
                $query->set('meta_type', 'DATETIME');
            }

            if (! is_admin() && $query->is_main_query() && $query->is_archive()) {
                $query->set('posts_per_page', 12); // optional

                $today = \date('Y-m-d H:i') . ':00';

                $meta_query = [
                    'relation' => 'AND',
                    [
                        'key'     => '_date_publish',
                        'value'   => $today,
                        'compare' => '<=',
                        'type'    => 'DATE',
                    ],
                    [
                        'key'     => '_date_unpublish',
                        'value'   => $today,
                        'compare' => '>=',
                        'type'    => 'DATE',
                    ],
                ];

                $query->set('meta_query', $meta_query);

                $query->set('orderby', 'meta_value');
                $query->set('meta_key', '_date_publish');
                $query->set('order', 'DESC');
            }
        });
    }
}
