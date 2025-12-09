<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class PageObecnyUrad extends Composer
{
    public function address()
    {
        return get_option('rudno_ou_address');
    }

    public function phone()
    {
        return get_option('rudno_ou_phone');
    }

    public function email()
    {
        return get_option('rudno_ou_mail');
    }

    public function hours()
    {
        return get_option('rudno_ou_hours', []);
    }

    public function currentHours()
    {
        $hours = get_option('rudno_ou_hours', []);

        $today = (int) date('N');

        $items = isset($hours[$today - 1]) ? $hours[$today - 1] : [];

        $string = '';
        $i = 0;
        foreach ($items as $item) {
            if (! ($item['to'] ?? false)) {
                continue;
            }

            if ($i === 0) {
                $string .= 'Dnes otvorené: <strong>' . $item['from'] . ' - ' . $item['to'] . '</strong>';
            } else {
                $string .= ' a <strong>' . $item['from'] . ' - ' . $item['to'] . '</strong>';
            }

            $i++;
        }

        return $string ?: 'Dnes zatvorené';
    }

    public function preview()
    {
        $imagePostId =  get_option('rudno_ou_preview', null);
        $image = get_post($imagePostId);

        return $image ? $image->guid : null;
    }

    public function headerImage()
    {
        global $post;

        $imagePostId = get_post_thumbnail_id($post->ID);
        $image = get_post($imagePostId);

        return $image ? $image->guid : null;
    }

    public function employeesTop()
    {
        $taxName = 'people_position';
        $slug = 'zamestnanec';
        $term = get_term_by('slug', $slug, $taxName);

        $args = [
            'post_type' => 'rudno-people',
            'numberposts' => -1,
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

        return $posts;
    }

    public function employeesBottom()
    {
        $taxName = 'people_position';
        $slug = 'pracovnik';
        $term = get_term_by('slug', $slug, $taxName);

        $args = [
            'post_type' => 'rudno-people',
            'numberposts' => -1,
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

        return $posts;
    }

    /**
     * @return array<int|\WP_Post>
     */
    public function usefulLinks(): array
    {
        $args = [
            'post_type' => 'rudno-useful-links',
            'numberposts' => -1,
        ];

        return get_posts($args);
    }
}
