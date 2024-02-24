<?php
// Include the database connection file
include('connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $grade = $_POST['grade'];
    $section = $_POST['section'];
    $usertype = $_POST['usertype'];
    $username = $_POST['username'];
    $password = $_POST['password']; // Consider encrypting the password

    // Prepare and bind
    $stmt = $mysqli->prepare("INSERT INTO users (firstname, lastname, grade, section, usertype, username, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $firstname, $lastname, $grade, $section, $usertype, $username, $hashed_password);

    // Encrypt password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Execute the query
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header('Location: login.php');
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
