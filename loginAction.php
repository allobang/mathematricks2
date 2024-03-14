<?php
session_start(); // Start the session at the beginning
include('connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare statement to prevent SQL injection
    $stmt = $mysqli->prepare("SELECT id, firstname, lastname, grade, section, usertype, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Password is correct, store user details in session variables
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $username;
            $_SESSION['firstname'] = $row['firstname'];
            $_SESSION['lastname'] = $row['lastname'];
            $_SESSION['grade'] = $row['grade'];
            $_SESSION['section'] = $row['section'];
            $_SESSION['usertype'] = $row['usertype'];
            
            // Redirect based on user type
            header("Location: play.php");
        } else {
            // Password is not correct, redirect with error message
            header("Location: login.php?error=invalid");
        }
    } else {
        // Username not found, redirect with error message
        header("Location: login.php?error=invalid");
    }

    $stmt->close();
    $mysqli->close();
} else {
    // Form not submitted, redirect to login page
    header("Location: login.php");
}
?>
