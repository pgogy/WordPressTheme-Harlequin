<style>
<?PHP

	$term = get_cat_id( single_cat_title("",false) );
	$color = get_option( 'harlequin_' . $term . '_colour');
	$colour = harlequin_hex2rgb($color);
	$rgba = "rgba(" . $colour[0] . "," . $colour[1] . "," . $colour[2] . ",1)";
?>
.search .page-title h1{
	color: <?PHP echo $rgba; ?>;
}
</style>
<?php 

	if ( have_posts() ) :

	harlequin_archive_title();

	while ( have_posts() ) : the_post();

		get_template_part( 'parts/content/content-search');

	endwhile;
		
		get_template_part('parts/pagination/pagination');
		
	else :

		get_template_part( 'parts/content/content-none');

	endif;

?>