<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class PagePoslanci extends Composer
{
    public const int POSTS_PER_PAGE = 5;

    protected function override(): array
    {
        return [
            'people' => $this->people(),
            'closestSeating' => $this->closestSeating(),
        ];
    }

    public function people(): array
    {
        $taxName = 'people_position';
        $slug = 'poslanec';
        $term = get_term_by('slug', $slug, $taxName);

        $args = [
            'post_type' => 'rudno-people',
            'numberposts' => '-1',
            'tax_query' => [
                [
                    'taxonomy' => $taxName,
                    'field' => 'term_id',
                    'terms' => $term->term_id,
                    'include_children' => true
                ]
            ]
        ];

        return get_posts($args);
    }

    public function closestSeating(): ?\WP_Post
    {
        $args = [
            'posts_per_page' => '1',
            'post_type' => 'rudno-seating',
            'meta_key' => '_date',
            'orderby'  => 'meta_value',
            'order'    => 'DESC',
            'meta_query' => [
                [
                    'key' => '_date',
                    'value' => date('Y-m-d'),
                    'compare' => '>=',
                ]
            ]
        ];

        $posts = get_posts($args);

        return empty($posts) ? null : $posts[0];
    }
}
