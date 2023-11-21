<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

require_once get_stylesheet_directory() . '/inc/admin-ui.php';
require_once get_stylesheet_directory() . '/inc/custom-blocks.php';
require_once get_stylesheet_directory() . '/inc/processos.php';
require_once get_stylesheet_directory() . '/inc/frontend.php';

function my_theme_styles() {
  $styles = glob(get_stylesheet_directory() . '/styles/*.css');
  foreach ($styles as $style) {
    wp_enqueue_style(basename($style), get_stylesheet_directory_uri() . '/' . basename($style));
  }
}

add_action('wp_enqueue_scripts', 'my_theme_styles');
