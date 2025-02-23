<?php
include('../config/db.php');

if (!isset($_SESSION['admin_logged_in'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT status FROM subcategories WHERE id = $id";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $subcategory = mysqli_fetch_assoc($result);
        $new_status = ($subcategory['status'] == 'active') ? 'inactive' : 'active';

        $update_query = "UPDATE subcategories SET status = '$new_status' WHERE id = $id";
        if (mysqli_query($con, $update_query)) {
            echo json_encode(['success' => true, 'new_status' => $new_status]);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Database update failed']);
            exit;
        }
    }
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
exit;
