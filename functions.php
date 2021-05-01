<?php

require_once(get_theme_file_path('inc/tgm.php'));
require_once(get_theme_file_path('inc/attachments.php'));
require_once(get_theme_file_path('widgets/social-icons-widget.php'));

if (site_url() == "http://demo.lwhh.com") {
    define("VERSION", time());
}else{
    define("VERSION",wp_get_theme()->get("Version"));
}

/**
 * after setup theme.
 */

 function philosophy_after_setup_theme(){
 	load_theme_textdomain('philosophy');
 	add_theme_support( 'post-thumbnails' );
 	add_theme_support('title-tag');
 	add_theme_support( 
 		'html5', 
 		array( 
 			'comment-list', 
 			'comment-form', 
 			'search-form', 
 			'gallery', 
 			'caption', 
 			'style', 
 			'script', 
 		) 
 	);

 	add_theme_support(
			'post-formats',
			array(
				'link',
				'gallery',
				'image',
				'quote',				
				'video',
				'audio',			
			)
		);
 	add_editor_style("/assets/css/editor-style.css");

 	register_nav_menu("topmenu", __("Top Menu", "philosophy"));

    register_nav_menus(array(
        "footer_left" => __("Footer Left Menu","philosophy"),
        "footer_middle" => __("Footer Middle Menu","philosophy"),
        "footer_right" => __("Footer Right Menu","philosophy")
    ));

 	add_image_size( "philosophy-home-square", 400, 400, true);
 }

 add_action( 'after_setup_theme', 'philosophy_after_setup_theme');

/**
 * Enqueue scripts and styles.
 */

 function philosophy_assets() {
 	wp_enqueue_style( 'fontawesome-css', get_theme_file_uri('/assets/css/font-awesome/css/font-awesome.min.css'), null, '1.0' );
 	wp_enqueue_style( 'fonts-css', get_theme_file_uri('/assets/css/fonts.css'), null, '1.0' );
 	wp_enqueue_style( 'base-css', get_theme_file_uri('/assets/css/base.css'), null, '1.0' );
 	wp_enqueue_style( 'vendor-css', get_theme_file_uri('/assets/css/vendor.css'), null, '1.0' );
 	wp_enqueue_style( 'main-css', get_theme_file_uri('/assets/css/main.css'), null, '1.0' );
 	wp_enqueue_style('philosophy-style-css', get_stylesheet_uri(),null, VERSION);

 	wp_enqueue_script('modernizr-js', get_theme_file_uri('/assets/js/modernizr.js'), '1.0');
 	wp_enqueue_script('pace-min-js', get_theme_file_uri('/assets/js/pace.min.js'), '1.0');
 	wp_enqueue_script('plugins-js', get_theme_file_uri('/assets/js/plugins.js'), array('jquery'), '1.0',true);
 	wp_enqueue_script('main-js', get_theme_file_uri('/assets/js/main.js'), array('jquery'), '1.0',true);
 }

add_action('wp_enqueue_scripts', 'philosophy_assets');


function philosophy_pagination(){
	global $wp_query;
	$links = paginate_links( array(
		'current'	=> max(1,get_query_var('paged')),
		'total' 	=> $wp_query->max_num_pages,
		'type'		=> 'list',
		'mid-size' 	=> 3
	) );
	$links = str_replace("page-numbers","pgn__num",$links);
	$links = str_replace("<ul class='pgn__num'>","<ul>",$links);
	$links = str_replace("next pgn__num","pgn__next",$links);
	$links = str_replace("prev pgn__num","pgn__prev",$links);
	echo $links;
}
 
 remove_action("term_description","wpautop");


function philosophy_widgets(){
	register_sidebar( array(
        'name'          => __( 'About Us Page', 'philosophy' ),
        'id'            => 'about-us',
        'description'   => __( 'Widgets in this area will be shown on all posts and pages.', 'philosophy' ),
        'before_widget' => '<div id="%1$s" class="col-block %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="quarter-top-margin">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Contact Page Map Section', 'philosophy' ),
        'id'            => 'cantact-maps',
        'description'   => __( 'Widgets in this area will be shown on all contact page.', 'philosophy' ),
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ) );

    register_sidebar( array(
        'name'          => __( 'Contact Page info', 'philosophy' ),
        'id'            => 'cantact-info',
        'description'   => __( 'Widgets in this area will be shown on all contact page.', 'philosophy' ),
        'before_widget' => '<div id="%1$s" class="col-block %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="quarter-top-margin">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Before Footer Section', 'philosophy' ),
        'id'            => 'before_footer_section',
        'description'   => __( 'footer section right site', 'philosophy' ),
        'before_widget' => '<div id="%1$s" "%2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 ">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer Section', 'philosophy' ),
        'id'            => 'footer_right',
        'description'   => __( 'footer section right site', 'philosophy' ),
        'before_widget' => '<div id="%1$s" "%2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer Bottom Section', 'philosophy' ),
        'id'            => 'footer-bottom',
        'description'   => __( 'footer bottom section', 'philosophy' ),
        'before_widget' => '<div id="%1$s" "%2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ) );
}
add_action("widgets_init", "philosophy_widgets");

function philosophy_search_form($form){
    $homedir = home_url("/");
    $label = __("Search for:","philosophy");
    $button_label = __("Search","philosophy");
    $newform =<<<FORM
    <form role="search" method="get" class="header__search-form" action="{$homedir}">
        <label>
            <span class="hide-content">{$label}</span>
            <input type="search" class="search-field" placeholder="Type Keywords" value="" name="s" title="{$label}" autocomplete="off">
        </label>
        <input type="submit" class="search-submit" value="{$button_label}">
    </form>;
    FORM;
    return $newform;
}
add_filter( 'get_search_form', 'philosophy_search_form' );
