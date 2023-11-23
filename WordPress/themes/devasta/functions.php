<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_and_child_styles' );
function enqueue_parent_and_child_styles() {
    // Enfileira o estilo do tema pai
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );

    // Enfileira o estilo do tema filho
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri().'/style.css', array('parent-style') );
}

function load_inc_directory() {
    $path = get_stylesheet_directory() . '/inc/*.php';
    $files = glob($path);

    if ($files !== false) {
        foreach ($files as $file) {
            require_once $file;
        }
    }
}

add_action('wp_loaded', 'load_inc_directory');

function my_additional_styles() {
    // Enfileira estilos da pasta /styles/
    $styles = glob(get_stylesheet_directory() . '/styles/*.css');
    foreach ($styles as $style) {
        wp_enqueue_style(basename($style), get_stylesheet_directory_uri() . '/styles/' . basename($style));
    }

    // Enfileira estilos da pasta raiz
    if (file_exists(get_stylesheet_directory() . '/comments.css')) {
        wp_enqueue_style('comments-style', get_stylesheet_directory_uri() . '/comments.css');
    }
}

add_action('wp_enqueue_scripts', 'my_additional_styles');