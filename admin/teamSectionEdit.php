<?php
include('../config/db.php');
$message = "";

// Process form submission for updating the team section settings
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_team_section'])) {
    $section_title = mysqli_real_escape_string($con, trim($_POST['section_title']));
    $section_description = mysqli_real_escape_string($con, trim($_POST['section_description']));

    // Check if a record exists; assume only one record exists.
    $query = "SELECT id FROM team_section LIMIT 1";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $sectionId = $data['id'];
        mysqli_query($con, "UPDATE team_section SET section_title = '$section_title', section_description = '$section_description' WHERE id = $sectionId");
    } else {
        mysqli_query($con, "INSERT INTO team_section (section_title, section_description) VALUES ('$section_title', '$section_description')");
    }
    $message = "<div class='alert alert-success'>Team section updated successfully!</div>";
}

// Fetch current team section settings
$query = "SELECT section_title, section_description FROM team_section LIMIT 1";
$result = mysqli_query($con, $query);
$data = mysqli_fetch_assoc($result);
$section_title = $data ? $data['section_title'] : 'Mūsų Komanda';
$section_description = $data ? $data['section_description'] : 'VIP Grožio Studijoje dirba profesionalių grožio specialistų komanda, kuri užtikrina, kad kiekvienas klientas gautų geriausią paslaugą.';

include('includes/header.php');
?>

<div class="container mt-4">
    <h2>Edit Team Section Settings</h2>
    <?= $message; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Section Title</label>
            <input type="text" name="section_title" class="form-control" value="<?= htmlspecialchars($section_title); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Section Description</label>
            <textarea name="section_description" class="form-control" rows="4" required><?= htmlspecialchars($section_description); ?></textarea>
        </div>
        <button type="submit" name="update_team_section" class="btn btn-primary">Update Section</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
