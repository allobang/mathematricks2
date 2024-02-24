<?php
session_start();
include('connection.php');

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
// Fetch all questions from the database
$query = "SELECT * FROM `quizquestions` ORDER BY `created_at` DESC";
$result = $mysqli->query($query);

// Check if the query was successful
if (!$result) {
    die('Error: ' . $mysqli->error);
}
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
                            <div class="page-pretitle">Question</div>
                            <h2 class="page-title">List</h2>
                        </div>
                    </div>
                    <!-- end title -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="content">
                                    <div class="head">
                                        <h5 class="mb-0">Questions Table</h5>
                                        <p class="text-muted">You are viewing the lists of Questions</p>
                                    </div>

                                    <div class="canvas-wrapper">
                                        <div class="col-lg-12">
                                            <div class="row g-2 justify-content-end">
                                                <div class="row g-2">
                                                    <!-- Button to add a question, now moved to the left -->
                                                    <div class="mb-3 col-md-auto">
                                                        <button type="button" class="btn btn-primary"
                                                            style="margin-top: 32px;"
                                                            onclick="window.location.href='question.php';">Add</button>
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label for="grade" class="form-label">Grade</label>
                                                        <select id="filterGrade" name="grade" class="form-select"
                                                            required>
                                                            <option value="" selected>Choose...</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label for="difficulty" class="form-label">Difficulty</label>
                                                        <select id="filterDifficulty" name="difficulty"
                                                            class="form-select" required>
                                                            <option value="" selected>Choose...</option>
                                                            <option value="Easy">Easy</option>
                                                            <option value="Medium">Medium</option>
                                                            <option value="Hard">Hard</option>
                                                        </select>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="d-flex justify-content-center">
                                                <table class="table table-hover" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Grade</th>
                                                            <th>Difficulty</th>
                                                            <th>Question</th>
                                                            <th>Choice1</th>
                                                            <th>Choice2</th>
                                                            <th>Choice3</th>
                                                            <th>Choice4</th>
                                                            <th>Answer</th>
                                                            <th>Explanation</th>
                                                            <th>Image</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php while ($row = $result->fetch_assoc()): ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo htmlspecialchars($row['id']); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlspecialchars($row['grade']); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlspecialchars($row['difficulty']); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlspecialchars($row['question']); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlspecialchars($row['choice1']); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlspecialchars($row['choice2']); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlspecialchars($row['choice3']); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlspecialchars($row['choice4']); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlspecialchars($row['answer']); ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo htmlspecialchars($row['explanation']); ?>
                                                                </td>
                                                                <td>
                                                                    <?php if ($row['image_url']): ?>
                                                                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>"
                                                                            alt="Question Image"
                                                                            style="width: 100px; height: auto;">
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <a href="editQuestion.php?id=<?php echo $row['id']; ?>"
                                                                        title="Edit">
                                                                        <i class="fas fa-edit"></i>
                                                                        <!-- Placeholder for an edit icon -->
                                                                    </a>
                                                                    |
                                                                    <a href="deleteQuestion.php?id=<?php echo $row['id']; ?>"
                                                                        onclick="return confirm('Are you sure you want to delete this?');"
                                                                        title="Delete">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                        <!-- Placeholder for a delete icon -->
                                                                    </a>
                                                            </tr>
                                                        <?php endwhile; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function () {
                // Function to fetch filtered questions
                function fetchFilteredQuestions() {
                    var grade = $("#filterGrade").val();
                    var difficulty = $("#filterDifficulty").val();
                    $.ajax({
                        url: 'filterQuestions.php',
                        type: 'GET',
                        data: {
                            grade: grade,
                            difficulty: difficulty
                        },
                        success: function (data) {
                            $('tbody').html(data);
                        }
                    });
                }

                // Event listeners for both filters
                $("#filterGrade, #filterDifficulty").change(function () {
                    fetchFilteredQuestions();
                });
            });
        </script>


        <?php include 'layout/foot.php'; ?>