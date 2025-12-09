<?php

declare(strict_types=1);

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

final class RowCardZastupitelstvo extends Composer
{
    protected static $views = [
        'partials.row-card-zastupitelstvo',
    ];

    /**
     * @return \WP_Post|null
     */
    public function seating(): ?\WP_Post
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
