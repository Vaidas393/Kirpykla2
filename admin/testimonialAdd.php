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
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            break;
        case IMAGETYPE_GIF:
            $image = imagecreatefromgif($source);
            break;
        default:
            return false;
    }

    // Resize and crop to a square
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

/* --- Process Form Submission --- */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_testimonial'])) {
    $name = mysqli_real_escape_string($con, trim($_POST['name']));
    $designation = mysqli_real_escape_string($con, trim($_POST['designation']));
    $rating = intval($_POST['rating']);
    $content = mysqli_real_escape_string($con, trim($_POST['content']));

    // Process image upload; required in our case.
    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        $target = "../uploads/" . $image_name;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target)) {
            // Resize/crop image to 150x150 with 80% quality
            resizeImage($target, $target, 150, 150, 80);
        } else {
            $message .= "<div class='alert alert-warning'>Failed to upload image!</div>";
            $image_name = "";
        }
    } else {
        $message .= "<div class='alert alert-danger'>Testimonial image is required!</div>";
        $image_name = "";
    }

    if (!empty($name) && !empty($designation) && !empty($content) && !empty($image_name)) {
        $query = "INSERT INTO testimonials (name, designation, image, rating, content) VALUES ('$name', '$designation', '$image_name', $rating, '$content')";
        if (mysqli_query($con, $query)) {
            $message .= "<div class='alert alert-success'>Testimonial added successfully!</div>";
        } else {
            $message .= "<div class='alert alert-danger'>Error adding testimonial: " . mysqli_error($con) . "</div>";
        }
    }
}
include('includes/header.php');
?>

<div class="container mt-4">
    <h2>Add New Testimonial</h2>
    <?= $message; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Designation</label>
            <input type="text" name="designation" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Rating (1-5)</label>
            <input type="number" name="rating" class="form-control" value="5" min="1" max="5" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Testimonial Content</label>
            <textarea name="content" class="form-control" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Testimonial Image (will be cropped to 150x150, 80% quality)</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <button type="submit" name="add_testimonial" class="btn btn-primary">Add Testimonial</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
