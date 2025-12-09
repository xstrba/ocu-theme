<?php
/**
 * File with meta boxes for documents
 */

/**
 * Class Content_Meta_Box
 */
abstract class Content_Meta_Box
{
    const POST_TYPE = 'rudno-dokumenty';

    public static function add()
    {
        add_meta_box('content_meta_box', 'Obsah', [self::class, 'html'], self::POST_TYPE);
        add_meta_box('type_meta_box', 'Typ', [self::class, 'htmlType'], self::POST_TYPE);
    }

    public static function html($doc)
    {
        $fileMeta = $doc->_file;

        if ($fileMeta) {
            $fileUrl = get_post($fileMeta)->guid;
            $url = explode('/uploads/', $fileUrl)[1];
        }

        wp_nonce_field('save_content', 'document_content_nonce');
        ?>
        <input type="hidden" name="document_updating" value="true">

        <div class="row mb-3">
            <label for="document_date" class="col-12 col-md-1">Dátum</label>
            <input type="date" name="document_date" id="document_date" value="<?php echo $doc->_date ?: date('Y-m-d') ?>" required>
            <p class="col-12 col-md-10 offset-md-1 text-secondary p-0">Dátum kedy bol dokument zverejnený na webe. Vo väčšine prípadov netreba túto položku meniť.</p>
        </div>

        <div class="row" id="spost_file_area">
            <label class="col-md-1" for="spost_file">Súbor</label>
            <button class="mr-1" type="button" id="spost_file_button">Vybrať súbor</button>
            <input type="hidden" name="spost_file" id="spost_file" value="<?php if ( isset ( $fileMeta ) ) echo $fileMeta; ?>">
            <input type="text" name="file_name" id="spost_file_txt" class="col-md-4" value="<?php if ( isset ( $url ) ) echo $url; ?>" aria-labeledby="spost_file_button" required data-readonly>
        </div>
        <p class="col-12 col-md-10 offset-md-1 text-secondary p-0">Vyberte jeden súbor, ktorý reprezentuje tento dokument. Pokiaľ chcete vložiť niekoľko obrázkov do jedného pdf súboru môžete použiť aplikáciu https://smallpdf.com/jpg-to-pdf</p>
        <?php
    }

    public static function save($post_id)
    {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if (array_key_exists('document_updating', $_POST) && check_admin_referer('save_content', 'document_content_nonce')) {

            if (array_key_exists('spost_file', $_POST) && ! empty($_POST["spost_file"])) {
                update_post_meta($post_id, '_file', $_POST['spost_file']);
            }

            if (array_key_exists('document_date', $_POST)) {
                update_post_meta($post_id, '_date', $_POST['document_date']);
            }

            if (array_key_exists('document_type', $_POST)) {
                wp_set_post_terms($post_id, (int) $_POST['document_type'], 'document-type');
            }
        }
    }

    public static function htmlType($post_id)
    {
        $terms = get_terms([
            'taxonomy' => 'document-type',
            'hide_empty' => false
        ]);

        $postTerms = get_the_terms($post_id, 'document-type');
        $postTerm = $postTerms ? $postTerms[0] : null;

        foreach ($terms as $key => $term) {
            ?>
            <div class="<?php
                            if ((isset($_GET['document_type']) && $term->term_id !== (int) $_GET['document_type'])) {
                                echo 'd-none';
                            }
                        ?> mb-2"
            >
                <input type="radio"
                        name="document_type"
                        id="document_type[<?php echo $key ?>]"
                        value="<?php echo $term->term_id ?>"
                        <?php
                            if ($term->term_id === $postTerm?->term_id ||
                                (isset($_GET['document_type']) && $term->term_id === (int) $_GET['document_type'])
                            ) {
                                echo "checked";
                            }
                        ?>
                >
                <label for="document_type[<?php echo $key; ?>]" class="mb-0 vertical-top clickable"><?php echo $term->name ?></label>
            </div>
            <?php
        }
    }
}

add_action('add_meta_boxes', ['Content_Meta_Box', 'add']);
add_action('save_post_' . Content_Meta_Box::POST_TYPE, ['Content_Meta_Box', 'save']);
