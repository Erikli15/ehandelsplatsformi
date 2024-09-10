<?php
/*
Template Name:  collegtions page
*/
?>

<form method="post">
    <input type="text" name="title">
    <textarea name="content"></textarea>
    <?php
    if (class_exists('WooCommerce')) {
        // Få alla publicerade produkter
        $products = wc_get_products(array('limit' => -1)); // Hämta alla produkter
        // Rendera en <select>-tagg med produkter
        if (!empty($products)) {
            echo '<select name="product_select[]" multiple>';
            foreach ($products as $product) {
                echo '<option value="' . $product->get_id() . '">' . $product->get_name() . '</option>';
            }
            echo '</select>';
        } else {
            echo 'Inga produkter hittades.';
        }
    }
    ?>
    <input type="submit" value="Lägg till">

</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Hämta formulärdata
    $title = $_POST['title'];
    $content = $_POST['content'];
    $selected_products = $_POST['product_select'] ?? [];

    // Skapa en ny instans av custom post typen
    $post = array(
        'post_type' => 'Collegtions',
        'post_title' => $title,
        'post_content' => $content,
    );
    $post_id = wp_insert_post($post);

    // Spara kollektionen som post meta
    $collection = array(
        'title' => $title,
        'content' => $content,
        'products' => $selected_products
    );
    update_post_meta($post_id, 'collection', $collection);

    // Gör något med kollektionen (t.ex. skriva ut kollektionen)
    echo '<h2>Kollektioner:</h2>';
    echo '<p>Title: ' . $collection['title'] . '</p>';
    echo '<p>Innehåll: ' . $collection['content'] . '</p>';
    echo '<p>Produkter:</p>';
    foreach ($collection['products'] as $product_id) {
        $product = wc_get_product($product_id);
        echo '<p>' . $product->get_name() . '</p>';
    }
}
?>