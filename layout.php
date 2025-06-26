<?php
/**
* playlist layout
*/
if(!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            border: 2px solid #ccc;
            min-height: 600px;
            display: flex;
            flex-direction: column;
        }

        .top-section {
            display: flex;
            flex: 1;
            min-height: 400px;
        }

        .main-content {
            flex: 1;
            border: 1px solid #ddd;
            margin: 10px;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fafafa;
        }

        .sidebar {
		    width: 300px;
		    height: 400px;
		    border: 1px solid #ddd;
		    margin: 10px 10px 10px 0;
		    padding: 10px;
		    overflow-y: auto;
		}

        .sidebar-item {
            display: flex;
            margin-bottom: 15px;
            border: 1px solid #eee;
            padding: 10px;
            cursor: pointer;
        }

        .sidebar-item:last-child {
            margin-bottom: 0;
        }

        .sidebar-image {
            width: 120px;
            height: 90px;
            background-color: #e0e0e0;
            border: 1px solid #ccc;
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: #666;
        }

        .sidebar-text {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .sidebar-text h4 {
            margin-bottom: 5px;
            font-size: 12px;
            color: #333;
        }

        .sidebar-text p {
            font-size: 10px;
            color: #666;
            line-height: 1.3;
        }

        .bottom-section {
            height: 150px;
            border: 1px solid #ddd;
            margin: 0 10px 10px 10px;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fafafa;
        }

        .placeholder-text {
            color: #888;
            font-size: 16px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .top-section {
                flex-direction: column;
            }
            
            .sidebar {
                width: auto;
                margin: 0 10px 10px 10px;
            }
            
            .sidebar-item {
                flex-direction: column;
                text-align: center;
            }
            
            .sidebar-image {
                margin: 0 auto 10px auto;
            }
        }
    </style>
    <div class="container">
        <div class="top-section">
            <div class="main-content youlist-main-video">
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
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarItems = document.querySelectorAll('.sidebar-item');
            const mainContent = document.querySelector('.youlist-main-video');
            
            sidebarItems.forEach((item, index) => {
                item.addEventListener('click', function() {
                    // Remove active class from all items
                    sidebarItems.forEach(i => i.style.backgroundColor = '');
                    
                    // Add active state to clicked item
                    this.style.backgroundColor = '#f0f0f0';
                    
                    // Update main content
                    const title = this.querySelector('h4').textContent;
                    const videoId = this.getAttribute('data-video-id');
                    const embeddUrl = `https://www.youtube.com/embed/${videoId}`;
                    mainContent.innerHTML = `<iframe width="100%" height="100%" src="${embeddUrl}" frameborder="0" allowfullscreen></iframe>`;


                });
                
                // Add hover effect
                item.addEventListener('mouseenter', function() {
                    if (this.style.backgroundColor !== '#f0f0f0') {
                        this.style.backgroundColor = '#f8f8f8';
                    }
                });
                
                item.addEventListener('mouseleave', function() {
                    if (this.style.backgroundColor !== '#f0f0f0') {
                        this.style.backgroundColor = '';
                    }
                });
            });
        });
    </script>
