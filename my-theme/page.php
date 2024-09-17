<?php
get_header();
?>
This is a page:

<div id="menu">
	<a href="<?php echo (home_url("/")) ?>">Hem</a>
	<a href="<?php echo (home_url("/butik/")) ?>">Butik</a>
	<a href="<?php echo (home_url("/collections/")) ?>">Kollektioner</a>
	<a href="<?php echo (home_url("/recipes/")) ?>">Respt</a>
</div>

<?php
if (have_posts()):

	while (have_posts()):
		the_post();

		$query = new WP_Query(
			array(
				'post_parent' => get_the_ID(),
				'post_type' => 'page',
				'orderby' => 'menu_order',
				'order' => 'ASC'
			)
		);

		while ($query->have_posts()) {
			$query->the_post();

			?><a href="<?php echo (get_permalink(get_the_ID())); ?>">
				<?php
				the_title();
				?>
			</a>
			<?php
		}

		wp_reset_postdata();


		the_title();
		the_content();

	endwhile;

endif;
?>
<?php
get_footer();