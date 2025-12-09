<?php

use Yoast\WP\SEO\Generators\Schema\Person;
use Yoast\WP\SEO\Config\Schema_IDs;

/**
 * Class StarostaSeo
 */
class StarostaSeo extends Person {
    public const FIELD_EMAIL = 'email';
    public const FIELD_NAME = 'name';
    public const FIELD_PHONE = 'telephone';
    public const FIELD_POSITION = 'jobTitle';
    public const FIELD_WORKS_FOR = 'worksFor';
    public const FIELD_MAIN_ENTITY = 'mainEntityOfPage';
    public const FIELD_NATIONALITY = 'nationality';
    public const FIELD_IMAGE = 'image';

    /**
     * A value object with context variables.
     *
     * @var \WPSEO_Schema_Context
     */
    public $context;

    /**
     * Team_Member constructor.
     *
     * @param \WPSEO_Schema_Context $context Value object with context variables.
     */
    public function __construct(\WPSEO_Schema_Context $context)
    {
        $this->context = $context;
    }

    /**
     * Determines whether or not a piece should be added to the graph.
     *
     * @return bool Whether or not a piece should be added.
     */
    public function is_needed(): bool
    {
        return is_page('starosta');
    }

    /**
     * Adds our Starosta's piece of the graph.
     *
     * @return array|mixed[] Person Schema markup.
     */
    public function generate(): array
    {
        $data = parent::generate();

        $taxName = 'people_position';
        $term = get_term_by('slug', 'starosta', $taxName);

        $args = [
            'post_type' => 'rudno-people',
            'numberposts' => 1,
            'tax_query' => [
                [
                    'taxonomy' => $taxName,
                    'field' => 'term_id',
                    'terms' => $term->term_id,
                    'include_children' => true
                ]
            ]
        ];

        $posts = get_posts($args);

        $starosta = $posts ? $posts[0] : null;

        if ($starosta) {
            $data['@type'] = 'Person';
            $data[self::FIELD_WORKS_FOR] = [ '@id' => $this->context->site_url . Schema_IDs::ORGANIZATION_HASH ];
            $data[self::FIELD_MAIN_ENTITY] = [ '@id' => $this->context->canonical . Schema_IDs::WEBPAGE_HASH ];

            if ($starosta->_email) {
                $data[self::FIELD_EMAIL] = $starosta->_email;
            }

            if ($starosta->_name) {
                $data[self::FIELD_NAME] = $starosta->_name;
            }

            if ($starosta->_phone) {
                $data[self::FIELD_PHONE] = $starosta->_phone;
            }

            if ($starosta->_position) {
                $data[self::FIELD_POSITION] = $starosta->_position;
            }

            $data[self::FIELD_IMAGE] = get_the_post_thumbnail_url($starosta->ID);

            $data[self::FIELD_NATIONALITY] = [
                '@type' => 'Country',
                'name' => 'Slovakia',
            ];
        }

        return $data;
    }
}
