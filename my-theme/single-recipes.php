<?php
/*
Template Name:  recipes page
*/

get_header();

?>
<?php
// Hämta alla produkter från WooCommerce
$products = wc_get_products(array(
    'limit' => -1, // Hämta alla produkter
));
?>
<!-- Skapa en datalist med WooCommerce-produkterna -->
<datalist id="product-list">
    <?php foreach ($products as $product): ?>
        <option value="<?php echo esc_attr($product->get_name()); ?>">
        <?php endforeach; ?>
</datalist>


<form method="POST">
    <input type="text" name="creator_name" placeholder="Ditt namn" required>

    <div id="ingredient-container">
        <div>
            <input type="text" name="ingredient_name[]" list="product-list" placeholder="Ingrediens 1" required>
            <input type="number" name="ingredient_quantity[]" placeholder="Antal" min="1" required>
            <select name="ingredient_unit[]">
                <option value="kg">kg</option>
                <option value="hg">hg</option>
                <option value="gram">gram</option>
                <option value="l">l</option>
                <option value="dl">dl</option>
                <option value="cl">cl</option>
                <option value="ml">ml</option>
                <option value="msk">msk</option>
                <option value="tsk">ts</option>
                <option value="krm">krm</option>
                <option value="kpp">kpp</option>
                <option value="st">st</option>
            </select>
            <button class="remove-button">Ta bort</button>
        </div>
    </div>
    <div><button id="add-button">Lägg till ingredient</button></div>
    <script>
        const ingredientContainer = document.getElementById('ingredient-container');
        const addButton = document.getElementById('add-button');

        addButton.addEventListener('click', () => {
            const newIngredientFields = `
        <div>
            <input type="text" name="ingredient_name[]" list="product-list" placeholder="Ingrediens" required>
            <input type="number" name="ingredient_quantity[]" placeholder="Antal" min="1" required>
            <select name="ingredient_unit[]">
                <option value="kg">kg</option>
                <option value="hg">hg</option>
                <option value="gram">gram</option>
                <option value="l">l</option>
                <option value="dl">dl</option>
                <option value="cl">cl</option>
                <option value="ml">ml</option>
                <option value="ms">ms</option>
                <option value="ts">ts</option>
                <option value="krm">krm</option>
                <option value="kkp">kkp</option>
                <option value="st">st</option>
            </select>
            <button class="remove-button">Remove</button>
        </div>
    `;
            ingredientContainer.insertAdjacentHTML('beforeend', newIngredientFields);
        });

        ingredientContainer.addEventListener('click', (event) => {
            if (event.target.classList.contains('remove-button')) {
                event.target.parentNode.remove();
            }
        });
    </script>
    <textarea name="recipe_description" placeholder="Beskrivning av receptet" required></textarea>

    <input type="submit" value="Spara" name="submit_recipe">
</form>


<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['submit_recipe'])) {
        $creator_name = sanitize_text_field($_POST['creator_name']);
        $recipe_description = sanitize_textarea_field($_POST['recipe_description']);

        $ingredients = array_map(function ($name, $quantity, $unit) {
            return $quantity . ' ' . $unit . ' ' . sanitize_text_field($name);
        }, $_POST['ingredient_name'], $_POST['ingredient_quantity'], $_POST['ingredient_unit']);

        $ingredient_list = implode(", ", $ingredients);

        $new_post = [
            'post_title' => wp_strip_all_tags("$creator_name's Recept"),
            'post_content' => "Ingredienser: $ingredients_list\n\nBeskrivning: $recipe_description\n\nInstruktioner: $instructions_list",
            'post_status' => 'publish',
            'post_author' => get_current_user_id(),
            'post_type' => 'Recipes', // Update post type to 'recipe'
        ];

        $post_id = wp_insert_post($new_post);

        $recipe_meta = array(
            'creator_name' => $creator_name,
            'recipe_description' => $recipe_description,
            'ingredient_list' => $ingredient_list
        );
        // Set the recipe message meta key
        update_post_meta($post_id, 'recipe', $recipe_meta);
    }
}

// Retrieve recipe messages
$recipes = get_posts(array(
    'post_type' => 'Recipes',
    'posts_per_page' => -1
));

?>
<section id="recipe-body">
    <?php
    foreach ($recipes as $recipe) {
        $recipe_meta = get_post_meta($recipe->ID, 'recipe', true);
        $ingredients = explode(", ", $recipe_meta['ingredient_list']);
        $instructions = explode("\n", $recipe_meta['recipe_description']); // Assuming instructions are separated by newline characters
    
        ?>
        <div id="recipe-card">
            <h2 id="recipe-title"><?php echo $recipe->post_title; ?></h2>
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
</section>