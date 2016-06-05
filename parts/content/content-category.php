<?PHP
	$colour = harlequin_hex2rgb(get_post_meta(get_the_ID(), "harlequin_post_colour", true));
	$rgba = "rgba(" . $colour[0] . "," . $colour[1] . "," . $colour[2] . ", 0.7)";
	
	$title_length = strlen($post->post_title);
	if($title_length<15){
		$width = "small";
	}else if($title_length<30){
		$width = "medium";
	}else{
		$width = "large";
	}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class("home-page " . $width); ?> <?PHP echo harlequin_get_post_background(); ?>>		
	<h2 class="entry-title" style="background-color:<?PHP echo $rgba; ?>;">
		<a href="<?PHP echo get_permalink(); ?>" rel="bookmark"><?PHP echo the_title(); ?></a>
	</h2>
</article>