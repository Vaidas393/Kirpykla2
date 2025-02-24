<?php
include('../config/db.php');

// Check if project_id is provided via GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: projectView.php");
    exit;
}

$project_id = intval($_GET['id']);

// Fetch project details to get image filenames
$project_query = mysqli_query($con, "SELECT * FROM projects WHERE id = $project_id");
$project = mysqli_fetch_assoc($project_query);

if ($project) {
    // Delete thumbnail and full image files if they exist
    if (!empty($project['thumbnail']) && file_exists("../uploads/" . $project['thumbnail'])) {
        unlink("../uploads/" . $project['thumbnail']);
    }
    if (!empty($project['full_image']) && file_exists("../uploads/" . $project['full_image'])) {
        unlink("../uploads/" . $project['full_image']);
    }

    // Delete video files from project_media
    $media_query = mysqli_query($con, "SELECT file_path FROM project_media WHERE project_id = $project_id");
    while ($media = mysqli_fetch_assoc($media_query)) {
        if (!empty($media['file_path']) && file_exists("../uploads/" . $media['file_path'])) {
            unlink("../uploads/" . $media['file_path']);
        }
    }

    // Remove related records from project_media and project_links
    mysqli_query($con, "DELETE FROM project_media WHERE project_id = $project_id");
    mysqli_query($con, "DELETE FROM project_links WHERE project_id = $project_id");

    // Finally, delete the project record
    mysqli_query($con, "DELETE FROM projects WHERE id = $project_id");
}

header("Location: projectView.php");
exit;
?>
