<?PHP

	if(is_page()){
		get_template_part( 'parts/content/page' );
	}else{
		get_template_part( 'parts/content/content' );
	}

?>