<?php
/*
Template Name: Collections Page
*/
?>

<form method="post">
    <input type="text" name="title" placeholder="Kollektion titel">
    <textarea name="content" placeholder="Kollektion beskrivning"></textarea>

    <?php
    if (class_exists('WooCommerce')) {
        // Get all published products
        $products = wc_get_products(array('limit' => -1)); // Fetch all products
        if (!empty($products)) {
            echo '<select name="product_select[]" multiple>';
            foreach ($products as $product) {
                echo '<option value="' . $product->get_id() . '">' . $product->get_name() . '</option>';
            }
            echo '</select>';
        } else {
            echo 'No products found.';
        }
    }
    ?>

    <input type="submit" value="Lägg till Kollektion">
</form>

<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $title = $_POST['title'];
    $content = $_POST['content'];
    $selected_products = $_POST['product_select'] ?? [];

    // Create a new instance of the custom post type
    $post = array(
        'post_type' => 'Collections',
        'post_title' => $title,
        'post_content' => $content,
        'post_status' => 'publish',
    );
    $post_id = wp_insert_post($post);

    // Save the collection as post meta
    $collection_meta = array(
        'title' => $title,
        'content' => $content,
        'products' => $selected_products
    );
    update_post_meta($post_id, 'collection', $collection_meta);

}
// Update the collection display
$collections = get_posts(array(
    'post_type' => 'Collections',
    'posts_per_page' => -1
));

if (!empty($collections)) {
    echo '<ul>'; // Start an unordered list
    foreach ($collections as $collection) {
        echo '<li>';
        echo '<a href="' . get_permalink($collection->ID) . '">';
        echo '<h2>' . $collection->post_title . '</h2>';
        echo '</a>';
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo 'No collections found.';
}
?>