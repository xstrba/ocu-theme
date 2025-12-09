<?php

namespace App\View\Composers;

use App\Enums\DocumentTypeTemplatesEnum;
use Roots\Acorn\View\Composer;

class TaxonomyDocumentType extends Composer
{
    /**
     * @var array<int, \App\Enums\DocumentTypeTemplatesEnum>
     */
    private array $templateCache = [];

    /**
     * @var int
     */
    private int $currentPageCache;

    /**
     * @return \App\Enums\DocumentTypeTemplatesEnum
     */
    public function template(): DocumentTypeTemplatesEnum
    {
        $termObject = get_queried_object();

        if (! $termObject instanceof \WP_Term) {
            return DocumentTypeTemplatesEnum::getDefault();
        }

        return $this->getTemplate($termObject);
    }

    public function posts(): array
    {
        $termObject = get_queried_object();

        if (! $termObject instanceof \WP_Term) {
            return [];
        }

        $template = $this->getTemplate($termObject);

        if ($template->usesYearlyFilter()) {
            $year = $this->currentPage();
            $nextYear = $year + 1;

            $args = [
                'post_type' => get_post_type(),
                'numberposts' => -1,
                'tax_query' => [
                    [
                        'taxonomy' => $termObject->taxonomy,
                        'field' => 'term_id',
                        'terms' => $termObject->term_id,
                        'include_children' => false
                    ]
                ],
                'meta_key' => ['_date', '_file'],
                'orderby'  => [
                    'meta_value' => 'DESC',
                    'post_date' => 'DESC'
                ],
                'meta_query'  =>  [
                    [
                        'key'     => '_date',
                        'value'   => "$year-01-01",
                        'compare' => '>=',
                    ],
                    [
                        'key'     => '_date',
                        'value'   => "$nextYear-01-01",
                        'compare' => '<',
                    ]
                ]
            ];
        } else {
            $args = [
                'post_type' => get_post_type(),
                'numberposts' => -1,
                'tax_query' => [
                    [
                        'taxonomy' => $termObject->taxonomy,
                        'field' => 'term_id',
                        'terms' => $termObject->term_id,
                        'include_children' => false
                    ]
                ],
                'meta_key' => ['_date', '_file'],
                'orderby'  => [
                    'meta_value' => 'DESC',
                    'post_date' => 'DESC'
                ],
            ];
        }

        return \array_filter(get_posts($args), static function ($post) {
            return (bool) get_post($post->_file);
        });
    }

    public function pagesYears(): ?array
    {
        $termObject = get_queried_object();

        if (! $termObject instanceof \WP_Term) {
            return null;
        }

        $template = $this->getTemplate($termObject);

        if (! $template->usesYearlyFilter()) {
            return null;
        }

        $groupByCb = function ($groupBy) {
            global $wpdb;

            return "YEAR({$wpdb->postmeta}.meta_value)";
        };

        add_filter('posts_groupby', $groupByCb);

        $args = [
            'post_type' => get_post_type(),
            'posts_per_page' => -1,
            'tax_query' => [
                [
                    'taxonomy' => $termObject->taxonomy,
                    'field' => 'term_id',
                    'terms' => $termObject->term_id,
                    'include_children' => false
                ]
            ],
            'meta_key' => '_date',
            'orderby'  => [
                'meta_value' => 'DESC',
            ],
        ];

        $query = new \WP_Query($args);

        remove_filter('posts_groupby', $groupByCb);

        $years = [];

        while ($query->have_posts()) {
            $post = $query->next_post();

            if ($post->_date && get_post($post->_file)) {
                $year = (int) date('Y', strtotime($post->_date));

                $years[] = $year;
            }
        }

        if ($years === []) {
            return [(int) date('Y')];
        }

        return $years;
    }

    public function currentPage(): int
    {
        return $this->currentPageCache ??= ((int) get_query_var('year') ?:
            $this->getLatestDate());
    }

    private function getLatestDate(): int
    {
        $termObject = get_queried_object();

        if (! $termObject instanceof \WP_Term) {
            return (int) date('Y');
        }

        $groupByCb = function ($groupBy) {
            global $wpdb;

            return "YEAR({$wpdb->postmeta}.meta_value)";
        };

        add_filter('posts_groupby', $groupByCb);

        $args = [
            'post_type' => get_post_type(),
            'posts_per_page' => 1,
            'tax_query' => [
                [
                    'taxonomy' => $termObject->taxonomy,
                    'field' => 'term_id',
                    'terms' => $termObject->term_id,
                    'include_children' => false
                ]
            ],
            'meta_key' => '_date',
            'orderby'  => [
                'meta_value' => 'DESC',
            ],
        ];

        $query = new \WP_Query($args);

        remove_filter('posts_groupby', $groupByCb);

        while ($query->have_posts()) {
            $post = $query->next_post();

            if ($post->_date && get_post($post->_file)) {
                return (int) date('Y', strtotime($post->_date));
            }
        }

        return (int) date('Y');
    }

    /**
     * @param \WP_Term $termObject
     *
     * @return \App\Enums\DocumentTypeTemplatesEnum
     */
    private function getTemplate(\WP_Term $termObject): DocumentTypeTemplatesEnum
    {
        return $this->templateCache[$termObject->term_id] ??= DocumentTypeTemplatesEnum::tryFromOrDefault(
            (string) get_term_meta($termObject->term_id, '_template', true)
        );
    }
}
