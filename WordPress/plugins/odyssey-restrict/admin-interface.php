<div class="wrap">
    <h2>Odyssey Restrict</h2>
    <h2 class="nav-tab-wrapper">
        <a href="#visao-geral" class="nav-tab nav-tab-active">Visão Geral</a>
        <a href="#categorias" class="nav-tab">Categorias</a>
        <a href="#tags" class="nav-tab">Tags</a>
        <a href="#paginas" class="nav-tab">Páginas</a>
        <a href="#posts" class="nav-tab">Posts</a>
        <a href="#configuracoes" class="nav-tab">Configurações</a>
    </h2>

    <form method="post" action="options.php">
        <?php settings_fields('odyssey_restrict_options'); ?>
        <?php do_settings_sections('odyssey_restrict'); ?>
		
		<div id="visao-geral" class="tab-content" style="display: block;">
            <!-- Conteúdo de visão geral aqui -->
			<?php
function odyssey_restrict_overview_content() {
    // Obter configurações do plugin
    $allowed_pages = (array) get_option('odyssey_restrict_allowed_pages', []);
    $allowed_posts = (array) get_option('odyssey_restrict_allowed_posts', []);
    $allowed_categories = (array) get_option('odyssey_restrict_allowed_categories', []);
    $allowed_tags = (array) get_option('odyssey_restrict_allowed_tags', []);

    // Contar total de páginas, posts, categorias e tags
    $total_pages = count(get_pages());
    $total_posts = count(get_posts(['post_type' => 'post']));
    $total_categories = count(get_categories());
    $total_tags = count(get_tags());

    // Contar itens públicos
    $public_pages = count(array_intersect($allowed_pages, array_column(get_pages(), 'ID')));
    $public_posts = count(array_intersect($allowed_posts, array_column(get_posts(['post_type' => 'post']), 'ID')));
    $public_categories = count(array_intersect($allowed_categories, array_column(get_categories(), 'term_id')));
    $public_tags = count(array_intersect($allowed_tags, array_column(get_tags(), 'term_id')));

    // Cálculo de itens privados
    $private_pages = $total_pages - $public_pages;
    $private_posts = $total_posts - $public_posts;
    $private_categories = $total_categories - $public_categories;
    $private_tags = $total_tags - $public_tags;
	
	// Calcular totais públicos e privados
    $total_public_items = $public_pages + $public_posts + $public_categories + $public_tags;
    $total_private_items = ($total_pages - $public_pages) + ($total_posts - $public_posts) + ($total_categories - $public_categories) + ($total_tags - $public_tags);

    // HTML da visão geral
    echo '<div class="wrap">';
    echo '<h3>Visão Geral do Odyssey Restrict</h3>';
	
	// Card para quantidade total de itens públicos vs. privados
    echo '<div class="card">';
    echo '<h3>Total de Itens: Públicos vs. Privados</h3>';
    echo "<p>Itens Públicos: $total_public_items</p>";
    echo "<p>Itens Privados: $total_private_items</p>";
    echo '</div>';

    // Card para quantidade total de itens públicos vs. privados
    echo '<div class="card">';
    echo '<h3>Total de Itens: Públicos vs. Privados</h3>';
    echo "<p>Páginas - Públicas: $public_pages, Privadas: $private_pages</p>";
    echo "<p>Posts - Públicos: $public_posts, Privados: $private_posts</p>";
    echo "<p>Categorias - Públicas: $public_categories, Privadas: $private_categories</p>";
    echo "<p>Tags - Públicas: $public_tags, Privadas: $private_tags</p>";
    echo '</div>';

    // Card para cada tipo (posts, categorias, tags, páginas)
    echo '<div class="card"><h3>Detalhamento por Tipo</h3>';
    echo "<p>Páginas Públicas: $public_pages</p>";
    echo "<p>Posts Públicos: $public_posts</p>";
    echo "<p>Categorias Públicas: $public_categories</p>";
    echo "<p>Tags Públicas: $public_tags</p>";
    echo '</div>';

    // Aviso sobre revisão das páginas públicas
    echo '<div class="alert">';
    echo '<p><strong>Aviso:</strong> Revise regularmente as páginas públicas para garantir a segurança empresarial.</p>';
    echo '</div>';

    echo '</div>';
}

// Chame essa função na sua interface de administração onde a aba de visão geral deve aparecer
odyssey_restrict_overview_content();

?>

        </div>

        <div id="categorias" class="tab-content">
            <!-- Conteúdo de categorias -->
            <?php
				function odyssey_restrict_category_cards() {
    // Obter categorias permitidas
    $allowed_categories = (array) get_option('odyssey_restrict_allowed_categories', []);

    // Obter todas as categorias
    $categories = get_categories();

    // HTML para os cards das categorias
    echo '<div class="wrap">';
    echo '<h2>Cards de Categorias</h2>';

    foreach ($categories as $category) {
        // Contar posts públicos na categoria
        $public_posts_count = count(get_posts([
            'post_type' => 'post',
            'category' => $category->term_id,
            'post_status' => 'publish',
            'include' => $allowed_categories
        ]));

        // Exibir card para a categoria
        echo '<div class="card">';
        echo '<h3>' . esc_html($category->name) . '</h3>';
        echo '<p>Posts Públicos: ' . $public_posts_count . '</p>';
        echo '</div>';
    }

    echo '</div>';
}

