<?php
include('../config/db.php'); // Ensure no spaces before `<?php`

// Check if category ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: categoryView.php");
    exit;
}

$id = $_GET['id'];
$category = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM categories WHERE id = $id"));

if (!$category) {
    header("Location: categoryView.php"); // Redirect if category doesn't exist
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = trim($_POST['category_name']);

    if (!empty($new_name)) {
        mysqli_query($con, "UPDATE categories SET name = '$new_name' WHERE id = $id");
        header("Location: categoryView.php"); // Redirect to category list after update
        exit;
    } else {
        $error = "Category name cannot be empty!";
    }
}

include('includes/header.php');
?>

<div class="container mt-4">
    <h2>Edit Category</h2>

    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php } ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" name="category_name" class="form-control" value="<?= htmlspecialchars($category['name']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Category</button>
        <a href="categoryView.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include('includes/footer.php'); ?>
