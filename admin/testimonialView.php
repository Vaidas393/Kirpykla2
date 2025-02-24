<?php
include('../config/db.php');

// --- Handle Section Settings Update ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_testimonial_section'])) {
    $newTitle = mysqli_real_escape_string($con, trim($_POST['section_title']));
    $newDescription = mysqli_real_escape_string($con, trim($_POST['section_description']));

    // Check if a record exists
    $sectionQuery = mysqli_query($con, "SELECT id FROM testimonial_section LIMIT 1");
    if (mysqli_num_rows($sectionQuery) > 0) {
        $section = mysqli_fetch_assoc($sectionQuery);
        $sectionId = $section['id'];
        if (!empty($newTitle) && !empty($newDescription)) {
            mysqli_query($con, "UPDATE testimonial_section SET section_title = '$newTitle', section_description = '$newDescription' WHERE id = $sectionId");
        }
    } else {
        if (!empty($newTitle) && !empty($newDescription)) {
            mysqli_query($con, "INSERT INTO testimonial_section (section_title, section_description) VALUES ('$newTitle', '$newDescription')");
        }
    }
}

// Fetch the current section title and description
$sectionQuery = mysqli_query($con, "SELECT section_title, section_description FROM testimonial_section LIMIT 1");
$sectionData = mysqli_fetch_assoc($sectionQuery);
$sectionTitle = $sectionData ? $sectionData['section_title'] : 'Atsiliepimai';
$sectionDescription = $sectionData ? $sectionData['section_description'] : 'Mūsų klientai vertina aukštą paslaugų kokybę, profesionalumą ir dėmesį detalėms. Štai keletas jų atsiliepimų.';

// --- Fetch All Testimonials ---
$query = "SELECT * FROM testimonials ORDER BY created_at DESC";
$result = mysqli_query($con, $query);

include('includes/header.php');
?>

<div class="container mt-4">
    <h2>Manage Testimonials</h2>

    <!-- Section Settings Update Form -->
    <form method="POST" class="mb-4">
        <div class="mb-3">
            <label for="section_title" class="form-label"><strong>Section Title:</strong></label>
            <input type="text" name="section_title" class="form-control" value="<?= htmlspecialchars($sectionTitle); ?>" required>
        </div>
        <div class="mb-3">
            <label for="section_description" class="form-label"><strong>Section Description:</strong></label>
            <textarea name="section_description" class="form-control" required><?= htmlspecialchars($sectionDescription); ?></textarea>
        </div>
        <button type="submit" name="update_testimonial_section" class="btn btn-primary">Update Section</button>
    </form>

    <!-- Testimonials Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Rating</th>
                <th>Image</th>
                <th>Content</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($testimonial = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $testimonial['id']; ?></td>
                    <td><?= htmlspecialchars($testimonial['name']); ?></td>
                    <td><?= htmlspecialchars($testimonial['designation']); ?></td>
                    <td><?= $testimonial['rating']; ?></td>
                    <td>
                        <?php if (!empty($testimonial['image'])): ?>
                            <img src="../uploads/<?= $testimonial['image']; ?>" alt="Testimonial" width="75">
                        <?php else: ?>
                            <span class="text-muted">No image</span>
                        <?php endif; ?>
                    </td>
                    <td><?= nl2br(htmlspecialchars($testimonial['content'])); ?></td>
                    <td><?= date('F d, Y', strtotime($testimonial['created_at'])); ?></td>
                    <td>
                        <a href="testimonialEdit.php?id=<?= $testimonial['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="testimonialDelete.php?id=<?= $testimonial['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this testimonial?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('includes/footer.php'); ?>
