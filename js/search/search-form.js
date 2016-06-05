jQuery(document).ready(
	function(){
		jQuery(".harlequin_search_box")
			.on("focus", function(event){
					jQuery(event.target).attr("value","");
				}
			);
	}
);