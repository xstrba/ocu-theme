<?php

// check if yoast seo is on correct version
if (\class_exists('Yoast\WP\SEO\Config\Schema_IDs')) {
    require_once 'models/starosta.php';

    add_filter( 'wpseo_schema_graph_pieces', 'yoast_add_graph_pieces', 11, 2 );

    /**
     * Adds Schema pieces to our output.
     *
     * @param array                 $pieces  Graph pieces to output.
     * @param \WPSEO_Schema_Context $context Object with context variables.
     *
     * @return array Graph pieces to output.
     */
    function yoast_add_graph_pieces( $pieces, $context ) {
        $pieces[] = new StarostaSeo( $context );

        return $pieces;
    }

    // uncomment next line for development
    // add_filter( 'yoast_seo_development_mode', '__return_true' );
}
