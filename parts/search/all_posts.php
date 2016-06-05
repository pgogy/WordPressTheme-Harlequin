<?php 

echo "OH DO FUCK OFF";

//	global $query_string;
//	query_posts( $query_string . '&order=ASC&orderby=title' );

	if ( have_posts() ) : 
	
		harlequin_archive_title();
			
//		while ( have_posts() ) : the_post(); 

//			get_template_part( 'parts/content/content-search' );

//		endwhile;

		if(get_theme_mod("pagination")=="on"){
			
			get_template_part('parts/pagination/pagination');

		}

		if(get_theme_mod("search")=="on"){
		
			get_template_part('parts/search-form/standard');
		
		}
			
	else :
			
		get_template_part( 'parts/content/content-none');

	endif;
	
?>