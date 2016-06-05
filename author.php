<?php

get_header(); 

?>	
	<div id="primary" class="content-area">
		<div id="content">	
			<main id="main" class="site-main" role="main"><?PHP

			get_template_part( 'parts/author/all_posts'); 
	
		?></main><!-- .site-main -->
		<div class='searchpagination'>
		<?PHP
			
			if(get_theme_mod("pagination")=="on"){

				get_template_part('parts/pagination/pagination');

			}
			
			if(get_theme_mod("tag_cloud")=="on"){
			
				harlequin_tag_cloud(_x("Tag Cloud","tag cloud","harlequin"), harlequin_posts_content("category", get_cat_id( single_cat_title("",false) )));

			}

			if(get_theme_mod("search")=="on"){
			
				get_template_part('parts/search-form/standard');
			
			}
			
		?>
		</div>
		<?php get_sidebar( 'sidebar-bottom' ); ?>
	</div><!-- .content-area -->

<?php get_footer(); ?>
