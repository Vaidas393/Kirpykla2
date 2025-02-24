<?php
include('../config/db.php');
$message = "";

// Fetch existing contact information (assuming only one row)
$contactQuery = mysqli_query($con, "SELECT * FROM contact_info LIMIT 1");
$contact = mysqli_fetch_assoc($contactQuery);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_contact'])) {
    $address = mysqli_real_escape_string($con, trim($_POST['address']));
    $email = mysqli_real_escape_string($con, trim($_POST['email']));
    $phone = mysqli_real_escape_string($con, trim($_POST['phone']));
    $google_map_embed = mysqli_real_escape_string($con, trim($_POST['google_map_embed']));

    if ($contact) {
        // Update existing row
        $query = "UPDATE contact_info SET
                    address = '$address',
                    email = '$email',
                    phone = '$phone',
                    google_map_embed = '$google_map_embed'
                  WHERE id = {$contact['id']}";
    } else {
        // Insert new row
        $query = "INSERT INTO contact_info (address, email, phone, google_map_embed)
                  VALUES ('$address', '$email', '$phone', '$google_map_embed')";
    }

    if (mysqli_query($con, $query)) {
        $message = "<div class='alert alert-success'>Contact information updated successfully!</div>";
        $contactQuery = mysqli_query($con, "SELECT * FROM contact_info LIMIT 1");
        $contact = mysqli_fetch_assoc($contactQuery);
    } else {
        $message = "<div class='alert alert-danger'>Error updating contact info: " . mysqli_error($con) . "</div>";
    }
}

include('includes/header.php');
?>

<div class="container mt-4">
    <h2>Edit Contact Information</h2>
    <?= $message; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($contact['address'] ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($contact['email'] ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($contact['phone'] ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Google Map Embed Link</label>
            <textarea name="google_map_embed" class="form-control" rows="3" required><?= htmlspecialchars($contact['google_map_embed'] ?? ''); ?></textarea>
        </div>
        <button type="submit" name="update_contact" class="btn btn-primary">Update Contact Info</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
