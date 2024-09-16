<?php
/*
Template Name:  recipes page
*/

get_header()

    ?>
<form method="POST">
    <input type="text" name="creator_name" placeholder="Ditt namn" required>

    <div id="ingredient-container">
        <div>
            <input type="text" name="ingredient_name[]" placeholder="Ingrediens 1" required>
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
            <input type="text" name="ingredient_name[]" placeholder="Ingrediens" required>
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
            'post_content' => "Ingredienser: $ingredient_list \n\n Beskrivning: $recipe_description",
            'post_status' => 'publish',
            'post_author' => get_current_user_id(),
            'post_type' => 'Recipes', // Update post type to 'recipe'
        ];

        $post_id = wp_insert_post($new_post);

        $recipe_meta = array(
            'creator_name' => $creator_name,
            'recipe_description' => $recipe_description,
            'ingredient' => $ingredient_list
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


foreach ($recipes as $recipe) {
    echo ('<div className="recipe_contaner">' . $recipe->post_title . $recipe->post_content . '</div>');
}