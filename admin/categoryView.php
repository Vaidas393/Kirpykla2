<?php
include('../config/db.php');

// Handle category deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($con, "DELETE FROM categories WHERE id = $id");
    header("Location: categoryView.php");
    exit;
}

// Fetch all categories
$categories = mysqli_query($con, "SELECT * FROM categories");

include('includes/header.php'); // Include DataTables in the header
?>

<div class="container mt-4">
    <h2>Manage Categories</h2>
    <table id="categoryTable" class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($category = mysqli_fetch_assoc($categories)) { ?>
                <tr>
                    <td><?= $category['id'] ?></td>
                    <td><?= $category['name'] ?></td>
                    <td>
                        <button class="btn btn-sm toggle-status <?= ($category['status'] == 'active') ? 'btn-success' : 'btn-secondary' ?>"
                            data-id="<?= $category['id'] ?>"
                            data-status="<?= $category['status'] ?>">
                            <?= ucfirst($category['status']) ?>
                        </button>
                    </td>
                    <td>
                        <a href="categoryEdit.php?id=<?= $category['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="categoryView.php?delete=<?= $category['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Include DataTables & AJAX -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Initialize DataTables
        new simpleDatatables.DataTable("#categoryTable");

        // Handle status toggle using AJAX
        document.querySelectorAll('.toggle-status').forEach(button => {
            button.addEventListener('click', function () {
                const categoryId = this.getAttribute('data-id');

                fetch('categoryToggle.php?id=' + categoryId, { method: 'GET' })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.setAttribute('data-status', data.new_status);
                        this.textContent = data.new_status.charAt(0).toUpperCase() + data.new_status.slice(1);
                        this.classList.toggle('btn-success', data.new_status === 'active');
                        this.classList.toggle('btn-secondary', data.new_status === 'inactive');
                    } else {
                        alert("Failed to update status!");
                    }
                })
                .catch(error => console.log("Error:", error));
            });
        });
    });
</script>

<?php include('includes/footer.php'); ?>
