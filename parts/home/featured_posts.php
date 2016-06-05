<?php 

	$the_query = new WP_Query( array('category__and' => get_option("popuppigeon_featured")) );
	
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			get_template_part( 'parts/content/content-index', get_post_format() );
		}
		
	} 
	
	wp_reset_postdata();

?>