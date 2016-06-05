jQuery(document).ready( function($) {
		
		jQuery("li.menu-back")
			.on("click", function(event){
				jQuery(event.currentTarget)
						.parent()
						.fadeOut("linear", function(){
								jQuery(event.currentTarget)
									.parent()
									.parent()
									.parent()
									.children()
									.each(
										function(index,value){
											jQuery(value).fadeIn("linear");
										}
									);
							}
						);
						
			}
		);
	
		jQuery("nav.nav-menu-standard .caret")
			.on("click", function(event){
					
					if(jQuery(event.currentTarget).attr("menu_depth")=="menu-depth-0"){
					
						jQuery(event.currentTarget)
							.parent()
							.parent()
							.attr("keep","true");
						
						length = jQuery(event.currentTarget)
							.parent()
							.parent()
							.parent()
							.children()
							.length;
						
						jQuery(event.currentTarget)
							.parent()
							.parent()
							.parent()
							.children()
							.each(
								function(index,value){
									if(jQuery(value).attr("keep")!="true"){
										if((index+1)==length){
											jQuery(value).fadeOut("linear", function(){
												jQuery(event.currentTarget)
													.parent()
													.next()
													.fadeIn("linear")
											});
										}else{
											jQuery(value).fadeOut("linear");
										}
									}else{
										jQuery(value).attr("keep","");
										if((index+1)==length){
											jQuery(event.currentTarget)
												.parent()
												.next()
												.fadeIn("linear");
										}
									}
								}
							);
					
					}else{	
					
						length = jQuery(event.currentTarget)
							.parent()
							.parent()
							.parent()
							.children()
							.length;
					
						jQuery(event.currentTarget)
							.parent()
							.parent()
							.parent()
							.children()
							.first()
							.attr("keep","true");
							
						jQuery(event.currentTarget)
							.parent()
							.parent()
							.attr("keep","true");

						jQuery(event.currentTarget)
							.parent()
							.parent()
							.parent()
							.children()
							.each(
								function(index,value){
									if(jQuery(value).attr("keep")!="true"){
										if((index+1)==length){
											jQuery(value).fadeOut("linear", function(){
												jQuery(event.currentTarget)
													.parent()
													.next()
													.fadeIn("linear")
											});
										}else{
											jQuery(value).fadeOut("linear");
										}
									}else{
										jQuery(value).attr("keep","");
										if((index+1)==length){
											jQuery(event.currentTarget)
												.parent()
												.next()
												.fadeIn("linear");
										}
									}
								}
							);

					}
		
				}
			);
	}
);
