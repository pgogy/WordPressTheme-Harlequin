<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<?PHP
	get_template_part( 'parts/header/main');
	wp_head();
?>
<body <?php body_class(); ?>>
	<div id="page" class="hfeed site">
		<div id="header-area" class="sidebar sidebar-centre">
			<header id="masthead" class="site-header" role="banner">
				<div id='site-name' class="site-branding">
					<?PHP 
						$name_extra = "";
						$desc_extra = "";
						$name = get_bloginfo('name'); 
						$desc = get_bloginfo('description');
						if(strlen($name)>50){
							$name_extra = "small_title";
						}
						if(strlen($desc)>50){
							$desc_extra = "small_title";
						}
						
					?>
					<h1 class="site-title <?PHP echo $name_extra ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?PHP echo $name; ?></a></h1>
					<h2 class="site-description <?PHP echo $desc_extra ?>"><?PHP echo $desc; ?></h2>
				</div><!-- .site-branding -->
			</header><!-- .site-header -->
			<?PHP
				
				get_template_part( 'parts/header/menu/standard'); 
			
			?>
		</div>