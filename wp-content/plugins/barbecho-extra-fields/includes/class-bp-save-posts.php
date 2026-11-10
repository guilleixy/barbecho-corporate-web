<?php
if (!defined('ABSPATH')) {
    exit;
}

function bp_guardar_miniatura($post_id) {
    if (!isset($_POST['bp_miniatura_nonce_field']) || !wp_verify_nonce($_POST['bp_miniatura_nonce_field'], 'bp_guardar_miniatura_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['bp_miniatura_id'])) {
        $id = intval($_POST['bp_miniatura_id']);
        if ($id > 0) {
            update_post_meta($post_id, '_bp_proyecto_miniatura', $id);
        } else {
            delete_post_meta($post_id, '_bp_proyecto_miniatura');
        }
    }
}
add_action('save_post', 'bp_guardar_miniatura');

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
