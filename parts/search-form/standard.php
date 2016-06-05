<?PHP

	?><div id="searchform">
		<form action="<?PHP echo home_url(); ?>" method="GET">
			<input type="text" class='harlequin_search_box' name="s" value="Search...." />
			<input type="submit" value="<?PHP echo __("Search", 'harlequin'); ?>" />
		</form>
	</div><?PHP
	
?>