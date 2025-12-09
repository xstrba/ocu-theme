<?php
/*
**
** Enqueue scripts and styles
**
**
*/
add_action( 'admin_enqueue_scripts', function() {

  // Enqueues all scripts, styles, settings, and templates necessary to use all media JS APIs.
  if ( ! did_action( 'wp_enqueue_media' ) ) {
    wp_enqueue_media();
  }

  // Enqueues scripts to handle image select/upload feature
  wp_enqueue_script( 'rudno_waste_image_upload', get_template_directory_uri() . '/rudno-sections/assets/js/waste.js', array('jquery'), null, false );

  // Enqueues general stylesheet
  wp_enqueue_style( 'main_css_style', get_template_directory_uri() . '/rudno-sections/assets/css/waste.css');

});
