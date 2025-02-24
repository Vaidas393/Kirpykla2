<?php
include('../config/db.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: teamView.php");
    exit;
}

$member_id = intval($_GET['id']);
$query = "SELECT image FROM team_members WHERE id = $member_id";
$result = mysqli_query($con, $query);
$member = mysqli_fetch_assoc($result);

if ($member) {
    if (!empty($member['image']) && file_exists("../uploads/" . $member['image'])) {
        unlink("../uploads/" . $member['image']);
    }
    mysqli_query($con, "DELETE FROM team_members WHERE id = $member_id");
}

header("Location: teamView.php");
exit;
?>
