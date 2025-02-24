<?php
include('../config/db.php');
$query = "SELECT * FROM project_categories ORDER BY name";
$result = mysqli_query($con, $query);
include('includes/header.php');
?>

<div class="container mt-4">
  <h2>Manage Project Categories</h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($cat = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?= $cat['id']; ?></td>
        <td><?= htmlspecialchars($cat['name']); ?></td>
        <td><?= htmlspecialchars($cat['description']); ?></td>
        <td>
          <a href="projectCategoryEdit.php?id=<?= $cat['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="projectCategoryDelete.php?id=<?= $cat['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<?php include('includes/footer.php'); ?>
