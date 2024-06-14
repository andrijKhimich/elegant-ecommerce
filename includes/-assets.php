<?php
function my_assets() {
	wp_deregister_script('jquery-core');
	// wp_register_script('jquery-core', get_stylesheet_directory_uri() . '/libs/js/jquery-3.5.0.min.js');
	// wp_enqueue_script('jquery');
	wp_enqueue_script('libs-js', get_template_directory_uri() . '/build/js/libs.min.js');
	wp_enqueue_script('main-js', get_template_directory_uri() . '/build/js/script.min.js');

	// wp_enqueue_style('splide-styles', get_template_directory_uri() . '/libs/css/splide.min.css');
	// wp_enqueue_style('main-style', get_template_directory_uri() . '/build/css/main.css');
	// wp_enqueue_script('ukiyo-js', get_stylesheet_directory_uri() . '/libs/js/ukiyo.min.js', true);
	// wp_enqueue_script('swiper-js', get_stylesheet_directory_uri() . '/libs/js/splide.min.js', true);
	// wp_enqueue_script('lenis-js', get_stylesheet_directory_uri() . '/libs/js/lenis.min.js', true);
	// wp_enqueue_script('gsap-js', get_stylesheet_directory_uri() . '/libs/js/gsap.min.js', true);
	// wp_enqueue_script('main-js', get_stylesheet_directory_uri() . '/build/js/main.js',  array('jquery'), '1.0', true);
	wp_enqueue_style('main-style', get_template_directory_uri() . '/build/css/style.min.css');

	if (is_single()) {
		// wp_enqueue_style('magnific-popup-styles', get_template_directory_uri() . '/libs/css/magnific-popup.min.css');
		// wp_enqueue_script('magnific-popup-js', get_stylesheet_directory_uri() . '/libs/js/magnific-popup.min.js', array('jquery'), true);
	}
	if (is_404()) {
		// wp_enqueue_style('404', get_template_directory_uri() . '/build/static/css/pages/page-404.css');
	}
}
add_action('wp_enqueue_scripts', 'my_assets');
add_action('admin_enqueue_scripts', 'load_admin_style');

function load_admin_style() {
	wp_enqueue_style('admin-style-css', get_template_directory_uri() . '/admin-style.css');
}
add_editor_style('admin-style.css');
