<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_and_child_styles' );
function enqueue_parent_and_child_styles() {
    // Enfileira o estilo do tema pai
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );

    // Enfileira o estilo do tema filho
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri().'/style.css', array('parent-style') );
}

add_action( 'admin_head', function() {
// Add CSS code below.
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter+Tight&display=swap" rel="stylesheet">
<?php
	});

add_action( 'admin_enqueue_scripts', function() {
    wp_enqueue_style( 'custom-admin-styles', get_template_directory_uri() . '/admin-styles.css' );
});
