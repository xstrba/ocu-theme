<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class TemplateRozcestnik extends Composer
{
    /**
     * Get links from page table element
     */
    public function links()
    {
        $links = [];

        // get subpages
        foreach (self::subPages() as $subPage) {
            $links[$subPage->post_title] = [
                'link' => get_permalink($subPage->ID),
                'image' => wp_get_attachment_url( get_post_thumbnail_id($subPage->ID) ),
            ];
        }

        // get from table content
        $contents = get_the_content();
        $DOM = new \DOMDocument;
        @$DOM->loadHTML('<?xml encoding="utf-8" ?>' . $contents);
        $items = $DOM->getElementsByTagName('tr');

        foreach ($items as $node) {
            $key = '';
            $i = 0;
            foreach ($node->childNodes as $tdNode) {
                if ($i === 0) {
                    $key = $tdNode->textContent;
                } else if ($i === 1) {
                    if ($key) {
                        $links[$key] = [
                            'link' => $tdNode->textContent,
                        ];
                    }
                    break;
                }
                $i++;
            }
        }

        return $links;
    }

    /**
     * @return array|WP_Post[]
     */
    private static function subPages(): array
    {
        global $post;

        if ($post->post_type !== 'page') {
            return [];
        }

        return get_pages([
            'child_of' => $post->ID,
            'sort_column' => 'menu_order',
        ]);
    }
}
