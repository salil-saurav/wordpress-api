<?php
// Remove WP Bloat
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
remove_action('wp_head', 'rsd_link'); //removes EditURI/RSD (Really Simple Discovery) link.
remove_action('wp_head', 'wlwmanifest_link'); //removes wlwmanifest (Windows Live Writer) link.
remove_action('wp_head', 'wp_generator'); //removes meta name generator.
remove_action('wp_head', 'wp_shortlink_wp_head'); //removes shortlink.
remove_action( 'wp_head', 'feed_links', 2 ); //removes feed links.
remove_action('wp_head', 'feed_links_extra', 3 );  //removes comments feed.
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );
remove_action('rest_api_init', 'wp_oembed_register_route');
remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
remove_action( 'wp_head', 'wp_resource_hints', 2 );

function remove_api () {
	remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
	remove_action('template_redirect', 'rest_output_link_header', 11);
}
add_action( 'after_setup_theme', 'remove_api' );

// Disables Pesky Emojis
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

// Disables Embeds
function deregister_embed_scripts() {
	wp_dequeue_script( 'wp-embed' );
	wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_print_scripts', 'deregister_embed_scripts' );

//Remove print styles
function deregister_print_styles() {
	wp_dequeue_style( 'twenty-twenty-one-print-style' );
	wp_deregister_style( 'twenty-twenty-one-print-style' );
}
add_action( 'wp_print_styles', 'deregister_print_styles', 100 );

//Remove customizer css
function deregister_color_overrides() {
	wp_dequeue_style( 'twenty-twenty-one-custom-color-overrides' );
	wp_deregister_style( 'twenty-twenty-one-custom-color-overrides' );
}
add_action( 'wp_print_styles', 'deregister_color_overrides', 100 );

//Remove the gutenberg styles
function deregister_gutenberg_styles() {
	wp_dequeue_style( 'wp-block-library' );
	wp_deregister_style( 'wp-block-library' );
}

add_action( 'wp_print_styles', 'deregister_gutenberg_styles', 100 );

// Disables Embeds
function remove_jquery() {
	wp_dequeue_script( 'jquery-core' );
	wp_deregister_script( 'jquery-core' );
	wp_dequeue_script( 'jquery-migrate' );
	wp_deregister_script( 'jquery-migrate' );
}
add_action( 'wp_print_scripts', 'remove_jquery' );

// Remove page comments
function remove_page_comments() {
    remove_post_type_support( 'page', 'comments' );
}
add_action( 'init', 'remove_page_comments' );

// Remove default editor from pages
function remove_page_default_editor() {
    remove_post_type_support( 'page', 'editor' );
}
add_action( 'init', 'remove_page_default_editor' );

// Remove trackbacks
function remove_page_trackbacks() {
    remove_post_type_support( 'page', 'trackbacks' );
}
add_action( 'init', 'remove_page_trackbacks' );

// Remove excerpt
function remove_page_excerpt() {
    remove_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'remove_page_excerpt' );

// Remove featured image for home page

function remove_page_featured_image() {
	remove_post_type_support( 'page', 'thumbnail' );
}
if ( is_home() ) {
	add_action( 'init', 'remove_page_featured_image' );
}

