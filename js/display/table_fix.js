jQuery(document).ready( function(){
	jQuery( ".single article table" )
		.each(
			function(index,value){
				width = jQuery(value).width();
				jQuery(value)
					.css("width", "100%");
			}
		);

	}
);