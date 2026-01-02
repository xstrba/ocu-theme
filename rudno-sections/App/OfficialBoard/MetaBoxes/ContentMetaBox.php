<?php

declare(strict_types=1);

namespace Plugin\OfficialBoard\MetaBoxes;

use DateTime;
use Plugin\Common\Application;
use Plugin\OfficialBoard\Registrars\OfficialBoardRegistrar;

class ContentMetaBox
{
    public function register(Application $application): void
    {
        $application->registerAddMetaBoxesAction($this->add(...));
        add_action('save_post_' . OfficialBoardRegistrar::POST_TYPE, $this->save(...));
    }

    public function add(): void
    {
        add_meta_box('official-board_content_meta_box', __('Obsah', 'ocu-theme'), $this->html(...), OfficialBoardRegistrar::POST_TYPE);
    }

    public function html($doc): void
    {
        $fileMeta = get_post_meta($doc->ID, '_file')[0] ?? [];
        $urlString = '';
        $fileMetaString = implode(',', $fileMeta);

        foreach ($fileMeta as $fileId) {
            if ($urlString !== '') {
                $urlString .= ', ';
            }

            $post = get_post($fileId);

            $urlString .= \array_last(explode('/', $post->guid));
        }

        wp_nonce_field('save_content', 'official-board_content_nonce');

        try {
            $datePublished = new \DateTime($doc->_date_publish);
        } catch (\DateMalformedStringException) {
            $datePublished = new \DateTime();
        }

        try {
            $dateUnpublished = new \DateTime($doc->_date_unpublish);
        } catch (\DateMalformedStringException) {
            $dateUnpublished = new \DateTime();
        }
        ?>
        <input type="hidden" name="official-board_updating" value="true">

        <div class="row" id="spost_file_area" data-multiple="true">
            <label class="col-md-1" for="spost_file">Súbor</label>
            <button class="mr-1" type="button" id="spost_file_button">Vybrať súbory</button>
            <input type="hidden" name="spost_file" id="spost_file" value="<?php if ($fileMetaString) echo $fileMetaString; ?>">
            <input type="text" name="file_name" id="spost_file_txt" class="col-md-4" value="<?php if ($urlString) echo $urlString; ?>" aria-labeledby="spost_file_button" required data-readonly>
        </div>
        <p class="col-12 col-md-10 mb-3 offset-md-1 text-secondary p-0">Vyberte súbory, ktoré reprezentujú tento dokument. Pokiaľ chcete vložiť niekoľko obrázkov do jedného pdf súboru môžete použiť aplikáciu https://smallpdf.com/jpg-to-pdf</p>


        <div class="row">
            <label for="document_date_publish" class="col-12 col-md-1">Dátum vyvesenia</label>
            <input type="date" name="document_date_publish" id="document_date_publish" value="<?php echo $datePublished->format('Y-m-d') ?>" required>
            <input type="time" name="document_time_publish" id="document_time_publish" value="<?php echo $datePublished->format('H:i') ?>" required>
            <p class="col-12 col-md-10 offset-md-1 text-secondary p-0">Dátum a čas kedy bude dokument vyvesený na úradnej tabuli.</p>
        </div>

        <div class="row">
            <label for="document_date_unpublish" class="col-12 col-md-1">Dátum zvesenia</label>
            <input type="date" name="document_date_unpublish" id="document_date_unpublish" value="<?php echo $dateUnpublished->format('Y-m-d') ?>" required>
            <input type="time" name="document_time_unpublish" id="document_time_unpublish" value="<?php echo $dateUnpublished->format('H:i') ?>" required>
            <p class="col-12 col-md-10 offset-md-1 text-secondary p-0">Dátum a čas kedy bude dokument zvesený z úradnej tabule.</p>
        </div>
        <?php
    }

    public function save($postId): void
    {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if (array_key_exists('official-board_updating', $_POST) && check_admin_referer('save_content', 'official-board_content_nonce')) {

            if (array_key_exists('spost_file', $_POST) && ! empty($_POST["spost_file"])) {
                $items = \explode(',', $_POST["spost_file"]);
                $mapped = [];

                foreach ($items as $item) {
                    if (\is_numeric($item)) {
                        $mapped[] = (int) $item;
                    }
                }

                update_post_meta($postId, '_file', $mapped);
            }

            // Vyvesenie
            if (! empty($_POST['document_date_publish']) && ! empty($_POST['document_time_publish'])) {
                $publish = sprintf(
                    '%s %s:00',
                    sanitize_text_field($_POST['document_date_publish']),
                    sanitize_text_field($_POST['document_time_publish'])
                );

                update_post_meta($postId, '_date_publish', $publish);
            }

            // Zvesenie
            if (! empty($_POST['document_date_unpublish']) && ! empty($_POST['document_time_unpublish'])) {
                $unpublish = sprintf(
                    '%s %s:00',
                    sanitize_text_field($_POST['document_date_unpublish']),
                    sanitize_text_field($_POST['document_time_unpublish'])
                );

                update_post_meta($postId, '_date_unpublish', $unpublish);
            }
        }
    }
}
