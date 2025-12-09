<?php
/**
 * Loading assets
 */

 /**
  * Loads base admin stzles
  */
add_action( 'admin_enqueue_scripts', function() {

 // Enqueues general stylesheet
 wp_enqueue_style( 'main_css_style', get_template_directory_uri() . '/rudno-sections/assets/css/admin.css');

});

/**
 * Loads the image management javascript
 */
function spost_image_enqueue($hook) {
    global $typenow;

    if( substr( $typenow, 0, 6 ) === "rudno-" || $hook === 'toplevel_page_rudno_ou_info') {
        wp_enqueue_media();
        // Registers and enqueues the required javascript.
        wp_register_script( 'meta-box-image', get_template_directory_uri() . '/rudno-sections/assets/bootstrap-tagsinput/src/bootstrap-tagsinput.js', array( 'jquery' ) );

        wp_register_script( 'meta-box-tagsinput', get_template_directory_uri() . '/rudno-sections/assets/js/doc-file-image.js', array( 'jquery' ) );

        wp_localize_script( 'meta-box-image', 'rudno_file',
            array(
                'title' => 'Vyber alebo nahraj soubor',
                'button' => 'Pouzit tenhle soubor',
            )
        );
        wp_enqueue_script( 'meta-box-image' );
        wp_enqueue_script('meta-box-tagsinput');
    }
}
add_action( 'admin_enqueue_scripts', 'spost_image_enqueue' );

/**
 * Loads javascript
 */
function rudno_scripts_eneque($hook) {
    global $typenow;
    if( substr( $typenow, 0, 6 ) === "rudno-" || $hook === 'toplevel_page_rudno_ou_info') {
        // Registers and enqueues the required javascript.
        wp_register_script( 'rudno-main', get_template_directory_uri() . '/rudno-sections/assets/js/app.js', array( 'jquery' ) );
        wp_enqueue_script( 'rudno-main' );

        wp_enqueue_script('jquery-ui-datepicker');
        wp_register_style('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
        wp_enqueue_style('jquery-ui');
    }

    if ($hook === 'toplevel_page_rudno_ou_info') {
        wp_register_script( 'rudno-ou_info', get_template_directory_uri() . '/rudno-sections/assets/js/ouinfo.js', array( 'jquery' ) );
        wp_enqueue_script( 'rudno-ou_info' );
    }
}
add_action( 'admin_enqueue_scripts', 'rudno_scripts_eneque' );

/**
 * Loads bootstrap and styles
 */
function rudno_style_enqueue($hook) {
    global $typenow;

    if( substr( $typenow, 0, 6 ) === "rudno-" || $hook === 'toplevel_page_rudno_ou_info' ) {

        // Bootstrap css
        wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/rudno-sections/assets/bootstrap-4.3.1-dist/css/bootstrap.min.css' );
        wp_enqueue_style( 'bootstrap-tagsinput', get_template_directory_uri() . '/rudno-sections/assets/bootstrap-tagsinput/src/bootstrap-tagsinput.css' );
        wp_enqueue_style( 'main_style', get_template_directory_uri() . '/rudno-sections/assets/css/main.css');

        //bootstrap javascript
        wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/rudno-sections/assets/bootstrap-4.3.1-dist/js/bootstrap.min.js', array( 'jquery' ) );
    }
}
add_action( 'admin_enqueue_scripts', 'rudno_style_enqueue' );
