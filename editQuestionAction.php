<?php
session_start();
include("connection.php");

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extract the id from the form data
    $id = $_POST['id']; // Make sure you're getting the id correctly

    $grade = $_POST['grade'];
    $subject = $_POST['subject'];
    $difficulty = $_POST['difficulty'];
    $question_text = $_POST['question'];
    $choice1 = $_POST['choice1'];
    $choice2 = $_POST['choice2'];
    $choice3 = $_POST['choice3'];
    $choice4 = $_POST['choice4'];
    $answer = $_POST['answer'];
    $explanation = $_POST['explanation'];

    // Prepare the update statement
    if ($update_stmt = $mysqli->prepare("UPDATE QuizQuestions SET grade = ?, subject = ?, difficulty = ?, question = ?, choice1 = ?, choice2 = ?, choice3 = ?, choice4 = ?, answer = ?, explanation = ? WHERE id = ?")) {
        // Bind parameters
        $update_stmt->bind_param("ssssssssssi", $grade, $subject, $difficulty, $question_text, $choice1, $choice2, $choice3, $choice4, $answer, $explanation, $id);

        // Execute the statement
        if ($update_stmt->execute()) {
            $message = "Question updated successfully.";
            header("location:displayQuestions.php");
        } else {
            $message = "Error updating record: " . $update_stmt->error;
        }

        $update_stmt->close();
    } else {
        echo "Error preparing statement: " . $mysqli->error;
    }
}
