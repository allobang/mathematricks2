<?php
session_start();
include('connection.php');

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Check if there is a POST request with file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if file is uploaded with no errors

    // Prepare an insert statement
    $query = "INSERT INTO QuizQuestions (grade, subject, difficulty, question, choice1, choice2, choice3, choice4, answer, explanation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $mysqli->prepare($query)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ssssssssss", $_POST['grade'], $_POST['subject'], $_POST['difficulty'], $_POST['question'], $_POST['choice1'], $_POST['choice2'], $_POST['choice3'], $_POST['choice4'], $_POST['answer'], $_POST['explanation']);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Fetch the ID of the last inserted question
            $last_id = $mysqli->insert_id;

            // Redirect to editQuestion.php with the last inserted question ID
            header("Location: editQuestion.php?id=" . $last_id);
            exit;

            header('location:displayQuestions.php');
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $mysqli->error;
    }
}


// Close connection
$mysqli->close();
?>