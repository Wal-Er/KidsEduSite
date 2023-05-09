<?php
// Set the page title and description
$pageTitle = "Feedback Form";
$pageDescription = "Please provide your feedback about our website.";

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Retrieve user input from the form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $feedback = $_POST['feedback'];

    // Define the email parameters
    $to = "email@example.com";
    $subject = "Feedback from $name";
    $message = "Name: $name\n\nEmail: $email\n\nFeedback: $feedback";

    // Send the email and display a confirmation message to the user
    if (mail($to, $subject, $message)) {
        echo "<h2>Thank you, $name, for your feedback!</h2>";
        echo "<p>We appreciate you taking the time to let us know your thoughts about our website.</p>";
        echo "<p>Here's what you had to say:</p>";
        echo "<p>$feedback</p>";
    } else {
        echo "<h2>Sorry, there was an error sending your feedback.</h2>";
        echo "<p>Please try again later.</p>";
    }
} else {
    // Display the feedback form to the user
    echo "<!DOCTYPE html>";
    echo "<html lang=\"en\">";
    echo "<head>";
    echo "<meta charset=\"UTF-8\">";
    echo "<title>$pageTitle</title>";
    echo "<link rel=\"stylesheet\" href=\"styles.css\">";
    echo "</head>";
    echo "<body>";
    echo "<h2>Feedback Form</h2>";
    echo "<p>Please provide your feedback about our website.</p>";
    echo "<form method=\"post\">";
    echo "<label for=\"name\">Name:</label><br>";
    echo "<input type=\"text\" id=\"name\" name=\"name\" required><br>";
    echo "<label for=\"email\">Email:</label><br>";
    echo "<input type=\"email\" id=\"email\" name=\"email\" required><br>";
    echo "<label for=\"feedback\">Feedback:</label><br>";
    echo "<textarea id=\"feedback\" name=\"feedback\" rows=\"5\" cols=\"30\" required></textarea><br>";
    echo "<input type=\"submit\" name=\"submit\" value=\"Submit\">";
    echo "</form>";
    echo "</body>";
    echo "</html>";
}
?> 