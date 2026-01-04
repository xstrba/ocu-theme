<?php

declare(strict_types=1);

namespace Plugin\OfficialBoard\Registrars;

use Plugin\Common\Application;
use WP_Query;

final class OfficialBoardTaxonomyRegistrar
{
    public const string TAXONOMY = 'ocu-official-board-document-type';

    public function register(Application $app): void
    {
        $labels = [
            'name'              => $name = __('Typy dokumentov úradnej tabule', 'ocu-theme'),
            'singular_name'     => __('Typ dokumentu úradnej tabule', 'ocu-theme'),
            'search_items'      => __('Vyhľadávaj typy dokumentov', 'ocu-theme'),
            'all_items'         => __('Všetky typy dokumentov', 'ocu-theme'),
            'parent_item'       => __('Rodičovský typ', 'ocu-theme'),
            'parent_item_colon' => __('Rodičovský typ:', 'ocu-theme'),
            'edit_item'         => __('Upraviť typ', 'ocu-theme'),
            'update_item'       => __('Upraviť typ', 'ocu-theme'),
            'add_new_item'      => __('Pridať nový typ', 'ocu-theme'),
            'new_item_name'     => __('Názov nového typu', 'ocu-theme'),
            'menu_name'         => $name,
        ];

        $args = [
            'hierarchical'      => false,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'meta_box_cb'       => false,
            'rewrite' => ['slug' => __('uradna-tabula', 'ocu-theme'), 'with_front' => true],
        ];

        $app->registerTaxonomy(self::TAXONOMY, [OfficialBoardRegistrar::POST_TYPE], $args);

        $app->registerPreGetPostsCb(static function (WP_Query $query): void {
            if (! $query->get(self::TAXONOMY)) {
                return;
            }

            // disable search template and meta resolving on web when searching on archive
            if (!is_admin() && $query->is_tax() && $query->is_archive() && $query->is_main_query() && $query->is_search()) {
                $query->is_search = false;
            }

            if (! is_admin() && $query->is_main_query() && $query->is_archive() && $query->is_tax()) {
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
