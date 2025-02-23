<?php
include('../config/db.php');

// Handle subcategory deletion (Before fetching data)
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Check if subcategory exists before deleting
    $check = mysqli_query($con, "SELECT id FROM subcategories WHERE id = $id");
    if (mysqli_num_rows($check) > 0) {
        mysqli_query($con, "DELETE FROM subcategories WHERE id = $id");
        header("Location: subcategoryView.php"); // Redirect to refresh page after deletion
        exit;
    }
}

// Fetch all subcategories along with their parent categories
$subcategories = mysqli_query($con, "
    SELECT subcategories.id, subcategories.name AS subcategory_name, subcategories.status,
           categories.name AS category_name
    FROM subcategories
    JOIN categories ON subcategories.category_id = categories.id
    ORDER BY categories.name, subcategories.name
");

include('includes/header.php');
?>

<div class="container mt-4">
    <h2>Manage Subcategories</h2>
    <table id="subcategoryTable" class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Subcategory Name</th>
                <th>Parent Category</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($subcategory = mysqli_fetch_assoc($subcategories)) { ?>
                <tr>
                    <td><?= $subcategory['id'] ?></td>
                    <td><?= $subcategory['subcategory_name'] ?></td>
                    <td><?= $subcategory['category_name'] ?></td>
                    <td>
                        <button class="btn btn-sm toggle-status <?= ($subcategory['status'] == 'active') ? 'btn-success' : 'btn-secondary' ?>"
                            data-id="<?= $subcategory['id'] ?>"
                            data-status="<?= $subcategory['status'] ?>">
                            <?= ucfirst($subcategory['status']) ?>
                        </button>
                    </td>
                    <td>
                        <a href="subcategoryEdit.php?id=<?= $subcategory['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="subcategoryView.php?delete=<?= $subcategory['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Initialize DataTables
        new simpleDatatables.DataTable("#subcategoryTable");

        // Event delegation for status toggle
        document.querySelector("#subcategoryTable").addEventListener('click', function (event) {
            if (event.target.classList.contains('toggle-status')) {
                const button = event.target;
                const subcategoryId = button.getAttribute('data-id');

                fetch('subcategoryToggle.php?id=' + subcategoryId, { method: 'GET' })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        button.setAttribute('data-status', data.new_status);
                        button.textContent = data.new_status.charAt(0).toUpperCase() + data.new_status.slice(1);
                        button.classList.toggle('btn-success', data.new_status === 'active');
                        button.classList.toggle('btn-secondary', data.new_status === 'inactive');
                    } else {
                        alert("Failed to update status!");
                    }
                })
                .catch(error => console.log("Error:", error));
            }
        });
    });
</script>

<?php include('includes/footer.php'); ?>
