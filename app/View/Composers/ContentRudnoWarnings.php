<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

/**
 * Class App
 *
 * @package App\View\Composers
 */
class ContentRudnoWarnings extends Composer
{
    protected static $views = [
        'partials.content-rudno-warnings',
    ];

    /**
     * @return int|mixed|\WP_Post|null
     */
    public function appWarning()
    {
        global $wp;

        $subpaths = [];
        $partials = \explode('/', $wp->request);
        $partialsCount = \count($partials);
        for ($i = 0; $i < $partialsCount; $i++) {
            $subpaths[$i] = implode('/', \array_slice($partials, 0, $i + 1));
        }

        $queries = [
            'relation' => 'OR',
            [
            'key' => '_pages',
            'value' => '(^|,)' . $wp->request . '(,|$)',
            'compare' => 'REGEXP'
            ],
            [
            'key' => '_pages',
            'value' => '(^|,)\*(,|$)',
            'compare' => 'REGEXP'
            ]
        ];

        if (\count($subpaths) === 1 && empty($subpaths[0])) {
            $queries[] = [
                'key' => '_pages',
                'value' => '(^|,)/(,|$)',
                'compare' => 'REGEXP'
            ];
        }

        foreach ($subpaths as $subpath) {
            $queries[] = [
                'key' => '_pages',
                'value' => '(^|,)' . $subpath . '\*(,|$)',
                'compare' => 'REGEXP'
            ];
        }

        $args = [
            'numberposts' => 1,
            'post_type' => 'rudno-warnings',
            'meta_query' => [
            $queries
            ]
        ];

        $news =  get_posts($args);
        return $news[0] ?? null;
    }
}
