<?php

get_header(); 

?>	
	<div id="primary" class="content-area">
		<div id="content">	
			<main id="main" class="site-main" role="main"><?PHP

			query_posts( $query_string . '&order=ASC' );
		
			get_template_part( 'parts/author/all_posts'); 
	
		?></main><!-- .site-main -->
		<div class='searchpagination'>
		<?PHP
			
			if(get_theme_mod("pagination")=="on"){

				get_template_part('parts/pagination/pagination');

			}

			if(get_theme_mod("search")=="on"){
			
				get_template_part('parts/search-form/standard');
			
			}
			
		?>
		</div>
	</div><!-- .content-area -->

<?php get_footer(); ?>
