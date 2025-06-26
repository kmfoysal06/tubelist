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
require_once(plugin_dir_path(__FILE__) . '.env');

function load_playlist($playlist_id) {
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
    include_once(plugin_dir_path(__FILE__) . 'layout.php');
 };

 add_shortcode('kmfoysal06_playlist', function($atts) {
    $id = isset($atts['id']) ? $atts['id'] : '';
    if (empty($id)) {
        return '<p>Please provide a playlist ID.</p>';
    }
    $playlist_items = load_playlist($id);
    return json_encode($playlist_items);
 });
