<style>
<?PHP

	$term = get_cat_id( single_cat_title("",false) );
	$color = get_option( 'harlequin_' . $term . '_colour');
	$colour = harlequin_hex2rgb($color);
	$rgba = "rgba(" . $colour[0] . "," . $colour[1] . "," . $colour[2] . ",1)";
?>
.archive .page-title h1{
	color: <?PHP echo $rgba; ?>;
}
</style>
<?php 

	if ( have_posts() ) :

		harlequin_archive_title();

		while ( have_posts() ) : the_post();

			get_template_part( 'parts/content/content-author');

		endwhile;
		
		if (get_theme_mod("tag_cloud")=="on") :
		
			$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
	
			harlequin_tag_cloud(_x("Tag Cloud","tag cloud","harlequin"), harlequin_posts_content("author", $author->ID));
		
		endif;
		
	else :

		get_template_part( 'parts/content/content-none');

	endif;

?>