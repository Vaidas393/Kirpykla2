<?php
include('../config/db.php');

// Ensure an ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: projectCategoryView.php");
    exit;
}

$category_id = intval($_GET['id']);

// Delete the category from the database
$query = "DELETE FROM project_categories WHERE id = $category_id";
if (mysqli_query($con, $query)) {
    header("Location: projectCategoryView.php?msg=Category+deleted+successfully");
    exit;
} else {
    echo "Error deleting category: " . mysqli_error($con);
}
?>
