<?php
/**
 * Plugin Name: Barbecho Extra Fields
 * Description: Plugin personalizado para añadir campos repetidores y funcionalidades extra.
 * Version: 1.3
 * Author: Guillermo Bernal
 */

if (!defined('ABSPATH')) {
    exit;
}

function bp_custom_repeater_meta_boxes() {
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

function bp_custom_repeater_reparto_html($post) {
    $reparto = get_post_meta($post->ID, '_bp_proyecto_reparto', true);
    if (!is_array($reparto)) {
        $reparto = array();
    }

    wp_nonce_field('bp_guardar_reparto_nonce', 'bp_reparto_nonce_field');
    ?>
    <div class="bp-repeater-container">
        <div class="bp-rows-wrapper-reparto">
            <?php
            if (!empty($reparto)) {
                foreach ($reparto as $index => $row) {
                    ?>
                    <div class="bp-repeater-row" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                        <input type="text" name="bp_reparto[<?php echo $index; ?>][nombre]" value="<?php echo esc_attr($row['nombre']); ?>" placeholder="Nombre" style="flex:1;">
                        <input type="text" name="bp_reparto[<?php echo $index; ?>][rol]" value="<?php echo esc_attr($row['rol']); ?>" placeholder="Personaje" style="flex:1;">
                        <button type="button" class="button bp-remove-row" style="color:#a00;">Eliminar</button>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <p>
            <button type="button" class="button button-secondary bp-add-row-reparto">Añadir elemento</button>
        </p>
    </div>

    <script>
    document.querySelector('.bp-add-row-reparto').addEventListener('click', function() {
        var wrapper = document.querySelector('.bp-rows-wrapper-reparto');
        var index = wrapper.children.length;

        var rowHtml = '<div class="bp-repeater-row" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">' +
            '<input type="text" name="bp_reparto[' + index + '][nombre]" placeholder="Nombre" style="flex:1;">' +
            '<input type="text" name="bp_reparto[' + index + '][rol]" placeholder="Personaje" style="flex:1;">' +
            '<button type="button" class="button bp-remove-row" style="color:#a00;">Eliminar</button>' +
        '</div>';

        wrapper.insertAdjacentHTML('beforeend', rowHtml);
    });
    </script>
    <?php
}

function bp_custom_repeater_responsables_html($post) {
    $responsables = get_post_meta($post->ID, '_bp_proyecto_responsables', true);
    if (!is_array($responsables)) {
        $responsables = array();
    }

    wp_nonce_field('bp_guardar_responsables_nonce', 'bp_responsables_nonce_field');
    ?>
    <div class="bp-repeater-container">
        <div class="bp-rows-wrapper-responsables">
            <?php
            if (!empty($responsables)) {
                foreach ($responsables as $index => $row) {
                    ?>
                    <div class="bp-repeater-row" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                        <input type="text" name="bp_responsables[<?php echo $index; ?>][nombre]" value="<?php echo esc_attr($row['nombre']); ?>" placeholder="Nombre" style="flex:1;">
                        <input type="text" name="bp_responsables[<?php echo $index; ?>][rol]" value="<?php echo esc_attr($row['rol']); ?>" placeholder="Rol" style="flex:1;">
                        <button type="button" class="button bp-remove-row" style="color:#a00;">Eliminar</button>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <p>
            <button type="button" class="button button-secondary bp-add-row-responsables">Añadir elemento</button>
        </p>
    </div>

    <script>
    document.querySelector('.bp-add-row-responsables').addEventListener('click', function() {
        var wrapper = document.querySelector('.bp-rows-wrapper-responsables');
        var index = wrapper.children.length;

        var rowHtml = '<div class="bp-repeater-row" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">' +
            '<input type="text" name="bp_responsables[' + index + '][nombre]" placeholder="Nombre" style="flex:1;">' +
            '<input type="text" name="bp_responsables[' + index + '][rol]" placeholder="Rol" style="flex:1;">' +
            '<button type="button" class="button bp-remove-row" style="color:#a00;">Eliminar</button>' +
        '</div>';

        wrapper.insertAdjacentHTML('beforeend', rowHtml);
    });
    </script>
    <?php
}

function bp_galeria_fotogramas_html($post) {
    $fotogramas = get_post_meta($post->ID, '_bp_proyecto_fotogramas', true);
    if (!is_array($fotogramas)) {
        $fotogramas = array();
    }

    wp_nonce_field('bp_guardar_fotogramas_nonce', 'bp_fotogramas_nonce_field');
    wp_enqueue_media();
    ?>
    <div class="bp-gallery-container">
        <div class="bp-gallery-wrapper" id="bp-fotogramas-wrapper" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap:15px; margin-bottom:15px;">
            <?php
            if (!empty($fotogramas)) {
                foreach ($fotogramas as $index => $item) {
                    $att_url = wp_get_attachment_url($item['id']);
                    $att_type = get_post_mime_type($item['id']);
                    $is_video = (strpos($att_type, 'video') !== false);
                    ?>
                    <div class="bp-gallery-item" style="border:1px solid #ccc; padding:10px; background:#f9f9f9; text-align:center;">
                        <input type="hidden" name="bp_fotogramas[<?php echo $index; ?>][id]" value="<?php echo esc_attr($item['id']); ?>">
                        <?php if ($is_video) : ?>
                            <video src="<?php echo esc_url($att_url); ?>" style="max-width:100%; height:90px; object-fit:cover; margin-bottom:8px; background:#000;" muted></video>
                            <span style="display:block; font-size:10px; color:#666; margin-bottom:5px;">[Vídeo / GIF]</span>
                        <?php else : ?>
                            <?php $img_thumb = wp_get_attachment_image_url($item['id'], 'thumbnail'); ?>
                            <img src="<?php echo esc_url($img_thumb ? $img_thumb : $att_url); ?>" style="max-width:100%; height:90px; object-fit:cover; margin-bottom:8px;">
                        <?php endif; ?>
                        <input type="text" name="bp_fotogramas[<?php echo $index; ?>][leyenda]" value="<?php echo esc_attr($item['leyenda']); ?>" placeholder="Leyenda opcional" style="width:100%; margin-bottom:8px; font-size:12px;">
                        <button type="button" class="button bp-remove-row" style="color:#a00; width:100%;">Eliminar</button>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <p>
            <button type="button" class="button button-secondary" id="bp-add-fotogramas">Añadir imágenes, vídeos o GIFs</button>
        </p>
    </div>

    <script>
    document.getElementById('bp-add-fotogramas').addEventListener('click', function(e) {
        e.preventDefault();
        var frame = wp.media({
            title: 'Seleccionar archivos multimedia',
            button: { text: 'Añadir a la galería' },
            multiple: true
        });

        frame.on('select', function() {
            var selection = frame.state().get('selection');
            var wrapper = document.getElementById('bp-fotogramas-wrapper');

            selection.map(function(attachment) {
                attachment = attachment.toJSON();
                var index = wrapper.children.length;
                var isVideo = attachment.type === 'video';
                var mediaUrl = isVideo ? attachment.url : (attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url);

                var previewHtml = isVideo
                    ? '<video src="' + mediaUrl + '" style="max-width:100%; height:90px; object-fit:cover; margin-bottom:8px; background:#000;" muted></video><span style="display:block; font-size:10px; color:#666; margin-bottom:5px;">[Vídeo / GIF]</span>'
                    : '<img src="' + mediaUrl + '" style="max-width:100%; height:90px; object-fit:cover; margin-bottom:8px;">';

                var html = '<div class="bp-gallery-item" style="border:1px solid #ccc; padding:10px; background:#f9f9f9; text-align:center;">' +
                    '<input type="hidden" name="bp_fotogramas[' + index + '][id]" value="' + attachment.id + '">' +
                    previewHtml +
                    '<input type="text" name="bp_fotogramas[' + index + '][leyenda]" placeholder="Leyenda opcional" style="width:100%; margin-bottom:8px; font-size:12px;">' +
                    '<button type="button" class="button bp-remove-row" style="color:#a00; width:100%;">Eliminar</button>' +
                '</div>';

                wrapper.insertAdjacentHTML('beforeend', html);
            });
        });

        frame.open();
    });
    </script>
    <?php
}

function bp_galeria_prensa_html($post) {
    $prensa = get_post_meta($post->ID, '_bp_proyecto_prensa', true);
    if (!is_array($prensa)) {
        $prensa = array();
    }

    wp_nonce_field('bp_guardar_prensa_nonce', 'bp_prensa_nonce_field');
    wp_enqueue_media();
    ?>
    <div class="bp-gallery-container">
        <div class="bp-gallery-wrapper" id="bp-prensa-wrapper" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap:15px; margin-bottom:15px;">
            <?php
            if (!empty($prensa)) {
                foreach ($prensa as $index => $item) {
                    $att_url = wp_get_attachment_url($item['id']);
                    $att_type = get_post_mime_type($item['id']);
                    $is_video = (strpos($att_type, 'video') !== false);
                    ?>
                    <div class="bp-gallery-item" style="border:1px solid #ccc; padding:10px; background:#f9f9f9; text-align:center;">
                        <input type="hidden" name="bp_prensa[<?php echo $index; ?>][id]" value="<?php echo esc_attr($item['id']); ?>">
                        <?php if ($is_video) : ?>
                            <video src="<?php echo esc_url($att_url); ?>" style="max-width:100%; height:90px; object-fit:cover; margin-bottom:8px; background:#000;" muted></video>
                            <span style="display:block; font-size:10px; color:#666; margin-bottom:5px;">[Vídeo / GIF]</span>
                        <?php else : ?>
                            <?php $img_thumb = wp_get_attachment_image_url($item['id'], 'thumbnail'); ?>
                            <img src="<?php echo esc_url($img_thumb ? $img_thumb : $att_url); ?>" style="max-width:100%; height:90px; object-fit:cover; margin-bottom:8px;">
                        <?php endif; ?>
                        <input type="text" name="bp_prensa[<?php echo $index; ?>][leyenda]" value="<?php echo esc_attr($item['leyenda']); ?>" placeholder="Leyenda opcional" style="width:100%; margin-bottom:8px; font-size:12px;">
                        <button type="button" class="button bp-remove-row" style="color:#a00; width:100%;">Eliminar</button>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <p>
            <button type="button" class="button button-secondary" id="bp-add-prensa">Añadir multimedia de prensa</button>
        </p>
    </div>

    <script>
    document.getElementById('bp-add-prensa').addEventListener('click', function(e) {
        e.preventDefault();
        var frame = wp.media({
            title: 'Seleccionar multimedia de prensa',
            button: { text: 'Añadir a la galería' },
            multiple: true
        });

        frame.on('select', function() {
            var selection = frame.state().get('selection');
            var wrapper = document.getElementById('bp-prensa-wrapper');

            selection.map(function(attachment) {
                attachment = attachment.toJSON();
                var index = wrapper.children.length;
                var isVideo = attachment.type === 'video';
                var mediaUrl = isVideo ? attachment.url : (attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url);

                var previewHtml = isVideo
                    ? '<video src="' + mediaUrl + '" style="max-width:100%; height:90px; object-fit:cover; margin-bottom:8px; background:#000;" muted></video><span style="display:block; font-size:10px; color:#666; margin-bottom:5px;">[Vídeo / GIF]</span>'
                    : '<img src="' + mediaUrl + '" style="max-width:100%; height:90px; object-fit:cover; margin-bottom:8px;">';

                var html = '<div class="bp-gallery-item" style="border:1px solid #ccc; padding:10px; background:#f9f9f9; text-align:center;">' +
                    '<input type="hidden" name="bp_prensa[' + index + '][id]" value="' + attachment.id + '">' +
                    previewHtml +
                    '<input type="text" name="bp_prensa[' + index + '][leyenda]" placeholder="Leyenda opcional" style="width:100%; margin-bottom:8px; font-size:12px;">' +
                    '<button type="button" class="button bp-remove-row" style="color:#a00; width:100%;">Eliminar</button>' +
                '</div>';

                wrapper.insertAdjacentHTML('beforeend', html);
            });
        });

        frame.open();
    });
    </script>
    <?php
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

function bp_guardar_custom_repeater_reparto($post_id) {
    if (!isset($_POST['bp_reparto_nonce_field']) || !wp_verify_nonce($_POST['bp_reparto_nonce_field'], 'bp_guardar_reparto_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    if (isset($_POST['bp_reparto']) && is_array($_POST['bp_reparto'])) {
        $clean_data = array();
        foreach ($_POST['bp_reparto'] as $row) {
            if (!empty($row['nombre']) || !empty($row['rol'])) {
                $clean_data[] = array(
                    'nombre' => sanitize_text_field($row['nombre']),
                    'rol'    => sanitize_text_field($row['rol'])
                );
            }
        }
        update_post_meta($post_id, '_bp_proyecto_reparto', $clean_data);
    } else {
        delete_post_meta($post_id, '_bp_proyecto_reparto');
    }
}
add_action('save_post', 'bp_guardar_custom_repeater_reparto');

function bp_guardar_custom_repeater_responsables($post_id) {
    if (!isset($_POST['bp_responsables_nonce_field']) || !wp_verify_nonce($_POST['bp_responsables_nonce_field'], 'bp_guardar_responsables_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    if (isset($_POST['bp_responsables']) && is_array($_POST['bp_responsables'])) {
        $clean_data = array();
        foreach ($_POST['bp_responsables'] as $row) {
            if (!empty($row['nombre']) || !empty($row['rol'])) {
                $clean_data[] = array(
                    'nombre' => sanitize_text_field($row['nombre']),
                    'rol'    => sanitize_text_field($row['rol'])
                );
            }
        }
        update_post_meta($post_id, '_bp_proyecto_responsables', $clean_data);
    } else {
        delete_post_meta($post_id, '_bp_proyecto_responsables');
    }
}
add_action('save_post', 'bp_guardar_custom_repeater_responsables');

function bp_guardar_galeria_fotogramas($post_id) {
    if (!isset($_POST['bp_fotogramas_nonce_field']) || !wp_verify_nonce($_POST['bp_fotogramas_nonce_field'], 'bp_guardar_fotogramas_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    if (isset($_POST['bp_fotogramas']) && is_array($_POST['bp_fotogramas'])) {
        $clean_data = array();
        foreach ($_POST['bp_fotogramas'] as $row) {
            if (!empty($row['id'])) {
                $clean_data[] = array(
                    'id'      => intval($row['id']),
                    'leyenda' => sanitize_text_field($row['leyenda'])
                );
            }
        }
        update_post_meta($post_id, '_bp_proyecto_fotogramas', $clean_data);
    } else {
        delete_post_meta($post_id, '_bp_proyecto_fotogramas');
    }
}
add_action('save_post', 'bp_guardar_galeria_fotogramas');

function bp_guardar_galeria_prensa($post_id) {
    if (!isset($_POST['bp_prensa_nonce_field']) || !wp_verify_nonce($_POST['bp_prensa_nonce_field'], 'bp_guardar_prensa_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    if (isset($_POST['bp_prensa']) && is_array($_POST['bp_prensa'])) {
        $clean_data = array();
        foreach ($_POST['bp_prensa'] as $row) {
            if (!empty($row['id'])) {
                $clean_data[] = array(
                    'id'      => intval($row['id']),
                    'leyenda' => sanitize_text_field($row['leyenda'])
                );
            }
        }
        update_post_meta($post_id, '_bp_proyecto_prensa', $clean_data);
    } else {
        delete_post_meta($post_id, '_bp_proyecto_prensa');
    }
}
add_action('save_post', 'bp_guardar_galeria_prensa');
