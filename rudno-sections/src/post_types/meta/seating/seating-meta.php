<?php


/**
 * Class Seating_Meta_Box
 */
abstract class Seating_Meta_Box
{
    const POST_TYPE = 'rudno-seating';

    public static function add()
    {
        add_meta_box('seating_meta_box', 'Súbor', [self::class, 'html'], self::POST_TYPE);
    }

    /**
     * @param $doc
     */
    public static function html($doc)
    {
        $fileMeta = $doc->_file;

        if ($fileMeta) {
            $fileUrl = get_post($fileMeta)->guid;
            $url = explode('/uploads/', $fileUrl)[1];
        }

        wp_nonce_field('save_seating', 'rudno_seating_nonce');
        ?>

        <input type="hidden" name="seating_updating" value="true">

        <div class="row input-group mb-3">
            <label for="seating_date" class="col-12 col-md-1">Dátum</label>
            <input type="date" name="seating_date" id="seating_date" value="<?php echo $doc->_date ?>" required>
        </div>

        <div class="row input-group mb-3">
            <label for="seating_time" class="col-12 col-md-1">Čas</label>
            <input type="text" class="col-12 col-md-11" name="seating_time" id="seating_time" value="<?php echo $doc->_time ?>" required
                placeholder="napr. 18:00"
            >
        </div>

        <div class="row input-group mb-3">
            <label for="seating_place" class="col-12 col-md-1">Miesto</label>
            <input type="text" class="col-12 col-md-11" name="seating_place" id="seating_place" value="<?php echo $doc->_place ?: 'Kultúrny dom' ?>" required placeholder="Napr.: Kultúrny dom">
        </div>

        <div class="row mb-3" id="spost_file_area">
            <label class="col-12 col-md-1" for="spost_file">Súbor</label>
            <button class="mr-1" type="button" id="spost_file_button">Vybrať súbor</button>
            <input type="hidden" name="spost_file" id="spost_file" value="<?php if ( isset ( $fileMeta ) ) echo $fileMeta; ?>">
            <input type="text" id="spost_file_txt" class="col-md-4" value="<?php if ( isset ( $url ) ) echo $url; ?>" readonly aria-labeledby="spost_file_button" pattern=".*\.pdf" required>
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

        if (\array_key_exists('seating_updating', $_POST) && check_admin_referer('save_seating', 'rudno_seating_nonce')) {
            if (\array_key_exists('spost_file', $_POST)) {
                update_post_meta($post_id, '_file', $_POST['spost_file']);
            }

            if (\array_key_exists('seating_time', $_POST)) {
                update_post_meta($post_id, '_time', filter_var($_POST['seating_time'], FILTER_SANITIZE_STRING));
            }

            if (\array_key_exists('seating_date', $_POST)) {
                update_post_meta($post_id, '_date', $_POST['seating_date']);
            }

            if (\array_key_exists('seating_place', $_POST)) {
                update_post_meta($post_id, '_place', filter_var($_POST['seating_place'], FILTER_SANITIZE_STRING));
            }
        }
    }
}

add_action('add_meta_boxes', ['Seating_Meta_Box', 'add']);
add_action('save_post_' . Seating_Meta_Box::POST_TYPE, ['Seating_Meta_Box', 'save']);
