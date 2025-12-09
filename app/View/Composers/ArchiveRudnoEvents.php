<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

/**
 * Class ArchiveRudnoEvents
 *
 * @package App\View\Composers
 */
class ArchiveRudnoEvents extends Composer
{
    const POST_TYPE = 'rudno-events';
    const NUMBER_LATESTS_EVENTS = 3;

    /**
     * @return array
     */
    public function eventsByYearMonth(): array
    {
        $args = [
            'post_type' => self::POST_TYPE,
            'numberposts' => -1,
            'meta_query' => [
                'relation' => 'AND',
                'date_from_clause' => [
                    'key' => '_date_from',
                    'compare' => '>=',
                    'value' => \date('Y-m-d', \strtotime("last sunday midnight")),
                ],
                'time_from_clause' => [
                    'key' => '_time_from',
                ],
            ],
            'orderby' => [
                'date_from_clause' => 'ASC',
                'time_from_clause' => 'ASC',
            ],
        ];

        $events =  get_posts($args);

        $eventsArray = [];

        $nextYear = ((int) date('Y')) + 1;
        $prevYear = $nextYear - 2;

        foreach ($events as $post) {
            $timestamp = \strtotime($post->_date_from);
            $fromYear = (int) \date('Y', $timestamp);
            $fromMonth = (int) \date('m', $timestamp);

            if ($fromYear >= $prevYear || $fromYear <= $nextYear) {
                $eventsArray[$fromYear] ??= [];
                $eventsArray[$fromYear][$fromMonth - 1][] = $post;
            }
        }

        if (count($eventsArray) === 1) {
            $eventsArray = [
                '' => \array_values($eventsArray)[0],
            ];
        }

        return $eventsArray;
    }

    /**
     * Get nearest future events
     *
     * @param string|int|null $id
     * @return array
     */
    public static function latests($id = null): array
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
}
