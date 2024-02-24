<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Rest of your index.php code...
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
                            <div class="page-pretitle">Add</div>
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
                                        <form action="addQuestion.php" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="grade">Grade:</label>
                                                        <input type="text" class="form-control" id="grade" name="grade">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="subject">Subject:</label>
                                                        <input type="text" class="form-control" id="subject"
                                                            name="subject">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="difficulty">Difficulty:</label>
                                                <select class="form-control" id="difficulty" name="difficulty">
                                                    <option value="Easy">Easy</option>
                                                    <option value="Medium">Medium</option>
                                                    <option value="Hard">Hard</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="question">Question:</label>
                                                <textarea class="form-control" id="question" name="question"
                                                    rows="3"></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="choice1">Choice 1:</label>
                                                        <input type="text" class="form-control" id="choice1"
                                                            name="choice1">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="choice3">Choice 3:</label>
                                                        <input type="text" class="form-control" id="choice3"
                                                            name="choice3">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="choice2">Choice 2:</label>
                                                        <input type="text" class="form-control" id="choice2"
                                                            name="choice2">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="choice4">Choice 4:</label>
                                                        <input type="text" class="form-control" id="choice4"
                                                            name="choice4">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="answer">Answer:</label>
                                                <input type="text" class="form-control" id="answer" name="answer">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="explanation">Explanation:</label>
                                                <textarea class="form-control" id="explanation" name="explanation"
                                                    rows="3"></textarea>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </form>
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