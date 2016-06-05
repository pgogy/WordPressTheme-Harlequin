<?php

function harlequin_category_title_background($term) {

	$hex = harlequin_hex2rgb(get_theme_mod("site_post_background_colour"));

	$thumbnail = get_option( 'harlequin_picture_' . $term . '_thumbnail_id', 0 );
	
	if($thumbnail){
		
		?>margin-top: 10px; background-color: rgba(<?PHP echo $hex[0] . "," . $hex[1] . "," . $hex[2]; ?>, 0.75); <?PHP		
	
	}else{

		$colour = get_option( 'harlequin_' . $term . '_colour');
		
		if($colour){
			
			?> background-color: rgba(<?PHP echo $hex[0] . "," . $hex[1] . "," . $hex[2]; ?>, 0.75); <?PHP		
		
		}
		
	}

}

function harlequin_category_thumbnail_background($term) {

	$thumbnail = get_option( 'harlequin_picture_' . $term . '_thumbnail_id', 0 );
	
	if($thumbnail){
		
		?> background:url('<?PHP echo wp_get_attachment_url($thumbnail); ?>') 0px 0px / cover no-repeat; <?PHP
	
	}else{

		$colour = get_option( 'harlequin_' . $term . '_colour');
		
		if($colour){
			
			?> background:<?PHP echo $colour; ?>; <?PHP
		
		}
		
	}

}

function harlequin_tag_cloud($title, $content){
	?><footer class="page-footer">
		<h1 class="page-title"><?PHP echo $title; ?></h1>
		<div class="taxonomy-description" id='tag_cloud'><?PHP
		
			harlequin_tag_cloud_tags($content);
			
		?></div>
	</footer><?PHP
}

function harlequin_tag_cloud_tags($content){
	
	$words = explode(" ", $content);
	$words = array_filter($words);
	$words = array_slice($words, 0, max(100, (integer) (count($words) / 10)));

	?>
	<script src="<?PHP echo get_template_directory_uri(); ?>/js/tagcloud/d3.lib.js"></script>
	<script src="<?PHP echo get_template_directory_uri(); ?>/js/tagcloud/d3.tagcloud.js"></script>
	<script src="<?PHP echo get_template_directory_uri(); ?>/js/tagcloud/d3.click.js"></script>
	<script>
	  var fill = d3.scale.category20();
	  half_width = (jQuery('#tag_cloud').width()/2);
	  d3.layout.cloud().size([jQuery('#tag_cloud').width(), 300])
		  .words([
			<?PHP
				foreach($words as $word){
					if(trim($word)!="" && strlen($word) > 3){
						echo '"' . trim($word) . '",';
					}
				}
			?>
			].map(function(d) {
			return {text: d, size: 10 + Math.random() * 90};
		  }))
		  .padding(5)
		  .rotate(function() { return ~~(Math.random() * 2) * 90; })
		  .fontSize(function(d) { return d.size; })
		  .on("end", draw)
		  .start();
	  function draw(words) {
		d3.select("#tag_cloud").append("svg")
			.attr("width", jQuery('#tag_cloud').width())
			.attr("height", 300)
		  .append("g")
			.attr("transform", "translate(" + half_width + ",150)")
		  .selectAll("text")
			.data(words)
		  .enter()
		  .append("text")
			.style("font-size", function(d) { return d.size + "px"; })
			.style("cursor", "pointer")
			.attr("text-anchor", "middle")
			.attr("transform", function(d) {
			  return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
			})
			.text(function(d) { return d.text; });
	  }
	</script><?PHP
	
}

function harlequin_get_post_background(){
	if(harlequin_post_thumbnail_url()!=""){
		return 'style="background:url(' . harlequin_post_thumbnail_url() . '); background-size: cover"';
	}else{
		return 'style="background-color:' . get_theme_mod('site_post_default_background_colour') . ';"';
	}
}

function harlequin_get_categories($id){

	$post_categories = wp_get_post_categories($id);
	$cats = array();
		
	foreach($post_categories as $c){
		$cat = get_category( $c );
		$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug, 'link' => get_category_link($c) );
	}
	
	return $cats;

}

function harlequin_post_thumbnail_url() {

	$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'harlequin_featured_image' );
	
	return $image[0];

} 

function harlequin_get_categories_links($id){

	$html = array();
	$cats = harlequin_get_categories($id);
	
	foreach($cats as $cat){
		$html[] = "<a href='" . $cat['link'] ."'>" . $cat['name'] . "</a>";
	}
	
	
	if(count($html)==0){
		$html[] = _x("No Categories", 'When no categories are found', "harlequin");
	}
	
	return $html;

}

