<div class="wrap">
    <h2>Odyssey Restrict</h2>
    <form method="post" action="options.php">
        <?php
            settings_fields('odyssey_restrict_options');
            do_settings_sections('odyssey_restrict');
        ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Tornar a página inicial pública</th>
                <td><input type="checkbox" name="odyssey_restrict_allow_home" value="yes" <?php checked('yes', get_option('odyssey_restrict_allow_home', 'no')); ?> /></td>
            </tr>
            <tr valign="top">
                <th scope="row">Páginas públicas</th>
                <td>
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
                </td>
            </tr>
            <tr valign="top">
    <th scope="row">Posts públicos</th>
    <td>
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
    </td>
</tr>

			
			<!-- Campo para categorias permitidas -->
            <tr valign="top">
    <th scope="row">Categorias públicas</th>
    <td>
        <?php
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
    </td>
</tr>


            <!-- Campo para tags permitidas -->
            <tr valign="top">
    <th scope="row">Tags públicas</th>
    <td>
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
    </td>
</tr>

			
			<tr valign="top">
    <th scope="row">URL da página de login personalizada</th>
    <td>
		<?php
		$login_page_slug = get_option('odyssey_restrict_login_page_slug', '');
		?>
		<input type="text" id="odyssey_restrict_login_page_slug" name="odyssey_restrict_login_page_slug" value="<?php echo esc_attr($login_page_slug); ?>" />
        <p class="description">A URL de login será <?php echo esc_url(home_url('/' . $login_page_slug)); ?>/. Ela se torna pública automaticamente.</p>
    </td>
</tr>	
        </table>
        <?php submit_button('Salvar alterações', 'primary', 'submit_form'); ?>
    </form>
</div>