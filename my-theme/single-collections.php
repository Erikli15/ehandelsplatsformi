<?php
/*
Template Name: Collection Page
*/
ob_start();

get_header();
// Fetch the collection details
$collection_meta = get_post_meta(get_the_ID(), 'collection', true);
if ($collection_meta) {
    echo '<h1>' . get_the_title() . '</h1>';
    echo '<p>' . $collection_meta['content'] . '</p>';

    // Display associated products
    if (!empty($collection_meta['products'])) {
        echo '<h3>Products in this Collection:</h3>';
        echo '<ul>';
        foreach ($collection_meta['products'] as $product_id) {
            $product = wc_get_product($product_id);
            if ($product) {
                echo '<li>';
                echo '<a href="' . get_permalink($product_id) . '">';
                echo $product->get_name();
                echo '</a>';
                echo '</li>';
            }
        }
        echo '</ul>';

        // Add to cart form
        echo '<form method="post">';
        echo '<input type="hidden" name="add_to_cart" value="' . implode(',', $collection_meta['products']) . '">';
        echo '<input type="submit" value="Lägg till varukorgen" />';
        echo '</form>';

        // Add to cart functionality
        if (isset($_POST['add_to_cart'])) {
            $product_ids_to_add = explode(',', $_POST['add_to_cart']);
            foreach ($product_ids_to_add as $product_id) {
                WC()->cart->add_to_cart($product_id);
            }
            wp_redirect(wc_get_cart_url());
            exit;
        }
    } else {
        echo '<p>No products in this collection.</p>';
    }
} else {
    echo '<p>No collection data found.</p>';
}

get_footer();
