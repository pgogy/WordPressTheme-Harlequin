<?php

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?PHP

			get_template_part("parts/search/search");

		?></main><!-- .site-main -->
		<?php get_sidebar( 'sidebar-bottom' ); ?>
	</section><!-- .content-area -->

<?php get_footer(); ?>
