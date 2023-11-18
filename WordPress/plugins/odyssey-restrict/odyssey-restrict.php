<?php
/**
 * Plugin Name: Odyssey Restrict
 * Description: Restricts content to logged-in users.
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
    register_setting('odyssey_restrict_options', 'odyssey_restrict_allow_home');
}

// Action for adding admin menu
function odyssey_restrict_menu() {
    add_menu_page('Odyssey Restrict Settings', 'Odyssey Restrict', 'manage_options', 'odyssey_restrict', 'odyssey_restrict_page');
}

// Function to display admin interface
function odyssey_restrict_page() {
    // Check if reset button is clicked and then reset the settings
    if (isset($_POST['reset_odyssey_restrict_settings'])) {
        update_option('odyssey_restrict_allowed_pages', []);
        update_option('odyssey_restrict_allow_home', 'no');
    }
    
    // Automatically correct the 'odyssey_restrict_allowed_pages' option if it's not an array
    $allowed_pages = get_option('odyssey_restrict_allowed_pages');
    if (!is_array($allowed_pages)) {
        update_option('odyssey_restrict_allowed_pages', []);
    }

    include plugin_dir_path(__FILE__) . 'admin-interface.php';
}

// Redirect function
function odyssey_restrict_redirect() {
    $allowed_pages = get_option('odyssey_restrict_allowed_pages', []);
    if (!is_array($allowed_pages)) {
        $allowed_pages = [];
    }
    $allow_home = get_option('odyssey_restrict_allow_home', 'no');

    if (!is_user_logged_in()) {
        if (is_home() && $allow_home === 'yes') {
            return;
        }
        if (is_single() || is_page() || is_post()) {
            global $post;
            if (in_array($post->ID, $allowed_pages)) {
                return;
            }
        }
        auth_redirect();
    }
}