<?php 

//  Custom Functions:
//  This functions page has only the functions necessary to duplicate the effects and design of leobabauta.com.
//  In the spirit of Zenhabit's minimalism, the functions will be as minimal as possible.
//  There are also some security-related and Wordpress bloat-trimming code.
//
//  All this to slightly improve an already marvelous theme!


//  Add Custom Menu Support
add_theme_support( 'menus' );
register_nav_menus(  
        array(  
            'primary'               => 'Home Page List Navigation',
            'latest_post'           => 'Full Width Latest Post',
			'footer_menu'           => 'Footer Menu.')  
        );  

	// Sets up menu parameters and adds Walker Class. (allows for text description before links)

	class description_walker extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth, $args) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="'. esc_attr( $class_names ) . '"';

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$description  = ! empty( $item->description ) ? '<dt class="before-desc">'.esc_attr( $item->description ).'</dt>' : '';

		if($depth != 0) {
			$description = $append = $prepend = "";
		}

		$item_output = $args->before;
		$item_output .= $description.$args->link_before;
		$item_output .= '<dd><a'. $attributes .'>';
		$item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );
		$item_output .= '</a></dd>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

// Front end only, don't hack on the settings page
if ( ! is_admin() ) {
    // Hook in early to modify the menu
    // This is before the CSS "selected" classes are calculated
    add_filter( 'wp_get_nav_menu_items', 'replace_placeholder_nav_menu_item_with_latest_post', 10, 3 );
}


	// Walker Class for Centered Home Page

	class centered_description_walker extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth, $args) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="'. esc_attr( $class_names ) . '"';

		$output .= $indent . '<article class="col" id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

		if($depth != 0) {
			$description = $append = $prepend = "";
		}

		$item_output = $args->before; 
		$item_output .= $description.$args->link_before;
		$item_output .= '</br>';
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );
		$item_output .= '</a></article>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

