jQuery(document).ready(
	function(){
		jQuery("#tag_cloud svg g text")
			.on("click", function(event){
					window.open(search_url + jQuery(event.target).html(), "_parent");
				}
			);
	}
);