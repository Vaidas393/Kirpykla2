<?php
include('../config/db.php');
$message = "";

// Check if project ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: projectView.php");
    exit;
}

$project_id = intval($_GET['id']);

// Fetch project details
$project_query = mysqli_query($con, "SELECT * FROM projects WHERE id = $project_id");
$project = mysqli_fetch_assoc($project_query);
if (!$project) {
    header("Location: projectView.php");
    exit;
}

// Fetch external links
$link_query = mysqli_query($con, "SELECT * FROM project_links WHERE project_id = $project_id");
$links = mysqli_fetch_all($link_query, MYSQLI_ASSOC);

// Fetch video media
$video_query = mysqli_query($con, "SELECT * FROM project_media WHERE project_id = $project_id");
$videos = mysqli_fetch_all($video_query, MYSQLI_ASSOC);

// Fetch dynamic categories for dropdown
$cat_query = "SELECT * FROM project_categories ORDER BY name";
$cat_result = mysqli_query($con, $cat_query);
$categories = mysqli_fetch_all($cat_result, MYSQLI_ASSOC);

// Function for resizing images (as provided earlier)
function resizeImage($source, $destination, $new_width, $new_height, $quality = 80) {
    list($width, $height, $imageType) = getimagesize($source);
    $newImage = imagecreatetruecolor($new_width, $new_height);

    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $image = imagecreatefromjpeg($source);
            break;
        case IMAGETYPE_PNG:
            $image = imagecreatefrompng($source);
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            break;
        case IMAGETYPE_GIF:
            $image = imagecreatefromgif($source);
            break;
        default:
            return false;
    }

    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    switch ($imageType) {
        case IMAGETYPE_JPEG:
            imagejpeg($newImage, $destination, $quality);
            break;
        case IMAGETYPE_PNG:
            $pngQuality = 9 - round(($quality/100) * 9);
            imagepng($newImage, $destination, $pngQuality);
            break;
        case IMAGETYPE_GIF:
            imagegif($newImage, $destination);
            break;
    }

    imagedestroy($image);
    imagedestroy($newImage);
    return true;
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_project'])) {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $category_id = mysqli_real_escape_string($con, $_POST['category']);

    // Handle Thumbnail Image update/deletion
    if (isset($_POST['delete_thumbnail']) && $_POST['delete_thumbnail'] == "1") {
        if (!empty($project['thumbnail']) && file_exists("../uploads/" . $project['thumbnail'])) {
            unlink("../uploads/" . $project['thumbnail']);
        }
        $thumbnail_name = "";
    } else {
        if (!empty($_FILES['thumbnail']['name'])) {
            if (!empty($project['thumbnail']) && file_exists("../uploads/" . $project['thumbnail'])) {
                unlink("../uploads/" . $project['thumbnail']);
            }
            $thumbnail_name = time() . '_' . basename($_FILES['thumbnail']['name']);
            $thumbnail_target = "../uploads/" . $thumbnail_name;
            if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $thumbnail_target)) {
                // Resize thumbnail to, for example, 300x200
                resizeImage($thumbnail_target, $thumbnail_target, 300, 200, 80);
            } else {
                $message .= "<div class='alert alert-warning'>Failed to upload new thumbnail!</div>";
                $thumbnail_name = $project['thumbnail'];
            }
        } else {
            $thumbnail_name = $project['thumbnail'];
        }
    }

    // Handle Full Size Image update/deletion
    if (isset($_POST['delete_full_image']) && $_POST['delete_full_image'] == "1") {
        if (!empty($project['full_image']) && file_exists("../uploads/" . $project['full_image'])) {
            unlink("../uploads/" . $project['full_image']);
        }
        $full_image_name = "";
    } else {
        if (!empty($_FILES['full_image']['name'])) {
            if (!empty($project['full_image']) && file_exists("../uploads/" . $project['full_image'])) {
                unlink("../uploads/" . $project['full_image']);
            }
            $full_image_name = time() . '_' . basename($_FILES['full_image']['name']);
            $full_image_target = "../uploads/" . $full_image_name;
            if (!move_uploaded_file($_FILES["full_image"]["tmp_name"], $full_image_target)) {
                $message .= "<div class='alert alert-warning'>Failed to upload new full image!</div>";
                $full_image_name = $project['full_image'];
            }
        } else {
            $full_image_name = $project['full_image'];
        }
    }

    // Update the project record
    $update_query = "UPDATE projects SET title='$title', description='$description', category_id='$category_id', thumbnail='$thumbnail_name', full_image='$full_image_name' WHERE id=$project_id";
    if (mysqli_query($con, $update_query)) {
        $message .= "<div class='alert alert-success'>Project updated successfully!</div>";
    } else {
        $message .= "<div class='alert alert-danger'>Error updating project: " . mysqli_error($con) . "</div>";
    }

    // Handle external links update:
    // For simplicity, delete all existing links and then reinsert new ones from the textarea.
    if (isset($_POST['links'])) {
        $newLinks = mysqli_real_escape_string($con, $_POST['links']);
        mysqli_query($con, "DELETE FROM project_links WHERE project_id=$project_id");
        $linkLines = explode("\n", $newLinks);
        foreach ($linkLines as $line) {
            $line = trim($line);
            if (!empty($line)) {
                if (strpos($line, 'youtube.com') !== false || strpos($line, 'youtu.be') !== false) {
                    $link_type = 'youtube';
                } elseif (strpos($line, 'drive.google.com') !== false) {
                    $link_type = 'google_drive';
                } else {
                    $link_type = 'other';
                }
                $stmt_link = mysqli_prepare($con, "INSERT INTO project_links (project_id, link, link_type) VALUES (?, ?, ?)");
                mysqli_stmt_bind_param($stmt_link, "iss", $project_id, $line, $link_type);
                mysqli_stmt_execute($stmt_link);
            }
        }
    }

    // Handle additional video uploads (existing videos remain)
    if (!empty($_FILES['videos']['name'][0])) {
        $upload_dir = "../uploads/";
        foreach ($_FILES['videos']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['videos']['error'][$key] == UPLOAD_ERR_OK) {
                $video_name = uniqid() . "_" . basename($_FILES['videos']['name'][$key]);
                $video_target = $upload_dir . $video_name;
                if (move_uploaded_file($tmp_name, $video_target)) {
                    $stmt_video = mysqli_prepare($con, "INSERT INTO project_media (project_id, file_path, file_type) VALUES (?, ?, 'video')");
                    mysqli_stmt_bind_param($stmt_video, "is", $project_id, $video_name);
                    mysqli_stmt_execute($stmt_video);
                }
            }
        }
    }

    // Refresh project details after update
    $project_query = mysqli_query($con, "SELECT * FROM projects WHERE id = $project_id");
    $project = mysqli_fetch_assoc($project_query);
}

