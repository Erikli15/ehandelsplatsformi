<?php
/**
 * Plugin Name: Recipes
 */

function pr_create_custom_post_type()
{
    register_post_type('Recipes', array(
        'labels' => array(
            'name' => 'Recipes',
            'singular_name' => 'Recipe',
            'menu_name' => 'Recipes',
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'Recipes'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'show_in_rest' => true, // För Gutenberg-redigeraren
    ));
}
add_action('init', 'pr_create_custom_post_type');

