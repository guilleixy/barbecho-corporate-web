<?php
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