// Front end only, don't hack on the settings page
if ( ! is_admin() ) {
    // Hook in early to modify the menu
    // This is before the CSS "selected" classes are calculated
    add_filter( 'wp_get_nav_menu_items', 'replace_placeholder_nav_menu_item_with_latest_post', 10, 3 );
}

 
// Replaces a custom URL placeholder with the URL to the latest post
function replace_placeholder_nav_menu_item_with_latest_post( $items, $menu, $args ) {
 
    // Loop through the menu items looking for placeholder(s)
    foreach ( $items as $item ) {
 
        // Is this the placeholder we're looking for?
        if ( '#latest' != $item->url )
            continue;
 
        // Get the latest post
        $latestpost = get_posts( array(
            'numberposts' => 1,
        ) );
 
        if ( empty( $latestpost ) )
            continue;
 
        // Replace the placeholder with the real URL
        $item->url = get_permalink( $latestpost[0]->ID );
		$item->title = $latestpost[0]->post_title;
    }
 
    // Return the modified (or maybe unmodified) menu items array
    return $items;
	}

	//  Remove junk from head, including the current Wordpress version number, which is a big security no-no.
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// 
	//   This is the start of the Leo Home Makeoover Special Options.
	//
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // Adding installation functions to the Wordpress Theme Customizer:
    function leohomemakeover_theme_customizer( $wp_customize ) {

    // Allows the site title and tagline t auto-refresh:
    $wp_customize->get_setting('blogname')->transport='postMessage';
    $wp_customize->get_setting('blogdescription')->transport='postMessage';
	$wp_customize->remove_section( 'title_tagline');

	// Create the different sections. (not including default Wordpress sections)

    $wp_customize->add_section( 'footer', array(
        'title' => __('Footer'), // The title of section
        'description' => __('Footer'), // The description of section
		'priority'       => 180,
    ) );

    $wp_customize->add_section( 'layout', array(
        'title' => __('Layout'), // The title of section
        'description' => __('Layout'), // The description of section
		'priority'       => 190,
    ) );
	
    $wp_customize->add_section( 'custom-css', array(
        'title' => __('Custom CSS'), // The title of section
        'description' => __('Custom CSS'), // The description of section
		'priority'       => 200,
    ) );

    // Adding installation functions to the Wordpress Theme Customizer:
    $wp_customize->add_section( 'google-analytics', array(
        'title' => __('Google Analytics'), // The title of section
        'description' => __('Google Analytics'), // The description of section
		'priority'       => 210,
    ) );

	// Remove the /// comment lines below to remove the Tagline field from the Title & Tagline section. Not recommended.
	/// $wp_customize->remove_control( 'blogdescription');


    //////////////////////////
    // Various Color Selectors
    //////////////////////////

    // Page Background Color Selector.
    $wp_customize->add_setting( 'leohomemakeover_color_bkg', array(
        'default' => '#ffffff',
        'type' => 'option',
        'sanitize_callback'    => 'sanitize_hex_color_no_hash',
        'sanitize_js_callback' => 'maybe_hash_hex_color',
		'transport' => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'leohomemakeover_color_bkg', array(
        'label'   => __('Page Background Color'),
        'section' => 'colors',
		'priority'       => 10,	
		'setting' => 'leohomemakeover_color_bkg',
    ) ) );


    // Main Link Color Selector.
    $wp_customize->add_setting( 'leohomemakeover_color_links', array(
        'default' => '#303030',
        'type' => 'option',
        'sanitize_callback'    => 'sanitize_hex_color_no_hash',
        'sanitize_js_callback' => 'maybe_hash_hex_color',
		'transport' => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'leohomemakeover_color_links', array(
        'label'   => __('Links Color'),
        'section' => 'colors',
		'priority'       => 20,
		'setting' => 'leohomemakeover_color_links'
    ) ) );
	
    // Main Link Hover Color Selector.
    $wp_customize->add_setting( 'leohomemakeover_color_linkshover', array(
        'default' => '#999999',
        'type' => 'option',
        'sanitize_callback'    => 'sanitize_hex_color_no_hash',
        'sanitize_js_callback' => 'maybe_hash_hex_color',
		'transport' => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'leohomemakeover_color_linkshover', array(
        'label'   => __('Links Hover Color'),
        'section' => 'colors',
		'priority'       => 30,
		'setting' => 'leohomemakeover_color_linkshover'
    ) ) );

    // Font Color Selector.
    $wp_customize->add_setting( 'leohomemakeover_color_fonts', array(
        'default' => '#000000',
        'type' => 'option',
        'sanitize_callback'    => 'sanitize_hex_color_no_hash',
        'sanitize_js_callback' => 'maybe_hash_hex_color',
		'transport' => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'leohomemakeover_color_fonts', array(
        'label'   => __('Site Font Color'),
        'section' => 'colors',
		'priority'       => 40,
		'setting' => 'leohomemakeover_color_fonts'
    ) ) );


    // H2 Color Selector.
    $wp_customize->add_setting( 'leohomemakeover_color_h2', array(
        'default' => '#333333',
        'type' => 'option',
        'sanitize_callback'    => 'sanitize_hex_color_no_hash',
        'sanitize_js_callback' => 'maybe_hash_hex_color',
		'transport' => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'leohomemakeover_color_h2', array(
        'label'   => __('H2 Font Color'),
        'section' => 'colors',
		'priority'       => 50,
		'setting' => 'leohomemakeover_color_h2'
    ) ) );
	
    // H3 H5 H6 Color Selector.
    $wp_customize->add_setting( 'leohomemakeover_color_h3', array(
        'default' => '#303030',
        'type' => 'option',
        'sanitize_callback'    => 'sanitize_hex_color_no_hash',
        'sanitize_js_callback' => 'maybe_hash_hex_color',
		'transport' => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'leohomemakeover_color_h3', array(
        'label'   => __('H3 Font Color'),
        'section' => 'colors',
		'priority'       => 60,
		'setting' => 'leohomemakeover_color_h3h5h6'
    ) ) );


	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // This creates the dropdown list of pages in the Theme Customizer and outputs the slug into the link instead of the page_ID.
	$list_pages = array();
	$list_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$list_pages[''] = __('Select a page:');
	foreach ($list_pages_obj as $page) {
		$list_pages[$page->post_name] = $page->post_title;
	}
	
    // Checkbox to toggle author website link/author posts page link.
	$wp_customize->add_setting( 'leohomemakeover_author_link', array(
        'default' => 0,
	) );

	$wp_customize->add_control( 'leohomemakeover_author_link', array(
        'label' => __('Link author to website. (Instead of author posts page)'),
        'type' => 'checkbox',
        'section' => 'nav',
		'priority'       => 200,
	) );

    // Checkbox to open author links in same/new window.
	$wp_customize->add_setting( 'leohomemakeover_extlink', array(
        'default' => 0,
	) );

	$wp_customize->add_control( 'leohomemakeover_extlink', array(
        'label' => __('Open author links in a new tab/window.'),
        'type' => 'checkbox',
        'section' => 'nav',
		'priority'       => 210,
	) );

	// Settings for section: LAYOUT	
	$wp_customize->add_setting( 'leohomemakeover_layout', array(
 	   'default' => 'left',
 	   'type' => 'option',
	   'transport' => 'postMessage',
	) );
 
	$wp_customize->add_control( 'leohomemakeover_layout', array(
	    'label' => __('Site Layout'),
	    'section' => 'layout',
        'type' => 'radio',
 	    'choices' => array(
 	       'left' => __('Default'),
      	   'center' => __('Centered'),
    	),
	) );

	// Settings for section: FOOTER
	
	$wp_customize->add_setting( 'leohomemakeover_credits', array(
 	   'default' => '&copy; Copyright 2013. Tigers will eat your face if you remove this.',
 	   'type' => 'option',
 	   'transport' => 'postMessage'
	) );
	$wp_customize->add_control( 'leohomemakeover_credits', array(
	    'label' => __('Footer Credits'),
	    'section' => 'footer'
	) );


	// Settings for section: CUSTOM CSS	
	
	/////////////////////////////////////////////////////////////////////////////////////
    // Adds a textfield option to the Theme Customizer. Allows for the Custom CSS option.
	class Example_Customize_Textarea_Control extends WP_Customize_Control {
   	 public $type = 'textarea';
 
  	  public function render_content() {
    	    ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
            </label>
        <?php
 	   }
	}

	$wp_customize->add_setting( 'leohomemakeover_custom_css', array(
	) );
 
	$wp_customize->add_control(new Example_Customize_Textarea_Control($wp_customize,'leohomemakeover_custom_css',array(
		'label' => __('Add any custom CSS you have here.'),
		'section' => 'custom-css',
		'type' => 'textarea',
		'settings' => 'leohomemakeover_custom_css',
		)
  	  )
	);


	// Settings for section: GOOGLE ANALYTICS		
	$wp_customize->add_setting( 'leohomemakeover_google_analytics', array(
        'default' => '',
	) );
 
	$wp_customize->add_control('leohomemakeover_google_analytics',array(
		'label' => __('Add your Google Analytics ID here. (Ex: UA-XXXXXXX-X)'),
		'section' => 'google-analytics',
		'type' => 'text',
		'settings' => 'leohomemakeover_google_analytics',
		)
 	);

    // The action below calls the contained live-editing javascript ONLY in the Theme Customizer.
	if ( $wp_customize->is_preview() && ! is_admin() ) {
		function leohomemakeover_customize_preview() {
 		   ?>
		    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/theme-customizer.js"></script>
		   <?php
		}  // End function leohomemakeover_customize_preview()
  	  add_action( 'wp_footer', 'leohomemakeover_customize_preview', 21);
	}
	
}

    // The below function outputs color/other styles from the Theme Customizer into the Wordpress header.


