
<?php
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
