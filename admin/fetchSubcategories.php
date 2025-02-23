<?php
include('../config/db.php');

$category_id = intval($_GET['category_id']);
$subcategories = mysqli_query($con, "SELECT id, name FROM subcategories WHERE category_id = $category_id");

$subcat_list = [];
while ($row = mysqli_fetch_assoc($subcategories)) {
    $subcat_list[] = $row;
}

echo json_encode($subcat_list);
?>
