<?php
/*
**
**  SECTION INTRO RENDER FUNCTIONS
**    - function names: [PageSlug]_[SectionID]_intro
**    - section callbacks can accept an $args parameter, which is an array.
**        - $args have the following keys defined: title, id, callback.
**          The values are defined at the add_settings_section() function.
**
*/
function rudno_waste_collecting_intro($args) {
  ?>
    <p><?php echo "Stručne popíšte zvoz odpadu vo vašej obci. Ako často sa zváža, v ktoré dni a pod." ?></p>
  <?php
}

function rudno_waste_yard_intro($args) {
  ?>
    <p><?php echo "Vyplňte základné informácie o zbernom dvore." ?></p>
  <?php
}




/*
**
**  FIELD RENDER FUNCTIONS
**    - function names: [PageSlug]_[FieldID]_render
**    - function accept $args parameter. $args is defined at the add_settings_field() function.
**            - wordpress has magic interaction with the following keys: label_for, class.
**            - the "label_for" key value is used for the "for" attribute of the <label>.
**            - the "class" key value is used for the "class" attribute of the <tr> containing the field.
**            - you can add custom key value pairs to be used inside your callbacks.
**
*/

// Render description field
function rudno_waste_description_render($args) {

  // related option name
  $option_name = 'rudno_waste_subtitle';

  // set arguments for wp_editor
  $content = get_option($option_name);
  $editor_settings = array(
    'media_buttons' => false,
    'textarea_name' => $option_name,
    'textarea_rows' => 10,
    'tinymce' => array(
        'block_formats' => 'Heading 1=h4;Heading 2=h5',
        'toolbar1' => 'formatselect,bold,italic,link',
    ),
    'quicktags' => false
  );

  // render rich text editor
  wp_editor($content, 'rudnowastesubtitleeditor', $editor_settings);

}


// Render address field
function rudno_waste_address_render($args) {

  // related option name
  $option_name = 'rudno_waste_address';

  // get initial value
  $address = get_option($option_name);

  // render field
  ?>
    <input class="regular-text" type="text" name="<?php echo $option_name; ?>" id="<?php echo $option_name; ?>" value="<?php echo $address; ?>" placeholder="Hlavná 123/4, 972 26 Nitrianske Rudno">
  <?php

}


// Render contact field
function rudno_waste_contact_render($args) {

  // related option name
  $option_name = 'rudno_waste_contact';

  // get initial value
  $contact = get_option($option_name);

  // render field
  ?>
    <input class="regular-text" type="text" name="<?php echo $option_name; ?>" id="<?php echo $option_name; ?>" value="<?php echo $contact; ?>" placeholder="0901 123 456">
    <p class="description"><?php echo "Ideálne jedno telefónne číslo."; ?></p>
  <?php

}


// Render picture field
function rudno_waste_picture_render($args) {

  // related option name
  $option_name = 'rudno_waste_picture';

  // get initial value
  $url = get_option($option_name);

  // render field
  ?>
    <div class="rudno_waste_picture_wrapper">
      <figure class="rudno_waste_picture_preview">
        <img src="<?php echo $url ?: "https://dummyimage.com/100x100/8f8f8f/fff"; ?>" data-fillableby="media" height="100"/>
      </figure>
      <div class="rudno_waste_picture_form">
        <input class="regular-text" type="text" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" value="<?php echo $url; ?>" placeholder="Napr.: http://www.adresa.sk/obrazok.jpg" data-fillableby="media">
        <button data-show="media">Vybrať obrázok</button>
      </div>
    </div>
  <?php

}


// Render openening hours field
function rudno_waste_opened_render($args) {

  // set days
  $days = ['Po', 'Ut', 'St', 'Št', 'Pi', 'So', 'Ne'];

  // related option name
  $option_name = 'rudno_waste_opened';

  // get initial value
  $opened = get_option($option_name);

  //render fields
  ?>
  <div class="rudno_waste_opened_wrapper">
    <div class="rudno_waste_opened_day_wrapper">
      <label></label>
      <span>Doobeda (príp. celý deň)</span>
      <span>Poobede</span>
    </div>
    <?php
      foreach ($days as $key => $day) {
        ?>
          <div class="rudno_waste_opened_day_wrapper">
            <label><?php echo $day ?></label>
            <input type="text" name="<?php echo $option_name . "[{$key}][am]"; ?>" value="<?php echo $opened[$key]["am"]; ?>" />
            <input type="text" name="<?php echo $option_name . "[{$key}][pm]"; ?>" value="<?php echo $opened[$key]["pm"]; ?>" />
          </div>
        <?php
      }
    ?>
  </div>
  <?php

}



/*
**
**  FINALY RENDER PAGE
**    - function name: [PageSlug]_page_render
**
*/
function rudno_waste_page_render() {

 // check user capabilities
 if ( ! current_user_can( 'edit_posts' ) ) {
   return;
 }

 // add error/update messages

 // check if the user have submitted the settings
 // wordpress will add the "settings-updated" $_GET parameter to the url
 if ( isset( $_GET['settings-updated'] ) ) {

    // add settings saved message with the class of "updated"
    add_settings_error( 'rudno_waste_messages', 'rudno_waste_message', 'Nastavenia boli uložené.', 'updated' );

 }

 // show error/update messages
 settings_errors( 'rudno_waste_messages' );

 ?>
 <div class="wrap">
   <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
   <form action="options.php" method="post">
    <?php
       // output security fields for the registered setting
       settings_fields( 'rudno_waste' );
       // output setting sections and their fields
       do_settings_sections( 'rudno_waste' );
       // output save settings button
       submit_button( 'Uložiť nastavenia' );
    ?>
   </form>
 </div>
 <?php
}
