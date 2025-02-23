<?php
// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data and sanitize input
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($_POST['message']);
    $subject = "Message from your website"; // Customize if needed

    // Validate inputs
    $errors = [];
    if (empty($name)) {
        $errors[] = 'Name is required.';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is required.';
    }
    if (empty($message)) {
        $errors[] = 'Message is required.';
    }

    // If there are no validation errors, process the form
    if (empty($errors)) {
        // Email recipient
        $to = 'vaidas393@gmail.com'; // Change to your email

        // Always use your domain email in the 'From' field
        $headers = "From: Kirpykla Site <noreply@kirpykla.site>\r\n"; // Avoid Gmail/Yahoo blocking emails
        $headers .= "Reply-To: $email\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        // Email content
        $email_body = "<strong>Name:</strong> $name<br>
                       <strong>Email:</strong> $email<br>
                       <strong>Message:</strong><br>$message<br>";

        // Send the email using PHP's mail() function
        if (mail($to, $subject, $email_body, $headers)) {
            header('Location: ' . $_SERVER['HTTP_REFERER'] . '?status=success');
            exit();
        } else {
            // Log the error for debugging
            error_log("Mail function failed: " . error_get_last()['message']);
            header('Location: ' . $_SERVER['HTTP_REFERER'] . '?status=error&errors=Email sending failed.');
            exit();
        }
    } else {
        // Redirect back with validation errors
        header('Location: ' . $_SERVER['HTTP_REFERER'] . "?status=error&errors=" . urlencode(implode(', ', $errors)));
        exit();
    }
} else {
    echo 'Error: Form not submitted.';
}
?>
