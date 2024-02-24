<?php
session_start();
include('connection.php');

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
        // $question['difficulty'] = "Medium";
        // var_dump($question['difficulty']);
        // die();
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
                            <div class="page-pretitle">Edit</div>
                            <h2 class="page-title">Question</h2>
                        </div>
                        <!-- end title -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <h5 class="card-title">Quiz Form</h5>
                                            <p class="card-subtitle mb-2 text-muted">This is considered as one question
                                            </p>
                                        </div>
                                        <form action="editQuestionAction.php" method="post"
                                            enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="grade">Grade:</label>
                                                        <input type="text" class="form-control" id="grade" name="grade"
                                                            value="<?php echo htmlspecialchars($question['grade']); ?>">
                                                        <input type="text" class="form-control" id="id" name="id"
                                                            value="<?php echo htmlspecialchars($question['id']); ?>"
                                                            hidden>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="subject">Subject:</label>
                                                        <input type="text" class="form-control" id="subject"
                                                            name="subject"
                                                            value="<?php echo htmlspecialchars($question['subject']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="difficulty">Difficulty:</label>
                                                <select class="form-control" id="difficulty" name="difficulty">
                                                    <option value="Easy" <?php echo ($question['difficulty'] == 'Easy') ? 'selected' : ''; ?>>Easy</option>
                                                    <option value="Medium" <?php echo ($question['difficulty'] == 'Medium') ? 'selected' : ''; ?>>Medium
                                                    </option>
                                                    <option value="Hard" <?php echo ($question['difficulty'] == 'Hard') ? 'selected' : ''; ?>>Hard</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="question">Question:</label>
                                                <textarea class="form-control" id="question" name="question"
                                                    rows="3"><?php echo htmlspecialchars($question['question']); ?></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="choice1">Choice 1:</label>
                                                        <input type="text" class="form-control" id="choice1"
                                                            name="choice1"
                                                            value="<?php echo htmlspecialchars($question['choice1']); ?>">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="choice3">Choice 3:</label>
                                                        <input type="text" class="form-control" id="choice3"
                                                            name="choice3"
                                                            value="<?php echo htmlspecialchars($question['choice3']); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="choice2">Choice 2:</label>
                                                        <input type="text" class="form-control" id="choice2"
                                                            name="choice2"
                                                            value="<?php echo htmlspecialchars($question['choice2']); ?>">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="choice4">Choice 4:</label>
                                                        <input type="text" class="form-control" id="choice4"
                                                            name="choice4"
                                                            value="<?php echo htmlspecialchars($question['answer']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="answer">Answer:</label>
                                                <input type="text" class="form-control" id="answer" name="answer"
                                                    value="<?php echo htmlspecialchars($question['answer']); ?>">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="explanation">Explanation:</label>
                                                <textarea class="form-control" id="explanation" name="explanation"
                                                    rows="3"><?php echo htmlspecialchars($question['explanation']); ?></textarea>
                                            </div>
                                            <div class="form-group mb-4">
                                                <!-- <label for="image">Image:</label>
                                                <input type="file" class="form-control" id="image" name="image"
                                                    accept="image/*"> -->
                                                <a class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal">
                                                    <i class="fas fa-file-upload"></i> Upload Image
                                                </a>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Update Question</button>
                                        </form>

                                        <!-- modal part -->

                                        <div class="modal fade" id="exampleModal" role="dialog" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Upload Image</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <form class="needs-validation" method="post"
                                                            action="uploadQuestionImage.php"
                                                            enctype="multipart/form-data" novalidate>
                                                            <div class="mb-3">
                                                                <input class="form-control" type="file" id="formFile"
                                                                    name="uploadedFile">
                                                                <input type="text" class="form-control" id="id"
                                                                    name="id"
                                                                    value="<?php echo htmlspecialchars($question['id']); ?>"
                                                                    hidden>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary"><i
                                                                    class="fas fa-save"></i>
                                                                Save</button>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- end modal part -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'layout/foot.php'; ?>
</body>

</html>