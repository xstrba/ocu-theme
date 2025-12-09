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
        ];
    }

    public function seatingQuery(): \WP_Query
    {
        $args = array(
            'posts_per_page' => '5',
            'post_type' => 'rudno-dokumenty',
            'meta_key' => '_date',
            'orderby'  => 'meta_value',
            'order'    => 'DESC',
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
}
