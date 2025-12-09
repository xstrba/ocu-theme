<?php

function rudno_register_people_position_taxonomy()
{
    $labels = [
        'name'              => 'Pozície',
        'singular_name'     => 'Pozícia',
        'search_items'      => 'Nájdi pozíciu',
        'all_items'         => 'Všetky pozície',
        'edit_item'         => 'Upraviť pozíciu',
        'update_item'       => 'Aktualizovať pozíciu',
        'add_new_item'      => 'Vytvoriť novú pozíciu',
        'new_item_name'     => 'Názov novej pozície',
        'menu_name'         => 'Pozície',
    ];
    $args = [
        'hierarchical'      => true,
        'public'    => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'has_archive'       => false,
        'show_admin_column' => true,
        'publicly_queryable' => false,
        'query_var'         => true    ];
    register_taxonomy('people_position', ['rudno-people'], $args);
}
add_action('init', 'rudno_register_people_position_taxonomy');

function rudno_register_people_comission_taxonomy()
{
    $labels = [
        'name'              => 'Komisie',
        'singular_name'     => 'Komisia',
        'search_items'      => 'Nájdi komisiu',
        'all_items'         => 'Všetky Komisie',
        'edit_item'         => 'Upraviť komisiu',
        'update_item'       => 'Aktualizovať komisiu',
        'add_new_item'      => 'Vytvoriť novú komisiu',
        'new_item_name'     => 'Názov novej Komisie',
        'menu_name'         => 'Komisie',
    ];
    $args = [
        'hierarchical'       => true,
        'labels'             => $labels,
        'show_ui'            => true,
        'show_admin_column'  => true,
        'publicly_queryable' => false,
        'has_archive'        => false
    ];
    register_taxonomy('people_comission', ['rudno-people'], $args);
}
add_action('init', 'rudno_register_people_comission_taxonomy');


function comission_taxonomy_edit_custom_meta_field($term) {
    $people = get_posts([
        'numberposts' => -1,
        'post_type' => 'rudno-people',
        'tax_query' => [
            [
                'taxonomy' => 'people_comission',
                'field' => 'name',
                'terms' => $term->name
            ],
        ]
    ]);

    $t_id = $term->term_id;
    $term_meta = get_term_meta($t_id, '_head', true);

?>
    <tr class="form-field">
    <th scope="row" valign="top"><label for="term_meta[class_term_meta]"><?php echo __('Predseda'); ?></label></th>
        <td>
            <select name="term_meta[_head]" id="_head">
            <option value=""><?php echo __('--') ?></option>
<?php
            foreach ($people as $person) {
?>
                <option value="<?php echo $person->ID ?>" <?php echo $term_meta == $person->ID ? 'selected': ''?>><?php echo $person->_name?></option>
<?php
            }
?>
            </select>
            <p class="description"><?php echo __( 'Priraďte predsedu komisie' ); ?></p>
        </td>
    </tr>
<?php
}

add_action( 'people_comission_edit_form_fields', 'comission_taxonomy_edit_custom_meta_field', 10, 2 );

function comissions_save_taxonomy_custom_meta_field( $term_id ) {
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
add_action( 'edited_people_comission', 'comissions_save_taxonomy_custom_meta_field', 10, 2 );
