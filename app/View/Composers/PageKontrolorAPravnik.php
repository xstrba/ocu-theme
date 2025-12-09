<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

/**
 * Class PageKontrolorAPravnik
 *
 * @package App\View\Composers
 */
class PageKontrolorAPravnik extends Composer
{
    protected function override(): array
    {
        return [
            'controllerDocsQuery' => $this->controllerDocsQuery(),
            'lawyer' => $this->lawyer(),
            'controller' => $this->controller(),
        ];
    }

    /**
     * @return int|\WP_Post|null
     */
    public function controller()
    {
        $taxName = 'people_position';
        $slug = 'kontrolor';
        $term = get_term_by('slug', $slug, $taxName);

        $args = [
            'post_type' => 'rudno-people',
            'numberposts' => 1,
            'tax_query' => [
                [
                    'taxonomy' => $taxName,
                    'field' => 'term_id',
                    'terms' => $term->term_id,
                    'include_children' => true
                ]
            ]
        ];

        $posts = get_posts($args);

        return $posts ? $posts[0] : null;
    }

    /**
     * @return int|\WP_Post|null
     */
    public function lawyer()
    {
        $taxName = 'people_position';
        $slug = 'pravnik';
        $term = get_term_by('slug', $slug, $taxName);

        $args = [
            'post_type' => 'rudno-people',
            'numberposts' => 1,
            'tax_query' => [
                [
                    'taxonomy' => $taxName,
                    'field' => 'term_id',
                    'terms' => $term->term_id,
                    'include_children' => true
                ]
            ]
        ];

        $posts = get_posts($args);

        return $posts ? $posts[0] : null;
    }

    /**
     * @return \WP_Query
     */
    public function controllerDocsQuery(): \WP_Query
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
                    'terms' => 'vysledky-a-plany-hlavneho-kontrolora',
                )
            )
        );

        return new \WP_Query( $args );
    }
}
