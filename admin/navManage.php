<?php
include('../config/db.php');
$message = "";

// Update navigation link names (status will remain 'active')
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_navigation'])) {
    foreach ($_POST['name'] as $id => $name) {
        $name = mysqli_real_escape_string($con, trim($name));
        // Always set status to 'active'
        $status = "active";

        mysqli_query($con, "UPDATE navigation_links SET name='$name', status='$status' WHERE id=$id");
    }
    $message = "<div class='alert alert-success'>Navigation updated successfully!</div>";
}

// Fetch all navigation links
$query = "SELECT * FROM navigation_links ORDER BY parent_id IS NULL DESC, parent_id ASC, id ASC";
$result = mysqli_query($con, $query);
$navLinks = mysqli_fetch_all($result, MYSQLI_ASSOC);

include('includes/header.php');
?>

<div class="container mt-4">
    <h2>Manage Navigation Links</h2>
    <?= $message; ?>
    <form method="POST">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($navLinks as $link): ?>
                    <tr>
                        <td>
                            <!-- Editable name for each link -->
                            <input type="text" name="name[<?= $link['id']; ?>]" class="form-control" value="<?= htmlspecialchars($link['name']); ?>" required>
                        </td>
                        <td>
                            <!-- Display the status, all links will be active -->
                            <select name="status[<?= $link['id']; ?>]" class="form-select" disabled>
                                <option value="active" selected>Active</option>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" name="update_navigation" class="btn btn-primary">Update Navigation</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
