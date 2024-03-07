<?php
session_start();
include('connection.php');

// Check if the user is logged in and has the right privileges (optional, depending on your needs)
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Check if the form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['game_timer_hours'], $_POST['game_timer_minutes'])) {
    // Sanitize input data
    $hours = $mysqli->real_escape_string($_POST['game_timer_hours']);
    $minutes = $mysqli->real_escape_string($_POST['game_timer_minutes']);
    
    // Convert hours to minutes and add to total minutes
    $totalMinutes = ($hours * 60) + $minutes;
    
    // Prepare a SQL statement to insert/update the timer setting
    $sql = "INSERT INTO quiz_settings (setting_name, setting_value, description) VALUES ('quiz_duration', ?, 'Default quiz duration in minutes') ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)";

    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $totalMinutes);
        
        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            header("location:displayQuestions.php");
        } else {
            echo "Error: " . $stmt->error;
        }
        
        // Close statement
        $stmt->close();
    } else {
        echo "Error preparing the statement: " . $mysqli->error;
    }
} else {
    echo "Invalid request.";
}

// Close connection
$mysqli->close();
?>
