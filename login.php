<?php
// Starting a session to manage user login state
session_start();

// Redirecting the user to the main authenticated page if they are already logged in
if (isset($_SESSION['username'])) {
	header("Location: main_auth.php");
exit();
}

// Setting page title and description
$pageTitle = "Login";
$pageDescription = "Log in to access all the educational resources on our site.";

// Function to generate the head section of the HTML page
function generateHead($title, $description) {
	$head = "<head>\n";
	$head .= "<meta charset=\"UTF-8\">\n";
	$head .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n";
	$head .= "<title>$title</title>\n";
	$head .= "<meta name=\"description\" content=\"$description\">\n";
	$head .= "<link rel=\"stylesheet\" href=\"styles.css\">\n";
	$head .= "</head>\n";
 return $head;
}

// Function to generate the login form
function generateLoginForm() {
	$form = "<form method=\"post\">\n";
	$form .= "<label for=\"username\">Username:</label>\n";
	$form .= "<input type=\"text\" id=\"username\" name=\"username\" required>\n";
	$form .= "<br>\n";
	$form .= "<label for=\"password\">Password:</label>\n";
	$form .= "<input type=\"password\" id=\"password\" name=\"password\" required>\n";
	$form .= "<br>\n";
	$form .= "<button type=\"submit\">Log in</button>\n";
	$form .= "</form>\n";
 return $form;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if both username and password fields have been filled
    if (empty($_POST['username']) || empty($_POST['password'])) {
        echo "<p>Please fill in all fields.</p>";
    } else {
        // Get the username and password submitted by the user
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Set up PDO connection to the database
        $host = "localhost";
        $dbname = "mydatabase";
        $user = "myusername";
        $pass = "mypassword";
        $charset = "utf8mb4";

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

        // Prepare and execute a SELECT statement to check if the user exists in the database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // If the user does not exist, display an error message with a link to the registration page
        if (!$user) {
            echo "<p>Username not found. Please try again or <a href=\"register.php\">register</a> for an account.</p>";
        } else {
            // If the user exists, check if the submitted password matches the password hash in the database
            if (password_verify($password, $user['password'])) {
                // If the passwords match, redirect the user to the authenticated main page
                header("Location: main_auth.php");
                exit();
            } else {
                // If the passwords don't match, display an error message
                echo "<p>Incorrect password. Please try again.</p>";
            }
        }
    }
}

// Output the HTML for the login page
echo "<!DOCTYPE html>\n";
echo "<html>\n";
echo generateHead($pageTitle, $pageDescription);
echo "<body>\n";
echo "<h1>Login</h1>\n";
echo "<p>Log in to access all the educational resources on our site.</p>\n";
echo generateLoginForm();
echo "</body>\n";
echo "</html>";

?>
