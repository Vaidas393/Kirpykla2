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
            // PNG quality: 0 (best) to 9 (worst)
            $pngQuality = 9 - round(($quality / 100) * 9);
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

// Check if testimonial ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: testimonialView.php");
    exit;
}

$testimonial_id = intval($_GET['id']);

// Fetch testimonial details
$query = "SELECT * FROM testimonials WHERE id = $testimonial_id";
$result = mysqli_query($con, $query);
$testimonial = mysqli_fetch_assoc($result);
if (!$testimonial) {
    header("Location: testimonialView.php");
    exit;
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_testimonial'])) {
    $name = mysqli_real_escape_string($con, trim($_POST['name']));
    $designation = mysqli_real_escape_string($con, trim($_POST['designation']));
    $rating = intval($_POST['rating']);
    $content = mysqli_real_escape_string($con, trim($_POST['content']));

    // Handle image deletion/replacement
    if (isset($_POST['delete_image']) && $_POST['delete_image'] == "1") {
        if (!empty($testimonial['image']) && file_exists("../uploads/" . $testimonial['image'])) {
            unlink("../uploads/" . $testimonial['image']);
        }
        $image_name = "";
    } else {
        if (!empty($_FILES['image']['name'])) {
            if (!empty($testimonial['image']) && file_exists("../uploads/" . $testimonial['image'])) {
                unlink("../uploads/" . $testimonial['image']);
            }
            $image_name = time() . '_' . basename($_FILES['image']['name']);
            $target = "../uploads/" . $image_name;
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target)) {
                // Resize to 150x150 at 80% quality
                resizeImage($target, $target, 150, 150, 80);
            } else {
                $message .= "<div class='alert alert-warning'>Failed to upload new image!</div>";
                $image_name = $testimonial['image'];
            }
        } else {
            $image_name = $testimonial['image'];
        }
    }

    // Update testimonial record
    $updateQuery = "UPDATE testimonials SET name='$name', designation='$designation', rating=$rating, content='$content', image='$image_name' WHERE id=$testimonial_id";
    if (mysqli_query($con, $updateQuery)) {
        $message .= "<div class='alert alert-success'>Testimonial updated successfully!</div>";
        // Refresh testimonial details
        $query = "SELECT * FROM testimonials WHERE id = $testimonial_id";
        $result = mysqli_query($con, $query);
        $testimonial = mysqli_fetch_assoc($result);
    } else {
        $message .= "<div class='alert alert-danger'>Error updating testimonial: " . mysqli_error($con) . "</div>";
    }
}

include('includes/header.php');
?>

<div class="container mt-4">
    <h2>Edit Testimonial</h2>
    <?= $message; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($testimonial['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Designation</label>
            <input type="text" name="designation" class="form-control" value="<?= htmlspecialchars($testimonial['designation']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Rating (1-5)</label>
            <input type="number" name="rating" class="form-control" value="<?= $testimonial['rating']; ?>" min="1" max="5" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Testimonial Content</label>
            <textarea name="content" class="form-control" rows="4" required><?= htmlspecialchars($testimonial['content']); ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Testimonial Image (current image will be cropped to 150x150, 80% quality)</label>
            <?php if (!empty($testimonial['image'])): ?>
                <div>
                    <img src="../uploads/<?= $testimonial['image']; ?>" width="100" alt="Testimonial Image">
                    <label><input type="checkbox" name="delete_image" value="1"> Delete Image</label>
                </div>
            <?php endif; ?>
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" name="edit_testimonial" class="btn btn-primary">Update Testimonial</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
