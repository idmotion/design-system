<?php
// Botão de editar página
function editar_botao_shortcode() {
    if ( current_user_can( 'edit_pages' ) ) {
        global $post;
        $editar_url = get_admin_url() . 'post.php?post=' . $post->ID . '&action=edit';
        return $editar_url;
    }
    return '';
}
add_shortcode( 'editar_botao', 'editar_botao_shortcode' );

// Adicionar conteúdo padrão de processos em novos posts criados
function adicionar_estrutura_post( $post_id, $post, $update ) {
    // Verifica se é um novo post, se é do tipo "post" e se não é uma cópia
    if ( $update || 'post' !== $post->post_type || false !== strpos( $post->post_title, '(Cópia)' ) ) {
        return;
    }

    // Define a estrutura de elementos como blocos
    $estrutura = '<!-- wp:heading {"level":2} -->
    <h2 class="wp-block-heading">POP</h2>
    <!-- /wp:heading -->

    <!-- wp:heading {"level":3} -->
    <h3 class="wp-block-heading">Requisitos</h3>
    <!-- /wp:heading -->

    <!-- wp:list -->
    <ul><li>Descreva os materiais necessários.</li></ul>
    <!-- /wp:list -->

    <!-- wp:heading {"level":3} -->
    <h3 class="wp-block-heading">Procedimentos</h3>
    <!-- /wp:heading -->

    <!-- wp:list {"ordered":true} -->
    <ol><li>Descreva os procedimentos a serem seguidos.</li></ol>
    <!-- /wp:list -->

    <!-- wp:heading {"level":3} -->
    <h3 class="wp-block-heading">Resultados</h3>
    <!-- /wp:heading -->

    <!-- wp:list -->
    <ul><li>Descreva os resultados esperados.</li></ul>
    <!-- /wp:list -->';

    // Atualiza o conteúdo do post
    $post->post_content = $estrutura;
    wp_update_post( $post );
}
add_action( 'wp_insert_post', 'adicionar_estrutura_post', 10, 3 );

// Shortcodes de contagem para tags
// Total de posts
function total_posts_count_shortcode() {
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => -1
    );

    $query = new WP_Query($args);
    $count = $query->found_posts;
    return $count;
}
add_shortcode('total_posts_count', 'total_posts_count_shortcode');

// Total de itens na tag Processo
function count_processo_items_shortcode() {
    $args = array(
        'tax_query' => array(
            array(
                'taxonomy' => 'post_tag',
                'field' => 'slug',
                'terms' => 'processo'
            )
        ),
        'posts_per_page' => -1
    );

    $query = new WP_Query($args);
    $count = $query->found_posts;

    return $count;
}
add_shortcode('count_processo_items', 'count_processo_items_shortcode');

// Total de itens na tag Material
function count_material_items_shortcode() {
    $args = array(
        'tax_query' => array(
            array(
                'taxonomy' => 'post_tag',
                'field' => 'slug',
                'terms' => 'material'
            )
        ),
        'posts_per_page' => -1
    );

    $query = new WP_Query($args);
    $count = $query->found_posts;

    return $count;
}
add_shortcode('count_material_items', 'count_material_items_shortcode');

// Total de itens na tag Anotação
function count_anotacao_items_shortcode() {
    $args = array(
        'tax_query' => array(
            array(
                'taxonomy' => 'post_tag',
                'field' => 'slug',
                'terms' => 'anotacao'
            )
        ),
        'posts_per_page' => -1
    );

    $query = new WP_Query($args);
    $count = $query->found_posts;

    return $count;
}
add_shortcode('count_anotacao_items', 'count_anotacao_items_shortcode');

// Total de itens na tag Conteúdo
function count_conteudo_items_shortcode() {
    $args = array(
        'tax_query' => array(
            array(
                'taxonomy' => 'post_tag',
                'field' => 'slug',
                'terms' => 'conteudo'
            )
        ),
        'posts_per_page' => -1
    );

    $query = new WP_Query($args);
    $count = $query->found_posts;

    return $count;
}
add_shortcode('count_conteudo_items', 'count_conteudo_items_shortcode');

