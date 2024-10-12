<?php
/**
 * Plugin Name: Auto Refresh on Save
 * Plugin URI: https://wordpress.org/plugins/auto-refresh-on-save
 * Description: Automatically refreshes the frontend page when an admin or editor saves or updates it. Clears cache to ensure the latest content is visible.
 * Version: 1.0.0
 * Author: Mir Monoarul Alam
 * Author URI: http://mirm.pro/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: auto-refresh-on-save
 * Domain Path: /languages
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Hook to detect when a post/page is saved
add_action('save_post', 'ars_refresh_frontend_on_save', 10, 2);

function ars_refresh_frontend_on_save($post_id, $post) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (wp_is_post_revision($post_id)) return;

    update_post_meta($post_id, '_ars_last_update_time', time());
}

// Enqueue frontend script only for logged-in admins or editors
add_action('wp_enqueue_scripts', 'ars_enqueue_frontend_script');

function ars_enqueue_frontend_script() {
    if (!current_user_can('edit_posts')) return;

    wp_enqueue_script(
        'ars-refresh-script',
        plugin_dir_url(__FILE__) . 'ars-refresh.js',
        ['jquery'],
        '1.0.0',
        true
    );

    if (is_singular()) {
        $post_id = get_the_ID();
        $last_saved = get_post_meta($post_id, '_ars_last_update_time', true);
        wp_localize_script('ars-refresh-script', 'arsData', [
            'lastSaved' => $last_saved ?: 0,
            'currentPostId' => $post_id,
        ]);
    }
}

// Clear page cache on save
add_action('save_post', 'ars_clear_cache_on_save', 20, 2);

function ars_clear_cache_on_save($post_id, $post) {
    if (function_exists('wp_cache_flush')) {
        wp_cache_flush(); // For WP Super Cache or similar plugins
    }
}