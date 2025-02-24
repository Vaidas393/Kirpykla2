<?php
include('../config/db.php');
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_category'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

    if (!empty($name)) {
        $query = "INSERT INTO project_categories (name, description) VALUES ('$name', '$description')";
        if (mysqli_query($con, $query)) {
            $message = "<div class='alert alert-success'>Category added successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error adding category: " . mysqli_error($con) . "</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>Category name is required!</div>";
    }
}
include('includes/header.php');

?>



<div class="container mt-4">
  <h2>Add New Project Category</h2>
  <?= $message; ?>
  <form method="POST">
      <div class="mb-3">
          <label class="form-label">Category Name</label>
          <input type="text" name="name" class="form-control" required>
      </div>
      <div class="mb-3">
          <label class="form-label">Description (Optional)</label>
          <textarea name="description" class="form-control"></textarea>
      </div>
      <button type="submit" name="add_category" class="btn btn-primary">Add Category</button>
  </form>
</div>
<?php include('includes/footer.php'); ?>
