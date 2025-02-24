<?php
include('../config/db.php');
$message = "";

// Check if member ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: teamView.php");
    exit;
}

$member_id = intval($_GET['id']);

// Fetch team member details
$query = "SELECT * FROM team_members WHERE id = $member_id";
$result = mysqli_query($con, $query);
$member = mysqli_fetch_assoc($result);
if (!$member) {
    header("Location: teamView.php");
    exit;
}

// Include resize function if not already defined
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_member'])) {
    $name = mysqli_real_escape_string($con, trim($_POST['name']));
    $role = mysqli_real_escape_string($con, trim($_POST['role']));
    $description = mysqli_real_escape_string($con, trim($_POST['description']));
    $facebook = mysqli_real_escape_string($con, trim($_POST['facebook']));
    $instagram = mysqli_real_escape_string($con, trim($_POST['instagram']));

    // Handle image deletion/replacement
    if (isset($_POST['delete_image']) && $_POST['delete_image'] == "1") {
        if (!empty($member['image']) && file_exists("../uploads/" . $member['image'])) {
            unlink("../uploads/" . $member['image']);
        }
        $image_name = "";
    } else {
        if (!empty($_FILES['image']['name'])) {
            if (!empty($member['image']) && file_exists("../uploads/" . $member['image'])) {
                unlink("../uploads/" . $member['image']);
            }
            $image_name = time() . '_' . basename($_FILES['image']['name']);
            $target = "../uploads/" . $image_name;
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target)) {
                // Resize to 300x300 at 80% quality
                resizeImage($target, $target, 300, 300, 80);
            } else {
                $message .= "<div class='alert alert-warning'>Failed to upload new image!</div>";
                $image_name = $member['image'];
            }
        } else {
            $image_name = $member['image'];
        }
    }

    $updateQuery = "UPDATE team_members SET name='$name', role='$role', description='$description', image='$image_name', facebook='$facebook', instagram='$instagram' WHERE id=$member_id";
    if (mysqli_query($con, $updateQuery)) {
        $message .= "<div class='alert alert-success'>Team member updated successfully!</div>";
        $query = "SELECT * FROM team_members WHERE id = $member_id";
        $result = mysqli_query($con, $query);
        $member = mysqli_fetch_assoc($result);
    } else {
        $message .= "<div class='alert alert-danger'>Error updating member: " . mysqli_error($con) . "</div>";
    }
}

include('includes/header.php');
?>

<div class="container mt-4">
    <h2>Edit Team Member</h2>
    <?= $message; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($member['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Role/Position</label>
            <input type="text" name="role" class="form-control" value="<?= htmlspecialchars($member['role']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($member['description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Facebook URL (optional)</label>
            <input type="text" name="facebook" class="form-control" value="<?= htmlspecialchars($member['facebook']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Instagram URL (optional)</label>
            <input type="text" name="instagram" class="form-control" value="<?= htmlspecialchars($member['instagram']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Team Member Image (will be cropped to 300x300, 80% quality)</label>
            <?php if (!empty($member['image'])): ?>
                <div>
                    <img src="../uploads/<?= $member['image']; ?>" width="150" alt="Team Member Image">
                    <label><input type="checkbox" name="delete_image" value="1"> Delete Image</label>
                </div>
            <?php endif; ?>
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" name="edit_member" class="btn btn-primary">Update Member</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
