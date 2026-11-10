<?php
if (!defined('ABSPATH')) {
    exit;
}

function bp_hero_global_menu() {
    add_submenu_page(
        'options-general.php',
        'Configuración de Hero Global',
        'Hero Global',
        'manage_options',
        'bp-hero-global',
        'bp_hero_global_settings_page_html'
    );
}
add_action('admin_menu', 'bp_hero_global_menu');

function bp_hero_global_settings_page_html() {
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_POST['bp_hero_submit']) && check_admin_referer('bp_hero_guardar_nonce', 'bp_hero_nonce_field')) {
        $texto_opcional = sanitize_text_field($_POST['bp_hero_texto']);
        $miniatura_id   = intval($_POST['bp_miniatura_id']);

        update_option('bp_hero_texto_opcional', $texto_opcional);
        update_option('bp_hero_miniatura_id', $miniatura_id);

        echo '<div class="notice notice-success is-dismissible"><p><strong>Cambios guardados correctamente.</strong></p></div>';
    }

    $texto_actual = get_option('bp_hero_texto_opcional', '');
    $att_id       = get_option('bp_hero_miniatura_id', '');

    $post = (object) ['ID' => 0];
    wp_enqueue_media();
    ?>
    <div class="wrap">
        <h1>Configuración de Hero (Páginas y Archivos)</h1>
        <form method="post" action="">
            <?php wp_nonce_field('bp_hero_guardar_nonce', 'bp_hero_nonce_field'); ?>

            <table class="form-table">
                <tr>
                    <th scope="row"><label for="bp_hero_texto">Texto Opcional</label></th>
                    <td>
                        <input type="text" name="bp_hero_texto" id="bp_hero_texto" value="<?php echo esc_attr($texto_actual); ?>" class="regular-text" placeholder="Ej. Subtítulo o texto descriptivo">
                        <p class="description">Este texto acompañará al título "Somos" en las páginas y archivos.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Miniatura / Multimedia</th>
                    <td>
                        <?php
                        include BP_PLUGIN_DIR . 'admin/views/miniatura.php';
                        ?>
                    </td>
                </tr>
            </table>

            <?php submit_button('Guardar cambios', 'primary', 'bp_hero_submit'); ?>
        </form>
    </div>
    <?php
}
