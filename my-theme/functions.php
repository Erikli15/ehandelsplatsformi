<?php
/**
 * my-theme
 */

function mitt_custom_theme_styles()
{
    wp_enqueue_style('mitt-temas-stil', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'mitt_custom_theme_styles');

wp_enqueue_style('extra-stilar', get_template_directory_uri() . '/css/extra-styles.css');
