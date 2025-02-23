<?php
include('../config/db.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    mysqli_query($con, "DELETE FROM services WHERE id = $id");
}

header("Location: serviceView.php");
exit;
?>
