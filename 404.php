<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Sorry, something can\'t be found. Try searching below', 'harlequin' ); ?></h1>
					<?PHP get_search_form(); ?>
				</header><!-- .page-header -->
			</section><!-- .error-404 -->
		</main><!-- .site-main -->
		<?php get_sidebar( 'sidebar-bottom' ); ?>
	</div><!-- .content-area -->

<?php get_footer(); ?>
