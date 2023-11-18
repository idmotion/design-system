<div class="wrap">
    <h2>Odyssey Restrict Settings</h2>
    <form method="post" action="options.php">
        <?php
            settings_fields('odyssey_restrict_options');
            do_settings_sections('odyssey_restrict');
        ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Allow Homepage</th>
                <td><input type="checkbox" name="odyssey_restrict_allow_home" value="yes" <?php checked('yes', get_option('odyssey_restrict_allow_home', 'no')); ?> /></td>
            </tr>
            <tr valign="top">
                <th scope="row">Allowed Pages</th>
                <td>
                    <?php
                        $allowed_pages = get_option('odyssey_restrict_allowed_pages', []);
                        $pages = get_pages();
                        $posts = get_posts();

                        foreach ($pages as $page) {
                            echo '<input type="checkbox" name="odyssey_restrict_allowed_pages[]" value="' . $page->ID . '" ' . (in_array($page->ID, $allowed_pages) ? 'checked' : '') . ' />' . $page->post_title . '<br>';
                        }

                        foreach ($posts as $post) {
                            echo '<input type="checkbox" name="odyssey_restrict_allowed_pages[]" value="' . $post->ID . '" ' . (in_array($post->ID, $allowed_pages) ? 'checked' : '') . ' />' . $post->post_title . '<br>';
                        }
                    ?>
                </td>
            </tr>
        </table>
        <input type="submit" class="button-primary" value="Save Changes" />
    </form>
    <form method="post">
        <input type="submit" name="reset_odyssey_restrict_settings" class="button" value="Corrigir Configurações" />
    </form>
</div>
