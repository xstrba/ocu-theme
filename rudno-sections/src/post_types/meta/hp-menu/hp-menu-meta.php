<?php


/**
 * Class Menu_Meta_Box
 */
abstract class Menu_Meta_Box
{
    const POST_TYPE =  'rudno-hp-menu';

    public static function add()
    {
        add_meta_box('menu_meta_box', 'Link', [self::class, 'html'], self::POST_TYPE);
    }

    /**
     * @param $item
     */
    public static function html($item)
    {
        wp_nonce_field('save_hp-menu', 'hp-menu_nonce');

?>
        <input type="hidden" name="hp-menu_updating" value="true">

        <div class="row mb-3">
            <label for="menu_link" class="col-12 col-md-1">Odkaz</label>
            <input type="text" class="col-12 col-md-10" name="menu_link" id="menu_link" maxlength="250"
            value="<?php echo $item->_link; ?>" required placeholder="Napr.: akcie">
        </div>

        <div class="row">
            <label for="menu_blank" class="col-12 col-md-1">Otvoriť na novej karte</label>
            <div class="col-12 col-md-1 p-0">
                <input type="checkbox" name="menu_blank" id="menu_blank" <?php if ($item->_blank) echo "checked" ?>>
            </div>
        </div>

        <div class="row">
            <label for="menu_highlighted" class="col-12 col-md-1">Zvýrazniť</label>
            <div class="col-12 col-md-1 p-0">
                <input type="checkbox" name="menu_highlighted" id="menu_highlighted" <?php if ($item->_highlighted) echo "checked" ?>>
            </div>
        </div>

        <div class="row">
            <label for="menu_icon" class="col-12 col-md-1">Ikona</label>
            <input type="text" class="col-12 col-md-10" name="menu_icon" id="menu_icon" maxlength="250"
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

        if (array_key_exists('hp-menu_updating', $_POST) && check_admin_referer('save_hp-menu', 'hp-menu_nonce')) {

            if (array_key_exists('menu_link', $_POST)) {
                update_post_meta($post_id, '_link', trim(filter_var($_POST['menu_link'], FILTER_SANITIZE_URL)));
            }

            update_post_meta($post_id, '_blank', array_key_exists('menu_blank', $_POST));
            update_post_meta($post_id, '_highlighted', array_key_exists('menu_highlighted', $_POST));

            if (array_key_exists('menu_icon', $_POST)) {
                update_post_meta($post_id, '_icon', trim(filter_var($_POST['menu_icon'], FILTER_SANITIZE_STRING)));
            }
        }
    }
}

add_action('add_meta_boxes', ['Menu_Meta_Box', 'add']);
add_action('save_post_' . Menu_Meta_Box::POST_TYPE, ['Menu_Meta_Box', 'save']);
