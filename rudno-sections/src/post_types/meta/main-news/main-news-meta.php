<?php


/**
 * Class Main_News_Meta_Box
 */
abstract class Main_News_Meta_Box
{
    const POST_TYPE =  'rudno-warnings';

    public static function add()
    {
        add_meta_box('main_news_meta_box', 'Obsah', [self::class, 'html'], self::POST_TYPE);
    }

    public static function html($doc)
    {
        $fileMeta = $doc->_file;

        if ($fileMeta) {
            $fileUrl = get_post($fileMeta)->guid;
            $url = explode('/uploads/', $fileUrl)[1];
        }

        wp_nonce_field('save_main_news', 'rudno-warnings_nonce');
        ?>

        <input type="hidden" name="main_news_updating" value="true">

        <div class="row input-group mb-3">
            <label for="post_content" class="col-12 col-md-1">Text</label>
            <textarea class="col-12 col-md-11" name="post_content" id="post_content" maxlength="1000" rows="6"><?php
                echo $doc->post_content;
            ?></textarea>
        </div>

        <div class="row mb-3">

            <label for="newType" class="col-md-1">Druh obsahu</label>
            <div class="form-check form-check-inline" id="newType">
                <input class="form-check-input" type="radio" name="main_news_type" id="radios1" value="file" <?php echo $doc->_type === 'file' ? 'checked' : '' ?>>
                <label class="form-check-label" for="radios1">
                    Súbor
                </label>
            </div>

            <div class="form-check form-check-inline" id="newType">
                <input class="form-check-input" type="radio" name="main_news_type" id="radios2" value="link" <?php echo $doc->_type === 'link' ? 'checked' : '' ?>>
                <label class="form-check-label" for="radios2">
                    Odkaz na stránku
                </label>
            </div>

            <div class="form-check form-check-inline" id="newType">
                <input class="form-check-input" type="radio" name="main_news_type" id="radios3" value="false" <?php echo $doc->_type === 'false' ? 'checked' : '' ?>>
                <label class="form-check-label" for="radios3">
                    Oznam
                </label>
            </div>
            <p class="offset-md-1 col-11 p-0">
                V prípade, že zadávate súbor vyberte možnosť súbor, v prípade, že odkaz na stráku vyberte možnosť odkaz na stránku. Možnosť "Oznam" môžete vybrať v prípade, že je táto novinka iba oznam.
            </p>
        </div>

        <div class="row mb-3" id="spost_file_area">
            <label class="col-md-1" for="spost_file">Súbor</label>
            <button class="mr-1" type="button" id="spost_file_button">Vybrať súbor</button>
            <input type="hidden" name="spost_file" id="spost_file" value="<?php if ( isset ( $fileMeta ) ) echo $fileMeta; ?>">
            <input type="text" id="spost_file_txt" class="col-md-4" value="<?php if ( isset ( $url ) ) echo $url; ?>" readonly aria-labeledby="spost_file_button" pattern=".*\.pdf" required>
        </div>

        <div class="row input-group mb-3">
            <label class="col-12 col-md-1" for="main_news_link">Odkaz na stránku</label>
            <input type="text" class="col-12 col-md-11" name="main_news_link" id="main_news_link" maxlength="250"
            pattern="[+-#*\/0-9]+" value="<?php echo $doc->_link ?>" placeholder="Napr.: https://nitrianskerudno.sk">
        </div>

        <div class="row input-group mb-3">
            <label class="col-1" for="main_news_blank">Otvoriť na novej karte</label>
            <div class="col-11">
                <input type="checkbox" name="main_news_blank" id="main_news_blank"
                <?php if ($doc->_blank):?> checked <?php endif ?>>
            </div>
        </div>

        <div class="row input-group mb-3">
            <label class="col-12 col-md-1" for="main_news_pages">Stránky</label>
            <input type="text" class="col-12 col-md-11" data-role="tagsinput" name="main_news_pages" id="main_news_pages" value="<?php echo $doc->_pages ?>"/>
            <p class="offset-md-1 col-11 p-0">
                Vložte zoznam stránok oddelených čiarkou. Pokiaľ chcete zahrnúť všetky stránky s predponou použite "*", napr.: "dokumenty*".
                Na danej stránke sa zobrazí posledná novinka pre túto stránku.
            </p>
        </div>
        <?php
    }

    public static function save($post_id)
    {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if (array_key_exists('main_news_updating', $_POST) && check_admin_referer('save_main_news', 'rudno-warnings_nonce')) {
            if (array_key_exists('spost_file', $_POST)) {
                update_post_meta($post_id, '_file', $_POST['spost_file']);
            }

            if (array_key_exists('main_news_link', $_POST)) {
                update_post_meta($post_id, '_link', filter_var($_POST['main_news_link'], FILTER_SANITIZE_STRING));
            }

            update_post_meta($post_id, '_blank', array_key_exists('main_news_blank', $_POST));

            if (array_key_exists('main_news_type', $_POST)) {
                update_post_meta($post_id, '_type', filter_var($_POST['main_news_type'], FILTER_SANITIZE_STRING));
            }

            if (array_key_exists('main_news_pages', $_POST)) {
                update_post_meta($post_id, '_pages', filter_var($_POST['main_news_pages'], FILTER_SANITIZE_STRING));
            }
        }
    }
}

add_action('add_meta_boxes', ['Main_News_Meta_Box', 'add']);
add_action('save_post_' . Main_News_Meta_Box::POST_TYPE, ['Main_News_Meta_Box', 'save']);
