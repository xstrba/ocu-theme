<?php


/**
 * Class People_Meta_Box
 */
abstract class People_Meta_Box
{
    const POST_TYPE = 'rudno-people';

    public static function add()
    {
        remove_meta_box('people_positiondiv', self::POST_TYPE, 'side');
        add_meta_box( 'people_positiondiv', 'Pozície', 'post_categories_meta_box', self::POST_TYPE, 'normal', 'low', array( 'taxonomy' => 'people_position' ));

        remove_meta_box('people_comissiondiv', self::POST_TYPE, 'side');
        add_meta_box( 'people_comissiondiv', 'Komisie', 'post_categories_meta_box', self::POST_TYPE, 'normal', 'low', array( 'taxonomy' => 'people_comission' ));

        add_meta_box('people_meta_box', 'Informácie', [self::class, 'html'], self::POST_TYPE, 'advanced', 'high');

    }

    /**
     * @param $person
     */
    public static function html($person)
    {
        wp_nonce_field('save_name', 'name_nonce');

?>
        <input type="hidden" name="person_updating" value="true">

        <div class="row input-group mb-3">
            <label class="col-12 col-md-1" for="person_name">Meno</label>
            <input type="text" class="col-12 col-md-11" name="person_name" id="person_name" maxlength="250"
            value="<?php echo get_post_meta($person->ID, '_name', true); ?>">
        </div>

        <div class="row input-group mb-3">
            <label class="col-12 col-md-1" for="person_position">Funkcia</label>
            <input type="text" class="col-12 col-md-11" name="person_position" id="person_position" maxlength="250"
            value="<?php echo $person->_position ?>" placeholder="Napr.: Starosta alebo Poslanec">
        </div>


        <div class="row input-group mb-3">
            <label class="col-12 col-md-1" for="person_email">E-mail</label>
            <input type="email" class="col-12 col-md-11" name="person_email" id="person_email" maxlength="250"
            pattern="[^@]+@[^@]+\..+" value="<?php echo $person->_email ?>" placeholder="Napr.: príklad@nitrianskerudno.sk">
        </div>

        <div class="row input-group mb-3">
            <label class="col-12 col-md-1" for="person_phone">Telefón</label>
            <input type="text" class="col-12 col-md-11" name="person_phone" id="person_phone" maxlength="30"
            pattern="[+-#*\/0-9]+" value="<?php echo $person->_phone ?>" placeholder="Napr.: +421 XXX XXX XXX">
            <p class="offset-md-1 col-11 p-0">
                Viacero tel. čísel oddeľte čiarkou.
            </p>
        </div>

        <div class="row input-group mb-3">
            <label for="person_description" class="col-md-1">Detailný popis</label>
            <textarea name="person_description" id="person_description" class="col-6" cols="30" rows="10" placeholder="Zadajte popis toho, čo daná osoba vykonáva ..."><?php
                echo $person->_description
            ?></textarea>
        </div>
<?php
    }

    /**
     * @param $post_id
     */
    public static function save($post_id)
    {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if (array_key_exists('person_updating', $_POST) && check_admin_referer('save_name', 'name_nonce')) {
            if (array_key_exists('person_name', $_POST)) {
                $name = trim(sanitize_text_field($_POST['person_name']));

                $newPost = array(
                    'ID' => $post_id,
                    'post_title' => $name,
                    'post_name' => $name
                );

                // remove action so id doesnt loop
                remove_action('save_post_' . People_Meta_Box::POST_TYPE, ['People_Meta_Box', 'save']);

                // set title of a post
                wp_update_post($newPost);

                // add action again
                add_action('save_post_' . People_Meta_Box::POST_TYPE, ['People_Meta_Box', 'save']);

                update_post_meta($post_id, '_name', $name);
            }

            if (array_key_exists('person_email', $_POST)) {
                update_post_meta($post_id, '_email', trim(filter_var($_POST['person_email'], FILTER_SANITIZE_EMAIL)));
            }

            if (array_key_exists('person_phone', $_POST)) {
                update_post_meta($post_id, '_phone', trim(filter_var($_POST['person_phone'], FILTER_SANITIZE_STRING)));
            }

            if (array_key_exists('person_position', $_POST)) {
                update_post_meta($post_id, '_position', trim(filter_var($_POST['person_position'], FILTER_SANITIZE_STRING)));
            }

            if (array_key_exists('person_description', $_POST)) {
                update_post_meta($post_id, '_description', trim(filter_var($_POST['person_description'], FILTER_SANITIZE_STRING)));
            }
        }
    }
}

add_action('add_meta_boxes', ['People_Meta_Box', 'add']);
add_action('save_post_' . People_Meta_Box::POST_TYPE, ['People_Meta_Box', 'save']);
