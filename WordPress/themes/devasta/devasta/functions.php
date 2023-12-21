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

add_action( 'admin_head', function() {
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight&display=swap" rel="stylesheet">
    <?php
        });

add_action( 'admin_enqueue_scripts', function() {
    wp_enqueue_style( 'custom-admin-styles', get_stylesheet_directory_uri() . '/admin-styles.css' );
});

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

function devasta_update($transient) {
    if (empty($transient->checked)) {
        return $transient;
    }

    $theme_slug = get_stylesheet();
    $api_url = 'https://updates.idmotion.com.br/devasta/devasta-update-api.php';
    $response = wp_remote_get($api_url);

    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) != 200) {
        return $transient;
    }

    $api_response = json_decode(wp_remote_retrieve_body($response));

    if (version_compare($transient->checked[$theme_slug], $api_response->version, '<')) {
        $transient->response[$theme_slug] = [
            'new_version' => $api_response->version,
            'package'     => $api_response->download_url,
            'url'         => 'Informação da URL do tema'
        ];
    }

    return $transient;
}
add_filter('pre_set_site_transient_update_themes', 'devasta_update');