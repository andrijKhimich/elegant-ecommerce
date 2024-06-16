<?php
/**
 * Main functions PHP file for the theme.
 *
 * @category   Components
 * @package    WordPress
 * @since      1.0.0
 */

// Include necessary files.
require_once 'includes/-assets.php';
require_once 'includes/-custom-buttons-tinymce.php';

/**
 * Sets the save point for ACF JSON files.
 *
 * @return string Path to the ACF JSON save directory.
 */
function local_acf_json_save_point(): string {
	return get_stylesheet_directory() . '/acf';
}
add_filter( 'acf/settings/save_json', 'local_acf_json_save_point' );

/**
 * Sets the load point for ACF JSON files.
 *
 * @param array $paths Array of paths where ACF JSON files are loaded from.
 * @return array Modified array of paths.
 */
function my_acf_json_load_point( array $paths ): array {
	unset( $paths[0] );
	$paths[] = get_stylesheet_directory() . '/acf';
	return $paths;
}
add_filter( 'acf/settings/load_json', 'my_acf_json_load_point' );

/**
 * Adds support for SVG uploads.
 *
 * @param array $mime_types Current list of MIME types.
 * @return array Modified list of MIME types.
 */
function my_mime_types( array $mime_types ): array {
	$mime_types['svg'] = 'image/svg+xml';
	return $mime_types;
}
add_filter( 'upload_mimes', 'my_mime_types', 1, 1 );

/**
 * Adds various theme supports.
 */
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'menus' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );
}

/**
 * Registers navigation menus.
 *
 * @return void
 */
function site_features(): void {
	register_nav_menu( 'Header menu', 'Header menu' );
	register_nav_menu( 'Sitemap menu', 'Sitemap menu' );
	register_nav_menu( 'What we do menu', 'What we do menu' );
	register_nav_menu( 'Legal menu', 'Legal menu' );
}
add_action( 'after_setup_theme', 'site_features' );

// Add custom image size.
add_image_size( 'full_hd', 1920, 1080 );

/**
 * De registers certain styles.
 *
 * @return void
 */
function wps_deregister_styles() {
	wp_deregister_style( 'contact-form-7' );
	wp_deregister_style( 'wp-block-library' );
	wp_deregister_style( 'wp-block-library-theme' );
	wp_deregister_style( 'wc-block-style' );
}
add_action( 'wp_print_styles', 'wps_deregister_styles', 100 );

// Disable automatic paragraph tags in Contact Form 7.
add_filter( 'wpcf7_autop_or_not', '__return_false' );

/**
 * Changes the class on the custom logo in the header.php
 *
 * @param string $html the class.
 * @return string
 */
function change_logo_class( $html ) {
	$html = str_replace( 'custom-logo-link', 'logo', $html );
	return $html;
}
add_filter( 'get_custom_logo', 'change_logo_class', 10 );
