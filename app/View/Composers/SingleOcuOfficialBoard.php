<?php

namespace App\View\Composers;

use Plugin\OfficialBoard\Registrars\OfficialBoardRegistrar;
use Plugin\OfficialBoard\Registrars\OfficialBoardTaxonomyRegistrar;
use Roots\Acorn\View\Composer;

class SingleOcuOfficialBoard extends Composer
{
    public const string POST_TYPE = OfficialBoardRegistrar::POST_TYPE;

    protected function override(): array
    {
        return [
            'files' => $this->files(),
            'document_type' => $this->documentType(),
            'published_from' => $this->publishedFrom(),
            'published_to' => $this->publishedTo(),
        ];
    }

    /**
     * @return array<array-key, \WP_Post>
     */
   protected function files(): array
    {
        $post = get_post();

        $filesMeta = get_post_meta($post->ID, '_file')[0] ?? [];

        if ($filesMeta === []) {
            return [];
        }

        return get_posts([
            'post__in' => $filesMeta,
            'post_type' => 'attachment',
            'orderby' => 'post__in',
            'posts_per_page' => -1,
        ]);
    }

    /**
     * @return string
     */
    protected function documentType(): string
    {
        $post = get_post();

        $postTerms = get_the_terms($post->ID, OfficialBoardTaxonomyRegistrar::TAXONOMY);
        return ($postTerms ? $postTerms[0] : null)?->name;
    }

    protected function publishedFrom(): ?string
    {
        $post = get_post();

        $raw = $post->_date_publish;

        try {
            $date = new \DateTime($raw);
        } catch (\DateMalformedStringException) {
            return null;
        }

        return \date('d. m. Y H:i', $date->getTimestamp());
    }

    protected function publishedTo(): ?string
    {
        $post = get_post();

        $raw = $post->_date_unpublish;

        try {
            $date = new \DateTime($raw);
        } catch (\DateMalformedStringException) {
            return null;
        }

        return \date('d. m. Y H:i', $date->getTimestamp());
    }
}
