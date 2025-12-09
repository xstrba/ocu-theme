<?php


/**
 * Class Menu_Meta_Box
 */
abstract class Useful_Links_Meta_Box
{
    const POST_TYPE =  'rudno-useful-links';

    public static function add()
    {
        add_meta_box('useful_link_meta_box', 'Link', [self::class, 'html'], self::POST_TYPE);
    }

    /**
     * @param $item
     */
    public static function html($item)
    {
        wp_nonce_field('save_useful-link', 'useful-link_nonce');

?>
        <input type="hidden" name="useful-link_updating" value="true">

        <div class="row mb-3">
            <label for="link" class="col-12 col-md-1">Odkaz</label>
            <input type="text" class="col-12 col-md-10" name="link" id="link" maxlength="250"
            value="<?php echo $item->_link; ?>" required placeholder="Napr.: akcie">
        </div>

        <div class="row">
            <label for="icon" class="col-12 col-md-1">Ikona</label>
            <input type="text" class="col-12 col-md-10" name="icon" id="icon" maxlength="250"
            value="<?php echo $item->_icon; ?>" placeholder="Napr.: ion:document-text-outline" required>
            <p class="col-12 col-md-10 offset-md-1 text-secondary p-0">Všetky ikony a ich kódy sú na webe https://ionicons.com/</p>
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

        if (array_key_exists('useful-link_updating', $_POST) && check_admin_referer('save_useful-link', 'useful-link_nonce')) {

            if (array_key_exists('link', $_POST)) {
                update_post_meta($post_id, '_link', trim(filter_var($_POST['link'], FILTER_SANITIZE_URL)));
            }

            if (array_key_exists('icon', $_POST)) {
                update_post_meta($post_id, '_icon', trim(filter_var($_POST['icon'], FILTER_SANITIZE_STRING)));
            }
        }
    }
}

add_action('add_meta_boxes', ['Useful_Links_Meta_Box', 'add']);
add_action('save_post_' . Useful_Links_Meta_Box::POST_TYPE, ['Useful_Links_Meta_Box', 'save']);
