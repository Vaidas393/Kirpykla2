<?php
include('config/db.php');
include('structure/head.php');
include('structure/header.php');

// Check if post ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: blog.php");
    exit;
}

$post_id = intval($_GET['id']);

// Fetch post details
$post_query = mysqli_query($con, "SELECT * FROM posts WHERE id = $post_id");
$post = mysqli_fetch_assoc($post_query);
if (!$post) {
    header("Location: blog.php");
    exit;
}

// Fetch media for the post
$media_query = mysqli_query($con, "SELECT * FROM post_media WHERE post_id = $post_id");
$media_items = [];
while ($media = mysqli_fetch_assoc($media_query)) {
    $media_items[] = $media;
}

// Fetch YouTube/Google Drive links
$links_query = mysqli_query($con, "SELECT * FROM post_links WHERE post_id = $post_id");
$links = [];
while ($link = mysqli_fetch_assoc($links_query)) {
    $links[] = $link;
}

// Categorize media
$images = [];
$videos = [];
$youtubeLinks = [];
$googleDriveLinks = [];

foreach ($media_items as $media) {
    if ($media['file_type'] == 'image') {
        $images[] = $media['file_path'];
    } elseif ($media['file_type'] == 'video') {
        $videos[] = $media['file_path'];
    }
}

foreach ($links as $link) {
    if (strpos($link['link'], 'youtube.com') !== false) {
        $youtubeLinks[] = $link['link'];
    } elseif (strpos($link['link'], 'drive.google.com') !== false) {
        $googleDriveLinks[] = $link['link'];
    }
}
?>

<main id="main">
    <div class="breadcrumbs d-flex align-items-center" style="background-image: url('assets/img/breadcrumbs-bg.jpg');">
        <div class="container d-flex flex-column align-items-center">
            <h2>Blog Details</h2>
            <ol>
                <li><a href="index.php">Home</a></li>
                <li>Blog Details</li>
            </ol>
        </div>
    </div>

    <section id="blog" class="blog">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    <article class="blog-details">
                        <h2 class="title"><?= htmlspecialchars($post['title']); ?></h2>

                        <div class="meta-top">
                            <ul>
                                <li class="d-flex align-items-center">
                                    <i class="bi bi-clock"></i>
                                    <time datetime="<?= $post['created_at']; ?>">
                                        <?= date('F d, Y', strtotime($post['created_at'])) ?>
                                    </time>
                                </li>
                            </ul>
                        </div>

                        <div class="content">
                            <p><strong>Description:</strong> <?= htmlspecialchars($post['description']); ?></p>
                            <p><strong>Details:</strong> <?= nl2br(htmlspecialchars($post['details'])); ?></p>
                        </div>

                        <!-- Media Display -->
                        <?php if (count($images) > 0) : ?>
                            <div class="media-images mt-3">
                                <h5>Images</h5>
                                <div class="row">
                                    <?php foreach ($images as $image) : ?>
                                        <div class="col-md-4 mb-3">
                                            <a href="<?= htmlspecialchars($image); ?>" target="_blank">
                                                <img src="<?= htmlspecialchars($image); ?>" class="img-fluid rounded w-100" alt="Image">
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (count($videos) > 0) : ?>
                            <div class="media-videos mt-3">
                                <h5>Videos</h5>
                                <div class="row">
                                    <?php foreach ($videos as $video) : ?>
                                        <div class="col-md-12 mb-3">
                                            <video controls class="w-100">
                                                <source src="<?= htmlspecialchars($video); ?>" type="video/mp4">
                                            </video>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (count($youtubeLinks) > 0) : ?>
                            <div class="media-youtube mt-3">
                                <h5>YouTube Videos</h5>
                                <div class="row">
                                    <?php foreach ($youtubeLinks as $youtubeLink) :
                                        $videoId = explode("v=", $youtubeLink)[1];
                                        if (strpos($videoId, "&")) {
                                            $videoId = strtok($videoId, '&');
                                        }
                                    ?>
                                        <div class="col-md-12 mb-3">
                                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/<?= htmlspecialchars($videoId); ?>" frameborder="0" allowfullscreen></iframe>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (count($googleDriveLinks) > 0) : ?>
                            <div class="media-google mt-3">
                                <h5>Google Drive Videos</h5>
                                <div class="row">
                                    <?php foreach ($googleDriveLinks as $googleDriveLink) : ?>
                                        <div class="col-md-12 mb-3">
                                            <iframe src="<?= htmlspecialchars($googleDriveLink) ?>" width="100%" height="450" frameborder="0" allow="autoplay"></iframe>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </article>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include('structure/footer.php'); ?>
