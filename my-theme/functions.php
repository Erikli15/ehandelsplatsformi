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


// AJAX-handler för att filtrera samlingar
function filter_collections()
{
    $selected_category = isset($_GET['category']) ? $_GET['category'] : '';

    // Bygg query för att hämta samlingar beroende på vald kategori
    $args = array(
        'post_type' => 'Collections',
        'posts_per_page' => -1,
    );

    if (!empty($selected_category)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => $selected_category,
            ),
        );
    }
    $collections = get_posts($args);

    // Om det finns samlingar, returnera dem
    if (!empty($collections)) {
        echo '<ul class="collection-items">'; // Samma klassnamn som för alla kollektioner
        foreach ($collections as $collection) {
            echo '<li class="collection-item">'; // Samma klassnamn för varje kollektionspost
            echo '<a href="' . get_permalink($collection->ID) . '" class="collection-link">'; // Lägg till class här också för länken
            echo '<h2 class="collection-title">' . $collection->post_title . '</h2>'; // Samma klassnamn för titeln
            echo '</a>';
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p class="no-collections">No collections found.</p>'; // Lägg till en stylande klass för tomt resultat
    }

    // Viktigt för AJAX: döda scriptet efter att vi skickat output
    wp_die();
}

// Koppla vår funktion till AJAX-action
add_action('wp_ajax_filter_collections', 'filter_collections');
add_action('wp_ajax_nopriv_filter_collections', 'filter_collections');


