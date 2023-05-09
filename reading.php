<?php
// Start a new session.
session_start();

// Check if the user is logged in. If not, redirect to the login page.
if (!isset($_SESSION['username'])) {
	header("Location: index.php");
exit();
}

// Define the page description for SEO.
$pageDescription = "Watch the cartoon and solve the quiz at the bottom of the page.";

// Define a function to generate the HTML head section.
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
"What letter comes after A in the English alphabet?\" => array("B", "C", "D"),
"Which letter is the 18th letter in the English alphabet?\" => array("Q", "R", "S")
);

// check if form was submitted via POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $score = 0;

    // loop through each question and check if answer is correct
    foreach ($questions as $question => $answers) {
        if (isset($_POST[$question])) { // check if answer to question was submitted
            $selected_answer = $_POST[$question];
            $correct_answer = $answers[0]; // assume first answer is correct
            if ($selected_answer == $correct_answer) { // compare selected answer with correct answer
                $score++; // increment score if answer is correct
            }
        }
    }

    // save quiz result to session
    $_SESSION["quiz_result"] = "$score from " . count($questions);

    // redirect to the current page to prevent resubmitting the form
    header("Location: " . $_SERVER["REQUEST_URI"]);
    exit();
}

// display quiz result if available in session
if (isset($_SESSION["quiz_result"])) {
    $score = explode(" ", $_SESSION["quiz_result"])[0];
    $total = count($questions);
    echo "<p>Your result: $score out of $total</p>";
    unset($_SESSION["quiz_result"]); // remove quiz result from session
}

// display quiz form if quiz result is not available in session
if (!isset($_SESSION["quiz_result"])) {
    echo "<!DOCTYPE html>\n";
    echo "<html>\n";
    echo generateHead("Alphabet Adventures", $pageDescription); // generate HTML head with title and description
    echo "<body>";
    echo "<h1>Alphabet Adventures</h1>";
    echo "<iframe width='100%' height='315' src='https://www.youtube.com/watch?v=drlIUqRYM-w' frameborder='0' allowfullscreen></iframe>";

    // display quiz form
    echo "<h2>Quiz</h2>";
    echo "<form method='post'>";
    foreach ($questions as $question => $answers) {
        echo "<p><strong>$question</strong></p>";
        foreach ($answers as $answer) {
            echo "<label><input type='radio' name='$question' value='$answer'> $answer</label><br>"; // display answer options as radio buttons
        }
    }
    echo "<br><input type='submit' value='Send' class='button'>";
    echo "<a href='main_auth.php' class='button' style='float:right;'>Go to main page</a>";
    echo "</form>";

    echo "</html>\n";
}


?>