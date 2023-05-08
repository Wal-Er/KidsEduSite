<?php
// Start a new session
session_start();

// Redirect the user to the main page if they are already logged in
if (isset($_SESSION['username'])) {
    header("Location: main_auth.php");
    exit();
}

// Set the page title and description
$pageTitle = "Register";
$pageDescription = "Create an account to access all the educational resources on our site.";

// Function to generate the HTML for the head section of the page
function generateHead($pageTitle, $pageDescription) {
    $head = "<head>\n";
    $head .= "<meta charset=\"UTF-8\">\n";
    $head .= "<title>" . $pageTitle . "</title>\n";
    $head .= "<meta name=\"description\" content=\"" . $pageDescription . "\">\n";
    $head .= "<link rel=\"stylesheet\" href=\"styles.css\">\n";
    $head .= "</head>\n";
 return $head;
}

// Function to generate the HTML for the registration form
function generateRegistrationForm() {
    $form = "<form method=\"post\">\n";
    $form .= "<label for=\"username\">Username:</label>\n";
    $form .= "<input type=\"text\" id=\"username\" name=\"username\" required>\n";
    $form .= "<br>\n";
    $form .= "<label for=\"password\">Password:</label>\n";
    $form .= "<input type=\"password\" id=\"password\" name=\"password\" required>\n";
    $form .= "<br>\n";
    $form .= "<label for=\"confirm-password\">Confirm Password:</label>\n";
    $form .= "<input type=\"password\" id=\"confirm-password\" name=\"confirm-password\" required>\n";
    $form .= "<br>\n";
    $form .= "<button type=\"submit\">Register</button>\n";
    $form .= "</form>\n";
 return $form;
}



// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Check if any required fields are empty
    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['confirm-password'])) {
        echo "<p>Please fill in all fields.</p>";
    } else {
        // Check if passwords match
        if ($_POST['password'] !== $_POST['confirm-password']) {
            echo "<p>Passwords do not match.</p>";
        } else {
            // Get the username and password from the POST request
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            // Set up database credentials
            $host = "localhost";
            $dbname = "mydatabase";
            $user = "myusername";
            $pass = "mypassword";
            $charset = "utf8mb4";
            
            // Set up a PDO connection with the database
            $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            try {
                $pdo = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
            // Check if the username already exists in the database
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            if ($user) {
                echo "<p>Username already exists. Please choose a different username.</p>";
            } else {
                // Hash the password and store the user's information in the database
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                $stmt->execute([$username, $hash]);
                echo "<p>Registration successful. You can now <a href=\"login.php\">log in</a>.</p>";
            }
        }
    }
}

// Generate the HTML for the registration form
echo "<!DOCTYPE html>\n";
echo "<html>\n";
echo generateHead($pageTitle, $pageDescription);
echo "<body>\n";
echo "<h1>Register</h1>\n";
echo "<p>Create an account to access all the educational resources on our site.</p>\n";
echo generateRegistrationForm();
echo "</body>\n";
echo "</html>";

?>
