<?php
/**
 * Plugin Name: Collegtions 
 */

function pc_create_custom_post_type()
{
    register_post_type('Collegtions', array(
        'labels' => array(
            'name' => 'Collegtions',
            'singular_name' => 'Collegtion',
            'menu_name' => 'Collegtions',
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'Collegtions'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'show_in_rest' => true, // För Gutenberg-redigeraren
    ));
}
add_action('init', 'pc_create_custom_post_type');