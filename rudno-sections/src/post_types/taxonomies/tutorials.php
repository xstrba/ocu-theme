<?php

function rudno_register_tutorials_taxonomy()
{
    $labels = [
        'name'              => 'Kategórie',
        'singular_name'     => 'Kategória',
        'search_items'      => 'Hladaj kategóriu',
        'all_items'         => 'Všetky kategórie',
        'edit_item'         => 'Upraviť kategóriu',
        'update_item'       => 'Aktualizovať kategóriu',
        'add_new_item'      => 'Vytvoriť kategóriu',
        'new_item_name'     => 'Názov kategórie',
        'menu_name'         => 'Kategórie',
    ];
    $args = [
        'hierarchical'      => true,
        'public'            => true,
        'labels'            => $labels,
        'has_archive'       => true,
        'show_admin_column' => true,
        'meta_box_cb'       => false,
        'rewrite'           => array('slug' => 'potrebujem-vybavit', 'with_front' => false)
    ];
    register_taxonomy('tutorial-category', ['rudno-tutorials'], $args);
}
add_action('init', 'rudno_register_tutorials_taxonomy');

function tutorial_taxonomy_add_custom_field() {
    $people = get_posts([
        'numberposts' => -1,
        'post_type' => 'rudno-people',
        'tax_query' => [
            [
                'taxonomy' => 'people_position',
                'field' => 'slug',
                'terms' => 'zamestnanec'
            ],
        ]
    ]);

?>
    <div class="form-field">
    <label for="term_meta[_person]"><?php echo __('Kontaktná osoba'); ?></label>
    <select name="term_meta[_person]" id="_person">
    <option value=""><?php echo __('--') ?></option>
<?php
    foreach ($people as $person) {
?>
        <option value="<?php echo $person->ID ?>"><?php echo $person->_name?></option>
<?php
    }
?>
    </select>
    <p class="description"><?php echo __( 'Priraďte osobu zodpovednú za túto kategóriu' ); ?></p>
    </div>
<?php
}

add_action( 'tutorial-category_add_form_fields', 'tutorial_taxonomy_add_custom_field', 10, 2 );


function tutorials_taxonomy_edit_custom_meta_field($term) {
    $people = get_posts([
        'numberposts' => -1,
        'post_type' => 'rudno-people',
        'tax_query' => [
            [
                'taxonomy' => 'people_position',
                'field' => 'slug',
                'terms' => 'zamestnanec'
            ],
        ]
    ]);

    $t_id = $term->term_id;
    $term_meta = get_term_meta($t_id, '_person', true);

?>
    <tr class="form-field">
    <th scope="row" valign="top"><label for="term_meta[class_term_meta]"><?php echo __('Kontaktná osoba'); ?></label></th>
        <td>
            <select name="term_meta[_person]" id="_person">
            <option value=""><?php echo __('--') ?></option>
<?php
            foreach ($people as $person) {
?>
                <option value="<?php echo $person->ID ?>" <?php echo $term_meta == $person->ID ? 'selected': ''?>><?php echo $person->_name?></option>
<?php
            }
?>
            </select>
            <p class="description"><?php echo __( 'Priraďte osobu zodpovednú za túto kategóriu' ); ?></p>
        </td>
    </tr>
<?php
}

add_action( 'tutorial-category_edit_form_fields', 'tutorials_taxonomy_edit_custom_meta_field', 10, 2 );

function tutorials_save_taxonomy_custom_meta_field( $term_id ) {
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
add_action( 'edited_tutorial-category', 'tutorials_save_taxonomy_custom_meta_field', 10, 2 );
add_action( 'create_tutorial-category', 'tutorials_save_taxonomy_custom_meta_field', 10, 2 );
