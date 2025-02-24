<?php
include('../config/db.php');
$message = "";

// Ensure an ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: projectCategoryView.php");
    exit;
}

$category_id = intval($_GET['id']);

// Fetch the existing category data
$query = "SELECT * FROM project_categories WHERE id = $category_id";
$result = mysqli_query($con, $query);
if (mysqli_num_rows($result) == 0) {
    header("Location: projectCategoryView.php");
    exit;
}
$category = mysqli_fetch_assoc($result);

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_category'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

    if (!empty($name)) {
        $update_query = "UPDATE project_categories SET name = '$name', description = '$description' WHERE id = $category_id";
        if (mysqli_query($con, $update_query)) {
            $message = "<div class='alert alert-success'>Category updated successfully!</div>";
            // Refresh category data after update
            $query = "SELECT * FROM project_categories WHERE id = $category_id";
            $result = mysqli_query($con, $query);
            $category = mysqli_fetch_assoc($result);
        } else {
            $message = "<div class='alert alert-danger'>Error updating category: " . mysqli_error($con) . "</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>Category name is required!</div>";
    }
}

include('includes/header.php');
?>

<div class="container mt-4">
  <h2>Edit Project Category</h2>
  <?= $message; ?>
  <form method="POST">
      <div class="mb-3">
          <label class="form-label">Category Name</label>
          <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($category['name']); ?>" required>
      </div>
      <div class="mb-3">
          <label class="form-label">Description (Optional)</label>
          <textarea name="description" class="form-control"><?= htmlspecialchars($category['description']); ?></textarea>
      </div>
      <button type="submit" name="edit_category" class="btn btn-primary">Update Category</button>
  </form>
  <a href="projectCategoryView.php" class="btn btn-secondary mt-3">Back to Categories</a>
</div>

<?php include('includes/footer.php'); ?>