function harlequin_entry_meta() {
	
	?><div>
		<h6 class='meta_label'><?PHP echo _x('Categories', 'Categories', 'harlequin'); ?></h6><span><?PHP echo implode(" / ", harlequin_get_categories_links(get_the_ID())); ?></span>
	</div>
	<div>
		<h6 class='meta_label'><?PHP echo _x('Tags', 'Tags', 'harlequin'); ?></h6><span><?PHP echo get_the_tag_list(" ", " / ", " "); ?></span>
	</div>
	<?PHP if(get_theme_mod("author")=="on"){ ?>
	<div>
		<h6 class='meta_label'><?PHP echo _x('Author', 'Post Author', 'harlequin'); ?></h6><span><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a></span></h6>
	</div>
	<div>
		<h6 class='meta_label'><?PHP echo _x('Published', 'Published', 'harlequin'); ?></h6><span><a href="<?php echo get_permalink( get_the_ID() ); ?>"><?php the_date(); ?></a></span></h6>
	</div>
	<?PHP
	}
	
}

function harlequin_archive_title(){

	$term = get_cat_id( single_cat_title("",false) );
	
	if($term==0){
		$term = get_query_var('tag_id');
	}
	
	$thumbnail = get_option( 'harlequin_picture_' . $term . '_thumbnail_id', 0 );			
	if($thumbnail){
		$html = 'style="background:url(' . wp_get_attachment_url($thumbnail) . ') 0px 0px / cover no-repeat;"';
	}else{
		$html = "";
	}

	?><header class="page-header" <?PHP echo $html; ?> >
		<?php
			
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="taxonomy-description">', '</div>' );
			
		?>
	</header><?PHP

}

function harlequin_author_title(){

	?><header class="page-header">
		<?php
			echo '<h1 class="page-title">' . ucfirst(get_the_author_meta("display_name")) . '</h1>';
			if(get_the_author_meta("description")!=""){
				echo '<div class="taxonomy-description">' . get_the_author_meta("description") . '</div>';
			}
		?>
	</header><?PHP

}

function harlequin_child_categories(){

	?><footer class="page-footer">
		<h1 class="page-title"><?PHP echo _x('Related Categories', 'Categories similar to this one', 'harlequin'); ?></h1>
		<div class="taxonomy-description"><?PHP
		
			$category = get_category($_GET['cat']);
			
			$childcats = get_categories('child_of=' . $category->parent . '&hide_empty=1&exclude=' . $_GET['cat']);
			$output = array();
			foreach ($childcats as $childcat) {
				if (cat_is_ancestor_of($ancestor, $childcat->cat_ID) == false){
					$output[] = '<a href="'.get_category_link($childcat->cat_ID).'">' . $childcat->cat_name . '</a>';
					$ancestor = $childcat->cat_ID;
				}
			}
			
			echo implode(" / ", $output);
			
		?></div>
	</footer><?PHP

}

function harlequin_posts_authors_list($type, $id){

	$the_query = new WP_Query( array($type => $id, 'posts_per_page' => 99) );
	
	$authors = array();

	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$authors[] = get_the_author_meta('ID');
		}
	} 
	
	wp_reset_postdata();
	
	return $authors;
	
}

function harlequin_posts_authors_html($type, $id){

	$authors = array_unique(harlequin_posts_authors_list($type, $id));

	$output = array();
	foreach($authors as $author){
		$output[] = "<a href='" . get_author_posts_url($author) . "'>" . ucfirst(get_the_author_meta( 'display_name', $author )) . "</a>";
	}
	
	echo implode(" / ", $output);

}

function harlequin_posts_content($type, $id){

	$the_query = new WP_Query( array($type => $id, 'posts_per_page' => 99) );
	
	$content = "";

	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$content .= str_replace("\r", "", str_replace("\n", "", str_replace(".", "", preg_replace("/(?![=$'%-])\p{P}/u", " ", strip_tags(strtolower(get_the_content()))))));
		}
	} 
	
	wp_reset_postdata();
	
	return $content;
	
}

function harlequin_featured_posts_content($type, $id){

	if($type == "category"){
		$new_type = "category__and";
		$id = array($id, get_option("harlequin_featured"));
		$the_query = new WP_Query( array($new_type => $id, 'posts_per_page' => -1) );
	}else{
		$the_query = new WP_Query( array('category__and' => get_option("harlequin_featured"), $type => $id, 'posts_per_page' => -1) );
	}
	
	if ( $the_query->have_posts() ) {

		?><footer class="page-footer featured-content">
			<h1 class="page-title"><?PHP echo _x('Featured Content', 'Content from the featured category', 'harlequin'); ?></h1>
		</footer>
		<div class="featured-content">
			<?PHP
				
				harlequin_featured_posts_content_html($the_query, $type);
				
			?>
		</div><?PHP
	
	}else{
	
		wp_reset_postdata();
	
	}
	
}

function harlequin_featured_posts_content_html($the_query, $type){

	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			get_template_part("parts/content/content-" . $type . "-lower");
		}
	} 
	
	wp_reset_postdata();
	
}