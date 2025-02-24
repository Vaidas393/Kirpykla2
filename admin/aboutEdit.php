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
            // Preserve transparency
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

// Fetch current about section data (if exists) for background image handling
$sectionQuery = mysqli_query($con, "SELECT * FROM about_section LIMIT 1");
$aboutData = mysqli_fetch_assoc($sectionQuery);

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_about'])) {
    // Gather main fields
    $main_title         = mysqli_real_escape_string($con, trim($_POST['main_title']));
    $story_heading      = mysqli_real_escape_string($con, trim($_POST['story_heading']));
    $story_subtitle     = mysqli_real_escape_string($con, trim($_POST['story_subtitle']));
    $description        = mysqli_real_escape_string($con, trim($_POST['description']));
    $additional_paragraph = mysqli_real_escape_string($con, trim($_POST['additional_paragraph']));
    $video_link         = mysqli_real_escape_string($con, trim($_POST['video_link']));

    // Process background image upload / deletion
    if (isset($_POST['delete_background']) && $_POST['delete_background'] == "1") {
        if (!empty($aboutData['background_image']) && file_exists("../uploads/" . $aboutData['background_image'])) {
            unlink("../uploads/" . $aboutData['background_image']);
        }
        $background_image_filename = "";
    } else {
        if (!empty($_FILES['background_image']['name'])) {
            // If a new file is uploaded, remove the old one
            if (!empty($aboutData['background_image']) && file_exists("../uploads/" . $aboutData['background_image'])) {
                unlink("../uploads/" . $aboutData['background_image']);
            }
            $background_image_filename = time() . '_' . basename($_FILES['background_image']['name']);
            $target = "../uploads/" . $background_image_filename;
            if (move_uploaded_file($_FILES["background_image"]["tmp_name"], $target)) {
                // Resize to 1920x1080 at 80% quality
                resizeImage($target, $target, 1920, 1080, 80);
            } else {
                $message .= "<div class='alert alert-warning'>Failed to upload new background image!</div>";
                $background_image_filename = $aboutData['background_image'];
            }
        } else {
            $background_image_filename = $aboutData ? $aboutData['background_image'] : "";
        }
    }

    // Update or insert about section record
    if ($aboutData) {
        $sectionId = $aboutData['id'];
        $updateQuery = "UPDATE about_section SET
            background_image = '$background_image_filename',
            main_title = '$main_title',
            story_heading = '$story_heading',
            story_subtitle = '$story_subtitle',
            description = '$description',
            additional_paragraph = '$additional_paragraph',
            video_link = '$video_link'
            WHERE id = $sectionId";
        mysqli_query($con, $updateQuery);
    } else {
        $insertQuery = "INSERT INTO about_section
            (background_image, main_title, story_heading, story_subtitle, description, additional_paragraph, video_link)
            VALUES
            ('$background_image_filename', '$main_title', '$story_heading', '$story_subtitle', '$description', '$additional_paragraph', '$video_link')";
        mysqli_query($con, $insertQuery);
        $sectionId = mysqli_insert_id($con);
    }

    // Process dynamic list items: one per line
    $listItemsText = trim($_POST['list_items']);
    $listItems = array_filter(array_map('trim', explode("\n", $listItemsText)));
    // Delete existing list items for this section
    mysqli_query($con, "DELETE FROM about_list_items WHERE about_section_id = $sectionId");
    // Insert each new list item
    foreach ($listItems as $item) {
        $item = mysqli_real_escape_string($con, $item);
        $stmt = mysqli_prepare($con, "INSERT INTO about_list_items (about_section_id, list_item) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "is", $sectionId, $item);
        mysqli_stmt_execute($stmt);
    }

    $message = "<div class='alert alert-success'>About section updated successfully!</div>";

    // Refresh aboutData after update
    $sectionQuery = mysqli_query($con, "SELECT * FROM about_section LIMIT 1");
    $aboutData = mysqli_fetch_assoc($sectionQuery);
}

$background_image = $aboutData ? $aboutData['background_image'] : ' ';
$main_title         = $aboutData ? $aboutData['main_title'] : ' ';
$story_heading      = $aboutData ? $aboutData['story_heading'] : ' ';
$story_subtitle     = $aboutData ? $aboutData['story_subtitle'] : 'M ';
$description        = $aboutData ? $aboutData['description'] : ' ';
$additional_paragraph = $aboutData ? $aboutData['additional_paragraph'] : ' ';
$video_link         = $aboutData ? $aboutData['video_link'] : ' ';

// Fetch existing list items (if any)
$listQuery = mysqli_query($con, "SELECT list_item FROM about_list_items WHERE about_section_id = " . ($aboutData ? $aboutData['id'] : 0));
$listItems = [];
while ($row = mysqli_fetch_assoc($listQuery)) {
    $listItems[] = $row['list_item'];
}
$listItemsText = implode("\n", $listItems);

include('includes/header.php');
?>

<div class="container mt-4">
    <h2>Edit About Section</h2>
    <?= $message; ?>
    <form method="POST" class="mb-4" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Background Image</label>
            <?php if (!empty($background_image) && file_exists("../uploads/" . $background_image)): ?>
                <div>
                    <img src="../uploads/<?= htmlspecialchars($background_image); ?>" width="150" alt="Background Image">
                    <label><input type="checkbox" name="delete_background" value="1"> Delete Background Image</label>
                </div>
            <?php  else: ?>
                <div>
                    <img src="<?= htmlspecialchars($background_image); ?>" width="150" alt="Background Image">
                    <!-- If using default image, no delete option -->
                </div>
            <?php endif; ?>
            <input type="file" name="background_image" class="form-control">
            <small class="form-text text-muted">Upload new background image (recommended: 1920x1080, 80% quality)</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Main Title</label>
            <input type="text" name="main_title" class="form-control" value="<?= htmlspecialchars($main_title); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Story Heading</label>
            <input type="text" name="story_heading" class="form-control" value="<?= htmlspecialchars($story_heading); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Story Subtitle</label>
            <input type="text" name="story_subtitle" class="form-control" value="<?= htmlspecialchars($story_subtitle); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description Paragraph</label>
            <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($description); ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">List Items (one per line)</label>
            <textarea name="list_items" class="form-control" rows="4"><?= htmlspecialchars($listItemsText); ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Additional Paragraph</label>
            <textarea name="additional_paragraph" class="form-control" rows="3" required><?= htmlspecialchars($additional_paragraph); ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Video Link</label>
            <input type="text" name="video_link" class="form-control" value="<?= htmlspecialchars($video_link); ?>" required>
            <small class="form-text text-muted">Enter a YouTube or Google Drive URL</small>
        </div>
        <button type="submit" name="update_about" class="btn btn-primary">Update About Section</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
