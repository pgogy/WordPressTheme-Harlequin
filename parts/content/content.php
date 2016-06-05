<style>
<?PHP
	$post_colour = get_post_meta(get_the_ID(), "harlequin_post_colour", true);
	if($post_colour==""){
		$rgba = get_theme_mod('site_post_default_title_colour');
	}else{
		$colour = harlequin_hex2rgb($post_colour);
		$rgba = "rgba(" . $colour[0] . "," . $colour[1] . "," . $colour[2] . ",1)";
	}
?>
.single h1{
	color: <?PHP echo $rgba; ?>;
}
</style>
<article id="post-<?php the_ID(); ?>">
	<header class="entry-header" <?PHP echo harlequin_get_post_background() ?>>
		<?php
			the_title( '<h1 class="entry-title">', '</h1>' );
		?>
	</header>

	<div class="entry-content">
		<?php
			the_content( sprintf(
				__( 'Continue reading %s', 'harlequin' ),
				the_title( '<span class="screen-reader-text">', '</span>', false )
			) );
			
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'harlequin' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'harlequin' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
	</div>
	
	<footer class="entry-footer">
		<?php harlequin_entry_meta(); ?>
		<?php edit_post_link( __( 'Edit', 'harlequin' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->