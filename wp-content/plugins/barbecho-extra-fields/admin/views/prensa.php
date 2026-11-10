<?php
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
