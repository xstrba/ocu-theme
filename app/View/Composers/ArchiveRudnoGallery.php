<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

/**
 * Class ArchiveRudnoGallery
 *
 * @package App\View\Composers
 */
class ArchiveRudnoGallery extends Composer
{
    const POST_TYPE = 'rudno-gallery';

    /**
     * @return array|int[]|\WP_Post[]
     */
    public function galleries(): array
    {
        $args = [
            'post_type' => self::POST_TYPE,
            'numberposts' => -1
        ];

        return get_posts($args)?: [];
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
            'numberposts' => '3',
            'post__not_in' => [$id]
        ];

        return get_posts($args) ?: [];
    }
}
