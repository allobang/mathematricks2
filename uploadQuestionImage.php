<?php
session_start();
include("connection.php");

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
$id = $_POST["id"];
if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] == 0) {
    // Fetch the current profile picture filename
    $stmt = $mysqli->prepare("SELECT image_url FROM quizquestions WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentProfilePicture = $row['image_url'];
        // Check if there's an existing profile picture and delete it
        if (!empty($currentProfilePicture)) {
            $fileToDelete = $currentProfilePicture;
            if (file_exists($fileToDelete)) {
                unlink($fileToDelete);
            }
        }
    }
    // Continue with your file upload process
    $originalFileName = $_FILES['uploadedFile']['name'];
    $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    $newFileName = uniqid() . '.' . $fileExtension;
    $uploadDirectory = 'assets/img/';
    move_uploaded_file($_FILES['uploadedFile']['tmp_name'], $uploadDirectory . $newFileName);
    $image_url = $uploadDirectory . $newFileName;

    // Update the database with the new profile picture filename
    $stmt = $mysqli->prepare("UPDATE quizquestions SET image_url = ? WHERE id = ?");
    $stmt->bind_param("ss", $image_url, $id);
    if ($stmt->execute()) {
        header('location: displayQuestions.php');
    } else {
        // Handle error, maybe log it or notify the user
        header('location: displayQuestions.php');
    }
} else {
    // Handle file upload error, maybe log it or notify the user
    header('location: displayQuestions.php');
}