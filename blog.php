<?php
include('config/db.php');
include('structure/head.php');
include('structure/header.php');

$category_id = isset($_GET['category']) ? intval($_GET['category']) : null;
$subcategory_id = isset($_GET['subcategory']) ? intval($_GET['subcategory']) : null;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 9;
$offset = ($page - 1) * $limit;

// Ensure only active posts are displayed
$whereClause = "WHERE posts.status = 'active'";

if ($category_id) {
    $whereClause .= " AND posts.category_id = $category_id";
} elseif ($subcategory_id) {
    $whereClause .= " AND posts.subcategory_id = $subcategory_id";
}

// Fetch active posts with pagination
$query = "
    SELECT posts.*, categories.name AS category_name, subcategories.name AS subcategory_name
    FROM posts
    LEFT JOIN categories ON posts.category_id = categories.id
    LEFT JOIN subcategories ON posts.subcategory_id = subcategories.id
    $whereClause
    ORDER BY posts.created_at DESC
    LIMIT $limit OFFSET $offset
";
$posts = mysqli_query($con, $query);

// Get total number of active posts
$total_posts_query = mysqli_query($con, "SELECT COUNT(*) AS total FROM posts $whereClause");
$total_posts = mysqli_fetch_assoc($total_posts_query)['total'];
$total_pages = ceil($total_posts / $limit);
?>

<main id="main">
    <div class="breadcrumbs d-flex align-items-center" style="background-image: url('assets/img/breadcrumbs-bg.jpg');">
        <div class="container position-relative d-flex flex-column align-items-center">
            <h2>Blogas</h2>
            <ol>
                <li><a href="index.php">Pagrindinis</a></li>
                <li>Blogas</li>
            </ol>
        </div>
    </div>

    <section id="blog" class="blog">
        <div class="container">
            <div class="row gy-4 posts-list">
                <?php while ($post = mysqli_fetch_assoc($posts)) {
                    // Fetch all media items
                    $media_query = mysqli_query($con, "SELECT file_path, file_type FROM post_media WHERE post_id = " . $post['id']);
                    $media_items = [];
                    while ($media = mysqli_fetch_assoc($media_query)) {
                        $media_items[] = $media;
                    }

                    // Fetch links (YouTube & Google Drive)
                    $links_query = mysqli_query($con, "SELECT link FROM post_links WHERE post_id = " . $post['id']);
                    while ($link = mysqli_fetch_assoc($links_query)) {
                        // If it's a Google Drive link, convert it to embed format
                        if (strpos($link['link'], 'drive.google.com') !== false) {
                            if (preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $link['link'], $matches)) {
                                $driveId = $matches[1];
                                $embedLink = "https://drive.google.com/file/d/" . $driveId . "/preview";
                            } else {
                                $embedLink = $link['link'];
                            }
                        } else {
                            $embedLink = $link['link'];
                        }
                        $media_items[] = ["file_path" => $embedLink, "file_type" => "link"];
                    }
                    $first_media = $media_items[0] ?? null;
                    $additional_media_count = count($media_items) - 1;
                ?>
                    <div class="col-xl-4 col-md-6">
                        <div class="post-item position-relative h-100">
                            <div class="post-img position-relative overflow-hidden">
                                <?php if ($first_media) { ?>
                                    <?php if ($first_media['file_type'] == 'image') { ?>
                                        <a href="<?= htmlspecialchars($first_media['file_path']); ?>" target="_blank">
                                            <img src="<?= htmlspecialchars($first_media['file_path']); ?>"
                                                 class="img-fluid w-100"
                                                 alt="Blog Image">
                                        </a>
                                    <?php } elseif ($first_media['file_type'] == 'video') { ?>
                                        <video class="w-100" controls>
                                            <source src="<?= htmlspecialchars($first_media['file_path']); ?>" type="video/mp4">
                                        </video>
                                    <?php } elseif ($first_media['file_type'] == 'link' && strpos($first_media['file_path'], 'youtube.com') !== false) {
                                        $videoId = explode("v=", $first_media['file_path'])[1];
                                        if (strpos($videoId, "&")) { $videoId = explode("&", $videoId)[0]; }
                                    ?>
                                        <iframe width="100%" height="315"
                                                src="https://www.youtube.com/embed/<?= htmlspecialchars($videoId); ?>"
                                                frameborder="0" allowfullscreen></iframe>
                                    <?php } elseif ($first_media['file_type'] == 'link' && strpos($first_media['file_path'], 'drive.google.com') !== false) { ?>
                                        <iframe src="<?= htmlspecialchars($first_media['file_path']); ?>"
                                                width="100%" height="400" frameborder="0" allow="autoplay"></iframe>
                                    <?php } ?>
                                <?php } ?>
                                <?php if ($additional_media_count > 0) { ?>
                                    <span class="media-count badge bg-primary"><?= "+$additional_media_count failų" ?></span>
                                <?php } ?>
                            </div>

                            <div class="post-content d-flex flex-column">
                                <h3 class="post-title">
                                    <a href="blog-details.php?id=<?= $post['id']; ?>"><?= htmlspecialchars($post['title']); ?></a>
                                </h3>
                                <div class="meta d-flex align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-folder2"></i> <span class="ps-2"><?= htmlspecialchars($post['category_name']); ?></span>
                                    </div>
                                </div>
                                <p><?= substr(htmlspecialchars($post['description']), 0, 150) . '...'; ?></p>
                                <hr>
                                <a href="blog-details.php?id=<?= $post['id']; ?>" class="readmore"><span>Skaityti išsamiau</span><i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- Pagination -->
            <div class="blog-pagination">
                <ul class="justify-content-center">
                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                        <li class="<?= ($i == $page) ? 'active' : '' ?>">
                            <a href="blog.php?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </section>
</main>

<?php include('structure/footer.php'); ?>
