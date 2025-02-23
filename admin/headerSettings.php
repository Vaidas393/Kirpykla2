<?php
include('../config/db.php');

// Fetch current settings
$result = mysqli_query($con, "SELECT * FROM site_settings LIMIT 1");
$site_settings = mysqli_fetch_assoc($result);

// Resize and optimize image function
function resizeImage($source, $destination, $width, $height, $quality = 80) {
    list($origWidth, $origHeight, $imageType) = getimagesize($source);
    $newImage = imagecreatetruecolor($width, $height);

    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $image = imagecreatefromjpeg($source); break;
        case IMAGETYPE_PNG:
            $image = imagecreatefrompng($source);
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            break;
        case IMAGETYPE_GIF:
            $image = imagecreatefromgif($source); break;
        default: return false;
    }

    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $width, $height, $origWidth, $origHeight);

    switch ($imageType) {
        case IMAGETYPE_JPEG:
            imagejpeg($newImage, $destination, $quality); break;
        case IMAGETYPE_PNG:
            imagepng($newImage, $destination, 8); break;
        case IMAGETYPE_GIF:
            imagegif($newImage, $destination); break;
    }

    imagedestroy($image);
    imagedestroy($newImage);
    return true;
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $site_title = mysqli_real_escape_string($con, $_POST['site_title']);
    $logo_text = mysqli_real_escape_string($con, $_POST['logo_text']);
    $span_text = mysqli_real_escape_string($con, $_POST['span_text']); // New editable span part

    // Check if deleting the current logo
    if (isset($_POST['delete_logo']) && $_POST['delete_logo'] == 'yes') {
        if (!empty($site_settings['logo']) && file_exists("../uploads/" . $site_settings['logo'])) {
            unlink("../uploads/" . $site_settings['logo']);
        }
        $logo_name = null;
    } else {
        $logo_name = $site_settings['logo']; // retain existing if not deleting
    }

    // New logo upload
    if (!empty($_FILES['logo']['name'])) {
        $logo_name = time() . '_' . basename($_FILES['logo']['name']);
        $target_file = "../uploads/" . $logo_name;

        // Remove old logo
        if (!empty($site_settings['logo']) && file_exists("../uploads/" . $site_settings['logo'])) {
            unlink("../uploads/" . $site_settings['logo']);
        }

        if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
            resizeImage($target_file, $target_file, 200, 60, 80);
        }
    }

    // Update database
    $logo_db = $logo_name ? "'$logo_name'" : "NULL";
    $query = "UPDATE site_settings SET site_title='$site_title', logo=$logo_db, logo_text='$logo_text', span_text='$span_text' WHERE id=1";

    if (mysqli_query($con, $query)) {
        $message = "<div class='alert alert-success'>Header settings updated successfully!</div>";
        $result = mysqli_query($con, "SELECT * FROM site_settings LIMIT 1");
        $site_settings = mysqli_fetch_assoc($result);
    } else {
        $message = "<div class='alert alert-danger'>Error updating settings!</div>";
    }
}

include('includes/header.php');
?>

<div class="container mt-4">
    <h2>Header Settings</h2>
    <?= $message; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Site Title</label>
            <input type="text" name="site_title" class="form-control" value="<?= htmlspecialchars($site_settings['site_title']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Logo</label>
            <input type="file" name="logo" class="form-control">
            <?php if (!empty($site_settings['logo'])): ?>
                <img src="../uploads/<?= htmlspecialchars($site_settings['logo']) ?>" alt="Logo" class="mt-2" width="150">
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" value="yes" id="delete_logo" name="delete_logo">
                    <label class="form-check-label" for="delete_logo">
                        Delete current logo
                    </label>
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Logo Text (Shown when no image)</label>
            <input type="text" name="logo_text" class="form-control" value="<?= htmlspecialchars($site_settings['logo_text']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Span Text (Small Text Inside Header)</label>
            <input type="text" name="span_text" class="form-control" value="<?= htmlspecialchars($site_settings['span_text']) ?>">
        </div>

        <button type="submit" class="btn btn-primary">Update Header</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
