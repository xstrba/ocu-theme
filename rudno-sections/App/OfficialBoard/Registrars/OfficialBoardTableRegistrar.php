<?php

declare(strict_types=1);

namespace Plugin\OfficialBoard\Registrars;

use Plugin\Common\Application;
use WP_Query;

final class OfficialBoardTableRegistrar
{
    /**
     * @param \Plugin\Common\Application $app
     */
    public function register(Application $app): void
    {
        $app->addManageEditCPTColumnsFilter(OfficialBoardRegistrar::POST_TYPE, static function ($columns): array {
            $taxonomyKey = 'taxonomy-' . OfficialBoardTaxonomyRegistrar::TAXONOMY;

            return [
                'cb' => $columns['cb'],
                'title' => $columns['title'],
                $taxonomyKey => $columns[$taxonomyKey],
                'publish_at' => __('Vyvesené od', 'ocu-theme'),
                'unpublish_at' => __('Vyvesené do', 'ocu-theme'),
                'author' => __('Autor', 'ocu-theme'),
            ];
        });

        $app->addManageCPTPostsCustomColumnAction(OfficialBoardRegistrar::POST_TYPE, static function (string $column): void {
            global $post;

            switch( $column ) {
                case 'src' :

                    $src = $post->_file ? wp_get_attachment_url($post->_file) : null;

                    if ( !empty( $src ) ) {
                        echo "<a href='". $src ."'>";
                        echo explode('/uploads/', $src)[1];
                        echo "</a>";
                    } else {
                        echo __( 'Unknown' );
                    }
                    break;
                case 'publish_at' :
                    $value = $post->_date_publish;

                    echo $value
                        ? esc_html(date_i18n('d.m.Y H:i', strtotime($value)))
                        : '—';
                    break;
                case 'unpublish_at' :
                    $value = $post->_date_unpublish;

                    echo $value
                        ? esc_html(date_i18n('d.m.Y H:i', strtotime($value)))
                        : '—';
                    break;
                default :
                    break;
            }
        });

        $app->addManageEditCPTSortableColumnsFilter(OfficialBoardRegistrar::POST_TYPE, static function ($columns): array {
            $columns['publish_at']   = 'publish_at';
            $columns['unpublish_at'] = 'unpublish_at';
            return $columns;
        });
    }
}
