<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

/**
 * Class ArchiveRudnoDokumenty
 *
 * @package App\View\Composers
 */
class ArchiveRudnoDokumenty extends Composer
{
    /**
     * @return array
     */
    public function links(): array
    {
        global $wp;
        $path = '/' . $wp->request;
        $menuItems = wp_get_nav_menu_items( 'MainMenu' );

        $links = [];

        if ($menuItems) {
            $parentId = null;
            foreach ($menuItems as $item) {
                if ($item->url === $path) {
                    $parentId = $item->ID;
                    continue;
                }

                if ($parentId && $item->menu_item_parent == $parentId) {
                    $links[$item->title] = $item->url;
                }
            }
        }

        return $links;
    }
}
