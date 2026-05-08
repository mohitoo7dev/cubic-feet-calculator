<?php

/**
 * Plugin Name:       Cubic Feet Calculator
 * Plugin URI:        https://github.com/mohit/cubic-feet-calculator
 * Description:       Professional, fully responsive shortcode calculator for cubic feet. Supports Inches, Centimeters and Millimeters. Use [cubic_feet_calculator] shortcode.
 * Version:           3.0.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Mohit
 * Author URI:        https://github.com/mohitoo7dev
 * Text Domain:       cubic-feet-calculator
 * Domain Path:       /languages
 *
 * @package CubicFeetCalculator
 */

if (! defined('ABSPATH')) exit;

define('CFC_VERSION',         '3.0.0');
define('CFC_PLUGIN_FILE',     __FILE__);
define('CFC_PLUGIN_DIR',      plugin_dir_path(__FILE__));
define('CFC_PLUGIN_URL',      plugin_dir_url(__FILE__));
define('CFC_PLUGIN_BASENAME', plugin_basename(__FILE__));

function cfc_init()
{
    load_plugin_textdomain('cubic-feet-calculator', false, dirname(CFC_PLUGIN_BASENAME) . '/languages');
    require_once CFC_PLUGIN_DIR . 'includes/class-cfc-calculator.php';
    require_once CFC_PLUGIN_DIR . 'includes/class-cfc-shortcode.php';
    require_once CFC_PLUGIN_DIR . 'includes/class-cfc-assets.php';
    CFC_Assets::init();
    CFC_Shortcode::init();
}
add_action('plugins_loaded', 'cfc_init');

register_activation_hook(CFC_PLUGIN_FILE, function () {
    flush_rewrite_rules();
});
register_deactivation_hook(CFC_PLUGIN_FILE, function () {
    flush_rewrite_rules();
});
