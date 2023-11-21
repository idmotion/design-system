<div class="wrap">
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
                        $allowed_pages = get_option('odyssey_restrict_allowed_pages', []);
                        $pages = get_pages();

                        foreach ($pages as $page) {
                            echo '<input type="checkbox" name="odyssey_restrict_allowed_pages[]" value="' . $page->ID . '" ' . (in_array($page->ID, $allowed_pages) ? 'checked' : '') . ' />' . $page->post_title . '<br>';
                        }
                    ?>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Posts públicos</th>
                <td>
                    <?php
                        $allowed_posts = get_option('odyssey_restrict_allowed_posts', []);
                        $posts = get_posts();

                        foreach ($posts as $post) {
                            echo '<input type="checkbox" name="odyssey_restrict_allowed_posts[]" value="' . $post->ID . '" ' . (in_array($post->ID, $allowed_posts) ? 'checked' : '') . ' />' . $post->post_title . '<br>';
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
                        foreach ($categories as $category) {
                            $checked = in_array($category->term_id, $allowed_categories) ? 'checked' : '';
                            echo "<input type='checkbox' name='odyssey_restrict_allowed_categories[]' value='{$category->term_id}' {$checked}> {$category->name}<br>";
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
                        foreach ($tags as $tag) {
                            $checked = in_array($tag->term_id, $allowed_tags) ? 'checked' : '';
                            echo "<input type='checkbox' name='odyssey_restrict_allowed_tags[]' value='{$tag->term_id}' {$checked}> {$tag->name}<br>";
                        }
                    ?>
                </td>
            </tr>
			
        </table>
        <input type="submit" class="button-primary" value="Salvar alterações" />
    </form>
    <form method="post">
        <input type="submit" name="reset_odyssey_restrict_settings" class="button" value="Corrigir configurações" />
    </form>
</div>
