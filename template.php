<?php

?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    :root {
        --youtube-red: #ff0000;
        --youtube-dark: #0f0f0f;
        --youtube-gray: #f9f9f9;
        --youtube-text: #030303;
        --youtube-secondary: #606060;
    }

    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .playlist-header {
        background: linear-gradient(135deg, var(--youtube-red), #cc0000);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
    }

    .playlist-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .playlist-stats {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .video-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        margin-bottom: 1rem;
        overflow: hidden;
        cursor: pointer;
    }

    .video-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }

    .video-thumbnail {
        position: relative;
        width: 100%;
        height: 200px;
        background-size: cover;
        background-position: center;
        background-color: #000;
    }

    .video-number {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(0,0,0,0.8);
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .play-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 60px;
        height: 60px;
        background: var(--youtube-red);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .video-card:hover .play-button {
        opacity: 1;
    }

    .video-content {
        padding: 1.5rem;
    }

    .video-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--youtube-text);
        margin-bottom: 0.5rem;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .video-description {
        color: var(--youtube-secondary);
        font-size: 0.9rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .video-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 0.5rem;
        font-size: 0.85rem;
        color: var(--youtube-secondary);
    }

    .current-playing {
        border-left: 4px solid var(--youtube-red);
        background: #fff5f5;
    }

    .sidebar {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        position: sticky;
        top: 2rem;
        height: fit-content;
    }

    .current-video {
        aspect-ratio: 16/9;
        width: 100%;
        background: #000;
        border-radius: 8px;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
    }

    .now-playing-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--youtube-text);
    }

    .progress-bar {
        height: 4px;
        background: #ddd;
        border-radius: 2px;
        margin: 1rem 0;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: var(--youtube-red);
        width: 23%;
        animation: progress 2s ease-in-out infinite alternate;
    }

    @keyframes progress {
        0% { width: 20%; }
        100% { width: 35%; }
    }

    .control-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }

    .control-btn {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 20px;
        background: var(--youtube-gray);
        color: var(--youtube-text);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .control-btn:hover {
        background: #ddd;
    }

    .control-btn.active {
        background: var(--youtube-red);
        color: white;
    }

    @media (max-width: 768px) {
        .playlist-title {
            font-size: 2rem;
        }
        
        .video-thumbnail {
            height: 150px;
        }
        
        .video-content {
            padding: 1rem;
        }
    }
</style>
</head>
<body>
<?php
// $videos = 

$currentVideo = 0; // Currently playing video index
?>

<!-- Header -->
<div class="playlist-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="playlist-title">
                    <i class="fas fa-play-circle me-3"></i>
                    PHP Standards & Best Practices
                </h1>
                <div class="playlist-stats">
                    <span><i class="fas fa-video me-2"></i><?php echo count($videos); ?> videos</span>
                    <span class="ms-4"><i class="fas fa-clock me-2"></i>Complete Course</span>
                    <span class="ms-4"><i class="fas fa-code me-2"></i>PHP Development</span>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-light btn-lg">
                    <i class="fas fa-download me-2"></i>Save Playlist
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container">
    <div class="row">
        <!-- Video List -->
        <div class="col-lg-8">
            <div class="row">
                <?php foreach ($videos as $index => $video): ?>
                <div class="col-md-6 mb-4">
                    <div class="video-card <?php echo $index === $currentVideo ? 'current-playing' : ''; ?>" 
                            onclick="playVideo(<?php echo $index; ?>)">
                        <div class="video-thumbnail" 
                                style="background-image: url('<?php echo $video['thumbnail']; ?>');">
                            <div class="video-number"><?php echo $index + 1; ?></div>
                            <div class="play-button">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                        <div class="video-content">
                            <h3 class="video-title"><?php echo htmlspecialchars($video['title']); ?></h3>
                            <p class="video-description"><?php echo htmlspecialchars(substr($video['description'], 0, 150)) . '...'; ?></p>
                            <div class="video-meta">
                                <span><i class="fas fa-play-circle me-1"></i>Video <?php echo $index + 1; ?></span>
                                <span><i class="fas fa-eye me-1"></i>Watch</span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Sidebar - Now Playing -->
        <div class="col-lg-4">
            <div class="sidebar">
                <h4><i class="fas fa-play me-2 text-danger"></i>Now Playing</h4>
                
                <div class="current-video">
                    <i class="fab fa-youtube"></i>
                </div>
                
                <h5 class="now-playing-title" id="currentTitle">
                    <?php echo htmlspecialchars($videos[$currentVideo]['title']); ?>
                </h5>
                
                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>
                
                <div class="control-buttons">
                    <button class="control-btn" onclick="previousVideo()">
                        <i class="fas fa-step-backward"></i> Prev
                    </button>
                    <button class="control-btn active">
                        <i class="fas fa-pause"></i> Pause
                    </button>
                    <button class="control-btn" onclick="nextVideo()">
                        Next <i class="fas fa-step-forward"></i>
                    </button>
                </div>
                
                <div class="mt-4">
                    <h6><i class="fas fa-info-circle me-2"></i>Course Info</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check-circle text-success me-2"></i>PSR Standards</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Best Practices</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Composer</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Autoloading</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Error Handling</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    let currentVideoIndex = <?php echo $currentVideo; ?>;
    const videos = <?php echo json_encode($videos); ?>;

    function playVideo(index) {
        currentVideoIndex = index;
        
        // Remove current playing class from all cards
        document.querySelectorAll('.video-card').forEach(card => {
            card.classList.remove('current-playing');
        });
        
        // Add current playing class to selected card
        document.querySelectorAll('.video-card')[index].classList.add('current-playing');
        
        // Update sidebar
        document.getElementById('currentTitle').textContent = videos[index].title;
        
        // Simulate video loading
        const currentVideo = document.querySelector('.current-video');
        currentVideo.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        
        setTimeout(() => {
            currentVideo.innerHTML = '<i class="fab fa-youtube"></i>';
        }, 1000);
    }

    function nextVideo() {
        if (currentVideoIndex < videos.length - 1) {
            playVideo(currentVideoIndex + 1);
        }
    }

    function previousVideo() {
        if (currentVideoIndex > 0) {
            playVideo(currentVideoIndex - 1);
        }
    }

    // Auto-play next video simulation
    function autoPlay() {
        if (currentVideoIndex < videos.length - 1) {
            setTimeout(() => {
                nextVideo();
                autoPlay();
            }, 15000); // Change video every 15 seconds
        }
    }

    // Uncomment to enable auto-play
    // autoPlay();
</script>