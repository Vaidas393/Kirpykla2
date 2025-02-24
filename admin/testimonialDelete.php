<?php
include('../config/db.php');

// Check if testimonial ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: testimonialView.php");
    exit;
}

$testimonial_id = intval($_GET['id']);

// Fetch testimonial details to get image filename
$query = "SELECT image FROM testimonials WHERE id = $testimonial_id";
$result = mysqli_query($con, $query);
$testimonial = mysqli_fetch_assoc($result);

if ($testimonial) {
    if (!empty($testimonial['image']) && file_exists("../uploads/" . $testimonial['image'])) {
        unlink("../uploads/" . $testimonial['image']);
    }
    // Delete testimonial record
    mysqli_query($con, "DELETE FROM testimonials WHERE id = $testimonial_id");
}

header("Location: testimonialView.php");
exit;
?>
