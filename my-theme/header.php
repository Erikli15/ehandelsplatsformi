<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/extra-styles.css">

</head>

<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<div id="menu">
		<a href="<?php echo (home_url("/")) ?>">Hem</a>
		<a href="<?php echo (home_url("/butik/")) ?>">Butik</a>
		<a href="<?php echo (home_url("/collections/")) ?>">Kollektioner</a>
		<a href="<?php echo (home_url("/recipes/")) ?>">Respt</a>
		<a href="<?php echo (home_url("/varukorg/")) ?>">Varukorg</a>
	</div>