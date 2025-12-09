<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class PageObecneKomisie extends Composer
{
    public function comissions()
    {
        $taxName = 'people_comission';

        $terms = get_terms([
            'taxonomy' => $taxName,
            'hide_empty' => true
        ]);

        $byTerms = [];

        foreach ($terms as $term) {
            $headId = get_term_meta($term->term_id, '_head', true);
            $people = get_posts([
                'numberposts' => -1,
                'post_type' => 'rudno-people',
                'tax_query' => [
                    [
                        'taxonomy' => $taxName,
                        'field' => 'term_id',
                        'terms' => $term->term_id
                    ]
                ]
            ]);

            usort($people, function($a, $b) use ($headId) {
                if ($a->ID == $headId) {
                    $a->is_head = true;

                    return -1;
                }

                $a->is_head = false;
                return 1;
            });

            $byTerms[$term->name] = $people;
        }

        return $byTerms;
    }
}
