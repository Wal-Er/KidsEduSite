<?php
// Start the session
session_start();

// Destroy the session, effectively logging the user out
session_destroy();

// Redirect the user to the homepage
header("Location: index.php");

// Terminate the script
exit();
?>