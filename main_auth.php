<?php
// Start a new session or resume an existing session.
session_start();

// Check if a session variable named 'username' is set, if not redirect the user to the index page.
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Set page title and description.
$pageTitle = "Welcome to Kids Educational Site";
$pageDescription = "This site is designed to provide educational resources for kids.";

// Create an array of image URLs.
$images = array(                                    
    "https://images.pexels.com/photos/1741230/pexels-photo-1741230.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1",
    "https://images.pexels.com/photos/374916/pexels-photo-374916.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
);

// Function to generate the HTML head section.
function generateHead($title, $description) {
    // Create a string variable with HTML for the head section.
    $head = "<head>\n";
    $head .= "<meta charset=\"UTF-8\">\n";
    $head .= "<title>$title</title>\n";
    $head .= "<meta name=\"description\" content=\"$description\">\n";
    $head .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"styles.css\">\n";
    $head .= "</head>\n";
    // Return the HTML string for the head section.
    return $head;
}


function generateBody($images) {
    $body = "<body>\n";
    // Create navigation bar with links to feedback and logout pages
    $body .= '<nav class="nav">'."\n";
    $body .= '<ul>'."\n";
    $body .= '<li><a href="feedback.php"><button>Feedback</button></a></li>'."\n";
    $body .= '<li><a href="logout.php"><button>Log Out</button></a></li>'."\n";
    $body .= '</ul>'."\n";
    $body .= '</nav>'."\n";
    // Add heading and introductory text to the page
    $body .= "<h1>Welcome to Kids Educational Site</h1>\n";
    $body .= "<p>This site is designed to provide educational resources for kids.</p>\n";
    // Add first image and description
    $body .= "<div class=\"image-container\">\n";
    $body .= "<img src=\"$images[0]\" alt=\"\" />\n";
    $body .= "<a href=\"reading.php\"><button>Reading</button></a>\n";
    $body .= "<p>Reading is the ability to decode and understand written language. It is an essential skill that opens up a world of knowledge and imagination. Reading helps us learn new things, understand different perspectives, and communicate effectively.</p>\n";
    $body .= "</div>\n";
    // Add second image and description
    $body .= "<div class=\"image-container\" style=\"margin-top: 50px;\">\n";
    $body .= "<img src=\"$images[1]\" alt=\"\" />\n";
    $body .= "<a href=\"math.php\"><button>Mathematics</button></a>\n";
    $body .= "<p>Mathematics is the study of numbers, quantities, and shapes. It helps us understand the world around us and solve problems. From counting to calculus, mathematics is an important part of our lives.</p>\n";
    $body .= "</div>\n";
    $body .= "</body>\n";
    return $body;
}

// Generate the HTML page
echo "<!DOCTYPE html>\n";
echo "<html>\n";
// Generate the head section with page title, description and CSS style sheet
echo generateHead($pageTitle, $pageDescription);
// Generate the body section with content and images
echo generateBody($images);
echo "</html>";


?>