<?php
session_start();
include('connection.php');

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$message = '';

// Check if the question ID is passed and is a number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare a delete statement
    if ($stmt = $mysqli->prepare("DELETE FROM QuizQuestions WHERE id = ?")) {
        $stmt->bind_param("i", $id);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            header('location:displayQuestions.php');
        } else {
            $message = "Error deleting question: " . $stmt->error;
        }

        $stmt->close();
    }
} else {
    $message = "Invalid request. No question ID specified.";
}

$mysqli->close();
?>