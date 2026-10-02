<?php
/**
 *
 * @package           PluginPackage
 * @author            Michael Gangolf
 * @copyright         2026 Michael Gangolf
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name: Smooth scrolling with Lenis
 * Description: Adds the Lenis library (by darkroom.engineering) to your WordPress page
 * Version:     1.7.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Michael Gangolf
 * Author URI:        https://www.migaweb.de/
 * License:           GPL v3 or later
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!defined('MIGA_SMOOTH_SCROLLING_LENIS_VERSION')) {
    define('MIGA_SMOOTH_SCROLLING_LENIS_VERSION', '1.3.26');
}

function miga_smooth_scrolling_enqueue_scripts()
{
    $value = get_option('miga_smooth_scrolling_exclude_page', []);
    if ($value == "") {
        $value = [];
    }
    if (
        in_array(get_the_id(), $value)
        || (class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->preview->is_preview_mode())
    ) {
        return;
    }
    if (
        in_array(get_the_id(), $value)
        || (class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->preview->is_preview_mode())
    ) {
        // don't enqueue script for this page
    } else {

        $smoothWheel = 1;
        if (get_option('miga_smooth_scrolling_disable_wheel') == "yes") {
            $smoothWheel = 0;
        }
        $preventList = array_values(array_filter(array_map('trim', explode("\n", (string) get_option('miga_smooth_scrolling_prevent', '')))));
        wp_enqueue_style('theme-lenis-style', plugin_dir_url(__FILE__) .  'style.css', [], MIGA_SMOOTH_SCROLLING_LENIS_VERSION);
        wp_enqueue_script('theme-lenis', plugin_dir_url(__FILE__) . 'js/vendor/lenis.min.js', [], MIGA_SMOOTH_SCROLLING_LENIS_VERSION, false);
        wp_enqueue_script('theme-main', plugin_dir_url(__FILE__) . 'js/main.js', [], MIGA_SMOOTH_SCROLLING_LENIS_VERSION, ['in_footer' => true]);
        wp_localize_script('theme-main', 'miga_smooth_scrolling_params', [
          "miga_smooth_scrolling_smoothWheel" => (int) esc_attr($smoothWheel),
          "miga_smooth_scrolling_anchor_offset" => esc_attr(get_option('miga_smooth_scrolling_anchor_offset')),
          "miga_smooth_scrolling_lerp" => esc_attr(get_option('miga_smooth_scrolling_lerp')),
          "miga_smooth_scrolling_duration" => esc_attr(get_option('miga_smooth_scrolling_duration')),
          "miga_smooth_scrolling_anchor" => (get_option('miga_smooth_scrolling_anchor_links') == "yes"),
          "miga_smooth_scrolling_gsap" => (get_option('miga_smooth_scrolling_gsap') == "yes"),
          "miga_smooth_scrolling_prevent" => $preventList
        ]);

    }
}

function miga_smooth_scrolling_menu()
{
    add_submenu_page(
        'options-general.php',
        'Smooth Scrolling Settings',
        'Smooth Scrolling',
        'manage_options',
        'miga_smooth_scrolling',
        'miga_smooth_scrolling_page_callback'
    );
}

function miga_smooth_scrolling_page_callback()
{
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
<div class="wrap">
  <h1>Smooth Scrolling Settings</h1>
  <form method="post" action="options.php">
    <?php
    settings_fields('miga_lenis_option_group');
    do_settings_sections('miga_smooth_scrolling');
    submit_button();
    ?>
  </form>
  <p>Plugin is using <a target="_blank" rel="noopener noreferrer" href="https://github.com/darkroomengineering/lenis">lenis <?php echo esc_attr(MIGA_SMOOTH_SCROLLING_LENIS_VERSION); ?></a> by <a target="_blank" rel="noopener noreferrer" href="https://github.com/darkroomengineering">darkroom.engineering</a></p>
</div>
<?php
}

function miga_smooth_scrolling_fields()
{

    $page_slug = 'miga_smooth_scrolling';
    $option_group = 'miga_lenis_option_group';

    add_settings_section(
        'miga_smooth_scrolling_id',
        '',
        '',
        $page_slug
    );

    if ( get_option( 'miga_smooth_scrolling_gsap' ) === false )
        update_option( 'miga_smooth_scrolling_gsap', 0 );
    if ( get_option( 'miga_smooth_scrolling_disable_wheel' ) === false )
        update_option( 'miga_smooth_scrolling_disable_wheel', 0 );
    if ( get_option( 'miga_smooth_scrolling_anchor_links' ) === false )
        update_option( 'miga_smooth_scrolling_anchor_links', 0 );

    register_setting($option_group, 'miga_smooth_scrolling_disable_wheel', 'miga_smooth_scrolling_sanitize_checkbox');
    register_setting($option_group, 'miga_smooth_scrolling_exclude_page', 'miga_smooth_scrolling_sanitize_exclude_page');
    register_setting($option_group, 'miga_smooth_scrolling_anchor_links', 'miga_smooth_scrolling_sanitize_checkbox');
    register_setting($option_group, 'miga_smooth_scrolling_gsap', 'miga_smooth_scrolling_sanitize_checkbox');
    register_setting($option_group, 'miga_smooth_scrolling_anchor_offset', 'miga_smooth_scrolling_sanitize_value');
    register_setting($option_group, 'miga_smooth_scrolling_lerp', 'miga_smooth_scrolling_sanitize_lerp');
    register_setting($option_group, 'miga_smooth_scrolling_duration', 'miga_smooth_scrolling_sanitize_float');
    register_setting($option_group, 'miga_smooth_scrolling_prevent', 'miga_smooth_scrolling_sanitize_prevent');


    add_settings_field(
        'miga_smooth_scrolling_disable_wheel',
        'Disable mouse wheel',
        'miga_smooth_scrolling_mouse_wheel',
        $page_slug,
        'miga_smooth_scrolling_id'
    );

    add_settings_field(
        'miga_smooth_scrolling_exclude_page', // id
        'Exclude on these pages', // title
        'miga_smooth_scrolling_exclude_page_callback', // callback
        $page_slug,
        'miga_smooth_scrolling_id'
    );

    add_settings_field(
        'miga_smooth_scrolling_anchor_links', // id
        'Smooth anchor links', // title
        'miga_smooth_scrolling_anchor_links_callback', // callback
        $page_slug,
        'miga_smooth_scrolling_id'
    );

    add_settings_field(
        'miga_smooth_scrolling_gsap', // id
        'Synchronize with GSAP/ScrollTrigger', // title
        'miga_smooth_scrolling_gsap_callback', // callback
        $page_slug,
        'miga_smooth_scrolling_id'
    );
    add_settings_field(
        'miga_smooth_scrolling_anchor_offset', // id
        'Smooth anchor link offset', // title
        'miga_smooth_scrolling_anchor_offset_callback', // callback
        $page_slug,
        'miga_smooth_scrolling_id'
    );
    add_settings_field(
        'miga_smooth_scrolling_lerp', // id
        'Linear interpolation (lerp) intensity (between 0 and 1)<br/><small style="font-weight:normal;">Set this to 0 to use "duration of scroll animation"</small>', // title
        'miga_smooth_scrolling_lerp_callback', // callback
        $page_slug,
        'miga_smooth_scrolling_id'
    );
    add_settings_field(
        'miga_smooth_scrolling_duration', // id
        'Duration of scroll animation<br/><small style="font-weight:normal;">Set lerp to 0 to use this value</small>', // title
        'miga_smooth_scrolling_duration_callback', // callback
        $page_slug,
        'miga_smooth_scrolling_id'
    );
    add_settings_field(
        'miga_smooth_scrolling_prevent', // id
        'Prevent smooth scrolling on these elements<br/><small style="font-weight:normal;">One id (#modal) or class (.popup) per line</small>', // title
        'miga_smooth_scrolling_prevent_callback', // callback
        $page_slug,
        'miga_smooth_scrolling_id'
    );

}


function miga_smooth_scrolling_mouse_wheel($args)
{
    $value = get_option('miga_smooth_scrolling_disable_wheel');
    ?>
<label>
  <input type="checkbox" name="miga_smooth_scrolling_disable_wheel" <?php checked(esc_attr($value), 'yes') ?> /> Yes
</label>
<?php
}

function miga_smooth_scrolling_anchor_links_callback($args)
{
    $value = get_option('miga_smooth_scrolling_anchor_links');
    ?>
<label>
  <input type="checkbox" name="miga_smooth_scrolling_anchor_links" <?php checked(esc_attr($value), 'yes') ?> /> Yes
</label>
<?php
}

function miga_smooth_scrolling_gsap_callback($args)
{
    $value = get_option('miga_smooth_scrolling_gsap');
    ?>
<label>
  <input type="checkbox" name="miga_smooth_scrolling_gsap" <?php checked(esc_attr($value), 'yes') ?>/> Yes
</label>
<?php
}

function miga_smooth_scrolling_anchor_offset_callback($args)
{
    $value = get_option('miga_smooth_scrolling_anchor_offset', 0);
    ?>
<label>
  <input type="number" name="miga_smooth_scrolling_anchor_offset" value="<?php echo(empty($value) ? '0' : esc_attr($value)); ?>"/> px
</label>
<?php
}

function miga_smooth_scrolling_lerp_callback($args)
{
    $value = get_option('miga_smooth_scrolling_lerp', 0.1);
    ?>
<label>
  <input type="number" name="miga_smooth_scrolling_lerp" step="0.01" value="<?php echo(empty($value) ? '0' : esc_attr($value)); ?>"/> (default 0.1)
</label>
<?php
}

function miga_smooth_scrolling_duration_callback($args)
{
    $value = get_option('miga_smooth_scrolling_duration', 1.2);
    ?>
<label>
  <input type="number" name="miga_smooth_scrolling_duration" step="0.01" value="<?php echo(empty($value) ? '0' : esc_attr($value)); ?>"/> sec (default 1.2)
</label>
<?php
}

function miga_smooth_scrolling_exclude_page_callback()
{
    $value = get_option('miga_smooth_scrolling_exclude_page', []);
    if ($value == "") {
        $value = [];
    }
    echo '<select name="miga_smooth_scrolling_exclude_page[]" id="miga_smooth_scrolling_exclude_page" size="10" multiple="multiple">';

    $pages = get_pages();
    foreach ($pages as $page) {
        $option = '<option value="' . esc_attr($page->ID) . '"';

        if (in_array($page->ID, $value)) {
            $option .= " selected ";
        }

        $option .= '>' . esc_html($page->post_title) . '</option>';
        echo wp_kses($option, ['option' => ['value' => [], 'selected' => []]]);
    }

    echo '</select>';
}

function miga_smooth_scrolling_prevent_callback($args)
{
    $value = get_option('miga_smooth_scrolling_prevent', '');
    ?>
<label>
  <textarea name="miga_smooth_scrolling_prevent" id="miga_smooth_scrolling_prevent" rows="6" cols="40" placeholder="#modal&#10;.popup"><?php echo esc_textarea($value); ?></textarea>
</label>
<?php
}

function miga_smooth_scrolling_sanitize_checkbox($value)
{
    return 'on' == $value ? 'yes' : 'no';
}

function miga_smooth_scrolling_sanitize_exclude_page($value)
{
    if (!is_array($value)) {
        return [];
    }
    return array_map('absint', array_filter($value, 'is_numeric'));
}
function miga_smooth_scrolling_sanitize_value($value)
{
    return (int)$value;
}
function miga_smooth_scrolling_sanitize_lerp($value)
{
    return max(0, min(1, (float)$value));
}
function miga_smooth_scrolling_sanitize_float($value)
{
    return (float)$value;
}
function miga_smooth_scrolling_sanitize_prevent($value)
{
    $lines = explode("\n", (string)$value);
    $clean = [];
    foreach ($lines as $line) {
        $line = preg_replace('/[^A-Za-z0-9_\-#.]/', '', trim($line));
        if ($line !== '') {
            $clean[] = $line;
        }
    }
    return implode("\n", $clean);
}

add_action('admin_menu', 'miga_smooth_scrolling_menu');
add_action('wp_enqueue_scripts', 'miga_smooth_scrolling_enqueue_scripts', 15);
add_action('admin_init', 'miga_smooth_scrolling_fields');
