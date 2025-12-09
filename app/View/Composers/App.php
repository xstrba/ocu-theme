<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

/**
 * @deprecated Dont use
 *
 * Class App
 *
 * @package App\View\Composers
 */
class App extends Composer
{
    private array $months = [
        'Január',
        'Február',
        'Marec',
        'Apríl',
        'Máj',
        'Jún',
        'Júl',
        'August',
        'September',
        'Október',
        'November',
        'December'
    ];

    private array $shortDays = [
        'Po',
        'Ut',
        'St',
        'Št',
        'Pi',
        'So',
        'Ne'
    ];

    private array $fullDays = [
        'Pondelok',
        'Utorok',
        'Streda',
        'Štvrtok',
        'Piatok',
        'Sobota',
        'Nedeľa'
    ];

    /**
     * @return string|void
     */
    public function siteName()
    {
        return get_bloginfo('name');
    }

    /**
     * @return string[]
     */
    public function months(): array
    {
        return $this->months;
    }

    /**
     * @return string[]
     */
    public function shortDays(): array
    {
        return $this->shortDays;
    }

    /**
     * @return string[]
     */
    public function fullDays(): array
    {
        return $this->fullDays;
    }

    /**
     * @return string|null
     */
    public function pageImage(): ?string
    {
        global $post;

        if ($post?->post_type !== 'page') {
            return null;
        }

        $imgsrc = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

        return $imgsrc ?: null;
    }

    /**
     * @param string $url
     * @return bool
     */
    public static function isServerUrl(string $url): bool
    {
        return (bool) \preg_match('/^(((?!http).*)|.*' . $_SERVER['SERVER_NAME'] . '.*)$/', $url);
    }

    /**
     * Get stripped post content
     *
     * @param string $content
     * @param string|null $link
     * @return string
     */
    public static function strippedContent(string $content, string $link = null): string
    {
        $wordLimit = 55;
        $showMore = __("Zobraziť viac", "rudno-theme");

        $origContent = $content;
        $more = "<a href='$link'>$showMore</a>";

        $content = wp_trim_words($origContent, $wordLimit);

        if ($link && mb_strlen($origContent) !== mb_strlen($content)) {
            $content .= " $more";
        }

        return $content;
    }

    /**
     * @return string|null
     */
    public static function title(): ?string
    {
        if (is_tax()) {
            $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            return $term->name;
        }
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Nejnovšie príspevky', 'rudno-theme');
        }
        if (is_post_type_archive()) {
            return post_type_archive_title('', false);
        }
        if (is_archive()) {
            return get_the_archive_title();
        }
        if (is_search()) {
            return sprintf(__('Výsledky hľadania <span class="text-muted-light-bg font-italic">„%s“</span>', 'rudno-theme'), get_search_query());
        }
        if (is_404()) {
            return __('Stránka neexistuje', 'rudno-theme');
        }
        return get_the_title();
    }
}