// Contador de versões do post
function increment_update_count( $post_id ) {
    // Verifica se um transiente já foi definido para esta requisição para evitar contagens duplicadas
    if ( ! get_transient( 'updated_post_' . $post_id ) ) {
        
        $current_count = get_post_meta( $post_id, '_update_count', true );

        if ( $current_count ) {
            $new_count = $current_count + 1;
            update_post_meta( $post_id, '_update_count', $new_count );
        } else {
            update_post_meta( $post_id, '_update_count', 1 );
        }
        
        // Define um transiente para evitar contagens duplicadas em curto espaço de tempo
        set_transient( 'updated_post_' . $post_id, true, 10 );
    }
}

add_action( 'publish_post', 'increment_update_count' );


// Shortcode para exibir a contagem de atualizações
function update_count_shortcode() {
    $post_id = get_the_ID();
    $update_count = get_post_meta( $post_id, '_update_count', true );
    return $update_count ? $update_count : ' ';
}
add_shortcode( 'update_count', 'update_count_shortcode' );

// Contador de Tempo da Última Atualização
// Função para converter a data de última atualização em uma leitura amigável
function human_readable_last_updated() {
    $post_id = get_the_ID();
    $updated_time = get_the_modified_time('U', $post_id);
    $current_time = current_time('U');
    $time_diff = $current_time - $updated_time;

    if ( $time_diff < MINUTE_IN_SECONDS ) {
        $time_ago = sprintf( _n( '%s segundo atrás', '%s segundos atrás', $time_diff, 'text-domain' ), $time_diff );
    } elseif ( $time_diff < HOUR_IN_SECONDS ) {
        $minutes = round( $time_diff / MINUTE_IN_SECONDS );
        $time_ago = sprintf( _n( '%s minuto atrás', '%s minutos atrás', $minutes, 'text-domain' ), $minutes );
    } elseif ( $time_diff < DAY_IN_SECONDS ) {
        $hours = round( $time_diff / HOUR_IN_SECONDS );
        $time_ago = sprintf( _n( '%s hora atrás', '%s horas atrás', $hours, 'text-domain' ), $hours );
    } elseif ( $time_diff < WEEK_IN_SECONDS ) {
        $days = round( $time_diff / DAY_IN_SECONDS );
        $time_ago = sprintf( _n( '%s dia atrás', '%s dias atrás', $days, 'text-domain' ), $days );
    } elseif ( $time_diff < MONTH_IN_SECONDS ) {
        $weeks = round( $time_diff / WEEK_IN_SECONDS );
        $time_ago = sprintf( _n( '%s semana atrás', '%s semanas atrás', $weeks, 'text-domain' ), $weeks );
    } else {
        $months = round( $time_diff / MONTH_IN_SECONDS );
        $time_ago = sprintf( _n( '%s mês atrás', '%s meses atrás', $months, 'text-domain' ), $months );
    }

    return $time_ago;
}

// Shortcode para exibir o tempo desde a última atualização
function last_updated_shortcode() {
    return human_readable_last_updated();
}
add_shortcode( 'last_updated', 'last_updated_shortcode' );

// Função para verificar se post precisa de revisão após 1 ano da última atualização
function atualiza_lista_revisao() {
  $query_args = [
    'posts_per_page' => -1, // Obter todos os posts
    'post_type'      => 'post', // Ou seu tipo de post personalizado, se aplicável
    'fields'         => 'ids', // Obter apenas os IDs para economizar memória
    'date_query'     => [
      [
        'before' => '1 year ago', // Posts mais antigos que um ano
      ],
    ],
  ];

  $posts_antigos = get_posts($query_args);
  
  // Armazena a lista de IDs que precisam da flag
  update_option('posts_necessitam_revisao', $posts_antigos);
}

// Agendar a tarefa cron se ela ainda não estiver agendada
if (!wp_next_scheduled('atualiza_lista_revisao_hook')) {
  wp_schedule_event(time(), 'daily', 'atualiza_lista_revisao_hook');
}

// Adicionar a ação que vincula o hook ao evento
add_action('atualiza_lista_revisao_hook', 'atualiza_lista_revisao');

function deve_mostrar_aviso($post_id) {
    $posts_necessitam_revisao = get_option('posts_necessitam_revisao', []);
    return in_array($post_id, $posts_necessitam_revisao);
}

function aviso_revisao_shortcode() {
    global $post;

    if (deve_mostrar_aviso($post->ID)) {
        return 'mostrar-aviso';
    }

    return '';
}

add_shortcode('aviso_revisao', 'aviso_revisao_shortcode');