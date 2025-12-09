<?php
/*
**
** Initialize Setting Page, Options, Sections and Fields
**  - holds config variables, registers settings and adds page to admin menu
**
**
*/


/*
**
**  Page parametrs
**  - title:
**      (string) (Required) The text to be displayed in the title tags of the page when the menu is selected.
**  - slug:
**      (string) (Required) The slug name to refer to this page by. Should be unique for this menu page
**      and only include lowercase alphanumeric, dashes, and underscores characters
**  - capability:
**      (string) (Required) The capability/user permissions required for this page to be displayed to the user.
**  - menu->title:
**      (string) (Required) The text to be used for the menu.
**  - menu->icon:
**      (string) (Optional) Pass the name of a Dashicons helper class to use a font icon, e.g. 'dashicons-chart-pie'.
**  - menu->position:
**      (int) (Optional) The position in the menu order this item should appear.
**
**
*/
$page = [
  'title'       => 'Zber a zvoz odpadu',
  'slug'        => 'rudno_waste',
  'capability'  => 'edit_posts',
  'menu'        => [

    'title'     => 'Zber odpadu',
    'icon'      => 'dashicons-trash',
    'position'  => 44

  ]
];


/*
**
** Option list
**  - array of options' names (string)
**
**
*/
$options = [
  'subtitle',
  'address',
  'contact',
  'picture',
  'opened',
  // + add option
];



/*
**
** Sections list
**  - array of sections (array) containing related fields
**
**
*/
$sections = [

  'Zvoz odpadu' => [                                  // Section title
        'id'        => 'collecting',            // HTML wrapper id
        'fields'    => [                              // Children fields

              'Popis'   => [                          // Field Title/Label
                    'id'    => 'description',         // HTML id
                    'args'  => []                     // Additional arguments
              ],

              // + add field

        ]
  ],

  'Zberný dvor' => [

        'id'        => 'yard',
        'fields'    => [

            'Adresa'    => [
                  'id'    => 'address',
                  'args'  => []
            ],

            'Kontakt'   => [
                  'id'    => 'contact',
                  'args'  => []
            ],

            'Fotka'     => [
                  'id'    => 'picture',
                  'args'  => [
                    'class'   => 'rudno_waste_picture'
                  ]
            ],

            'Otvorené'  => [
                  'id'    => 'opened',
                  'args'  => [
                    'class'   => 'rudno_waste_opened'
                  ]

            ],

            // + add field

        ]

  ],

  // + add section
];

/*
**  End Config
*/





/*
**
** Setting page and options initialization
**   - goes through $option and $section configs and register/add options, sections and fields
**
** DO NOT CHANGE, unless you know what you're doing
**
*/
add_action( 'admin_init', function() use ($page, $options, $sections) {

  // Let's register options we want to save
  foreach ($options as $option) {

    // init arguments
    $option_name = $page['slug'] . '_' . $option;

    // register
    register_setting($page['slug'], $option_name);

  }

  // Let's add some sections
  foreach ($sections as $title => $section) {

    // init arguments
    $section_id = $page['slug'] . '_' . $section['id'];
    $section_title = $title;
    $section_intro_fc = $section_id . '_intro';
    $section_page = $page['slug'];

    // add section
    add_settings_section($section_id, $section_title, $section_intro_fc, $section_page);

    // Let's add some fields
    foreach ($section['fields'] as $titleKey => $field) {

      // init arguments
      $field_id = $page['slug'] . '_' . $field['id'];
      $field_title = $titleKey;
      $field_render_fc = $field_id . '_render';
      $field_page = $page['slug'];
      $field_section = $section_id;
      $field_args = $field['args'];

      // add field
      add_settings_field($field_id, $field_title, $field_render_fc, $field_page, $field_section, $field_args);

    }

  }
});


/*
**
**  REGISTER TOP LEVEL MENU ITEM
**
**
*/
add_action( 'admin_menu', function() use ($page) {

  add_menu_page($page['title'], $page['menu']['title'], $page['capability'], $page['slug'], $page['slug'] . '_page_render', $page['menu']['icon'], $page['menu']['position']);

});

add_filter('option_page_capability_' . $page['slug'], function($_) use ($page) {
    return $page['capability'];
});
