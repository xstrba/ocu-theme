<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class TaxonomyDocumentType extends Composer
{
    public function posts(): array
    {
        $year = (int) ((get_query_var('year')) ?: date('Y'));
        $nextYear = $year + 1;

        $termObject = get_queried_object();

        if (! $termObject) {
            return [];
        }

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
            'meta_key' => '_date',
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

        return \array_filter(get_posts($args), static function ($post) {
            return (bool) get_post($post->_file);
        });
    }

    public function pagesYears(): array
    {
        $termObject = get_queried_object();

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
            ]
        ];

        $all = get_posts($args);

        $years = [
            get_query_var('year') ?: date('Y') => true
        ];

        $years[date('Y')] = true;

        foreach ($all ?? [] as $post) {
            if ($post->_date && get_post($post->_file)) {
                $year = (int) date('Y', strtotime($post->_date));

                $years[$year] = true;
            }
        }

        $years = array_keys($years);
        rsort($years);

        return $years;
    }

    public function currentPage(): int
    {
        return (int) get_query_var('year') ?: date('Y');
    }
}
