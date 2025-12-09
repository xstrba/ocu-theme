<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

/**
 * Filter to add custom post types to RSS feed
 */
add_filter('request', function($query_vars) {

    $args = array(
        'public'   => true,
        '_builtin' => false,
        'exclude_from_search' => false
    );

    if (isset($query_vars['feed']))
        $query_vars['post_type'] = get_post_types($args);

    return $query_vars;
});

/**
 * Function that enables defer for enequed scripts
 * use #deferLoad at the end of src
 */
add_filter('clean_url', function($url) {
    if (!str_contains($url, '#deferLoad')) {
        return $url;
    }

    if (is_admin()) {
        return str_replace('#deferLoad', '', $url);
    }

    return str_replace('#deferLoad', '', $url) . "' defer='defer";
}, 11, 1);
