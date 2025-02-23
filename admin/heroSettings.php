<?php
include('../config/db.php');

$message = "";

// Function to resize and optimize images
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

// Handle adding a new slide
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_slide'])) {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $span_text = mysqli_real_escape_string($con, $_POST['span_text']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $button_text = mysqli_real_escape_string($con, $_POST['button_text']);
    $button_link = mysqli_real_escape_string($con, $_POST['button_link']);

    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        $target_file = "../uploads/" . $image_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            resizeImage($target_file, $target_file, 1600, 900, 80);
            $query = "INSERT INTO hero_carousel (title, span_text, description, button_text, button_link, image)
                      VALUES ('$title', '$span_text', '$description', '$button_text', '$button_link', '$image_name')";
            mysqli_query($con, $query);
            $message = "<div class='alert alert-success'>Slide added successfully!</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>Image is required!</div>";
    }
}

// Handle deleting a slide
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_slide']) && !empty($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']); // Ensure it's an integer

    $result = mysqli_query($con, "SELECT image FROM hero_carousel WHERE id=$delete_id");
    if ($result && mysqli_num_rows($result) > 0) {
        $slide = mysqli_fetch_assoc($result);

        // Delete the image if it exists
        if (!empty($slide['image']) && file_exists("../uploads/" . $slide['image'])) {
            unlink("../uploads/" . $slide['image']);
        }

        // Delete slide from database
        mysqli_query($con, "DELETE FROM hero_carousel WHERE id=$delete_id");
        $message = "<div class='alert alert-success'>Slide deleted successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Slide not found!</div>";
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_slide'])) {
    $message = "<div class='alert alert-danger'>Invalid slide ID!</div>";
}


// Handle editing a slide
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_slide'])) {
    $edit_id = $_POST['edit_id'];
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $span_text = mysqli_real_escape_string($con, $_POST['span_text']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $button_text = mysqli_real_escape_string($con, $_POST['button_text']);
    $button_link = mysqli_real_escape_string($con, $_POST['button_link']);

    // Fetch the existing slide image
    $result = mysqli_query($con, "SELECT image FROM hero_carousel WHERE id=$edit_id");
    $slide = mysqli_fetch_assoc($result);
    $image_name = $slide['image']; // Keep existing image by default

    if (!empty($_FILES['image']['name'])) {
        $new_image_name = time() . '_' . basename($_FILES['image']['name']);
        $target_file = "../uploads/" . $new_image_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            resizeImage($target_file, $target_file, 1600, 900, 80);

            // Delete old image
            if (!empty($slide['image']) && file_exists("../uploads/" . $slide['image'])) {
                unlink("../uploads/" . $slide['image']);
            }

            $image_name = $new_image_name; // Use new image
        }
    }

    $query = "UPDATE hero_carousel SET title='$title', span_text='$span_text', description='$description',
              button_text='$button_text', button_link='$button_link', image='$image_name' WHERE id=$edit_id";
    mysqli_query($con, $query);
    $message = "<div class='alert alert-success'>Slide updated successfully!</div>";
}

// Fetch all slides
$slides = mysqli_query($con, "SELECT * FROM hero_carousel ORDER BY id DESC");

include('includes/header.php');
?>

<div class="container mt-4">
    <h2>Hero Carousel Settings</h2>
    <?= $message; ?>

    <form method="POST" enctype="multipart/form-data">
        <h3>Add New Slide</h3>
        <input type="text" name="title" class="form-control" placeholder="Title" required>
        <input type="text" name="span_text" class="form-control mt-2" placeholder="Span Text (optional)">
        <textarea name="description" class="form-control mt-2" placeholder="Description" required></textarea>
        <input type="text" name="button_text" class="form-control mt-2" placeholder="Button Text" required>
        <input type="text" name="button_link" class="form-control mt-2" placeholder="Button Link" required>
        <input type="file" name="image" class="form-control mt-2" required>
        <button type="submit" name="add_slide" class="btn btn-primary mt-3">Add Slide</button>
    </form>

    <hr>

    <h3>Edit Existing Slides</h3>
    <?php while ($slide = mysqli_fetch_assoc($slides)) { ?>
        <form method="POST" enctype="multipart/form-data" class="mb-4">
            <input type="hidden" name="edit_id" value="<?= $slide['id'] ?>">
            <input type="text" name="title" class="form-control mt-2" value="<?= htmlspecialchars($slide['title']) ?>" required>
            <input type="text" name="span_text" class="form-control mt-2" value="<?= htmlspecialchars($slide['span_text']) ?>">
            <textarea name="description" class="form-control mt-2"><?= htmlspecialchars($slide['description']) ?></textarea>
            <input type="text" name="button_text" class="form-control mt-2" value="<?= htmlspecialchars($slide['button_text']) ?>" required>
            <input type="text" name="button_link" class="form-control mt-2" value="<?= htmlspecialchars($slide['button_link']) ?>" required>
            <input type="file" name="image" class="form-control mt-2">
            <img src="../uploads/<?= $slide['image'] ?>" width="100" class="mt-2">
            <button type="submit" name="edit_slide" class="btn btn-success mt-3">Update Slide</button>

            <!-- Handle Slide Deletion -->
            <input type="hidden" name="delete_id" value="<?= $slide['id'] ?>">
            <button type="submit" name="delete_slide" class="btn btn-danger mt-3">Delete</button>
        </form>
    <?php } ?>
</div>

<?php include('includes/footer.php'); ?>
