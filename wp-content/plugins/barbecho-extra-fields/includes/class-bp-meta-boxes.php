<?php
if (!defined('ABSPATH')) {
    exit;
}

function bp_custom_repeater_meta_boxes() {
    add_meta_box(
        'bp_thumbnail_box',
        __('Miniatura', 'barbecho'),
        'bp_miniatura_html',
        'proyecto',
        'normal',
        'default'
    );

    add_meta_box(
        'bp_reparto_box',
        __('Reparto', 'barbecho'),
        'bp_custom_repeater_reparto_html',
        'proyecto',
        'normal',
        'default'
    );

    add_meta_box(
        'bp_responsables_box',
        __('Responsables', 'barbecho'),
        'bp_custom_repeater_responsables_html',
        'proyecto',
        'normal',
        'default'
    );

    add_meta_box(
        'bp_fotogramas_box',
        __('Galería de Fotogramas y Vídeos', 'barbecho'),
        'bp_galeria_fotogramas_html',
        'proyecto',
        'normal',
        'default'
    );

    add_meta_box(
        'bp_prensa_box',
        __('Multimedia de Prensa', 'barbecho'),
        'bp_galeria_prensa_html',
        'proyecto',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'bp_custom_repeater_meta_boxes');

function bp_miniatura_html($post) {
    include BP_PLUGIN_DIR . 'admin/views/miniatura.php';
}

function bp_custom_repeater_reparto_html($post) {
    include BP_PLUGIN_DIR . 'admin/views/reparto.php';
}

function bp_custom_repeater_responsables_html($post) {
    include BP_PLUGIN_DIR . 'admin/views/responsables.php';
}

function bp_galeria_fotogramas_html($post) {
    include BP_PLUGIN_DIR . 'admin/views/fotogramas.php';
}

function bp_galeria_prensa_html($post) {
    include BP_PLUGIN_DIR . 'admin/views/prensa.php';
}

add_action('admin_footer', function() {
    ?>
    <script>
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('bp-remove-row')) {
            e.target.closest('.bp-gallery-item, .bp-repeater-row').remove();
        }
    });
    </script>
    <?php
});
