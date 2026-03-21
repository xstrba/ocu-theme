<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class PageZastupitelstvo extends Composer
{
    public const int POSTS_PER_PAGE = 5;

    protected function override(): array
    {
        return [
            'seatingQuery' => $this->seatingQuery(),
            'seating' => $this->seating(),
        ];
    }

    public function seatingQuery(): \WP_Query
    {
        $args = array(
            'posts_per_page' => '5',
            'post_type' => 'rudno-dokumenty',
            'meta_key' => '_date',
            'orderby'  => [
                'meta_value' => 'DESC',
                'modified' => 'DESC'
            ],
            'tax_query' => array(
                array(
                    'taxonomy' => 'document-type',
                    'field' => 'slug',
                    'terms' => 'zapisnice-zo-zastupitelstiev',
                )
            )
        );

        return new \WP_Query( $args );
    }

    /**
     * @return int|\WP_Post|null
     */
    public function seating()
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
