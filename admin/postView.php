<?php
include('../config/db.php');

// Handle post deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Fetch all image file paths before deleting
    $media_query = mysqli_query($con, "SELECT file_path FROM post_media WHERE post_id = $id");
    while ($media = mysqli_fetch_assoc($media_query)) {
        $file_path = "../" . $media['file_path']; // Adjust path as needed
        if (file_exists($file_path)) {
            unlink($file_path); // Delete file from server
        }
    }

    // Delete media associated with the post
    mysqli_query($con, "DELETE FROM post_media WHERE post_id = $id");

    // Delete post links (YouTube, Google Drive)
    mysqli_query($con, "DELETE FROM post_links WHERE post_id = $id");

    // Finally, delete the post
    mysqli_query($con, "DELETE FROM posts WHERE id = $id");

    header("Location: postView.php");
    exit;
}

// Handle status toggle
if (isset($_GET['toggle_status'])) {
    $id = intval($_GET['toggle_status']);
    $result = mysqli_query($con, "SELECT status FROM posts WHERE id = $id");

    if ($result) {
        $post = mysqli_fetch_assoc($result);
        $new_status = ($post['status'] == 'active') ? 'inactive' : 'active';
        mysqli_query($con, "UPDATE posts SET status = '$new_status' WHERE id = $id");
    }
    header("Location: postView.php");
    exit;
}

// Fetch all posts with their categories, subcategories, and check for media presence
$posts = mysqli_query($con, "
    SELECT posts.id, posts.title, posts.description, posts.status,
           categories.name AS category_name,
           subcategories.name AS subcategory_name,
           (SELECT COUNT(*) FROM post_media WHERE post_media.post_id = posts.id) AS media_count,
           (SELECT COUNT(*) FROM post_links WHERE post_links.post_id = posts.id) AS link_count
    FROM posts
    LEFT JOIN categories ON posts.category_id = categories.id
    LEFT JOIN subcategories ON posts.subcategory_id = subcategories.id
    ORDER BY posts.id DESC
");

include('includes/header.php');
?>

<div class="container mt-4">
    <h2>Manage Posts</h2>
    <table id="postTable" class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Status</th>
                <th>Media</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($post = mysqli_fetch_assoc($posts)) { ?>
                <tr>
                    <td><?= $post['id'] ?></td>
                    <td><?= htmlspecialchars($post['title']) ?></td>
                    <td><?= htmlspecialchars($post['category_name']) ?></td>
                    <td><?= $post['subcategory_name'] ?: '-' ?></td>
                    <td>
                        <a href="postView.php?toggle_status=<?= $post['id'] ?>" class="btn btn-sm
                        <?= ($post['status'] == 'active') ? 'btn-success' : 'btn-secondary' ?>">
                            <?= ucfirst($post['status']) ?>
                        </a>
                    </td>
                    <td>
                        <?php if ($post['media_count'] > 0 || $post['link_count'] > 0) { ?>
                            <span class="badge bg-primary">Has Media</span>
                        <?php } else { ?>
                            <span class="badge bg-secondary">No Media</span>
                        <?php } ?>
                    </td>
                    <td>
                        <a href="postEdit.php?id=<?= $post['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="postView.php?delete=<?= $post['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        new simpleDatatables.DataTable("#postTable");
    });
</script>

<?php include('includes/footer.php'); ?>
