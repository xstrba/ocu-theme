<?php

/**
 * Change login page
 */

/**
 * @return string
 */
function my_login_logo_url(): string
{
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

/**
 * @return string
 */
function my_login_logo_url_title(): string
{
    return 'Your Site Name and Info';
}
add_filter( 'login_headertext', 'my_login_logo_url_title' );

add_action( 'login_enqueue_scripts', function() {
    // Enqueues general stylesheet
    wp_enqueue_style( 'login_css_style', get_template_directory_uri() . '/rudno-sections/assets/css/login.css');

});
