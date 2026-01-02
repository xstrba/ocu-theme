<?php

declare(strict_types=1);

namespace Plugin\OfficialBoard\MetaBoxes;

use DateTime;
use Plugin\Common\Application;
use Plugin\OfficialBoard\Registrars\OfficialBoardRegistrar;
use Plugin\OfficialBoard\Registrars\OfficialBoardTaxonomyRegistrar;

class DocumentTypeMetaBox
{
    public function register(Application $application): void
    {
        $application->registerAddMetaBoxesAction($this->add(...));
        add_action('save_post_' . OfficialBoardRegistrar::POST_TYPE, $this->save(...));
    }

    public function add(): void
    {
        add_meta_box('official-board_document_type_meta_box', __('Typ', 'ocu-theme'), $this->html(...), OfficialBoardRegistrar::POST_TYPE);
    }

    public function html($doc): void
    {
        wp_nonce_field('save_document_type', 'official-board_document_type_nonce');

        ?>
        <input type="hidden" name="official-board_updating--document_type" value="true">
        <?php

        $terms = get_terms([
            'taxonomy' => OfficialBoardTaxonomyRegistrar::TAXONOMY,
            'hide_empty' => false
        ]);

        $postTerms = get_the_terms($doc->ID, OfficialBoardTaxonomyRegistrar::TAXONOMY);
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
                       value="<?php echo $term->name ?>"
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

        ?>
        <div class="row mt-4">
            <label for="document_type_custom" class="col-12 col-md-1"><?php echo __('Nový typ', 'ocu-theme') ?></label>
            <input type="text" name="document_type_custom" id="document_type_custom" value="">
            <p class="col-12 col-md-10 offset-md-1 text-secondary p-0">Po uložení sa vytvorí nový typ a automaticky priradí</p>
        </div>
        <?php
    }

    public function save($postId): void
    {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if (! array_key_exists('official-board_updating--document_type', $_POST) || ! check_admin_referer('save_document_type', 'official-board_document_type_nonce')) {
            return;
        }

        if (array_key_exists('document_type_custom', $_POST) && $_POST['document_type_custom']) {
            wp_set_post_terms($postId, $_POST['document_type_custom'], OfficialBoardTaxonomyRegistrar::TAXONOMY);
        } else if (array_key_exists('document_type', $_POST)) {
            wp_set_post_terms($postId, $_POST['document_type'], OfficialBoardTaxonomyRegistrar::TAXONOMY);
        }
    }
}
