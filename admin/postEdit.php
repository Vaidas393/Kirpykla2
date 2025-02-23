<?php
include('../config/db.php');

// Check if post ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: postView.php");
    exit;
}

$post_id = intval($_GET['id']);

// Fetch post details
$post_query = mysqli_query($con, "SELECT * FROM posts WHERE id = $post_id");
$post = mysqli_fetch_assoc($post_query);
if (!$post) {
    header("Location: postView.php");
    exit;
}

// Fetch categories
$categories = mysqli_query($con, "SELECT * FROM categories ORDER BY name");

// Fetch subcategories
$subcategories = mysqli_query($con, "SELECT * FROM subcategories WHERE category_id = {$post['category_id']} ORDER BY name");

// Fetch existing media (images & videos)
$media_query = mysqli_query($con, "SELECT * FROM post_media WHERE post_id = $post_id");
$existing_media = [];
while ($media = mysqli_fetch_assoc($media_query)) {
    $existing_media[] = $media;
}

// Fetch existing YouTube/Google Drive links
$links_query = mysqli_query($con, "SELECT * FROM post_links WHERE post_id = $post_id");

// Handle form submission for updating post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = trim($_POST['category_id']);
    $subcategory_id = !empty($_POST['subcategory_id']) ? trim($_POST['subcategory_id']) : NULL;
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $details = trim($_POST['details']);
    $links = trim($_POST['links']);

    if (!empty($category_id) && !empty($title) && !empty($description) && !empty($details)) {
        mysqli_query($con, "UPDATE posts SET
            category_id = '$category_id',
            subcategory_id = " . ($subcategory_id ? "'$subcategory_id'" : "NULL") . ",
            title = '$title',
            description = '$description',
            details = '$details'
            WHERE id = $post_id
        ");

        // Handle YouTube/Google Drive links
        if (!empty($links)) {
            mysqli_query($con, "DELETE FROM post_links WHERE post_id = $post_id");

            preg_match_all('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:watch\?v=|playlist\?list=)|youtu\.be\/)([A-Za-z0-9-_]+)|(?:https?:\/\/)?drive\.google\.com\/(?:file\/d\/|open\?id=)([A-Za-z0-9-_]+)/', $links, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                $link = !empty($match[1]) ? "https://www.youtube.com/watch?v=" . $match[1] : "https://drive.google.com/file/d/" . $match[2];
                $link_type = !empty($match[1]) ? "youtube" : "google_drive";

                mysqli_query($con, "INSERT INTO post_links (post_id, link, link_type) VALUES ($post_id, '$link', '$link_type')");
            }
        }

        // Handle new media uploads (images & videos)
        if (!empty($_FILES['media']['name'][0])) {
            foreach ($_FILES['media']['tmp_name'] as $key => $tmp_name) {
                $file_name = $_FILES['media']['name'][$key];
                $file_tmp = $_FILES['media']['tmp_name'][$key];

                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $file_type = in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif']) ? 'image' : (in_array($file_ext, ['mp4', 'mov', 'avi']) ? 'video' : '');

                if ($file_type) {
                    $upload_dir = "uploads/";
                    $file_path = $upload_dir . uniqid() . "_" . $file_name;
                    move_uploaded_file($file_tmp, "../" . $file_path);

                    mysqli_query($con, "INSERT INTO post_media (post_id, file_path, file_type) VALUES ($post_id, '$file_path', '$file_type')");
                }
            }
        }

        echo "<div class='alert alert-success'>Post updated successfully!</div>";
        header("Refresh: 1");
    } else {
        echo "<div class='alert alert-danger'>Category, Title, Description, and Details are required!</div>";
    }
}

// Handle media deletion
if (isset($_GET['delete_media'])) {
    $media_id = intval($_GET['delete_media']);
    $media_query = mysqli_query($con, "SELECT file_path FROM post_media WHERE id = $media_id AND post_id = $post_id");
    $media = mysqli_fetch_assoc($media_query);

    if ($media) {
        unlink("../" . $media['file_path']);
        mysqli_query($con, "DELETE FROM post_media WHERE id = $media_id");
    }
    header("Location: postEdit.php?id=$post_id");
    exit;
}

// Handle link deletion
if (isset($_GET['delete_link'])) {
    $link_id = intval($_GET['delete_link']);
    mysqli_query($con, "DELETE FROM post_links WHERE id = $link_id AND post_id = $post_id");
    header("Location: postEdit.php?id=$post_id");
    exit;
}

include('includes/header.php');
?>

<div class="container mt-4">
    <h2>Edit Post</h2>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Select Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <?php while ($category = mysqli_fetch_assoc($categories)) { ?>
                    <option value="<?= $category['id'] ?>" <?= ($category['id'] == $post['category_id']) ? 'selected' : '' ?>><?= $category['name'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Select Subcategory</label>
            <select name="subcategory_id" id="subcategory_id" class="form-control">
                <option value="">-- Select Subcategory --</option>
                <?php while ($subcategory = mysqli_fetch_assoc($subcategories)) { ?>
                    <option value="<?= $subcategory['id'] ?>" <?= ($subcategory['id'] == $post['subcategory_id']) ? 'selected' : '' ?>><?= $subcategory['name'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Post Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($post['title']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Short Description</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars($post['description']); ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Full Details</label>
            <textarea name="details" class="form-control"><?= htmlspecialchars($post['details']); ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Existing Media</label>
            <div>
                <?php foreach ($existing_media as $media) { ?>
                    <div class="d-inline-block position-relative me-2">
                        <?php if ($media['file_type'] === 'image') { ?>
                            <img src="../<?= $media['file_path']; ?>" alt="Image" class="img-thumbnail" width="100">
                        <?php } elseif ($media['file_type'] === 'video') { ?>
                            <video width="100" controls>
                                <source src="../<?= $media['file_path']; ?>" type="video/mp4">
                            </video>
                        <?php } ?>
                        <a href="postEdit.php?id=<?= $post_id ?>&delete_media=<?= $media['id'] ?>" class="btn btn-sm btn-danger position-absolute top-0 end-0">X</a>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Upload New Images or Videos</label>
            <input type="file" name="media[]" class="form-control" multiple accept="image/*,video/*">
        </div>

        <div class="mb-3">
            <label class="form-label">YouTube/Google Drive Links</label>
            <ul>
                <?php while ($link = mysqli_fetch_assoc($links_query)) { ?>
                    <li><?= $link['link'] ?> <a href="postEdit.php?id=<?= $post_id ?>&delete_link=<?= $link['id'] ?>" class="text-danger">Delete</a></li>
                <?php } ?>
            </ul>
            <textarea name="links" class="form-control" placeholder="Paste YouTube/Google Drive links here..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Post</button>
        <a href="postView.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include('includes/footer.php'); ?>
