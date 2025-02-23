<?php
include('../config/db.php');
include('includes/header.php');

// Fetch all categories for dropdown
$categories = mysqli_query($con, "SELECT * FROM categories ORDER BY name");

// Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = trim($_POST['category_id']);
    $subcategory_name = trim($_POST['subcategory_name']);

    if (!empty($category_id) && !empty($subcategory_name)) {
        // Insert into database
        $stmt = mysqli_prepare($con, "INSERT INTO subcategories (category_id, name, status) VALUES (?, ?, 'active')");
        mysqli_stmt_bind_param($stmt, "is", $category_id, $subcategory_name);

        if (mysqli_stmt_execute($stmt)) {
            $message = "<div class='alert alert-success'>Subcategory added successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error adding subcategory!</div>";
        }

        mysqli_stmt_close($stmt);
    } else {
        $message = "<div class='alert alert-danger'>All fields are required!</div>";
    }
}
?>

<div class="container mt-4">
    <h2>Add Subcategory</h2>

    <?= $message; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Select Parent Category</label>
            <select name="category_id" class="form-control" required>
                <option value="">-- Select Category --</option>
                <?php while ($category = mysqli_fetch_assoc($categories)) { ?>
                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Subcategory Name</label>
            <input type="text" name="subcategory_name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Subcategory</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
