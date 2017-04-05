( function( $ ){
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title' ).html( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).html( to );
		} );
	} );
	wp.customize( 'leohomemakeover_credits', function( value ) {
		value.bind( function( to ) {
			$( '.credits' ).html( to );
		} );
	} );
	wp.customize( 'leohomemakeover_color_bkg', function( value ) {
		value.bind( function( to ) {
			$('body').css('background-color', to );
		} );
	} );
	
	wp.customize( 'leohomemakeover_color_links', function( value ) {
		value.bind( function( to ) {
			$('a:link, a:visited, .menu-divider').css('color', to );
		} );
	} );
	wp.customize( 'leohomemakeover_color_linkshover', function( value ) {
		value.bind( function( to ) {
			$('a:hover').css('color', to );
		} );
	} );
	wp.customize( 'leohomemakeover_color_fonts', function( value ) {
		value.bind( function( to ) {
			$('body').css('color', to );
		} );
	} );
	wp.customize( 'leohomemakeover_color_h2', function( value ) {
		value.bind( function( to ) {
			$('h2').css('color', to );
		} );
	} );
	wp.customize( 'leohomemakeover_color_h3', function( value ) {
		value.bind( function( to ) {
			$('h3').css('color', to );
		} );
	} );

} )( jQuery );