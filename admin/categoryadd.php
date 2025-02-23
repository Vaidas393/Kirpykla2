<?php
include('../config/db.php'); // Ensure no spaces before `<?php`
include('includes/header.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_name = trim($_POST['category_name']);

    if (!empty($category_name)) {
        // Insert into database
        $stmt = mysqli_prepare($con, "INSERT INTO categories (name) VALUES (?)");
        mysqli_stmt_bind_param($stmt, "s", $category_name);
        mysqli_stmt_execute($stmt);

        echo "<div class='alert alert-success'>Category added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Category name is required!</div>";
    }
}
?>

<div class="container mt-4">
    <h2>Add Category</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" name="category_name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Category</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
