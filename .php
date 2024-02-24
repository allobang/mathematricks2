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
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $fileName = $_FILES['image']['name'];
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];
        $fileNameCmps = explode('.', $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Sanitize the file name and generate new unique file name
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $allowedfileExtensions = ['jpg', 'gif', 'png'];

        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Directory where the file is going to be placed
            $uploadFileDir = './assets/img/';
            $dest_path = $uploadFileDir . $newFileName;

            // Move the file to the desired folder
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $image_url = $dest_path;

                // Prepare an insert statement
                $query = "INSERT INTO QuizQuestions (grade, subject, difficulty, question, choice1, choice2, choice3, choice4, answer, explanation, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                
                if ($stmt = $mysqli->prepare($query)) {
                    // Bind variables to the prepared statement as parameters
                    $stmt->bind_param("sssssssssss", 
                        $_POST['grade'], 
                        $_POST['subject'], 
                        $_POST['difficulty'], 
                        $_POST['question'], 
                        $_POST['choice1'], 
                        $_POST['choice2'], 
                        $_POST['choice3'], 
                        $_POST['choice4'], 
                        $_POST['answer'], 
                        $_POST['explanation'], 
                        $image_url
                    );

                    // Attempt to execute the prepared statement
                    if ($stmt->execute()) {
                        echo "Question added successfully.";
                    } else {
                        echo "Error: " . $stmt->error;
                    }

                    // Close statement
                    $stmt->close();
                } else {
                    echo "Error preparing statement: " . $mysqli->error;
                }
            } else {
                echo 'Error moving the uploaded file.';
            }
        } else {
            echo 'Upload failed. Allowed file types: jpg, gif, png.';
        }
    } else {
        echo 'Error uploading the file. Error code: ' . $_FILES['image']['error'];
    }
}

// Close connection
$mysqli->close();
?>
