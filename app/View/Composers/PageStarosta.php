<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use WP_Post;

class PageStarosta extends Composer
{
    protected function override(): array
    {
        return [
            'mayor' => $this->mayor(),
            'viceMayor' => $this->viceMayor(),
            'worksQuery' => $this->worksQuery(),
            'pageContent' => $this->pageContent(),
        ];
    }

    /**
     * @return \WP_Post|null
     */
    public function mayor(): ?WP_Post
    {
        $taxName = 'people_position';
        $slug = 'starosta';
        $term = \get_term_by('slug', $slug, $taxName);

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

        $post = $posts ? $posts[0] : null;

        return $post instanceof WP_Post ? $post : null;
    }

    public function viceMayor(): ?WP_Post
    {
        $taxName = 'people_position';
        $slug = 'zastupca-starostu';
        $term = \get_term_by('slug', $slug, $taxName);

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
        $post = $posts ? $posts[0] : null;

        return $post instanceof WP_Post ? $post : null;
    }

    public function worksQuery(): \WP_Query
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
                    'terms' => 'praca-starostu',
                )
            )
        );

        return new \WP_Query( $args );
    }

    /**
     * @return string
     */
    public function pageContent(): string
    {
        $content = '';

        while (have_posts()) {
            the_post();
            $content .= get_the_content();
        }

        return $content;
    }
}
