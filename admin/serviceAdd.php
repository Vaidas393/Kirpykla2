<?php
include('../config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $icon = trim($_POST['icon']);

    if (!empty($name) && !empty($description) && !empty($icon)) {
        $stmt = mysqli_prepare($con, "INSERT INTO services (name, description, icon) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $name, $description, $icon);
        mysqli_stmt_execute($stmt);

        echo "<div class='alert alert-success'>Service added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>All fields are required!</div>";
    }
}

include('includes/header.php');
?>

<div class="container mt-4">
    <h2>Add Service</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Service Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Service Description (one point per line)</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Select Bootstrap Icon</label>
            <select id="icon-picker" name="icon" class="form-control" required>
                <!-- Icons will be loaded here dynamically -->
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Service</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
