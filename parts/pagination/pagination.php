<?PHP

	if(get_theme_mod("pagination")=="on"){

		$links = paginate_links( array( "prev_text" => _x("Previous", 'Before this one', 'harlequin'), "next_text" => _x("Next", 'After this one', 'harlequin') ));
		
		if($links!=""){ ?>
			<footer class="page-footer">
				<h1 class="pagination"><span class='more'><?PHP
					echo _x('More content', 'See more pages with of this type', 'harlequin');
				?></span><?PHP
			
				echo $links;
				
				?></h1>
			</footer><?PHP
		}
		
	}
