<?php
/**
 * Plugin Name: Odyssey Restrict
 * Description: Torne seu conteúdo exclusivo para usuários logados. Proteção poderosa em apenas um clique. Use agora!
 * Author: Idmotion.com.br
 * Version: 1.17.9
 * Author URI: https://idmotion.com.br/?utm_source=wp-plugins&utm_campaign=author-uri&utm_medium=wp-dash
 */

// Hook for adding admin menus
add_action('admin_menu', 'odyssey_restrict_menu');

// Register settings
add_action('admin_init', 'odyssey_restrict_settings');

// Hook to redirect if not logged in
add_action('template_redirect', 'odyssey_restrict_redirect');

// Function to register settings
function odyssey_restrict_settings() {
    register_setting('odyssey_restrict_options', 'odyssey_restrict_allowed_pages');
    register_setting('odyssey_restrict_options', 'odyssey_restrict_allowed_posts');
    register_setting('odyssey_restrict_options', 'odyssey_restrict_allow_home');
	register_setting('odyssey_restrict_options', 'odyssey_restrict_allowed_categories');
    register_setting('odyssey_restrict_options', 'odyssey_restrict_allowed_tags');
	register_setting('odyssey_restrict_options', 'odyssey_restrict_login_page_slug');
}

// Action for adding admin menu
function odyssey_restrict_menu() {
    add_menu_page('Configurações do Odyssey Restrict', 'Odyssey Restrict', 'manage_options', 'odyssey_restrict', 'odyssey_restrict_page');
}

// Function to display admin interface
function odyssey_restrict_page() {
    include plugin_dir_path(__FILE__) . 'admin-interface.php';
}

// Redirect function
function odyssey_restrict_redirect() {
    // Identifique o slug da página de login
    $login_page_slug = get_option('odyssey_restrict_login_page_slug', 'login');

    // Verifica se a página atual é a página de login
    if (is_page($login_page_slug)) {
        return;
    }
    
    $allowed_pages = (array) get_option('odyssey_restrict_allowed_pages', []);
    $allowed_posts = (array) get_option('odyssey_restrict_allowed_posts', []);
    $allowed_categories = (array) get_option('odyssey_restrict_allowed_categories', []);
    $allowed_tags = (array) get_option('odyssey_restrict_allowed_tags', []);
    $allow_home = get_option('odyssey_restrict_allow_home', 'no');

    if (!is_user_logged_in()) {
        // Verificar a página inicial
        if ((is_home() || is_front_page()) && $allow_home === 'yes') {
    return;
}

        // Verificar páginas e posts individuais
        if (is_single() || is_page()) {
        global $post;
        // Verifique se a página ou o post está permitido.
        if (in_array($post->ID, $allowed_pages) || in_array($post->ID, $allowed_posts)) {
            return;
        }

        // Verifique se o post pertence a alguma categoria permitida.
        $post_categories = wp_get_post_categories($post->ID);
if (!is_wp_error($post_categories) && array_intersect($post_categories, $allowed_categories)) {
    return;
}
		
		// Verifique se o post tem alguma tag permitida.
        $post_tags = wp_get_post_tags($post->ID, array('fields' => 'ids'));
        if (!empty($post_tags) && array_intersect($post_tags, $allowed_tags)) {
            return;
        }
    }

        // Verificar categorias
        if (is_category()) {
            $queried_object_id = get_queried_object_id();
            if (in_array($queried_object_id, $allowed_categories)) {
                return;
            }
        }

        // Verificar tags
        if (is_tag()) {
            $queried_object_id = get_queried_object_id();
            if (in_array($queried_object_id, $allowed_tags)) {
                return;
            }
        }

        // Redirecionamento para a página de login
        $login_page_url = home_url('/' . $login_page_slug); 
        wp_redirect($login_page_url);
        exit;
    }
}