<?php
include('../config/db.php');

if (!isset($_SESSION['admin_logged_in'])) {
    echo json_encode(['success' => false]);
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = mysqli_query($con, "SELECT status FROM categories WHERE id = $id");

    if ($result && mysqli_num_rows($result) > 0) {
        $category = mysqli_fetch_assoc($result);
        $new_status = ($category['status'] == 'active') ? 'inactive' : 'active';

        mysqli_query($con, "UPDATE categories SET status = '$new_status' WHERE id = $id");

        echo json_encode(['success' => true, 'new_status' => $new_status]);
        exit;
    }
}

echo json_encode(['success' => false]);
exit;
