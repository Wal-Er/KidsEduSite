<?php
// Start a PHP session.
session_start();

// If the user is not logged in, redirect them to the login page.
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Set the page description for SEO.
$pageDescription = "Watch the cartoon and solve the quiz at the bottom of the page.";

//Generate the HTML head section.
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

// Define the quiz questions and answers.
$questions = array(
    "1 + 1 = ?" => array("2", "3", "4"),
    "2 + 3 = ?" => array("5", "6", "7")
);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // If the form was submitted with POST method
    $score = 0;

    // Loop through the questions and check the selected answer
    foreach ($questions as $question => $answers) {
        if (isset($_POST[$question])) {
            $selected_answer = $_POST[$question];
            $correct_answer = $answers[0];
            if ($selected_answer == $correct_answer) {
                $score++;
            }
        }
    }

    // Save the score in the session variable and redirect to the same page
    $_SESSION["quiz_result"] = "$score from " . count($questions);
    header("Location: " . $_SERVER["REQUEST_URI"]);
    exit();
}

if (isset($_SESSION["quiz_result"])) {
    // If the quiz result is already set in the session, show the score
    $score = explode(" ", $_SESSION["quiz_result"])[0];
    $total = count($questions);
    echo "<p>Your result: $score out of $total</p>";
    unset($_SESSION["quiz_result"]);
}

if (!isset($_SESSION["quiz_result"])) {
    // If the quiz result is not set in the session, show the quiz form
    echo "<!DOCTYPE html>\n";
    echo "<html>\n";
    echo generateHead("Math Adventures", $pageDescription);
    echo "<body>";
    echo "<h1>Math Adventures</h1>";
    echo "<iframe width='100%' height='315' src='https://www.youtube.com/embed/GZ0HpuFQLcY' frameborder='0' allowfullscreen></iframe>";

    // Loop through the questions and generate the form
    echo "<h2>Quiz</h2>";
    echo "<form method='post'>";
    foreach ($questions as $question => $answers) {
        echo "<p><strong>$question</strong></p>";
        foreach ($answers as $answer) {
            echo "<label><input type='radio' name='$question' value='$answer'> $answer</label><br>";
        }
    }
    echo "<br><input type='submit' value='Send' class='button'>";
    echo "<a href='main_auth.php' class='button' style='float:right;'>Go to main page</a>";
    echo "</form>";

    echo "</html>\n";
}

?>