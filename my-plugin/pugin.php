<?php
/**
 * Plugin Name: Collections 
 */

function pc_create_custom_post_type()
{
    register_post_type('Collections', array(
        'labels' => array(
            'name' => 'Collections',
            'singular_name' => 'Collection',
            'menu_name' => 'Collections',
        ),
        'public' => true,
        'has_archive' => true,
        'taxonomies' => array('category'),
        'rewrite' => array('slug' => 'Collections'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'show_in_rest' => true, // För Gutenberg-redigeraren
    ));
}
add_action('init', 'pc_create_custom_post_type', );