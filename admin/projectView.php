<?php
include('../config/db.php');

// ---------- Section Settings ----------
// Handle section title & description update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_section'])) {
    $newTitle = mysqli_real_escape_string($con, trim($_POST['section_title']));
    $newDescription = mysqli_real_escape_string($con, trim($_POST['section_description']));

    // Check if a section settings record already exists
    $sectionQuery = mysqli_query($con, "SELECT id FROM project_section LIMIT 1");
    if (mysqli_num_rows($sectionQuery) > 0) {
        $section = mysqli_fetch_assoc($sectionQuery);
        $sectionId = $section['id'];
        if (!empty($newTitle) && !empty($newDescription)) {
            mysqli_query($con, "UPDATE project_section SET section_title = '$newTitle', section_description = '$newDescription' WHERE id = $sectionId");
        }
    } else {
        if (!empty($newTitle) && !empty($newDescription)) {
            mysqli_query($con, "INSERT INTO project_section (section_title, section_description) VALUES ('$newTitle', '$newDescription')");
        }
    }
}

// Fetch the section title and description (assumes only one record)
$sectionQuery = mysqli_query($con, "SELECT section_title, section_description FROM project_section LIMIT 1");
$sectionRow = mysqli_fetch_assoc($sectionQuery);
$sectionTitle = $sectionRow ? $sectionRow['section_title'] : "Our Projects";
$sectionDescription = $sectionRow ? $sectionRow['section_description'] : "Showcase your completed works and projects.";

// ---------- Projects Listing ----------
// Fetch projects along with their category names
$query = "SELECT p.*, pc.name AS category_name
          FROM projects p
          LEFT JOIN project_categories pc ON p.category_id = pc.id
          ORDER BY p.created_at DESC";
$result = mysqli_query($con, $query);

include('includes/header.php');
?>

<div class="container mt-4">
    <!-- Section Settings Update Form -->
    <h2>Manage Projects Section Settings</h2>
    <form method="POST" class="mb-4">
        <div class="mb-3">
            <label for="section_title" class="form-label"><strong>Section Title:</strong></label>
            <input type="text" name="section_title" class="form-control" value="<?= htmlspecialchars($sectionTitle); ?>" required>
        </div>
        <div class="mb-3">
            <label for="section_description" class="form-label"><strong>Section Description:</strong></label>
            <textarea name="section_description" class="form-control" required><?= htmlspecialchars($sectionDescription); ?></textarea>
        </div>
        <button type="submit" name="update_section" class="btn btn-primary">Update Section</button>
    </form>

    <!-- Projects Table -->
    <h2>Manage Projects</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Thumbnail</th>
                <th>Full Image</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($project = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $project['id']; ?></td>
                    <td><?= htmlspecialchars($project['title']); ?></td>
                    <td><?= htmlspecialchars($project['category_name'] ?? 'Uncategorized'); ?></td>
                    <td>
                        <?php if (!empty($project['thumbnail'])): ?>
                            <img src="../uploads/<?= $project['thumbnail']; ?>" alt="Thumbnail" width="100">
                        <?php else: ?>
                            <span class="text-muted">No image</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($project['full_image'])): ?>
                            <img src="../uploads/<?= $project['full_image']; ?>" alt="Full Image" width="100">
                        <?php else: ?>
                            <span class="text-muted">No image</span>
                        <?php endif; ?>
                    </td>
                    <td><?= date('F d, Y', strtotime($project['created_at'])); ?></td>
                    <td>
                        <a href="projectEdit.php?id=<?= $project['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="deleteProject.php?id=<?= $project['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this project?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('includes/footer.php'); ?>
