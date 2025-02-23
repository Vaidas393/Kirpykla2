<?php
include('../config/db.php');

// Handle section description update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_section_description'])) {
    $newDescription = trim($_POST['section_description']);

    // Update section description for any service (only one should exist)
    if (!empty($newDescription)) {
        mysqli_query($con, "UPDATE services SET section_description = '$newDescription' WHERE section_description IS NOT NULL LIMIT 1");
    }
}

// Fetch all services
$services = mysqli_query($con, "SELECT * FROM services");

// Fetch only the section description (should be only one row)
$sectionQuery = mysqli_query($con, "SELECT section_description FROM services WHERE section_description IS NOT NULL LIMIT 1");
$sectionRow = mysqli_fetch_assoc($sectionQuery);
$sectionDescription = $sectionRow ? $sectionRow['section_description'] : "Teikiame platų kirpyklos paslaugų spektrą – nuo kirpimų ir skutimo iki plaukų priežiūros ir stiliaus konsultacijų.";

include('includes/header.php');
?>

<div class="container mt-4">
    <h2>Manage Services</h2>

    <!-- Edit Section Description -->
    <form method="POST" class="mb-3">
        <label for="section_description" class="form-label"><strong>Section Description:</strong></label>
        <textarea name="section_description" class="form-control"><?= htmlspecialchars($sectionDescription) ?></textarea>
        <button type="submit" name="update_section_description" class="btn btn-primary mt-2">Update Description</button>
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
