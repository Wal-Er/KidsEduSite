<?php
// Start a session to keep track of user authentication status
session_start();

// Redirect user to main authenticated page if they are already logged in
if (isset($_SESSION['username'])) {
header("Location: main_auth.php");
exit();
}

// Set variables for the page title and description
$pageTitle = "Welcome to Kids Educational Site";
$pageDescription = "This site is designed to provide educational resources for kids.";

// Create an array of image URLs to display on the page
$images = array(
"https://images.pexels.com/photos/1741230/pexels-photo-1741230.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1",
"https://images.pexels.com/photos/374916/pexels-photo-374916.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
);

// Function to generate the HTML head section
function generateHead($title, $description) {
$head = "<head>\n";
$head .= "<meta charset=\"UTF-8\">\n";
$head .= "<title>$title</title>\n";
$head .= "<meta name=\"description\" content=\"$description\">\n";
$head .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"styles.css\">\n";
$head .= "</head>\n";
return $head;
}

// Function to generate the HTML body section
function generateBody($images) {
$body = "<body>\n";
$body .= "<nav class=\"nav\">\n";
$body .= "<ul>\n";
$body .= "<li><button><a href=\"login.php\">Log In</a></button></li>\n";
$body .= "<li><button><a href=\"register.php\">Sign Up</a></button></li>\n";
$body .= "<li><button><a href=\"feedback.php\">Feedback</a></button></li>\n";
$body .= "</ul>\n";
$body .= "</nav>\n";
$body .= "<h1>Welcome to Kids Educational Site</h1>\n";
$body .= "<p>This site is designed to provide educational resources for kids.</p>\n";
$body .= "<div class=\"image-container\">\n";
$body .= "<img src=\"$images[0]\" alt=\"\" />\n";
$body .= "<p>Reading is the ability to decode and understand written language. It is an essential skill that opens up a world of knowledge and imagination. Reading helps us learn new things, understand different perspectives, and communicate effectively.</p>\n";
$body .= "</div>\n";
$body .= "<div class=\"image-container\" style=\"margin-top: 50px;\">\n";
$body .= "<img src=\"$images[1]\" alt=\"\" />\n";
$body .= "<p>Mathematics is the study of numbers, quantities, and shapes. It helps us understand the world around us and solve problems. From counting to calculus, mathematics is an important part of our lives.</p>\n";
$body .= "</div>\n";
$body .= "</body>\n";
return $body;
}

// Generate the HTML for the page using the functions defined above
echo "<!DOCTYPE html>\n";
echo "<html>\n";
echo generateHead($pageTitle, $pageDescription);
echo generateBody($images);
echo "</html>";

?>