var brick_list = Array();

jQuery( document ).ready( function( $ ) {
		
	jQuery( '.home #main' )
		.children()
		.each(
			function(index, value){
				jQuery(value).fadeIn(750);
			}
		);
		
	jQuery( '.archive #main' )
		.children()
		.each(
			function(index, value){
				jQuery(value).fadeIn(750);
			}
		);
		
	jQuery( '.search #main' )
		.children()
		.each(
			function(index, value){
				jQuery(value).fadeIn(750);
			}
		);
		
	jQuery(".searchpagination")
		.css("display","block");
	
	
} );