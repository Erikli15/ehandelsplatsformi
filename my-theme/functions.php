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

function update_custom_field_for_all_products_callback()
{
    // code to update custom field for all products
    $products = wc_get_products(array(
        'limit' => -1, // Hämta alla produkter
    )); // get the products
    return $products;

}
add_action('init', 'update_custom_field_for_all_products_callback');