if (!is_admin()) {
	
	//Output the styles in the header.
	add_action('wp_head', 'leohomemakeover_custom_css');
	
	//begin leohomemakeover_custom_css()
	function leohomemakeover_custom_css() {
		
		$custom_css ='';
		
		/**custom css field**/
		if(get_option('leohomemakeover_color_bkg') != 'ffffff') {
			$custom_css .= 'body { background-color:#'.get_option('leohomemakeover_color_bkg').';}';
		}
		if(get_option('leohomemakeover_color_links') != '303030') {
			$custom_css .= 'a:link, a:visited, .menu-divider {color: #'.get_option('leohomemakeover_color_links').';}';
		}
		if(get_option('leohomemakeover_color_linkshover') != '999999') {
			$custom_css .= 'a:hover {color: #'.get_option('leohomemakeover_color_linkshover').';}';
		}
		if(get_option('leohomemakeover_color_fonts') != '000000') {
			$custom_css .= 'body { color:#'.get_option('leohomemakeover_color_fonts').';}';
		}
		if(get_option('leohomemakeover_color_h2') != '333333') {
			$custom_css .= 'h2 {color: #'.get_option('leohomemakeover_color_h2').';}';
		}
		if(get_option('leohomemakeover_color_h3') != '303030') {
			$custom_css .= 'h3, h5, h6 {color: #'.get_option('leohomemakeover_color_h3').';}';
		}
		if(get_theme_mod('leohomemakeover_custom_css') !='0') {
			$custom_css .= get_theme_mod('leohomemakeover_custom_css');
		}
		
		/** Displays all Custom CSS in header **/
		$css_output = "<!-- Custom CSS Styles -->\n<style type=\"text/css\">\n" . $custom_css . "\n</style>";
		if(!empty($custom_css)) { echo $css_output;}
		
	} //end leohomemakeover_custom_css()

} //end Custom CSS Header function.


add_action('wp_footer', 'ga');
 
function ga() {
 
    $account = get_theme_mod('leohomemakeover_google_analytics');
     
    $code = "<script type=\"text/javascript\"> 
      
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', '$account']);
      _gaq.push(['_trackPageview']);
      
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
      
    </script>"; 
     
    if (get_theme_mod('leohomemakeover_google_analytics') != '') echo $code;
 
}


    // The action below wraps up the Theme Customizer options.
	add_action( 'customize_register', 'leohomemakeover_theme_customizer', 11 );

?>