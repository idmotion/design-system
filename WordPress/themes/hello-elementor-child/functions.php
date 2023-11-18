<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

require_once get_stylesheet_directory() . '/inc/admin-ui.php';
require_once get_stylesheet_directory() . '/inc/custom-blocks.php';
require_once get_stylesheet_directory() . '/inc/processos.php';
require_once get_stylesheet_directory() . '/inc/frontend.php';

// Função para marcar ou desmarcar post como Lido
function toggle_read_status() {
    $post_id = $_POST['toggle_read_post_id'] ?? null;
    
    if (!$post_id || !is_user_logged_in()) {
        return;
    }
    
    $user_id = get_current_user_id();
    $read_status = get_user_meta($user_id, 'read_post_' . $post_id, true);
    
    if ($read_status === 'read') {
        update_user_meta($user_id, 'read_post_' . $post_id, 'unread');
    } else {
        update_user_meta($user_id, 'read_post_' . $post_id, 'read');
    }
    
    // Redirecionar para remover o parâmetro da URL
    wp_redirect(remove_query_arg('toggle_read'));
    exit;
}
add_action('init', 'toggle_read_status');

// Shortcode para mostrar o formulário ou status
function mark_or_unmark_as_read() {
    if (!is_user_logged_in()) {
        return;
    }
    
    $post_id = get_the_ID();
    $user_id = get_current_user_id();
    $read_status = get_user_meta($user_id, 'read_post_' . $post_id, true);
    
    if ($read_status === 'read') {
        $button_text = "Desmarcar leitura";
    } else {
        $button_text = "Marcar como lido";
    }
    
    return <<<EOT
        <form method="post">
            <input type="hidden" name="toggle_read_post_id" value="$post_id">
            <input type="submit" value="$button_text" class="read-status-button">
        </form>
EOT;
}
add_shortcode('mark_or_unmark_as_read', 'mark_or_unmark_as_read');



// Função para verificar se o post foi marcado como Lido
function is_read_func() {
    $user_id = get_current_user_id();
    $post_id = get_the_ID();
    if ($user_id) {
        $read_status = get_user_meta($user_id, 'read_post_' . $post_id, true);
        if ($read_status === 'read') {
            return 'Lido';
        } else {
            return '';
        }
    }
    return 'Você precisa estar logado para ver o status.';
}
add_shortcode('is_read', 'is_read_func');