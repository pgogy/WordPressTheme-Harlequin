<section class="error-404 not-found">
	<header class="page-header">
		<h1 class="page-title">
			<?PHP
				echo sprintf(
					 __( 'Sorry, Nothing found for %s', 'harlequin' ), $_GET['s']
				);
			?>
		</h1>
	</header>
	<div class="entry-content">
		<p><?PHP echo __( 'Search again?', 'harlequin' ); ?></p>
		<?PHP get_search_form(); ?>
	</div>
</section>