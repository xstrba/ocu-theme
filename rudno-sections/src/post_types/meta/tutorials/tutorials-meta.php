<?php


/**
 * Class Tutorials_Meta_Box
 */
abstract class Tutorials_Meta_Box
{
    const POST_TYPE = 'rudno-tutorials';

    public static function add()
    {
        remove_meta_box('tutorial-categorydiv', self::POST_TYPE, 'side');
        add_meta_box(
            'tutorial-categorydiv',
            'Kategória',
            'post_categories_meta_box',
            self::POST_TYPE, 'normal',
            'low',
            array( 'taxonomy' => 'tutorial-category' )
        );

    }

    /**
     * @param $tutorial
     */
    public static function html($tutorial)
    {
        wp_nonce_field('save_tutorials', 'tutorials_nonce');

?>
        <input type="hidden" name="tutorial_updating" value="true">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="clickable btn btn-outline-primary" for="person_name">Meno</label>
            </div>
            <input type="text" class="form-control" name="person_name" id="person_name" maxlength="250"
            value="<?php echo get_post_meta($tutorial->ID, '_name', true); ?>">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="clickable btn btn-outline-primary" for="person_position">Funkcia</label>
            </div>
            <input type="text" class="form-control" name="person_position" id="person_position" maxlength="250"
            value="<?php echo $tutorial->_position ?>">
        </div>


        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="clickable btn btn-outline-primary" for="person_email">E-mail</label>
            </div>
            <input type="email" class="form-control" name="person_email" id="person_email" maxlength="250"
            pattern="[^@]+@[^@]+\..+" value="<?php echo $tutorial->_email ?>" required>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="clickable btn btn-outline-primary" for="person_phone">Telefón</label>
            </div>
            <input type="text" class="form-control" name="person_phone" id="person_phone" maxlength="30"
            pattern="[+-#*\/0-9]+" value="<?php echo $tutorial->_phone ?>">
        </div>

        <div class="input-group mb-3">
            <textarea name="person_description" id="person_description" class="form-control" cols="30" rows="10" placeholder="Zadajte popis toho, čo daná osoba vykonáva ..."><?php
                echo $tutorial->_description
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

        if (\array_key_exists('tutorial_updating', $_POST) && check_admin_referer('save_tutorials', 'tutorials_nonce')) {
            if (\array_key_exists('person_name', $_POST)) {
                $name = trim(sanitize_text_field($_POST['person_name']));

                $newPost = array(
                    'ID' => $post_id,
                    'post_title' => $name,
                    'post_name' => $name
                );

                // remove action so id doesnt loop
                remove_action('post_updated', ['People_Meta_Box', 'save']);

                // set title of a post
                wp_update_post($newPost);

                // add action again
                add_action('post_updated', ['People_Meta_Box', 'save']);

                update_post_meta($post_id, '_name', $name);
            }

            if (\array_key_exists('person_email', $_POST)) {
                update_post_meta($post_id, '_email', trim(filter_var($_POST['person_email'], FILTER_SANITIZE_EMAIL)));
            }

            if (\array_key_exists('person_phone', $_POST)) {
                update_post_meta($post_id, '_phone', trim(filter_var($_POST['person_phone'], FILTER_SANITIZE_STRING)));
            }

            if (\array_key_exists('person_position', $_POST)) {
                update_post_meta($post_id, '_position', trim(filter_var($_POST['person_position'], FILTER_SANITIZE_STRING)));
            }

            if (\array_key_exists('person_description', $_POST)) {
                update_post_meta($post_id, '_description', trim(filter_var($_POST['person_description'], FILTER_SANITIZE_STRING)));
            }
        }
    }
}

add_action('add_meta_boxes', ['Tutorials_Meta_Box', 'add']);
add_action('save_post_' . Tutorials_Meta_Box::POST_TYPE, ['Tutorials_Meta_Box', 'save']);
