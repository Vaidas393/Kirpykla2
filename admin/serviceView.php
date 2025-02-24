<?php
include('../config/db.php');

// Handle section title & description update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_section'])) {
    $newTitle = trim($_POST['section_title']);
    $newDescription = trim($_POST['section_description']);

    // Update section title and description for services (assuming only one row stores these details)
    if (!empty($newTitle) && !empty($newDescription)) {
        mysqli_query($con, "UPDATE services SET section_title = '$newTitle', section_description = '$newDescription' WHERE section_title IS NOT NULL LIMIT 1");
    }
}

// Fetch the section title and description (assumes only one row holds these details)
$sectionQuery = mysqli_query($con, "SELECT section_title, section_description FROM services WHERE section_title IS NOT NULL LIMIT 1");
$sectionRow = mysqli_fetch_assoc($sectionQuery);
$sectionTitle = $sectionRow ? $sectionRow['section_title'] : "Our Services";
$sectionDescription = $sectionRow ? $sectionRow['section_description'] : "Teikiame platų kirpyklos paslaugų spektrą – nuo kirpimų ir skutimo iki plaukų priežiūros ir stiliaus konsultacijų.";

// Fetch all services
$services = mysqli_query($con, "SELECT * FROM services");

include('includes/header.php');
?>

<div class="container mt-4">
    <h2>Manage Services</h2>

    <!-- Edit Section Title and Description -->
    <form method="POST" class="mb-3">
        <label for="section_title" class="form-label"><strong>Section Title:</strong></label>
        <input type="text" name="section_title" class="form-control" value="<?= htmlspecialchars($sectionTitle) ?>" required>

        <label for="section_description" class="form-label mt-2"><strong>Section Description:</strong></label>
        <textarea name="section_description" class="form-control"><?= htmlspecialchars($sectionDescription) ?></textarea>

        <button type="submit" name="update_section" class="btn btn-primary mt-2">Update Section</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Service Name</th>
                <th>Icon</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($service = mysqli_fetch_assoc($services)): ?>
                <tr>
                    <td><?= $service['id'] ?></td>
                    <td><?= htmlspecialchars($service['name']) ?></td>
                    <td><i class="<?= htmlspecialchars($service['icon']) ?>"></i></td>
                    <td><?= nl2br(htmlspecialchars($service['description'])) ?></td>
                    <td>
                        <a href="edit_service.php?id=<?= $service['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_service.php?id=<?= $service['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('includes/footer.php'); ?>
