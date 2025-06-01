<?php
/**
 * @package TubeList
 * Plugin Name: Tubelist
 * Description: A simple plugin to load and display youtube playlists through shortcode with the help of youtube v3 api.
 * Author: kmfoysal06
 * Tags: youtube, playlist, tubelist, shortcode, api
 * Version: 1.0
 * Requires at least: 6.0
 * Tested up to: 6.8
 * Requires PHP: 7.0
 * License: GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: tubelist
 */





if(!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if(!defined("TUBELIST_DIR")) {
    define("TUBELIST_DIR", plugin_dir_path(__FILE__));
}
if(!defined("TUBELIST_URI")) {
    define("TUBELIST_URI", plugin_dir_url(__FILE__));
}
if(!defined("PLAYLIST_API_KEY")) {
    define("PLAYLIST_API_KEY", get_option('tubelist_api_key', ''));
}

function tubelist_load_playlist($playlist_id) {
     $api_key = PLAYLIST_API_KEY;
     $url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=100&playlistId={$playlist_id}&key={$api_key}";
     $response = wp_remote_get($url);
     $body = wp_remote_retrieve_body($response);
     $body_parsed = json_decode($body, true);
     $items = isset($body_parsed['items']) ? $body_parsed['items'] : [];
     if (empty($items)) {
        return '<p>No items found in this playlist.</p>';
    }
    
    $items_mapped = array_map(function($item) {
        $snippet = $item['snippet'];
        return [
            'title' => $snippet['title'],
            'description' => $snippet['description'],
            'videoId' => $snippet['resourceId']['videoId'],
            'thumbnail' => $snippet['thumbnails']['default']['url']
        ];
    }, $items);
    $videos = $items_mapped;
    ob_start();
    require_once plugin_dir_path(__FILE__) . 'playlist-markup.php';
    $output = ob_get_clean();
    return $output;
 };

 add_shortcode('tubelist', function($atts) {
    $id = isset($atts['id']) ? $atts['id'] : '';
    if (empty($id)) {
        return '<p>Please provide a playlist ID.</p>';
    }
    $playlist_items = tubelist_load_playlist($id);
    return $playlist_items;
 });
function tubelist_assets() {
    wp_register_style('tubelist-style', TUBELIST_URI . 'assets/css/playlist.css', [], filemtime(TUBELIST_DIR . 'assets/css/playlist.css'));

    wp_register_script('tubelist-script', TUBELIST_URI . 'assets/js/playlist.js', [], filemtime(TUBELIST_DIR . 'assets/js/playlist.js'), true);
    if (has_shortcode(get_post()->post_content, 'tubelist')) {
        wp_enqueue_style('tubelist-style');
        wp_enqueue_script('tubelist-script');
    } 
}

add_action('wp_enqueue_scripts', 'tubelist_assets');

// a settings page to provide api key and save it
function tubelist_settings_page() {
    add_options_page('TubeList Settings', 'TubeList', 'manage_options', 'tubelist-settings', 'tubelist_settings_page_html');
}
add_action('admin_menu', 'tubelist_settings_page');

function tubelist_settings_page_html() {
    if (!current_user_can('manage_options')) {
        return;
    }
    if (isset($_POST['tubelist_api_key'])) {
        $api_key = sanitize_text_field(wp_unslash($_POST['tubelist_api_key']));
        if (!empty($api_key)) {
            update_option('tubelist_api_key', $api_key);
        }
    }
    $api_key = get_option('tubelist_api_key', '');
    $html = '';
    $html .= '<div class="wrap">';
    $html .= '<h1>TubeList Settings</h1>';
    $html .= '<form method="post" action="">';
    $html .= '<table class="form-table">';
    $html .= '<tr valign="top">';
    $html .= '<th scope="row">API Key</th>';
    $html .= '<td><input type="text" name="tubelist_api_key" value="' . esc_attr($api_key) . '" class="regular-text" /></td>';
    $html .= '</tr>';
    $html .= '</table>';
    $html .= wp_nonce_field('tubelist_settings_save', 'tubelist_settings_nonce', true, false);
    $html .= '<p class="submit"><input type="submit" class="button button-primary" value="Save Changes" name="tubelist_submit" /></p>';
    $html .= '</form>';
    $html .= '</div>';
    echo wp_kses(
        $html,
        [
            'div' => ['class' => []],
            'h1' => [],
            'form' => ['method' => [], 'action' => []],
            'table' => ['class' => []],
            'tr' => [],
            'th' => ['scope' => []],
            'td' => [],
            'input' => ['type' => [], 'name' => [], 'value' => [], 'class' => []],
            'p' => ['class' => []],
            'button' => ['class' => [], 'type' => [], 'value' => []]
        ]
    );

}
