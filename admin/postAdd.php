<?php
include('../config/db.php');

// Fetch all categories for dropdown
$categories = mysqli_query($con, "SELECT * FROM categories ORDER BY name");

// Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = !empty($_POST['category_id']) ? trim($_POST['category_id']) : null;
    $subcategory_id = (!empty($_POST['subcategory_id']) && $_POST['subcategory_id'] !== "") ? trim($_POST['subcategory_id']) : NULL;
    $title = !empty($_POST['title']) ? trim($_POST['title']) : null;
    $description = !empty($_POST['description']) ? trim($_POST['description']) : null;
    $details = !empty($_POST['details']) ? trim($_POST['details']) : null;
    $links = (!empty($_POST['links']) && trim($_POST['links']) !== "") ? trim($_POST['links']) : NULL;

    if (!empty($category_id) && !empty($title) && !empty($description) && !empty($details)) {
        $stmt = mysqli_prepare($con, "INSERT INTO posts (category_id, subcategory_id, title, description, details, status) VALUES (?, ?, ?, ?, ?, 'active')");
        mysqli_stmt_bind_param($stmt, "iisss", $category_id, $subcategory_id, $title, $description, $details);

        if (mysqli_stmt_execute($stmt)) {
            $post_id = mysqli_insert_id($con);

            // Create upload directory if it doesn't exist
            $upload_dir = "../uploads/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Handle image uploads only
            if (!empty($_FILES['media']['name'][0])) {
                foreach ($_FILES['media']['tmp_name'] as $key => $tmp_name) {
                    if ($_FILES['media']['error'][$key] == UPLOAD_ERR_OK) {
                        $file_name = $_FILES['media']['name'][$key];
                        $file_tmp = $_FILES['media']['tmp_name'][$key];

                        // Get file extension
                        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                        // Allowed image extensions
                        $allowed_image_ext = ['jpg', 'jpeg', 'png', 'gif'];

                        if (!in_array($file_ext, $allowed_image_ext)) {
                            $message = "<div class='alert alert-danger'>Invalid file type: $file_ext (Only images allowed)</div>";
                            continue;
                        }

                        // Move file to uploads folder
                        $unique_file_name = uniqid() . "_" . $file_name;
                        $file_path = "uploads/" . $unique_file_name;
                        move_uploaded_file($file_tmp, $upload_dir . $unique_file_name);

                        // Insert into `post_media`
                        $stmt_media = mysqli_prepare($con, "INSERT INTO post_media (post_id, file_path, file_type) VALUES (?, ?, 'image')");
                        mysqli_stmt_bind_param($stmt_media, "is", $post_id, $file_path);
                        mysqli_stmt_execute($stmt_media);
                    }
                }
            }

            // Extract YouTube and Google Drive links
            if (!empty($links)) {
                preg_match_all('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:watch\?v=|playlist\?list=)|youtu\.be\/)([A-Za-z0-9-_]+)|(?:https?:\/\/)?drive\.google\.com\/(?:file\/d\/|open\?id=)([A-Za-z0-9-_]+)/', $links, $matches, PREG_SET_ORDER);

                foreach ($matches as $match) {
                    $link = !empty($match[1]) ? "https://www.youtube.com/watch?v=" . $match[1] : "https://drive.google.com/file/d/" . $match[2];
                    $link_type = !empty($match[1]) ? "youtube" : "google_drive";

                    $stmt_link = mysqli_prepare($con, "INSERT INTO post_links (post_id, link, link_type) VALUES (?, ?, ?)");
                    mysqli_stmt_bind_param($stmt_link, "iss", $post_id, $link, $link_type);
                    mysqli_stmt_execute($stmt_link);
                }
            }

            $message = "<div class='alert alert-success'>Post added successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error adding post!</div>";
        }

        mysqli_stmt_close($stmt);
    } else {
        $message = "<div class='alert alert-danger'>Category, Title, Description, and Details are required!</div>";
    }
}

include('includes/header.php');
?>

<div class="container mt-4">
    <h2>Add New Post</h2>

    <?= $message; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Select Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">-- Select Category --</option>
                <?php while ($category = mysqli_fetch_assoc($categories)) { ?>
                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Select Subcategory (Optional)</label>
            <select name="subcategory_id" id="subcategory_id" class="form-control">
                <option value="">-- Select Subcategory --</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Post Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Short Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Full Details</label>
            <textarea name="details" class="form-control" rows="5" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Upload Images</label>
            <input type="file" name="media[]" class="form-control" multiple accept="image/*">
        </div>

        <div class="mb-3">
            <label class="form-label">Paste YouTube/Google Drive Links</label>
            <textarea name="links" class="form-control" rows="3" placeholder="Paste YouTube/Google Drive links here..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Add Post</button>
        <a href="postView.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
    document.getElementById("category_id").addEventListener("change", function () {
        var categoryId = this.value;
        var subcategoryDropdown = document.getElementById("subcategory_id");

        if (categoryId) {
            fetch("fetchSubcategories.php?category_id=" + categoryId)
                .then(response => response.json())
                .then(data => {
                    subcategoryDropdown.innerHTML = '<option value="">-- Select Subcategory --</option>';
                    data.forEach(subcategory => {
                        subcategoryDropdown.innerHTML += `<option value="${subcategory.id}">${subcategory.name}</option>`;
                    });
                })
                .catch(error => console.error("Error fetching subcategories:", error));
        } else {
            subcategoryDropdown.innerHTML = '<option value="">-- Select Subcategory --</option>';
        }
    });
</script>

<?php include('includes/footer.php'); ?>
