<?php
/**
* playlist layout
*/
if(!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>
    <style>
    </style>
    <div class="tubelist-container">
        <div class="top-section">
            <div class="main-content tubelist-main-video">
                    <?php 
                    $id = $videos[0]['videoId'] ?? 'dQw4w9WgXcQ';
                    $embedd_url = "https://www.youtube.com/embed/{$id}"; 
                    ?>
                    <iframe width="100%" height="100%" src="<?php echo esc_url($embedd_url); ?>" frameborder="0" allowfullscreen></iframe>
            </div>
            
            <div class="sidebar">
                <?php foreach($videos as $video): ?>
                <div class="sidebar-item" data-video-id="<?php echo esc_attr($video['videoId']); ?>">
                    <div class="sidebar-image">
                        <img src="<?php echo esc_url($video['thumbnail']); ?>" alt="<?php echo esc_attr($video['title']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="sidebar-text">
                <h4><?php echo esc_html($video['title']); ?></h4>
                        <p><?php echo esc_html(substr($video['description'], 0, 60) . '...'); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
                
             </div>
        </div>
        
        <div class="bottom-section">
            <div class="placeholder-text">
                Bottom Content Section - Additional content area for footer or supplementary information
            </div>
        </div>
    </div>

    <script>
        // Simple interactive functionality

    </script>