// Chame essa função na interface de administração onde os cards das categorias devem aparecer
	odyssey_restrict_category_cards();
			
                $allowed_categories = (array) get_option('odyssey_restrict_allowed_categories', []);
                $categories = get_categories();

                if (!empty($categories)) {
                    foreach ($categories as $category) {
                        $checked = in_array($category->term_id, $allowed_categories) ? 'checked' : '';
                        echo "<input type='checkbox' name='odyssey_restrict_allowed_categories[]' value='" . esc_attr($category->term_id) . "' {$checked}> " . esc_html($category->name) . "<br>";
                    }
                } else {
                    echo '<p>Nenhuma categoria disponível.</p>';
                }
            ?>
        </div>

        <div id="tags" class="tab-content" style="display: none;">
            <!-- Conteúdo de tags -->
            <?php
                $allowed_tags = (array) get_option('odyssey_restrict_allowed_tags', []);
                $tags = get_tags();

                if (!empty($tags)) {
                    foreach ($tags as $tag) {
                        $checked = in_array($tag->term_id, $allowed_tags) ? 'checked' : '';
                        echo "<input type='checkbox' name='odyssey_restrict_allowed_tags[]' value='" . esc_attr($tag->term_id) . "' {$checked}> " . esc_html($tag->name) . "<br>";
                    }
                } else {
                    echo '<p>Nenhuma tag disponível.</p>';
                }
            ?>
        </div>

        <div id="paginas" class="tab-content" style="display: none;">
            <!-- Conteúdo de páginas -->
            <?php
                $allowed_pages = (array) get_option('odyssey_restrict_allowed_pages', []);
                $pages = get_pages();

                if (!empty($pages)) {
                    foreach ($pages as $page) {
                        $checked = in_array($page->ID, $allowed_pages) ? 'checked' : '';
                        echo '<input type="checkbox" name="odyssey_restrict_allowed_pages[]" value="' . esc_attr($page->ID) . '" ' . $checked . ' />' . esc_html($page->post_title) . '<br>';
                    }
                } else {
                    echo '<p>Nenhuma página disponível.</p>';
                }
            ?>
        </div>

        <div id="posts" class="tab-content" style="display: none;">
            <!-- Conteúdo de posts -->
            <?php
                $allowed_posts = (array) get_option('odyssey_restrict_allowed_posts', []);
                $posts = get_posts();

                if (!empty($posts)) {
                    foreach ($posts as $post) {
                        $checked = in_array($post->ID, $allowed_posts) ? 'checked' : '';
                        echo '<input type="checkbox" name="odyssey_restrict_allowed_posts[]" value="' . esc_attr($post->ID) . '" ' . $checked . ' />' . esc_html($post->post_title) . '<br>';
                    }
                } else {
                    echo '<p>Nenhum post disponível.</p>';
                }
            ?>
        </div>

        <div id="configuracoes" class="tab-content" style="display: none;">
            <!-- Campo para configurações -->
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">URL da página de login personalizada</th>
                    <td>
                        <?php $login_page_slug = get_option('odyssey_restrict_login_page_slug', ''); ?>
                        <input type="text" id="odyssey_restrict_login_page_slug" name="odyssey_restrict_login_page_slug" value="<?php echo esc_attr($login_page_slug); ?>" />
                        <p class="description">A URL de login será <?php echo esc_url(home_url('/' . $login_page_slug)); ?>/. Ela se torna pública automaticamente.</p>
                    </td>
                </tr> 
            </table>
        </div>

        <?php submit_button('Salvar alterações', 'primary', 'submit_form'); ?>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var tabs = document.querySelectorAll('.nav-tab-wrapper a');
    var tabPanels = document.querySelectorAll('.tab-content');

    tabs.forEach(function(tab) {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove a classe 'nav-tab-active' de todas as abas e esconde todos os painéis
            tabs.forEach(function(t) {
                t.classList.remove('nav-tab-active');
            });
            tabPanels.forEach(function(panel) {
                panel.style.display = 'none';
            });

            // Adiciona a classe 'nav-tab-active' à aba clicada e mostra o painel correspondente
            this.classList.add('nav-tab-active');
            var activePanel = document.querySelector(this.getAttribute('href'));
            if (activePanel) {
                activePanel.style.display = 'block';
            }
        });
    });

    // Ativa a primeira aba por padrão
    if (tabs.length > 0) {
        tabs[0].click();
    }
});
</script>