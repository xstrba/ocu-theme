<?php

namespace App\View\Composers;

use Plugin\OfficialBoard\Registrars\OfficialBoardRegistrar;
use Plugin\OfficialBoard\Registrars\OfficialBoardTaxonomyRegistrar;
use Roots\Acorn\View\Composer;

/**
 * Class ArchiveRudnoDokumenty
 *
 * @package App\View\Composers
 */
class ArchiveOcuOfficialBoard extends Composer
{
    protected static $views = [
        'archive-ocu-official-board',
        'taxonomy-ocu-official-board-document-type',
    ];

    protected function merge(): array
    {
        return \array_merge(parent::merge(), [
            'term_options' => $this->getTermOptions(),
            'selected_term' => $this->selectedTerm(),
        ]);
    }

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

        return $start . '<span class="font-weight-bold">' . \number_format_i18n($totalPosts) . '</span>' . $end;
    }

    /**
     * @return array<int, array{label: string, url: string}>
     */
    private function getTermOptions(): array
    {
        $terms = get_terms([
            'taxonomy' => OfficialBoardTaxonomyRegistrar::TAXONOMY,
            'hide_empty' => false,
        ]);

        // Custom sort function
        \usort($terms, static function(\WP_Term $a, \WP_Term $b): int {
            if ($a->count > 0 && $b->count === 0) {
                return -1;
            }

            if ($a->count === 0 && $b->count > 0) {
                return 1;
            }

            return \strcmp($a->name, $b->name);
        });

        $count = 0;

        /** @noinspection PhpArrayIndexImmediatelyRewrittenInspection */
        $options = [
            0 => [],
        ];

        foreach ($terms as $term) {
            $count += $term->count;

            $options[$term->term_id] = [
                'url' => get_term_link($term),
                'label' => $term->name . ' (' . \number_format_i18n($term->count) . ')',
            ];
        }

        $options[0] = [
            'url' => \get_post_type_archive_link(OfficialBoardRegistrar::POST_TYPE),
            'label' => __('Všetky', 'ocu-theme') . ' (' . \number_format_i18n($count) . ')',
        ];

        return $options;
    }

    private function selectedTerm(): int
    {
        $term = get_queried_object();

        if ($term instanceof \WP_Term) {
            return $term->term_id;
        }

        return 0;
    }
}
