<style>
<?PHP
	$colour = harlequin_hex2rgb(get_post_meta(get_the_ID(), "harlequin_post_colour", true));
	$rgba = "rgba(" . $colour[0] . "," . $colour[1] . "," . $colour[2] . ",1)";
?>
.page article .entry-header h1{
	color: <?PHP echo $rgba; ?>;
}
</style>
<article id="post-<?php the_ID(); ?>">
	<header class="entry-header" <?PHP echo harlequin_get_post_background() ?>>
		<?php
			the_title( '<h1 class="entry-title">', '</h1>' );
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading %s', 'harlequin' ),
				the_title( '<span class="screen-reader-text">', '</span>', false )
			) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->