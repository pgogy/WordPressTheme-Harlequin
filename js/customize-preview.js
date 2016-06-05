( function( $ ) {

	var $style = $( '#popuppigeon-colour-scheme-css' ),
		api = wp.customize;

	if ( ! $style.length ) {
	$style = $( 'head' ).append( '<style type="text/css" id="popuppigeon-colour-scheme-css" />' )
		                    .find( '#popuppigeon-colour-scheme-css' );
	}

	api( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	api( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	
	api( 'site_allsite_background_colour', function( value ) {
		value.bind( function( to ) {
			$( 'html' ).css("background-color", to );
		} );
	} );		
		
	api( 'site_allsite_colour', function( value ) {
		value.bind( function( to ) {
			$( 'footer.page-footer h1.page-title span.more' ).css("border-right", "2px solid " + to );
			$( '.page-footer h1 a' ).css("background-color", to );
			$( 'footer#colophon div div div aside' ).css("background-color", to );
			$( 'footer#colophon div div nav' ).css("background-color", to );
			$( 'nav form input[type=submit]' ).css("color", to );
			$( 'input[type=submit]' ).css("color", to );
		} );
	} );
	
	api( 'site_alllink_colour', function( value ) {
		value.bind( function( to ) {
			$( 'a' ).css("color"", to );
		} );
	} );
	
	api( 'site_alllink_hover_colour', function( value ) {
		value.bind( function( to ) {
			$( '#content a:hover' ).css("color", to );
			$( '#content a:focus' ).css("color", to );
		} );
	} );
	
	api( 'site_post_background_colour', function( value ) {
		value.bind( function( to ) {
			$( '.widget-title' ).css("color", to );
			$( '.home .page-footer h1 span').css("background-color", to);
			$( 'article').css("background-color", to);
			$( '.page-footer .pagination').css("background-color", to);
			$( 'li.pingback div.comment-body').css("background-color", to);
			$( '.comment-respond').css("background-color", to);
		} );
	} );
	
	api( 'site_content_background_colour', function( value ) {
		value.bind( function( to ) {
			$( '.page-footer h1 a').css("color", to);
			$( 'article .entry-header .entry-title').css("background-color", to);
			$( 'article .entry-content').css("background-color", to);
			$( 'article .entry-footer h6').css("background-color", to);
			$( '.page-header .taxonomy-description').css("background-color", to);
			$( 'section.not-found .page-content').css("background-color", to);
			$( '.page-footer .taxonomy-description').css("background-color", to);
		} );
	} );
	
	api( 'site_alltext_colour', function( value ) {
		value.bind( function( to ) {
			$( '#content' ).css("color", to );
		} );
	} );
	
	api( 'site_footer_colour', function( value ) {
		value.bind( function( to ) {
			$( 'footer#colophon' ).css("background-color", to );
		} );
	} );
	
	api( 'site_button_colour', function( value ) {
		value.bind( function( to ) {
			$( 'button' ).css("background-color", to );
			$( 'input[type=submit]' ).css("background-color", to );
		} );
	} );
	
	api( 'site_button_text_colour', function( value ) {
		value.bind( function( to ) {
			$( 'button' ).css("color", to );
			$( 'input[type=submit]' ).css("color", to );
		} );
	} );
	
	api( 'site_footer_background_colour', function( value ) {
		value.bind( function( to ) {
			$( 'footer#colophon' ).css("background-color", to );
		} );
	} );
	
	api( 'site_menu_background_colour', function( value ) {
		value.bind( function( to ) {
			$( 'h1' ).css("background-color", to );
			$( 'h2' ).css("background-color", to );
			$( 'h3' ).css("background-color", to );
			$( 'h4' ).css("background-color", to );
			$( 'h5' ).css("background-color", to );
			$( 'h6' ).css("background-color", to );
			$( 'summary' ).css("background-color", to );
			$( '#bodyContent h1' ).css("background-color", to );
			$( '#bodyContent h2' ).css("background-color", to );
			$( '#bodyContent h3' ).css("background-color", to );
			$( '#bodyContent h4' ).css("background-color", to );
			$( '#bodyContent h5' ).css("background-color", to );
			$( '#bodyContent h6' ).css("background-color", to );
			$( '.site-navigation' ).css("background-color", to );
			$( '.site-navigation ul' ).css("background-color", to );
			$( '.nav-menu-slide ul' ).css("background-color", to );
		} );
	} );
	
	api( 'site_menu_background_hover_colour', function( value ) {
		value.bind( function( to ) {
			$( '.site-navigation li:hover' ).css("background-color", to ); 
			$( '.site-navigation li:focus' ).css("background-color", to );
		} );
	} );
	
	api( 'site_menu_background_current_colour', function( value ) {
		value.bind( function( to ) {
			$( '.site-navigation ul li .current-menu-item a' ).css("background-color", to );
		} );
	} );
	
	api( 'site_menu_text_colour', function( value ) {
		value.bind( function( to ) {
			$( '.site-navigation ul li a' ).css("color", to );
		} );
	} );
	
	api( 'site_menu_text_hover_colour', function( value ) {
		value.bind( function( to ) {
			$( '.site-navigation li:hover' ).css("color", to ); 
			$( '.site-navigation li:focus' ).css("color", to );
		} );
	} );
	
	api( 'site_header_colour', function( value ) {
		value.bind( function( to ) {
			$( '#page #sidebar' ).css("color", to );
			$( 'header#masthead' ).css("background-color", to );
		} );
	} );
	
	api( 'site_header_text_colour', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	
	api( 'site_title_colour', function( value ) {
		value.bind( function( to ) {
			$( 'header#masthead h1 a' ).css("color", to );
			$( 'header#masthead p a' ).css("color", to );
			$( '.entry-footer div h6.meta_label' ).css("background-color", to );
			$( '.comments-title' ).css("background-color", to );
			$( '.comment-reply-title' ).css("background-color", to );
			$( 'input[type=submit]' ).css("background-color", to );
			$( '.page-header .page-title' ).css("background-color", to );
			$( '.page-footer .page-title' ).css("background-color", to );
			$( 'nav form input[type=submit]' ).css("background-color", to );
			$( 'nav form input[type=submit]' ).css("border-color", to );
		} );
	} );
	
	api.bind( 'preview-ready', function() {
		api.preview.bind( 'update-color-scheme-css', function( css ) {
			$style.html( css );
		} );
	} );
	
	api( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );


} )( jQuery );
