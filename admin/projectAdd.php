<?php
include('../config/db.php');
$message = "";

/* --- GD Resizing Function --- */
function resizeImage($source, $destination, $new_width, $new_height, $quality = 80) {
    list($width, $height, $imageType) = getimagesize($source);
    $newImage = imagecreatetruecolor($new_width, $new_height);

    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $image = imagecreatefromjpeg($source);
            break;
        case IMAGETYPE_PNG:
            $image = imagecreatefrompng($source);
            // preserve transparency
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
            // PNG quality: 0 (best quality) to 9 (worst)
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

/* --- Fetch dynamic categories --- */
$cat_query = "SELECT * FROM project_categories ORDER BY name";
$categories_result = mysqli_query($con, $cat_query);

/* --- Process Form Submission --- */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_project'])) {
    $title       = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $category_id = mysqli_real_escape_string($con, $_POST['category']); // category now holds the id

    // Optional images; set default to empty strings if not provided
    $thumbnail_name = "";
    $full_image_name = "";

    // Process Thumbnail Image if provided
    if (!empty($_FILES['thumbnail']['name'])) {
        $thumbnail_name   = time() . '_' . basename($_FILES['thumbnail']['name']);
        $thumbnail_target = "../uploads/" . $thumbnail_name;
        if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $thumbnail_target)) {
            // Resize the thumbnail image (e.g., to 300x200)
            resizeImage($thumbnail_target, $thumbnail_target, 300, 200, 80);
        } else {
            $message .= "<div class='alert alert-warning'>Failed to upload thumbnail!</div>";
        }
    }

    // Process Full Size Image if provided
    if (!empty($_FILES['full_image']['name'])) {
        $full_image_name   = time() . '_' . basename($_FILES['full_image']['name']);
        $full_image_target = "../uploads/" . $full_image_name;
        if (!move_uploaded_file($_FILES["full_image"]["tmp_name"], $full_image_target)) {
            $message .= "<div class='alert alert-warning'>Failed to upload full image!</div>";
        }
    }

    // Insert project record into database (images are optional)
    $query = "INSERT INTO projects (title, description, category_id, thumbnail, full_image)
              VALUES ('$title', '$description', '$category_id', '$thumbnail_name', '$full_image_name')";
    if (mysqli_query($con, $query)) {
        $project_id = mysqli_insert_id($con);

        // Process external links if provided
        if (!empty($_POST['links'])) {
            $links = mysqli_real_escape_string($con, $_POST['links']);
            // Regex to extract YouTube and Google Drive links
            preg_match_all('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:watch\?v=|playlist\?list=)|youtu\.be\/)([A-Za-z0-9-_]+)|(?:https?:\/\/)?drive\.google\.com\/(?:file\/d\/|open\?id=)([A-Za-z0-9-_]+)/', $links, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                $link = !empty($match[1]) ? "https://www.youtube.com/watch?v=" . $match[1] : "https://drive.google.com/file/d/" . $match[2];
                $link_type = !empty($match[1]) ? "youtube" : "google_drive";
                $stmt_link = mysqli_prepare($con, "INSERT INTO project_links (project_id, link, link_type) VALUES (?, ?, ?)");
                mysqli_stmt_bind_param($stmt_link, "iss", $project_id, $link, $link_type);
                mysqli_stmt_execute($stmt_link);
            }
        }

        // Process video uploads (multiple allowed)
        if (!empty($_FILES['videos']['name'][0])) {
            $upload_dir = "../uploads/";
            foreach ($_FILES['videos']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['videos']['error'][$key] == UPLOAD_ERR_OK) {
                    $video_name   = uniqid() . "_" . basename($_FILES['videos']['name'][$key]);
                    $video_target = $upload_dir . $video_name;
                    if (move_uploaded_file($tmp_name, $video_target)) {
                        $stmt_video = mysqli_prepare($con, "INSERT INTO project_media (project_id, file_path, file_type) VALUES (?, ?, 'video')");
                        mysqli_stmt_bind_param($stmt_video, "is", $project_id, $video_name);
                        mysqli_stmt_execute($stmt_video);
                    }
                }
            }
        }
        $message .= "<div class='alert alert-success'>Project added successfully!</div>";
    } else {
        $message .= "<div class='alert alert-danger'>Error adding project: " . mysqli_error($con) . "</div>";
    }
}

include('includes/header.php');
?>

<div class="container mt-4">
  <h2>Add New Project</h2>
  <?= $message; ?>
  <form method="POST" enctype="multipart/form-data">
      <div class="mb-3">
          <label class="form-label">Project Title</label>
          <input type="text" name="title" class="form-control" required>
      </div>
      <div class="mb-3">
          <label class="form-label">Project Description</label>
          <textarea name="description" class="form-control" required></textarea>
      </div>
      <div class="mb-3">
          <label class="form-label">Category</label>
          <select name="category" class="form-control" required>
              <option value="">-- Select Category --</option>
              <?php while ($cat = mysqli_fetch_assoc($categories_result)) { ?>
                <option value="<?= $cat['id']; ?>"><?= htmlspecialchars($cat['name']); ?></option>
              <?php } ?>
          </select>
      </div>
      <div class="mb-3">
          <label class="form-label">Thumbnail Image (small carousel) - optional</label>
          <input type="file" name="thumbnail" class="form-control">
      </div>
      <div class="mb-3">
          <label class="form-label">Full Size Image - optional</label>
          <input type="file" name="full_image" class="form-control">
      </div>
      <div class="mb-3">
          <label class="form-label">Upload Videos (optional, multiple allowed)</label>
          <input type="file" name="videos[]" class="form-control" multiple accept="video/*">
      </div>
      <div class="mb-3">
          <label class="form-label">Paste YouTube/Google Drive Links (optional)</label>
          <textarea name="links" class="form-control" rows="3" placeholder="Paste links here..."></textarea>
      </div>
      <button type="submit" name="add_project" class="btn btn-primary">Add Project</button>
  </form>
</div>

<?php include('includes/footer.php'); ?>
