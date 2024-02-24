<?php
session_start();
include('connection.php');

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$message = '';
$question = null;

// Check if the question ID is passed
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the question details
    if ($stmt = $mysqli->prepare("SELECT * FROM QuizQuestions WHERE id = ?")) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $question = $result->fetch_assoc();

        if (!$question) {
            $message = "No question found with ID $id.";
        }

        $stmt->close();
    }

    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Update the question
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

        if ($update_stmt = $mysqli->prepare("UPDATE QuizQuestions SET grade = ?, subject = ?, difficulty = ?, question = ?, choice1 = ?, choice2 = ?, choice3 = ?, choice4 = ?, answer = ?, explanation = ? WHERE id = ?")) {
            $update_stmt->bind_param("ssssssssssi", $grade, $subject, $difficulty, $question_text, $choice1, $choice2, $choice3, $choice4, $answer, $explanation, $id);

            if ($update_stmt->execute()) {
                $message = "Question updated successfully.";
                // Redirect to a confirmation page or refresh to see changes
            } else {
                $message = "Error updating record: " . $update_stmt->error;
            }

            $update_stmt->close();
        }
    }
} else {
    $message = "No question ID specified.";
}

$mysqli->close();
?>

<!doctype html>
<!-- 
* Bootstrap Simple Admin Template
* Version: 2.1
* Author: Alexis Luna
* Website: https://github.com/alexis-luna/bootstrap-simple-admin-template
-->
<html lang="en">

<?php include 'layout/head.php'; ?>

<body>
    <div class="wrapper">
        <?php include 'layout/side.php'; ?>
        <div id="body" class="active">
            <?php include 'layout/nav.php'; ?>
            <div class="content">
                <div class="container">
                    <!-- title -->
                    <div class="row">
                        <div class="col-md-12 page-header">
                            <div class="page-pretitle">Question</div>
                            <h2 class="page-title">Dashboard</h2>
                        </div>
                    </div>
                    <!-- end title -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="content">
                                    <div class="head">
                                        <h5 class="mb-0">Sample Shit</h5>
                                        <p class="text-muted">Subtitle shit</p>
                                    </div>
                                    <div class="canvas-wrapper">

                                        <h2>Edit Question</h2>
                                        <?php if (!empty($message)): ?>
                                            <p>
                                                <?php echo $message; ?>
                                            </p>
                                        <?php endif; ?>

                                        <?php if ($question): ?>
                                            <form action="editQuestion.php?id=<?php echo $id; ?>" method="post">
                                                <label for="grade">Grade:</label>
                                                <input type="text" id="grade" name="grade"
                                                    value="<?php echo htmlspecialchars($question['grade']); ?>"><br>

                                                <label for="subject">Subject:</label>
                                                <input type="text" id="subject" name="subject"
                                                    value="<?php echo htmlspecialchars($question['subject']); ?>"><br>

                                                <label for="difficulty">Difficulty:</label>
                                                <select id="difficulty" name="difficulty">
                                                    <option value="Easy" <?php echo ($question['difficulty'] == 'Easy') ? 'selected' : ''; ?>>Easy</option>
                                                    <option value="Medium" <?php echo ($question['difficulty'] == 'Medium') ? 'selected' : ''; ?>>Medium</option>
                                                    <option value="Hard" <?php echo ($question['difficulty'] == 'Hard') ? 'selected' : ''; ?>>Hard</option>
                                                </select><br>

                                                <label for="question">Question:</label>
                                                <textarea id="question"
                                                    name="question"><?php echo htmlspecialchars($question['question']); ?></textarea><br>

                                                <label for="choice1">Choice 1:</label>
                                                <input type="text" id="choice1" name="choice1"
                                                    value="<?php echo htmlspecialchars($question['choice1']); ?>"><br>

                                                <label for="choice2">Choice 2:</label>
                                                <input type="text" id="choice2" name="choice2"
                                                    value="<?php echo htmlspecialchars($question['choice2']); ?>"><br>

                                                <label for="choice3">Choice 3:</label>
                                                <input type="text" id="choice3" name="choice3"
                                                    value="<?php echo htmlspecialchars($question['choice3']); ?>"><br>

                                                <label for="choice4">Choice 4:</label>
                                                <input type="text" id="choice4" name="choice4"
                                                    value="<?php echo htmlspecialchars($question['choice4']); ?>"><br>

                                                <label for="answer">Answer:</label>
                                                <input type="text" id="answer" name="answer"
                                                    value="<?php echo htmlspecialchars($question['answer']); ?>"><br>

                                                <label for="explanation">Explanation:</label>
                                                <textarea id="explanation"
                                                    name="explanation"><?php echo htmlspecialchars($question['explanation']); ?></textarea><br>

                                                <input type="submit" value="Update Question">
                                            </form>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'layout/foot.php'; ?>