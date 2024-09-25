<?php
/*
Template Name: Collections Page
*/

?>
<!-- Lägg till CSS för Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Lägg till jQuery (om du inte redan har det) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Lägg till JavaScript för Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<?php
get_header();
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<form method="post">
    <input type="text" name="title" placeholder="Kollektion titel">
    <textarea name="content" placeholder="Kollektion beskrivning"></textarea>
    <input type="text" id="product_search" placeholder="Sök produkt...">
    <?php
    if (class_exists('WooCommerce')) {
        // Get all published products
        $products = wc_get_products(array('limit' => -1)); // Fetch all products
        if (!empty($products)) {
            echo '<select id="product_select" name="product_select[]" multiple>';
            foreach ($products as $product) {
                echo '<option value="' . $product->get_id() . '">' . $product->get_name() . '</option>';
            }
            echo '</select>';
        } else {
            echo 'No products found.';
        }

        // Get all categories
        $categories = get_terms(array(
            'taxonomy' => 'category',
            'hide_empty' => false,
        ));
        if (!empty($categories)) {
            echo '<select id="category_select" name="category_select" multiple>';

            foreach ($categories as $category) {
                echo '<option value="' . $category->term_id . '">' . $category->name . '</option>';
            }
            echo '</select>';
        } else {
            echo 'No categories found.';
        }
    }
    ?>
    <input type="submit" value="Lägg till Kollektion">
</form>

<script>
    // Lyssnar på inmatningen i sökfältet
    document.getElementById('product_search').addEventListener('input', function () {
        var searchValue = this.value.toLowerCase();  // Hämta värdet från sökfältet
        var options = document.getElementById('product_select').options;  // Hämta alternativen i select

        // Loopar genom alternativen och visar/döljer baserat på sökvärdet
        for (var i = 0; i < options.length; i++) {
            var optionText = options[i].text.toLowerCase();  // Texten i alternativet i små bokstäver
            if (optionText.includes(searchValue)) {
                options[i].style.display = '';  // Visa om texten matchar sökordet
            } else {
                options[i].style.display = 'none';  // Dölj annars
            }
        }
    });
</script>

<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $title = $_POST['title'];
    $content = $_POST['content'];
    $selected_products = $_POST['product_select'] ?? [];
    $selected_categories = $_POST['category_select'] ?? [];
    // Create a new instance of the custom post type
    $post = array(
        'post_type' => 'Collections',
        'post_title' => $title,
        'post_content' => $content,
        'post_status' => 'publish',
        'tax_input' => array(
            'category' => $selected_categories // Replace with the desired category slug
        )
    );
    $post_id = wp_insert_post($post);

    // Save the collection as post meta
    $collection_meta = array(
        'title' => $title,
        'content' => $content,
        'products' => $selected_products,
        'category' => $selected_categories
    );
    update_post_meta($post_id, 'collection', $collection_meta);

}
?>
<!-- Här ska kollektionerna visas -->
<div id="collection-results">
    <!-- Dropdown för kategorier -->
    <?php
    // Hämta kategorier och skapa dropdown
    $categories = get_terms(array(
        'taxonomy' => 'category',
        'hide_empty' => false,
    ));

    echo '<select id="category-filter" class="styled-select">';
    echo '<option value="">All categories</option>';
    foreach ($categories as $category) {
        echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
    }
    echo '</select>';
    ?>

    <!-- Här kommer resultaten laddas in via AJAX -->
    <div id="collection-list" class="styled-collection-list">
        <?php
        // Hämta alla samlingar som standard
        $collections = get_posts(array(
            'post_type' => 'Collections',
            'posts_per_page' => -1,
        ));

        if (!empty($collections)) {
            echo '<ul class="collection-items">';
            foreach ($collections as $collection) {
                echo '<li class="collection-item">';
                echo '<a href="' . get_permalink($collection->ID) . '" class="collection-link">';
                echo '<h2 class="collection-title">' . $collection->post_title . '</h2>';
                echo '</a>';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p class="no-collections">No collections found.</p>';
        }
        ?>
    </div>
</div>

<script>
    // JavaScript (jQuery) för att hantera AJAX-förfrågningar
    jQuery(document).ready(function ($) {
        $('#category-filter').on('change', function () {
            var selectedCategory = $(this).val();

            $.ajax({
                url: '<?php echo admin_url("admin-ajax.php"); ?>',
                type: 'GET',
                data: {
                    action: 'filter_collections',
                    category: selectedCategory
                },
                success: function (response) {
                    $('#collection-list').html(response); // Uppdatera resultatet med korrekt HTML och CSS-klasser
                }
            });
        });
    });

</script>

<?php
wp_footer();
?>