<?php
/**
 * register custom post type adn styles and scripts
 */

/**
 * @var array<array-key, class-string<\Plugin\Common\Parents\AbstractServiceProvider>> $providers
 */

use Plugin\PostTypes\Repositories\PostTypesRepository;

$providers = [
    \Plugin\PostTypes\Providers\PostTypesServiceProvider::class,
    \Plugin\OfficialBoard\Providers\OfficialBoardServiceProvider::class,
];

//document-post
include('assets.php');

//register settings
include('src/settings/ouinfo.php');
include('src/settings/waste/waste.php');

// register post types
include('src/post_types/main-news.php');
include('src/post_types/news.php');
include('src/post_types/events.php');
include('src/post_types/documents.php');
include('src/post_types/seating.php');
include('src/post_types/people.php');
include('src/post_types/homepage-menu.php');
include('src/post_types/tutorials.php');
include('src/post_types/useful-links.php');

$app = \Plugin\Common\Application::getInstance();

foreach ($providers as $provider) {
    $app->withServiceProvider(new $provider());
}


/*********************
* remove admin menu items
**********************/
function remove_menus(){
  remove_menu_page( 'edit.php' );                   //Posts
  remove_menu_page( 'edit-comments.php' );          //Comments
}
add_action( 'admin_menu', 'remove_menus' );


/*********************
* add admin menu seperator
**********************/
function add_admin_menu_separator( $position ) {

  	global $menu;
  	$menu[ $position ] = array(
  		0	=>	'',
  		1	=>	'read',
  		2	=>	'separator' . $position,
  		3	=>	'',
  		4	=>	'wp-menu-separator'
  	);

}
add_action( 'admin_init', 'add_admin_menu_separator' );

function set_admin_menu_separator() {
	do_action( 'admin_init', 25 );
  do_action( 'admin_init', 39 );
}
add_action( 'admin_menu', 'set_admin_menu_separator' );


/**
 * add custom post types to main page
 */
function rudno_add_custom_posts_to_main($query)
{
    if (is_home() && $query->is_main_query()) {
        $query->set('posts_per_page', 3);
    }
    return $query;
}
add_action('pre_get_posts', 'rudno_add_custom_posts_to_main');

/**
 * Remove yoast seo from custom post types
 */
function my_remove_wp_seo_meta_box() {
    if ( function_exists('yoast_breadcrumb') ) {
        $postTypes = get_post_types();

        foreach ($postTypes as $postType) {
            if (str_starts_with($postType, 'rudno-')) {
                remove_meta_box('wpcode-metabox-snippets', $postType, 'normal');
            }
        }

        foreach (\Plugin\Common\Application::getInstance()->getServiceContainer()->make(PostTypesRepository::class)
            ->getAll() as $postType => $_) {
            remove_meta_box('wpseo_meta', $postType, 'normal');
            remove_meta_box('wpcode-metabox-snippets', $postType, 'normal');
        }
    }
}
add_action('add_meta_boxes', 'my_remove_wp_seo_meta_box', 1000);

/**
 * Hide meta box on screen
 */
function minify_my_metabox( $classes ) {
    $classes[] = 'closed';

    return $classes;
}


function add_query_vars_filter( $vars ){
    $vars[] = 'filter_year';
    return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );

$app->initCb(static function () {
    add_rewrite_tag('%year%', '([0-9]+)');
});

$app->register();


/**
 * Style login page
 */
require_once __DIR__ . '/admin_login.php';
