<?php

declare(strict_types=1);

namespace App\Services;

final class GlobalDataResolver
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
     * @var string
     */
    private string $title;

    /**
     * @var string
     */
    private string $pageImage;

    /**
     * @var string
     */
    private string $siteName;

    /**
     * @return string|void
     */
    public function siteName()
    {
        return $this->siteName ??= get_bloginfo('name', 'display');
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
        if (isset($this->pageImage)) {
            return $this->pageImage ?: null;
        }

        global $post;

        if ($post?->post_type !== 'page') {
            $this->pageImage = '';

            return null;
        }

        $imgsrc = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

        $this->pageImage = $imgsrc ?: '';

        return $imgsrc ?: null;
    }

    /**
     * @param string $url
     * @return bool
     */
    public function isServerUrl(string $url): bool
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
    public function strippedContent(string $content, string $link = null): string
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
    public function title(): ?string
    {
        if (isset($this->title)) {
            return $this->title;
        }

        if (is_tax()) {
            $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            return $this->title = $term->name;
        }

        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return $this->title = get_the_title($home);
            }
            return $this->title = __('Nejnovšie príspevky', 'rudno-theme');
        }

        if (is_post_type_archive()) {
            return $this->title = post_type_archive_title('', false);
        }

        if (is_archive()) {
            return $this->title = get_the_archive_title();
        }

        if (is_search()) {
            return $this->title = sprintf(__('Výsledky hľadania <span class="text-muted-light-bg font-italic">„%s“</span>', 'rudno-theme'), get_search_query());
        }

        if (is_404()) {
            return $this->title = __('Stránka neexistuje', 'rudno-theme');
        }

        return $this->title = get_the_title();
    }
}
