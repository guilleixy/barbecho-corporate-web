<?php
$texto_opcional = get_post_meta($post->ID, '_bp_page_hero_texto', true);
$att_id         = get_post_meta($post->ID, '_bp_page_hero_media_id', true);

wp_nonce_field('bp_guardar_page_hero_nonce', 'bp_page_hero_nonce_field');
wp_enqueue_media();

$att_url  = $att_id ? wp_get_attachment_url($att_id) : '';
$att_type = $att_id ? get_post_mime_type($att_id) : '';
$is_video = ($att_type && strpos($att_type, 'video') !== false);
?>
<div class="bp-page-hero-container" style="max-width: 320px;">
    <div style="margin-bottom: 15px;">
        <label for="bp_page_hero_texto" style="display: block; font-weight: bold; margin-bottom: 5px;">Texto Opcional:</label>
        <input type="text" name="bp_page_hero_texto" id="bp_page_hero_texto" value="<?php echo esc_attr($texto_opcional); ?>" style="width: 100%;" placeholder="Ej. Subtítulo opcional">
    </div>

    <div style="margin-bottom: 10px;">
        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Multimedia del Hero:</label>
        <input type="hidden" name="bp_page_hero_media_id" id="bp_page_hero_media_id" value="<?php echo esc_attr($att_id); ?>">

        <div id="bp_page_hero_preview" style="border:1px solid #ccc; padding:10px; background:#f9f9f9; text-align:center; margin-bottom:10px; <?php echo $att_id ? '' : 'display:none;'; ?>">
            <div id="bp_page_hero_media_container" style="margin-bottom:0;">
                <?php if ($att_id) : ?>
                    <?php if ($is_video) : ?>
                        <video src="<?php echo esc_url($att_url); ?>" style="max-width:100%; height:120px; object-fit:cover; background:#000; display:block; margin:0 auto;" muted></video>
                        <span style="display:block; font-size:10px; color:#666; margin-top:5px;">[Vídeo / GIF]</span>
                    <?php else : ?>
                        <?php $img_thumb = wp_get_attachment_image_url($att_id, 'thumbnail'); ?>
                        <img src="<?php echo esc_url($img_thumb ? $img_thumb : $att_url); ?>" style="max-width:100%; height:120px; object-fit:cover; display:block; margin:0 auto;">
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <div style="margin-bottom: 10px; <?php echo $att_id ? 'display:none;' : ''; ?>" id="bp_page_hero_empty">
            <p style="text-align:center; color:#666; font-style:italic; border:1px dashed #ccc; padding:20px; margin:0;">No hay archivo seleccionado</p>
        </div>

        <div style="display:flex; gap:10px;">
            <button type="button" class="button button-secondary" id="bp_page_hero_select" style="flex:1;"><?php echo $att_id ? 'Cambiar archivo' : 'Seleccionar archivo'; ?></button>
            <button type="button" class="button" id="bp_page_hero_remove" style="color:#a00; <?php echo $att_id ? '' : 'display:none;'; ?>">Eliminar</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var selectBtn = document.getElementById('bp_page_hero_select');
    var removeBtn = document.getElementById('bp_page_hero_remove');
    var inputId = document.getElementById('bp_page_hero_media_id');
    var previewBox = document.getElementById('bp_page_hero_preview');
    var mediaContainer = document.getElementById('bp_page_hero_media_container');
    var emptyBox = document.getElementById('bp_page_hero_empty');

    if (selectBtn && !selectBtn.dataset.bound) {
        selectBtn.dataset.bound = 'true';

        selectBtn.addEventListener('click', function(e) {
            e.preventDefault();
            var frame = wp.media({
                title: 'Seleccionar archivo multimedia para el Hero',
                button: { text: 'Usar este archivo' },
                multiple: false
            });

            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                var isVideo = attachment.type === 'video';
                var mediaUrl = isVideo ? attachment.url : (attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url);

                inputId.value = attachment.id;

                var previewHtml = isVideo
                    ? '<video src="' + mediaUrl + '" style="max-width:100%; height:120px; object-fit:cover; background:#000; display:block; margin:0 auto;" muted></video><span style="display:block; font-size:10px; color:#666; margin-top:5px;">[Vídeo / GIF]</span>'
                    : '<img src="' + mediaUrl + '" style="max-width:100%; height:120px; object-fit:cover; display:block; margin:0 auto;">';

                mediaContainer.innerHTML = previewHtml;
                previewBox.style.display = 'block';
                emptyBox.style.display = 'none';
                removeBtn.style.display = 'inline-block';
                selectBtn.textContent = 'Cambiar archivo';
            });

            frame.open();
        });

        removeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            inputId.value = '';
            mediaContainer.innerHTML = '';
            previewBox.style.display = 'none';
            emptyBox.style.display = 'block';
            removeBtn.style.display = 'none';
            selectBtn.textContent = 'Seleccionar archivo';
        });
    }
});
</script>
