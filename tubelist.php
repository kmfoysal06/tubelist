<?php
/**
 * Plugin Name: Playlist Loader
 * Description: A simple plugin to load and display playlists.
 * Author: kmfoysal06
 * Version: 1.0
 * License: GPL2
 */
if(!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!file_exists(plugin_dir_path(__FILE__) . '.env')) {
    wp_die('cannot open the environment file');
}
if(!defined("TUBELIST_DIR")) {
    define("TUBELIST_DIR", plugin_dir_path(__FILE__));
}
if(!defined("TUBELIST_URI")) {
    define("TUBELIST_URI", plugin_dir_url(__FILE__));
}

require_once(plugin_dir_path(__FILE__) . '.env');

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
