<?php
/*
Template Name:  collegtions page
*/
?>


<form method="POST">
    <input type="text" name="search_query" id="search_query">
    <input type="submit" value="Sök" name="submit_search">
</form>





<?php

if (isset($_POST['submit_search'])) {

    $search_query = sanitize_text_field($_POST['search_query']);
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1, // Hämta alla produkter
        's' => $search_query // Search for products based on the search query
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $product = wc_get_product(get_the_ID());
            // Gör något med produkten, t.ex. visa dess namn
            echo '<div>';
            echo $product->get_name();
            // Add a link or button to add the product to the collection list
            echo ' <a href="#" data-product-id="' . $product->get_id() . '">Lägg till i samling</a>';
            echo '</div>';

        }

        wp_reset_postdata();
    } else {
        echo 'Inga produkter hittades.';
    }
}
?>