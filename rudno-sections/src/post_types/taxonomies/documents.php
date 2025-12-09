<?php

declare(strict_types=1);

use App\Enums\DocumentTypeTemplatesEnum;

function rudno_register_document_taxonomy()
{
    $labels = [
        'name'              => 'Typy dokumentov',
        'singular_name'     => 'Typ dokumentu',
        'search_items'      => 'Hladaj v typoch dokumentov',
        'all_items'         => 'Všetky typy dokumentov',
        'edit_item'         => 'Upraviť typ',
        'update_item'       => 'Aktualizovať typ',
        'add_new_item'      => 'Vytvoriť nový typ',
        'new_item_name'     => 'Názov nového typu',
        'menu_name'         => 'Typy dokumentov',
    ];
    $args = [
        'hierarchical'      => true,
        'public'            => true,
        'labels'            => $labels,
        'has_archive'       => false,
        'show_admin_column' => true,
        'meta_box_cb'       => false,
        'rewrite'           => array('slug' => 'dokumenty', 'with_front' => true)
    ];
    register_taxonomy('document-type', ['rudno-dokumenty'], $args);
}
add_action('init', 'rudno_register_document_taxonomy');

function document_type_taxonomy_edit_custom_meta_field($term) {
    $t_id = $term->term_id;
    $term_meta = get_term_meta($t_id, '_template', true);

    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="term_meta[_template]"><?php echo __('Šablóna'); ?></label></th>
        <td>
            <select name="term_meta[_template]" id="_head">
                <option value=""><?php echo __('--') ?></option>
                <?php
                foreach (DocumentTypeTemplatesEnum::cases() as $template) {
                    ?>
                    <option value="<?php echo $template->value ?>" <?php echo $term_meta === $template->value ? 'selected': ''?>><?php echo $template->getLabel(__(...))?></option>
                    <?php
                }
                ?>
            </select>
            <p class="description"><?php echo __( 'Priraďte predsedu komisie' ); ?></p>
        </td>
    </tr>
    <?php
}

add_action( 'document-type_edit_form_fields', 'document_type_taxonomy_edit_custom_meta_field', 10, 2 );

function document_types_save_taxonomy_custom_meta_field( $term_id ) {
    if ( isset( $_POST['term_meta'] ) ) {
        $t_id = $term_id;
        $term_meta = get_term_meta($t_id);
        $cat_keys = array_keys( $_POST['term_meta'] );
        foreach ( $cat_keys as $key ) {
            $term_meta[$key] = $_POST['term_meta'][$key];
        }

        // Save the option array.
        update_term_meta( "$t_id", $key, $term_meta[$key] );
    }

}
add_action( 'edited_document-type', 'document_types_save_taxonomy_custom_meta_field', 10, 2 );