include('includes/header.php');
?>

<div class="container mt-4">
    <h2>Edit Project</h2>
    <?= $message; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Project Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($project['title']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Project Description</label>
            <textarea name="description" class="form-control" required><?= htmlspecialchars($project['description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category" class="form-control" required>
                <option value="">-- Select Category --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id']; ?>" <?= ($cat['id'] == $project['category_id']) ? 'selected' : ''; ?>><?= htmlspecialchars($cat['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Thumbnail Image (small carousel) - optional</label>
            <?php if (!empty($project['thumbnail'])): ?>
                <div>
                    <img src="../uploads/<?= $project['thumbnail']; ?>" width="150" alt="Thumbnail">
                    <label><input type="checkbox" name="delete_thumbnail" value="1"> Delete</label>
                </div>
            <?php endif; ?>
            <input type="file" name="thumbnail" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Full Size Image - optional</label>
            <?php if (!empty($project['full_image'])): ?>
                <div>
                    <img src="../uploads/<?= $project['full_image']; ?>" width="150" alt="Full Image">
                    <label><input type="checkbox" name="delete_full_image" value="1"> Delete</label>
                </div>
            <?php endif; ?>
            <input type="file" name="full_image" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Existing External Links</label>
            <?php if (!empty($links)): ?>
                <ul>
                    <?php foreach ($links as $link): ?>
                        <li><?= htmlspecialchars($link['link']); ?>
                            <a href="delete_project_link.php?id=<?= $link['id']; ?>&project_id=<?= $project_id; ?>" class="text-danger" onclick="return confirm('Delete this link?');">Delete</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No links added.</p>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Add/Replace External Links (one per line)</label>
            <textarea name="links" class="form-control" placeholder="Paste new links here..."></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Upload Additional Videos (optional, multiple allowed)</label>
            <input type="file" name="videos[]" class="form-control" multiple accept="video/*">
        </div>

        <button type="submit" name="edit_project" class="btn btn-primary">Update Project</button>
    </form>

    <!-- Option to delete entire project -->
</div>

<?php include('includes/footer.php'); ?>
