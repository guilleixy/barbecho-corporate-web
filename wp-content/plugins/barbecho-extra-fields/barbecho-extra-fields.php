<?php
/**
 * Plugin Name: Barbecho Extra Fields
 * Description: Plugin personalizado para añadir campos repetidores y funcionalidades extra.
 * Version: 1.4
 * Author: Guillermo Bernal
 * Text Domain: barbecho
 */

if (!defined('ABSPATH')) {
    exit;
}

define('BP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('BP_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once BP_PLUGIN_DIR . 'includes/class-bp-meta-boxes.php';
require_once BP_PLUGIN_DIR . 'includes/class-bp-save-posts.php';
