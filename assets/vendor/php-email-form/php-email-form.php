<?php
// forms/contact.php

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    var_dump($_POST); // This will show the submitted form data in the browser

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = "zinute";
    $message = htmlspecialchars($_POST['message']);

    // Validate inputs
    $errors = [];
    if (empty($name)) {
        $errors[] = 'Name is required.';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is required.';
    }
    if (empty($subject)) {
        $errors[] = 'Subject is required.';
    }
    if (empty($message)) {
        $errors[] = 'Message is required.';
    }

    // If there are no errors, process the form
    if (empty($errors)) {
        // Prepare email headers
        $to = 'vaidas393@gmail.com'; // Replace with your email
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        // Prepare email body
        $email_body = "Name: $name\n";
        $email_body .= "Email: $email\n";
        $email_body .= "Subject: $subject\n";
        $email_body .= "Message:\n$message\n";

        // Send email
        if (mail($to, $subject, $email_body, $headers)) {
            // If email sent successfully, redirect back to the page
            $redirect_url = $_SERVER['HTTP_REFERER'] . "?status=success";
            header("Location: " . $redirect_url);
            exit();
        } else {
            // If email fails to send, show error message
            $redirect_url = $_SERVER['HTTP_REFERER'] . "?status=error";
            header("Location: " . $redirect_url);
            exit();
        }
    } else {
        // If there are validation errors, redirect back with errors
        $redirect_url = $_SERVER['HTTP_REFERER'] . "?status=error&errors=" . urlencode(implode(', ', $errors));
        header("Location: " . $redirect_url);
        exit();
    }
} else {
    // If the form is not submitted via POST, return an error
    echo 'Form submission error.';
}
?>
