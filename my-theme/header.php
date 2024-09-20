<!doctype html>
<html <?php language_attributes(); ?>>


<head>
	<?php wp_head(); ?>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/extra-styles.css">
	<!-- Google Tag Manager -->
	<script>(function (w, d, s, l, i) {
			w[l] = w[l] || []; w[l].push({
				'gtm.start':
					new Date().getTime(), event: 'gtm.js'
			}); var f = d.getElementsByTagName(s)[0],
				j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
					'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
		})(window, document, 'script', 'dataLayer', 'GTM-KDZL6DR5');</script>
	<!-- End Google Tag Manager -->
</head>

<body <?php body_class(); ?>>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KDZL6DR5" height="0" width="0"
			style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	<?php wp_body_open(); ?>

	<div id="menu">
		<a href="<?php echo (home_url("/")) ?>">Hem</a>
		<a href="<?php echo (home_url("/butik/")) ?>">Butik</a>
		<a href="<?php echo (home_url("/collections/")) ?>">Kollektioner</a>
		<a href="<?php echo (home_url("/recipes/")) ?>">Respt</a>
		<a href="<?php echo (home_url("/varukorg/")) ?>">Varukorg</a>
	</div>