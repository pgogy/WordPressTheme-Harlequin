jQuery(document).ready( function($) {

	if( $('#muqaddimah_post_id').length > 0 && $('#muqaddimah_term_id').length > 0 ){	
				 
		$(".handlediv").click(function(){
			var p = $(this).parent('.postbox');			
			p.toggleClass('closed');
		});
		
		WPSetThumbnailHTML = function(html){
			$('.inside', '#postimagediv').html(html);
		};
		
		WPRemoveThumbnail = function(nonce){
			var post_ID = 0;
			var term_ID = 0;
			
			if( $('#muqaddimah_post_id').length > 0 ){
				post_ID = $('#muqaddimah_term_id').val();
			}
			
			if( $('#muqaddimah_term_id').length > 0 ){
				term_ID = $('#muqaddimah_term_id').val();
			}
			
			if( post_ID < 1 || term_ID < 1 ){
				return;
			}
			
			$.post( ajaxurl, 
				{ 
					action: "muqaddimah-category-remove-image", 
					post_id: post_ID, 
					thumbnail_id: -1,
					term_id: term_ID,
					_ajax_nonce: nonce, 
					cookie: encodeURIComponent(document.cookie)
				}, 
				function(str){
					WPSetThumbnailHTML(str);
				}
			 );
		};
	}
	
});
