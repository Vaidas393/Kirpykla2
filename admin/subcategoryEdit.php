<?php
include('../config/db.php');

// Check if subcategory ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: subcategoryView.php");
    exit;
}

$id = intval($_GET['id']);

// Fetch subcategory details
$query = "SELECT subcategories.id, subcategories.name AS subcategory_name, subcategories.category_id,
                 categories.name AS category_name
          FROM subcategories
          JOIN categories ON subcategories.category_id = categories.id
          WHERE subcategories.id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$subcategory = mysqli_fetch_assoc($result);

if (!$subcategory) {
    header("Location: subcategoryView.php"); // Redirect if subcategory doesn't exist
    exit;
}

// Fetch all categories for dropdown
$categories = mysqli_query($con, "SELECT * FROM categories ORDER BY name");

// Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = trim($_POST['subcategory_name']);
    $new_category_id = trim($_POST['category_id']);

    if (!empty($new_name) && !empty($new_category_id)) {
        // Update the subcategory
        $update_query = "UPDATE subcategories SET name = ?, category_id = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($stmt, "sii", $new_name, $new_category_id, $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: subcategoryView.php"); // Redirect after update
            exit;
        } else {
            $message = "<div class='alert alert-danger'>Error updating subcategory!</div>";
        }

        mysqli_stmt_close($stmt);
    } else {
        $message = "<div class='alert alert-danger'>All fields are required!</div>";
    }
}

include('includes/header.php');
?>

<div class="container mt-4">
    <h2>Edit Subcategory</h2>

    <?= $message; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Select Parent Category</label>
            <select name="category_id" class="form-control" required>
                <?php while ($category = mysqli_fetch_assoc($categories)) { ?>
                    <option value="<?= $category['id'] ?>" <?= ($subcategory['category_id'] == $category['id']) ? 'selected' : '' ?>>
                        <?= $category['name'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Subcategory Name</label>
            <input type="text" name="subcategory_name" class="form-control" value="<?= htmlspecialchars($subcategory['subcategory_name']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Subcategory</button>
        <a href="subcategoryView.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include('includes/footer.php'); ?>
