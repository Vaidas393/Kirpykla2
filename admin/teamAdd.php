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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_member'])) {
    $name = mysqli_real_escape_string($con, trim($_POST['name']));
    $role = mysqli_real_escape_string($con, trim($_POST['role']));
    $description = mysqli_real_escape_string($con, trim($_POST['description']));
    $facebook = mysqli_real_escape_string($con, trim($_POST['facebook']));
    $instagram = mysqli_real_escape_string($con, trim($_POST['instagram']));

    $image_name = "";
    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        $target = "../uploads/" . $image_name;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target)) {
            // Resize to 300x300 at 80% quality
            resizeImage($target, $target, 300, 300, 80);
        } else {
            $message .= "<div class='alert alert-warning'>Failed to upload image!</div>";
            $image_name = "";
        }
    } else {
        $message .= "<div class='alert alert-danger'>Image is required!</div>";
    }

    if (!empty($name) && !empty($role) && !empty($description) && !empty($image_name)) {
        $query = "INSERT INTO team_members (name, role, description, image, facebook, instagram) VALUES ('$name', '$role', '$description', '$image_name', '$facebook', '$instagram')";
        if (mysqli_query($con, $query)) {
            $message .= "<div class='alert alert-success'>Team member added successfully!</div>";
        } else {
            $message .= "<div class='alert alert-danger'>Error adding team member: " . mysqli_error($con) . "</div>";
        }
    }
}

include('includes/header.php');
?>

<div class="container mt-4">
    <h2>Add New Team Member</h2>
    <?= $message; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Role/Position</label>
            <input type="text" name="role" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Facebook URL (optional)</label>
            <input type="text" name="facebook" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Instagram URL (optional)</label>
            <input type="text" name="instagram" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Team Member Image (will be cropped to 300x300, 80% quality)</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <button type="submit" name="add_member" class="btn btn-primary">Add Member</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
