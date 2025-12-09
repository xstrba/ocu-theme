<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

/**
 * Class PageHome
 *
 * @package App\View\Composers
 */
class PageHome extends Composer
{
    public const NUMBER_EVENTS = 3;
    public const NUMBER_NEWS = 2;

    protected static $views = [
        'front-page',
        'page-home',
    ];

    protected function override(): array
    {
        return [
            'events' => self::events(),
            'news' => self::news(),
            'roads' => self::roads(),
            'seating' => self::seating(),
        ];
    }

    /**
     * @return int[]|\WP_Post[]
     */
    public static function events(): array
    {
        $args = [
            'numberposts' => self::NUMBER_EVENTS,
            'post_type' => 'rudno-events',
            'meta_query'  =>  [
                'relation' => 'AND',
                'date_clause' => [
                    'key'     => '_date_from',
                    'value'   => date('Y-m-d'),
                    'compare' => '>=',
                ],
                'time_clause' => [
                    'key' => '_time_from',
                ],
            ],
            'orderby'  => [
                'date_clause' => 'ASC',
                'time_clause' => 'ASC',
            ],
        ];

        return get_posts($args);
    }

    /**
     * @return int[]|\WP_Post[]
     */
    public static function news(): array
    {
        $args = [
            'numberposts' => self::NUMBER_NEWS,
            'post_type' => 'rudno-news'
        ];

        return get_posts($args);
    }

    /**
     * @return array
     */
    public static function roads(): array
    {
        $args = [
            'numberposts' => -1,
            'post_type' => 'rudno-hp-menu'
        ];

        $links =  get_posts($args);

        $roads = [];
        foreach ($links ?? [] as $key => $post) {
            $roads[] = [
              'link' => $post->_link,
              'icon' => $post->_icon,
              'title' => $post->post_title,
              'target' => $post->_blank ? '_blank' : '_self',
              'btnlabel' => $post->post_title,
              'description' => $post->post_excerpt,
              'highlighted' => $post->_highlighted,
            ];
        }

        return $roads;
    }

    /**
     * @return int|\WP_Post|null
     */
    public static function seating()
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
