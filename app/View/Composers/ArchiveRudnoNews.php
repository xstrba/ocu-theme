<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

/**
 * Class ArchiveRudnoNews
 *
 * @package App\View\Composers
 */
class ArchiveRudnoNews extends Composer
{
    /**
     * @return int[]|\WP_Post[]
     */
    public function webNews(): array
    {
        $args = array(
            'numberposts' => '10',
            'post_type' => 'rudno-dokumenty',
            'orderby' => 'modified',
            'order' => 'DESC'
        );

        return get_posts($args);
    }

    /**
     * @return string|null
     */
    public function subtitle(): ?string
    {
        $link = get_option('rudno_ou_facebook');

        return $link ? (
            __('Pre tie najčerstvejšie novinky z prvej ruky sledujte našu', 'rudno-theme') .
            " <a href='$link' target='_blank' title='" . __('Odkaz na Facebook stránku', 'rudno-theme') . "'>" .
            __('Facebook stránku', 'rudno-theme') . "</a>."
        ) : null;
    }
}
