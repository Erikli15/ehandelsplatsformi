<?php
/*
Template Name: Start Page
*/
?>
<?php
get_header();
?>
<div class="logo">Baka med Glädje</div>

<section class="hero">
    <div class="hero-text">
        <h1>Fyll ditt kök med doften av nybakat</h1>
        <a href="/butik/" class="btn">Shoppa nu</a>
    </div>
</section>
<?php
$args = array(
    'post_type' => 'product',
    'posts_per_page' => 3,
    'meta_key' => 'total_sales',
    'orderby' => 'meta_value_num',
    'order' => 'DESC'
);

$popular_products = new WP_Query($args);

if ($popular_products->have_posts()) {
    echo '<section class="featured-products">';
    echo '<h2>Utvalda Produkter</h2>';
    while ($popular_products->have_posts()) {
        $popular_products->the_post();
        // Visa produktinformation
        echo '<div class="product-card">';
        echo '<img src="' . get_the_post_thumbnail_url() . '" alt="' . get_the_title() . '">';
        echo '<h3>' . get_the_title() . '</h3>';
        echo '<p>Pris: ' . $product->get_price() . ' kr</p>'; // Assuming you have a function get_price() to retrieve the product
        echo '<button>Lägg i varukorg</button>';
        echo '</div>';
    }
    echo '</section>';
    wp_reset_postdata();
} else {
    echo 'Inga populära produkter hittades.';
}

$popular_recipes = get_posts(array(
    'post_type' => 'Recipes',
    'posts_per_page' => 3,
));
?>
<section class="recipe-tips">
    <h2>Prova våra populära recept!</h2>
    <article id="recipe-body">
        <?php
        foreach ($popular_recipes as $popular_recipe) {
            $recipe_meta = get_post_meta($popular_recipe->ID, 'recipe', true);
            $ingredients = explode(", ", $recipe_meta['ingredient_list']);
            $instructions = explode("\n", $recipe_meta['recipe_description']); // Assuming instructions are separated by newline characters
        
            ?>
            <div id="recipe-card">
                <h2 id="recipe-title"><?php echo $popular_recipe->post_title; ?></h2>
                <div id="ingredients">
                    <ul>
                        <?php foreach ($ingredients as $ingredient) { ?>
                            <li><?php echo $ingredient; ?></li>
                        <?php } ?>
                    </ul>
                </div>
                <div id="instructions">
                    <ol>
                        <?php foreach ($instructions as $instruction) { ?>
                            <li><?php echo $instruction; ?></li>
                        <?php } ?>
                    </ol>
                </div>
            </div>
            <?php
        }
        ?>
    </article>
</section>

<section class="reviews">
    <h2>Populära kollektioner</h2>
    <?php
    $collections = get_posts(array(
        'post_type' => 'Collections',
        'posts_per_page' => 6,
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
</section>

<?php
get_footer();
?>