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

function check_theme_update() {
    $api_url = 'https://updates.idmotion.com.br/devasta/devasta-update-api.php';
    $response = wp_remote_get($api_url);

    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) != 200) {
        return; // Falha na obtenção da resposta da API
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);

    if (version_compare(wp_get_theme()->get('Version'), $data->version, '<')) {
        // Configurações para a atualização
        global $wp_filter;
        $wp_filter['upgrader_package_options'][10]['theme_update'] = function($options) use ($data) {
            if ($options['hook_extra']['theme'] == get_template()) {
                $options['package'] = $data->download_url;
            }
            return $options;
        };
    }
}
add_action('admin_init', 'check_theme_update');