<?php
/*
Template Name:  recipes page
*/
?>

<form method="POST">
    <textarea name="recipe_content" id="recipe_content"></textarea>
    <input type="submit" value="Spara" name="submit_recipe">
</form>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['recipe_content'])) {
        add_post_meta(get_the_id(), 'recipe_message', $_POST['recipe_content']);
    }
}
$recipes = get_post_meta(get_the_id(), 'recipe_message', false);
foreach ($recipes as $recipe) {
    echo ('<div>' . $recipe . '</div>');
}