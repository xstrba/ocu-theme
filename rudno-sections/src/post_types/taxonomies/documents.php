<?php

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
