<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class SingleRudnoEvents extends Composer
{
    const POST_TYPE = 'rudno-events';
    const NUMBER_LATESTS_EVENTS = 3;

    /**
     * Get nearest future events
     *
     * @param string|int|null $id
     * @return array
     */
    public function latests($id = null): array
    {
        $args = [
            'post_type' => self::POST_TYPE,
            'numberposts' => self::NUMBER_LATESTS_EVENTS,
            'post__not_in' => [$id],
            'meta_query' => [
                'relation' => 'AND',
                'date_from_clause' => [
                    'key' => '_date_from',
                    'compare' => '>=',
                    'value' => \date('Y-m-d', \strtotime("last sunday midnight")),
                ],
                'time_from_clause' => [
                    'key' => '_time_from',
                ]
            ],
            'oreder_by' => [
                'date_from_clause',
                'time_from_clause',
            ]
        ];

        return get_posts($args) ?: [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function override(): array
    {
        $post = get_post();

        return [
            'latests' => $this->latests($post->ID),
        ];
    }
}
