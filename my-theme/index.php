<?php
get_header();

if (is_tax() || is_category()) {
	// Get the current term
	$term = get_queried_object();

	// Output the term name
	echo '<h1>' . esc_html($term->name) . '</h1>';
}
?>


<?php
if (have_posts()):

	while (have_posts()):
		the_post();
		the_title();
		the_content();
	endwhile;

endif;
?>

<?php
get_footer();
