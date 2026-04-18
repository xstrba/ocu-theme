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
        $this->seedTestData();

        return \array_merge(parent::merge(), [
            'title' => $this->title(),
            'term_options' => $this->getTermOptions(),
            'selected_term' => $this->selectedTerm(),
            'year_options' => $this->getYearOptions(),
            'selected_year' => (int) get_query_var('filter_year'),
        ]);
    }

    public function title(): string
    {
        $title = __('Úradná tabuľa', 'ocu-theme');
        $term = get_queried_object();

        if ($term instanceof \WP_Term) {
            $title .= ' - ' . $term->name;
        }

        return $title;
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

        if ($postTerm) {
            $tags[] = $postTerm->name;
        }

        $publishDate = get_post_meta($post->ID, '_date_publish', true);
        $unpublishDate = get_post_meta($post->ID, '_date_unpublish', true);
        $today = \date('Y-m-d H:i:s');

        if ($publishDate) {
            $tags[] = esc_html(date_i18n('d. m. Y', strtotime($publishDate)));

            if ($publishDate > $today) {
                $tags[] = '<span class="text-brand-blue font-weight-bold">' . __('Naplánované vyvesenie', 'ocu-theme') . '</span>';
            }
        }

        if ($unpublishDate) {
            if ($today > $unpublishDate) {
                $tags[] = '<span class="text-danger font-weight-bold">' . __('Zvesené', 'ocu-theme') . '</span>';
            }
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
     * @return array<int, array{label: string, url: string, count: int}>
     */
    private function getTermOptions(): array
    {
        global $wpdb;

        $terms = get_terms([
            'taxonomy' => OfficialBoardTaxonomyRegistrar::TAXONOMY,
            'hide_empty' => false,
        ]);

        $filterYear = (int) get_query_var('filter_year');
        $search = get_query_var('s');

        // Filter terms based on current year and search
        $where = $this->getBaseWhere($search);
        $where .= $this->getDateWhere($filterYear);

        // Get counts per term
        $countsQuery = $wpdb->prepare("
            SELECT tt.term_id, COUNT(DISTINCT p.ID) as post_count
            FROM {$wpdb->posts} p
            JOIN {$wpdb->term_relationships} tr ON p.ID = tr.object_id
            JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
            LEFT JOIN {$wpdb->postmeta} pm_pub ON p.ID = pm_pub.post_id AND pm_pub.meta_key = '_date_publish'
            LEFT JOIN {$wpdb->postmeta} pm_unpub ON p.ID = pm_unpub.post_id AND pm_unpub.meta_key = '_date_unpublish'
            WHERE {$where}
              AND tt.taxonomy = %s
            GROUP BY tt.term_id
        ", OfficialBoardTaxonomyRegistrar::TAXONOMY);

        $termCounts = $wpdb->get_results($countsQuery, OBJECT_K);

        // Get total unique posts count matching year and search
        $totalCountQuery = "
            SELECT COUNT(DISTINCT p.ID)
            FROM {$wpdb->posts} p
            LEFT JOIN {$wpdb->postmeta} pm_pub ON p.ID = pm_pub.post_id AND pm_pub.meta_key = '_date_publish'
            LEFT JOIN {$wpdb->postmeta} pm_unpub ON p.ID = pm_unpub.post_id AND pm_unpub.meta_key = '_date_unpublish'
            WHERE {$where}
        ";
        $totalCount = (int) $wpdb->get_var($totalCountQuery);

        // Map counts to terms
        foreach ($terms as $term) {
            $term->count = (int) ($termCounts[$term->term_id]->post_count ?? 0);
        }

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

        $urlArgs = array_filter([
            'filter_year' => $filterYear ?: null,
            's' => $search ?: null,
        ]);

        $options = [
            0 => [
                'url' => add_query_arg($urlArgs, \get_post_type_archive_link(OfficialBoardRegistrar::POST_TYPE)),
                'label' => __('Všetky', 'ocu-theme') . ' (' . \number_format_i18n($totalCount) . ')',
                'count' => $totalCount,
            ]
        ];

        foreach ($terms as $term) {
            if ($term->count > 0) {       
                $options[$term->term_id] = [
                    'url' => add_query_arg($urlArgs, get_term_link($term)),
                    'label' => $term->name . ' (' . \number_format_i18n($term->count) . ')',
                    'count' => $term->count,
                ];
            }
        }

        return $options;
    }

    /**
     * @return array<int, array{label: string, url: string, count: int}>
     */
    private function getYearOptions(): array
    {
        global $wpdb;

        $search = get_query_var('s');
        $selectedTerm = $this->selectedTerm();

        // Base where for filtering years (respects search and category)
        $where = $this->getBaseWhere($search);
        
        if ($selectedTerm) {
            $where .= $wpdb->prepare(
                " AND p.ID IN (SELECT object_id FROM {$wpdb->term_relationships} tr WHERE tr.term_taxonomy_id IN (SELECT term_taxonomy_id FROM {$wpdb->term_taxonomy} tt WHERE tt.term_id = %d))",
                $selectedTerm
            );
        }

        // Get active documents count (filter_year = 0)
        $activeWhere = $where . $this->getDateWhere(0);
        $activeCountQuery = "
            SELECT COUNT(DISTINCT p.ID)
            FROM {$wpdb->posts} p
            LEFT JOIN {$wpdb->postmeta} pm_pub ON p.ID = pm_pub.post_id AND pm_pub.meta_key = '_date_publish'
            LEFT JOIN {$wpdb->postmeta} pm_unpub ON p.ID = pm_unpub.post_id AND pm_unpub.meta_key = '_date_unpublish'
            WHERE {$activeWhere}
        ";
        $activeCount = (int) $wpdb->get_var($activeCountQuery);

        // Get counts for each year
        // We join pm for the actual year grouping, but need pm_pub/pm_unpub for the shared $where clause
        $yearCountsQuery = "
            SELECT YEAR(pm.meta_value) as doc_year, COUNT(DISTINCT p.ID) as post_count
            FROM {$wpdb->posts} p
            JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
            LEFT JOIN {$wpdb->postmeta} pm_pub ON p.ID = pm_pub.post_id AND pm_pub.meta_key = '_date_publish'
            LEFT JOIN {$wpdb->postmeta} pm_unpub ON p.ID = pm_unpub.post_id AND pm_unpub.meta_key = '_date_unpublish'
            WHERE {$where}
              AND pm.meta_key IN ('_date_publish', '_date_unpublish')
              AND pm.meta_value != ''
              AND pm.meta_value IS NOT NULL
            GROUP BY doc_year
            ORDER BY doc_year DESC
        ";
        $yearCounts = $wpdb->get_results($yearCountsQuery, OBJECT_K);

        // Get the minimum year from _date_publish to establish the range
        $minYear = (int) $wpdb->get_var($wpdb->prepare("
            SELECT MIN(YEAR(meta_value))
            FROM {$wpdb->postmeta} pm
            JOIN {$wpdb->posts} p ON pm.post_id = p.ID
            WHERE p.post_type = %s
            AND p.post_status = 'publish'
            AND pm.meta_key = '_date_publish'
            AND pm.meta_value != ''
            AND pm.meta_value IS NOT NULL
        ", OfficialBoardRegistrar::POST_TYPE));

        $currentYear = (int) date('Y');
        // If no posts exist yet, use current year as the only option
        $minYear = $minYear ?: $currentYear;
        
        // Ensure we don't include future years and the range is descending
        $allYears = range($currentYear, $minYear);

        $baseUrl = $selectedTerm ? get_term_link($selectedTerm) : get_post_type_archive_link(OfficialBoardRegistrar::POST_TYPE);
        $urlArgs = array_filter([
            's' => $search ?: null,
        ]);

        $options = [
            0 => [
                'url' => add_query_arg($urlArgs, $baseUrl),
                'label' => __('Aktuálne vyvesené', 'ocu-theme') . ' (' . \number_format_i18n($activeCount) . ')',
                'count' => $activeCount,
            ],
        ];

        foreach ($allYears as $year) {
            if (!$year) continue;
            $count = (int) ($yearCounts[$year]->post_count ?? 0);
            $options[(int)$year] = [
                'url' => add_query_arg(array_merge($urlArgs, ['filter_year' => $year]), $baseUrl),
                'label' => $year . ' (' . \number_format_i18n($count) . ')',
                'count' => $count,
            ];
        }

        return $options;
    }

    private function getBaseWhere(?string $search): string
    {
        global $wpdb;

        $where = $wpdb->prepare(
            "p.post_type = %s AND p.post_status = 'publish'",
            OfficialBoardRegistrar::POST_TYPE
        );

        if ($search) {
            // Safety: Truncate search input and limit consecutive spaces
            $search = trim(mb_substr($search, 0, 150));
            
            // Split search into terms (matching standard WordPress behavior)
            $terms = explode(' ', $search);
            $terms = array_filter($terms, fn($t) => mb_strlen($t) >= 3); // Remove terms shorter than 3 characters
            $terms = array_slice($terms, 0, 10); // Safety: Limit to first 10 terms

            if (!empty($terms)) {
                $searchParts = [];
                foreach ($terms as $term) {
                    $searchLike = '%' . $wpdb->esc_like($term) . '%';
                    $searchParts[] = $wpdb->prepare(
                        "(p.post_title LIKE %s OR p.post_excerpt LIKE %s OR p.post_content LIKE %s)",
                        $searchLike, $searchLike, $searchLike
                    );
                }
                $where .= " AND (" . implode(" AND ", $searchParts) . ")";
            }
        }

        return $where;
    }

    private function getDateWhere(int $filterYear): string
    {
        global $wpdb;
        $where = "";

        if ($filterYear) {
            $yearStart = "{$filterYear}-01-01 00:00:00";
            $yearEnd = "{$filterYear}-12-31 23:59:59";
            $where .= $wpdb->prepare(
                " AND (pm_pub.meta_value BETWEEN %s AND %s)",
                $yearStart, $yearEnd
            );
        } else {
            $today = \date('Y-m-d H:i') . ':00';
            // Align with Registrar comparison (using string comparison for speed, mirroring WP logic)
            $where .= $wpdb->prepare(
                " AND (pm_pub.meta_value IS NOT NULL AND pm_pub.meta_value != '' AND pm_pub.meta_value <= %s) 
                  AND (pm_unpub.meta_value IS NOT NULL AND pm_unpub.meta_value != '' AND pm_unpub.meta_value >= %s)",
                $today, $today
            );
        }

        return $where;
    }

    private function selectedTerm(): int
    {
        $term = get_queried_object();

        if ($term instanceof \WP_Term) {
            return $term->term_id;
        }

        return 0;
    }

    private function seedTestData(): void
    {
        if (($_GET['seed'] ?? '') !== '1') {
            return;
        }

        // 1. Ensure categories exist
        $categories = ['VZN', 'Zmluvy'];
        $catIds = [];
        foreach ($categories as $catName) {
            $term = wp_insert_term($catName, OfficialBoardTaxonomyRegistrar::TAXONOMY);
            if (is_wp_error($term)) {
                $existing = get_term_by('name', $catName, OfficialBoardTaxonomyRegistrar::TAXONOMY);
                $catIds[] = $existing ? $existing->term_id : null;
            } else {
                $catIds[] = $term['term_id'];
            }
        }
        $catIds = array_filter($catIds);

        // 2. Fetch random media
        $mediaIds = get_posts([
            'post_type' => 'attachment',
            'posts_per_page' => 50,
            'fields' => 'ids',
        ]);

        $currentYear = (int) date('Y');
        
        for ($offset = 0; $offset <= 2; $offset++) {
            $year = $currentYear - $offset;
            
            for ($i = 1; $i <= 40; $i++) {
                $isActive = ($i <= 20);
                
                $title = "Testovací dokument {$year}-" . ($isActive ? 'A' : 'I') . "-{$i}";
                
                $postId = wp_insert_post([
                    'post_title' => $title,
                    'post_type' => OfficialBoardRegistrar::POST_TYPE,
                    'post_status' => 'publish',
                    'post_date' => "{$year}-01-01 00:00:00",
                ]);

                if ($postId) {
                    // Category
                    if (!empty($catIds)) {
                        $cid = $catIds[array_rand($catIds)];
                        wp_set_post_terms($postId, [$cid], OfficialBoardTaxonomyRegistrar::TAXONOMY);
                    }

                    // Dates
                    if ($offset === 0 && $isActive) {
                        // Current year active docs: published on first day of year
                        $publish = "{$year}-01-01 00:00:00";
                    } else {
                        // Others: random day/month
                        $randDay = str_pad((string)rand(1, 28), 2, '0', STR_PAD_LEFT);
                        $randMonth = str_pad((string)rand(1, 12), 2, '0', STR_PAD_LEFT);
                        $publish = "{$year}-{$randMonth}-{$randDay} 00:00:00";
                    }

                    $unpublish = $isActive ? '2030-12-31 23:59:59' : "{$year}-12-31 00:00:00";

                    update_post_meta($postId, '_date_publish', $publish);
                    update_post_meta($postId, '_date_unpublish', $unpublish);

                    // Files (1-3 random media)
                    if (!empty($mediaIds)) {
                        $count = rand(1, 3);
                        $shuffledMedia = $mediaIds;
                        shuffle($shuffledMedia);
                        $files = array_slice($shuffledMedia, 0, min($count, count($mediaIds)));
                        update_post_meta($postId, '_file', $files);
                    }
                }
            }
        }
    }
}
