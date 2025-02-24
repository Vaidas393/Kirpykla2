<?php
include('../config/db.php');
$message = "";

// --- Handle Team Section Settings Update ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_team_section'])) {
    $section_title = mysqli_real_escape_string($con, trim($_POST['section_title']));
    $section_description = mysqli_real_escape_string($con, trim($_POST['section_description']));

    // Check if a record exists in team_section
    $query = "SELECT id FROM team_section LIMIT 1";
    $resultSection = mysqli_query($con, $query);
    if (mysqli_num_rows($resultSection) > 0) {
        $data = mysqli_fetch_assoc($resultSection);
        $sectionId = $data['id'];
        mysqli_query($con, "UPDATE team_section SET section_title = '$section_title', section_description = '$section_description' WHERE id = $sectionId");
    } else {
        mysqli_query($con, "INSERT INTO team_section (section_title, section_description) VALUES ('$section_title', '$section_description')");
    }
    $message .= "<div class='alert alert-success'>Team section updated successfully!</div>";
}

// Fetch current team section settings
$sectionQuery = mysqli_query($con, "SELECT section_title, section_description FROM team_section LIMIT 1");
$sectionData = mysqli_fetch_assoc($sectionQuery);
$section_title = $sectionData ? $sectionData['section_title'] : 'Mūsų Komanda';
$section_description = $sectionData ? $sectionData['section_description'] : ' ';

// --- Fetch Team Members ---
$query = "SELECT * FROM team_members ORDER BY created_at DESC";
$result = mysqli_query($con, $query);

include('includes/header.php');
?>

<div class="container mt-4">
    <!-- Team Section Settings -->
    <h2>Manage Team Section Settings</h2>
    <?= $message; ?>
    <form method="POST" class="mb-4">
        <div class="mb-3">
            <label class="form-label">Section Title</label>
            <input type="text" name="section_title" class="form-control" value="<?= htmlspecialchars($section_title); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Section Description</label>
            <textarea name="section_description" class="form-control" rows="3" required><?= htmlspecialchars($section_description); ?></textarea>
        </div>
        <button type="submit" name="update_team_section" class="btn btn-primary">Update Section</button>
    </form>
</div>

<div class="container mt-4">
    <h2>Manage Team Members</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Role</th>
                <th>Image</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($member = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $member['id']; ?></td>
                    <td><?= htmlspecialchars($member['name']); ?></td>
                    <td><?= htmlspecialchars($member['role']); ?></td>
                    <td>
                        <?php if (!empty($member['image'])): ?>
                            <img src="../uploads/<?= $member['image']; ?>" alt="Team Member" width="75">
                        <?php else: ?>
                            <span class="text-muted">No image</span>
                        <?php endif; ?>
                    </td>
                    <td><?= date('F d, Y', strtotime($member['created_at'])); ?></td>
                    <td>
                        <a href="teamEdit.php?id=<?= $member['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="teamDelete.php?id=<?= $member['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this member?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('includes/footer.php'); ?>
