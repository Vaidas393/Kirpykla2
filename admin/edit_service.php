<?php
include('../config/db.php');

// Get service ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: view_services.php"); // Redirect if ID is missing
    exit;
}

$id = intval($_GET['id']);
$service = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM services WHERE id = $id"));

if (!$service) {
    header("Location: view_services.php"); // Redirect if service does not exist
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $icon = trim($_POST['icon']);
    $section_description = trim($_POST['section_description']);

    if (!empty($name) && !empty($description) && !empty($icon)) {
        mysqli_query($con, "UPDATE services SET name = '$name', description = '$description', icon = '$icon', section_description = '$section_description' WHERE id = $id");
        header("Location: serviceView.php"); // Redirect after update
        exit;
    } else {
        $error = "All fields are required!";
    }
}

include('includes/header.php');
?>

<div class="container mt-4">
    <h2>Edit Service</h2>

    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php } ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Service Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($service['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Service Description (one point per line)</label>
            <textarea name="description" class="form-control" required><?= htmlspecialchars($service['description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Select Bootstrap Icon</label>
            <select id="icon-picker" name="icon" class="form-control select2" required>
                <option value="<?= htmlspecialchars($service['icon']); ?>" selected><?= htmlspecialchars($service['icon']); ?></option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Section Description (optional, used only once)</label>
            <textarea name="section_description" class="form-control"><?= htmlspecialchars($service['section_description']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Service</button>
        <a href="view_services.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include('includes/footer.php'); ?>
