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

 if (!defined('ABSPATH')) exit; // Exit if accessed directly.

 // Update post meta on save.
 add_action('save_post', function($post_id, $post) {
     if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
     if (wp_is_post_revision($post_id)) return;
 
     update_post_meta($post_id, '_ars_last_update_time', time());
 }, 10, 2);
 
 // Enqueue frontend scripts on singular pages.
 add_action('wp_enqueue_scripts', function () {
     if (is_singular()) {
         $post_id = get_the_ID();
         $last_saved = get_post_meta($post_id, '_ars_last_update_time', true) ?: 0;
 
         wp_enqueue_script('ars-refresh-script', plugin_dir_url(__FILE__) . 'ars-refresh.js', ['jquery'], null, true);
         wp_localize_script('ars-refresh-script', 'arsData', [
             'ajaxUrl' => admin_url('admin-ajax.php'),
             'lastSaved' => $last_saved,
             'currentPostId' => $post_id,
         ]);
     }
 });
 
 // AJAX handler to check for post/page updates.
 add_action('wp_ajax_check_page_update', 'ars_check_page_update');
 add_action('wp_ajax_nopriv_check_page_update', 'ars_check_page_update');
 
 function ars_check_page_update() {
     if (!isset($_POST['post_id'])) wp_send_json_error();
 
     $post_id = intval($_POST['post_id']);
     $saved_time = get_post_meta($post_id, '_ars_last_update_time', true);
 
     if ($saved_time) {
         wp_send_json_success(['lastSaved' => $saved_time]);
     } else {
         wp_send_json_error();
     }
 
     wp_die(); // Properly terminate AJAX request.
 }