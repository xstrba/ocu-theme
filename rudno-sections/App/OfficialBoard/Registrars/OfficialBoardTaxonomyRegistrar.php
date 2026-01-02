<?php

declare(strict_types=1);

namespace Plugin\OfficialBoard\Registrars;

use Plugin\Common\Application;

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
            'query_var'         => true,
            'rewrite'           => [ 'slug' => __('uradna-tabula', 'ocu-theme'), 'with_front' => true ],
        ];

        $app->registerTaxonomy(self::TAXONOMY, [OfficialBoardRegistrar::POST_TYPE], $args);

        $app->registerAddMetaBoxesAction(function (Application $app) {
            $app->removeMetaBox('tagsdiv-' . self::TAXONOMY, OfficialBoardRegistrar::POST_TYPE, 'side');
        });
    }
}
