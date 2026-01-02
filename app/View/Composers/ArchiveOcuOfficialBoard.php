<?php

namespace App\View\Composers;

use Plugin\OfficialBoard\Registrars\OfficialBoardTaxonomyRegistrar;
use Roots\Acorn\View\Composer;

/**
 * Class ArchiveRudnoDokumenty
 *
 * @package App\View\Composers
 */
class ArchiveOcuOfficialBoard extends Composer
{
    /**
     * @param \WP_Post $post
     *
     * @return array<array-key, string>
     */
    public function getPostTags(\WP_Post $post): array
    {
        $tags = [];

        $postTerms = get_the_terms($post->ID, OfficialBoardTaxonomyRegistrar::TAXONOMY);
        $postTerm = $postTerms ? $postTerms[0] : null;

        $tags[] = $postTerm->name;

        $value = get_post_meta($post->ID, '_date_publish', true);

        if ($value) {
            $tags[] = esc_html(date_i18n('d. m. Y', strtotime($value)));
        }

        $fileMeta = get_post_meta($post->ID, '_file')[0] ?? [];
        $fileCount = 0;

        foreach ($fileMeta as $value) {
            if (\is_numeric($value)) {
                $fileCount++;
            }
        }

        if ($fileCount > 1 && $fileCount < 5) {
            $tags[] = __($fileCount . ' súbory', 'ocu-theme');
        } else if ($fileCount > 5) {
            $tags[] = __($fileCount . ' súborov', 'ocu-theme');
        }

        return $tags;
    }

    /**
     * @param int $totalPosts
     * @return string
     */
    public function getTotalPostsLabel(int $totalPosts): string
    {
        if ($totalPosts > 1 && $totalPosts < 5) {
            $start = __('Zobrazujú sa ', 'ocu-theme');
            $end = __(' výsledky', 'ocu-theme');
        } else if ($totalPosts === 1) {
            $start = __('Zobrazuje sa ', 'ocu-theme');
            $end = __(' výsledok', 'ocu-theme');
        } else {
            $start = __('Zobrazuje sa ', 'ocu-theme');
            $end = __(' výsledkov', 'ocu-theme');
        }

        return $start . \number_format_i18n($totalPosts) . $end;
    }
}
