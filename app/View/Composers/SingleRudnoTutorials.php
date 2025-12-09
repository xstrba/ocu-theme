<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class SingleRudnoTutorials extends Composer
{
    public function ou()
    {
        $image = get_post(get_option('rudno_ou_preview'));

        $ou = [
          'address' => get_option('rudno_ou_address'),
          'phone'   => get_option('rudno_ou_phone'),
          'mail'   => get_option('rudno_ou_mail'),
          'hours'  => get_option('rudno_ou_hours'),
          'image'   => $image->guid,
        ];

        return $ou;
    }

    public function people()
    {
        $people = [];
        $terms = get_the_terms($post->ID, 'tutorial-category');

        if($terms && !is_wp_error( $terms )) {
          foreach($terms as $term) {
            $people += [ get_post(get_term_meta($term->term_id, '_person', true)) ];
          }
        }

        return $people;
    }
}
