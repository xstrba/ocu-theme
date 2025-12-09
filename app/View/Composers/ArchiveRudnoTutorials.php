<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ArchiveRudnoTutorials extends Composer
{
    public function categories()
    {
        $categories = get_terms('tutorial-category');

        return $categories && !is_wp_error($categories) ? $categories : null;
    }
}
