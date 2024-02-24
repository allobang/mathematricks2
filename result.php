<?php
session_start();
require_once('connection.php');

// Redirect if not logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit;
}

$sessionId = $_SESSION['current_session_id'] ?? 0;
$userGrade = $_SESSION['grade'] ?? '';

// Fetch all questions for the user's grade
$questionsQuery = "SELECT id, question, answer, explanation FROM quizquestions WHERE grade = ?";
$questionsStmt = $mysqli->prepare($questionsQuery);
$questionsStmt->bind_param("s", $userGrade);
$questionsStmt->execute();
$questionsResult = $questionsStmt->get_result();
$questions = $questionsResult->fetch_all(MYSQLI_ASSOC);

// Fetch all attempts with the selected answer
$attemptsQuery = "SELECT aa.question_id, aa.is_correct, aa.selected_answer 
                  FROM answer_attempts aa
                  WHERE session_id = ?";
$attemptsStmt = $mysqli->prepare($attemptsQuery);
$attemptsStmt->bind_param("i", $sessionId);
$attemptsStmt->execute();
$attemptsResult = $attemptsStmt->get_result();
$answeredAttempts = [];
while ($attempt = $attemptsResult->fetch_assoc()) {
    $answeredAttempts[$attempt['question_id']] = $attempt;
}
$totalScore = $_SESSION['quiz_score'] ?? 0;
$totalQuestions = count($questions);

$correctCount = 0;
$incorrectCount = 0;
$unansweredCount = $totalQuestions;

foreach ($answeredAttempts as $attempt) {
    if ($attempt['is_correct']) {
        $correctCount++;
    } else {
        $incorrectCount++;
    }
    $unansweredCount--; // Decrease for every answered question
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fafafa;
            color: #333;
            text-align: center;
            padding: 20px;
        }

        h1,
        h2 {
            color: #6a1b9a;
        }

        p,
        li {
            font-size: 16px;
        }

        .score-summary {
            background-color: #e1bee7;
            border-radius: 10px;
            padding: 10px;
            margin: 20px auto;
            display: inline-block;
        }

        #quizResultsChart {
            width: 300px;
            height: 300px;
            margin: 20px auto;
        }

        ol {
            text-align: left;
            display: inline-block;
            margin-top: 20px;
        }

        li {
            background-color: #f3e5f5;
            margin: 10px;
            padding: 10px;
            border-radius: 8px;
        }

        .question,
        .user-answer,
        .correct-answer,
        .no-answer {
            display: block;
            margin: 5px 0;
        }

        .correct-answer {
            color: #388e3c;
        }

        .incorrect-answer,
        .no-answer {
            color: #d32f2f;
        }

        button {
            background-color: #7b1fa2;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        .content-container {
            background-color: rgba(255, 255, 255, 0.85);
            /* White with transparency */
            padding: 20px;
            border-radius: 10px;
            margin: auto;
            width: 90%;
            /* Adjust width as needed */
            max-width: 800px;
            /* Maximum width */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Soft shadow for depth */
            position: relative;
            /* Above the video background */
            z-index: 1;
        }

        .video-bg {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
            /* Ensure video stays in the background */
        }
        ol {
    list-style-type: none; /* Removes default numbering */
}
    </style>
</head>

<body>
    <video autoplay loop muted class="video-bg">
        <source src="bee.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    
    <div class="content-container">
    <h1>Quiz Results</h1>
    <div class="score-summary">
        <h2>Score Summary</h2>
        <p><strong>Score:</strong>
            <?= $totalScore ?> /
            <?= $totalQuestions ?>
        </p>
    </div>

    <div>
        <canvas id="quizResultsChart"></canvas>
        
    <button onclick="window.location.href='play.php';">Play Again</button>
    </div>

        <!-- Quiz questions and answers -->
        <?php if (!empty($questions)): ?>
            <ol>
                <?php foreach ($questions as $index => $question): ?>
                    <?php
                    $isAnswered = isset($answeredAttempts[$question['id']]);
                    $isCorrect = $isAnswered ? $answeredAttempts[$question['id']]['is_correct'] : false;
                    $backgroundColor = $isCorrect ? '#c8e6c9' : '#ffcdd2'; // Greenish for correct, reddish for incorrect or unanswered
                    ?>
                    <li style="background-color: <?= $backgroundColor ?>; border-radius: 5px; padding: 5px; margin-bottom: 10px;">
                        <span
                            style="font-weight: bold; color: <?= $isAnswered ? ($isCorrect ? '#2e7d32' : '#c62828') : '#c62828' ?>;">
                            <?= $index + 1 ?>.
                        </span>
                        <?= "Question: " . htmlspecialchars($question['question']) ?><br>
                        <?php if ($isAnswered): ?>
                            You answered:
                            <?= htmlspecialchars($answeredAttempts[$question['id']]['selected_answer']) ?><br>
                            <?= $isCorrect ? '<span style="color: #2e7d32;">Correct</span>' : '<span style="color: #c62828;">Incorrect</span>' ?><br>
                            <?php if (!$isCorrect): ?>
                                Correct Answer:
                                <?= htmlspecialchars($question['answer']) ?><br>
                            <?php endif; ?>
                        <?php else: ?>
                            You answered: <span style="color: #c62828;">No answer</span><br>
                            Correct Answer:
                            <?= htmlspecialchars($question['answer']) ?><br>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ol>

        <?php else: ?>
            <p>No questions found for your grade.</p>
        <?php endif; ?>
    </div>
    <script>
        // Convert PHP variables to JavaScript
        const correctCount = <?= $correctCount ?>;
        const incorrectCount = <?= $incorrectCount ?>;
        const unansweredCount = <?= $unansweredCount ?>;

        // Render the pie chart
        const ctx = document.getElementById('quizResultsChart').getContext('2d');
        const quizResultsChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Correct', 'Incorrect', 'Unanswered'],
                datasets: [{
                    label: 'Quiz Results',
                    data: [correctCount, incorrectCount, unansweredCount],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)', // Correct - Green
                        'rgba(255, 99, 132, 0.2)', // Incorrect - Red
                        'rgba(201, 203, 207, 0.2)' // Unanswered - Grey
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(201, 203, 207, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                }
            },
        });
    </script>
</body>

</html>