<?php
/*
Template Name: Collection Page
*/
ob_start();

get_header();
// Fetch the collection details
$collection_meta = get_post_meta(get_the_ID(), 'collection', true);

if ($collection_meta) {
    echo '<div id="collection-wrapper">';

    // Title
    echo '<h1 id="collection-title">' . get_the_title() . '</h1>';

    // Content
    echo '<p id="collection-content">' . $collection_meta['content'] . '</p>';

    // Display associated products
    if (!empty($collection_meta['products'])) {
        echo '<h3 id="collection-products-title">Products in this Collection:</h3>';
        echo '<ul id="collection-products-list">';
        foreach ($collection_meta['products'] as $product_id) {
            $product = wc_get_product($product_id);
            if ($product) {
                echo '<li id="collection-product-item">';
                echo '<a href="' . get_permalink($product_id) . '" id="collection-product-link">';
                echo $product->get_name();
                echo '</a>';
                echo '</li>';
            }
        }
        echo '</ul>';

        // Add to cart form
        echo '<form method="post" id="add-to-cart-form">';
        echo '<input type="hidden" name="add_to_cart" value="' . implode(',', $collection_meta['products']) . '">';
        echo '<input type="submit" id="add-to-cart-button" value="Lägg till varukorgen" />';
        echo '</form>';
    } else {
        echo '<p>No products in this collection.</p>';
    }

    echo '</div>';
} else {
    echo '<p>No collection data found.</p>';
}

// Add to cart functionality
if (isset($_POST['add_to_cart'])) {
    $product_ids_to_add = explode(',', $_POST['add_to_cart']);
    foreach ($product_ids_to_add as $product_id) {
        WC()->cart->add_to_cart($product_id);
    }
    wp_redirect(wc_get_cart_url());
    exit;
}

get_footer();
